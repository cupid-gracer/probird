import datetime
from datetime import timedelta
import time
from get_sunset_v3 import astral
# import astral
import pytz

FT_PER_METRE = 3.2808399
location = astral.Location(info=("Capespigne", "France", 43.732924, 3.251173, "GMT", 157/FT_PER_METRE))

def day(now, date):
    # compute surrise and sunset for today
    '''    sun_info = Bassum.sun(date=datetime.date.today())
    sunrise = sun_info["sunrise"]
    sunrise = sunrise.replace(tzinfo=None)
    sunset = sun_info["sunset"]
    sunset = sunset.replace(tzinfo=None)
    night = 0

    # modification of 18th september
    now_hour = timedelta(hours= now.hour, minutes= now.minute, seconds= now.second)#datetime.time(now.hour,now.minute,now.second)
    sunset_hour = timedelta(hours= sunset.hour, minutes= sunset.minute, seconds= sunset.second)#datetime.time(sunset.hour,sunset.minute,sunset.second)
    sunrise_hour = timedelta(hours= sunrise.hour, minutes= sunrise.minute, seconds= sunrise.second)#datetime.time(sunrise.hour,sunrise.minute,sunrise.second)

    # Test sunset and sunrise
    if (now_hour-hour_adjust)>sunset_hour or (now_hour-hour_adjust)<sunrise_hour:
        night = 1
        print ('night')
    else:
        print ('day')
        night = 0

    hour_adjust = timedelta(hours=2,minutes= 1)
    print('now_hour2')
    print(now_hour)
    print('sunset_hour2')
    print(sunset_hour)
    print('sunrise_hour2')
    print(sunrise_hour)
    print('night2')
    print(night)
    print('now_hour-hour_adjust')
    print(now_hour-hour_adjust)
    print('now_hour+hour_adjust')
    print(now_hour+hour_adjust)
    return now_hour,sunset_hour,sunrise_hour,night
    '''

    '''paris = pytz.timezone('Europe/Paris')
    paris_time = datetime.datetime.fromtimestamp(time.time(),tz=paris)
    paris_time_naive = paris_time.replace(tzinfo=None)
    utc_time = datetime.datetime.utcfromtimestamp(time.time())
    print("paris_time ",paris_time_naive)
    print("utc_time ",utc_time)
    raw_UTC_offset = paris_time_naive - utc_time'''


    raw_UTC_offset = datetime.datetime.fromtimestamp(time.time()) - datetime.datetime.utcfromtimestamp(time.time())

    # print("raw_UTC_offset ",raw_UTC_offset)
    #UTC_offset = timedelta(hours=int(raw_UTC_offset.seconds // 3600))
    #print("UTC_offset ", UTC_offset)
    # config for Theshold mitigation
    stop_after_sunset = timedelta(minutes=10)  # (hours = 1, minutes = 30)
    stop_before_sunrise = timedelta(minutes=10)  # (hours = 1, minutes = 30)


    sun_info = location.sun(date=datetime.datetime.strptime(date, "%Y-%m-%d"))

    sunrise = sun_info["sunrise"]
    sunrise = sunrise.replace(tzinfo=None)
    sunrise = sunrise + raw_UTC_offset
    sunset = sun_info["sunset"]
    sunset = sunset.replace(tzinfo=None)
    sunset = sunset + raw_UTC_offset
    night = 0

    # modification of 18th september
    now_hour = timedelta(hours=now.hour, minutes=now.minute, seconds=now.second)  # datetime.time(now.hour,now.minute,now.second)
    #sunset_hour = timedelta(hours=sunset.hour, minutes=sunset.minute, seconds=sunset.second)  # datetime.time(sunset.hour,sunset.minute,sunset.second)
    #sunrise_hour = timedelta(hours=sunrise.hour, minutes=sunrise.minute, seconds=sunrise.second)  # datetime.time(sunrise.hour,sunrise.minute,sunrise.second)

    compensated_sunset = sunset + stop_after_sunset
    compensated_sunrise = sunrise - stop_before_sunrise
    compensated_sunset_hour = timedelta(hours=compensated_sunset.hour, minutes=compensated_sunset.minute, seconds=compensated_sunset.second)  # datetime.time(sunset.hour,sunset.minute,sunset.second)
    compensated_sunrise_hour = timedelta(hours=compensated_sunrise.hour, minutes=compensated_sunrise.minute, seconds=compensated_sunrise.second)  # datetime.time(sunrise.hour,sunrise.minute,sunrise.second)


    # print('Now', now)
    # print('Now_hour', now_hour)
    # print('sunrise = ', sunrise, 'compensated sunrise = ', compensated_sunrise_hour)
    # print('sunset = ', sunset, 'compensated sunset = ', compensated_sunset_hour)

    # Test sunset and sunrise
    if  (compensated_sunrise_hour < now_hour < compensated_sunset_hour):
        # print('day')
        night = 0
    else:
        night = 1
        # print('night')

    # return now_hour, compensated_sunset_hour, compensated_sunrise_hour, night
    return str(sunrise)[:19], str(sunset)[:19]



