from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.by import By
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


inputurl = str(input("please input search key: "))
inputNumber = 1
inputNumber = int(input("please input start number ( 1 ~  ): "))

# self.driver = webdriver.Chrome("./chromedriver.exe")
options = webdriver.ChromeOptions()
# options.add_argument("--headless")
options.add_argument("--start-maximized")
driver = webdriver.Chrome(chrome_options=options)


def gotoURL(url):
    startNumber = inputNumber
    driver.get(url)
    # WebDriverWait(driver, 20).until(
    #     EC.presence_of_element_located((By.CLASS_NAME, 'hdtb-mitem')))
    resultList = []
    map_button = ""
    tags = driver.find_elements_by_xpath("//div[@class='hdtb-mitem hdtb-imb']")
    for tag in tags:
        href = tag.find_element_by_xpath("./a").get_attribute('href')
        if "map" in href:
            map_button = tag.find_element_by_xpath("./a")
            break
    map_button.click()
    time.sleep(5)
    k = 0
    
    # if exist the start number, goto start point to startNumber
    startRow = (startNumber - 1)%20
    startPage = int((startNumber-1)/20)
    page = 0
    j = startRow

    while page < startPage:
        try:
            button = driver.find_element_by_class_name("gm2-caption")
            nextbutton = button.find_elements_by_tag_name('button')
            nextbutton[1].click()
            page = page + 1
            time.sleep(5)
        except:
            break

    resultFile = "tempWithoutEmail.txt"
    with open(resultFile, "a", encoding="utf8", newline='') as outputFile:
        writer = csv.writer(outputFile, delimiter='\t')
        if startNumber == 1:
            writer.writerow(["Title", "WebSite", "Address", "Phone"])
        while True:
            try:
                list = driver.find_elements_by_xpath("//div[@class='section-result']")  #select Section Result
                for tmp in list:
                    list = driver.find_elements_by_xpath("//div[@class='section-result']")
                    tmp = list[j]
                    j = j + 1
                    tmp.click()
                    time.sleep(5)
                    title = ""
                    address = ""
                    phone = ""
                    website = ""
                    # driver.find_elements_by_xpath("//button[contains(@data-item-id, 'phone:tel')]")
                    f = True
                    print(startNumber)
                    startNumber = startNumber + 1
                    try:
                        title = driver.find_element_by_class_name("section-hero-header-title-title").text
                        website_copyButton = driver.find_element_by_xpath("//button[@data-tooltip='Copy website']")
                        website_copyButton.click()
                        website = pyperclip.paste()
                        phone = driver.find_element_by_xpath("//button[contains(@data-item-id, 'phone:tel')]").text
                        address = driver.find_element_by_xpath("//button[@data-item-id='address']").text
                       
                    except:
                        print("No address!")
                        f = False
                    if f:
                        resultList.append([])
                        resultList[k].append(title)
                        resultList[k].append(website)
                        resultList[k].append(address)
                        resultList[k].append(phone)
                        writer.writerow(resultList[k])
                        print(title)
                        print(website)
                        print(phone)
                        print(address)
                        k = k + 1
                    print('-------------------------------------------------------------')

                    back = driver.find_element_by_class_name("section-back-to-list-button")
                    back.click()
                    time.sleep(5)

                    if j >= len(list):
                        break
                # if k > 3:
                #     break
                j = 0
                try:
                    button = driver.find_element_by_class_name("gm2-caption")
                    nextbutton = button.find_elements_by_tag_name('button')
                    nextbutton[1].click()
                    time.sleep(5)
                except:
                    break
            except:
                print("Can't get list! Please enter other search key!")
                return
        outputFile.close()
      
#     for list in resultList:
#         list.append(getEmail(list[1]))
#         print(list)
#         print(k)

#     saveCSV(resultList)

# def getEmail(siteUrl):
#     try:
#         driver.get(siteUrl)
#         html = driver.page_source
#         email = re.findall(r'([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z_-]+)', html)[-1]
#         s = email.split('.')[-1]
#         if s in ['js', 'png', 'gif', 'jpg', 'jpeg', 'mp3', 'svg']:
#             email = "No"
#         print(s)
#         return email
#     except:
#         return "No"

# def saveCSV(list):
#     bar = progressbar.ProgressBar(maxval=100, \
#     widgets=[progressbar.Bar('=', '[', ']'), ' ', progressbar.Percentage()])
#     resultFile = "repairPhoneResult.txt"
#     bar.start()
#     i = 0
#     numsOfLines = len(list)
#     with open(resultFile, "w", encoding="utf8", newline='') as outputFile:
#         writer = csv.writer(outputFile, delimiter='\t')
#         writer.writerow(["Title", "Site URL", "Phone", "Address", "Email"])
       
#         print("Data Processing...")
#         bar.start()
#         for line in list:
#             writer.writerow(line)
#             bar.update(i/numsOfLines * 100)
#             i += 1
#         bar.finish()
        
#         outputFile.close()



gotoURL("https://www.google.com/search?q=%s" % inputurl)