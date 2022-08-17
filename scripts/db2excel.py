import pandas as pd
import mysql.connector
import os
import sys
import xlsxwriter
from os import listdir
from os.path import isfile, join

def getDataFromDB(cursor, start, end, where_in):
    sql = ''
    sql = "SELECT Time_stamp, Wind_Turbine_ID, Wind_Speed, RPM, Status, Expected_Status, Sub_Status, Temperature, Rain, Visibility FROM `wind_turbine_data` WHERE `Time_Stamp` between '" + start + "' AND '" + end +"' AND `Wind_Turbine_ID` IN(" + where_in + ") GROUP BY Time_stamp, Wind_Turbine_ID;"
    cursor.execute(sql)
    records = cursor.fetchall()
    existData = True if len(records) > 0 else False
    header = ['Time Stamp', 'WT (Wind Turbine ID)', 'Wind Speed', 'RPM', 'Status',  'Expected Status', 'Sub Status',  'Temperature', 'Rain', 'Visibility']
    return records, header, existData




try:
    # DB config
    # connection = mysql.connector.connect(host='localhost', database='capespigne_probird', user='root', password='')
    connection = mysql.connector.connect(host='localhost', port=3306, database='capespigne_probird', user='sol', password='6eu21pt7')
    cursor = connection.cursor()

    start = sys.argv[1]
    end = sys.argv[2]
    where_in = sys.argv[3]
    file_name = sys.argv[4]

    file_path = '/var/www/html/uploads/'+file_name + '.xlsx'
    if not os.path.islink(file_path) and os.path.isfile(file_path) :
        print('yes')
        exit()
    # records, header, existData = getDataFromDB(cursor, '2022-04-01 15:09:00', '2022-04-01 15:10:00', "'5','6','7'")
    records, header, existData = getDataFromDB(cursor, start, end, where_in)
    if not existData:
        print('no')
        exit()

    df = pd.DataFrame(records,columns=header)
    writer = pd.ExcelWriter(file_path, engine='xlsxwriter')
    df.to_excel(writer, sheet_name='ProBird-RecordsExcel',  header=True,  index=False)
    workbook = writer.book
    workbook.set_properties({'author': 'PROBIRD', 'title':'ProBird-RecordsExcel', 'subject':'ProBird-RecordsExcel', 'description':'ProBird-RecordsExcel', 'keywords':'ProBird-RecordsExcel', 'category':'ProBird-RecordsExcel'})
    writer.save()

    print('yes')

except mysql.connector.Error as e:
    print("error", e)
finally:
    if connection.is_connected():
        connection.close()
        cursor.close()





