from os import listdir
from os.path import isfile, join
import os
import sys

import datetime
import time


filelist = "/var/www/html/filelist"
uploads = "/var/www/html/uploads"


def delFiles(src):
    ms = datetime.datetime.now()
    delTime = time.mktime(ms.timetuple()) - 1 * 3600
    for item in os.scandir(src):
        if item.stat().st_atime <= delTime:
            os.remove(item.path)
        # print(item.name, item.path, item.stat().st_size, item.stat().st_atime, os.path.getctime(item.path))


delFiles(filelist)
delFiles(uploads)