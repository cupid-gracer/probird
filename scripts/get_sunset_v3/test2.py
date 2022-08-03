import sun
from datetime import datetime
import astral
from datetime import timedelta
import math

def getDiffSeconds(start, end):
    d1 = datetime.strptime(start, "%Y-%m-%d %H:%M:%S")
    d2 = datetime.strptime(end, "%Y-%m-%d %H:%M:%S")
    delta = abs((d2 - d1).seconds)
    return delta

FT_PER_METRE = 3.2808399


input_date = input("Enter Date:- ")
now = datetime.now()
# paramétrage de la localisation , nom du parc , pays, coordonné
parc_location = astral.Location(info=("Capespigne", "France", 43.732924, 3.251173, "GMT", 157/FT_PER_METRE))
sunrise_hour, sunset_hour = sun.day(now , input_date)

print("sunrise_hour: " +sunrise_hour)
print("sunset_hour: " +sunset_hour)

diff = getDiffSeconds(sunrise_hour, sunset_hour)
print("diff: " + str(diff))
print("expected:", math.ceil(diff/16))