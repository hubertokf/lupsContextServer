import sys
import os

sys.path.append("")

from business_rules.actions import BaseActions, rule_action
from business_rules.fields import FIELD_NUMERIC,FIELD_SELECT, FIELD_TEXT
from business_rules import run_all
from business_rules.actions import BaseActions, rule_action
from business_rules.fields import FIELD_NUMERIC, FIELD_TEXT
import json
import email
import requests
import logging
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart
from email.utils import formatdate
import smtplib

class ActionRules(BaseActions):
    def __init__ (self, parameters):
        self.name = parameters
        headers = {'Content-type': 'application/json', 'X-API-KEY': 'cfb281929c3574091ad2a7cf80274421e6a87c59'}
        url = "http://localhost/{0}/api/configuracoes".format(os.path.relpath(".","../"))
        r = requests.get(url, headers=headers)
        initial_list = json.loads(r.json())
        self.configs = dict((item['name'], item) for item in initial_list)

    @rule_action(params = {"email": FIELD_TEXT})
    def send_email(self, email):

        sender = self.configs['email_from']['value']
        receivers = [email]

        message = "Valores fora das condições estipuladas na regra {0}".format(self.name)
        subject = "Faixa de valores fora dos padrões"

        #  build the message
        msg            = MIMEMultipart()
        msg['From']    = sender
        msg['To']      = ', '.join(receivers)
        msg['Date']    = formatdate(localtime=True)
        msg['Subject'] = subject
        msg.attach(MIMEText(message))
        try:
            smtpObj = smtplib.SMTP(self.configs['email_host']['value'],self.configs['email_port']['value'])
            smtpObj.ehlo()
            smtpObj.starttls()
            smtpObj.login(self.configs['email_user']['value'],self.configs['email_pass']['value'])
            smtpObj.sendmail(sender, receivers, msg.as_string())
            print ("Successfully sent email")
            smtpObj.quit()
        except :
            print ("Error: unable to send email")
