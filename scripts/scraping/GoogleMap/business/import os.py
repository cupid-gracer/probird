import os
import sys
import csv
# import json
import time
import pprint
import pandas as pd
import datetime
import subprocess
import contextlib
from collections import OrderedDict, namedtuple
from paramiko import SSHClient, AutoAddPolicy
from scp import SCPClient
import dateutil.relativedelta
from bs4 import BeautifulSoup
this_dir = os.path.abspath(os.path.dirname(__file__))
frgx_sdk_dir = os.path.join(this_dir, 'python_sdk')
vendor_dir = os.path.join(this_dir, 'python_sdk', 'vendor')
api_client = os.path.join(this_dir, 'python_sdk', 'ApiClient')
sys.path.append(frgx_sdk_dir)
sys.path.append(vendor_dir)
sys.path.append(api_client)
from FrgxTrackingApiClient import FrgxTrackingApiClient
from email_notify import EmailNotification
from orders import Order
from settings import *
# import mysqldump2csv
# magento api
###########################################
from rauth.service import OAuth1Service
# from rauth.oauth import HmacSha1Signature
from rauth.oauth import PlaintextSignature


class ChicParfums_Mailer():
    def __init__(self):
        self.pp = pprint.PrettyPrinter(depth=6)
        self.dir = os.path.abspath(os.path.dirname(__file__))
        self.environ = os.environ
        self.environ['PYTHONIOENCOING'] = 'utf-8'
        # testing parameters in settings.py:
        # 1)set test_email to None for normal operations or an email (will override *both* sender and receiver)
        # 2)set order_id_override in conjunction with test_email to test a specific order id
        # 3)also set sender_password, smtp_address, smtp_port etc
        ##################################################
        try:
            self.test_email = test_email
        except NameError:
            self.test_email = None
        try:
            self.skip_email = skip_email
        except NameError:
            self.skip_email = None
        try:
            self.fetch_magento_orders = fetch_magento_orders
        except NameError:
            self.fetch_magento_orders = True
        ##################################################

        # DO NOT EDIT
        ##################################################
        if self.test_email is not None:
            try:
                self.recipient_override = self.test_email
            except NameError:
                self.recipient_override = None
            try:
                self.order_id_override = test_order_id
            except NameError:
                self.order_id_override = None
            try:
                self.magento_order_statuses = [status_override]
            except NameError:
                self.magento_order_statuses = ["processing"]
            try:
                self.store_override = store_override
            except NameError:
                self.store_override = None
        else:
            self.recipient_override = None
            self.order_id_override = None
            self.magento_order_statuses = ["processing"]
            self.store_override = None
        ##################################################

        self.francais_store_id = 1
        self.english_store_id = 2
        self.french_store_name = "Français"
        self.english_store_name = "English"
        self.order_status_filter = "processing"
        self.carrier_names = [
            "CanPar",
            "Canada Post"
        ]
        self.carrier_urls = [
            "https://www.canpar.ca/en/track/TrackingAction.do?locale=en&type=2&reference={}&shipper_num=null",
            "http://www.canadapost.ca/cpotools/apps/track/personal/findByTrackNumber?trackingNumber={}&LOCALE=fr&LOCALE2=en"
        ]
        self.magento_url = "https://www.chicparfums.ca"
        # self.soap_path = "api/soap/?wsdl"
        self.soap_path = "api/v2_soap?wsdl=1"
        self.magento_soap_url = "{}/{}".format(self.magento_url, self.soap_path)
        self.magento_soap_username = "2q3guHS@G@k@Axof"
        self.magento_soap_password = "@75joNQcr5hg6twx"
        self.access_token = "0698d65ad6557a6dbc76dfe8ceb65ca3"
        self.access_token_secret = "f2d9a9a8ce5cd2beda5259959e0dc4e1"
        try:
            self.magento_api = magento_api
        except NameError:
            self.magento_api = False
        if self.magento_api:
            self.magento_consumer_key = "06176a761f95ba7aacc3a3f86b3adba7"
            self.magento_consumer_secret = "74a5c384f99bed57a911c5072f02f746"
            self.magento_admin_string = "gutsqc"
            self.rest_app = 'Mailer'
            self.magento = OAuth1Service(
                name=self.rest_app,
                consumer_key=self.magento_consumer_key,
                consumer_secret=self.magento_consumer_secret,
                request_token_url='{}/oauth/initiate'.format(self.magento_url),
                access_token_url='{}/oauth/token'.format(self.magento_url),
                # authorize_url='{}/oauth/authorize'.format(self.magento_url),
                authorize_url='{}/{}/oauth_authorize'.format(self.magento_url, self.magento_admin_string),
                base_url='{}/api/rest/'.format(self.magento_url),
                signature_obj=PlaintextSignature
            )
        else:
            self.chicparfums_username = 'wholesa1'
            self.chicparfums_password = 'jdcN912wp0Rk'
            self.chicparfums_hostname = 'sip1-192.nexcess.net'
            # self.chic_parfums_command = "mysqldump -uwholesa1_chicpar -p'Weasel11!!' wholesa1_chicparf_magento sales_flat_order --where=\"status='processing'\" > /home/wholesa1/desynet_outgoing/sales_flat_order.sql"
            self.chic_parfums_command = "/usr/bin/php /home/wholesa1/chicparfums.ca/export_orders.php"
            self.ssh_command_delay = 10

        self.magento_store_name = "ChicParfums.ca"
        self.magento_views = [self.french_store_name, self.english_store_name]

        self.frangrancex_api_id = "d9a69a0ab8b8"
        self.frangrancex_api_key = "6be84464b4eb1196bda7d773c92bc6c509cae964"
        self.trackingApiClient = FrgxTrackingApiClient(self.frangrancex_api_id, self.frangrancex_api_key)
        if not self.trackingApiClient:
            print("Error authenticating FragranceX API connection! Aborting.")
            exit(1)
        self.sender_name = "Chic Parfums"
        self.email_subject_english = "CHICPARFUMS.CA: Your order #{}"
        self.email_subject_french = "CHICPARFUMS.CA: Votre commande #{}"
        if self.test_email is not None:
            self.smtp_address = test_smtp_address
            self.smtp_port = test_smtp_port
            self.sender_address = self.test_email
            self.sender_username = self.test_email
            self.sender_password = test_password
        else:
            self.smtp_address = prod_smtp_address
            self.smtp_port = prod_smtp_port
            self.sender_address = prod_email
            self.sender_username = prod_email
            self.sender_password = prod_password

        # template vars
        self.store_name = "Chic Parfums"
        # self.logo_img_url = "https://www.chicparfums.ca/skin/frontend/novaworks/bearstore/images/chic.jpg"
        self.logo_img_url = "https://www.chicparfums.ca/media/email/logo/default/logo.jpg"
        self.logo_url = "https://www.chicparfums.ca"
        self.logo_alt = "Chic Parfums"
        self.service_email = "info@chicparfums.ca"
        self.facebook_url = "https://www.facebook.com/chicparfumsCA/"
        self.english_facebook_image_url = "https://www.chicparfums.ca/media/54neqrkoab8pdgx1bhogmjdj2bl.gif"
        self.french_facebook_image_url = "https://www.chicparfums.ca/media/Facebook1_2035.jpg"

        self.php_path = php_path
        self.subprocess_dicts = []

        self.fragx_api = fragx_api
        if not self.fragx_api:
            self.fragx_tracking_list = open(os.path.join(self.dir, 'fragx', 'tracking.csv'), 'r')
            self.reader = csv.DictReader(self.fragx_tracking_list)
        open(os.path.join(self.dir, 'orders.csv'), 'w').close()
        self.order_summary_list = open(os.path.join(self.dir, 'orders.csv'), 'a')

        self.a_month_ago = datetime.datetime.now() + dateutil.relativedelta.relativedelta(months=-2)
        self.a_month_ago = self.a_month_ago.strftime("%Y-%m-%d %H:%M:%S")
        self.today = datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")
        # print(self.a_month_ago)

    def close(self):
        if self.fragx_tracking_list:
            self.fragx_tracking_list.close()
            self.fragx_tracking_list = None

        if self.order_summary_list:
            self.order_summary_list.close()
            self.order_summary_list = None

    def drop_quotes(self, string):
        string = string.replace('"', '')
        string = string.replace("'", "")
        return string

    def parse_fragx_tracking_list(self, order_id):
        # todo, alternative method
        if not bool(BeautifulSoup(self.fragx_tracking_list, "html.parser").find()):
            self.fragx_tracking_list.seek(0)
            tracking_data = None
            for record in self.reader:
                if 'YourOrderID' in record:
                    if record['YourOrderID'] == order_id:
                        # print(record)
                        tracking_data = {
                            'carrier': self.drop_quotes(record['Carrier']),
                            'trackingnumber': record['TrackNo']
                        }
                        tracking_data = namedtuple("TrackingData", tracking_data.keys())(*tracking_data.values())
                        self.fragx_tracking_list.seek(0)
                        return tracking_data
            self.fragx_tracking_list.seek(0)
            return tracking_data
        else:
            print('Error. Corrupt FragranceX portal download detected. Please manually run php fragx/get_fragx_tracking_list.php. Aborting.')
            sys.exit()

    def tracking_email_sent_api(self, data, template):
        # skip updating the local sqllite db if email test mode is active
        # otherwise, it (sqllite db) will need to be manually manipulated to email the customer if a real order was used for testing
        if self.test_email is None:
            if template.startswith("shipment"):
                Order.create(tracking_id=str(data['tracking_id']), order_id=str(data['order_id']))
            elif template.startswith("order"):
                Order.create(tracking_id='', order_id=str(data['order_id']))

        # skip the soap call (shipment/tracking creation in magento) if email test mode is active
        if self.test_email is None and template.startswith("shipment"):
            subprocess_dict = OrderedDict([
                ('order_id', str(data['order_id']).encode('utf-8')),
                ('tracking_id', str(data['tracking_id']).encode('utf-8')),
                ('note', str(data['note']).encode('utf-8')),
                ('carrier_name', str(data['carrier_name']).encode('utf-8'))
            ])
            self.subprocess_dicts.append(subprocess_dict)

    def update_tracking_numbers(self):
        # update magento tracking number via php soap script
        php_script = os.path.join(self.dir, "create_shipment_track.php")
        for d in self.subprocess_dicts:
            payload = [
                self.php_path,
                php_script,
                d['order_id'],
                d['tracking_id'],
                d['note'],
                d['carrier_name'],
                d['carrier_name']
            ]
            subprocess.call(payload, env=self.environ)

    def send_tracking_email(self, elist, template):
        e = EmailNotification(
            self.smtp_address,
            self.sender_name,
            self.sender_address,
            self.sender_username,
            self.sender_password,
            self.smtp_port,
            self.tracking_email_sent_api,
            self.skip_email)
        e.mailbulk(elist, template)

    def get_carrier_url(self, carrier_name):
        carrier_index = self.carrier_names.index(carrier_name)
        return self.carrier_urls[carrier_index]

    # def get_carrier_url(self, carrier_name):
    #     try:
    #         carrier_index = self.carrier_names.index(carrier_name)
    #     except ValueError:
    #         return None
    #     else:
    #         return self.carrier_urls[carrier_index]

    def get_access_token(self):
        # get request token
        (self.request_token, self.request_token_secret) = self.magento.get_request_token(params={'oauth_callback': 'oob'})
        print('request token: {}'.format(self.request_token))
        print('secret token: {}'.format(self.request_token_secret))
        authorize_url = self.magento.get_authorize_url(self.request_token)
        print('Visit this URL in your browser: ' + authorize_url)
        verifier = input('Paste Code from browser: ')

        (self.access_token, self.access_token_secret) = self.magento.get_access_token(
            request_token=self.request_token,
            request_token_secret=self.request_token_secret,
            data={'oauth_verifier': verifier}
        )
        print('Update self.access_token and self.access_token_secret with these values in __init__:')
        print('access token: {}'.format(self.access_token))
        print('token secret: {}'.format(self.access_token_secret))
        exit()

    def get_shipping_title(self, object, key):
        if key in object:
            value = object[key]
            if value is not None:
                value = value.title()
            else:
                value = ''
        else:
            value = ''
        return value

    def format_shipping_address(self, shipping_address_json):
        # 'company': None,
        # 'city': '324424',
        # 'firstname': 'Test',
        # 'telephone': '342424',
        # 'suffix': None,
        # 'street': '3243243',
        # 'region': 'Quebec',
        # 'postcode': '3424',
        # 'middlename': None,
        # 'country_id': 'CA',
        # 'prefix': None,
        # 'lastname': 'User',
        # 'email': 'testuser@chicparfums.ca',
        # 'address_type': 'shipping'

        firstname = self.get_shipping_title(shipping_address_json, 'firstname')
        lastname = self.get_shipping_title(shipping_address_json, 'lastname')
        street = self.get_shipping_title(shipping_address_json, 'street')
        city = self.get_shipping_title(shipping_address_json, 'city')
        region = self.get_shipping_title(shipping_address_json, 'region')
        postcode = self.get_shipping_title(shipping_address_json, 'postcode')
        country_id = self.get_shipping_title(shipping_address_json, 'country_id')
        return "{} {}\n{}\n{} {}\n{}, {}".format(
            firstname,
            lastname,
            street,
            city,
            region,
            postcode,
            country_id
        )

    def force_update_tracking(self):
        self.subprocess_dicts = []
        orders = [
        ]
        tracks = [
        ]
        zipped = zip(orders, tracks)
        for order, track in zipped:
            subprocess_dict = OrderedDict([
                ('order_id', str(order).encode('utf-8')),
                ('tracking_id', str(track).encode('utf-8')),
                ('note', str('').encode('utf-8')),
                ('carrier_name', str('Canada Post').encode('utf-8'))
            ])
            self.subprocess_dicts.append(subprocess_dict)
        print(self.subprocess_dicts)
        if self.subprocess_dicts:
            self.update_tracking_numbers()

    def parse_orders_api(self):
        if self.magento_api:
            token = self.access_token, self.access_token_secret
            session = self.magento.get_session(token=token, signature=None)

        shipping_list_french = []
        shipping_list_english = []
        update_list_french = []
        update_list_english = []
        for view in self.magento_views:
            running = {}
            orders_df = pd.DataFrame()
            if self.magento_api:
                current = {}
                previous = {'initialize': 'supercalafragialisticexpialidocious'}
                page = 1
                while True:
                    print('Processing page {}...'.format(page))
                    params = dict(
                        limit=100,
                        page=page,
                        order='created_at',
                        dir='asc'
                    )
                    headers = {'Content-Type': 'application/json', 'Accept': 'application/json'}
                    r = session.get(
                        # "orders?filter[0][attribute]=created_at&filter[0][from]={}".format(self.a_month_ago) + "&filter[1][attribute]=store_name&filter[1][in]=Main%20Website\n{}\n{}".format(self.magento_store_name, view),
                        # multiple filters seem not to work properly, so differentiate the store later by checking the field
                        "orders?filter[0][attribute]=created_at&filter[0][from]={}".format(self.a_month_ago) + "&filter[0][to]={}".format(self.today),
                        params=params,
                        header_auth=True,
                        headers=headers
                    )
                    current = r.json()
                    if current != previous:
                        # print(current)
                        previous = current.copy()
                        running.update(current.copy())
                        page += 1
                    else:
                        running.update(current.copy())
                        break
                    # if page == 3:
                    #     break
            # print(running)
            # with open('orders.json'.format(view), 'w') as orders_json:
            #     orders_json.write(json.dumps(running))
            # exit()
            else:
                if self.fetch_magento_orders:
                    with SSHClient() as ssh:
                        ssh.load_host_keys(os.path.expanduser('~/.ssh/known_hosts'))
                        ssh.set_missing_host_key_policy(AutoAddPolicy())
                        ssh.connect(self.chicparfums_hostname,
                                    username=self.chicparfums_username,
                                    password=self.chicparfums_password,
                                    allow_agent=False,
                                    look_for_keys=False)
                        (ssh_stdin, ssh_stdout, ssh_stderr) = ssh.exec_command(self.chic_parfums_command)
                        # print(ssh_stdout.read())
                        time.sleep(self.ssh_command_delay)
                        with SCPClient(ssh.get_transport()) as scp:
                            scp.get('/home/wholesa1/chicparfums.ca/desynet_outgoing/magento_orders.csv', os.path.join(self.dir, 'chicparfums_incoming'))
                # mysqldump2csv.main(os.path.join(self.dir, 'desynet_incoming', 'sales_flat_order.sql'), self.sales_flat_order_header)
                orders_df = pd.read_csv(os.path.join(self.dir, 'chicparfums_incoming', 'magento_orders.csv'), index_col=False)
                orders_df.fillna('', inplace=True)

            for record in running if self.magento_api else orders_df.iterrows():
                if self.magento_api:
                    order_id = ''
                    if 'error' in running[record]:
                        print('Error! Skipping...')
                        print(running[record])
                        continue
                    if 'store_name' in running[record]:
                        store_name = running[record]['store_name']
                    if 'increment_id' in running[record]:
                        order_id = running[record]['increment_id']
                    if self.order_id_override and self.order_id_override != str(order_id):
                        continue
                    order_status = ''
                    if 'status' in running[record]:
                        order_status = running[record]['status']
                    # if order_id != "145002550":
                    #     continue
                    # order_state = "{}:{}\n".format(order_id, order_status)
                    # self.order_summary_list.write(order_state)

                    customer_firstname = ''
                    customer_email = ''
                    shipping_address = ''
                    shipping_description = ''
                    customer_email = ''
                    if 'addresses' in running[record]:
                        for address in running[record]['addresses']:
                            if 'address_type' in address:
                                if address['address_type'] == 'shipping':
                                    if 'firstname' in running[record]['addresses'][1]:
                                        customer_firstname = running[record]['addresses'][1]['firstname']
                                    if 'email' in running[record]['addresses'][1]:
                                        customer_email = running[record]['addresses'][1]['email']
                                    shipping_address = self.format_shipping_address(address)
                                    break
                    if 'shipping_description' in running[record]:
                        shipping_description = running[record]['shipping_description']
                    order_comment = ''
                    if 'order_comments' in running[record]:
                        for comment in running[record]['order_comments']:
                            if 'is_customer_notified' in comment and 'comment' in comment:
                                if comment['is_customer_notified']:
                                    if comment['comment'] is not None:
                                        if order_comment == '':
                                            order_comment = "{}".format(comment['comment'])
                                        else:
                                            order_comment += "\n{}".format(comment['comment'])
                else:
                    # print(record)
                    store_name = record[1]['store_name']
                    order_id = record[1]['order_id']
                    if self.order_id_override and self.order_id_override != str(order_id):
                        continue
                    order_status = record[1]['status']
                    order_comment = record[1]['customer_note']
                    customer_firstname = record[1]['customer_firstname']
                    customer_lastname = record[1]['customer_lastname']
                    customer_email = record[1]['customer_email']
                    shipping_description = record[1]['shipping_description']
                    address = {}
                    address['firstname'] = str(record[1]['firstname']).title()
                    address['lastname'] = str(record[1]['lastname']).title()
                    address['street'] = str(record[1]['street']).title()
                    address['city'] = str(record[1]['city']).title()
                    address['region'] = str(record[1]['region']).title()
                    address['postcode'] = str(record[1]['postcode']).upper()
                    address['country_id'] = str(record[1]['country_id']).title()
                    # self.pp.pprint(address)
                    # shipping_address_id = record[1]['shipping_address_id']
                    shipping_address = self.format_shipping_address(address)

                # print("store_name: {}".format(store_name))
                # print("order_id: {}".format(order_id))
                # print("order_status: {}".format(order_status))
                # print("order_comment: {}".format(order_comment))
                # print("customer_firstname: {}".format(customer_firstname))
                # print("customer_lastname: {}".format(customer_lastname))
                # print("customer_email: {}".format(customer_email))
                # print("shipping_description: {}".format(shipping_description))
                # # print("shipping_address_id: {}".format(shipping_address_id))
                # print("shipping_address: {}".format(shipping_address))

                if order_status in self.magento_order_statuses:
                    print('Processing order id: {}, Status: {})'.format(order_id, order_status))
                    if not self.fragx_api:
                        tracking_data = self.parse_fragx_tracking_list(str(order_id))
                    else:
                        tracking_data = self.trackingApiClient.get_tracking_information(str(order_id))
                    if tracking_data is not None:
                        print(tracking_data)
                        if self.recipient_override:
                            this_email = self.recipient_override
                        else:
                            this_email = customer_email
                        if order_comment is None or order_comment == "None":
                            order_comment = ""
                        if this_email is not None:
                            if self.store_override is not None:
                                store_name = self.store_override
                            template_data = {
                                "email": this_email,
                                "name": self.sender_name,
                                "data": {
                                    "logo_img_url": self.logo_img_url,
                                    "logo_url": self.logo_url,
                                    "logo_alt": self.logo_alt,
                                    "dear": str(customer_firstname).title(),
                                    "order_id": str(order_id),
                                    "note": str(order_comment),
                                    "store_name": self.magento_store_name,
                                    "service_email": self.service_email,
                                    "facebook_url": self.facebook_url,
                                    "facebook_image_url": self.english_facebook_image_url if "English" in store_name else self.french_facebook_image_url,
                                }
                            }
                            # if view == self.french_store_name:
                            if self.french_store_name in store_name or 'Fran\u00e7ais' in store_name:
                                template_data["subject"] = self.email_subject_french
                                if tracking_data.carrier in self.carrier_names:
                                    if self.skip_email:
                                        template_data['data']["tracking_id"] = str(tracking_data.trackingnumber)
                                        template_data['data']["shipping_address"] = str(shipping_address)
                                        template_data['data']["shipping_description"] = str(shipping_description)
                                        template_data['data']["carrier_url"] = self.get_carrier_url(str(tracking_data.carrier)).format(str(tracking_data.trackingnumber))
                                        template_data['data']["carrier_name"] = str(tracking_data.carrier)
                                        shipping_list_french.append(template_data)
                                    else:
                                        try:
                                            Order.select().where(Order.order_id == str(order_id)).where(Order.tracking_id == str(tracking_data.trackingnumber)).get()
                                        except Exception:
                                            # the order/tracking number pair doesn't already exist in the database - so proceed
                                            try:
                                                Order.select().where(Order.order_id == "").where(Order.tracking_id == str(tracking_data.trackingnumber)).get()
                                            except Exception:
                                                # nor does the tracking number alone already exist in the database - so proceed
                                                template_data['data']["tracking_id"] = str(tracking_data.trackingnumber)
                                                template_data['data']["shipping_address"] = str(shipping_address)
                                                template_data['data']["shipping_description"] = str(shipping_description)
                                                template_data['data']["carrier_url"] = self.get_carrier_url(str(tracking_data.carrier)).format(str(tracking_data.trackingnumber))
                                                template_data['data']["carrier_name"] = str(tracking_data.carrier)
                                                shipping_list_french.append(template_data)
                                            else:
                                                print("Shipping/Tracking email has already been issued for order #{}".format(order_id))
                                        else:
                                            print("Shipping/Tracking email has already been issued for order #{}".format(order_id))
                                else:
                                    if self.skip_email:
                                        update_list_french.append(template_data)
                                    else:
                                        try:
                                            Order.select().where(Order.order_id == str(order_id)).where(Order.tracking_id == "").get()
                                        except Exception:
                                            # the order number alone doesn't already exist in the database
                                            try:
                                                Order.select().where(Order.order_id == str(order_id)).where(Order.tracking_id == str(tracking_data.trackingnumber)).get()
                                            except Exception:
                                                # nor does the order/tracking number pair already exist in the database - so proceed
                                                update_list_french.append(template_data)
                                            else:
                                                print("Order Confirmation email has already been issued for order #{}".format(order_id))
                                        else:
                                            print("Order Confirmation email has already been issued for order #{}".format(order_id))
                            # elif view == self.english_store_name:
                            elif self.english_store_name in store_name:
                                template_data["subject"] = self.email_subject_english
                                if tracking_data.carrier in self.carrier_names:
                                    if self.skip_email:
                                        template_data['data']["tracking_id"] = str(tracking_data.trackingnumber)
                                        template_data['data']["shipping_address"] = str(shipping_address)
                                        template_data['data']["shipping_description"] = str(shipping_description)
                                        template_data['data']["carrier_url"] = self.get_carrier_url(str(tracking_data.carrier)).format(str(tracking_data.trackingnumber))
                                        template_data['data']["carrier_name"] = str(tracking_data.carrier)
                                        shipping_list_english.append(template_data)
                                    else:
                                        try:
                                            Order.select().where(Order.order_id == str(order_id)).where(Order.tracking_id == str(tracking_data.trackingnumber)).get()
                                        except Exception:
                                            # the order/tracking number pair doesn't already exist in the database so proceed
                                            try:
                                                Order.select().where(Order.order_id == "").where(Order.tracking_id == str(tracking_data.trackingnumber)).get()
                                            except Exception:
                                                # nor does the tracking number alone already exist in the database so proceed
                                                template_data['data']["tracking_id"] = str(tracking_data.trackingnumber)
                                                template_data['data']["shipping_address"] = str(shipping_address)
                                                template_data['data']["shipping_description"] = str(shipping_description)
                                                template_data['data']["carrier_url"] = self.get_carrier_url(str(tracking_data.carrier)).format(str(tracking_data.trackingnumber))
                                                template_data['data']["carrier_name"] = str(tracking_data.carrier)
                                                shipping_list_english.append(template_data)
                                            else:
                                                print("Shipping/Tracking email has already been issued for order #{}".format(order_id))
                                        else:
                                            print("Shipping/Tracking email has already been issued for order #{}".format(order_id))
                                else:
                                    if self.skip_email:
                                        update_list_english.append(template_data)
                                    else:
                                        try:
                                            Order.select().where(Order.order_id == str(order_id)).where(Order.tracking_id == "").get()
                                        except Exception:
                                            # the order number alone doesn't already exist in the database
                                            try:
                                                Order.select().where(Order.order_id == str(order_id)).where(Order.tracking_id == str(tracking_data.trackingnumber)).get()
                                            except Exception:
                                                # nor does the order/tracking number pair already exist in the database - so proceed
                                                update_list_english.append(template_data)
                                            else:
                                                print("Order Confirmation email has already been issued for order #{}".format(order_id))
                                        else:
                                            print("Order Confirmation email has already been issued for order #{}".format(order_id))
                    else:
                        print("Order {} not found!".format(str(order_id)))
            # this is required since we are no longer looping through store views
            break

        if self.trackingApiClient.timer is not None:
            self.trackingApiClient.timer.cancel()
        if self.magento_api:
            session.close()
        print("English order confirmations: #{}".format(len(update_list_english)))
        print("English shipping confirmations: #{}".format(len(shipping_list_english)))
        print("French order confirmations: #{}".format(len(update_list_french)))
        print("French shipping confirmations: #{}".format(len(shipping_list_french)))
        if True:
            if self.skip_email or len(shipping_list_french) > 0:
                self.send_tracking_email(shipping_list_french, "shipment_update-Canada-Post-tracking-update-FR")
            if self.skip_email or len(shipping_list_english) > 0:
                self.send_tracking_email(shipping_list_english, "shipment_update-Canada-Post-tracking-update-EN")
            if self.skip_email or len(update_list_french) > 0:
                self.send_tracking_email(update_list_french, "order_update_tracking_us-FR")
            if self.skip_email or len(update_list_english) > 0:
                self.send_tracking_email(update_list_english, "order_update_tracking_us-EN")
            if self.subprocess_dicts:
                self.update_tracking_numbers()
        return


if __name__ == '__main__':
    with contextlib.closing(ChicParfums_Mailer()) as cp:
        cp.parse_orders_api()
        # cp.force_update_tracking()
