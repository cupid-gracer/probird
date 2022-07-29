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



inputurl = str(input("please input search key: "))
# self.driver = webdriver.Chrome("./chromedriver.exe")
options = webdriver.ChromeOptions()
options.add_argument("--headless")
options.add_argument("--start-maximized")
driver = webdriver.Chrome(chrome_options=options)


def gotoURL(url):
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
    time.sleep(10)
    k = 0

    resultFile = "temp.txt"
    with open(resultFile, "w", encoding="utf8", newline='') as outputFile:
        writer = csv.writer(outputFile, delimiter='\t')
        writer.writerow(["Title", "Site URL", "Phone"])
       
        while True:
            try:
                list = driver.find_elements_by_xpath("//div[@class='section-result']")  #select Section Result
                for tmp in list:
                    title = tmp.find_element_by_xpath(".//h3[@class='section-result-title']/span").get_attribute("textContent")
                    phone = tmp.find_element_by_class_name("section-result-phone-number").get_attribute("textContent")
                    try:
                        pageurl = tmp.find_element_by_xpath(".//a[@class='section-result-action section-result-action-wide']").get_attribute("href")
                        resultList.append([])
                        resultList[k].append(title)
                        resultList[k].append(pageurl)
                        resultList[k].append(phone)
                        writer.writerow(resultList[k])
                        k = k + 1
                        if k > 100:
                            break
                    except:
                        pass
                if k > 100:
                    break
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
      
    k = 0
    # print(resultList)
#     for list in resultList:
#         list.append(getEmail(list[1]))
#         print(list)
#     saveCSV(resultList)

# def getEmail(siteUrl):
#     try:
#         driver.get(siteUrl)
#         html = driver.page_source
#         email = re.findall(r'([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z_-]+)', html)[-1]
#         return email
#     except:
#         try:
#             # WebDriverWait(driver, 20).until(EC.presence_of_element_located(driver.find_element_by_xpath("//*[contains(translate(text(), \"ABCDEFGHIJKLMNOPQRSTUVWXYZ\",\"abcdefghijklmnopqrstuvwxyz\"), 'contact')]")))
#             time.sleep(10)
#             contact = driver.find_element_by_xpath("//*[contains(translate(text(), \"ABCDEFGHIJKLMNOPQRSTUVWXYZ\",\"abcdefghijklmnopqrstuvwxyz\"), 'contact')]")
#             # contact.click()
#             driver.execute_script("arguments[0].click();", contact)
#             html = driver.page_source
#             email = re.findall(r'([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z_-]+)', html)[-1]
#             return email
#         except:
#             try:
#                 driver.get(siteUrl)
#                 contact = driver.find_element_by_xpath("//*[contains(text(), 'contact us')]")
#                 contact.click()
#                 html = driver.page_source
#                 email = re.findall(r'([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z_-]+)', html)[-1]
#                 return email
#             except:
#                 return "No"


        
# def saveCSV(list):
#     bar = progressbar.ProgressBar(maxval=100, \
#     widgets=[progressbar.Bar('=', '[', ']'), ' ', progressbar.Percentage()])
#     resultFile = "result.csv"
#     bar.start()
#     i = 0
#     numsOfLines = len(list)
#     with open(resultFile, "w", encoding="utf8", newline='') as outputFile:
#         writer = csv.writer(outputFile, delimiter='\t')
#         writer.writerow(["Title", "Site URL", "Phone", "Email"])
       
#         print("Data Processing...")
#         bar.start()
#         for line in list:
#             writer.writerow([line[0], line[1], line[2], line[3]])
#             bar.update(i/numsOfLines * 100)
#             i += 1
#         bar.finish()
        
#         outputFile.close()

# def saveCSVOneByOne():


# print(getEmail("http://www.mkmci.com/"))
# print(getEmail("http://www.emsconsultla.com/"))

gotoURL("https://www.google.com/search?q=%s" % inputurl)
# getEmail("http://www.australiagsmworld.com.au/")