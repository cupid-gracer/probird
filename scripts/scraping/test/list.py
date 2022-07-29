from os import listdir
from os.path import isfile, join
import os
import sys


if __name__ == "__main__":
    fp = sys.argv[1]
    # fp = input("Enter file Path:- ")
    try:
        if not os.path.islink(fp):
            total_size = os.path.getsize(fp)
    except Exception as e:
        print(e)
    print(total_size)


# def get_size(start_path = 'D:\\02_development'):
#     total_size = 0
#     for dirpath, dirnames, filenames in os.walk(start_path):
#         for f in filenames:
#             fp = os.path.join(dirpath, f)
#             # skip if it is symbolic link
#             try:
#             	if not os.path.islink(fp):
#                     total_size += os.path.getsize(fp)
#             except Exception as e:
#                 print(e)
            

#     return total_size

# print(get_size(), 'bytes')


# mypath = 'E:\\'
# for f in listdir(mypath):
# 	print(f)
# onlyfiles = [f for f in listdir(mypath) if isfile(join(mypath, f))]
# print(onlyfiles)