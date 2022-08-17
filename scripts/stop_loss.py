
import mysql.connector
import pandas as pd
import json
from datetime import datetime
import math
from get_sunset_v3 import sun
import numpy as np

capture_time = 16 # The time to capture image each wind turbine

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
        records = sorted(records, key=lambda x: x[3], reverse=False)
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
        result.append({'wind_turbine_id': wind_turbine_id, 'data': _data})
    elif type == 'wind_turbine':
        wind_turbine_id = -1
        _data = []
        records = sorted(records, key=lambda x: x[2], reverse=False)
        for item in records:
            if item[2] == wind_turbine_id:
                _data.append([str(item[1])[:19], float(item[3]), float(item[4])])
            else:
                if len(_data) > 0:
                    result.append({'wind_turbine_id': wind_turbine_id, 'data': _data})
                    _data = []
                wind_turbine_id = item[2]
                _data.append([str(item[1])[:19], float(item[3]), float(item[4])])
        _data = sorted(_data, key=lambda x: datetime.strptime(x[0], '%Y-%m-%d %H:%M:%S'), reverse=False)
        result.append({'wind_turbine_id': wind_turbine_id, 'data': _data})
    # print(json.dumps(result, indent=4, sort_keys=True))
    return result, existData


def genDateRange(start, end, freq):
    return pd.date_range(start, end, freq=freq)


def getDiffSeconds(start, end):
    start = str(start)
    end = str(end)
    d1 = datetime.strptime(start, "%Y-%m-%d %H:%M:%S")
    d2 = datetime.strptime(end, "%Y-%m-%d %H:%M:%S")
    # delta = abs((d2 - d1).seconds)
    delta = (d2 - d1).seconds
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


def processingImageNumber(date, wt_cams):
    sunrise, sunset = sun.day(datetime.now(), date)

    sql = "SELECT Time_Stamp FROM medias WHERE DATE(Time_Stamp) = '" + date + "' ORDER BY `ID` ASC LIMIT 1;"
    cursor.execute(sql)
    _r = cursor.fetchall()
    if len(_r) > 0:
        start_time = _r[0][0]
    else:
        start_time = sunrise

    sql = "SELECT Time_Stamp FROM medias WHERE DATE(Time_Stamp) = '" + date + "' ORDER BY `ID` DESC LIMIT 1;"
    cursor.execute(sql)
    _r = cursor.fetchall()
    if len(_r) > 0:
        end_time = _r[0][0]
    else:
        end_time = sunset

    
    start_time = start_time if getDiffSeconds(start_time, sunrise) > 0 else sunrise
    end_time = end_time if getDiffSeconds(end_time, sunset) < 0 else sunset
    day_time = getDiffSeconds(start_time, end_time)
    expect_number_each_cam = math.ceil(day_time/capture_time)


    sql = "SELECT count(*) as img_number, WT_pack_ID FROM medias  WHERE DATE(Time_Stamp) = '" + date + "' AND Type='Picture' GROUP BY WT_pack_ID"
    cursor.execute(sql)
    medias = cursor.fetchall()
    
    sql = "SELECT count(*) as video_number, WT_pack_ID FROM medias  WHERE DATE(Time_Stamp) = '" + date + "' AND Type='Video' GROUP BY WT_pack_ID"
    cursor.execute(sql)
    videos = cursor.fetchall()
    
    result = []

    for wt_cam in wt_cams:
        wt_id = wt_cam[0]
        cam_number = len(wt_cam[1])
        expected_img_number = expect_number_each_cam * cam_number
        img_number = 0
        video_number = 0
        for wt_pack_id in wt_cam[1]:
            img_number = img_number + next((x[0] for x in medias if x[1] == wt_pack_id),0)
            video_number = video_number + next((x[0] for x in videos if x[1] == wt_pack_id),0)
        result.append([wt_id, expected_img_number, img_number, video_number])
    return result


def getRelationWTPackAndWT():
    sql = "SELECT * FROM wt_in_wind_turbine_pack"
    cursor.execute(sql)
    records = cursor.fetchall()
    result = []
    wt_id = -1
    _r = []
    records = sorted(records, key = lambda x: x[2], reverse=False)
    for row in records:
        if wt_id == row[2]:
            _r.append(row[1])
        else:
            if not wt_id == -1:
                result.append([wt_id, _r])
                _r = []
            _r.append(row[1])
            wt_id = row[2]
    result.append([wt_id, _r])
    return result


def processingRowNumber(date):
    sql = "SELECT Time_Stamp, Wind_Turbine_ID FROM wind_turbine_data1 WHERE DATE(Time_Stamp) = '" + date +"' GROUP BY Time_Stamp, Wind_Turbine_ID ORDER BY `ID` ASC;"
    cursor.execute(sql)
    rows = cursor.fetchall()
    sunrise, sunset = sun.day(datetime.now(), date)
    if len(rows) > 0:
        start_time = rows[0][0]
        end_time = rows[-1][0]
    else:
        start_time = sunrise
        end_time = sunset
    start_time = start_time if getDiffSeconds(start_time, sunrise) > 0 else sunrise
    end_time = end_time if getDiffSeconds(end_time, sunset) < 0 else sunset
    expect_row_number = getDiffSeconds(start_time, end_time)
    
    list_wt = np.array(rows)
    list_wt = list_wt[:, 1]
    # wt_ids = set(list_wt)
    # wt_ids = sorted(wt_ids, key=lambda x: x, reverse=False)

    (unique, counts) = np.unique(list_wt, return_counts=True)
    frequencies = np.asarray((unique, counts)).T

    return frequencies, expect_row_number

try:

    
    # DB config
    connection = mysql.connector.connect(host='localhost', database='capespigne_probird', user='root', password='')
    # connection = mysql.connector.connect(host='localhost', port=3306, database='capespigne_probird', user='sol', password='6eu21pt7')
    cursor = connection.cursor()
    
    

    # Date Generate
    dates = genDateRange('2022-04-01', '2022-06-30', 'd')

    # Get relations between WT pack and WT
    wt_cams = getRelationWTPackAndWT()

    # Loop in dates
    for date in dates:
        date = str(date)[:10]
        print('------------   ' + date + '  ------------')
        print('\tfetching data from db...')
        data_probird_order, probird_exist = getDataFromDB(cursor, date, 'probird')
        data_wind_turbine, wind_turbine_exist = getDataFromDB(cursor, date, 'wind_turbine')
        if not wind_turbine_exist:
            print('\tno data skiped...')
            continue

        print('\tcalculating...')
        stop_list, stop_number, uptime, downtime = getDowntime(data_probird_order)
        print('\tstop_list, stop_number, uptime, downtime  done.')
        loss_power = getLossPower(stop_list, data_wind_turbine)
        print('\tloss_power done.')
        turbine_data = processingTurbineData(data_wind_turbine)
        print('\tturbine_data done.')
        img_numbers = processingImageNumber(date, wt_cams)
        print('\timage number done.')
        row_numbers, expect_row_number = processingRowNumber(date)
        print('\trow number done.')

        print('\tstoring result into db...')
        for turbine_item in turbine_data:
            wind_turbine_id = turbine_item[0]
            expect_power_amount = turbine_item[1]
            avg_wind_speed = turbine_item[2]
            avg_rpm = turbine_item[3]
            loss_power_amount = next((x[1] for x in loss_power if x[0] == wind_turbine_id),0)
            # _uptime = next((x[1] for x in uptime if x[0] == wind_turbine_id),0)
            _uptime = 24 * 3600
            _downtime = next((x[1] for x in downtime if x[0] == wind_turbine_id),0)
            _stop_number = next((x[1] for x in stop_number if x[0] == wind_turbine_id),0)
            _img = next((x for x in img_numbers if x[0] == wind_turbine_id),0)
            expected_img_number = _img[1]
            img_number = _img[2]
            video_number = _img[3]
            _row_number = next((x for x in row_numbers if x[0] == wind_turbine_id),0)
            _row_number = _row_number[1]

            sql = "INSERT INTO statistics (wind_turbine_id, date, expect_power_amount, loss_power_amount, uptime, downtime, stop_number, avg_wind_speed, avg_rpm, expected_img_number, img_number, expect_wt_data_number, wt_data_number, detection_number) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
            val = (wind_turbine_id, date, expect_power_amount, loss_power_amount, _uptime, _downtime, _stop_number, avg_wind_speed, avg_rpm, expected_img_number, img_number, expect_row_number, _row_number, video_number)
            cursor.execute(sql, val)

        connection.commit()
        
except mysql.connector.Error as e:
    print("Error reading data from MySQL table", e)
finally:
    if connection.is_connected():
        connection.close()
        cursor.close()
        print("MySQL connection is closed")
