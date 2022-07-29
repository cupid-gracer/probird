import requests
import random
import string
from random import choice
import re, csv
from time import sleep, time
from random import uniform, randint
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import NoSuchElementException
from selenium.webdriver.support.ui import Select

options = webdriver.ChromeOptions()
options.add_argument("--start-maximized")
# options.add_argument("--headless")
driver = webdriver.Chrome('chromedriver.exe', options=options)

pageurl = 'https://raffle.bstn.com/nike-dunk-low-sp-university-red-/'
apikey = '87f3268438ad434ab57844defaae466f'
sitekey = '03196e24-ce02-40fc-aa86-4d6130e1c97a'
first_token = ''

email = 'test4@test.com'
instagram_name = 'test4'
first_name = 'test4'
last_name = 'test4'
street = 'test4'
street_no = '33'
address2 = 'test42'
zip = '12365'
city = 'test4'

def get_first_token():
	global first_token
	url = 'https://2captcha.com/in.php?key=' + apikey + '&method=hcaptcha&sitekey=' + sitekey + '&pageurl=' + pageurl
	resp = requests.get(url)
	print('*******************' + '\n')
	print(resp.text + '\n')

	if resp.text[0:2] != 'OK':
		quit('Service error. Error code:' + resp.text)

	captcha_id = resp.text[3:]
	print(resp.text[3:] + '\n')

	fetch_url = "https://2captcha.com/res.php?key=" + apikey + "&action=get&id=" + captcha_id
	for i in range(1, 20):
		sleep(6) # wait 6 sec.
		resp = requests.get(fetch_url)
		if resp.text[0:2] == 'OK':
			break

	print('^^^^^^^^^^^^^^^^^^^^' + '\n')
	print(resp.text + '\n')
	first_token = resp.text[3:]
	print(resp.text[3:] + '\n')

driver.get(pageurl)

sleep(1)
mainWin = driver.current_window_handle  

# move the driver to the first iFrame 
driver.switch_to_frame(driver.find_elements_by_tag_name("iframe")[0])

CheckBox = WebDriverWait(driver, 20).until(
        EC.presence_of_element_located((By.CLASS_NAME ,"checkbox-container"))
        ) 
sleep(1)
CheckBox.click()
sleep(1)

driver.switch_to_window(mainWin)
WebDriverWait(driver, 20).until(EC.presence_of_element_located((By.TAG_NAME ,"textarea")))

get_first_token()
print (first_token + '\n')
driver.execute_script("document.getElementsByTagName('textarea')[0].value='" + first_token + "';")
driver.execute_script("document.getElementsByTagName('textarea')[1].value='" + first_token + "';")
sleep(1)

textarea1 = driver.find_elements_by_tag_name("textarea")[0]
textarea2 = driver.find_elements_by_tag_name("textarea")[1]
print('--------------' + '\n')
print(textarea1.get_attribute('value') + '\n')
print('--------------' + '\n')
print(textarea2.get_attribute('value') + '\n')


driver.execute_script("document.forms['challenge-form'].submit();")
sleep(1)


inputs = driver.find_elements_by_tag_name('input')
print(len(inputs))

for i in range(0, len(inputs)):
    print(inputs[i].get_attribute('placeholder'))
    if inputs[i].get_attribute('placeholder') == 'Email Address':
        inputs[i].send_keys(email)

    if inputs[i].get_attribute('placeholder') == 'Instagram Name':
        inputs[i].send_keys(instagram_name)
    
    if inputs[i].get_attribute('placeholder') == 'First Name':
        inputs[i].send_keys(first_name)
    
    if inputs[i].get_attribute('placeholder') == 'Last Name':
        inputs[i].send_keys(last_name)

    if inputs[i].get_attribute('placeholder') == 'Street':
        inputs[i].send_keys(street)

    if inputs[i].get_attribute('placeholder') == 'Street No.':
        inputs[i].send_keys(street_no)

    if inputs[i].get_attribute('placeholder') == 'Address Second Line':
        inputs[i].send_keys(address2)

    if inputs[i].get_attribute('placeholder') == 'ZIP':
        inputs[i].send_keys(zip)

    if inputs[i].get_attribute('placeholder') == 'City':
        inputs[i].send_keys(city)

check1 = driver.find_element_by_id('checkPrivacy')
driver.execute_script("arguments[0].click();", check1)
sleep(1)
check2 = driver.find_element_by_id('checkNewsletter')
driver.execute_script("arguments[0].click();", check2)
sleep(1)

selects = driver.find_elements_by_tag_name('select')
select1 = Select(selects[0])
select1.select_by_value('41')
select2 = Select(selects[1])
select2.select_by_value('1')
select3 = Select(selects[2])
select3.select_by_value('9')
select4 = Select(selects[3])
select4.select_by_value('male')
select5 = Select(selects[4])
select5.select_by_value('GB')

with open('size.txt', 'w') as sz:
    sizes = selects[0].find_elements_by_tag_name('option')
    for i in range(1, len(sizes)):
        print(sizes[i].text)
        sz.write(sizes[i].text + '\n')

btn = driver.find_element_by_tag_name('button')
driver.execute_script("arguments[0].click();", btn)
sleep(5)