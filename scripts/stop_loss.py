import mysql.connector
import pandas as pd
import json
from datetime import datetime
import math

def getDataFromDB(cursor, date, type = 'probird'):
    sql = ''
    if type == 'probird':
        sql = "SELECT * FROM probird_orders WHERE DATE(Time_Stamp) = '" + date + "' GROUP BY Wind_Turbine, Time_Stamp"
    elif type == 'wind_turbine':
        sql = "SELECT * FROM wind_turbine_data1 WHERE DATE(Time_Stamp) = '" + date + "' GROUP BY Wind_Turbine_ID, Time_Stamp"
    cursor.execute(sql)
    records = cursor.fetchall()
    existData = True if len(records) > 0 else False

    result = []
    if type == 'probird':
        wind_turbine_id = -1
        _data = []
        for item in records:
            if item[3] == wind_turbine_id:
                _data.append([str(item[1])[:19], item[2]])
            else:
                if len(_data) > 0:
                    result.append({'wind_turbine_id': wind_turbine_id, 'data': _data})
                    _data = []
                wind_turbine_id = item[3]
                _data.append([str(item[1])[:19], item[2]])
        _data = sorted(_data, key=lambda x: datetime.strptime(x[0], '%Y-%m-%d %H:%M:%S'), reverse=False)
        print(_data)
        result.append({'wind_turbine_id': wind_turbine_id, 'data': _data})
    elif type == 'wind_turbine':
        wind_turbine_id = -1
        _data = []
        for item in records:
            if item[2] == wind_turbine_id:
                _data.append([str(item[1])[:19], float(item[3]), float(item[4])])
            else:
                if len(_data) > 0:
                    result.append({'wind_turbine_id': wind_turbine_id, 'data': _data})
                    _data = []
                wind_turbine_id = item[2]
                _data.append([str(item[1])[:19], float(item[3]), float(item[4])])
        result.append({'wind_turbine_id': wind_turbine_id, 'data': _data})
    # print(json.dumps(result, indent=4, sort_keys=True))
    return result, existData


def genDateRange(start, end, freq):
    return pd.date_range(start, end, freq=freq)


def getDiffSeconds(start, end):
    d1 = datetime.strptime(start, "%Y-%m-%d %H:%M:%S")
    d2 = datetime.strptime(end, "%Y-%m-%d %H:%M:%S")
    delta = abs((d2 - d1).seconds)
    return delta


def getDowntime(probird_list):
    stop_number = []
    uptime = []
    downtime = []
    stop_list = []
    
    for probird_list_by_id in probird_list:
        is_first_stop = True
        start = ''
        end = ''
        _downtime = 0
        _stop_number = 0
        _stop_list = []
        wind_turbine_id = probird_list_by_id['wind_turbine_id']
        for item in probird_list_by_id['data']:
            if item[1] != 0:
                if is_first_stop:
                    start = item[0]
                    is_first_stop = False
            else:
                if not is_first_stop:
                    end = item[0]
                    is_first_stop = True
                    _stop_number = _stop_number + 1
                    _stop_list.append([start, end])
                    _downtime = _downtime + getDiffSeconds(start, end)
        if not is_first_stop:
            _stop_number = _stop_number + 1
            _stop_list.append([start, probird_list_by_id['data'][-1][0]])
            _downtime = _downtime + getDiffSeconds(start, probird_list_by_id['data'][-1][0])
        stop_list.append([wind_turbine_id, _stop_list])
        stop_number.append([wind_turbine_id, _stop_number])
        downtime.append([wind_turbine_id, _downtime])
        delta = getDiffSeconds(probird_list_by_id['data'][0][0], probird_list_by_id['data'][-1][0]) if len(probird_list_by_id['data']) > 0 else 0
        uptime.append([wind_turbine_id, delta])
    return stop_list, stop_number, uptime, downtime


def calPowerAmount(wind_speed, type = 'S'):
    if wind_speed > 0:
        increment = 3600 if type == 'S' else 60 if type == 'M' else 1
        production = 3346.35 / (1+math.exp(5.60355-0.68957 * wind_speed))
        production = production / increment
    else:
        production = 0
    return production


def getLossPower(stop_list, data_wind_turbine):
    """
        summary:
            to calculate loss power using stop range data which was got using 'porbird_orders' table
        params:
            stop_list           =>  contains stop range as per each wind tubine
                format:             [[wind_turbine_id, [[start_time, end_time],...]],...]
            data_wind_turbine   =>  contains wind tubine data  
                format:             [{'wind_turbine_id':x, data:[[time_stamp, wind_speed, RPM],...]},...]
        return:
            format: [[wind_turbine_id, loss_power],...]
    """
    loss_power = []
    for stop_item in stop_list:
        wind_turbine_id = stop_item[0]
        _d_wind_turbine = next((x['data'] for x in data_wind_turbine if x['wind_turbine_id'] == wind_turbine_id), [])
        _loss_power = 0
        if len(_d_wind_turbine) > 0:
            _d_wind_turbine = _d_wind_turbine
            for _st_item in stop_item[1]:
                start = _st_item[0]
                end = _st_item[1]
                stop_range = genDateRange(start, end, 'S')
        
                for stop_point in stop_range[:-2]:
                    stop_point = str(stop_point)[:19]
                    _d_wind_turbine_item = next((x for x in _d_wind_turbine if x[0] == stop_point), [0,0,0])
                    # _d_wind_turbine_item = _d_wind_turbine_item[0] if len(_d_wind_turbine_item) > 0 else [0,0,0]
                    _loss_power = _loss_power +  calPowerAmount(_d_wind_turbine_item[1], 'S')
            loss_power.append([wind_turbine_id, _loss_power])
        else:
            loss_power.append([wind_turbine_id, 0])
    return loss_power


def processingTurbineData(data_wind_turbine):
    turbine_data = []
    for _d_wind_turbine in data_wind_turbine:
        wind_turbine_id = _d_wind_turbine['wind_turbine_id']
        data = _d_wind_turbine['data']
        _power = 0
        _wind_speed = 0
        _rpm = 0
        for _d in data:
            _w = _d[1]
            _r = _d[2]
            _power = _power + calPowerAmount(_w, 'S')
            _wind_speed = _wind_speed + _w
            _rpm = _rpm + _r
        _wind_speed = _wind_speed/len(data)
        _rpm = _rpm/len(data)
        turbine_data.append([wind_turbine_id, _power, _wind_speed, _rpm])
    return turbine_data

try:
    # DB config
    connection = mysql.connector.connect(host='localhost', database='capespigne_probird', user='root', password='')
    cursor = connection.cursor()

    # Date Generate
    dates = genDateRange('2022-04-02', '2022-04-02', 'd')
    # Loop in dates
    for date in dates:
        date = str(date)[:10]
        print('------------   ' + date + '  ------------')
        print('\tfetching data from db...')
        data_probird_order, probird_exist = getDataFromDB(cursor, date, 'probird')
        print(data_probird_order)
        # data_wind_turbine, wind_turbine_exist = getDataFromDB(cursor, date, 'wind_turbine')
        if not wind_turbine_exist:
            continue

        print('\tcalculating...')
        stop_list, stop_number, uptime, downtime = getDowntime(data_probird_order)
        print(stop_list)
        break
        print('\tstop_list, stop_number, uptime, downtime  done.')
        loss_power = getLossPower(stop_list, data_wind_turbine)
        print('\tloss_power done.')
        turbine_data = processingTurbineData(data_wind_turbine)
        print('\tturbine_data done.')
        print('\tstoring result into db...')
        for turbine_item in turbine_data:
            wind_turbine_id = turbine_item[0]
            expect_power_amount = turbine_item[1]
            avg_wind_speed = turbine_item[2]
            avg_rpm = turbine_item[3]
            loss_power_amount = next((x[1] for x in loss_power if x[0] == wind_turbine_id),0)
            _uptime = next((x[1] for x in uptime if x[0] == wind_turbine_id),0)
            _downtime = next((x[1] for x in downtime if x[0] == wind_turbine_id),0)
            _stop_number = next((x[1] for x in stop_number if x[0] == wind_turbine_id),0)

            sql = "INSERT INTO statistics (wind_turbine_id, date, expect_power_amount, loss_power_amount, uptime, downtime, stop_number, avg_wind_speed, avg_rpm) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)"
            val = (wind_turbine_id, date, expect_power_amount, loss_power_amount, _uptime, _downtime, _stop_number, avg_wind_speed, avg_rpm)
            cursor.execute(sql, val)
        connection.commit()
        
except mysql.connector.Error as e:
    print("Error reading data from MySQL table", e)
finally:
    if connection.is_connected():
        connection.close()
        cursor.close()
        print("MySQL connection is closed")
