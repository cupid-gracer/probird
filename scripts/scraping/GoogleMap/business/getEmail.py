from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException
from selenium.webdriver.support.ui import WebDriverWait
from selenium import webdriver
# from xgoogle.search import GoogleSearch, SearchError
import time
import os
import sys
import codecs
import re
import csv
import progressbar
import pyperclip


inputFileName = str(input("please input file name: "))
outputFileName = str(input("please output file name: "))
inputStart = int(input("please input start number ( 1 ~ ): "))
# self.driver = webdriver.Chrome("./chromedriver.exe")
options = webdriver.ChromeOptions()
# options.add_argument("--headless")
options.add_argument("--start-maximized")
driver = webdriver.Chrome(chrome_options=options)


def start():
    startNumber =  inputStart
    with open(inputFileName, "r", encoding="utf8") as inputFile:
        reader = csv.DictReader(inputFile, dialect="excel-tab")
        if startNumber == 1:
            if  os.path.exists(outputFileName):
                os.remove(outputFileName)
        with open(outputFileName, "a", encoding="utf8", newline='') as outputFile:
            writer = csv.writer(outputFile, delimiter='\t')
            headers = ["Title", "WebSite", "Address", "Phone", "Email"]
            writer = csv.DictWriter(outputFile, delimiter='\t', fieldnames=headers)

            if startNumber == 1:
                writer.writeheader()  # file doesn't exist yet, write a header
                
            i = 1
            for line in reader:
                if i < startNumber:
                    pass
                email = getEmail(line['WebSite'])
                if email == "No":
                    continue
                writer.writerow([line['Title'],line['WebSite'],line['Address'],line['Phone'], email])
                print(i)
                print(line['WebSite'])
                print(email)
                print("=========================")
                i = i + 1
            outputFile.close()
        inputFile.close()


def getEmail(siteUrl):
    try:
        driver.get(siteUrl)
        html = driver.find_element_by_tag_name("body").get_attribute('innerHTML')
        email = re.findall(r'([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z_-]+)', html)
        result = emailProcess(email)
        if len(email) == 0 or result == "No":
            return extractEmail(siteUrl)
        return result
    except:
        return extractEmail(siteUrl)


def extractEmail(siteUrl):
    try:
        contact = driver.find_element_by_css_selector('a[href*=contact]')
        driver.execute_script("arguments[0].click();", contact)
        time.sleep(5)
        html = driver.find_element_by_tag_name("body").get_attribute('innerHTML')
        email = re.findall(r'([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z_-]+)', html)
        if len(email) == 0:
            return "No"
        return emailProcess(email)
    except:
        return "No"


def emailProcess(list):
    email = ""
    f = True
    e = []
    for row in list:
        if row.strip() == "" or "example" in row or "email" in row:
            pass

        s = row.split('.')[-1]
        if s.lower() not in ['js', 'png', 'gif', 'jpg', 'jpeg', 'mp3', 'svg', 'ico', 'io']:
            e.append(row)
    if len(e) > 0:
        e = set(e)
    i = 0
    for ee in e:
        f = False
        if i == 0:
            email = ee
        else:
            email = email + " \n " + ee
        i = i + 1

    if f:
        email = "No"
    return email


start()