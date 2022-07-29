import os
import sys
import zipfile


def zip(zipFileName, files):
    zf = zipfile.ZipFile("%s.zip" % ("/var/www/html/uploads/"+zipFileName), "w", zipfile.ZIP_DEFLATED)
    for filePath in files:
        fileName = filePath.split('/')[-1]
        if not os.path.islink(filePath) and os.path.isfile(filePath) :
            zf.write(filePath, fileName)
    zf.close()



if __name__ == "__main__":
    zipFileName = sys.argv[1]
    listFilePath = sys.argv[2]
    f = open(listFilePath, "r")
    txt = f.readline()
    files = txt.split(",")
    zip(zipFileName, files)
    print('done')