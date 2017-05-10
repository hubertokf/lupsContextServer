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
        self.core_father = parent


    @rule_action(params = {"email": FIELD_TEXT})
    def send_email(self, email):

        sender = 'teste@teste.com.br'
        receivers = [email]

        message = "Valores fora das condições estipuladas na regra {0}".format(paramters.name_rule)
        subject = "Faixa de valores fora dos padrões"

        #  build the message
        msg            = MIMEMultipart()
        msg['From']    = sender
        msg['To']      = ', '.join(receivers)
        msg['Date']    = formatdate(localtime=True)
        msg['Subject'] = subject
        msg.attach(MIMEText(message))
        try:
            smtpObj = smtplib.SMTP('smtp.gmail.com',587)
            smtpObj.ehlo()
            smtpObj.starttls()
            smtpObj.login(sender,"3123123123121")
            smtpObj.sendmail(sender, receivers, msg.as_string())
            print ("Successfully sent email")
            smtpObj.quit()
        except :
            print ("Error: unable to send email")
            smtpObj.quit()
