from os import listdir
from os.path import isfile, join
import os
import sys


def get_size(paths):
    total_size = 0
    for fp in paths:
        try:
            if not os.path.islink(fp) and os.path.isfile(fp) :
                total_size += os.path.getsize(fp)
        except Exception as e:
            errors = 0
                    

    return total_size


if __name__ == "__main__":
    filepath = sys.argv[1]
    f = open(filepath, "r")
    txt = f.readline()
    paths = txt.split(",")
    print(get_size(paths))