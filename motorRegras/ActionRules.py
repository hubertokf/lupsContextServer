import sys
import os

sys.path.append("")

from business_rules.actions import BaseActions, rule_action
from business_rules.fields import FIELD_NUMERIC,FIELD_SELECT, FIELD_TEXT
from business_rules import run_all
from business_rules.actions import BaseActions, rule_action
from business_rules.fields import FIELD_NUMERIC, FIELD_TEXT
from core.moduleOfRules.ConditionsRules import ConditionsRules
from core.moduleOfRules.Parameters import Parameters
import json
import email
import requests
import logging
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart
from email.utils import formatdate
import smtplib
import core.event_treatment

class ActionRules(BaseActions):
    core_father = None
    def __init__ (self, parameters,parent):
        self.core_father = parent
        self.parameters  = parameters

    @rule_action(params={"uuid_sensor": FIELD_TEXT })
    def publisher(self,uuid_sensor): # ação que ativa o evento de publicação

                object_events = core.event_treatment.Event_Treatment(self.core_father)

                try:
                    data_send_context = {}
                    param                                = {"uuID":uuid_sensor}
                    data_sensors                         = self.core_father.API_access("get", "sensors", model_id=None, data=None, param=param)
                    get_sensor                           = data_sensors.json()
                    id_sensor                            = get_sensor[0]['id']
                    data_send_context['sensor']          = id_sensor # dizer qual é o sensor para adicionar o valor na persistencia
                    data_send_context['event']           = "publisher" #para o tratador de eventos chmar a publicação
                    data_send_context['persistance']     = False # pra dizer que as datas não vem da persistencia

                    if(uuid_sensor in self.parameters.get_dist()): # verifica se o valor do sensor já foi coletado
                        data = self.parameters.get_element_dist(uuid_sensor)
                        data_send_context['value']       = data['value']
                        data_send_context['collectDate'] = data['collectDate']

                    else: # caso o valor do sensor não tenha sido coletado, realiza a coleta
                        collect_data                     = {}
                        collect_data['uuID']             = uuid_sensor
                        collect_data['event']            = "gathering"
                        collect_data['collect_to_rule']  = True
                        uuid                             = {"uuID":collect_data['uuID']}
                        info_gateway                     = self.core_father.API_access("get", "sensors", model_id=None, data=None, param=uuid).json()
                        id_gateway                       = info_gateway[0]['gateway']
                        collect_data['gateway']          = id_gateway
                        collect_data                     = json.dumps(collect_data)
                        info_gateway_and_sensor          = object_events.event(collect_data)
                        data_send_context['value']       = info_gateway_and_sensor['value']
                        data_send_context['collectDate'] = info_gateway_and_sensor['collectDate']

                    object_events.event(data_send_context)

                except Exception as inst:
                    print(type(inst))
                    print(inst.args)
                    raise

    @rule_action(params={"uuid_sensor": FIELD_TEXT })
    def publisher_all(self,uuid_sensor): # ação que ativa o evento de publicação de todos os sensores envolvidos.

                object_events = core.event_treatment.Event_Treatment(self.core_father)
                try:
                    datas_sensor_collect = self.parameters.get_dist()
                    for data_sensor in datas_sensor_collect:
                        data_send_context = {}
                        data_send_context['id_sensor']       = data_sensor["id_sensor"]
                        data_send_context['event']           = "publisher"
                        data_send_context['persistance']     = True # pra dizer que as datas não vem da persistencia
                        datas_sensor_collect["collectDate"]  = data_sensor["collectDate"]
                        datas_sensor_collect["value"]        = data_sensor["value"]
                        object_events.event(data_send_context)
                except Exception as inst: #problema de comunicação

                    print(type(inst))
                    print(inst.args)
                    raise
                       # arguments stored in .args
    @rule_action(params={"info_adicional":FIELD_NUMERIC })
    def gathering(self,info_adicional): # ação que ativa o evento de coleta
        json = '{{"id_sensor": {0}, "event": "{1}", "valor",{2}}}'.format(self.parameters.id,self.parameters.event,self.parameters.value)
        #chamar tratador de evento

    @rule_action(params={"uuid":FIELD_TEXT,"timer":FIELD_TEXT })
    def proceeding(self,uuid,timer): # ação que ativa o evento de atuação
        # package_info_events = {}
        # package_info_events['uuid']  = uuid
        # package_info_events['timer'] = timer
        # package_info_events['event'] = "proceeding"
        # object_events = core.event_treatment.Event_Treatment(self.core_father)
        # object_events.event(package_info_events)
        logging.basicConfig(filename='myapp.log', level=logging.INFO)
        logging.info('Irrigação acionada')


    @rule_action(params = {"email": FIELD_TEXT})
    def test_post_event(self, email):
        # pass
        sender = 'teste@teste.com.br'
        receivers = [email]

        message = "Houve um erro de leitura no sensor{0}.\n Por favor, verifique a situação do sensor assim como a sua comunicação com o gateway".format(self.parameters.id)
        subject = "Problema no sensor {0}".format(self.parameters.id)

        #  build the message
        msg            = MIMEMultipart()
        msg['From']    = sender
        msg['To']      = ', '.join(receivers)
        msg['Date']    = formatdate(localtime=True)
        msg['Subject'] = subject
        msg.attach(MIMEText(message))
        #  print(msg.as_string())
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
        print("okkkkkkkkkkk")

    @rule_action(params = {"ruler": FIELD_TEXT})
    def gathering_error(self,ruler):

        contador = self.parameters.contador - 1
        json = '{{"id_sensor": {0}, "event": "e", "valor":{1}, "contador": {2}}}'.format(self.parameters.id,self.parameters.value,contador)
        object_events = Event_Treatment(self.core_father)
        object_events.event(1,json)

    '''Método de transição para proximo regra, desabilita o conjunto de regra acionadas,bem como regra atual.
       Habilita proxima regra de transição, id's das regras di cinjunto encontranm-se no array rules,
       id da regra atual=> id_current_rule, id da próxima regra=>id_next_rule'''

    @rule_action(params={"rules": FIELD_SELECT,"id_next_rule": FIELD_NUMERIC,"id_current_rule":FIELD_NUMERIC})
    def next_rule(self,rules,id_next_rule,id_current_rule):

        payload = {'status':False}
        r       = self.core_father.API_access("put", "rules", model_id=id_current_rule, data=payload, param=None)
        payload = {'status':True}
        r       = self.core_father.API_access("put", "rules", model_id=id_next_rule, data=payload, param=None)

        for id_rule_set in rules:
            payload = {'status':False}
            r = self.core_father.API_access("put", "rules", model_id=id_rule_set, data=payload, param=None)


    '''Método que desabilita todas as regras, ele só vai setar novamente quando receber um ok'''
    @rule_action
    def failure_transition(self,rules,id_rule,id_current_rule):
#Em construção
                payload = {'status':False}
                r = self.core_father.API_access("put", "rules", model_id=id_current_rule, data=payload, param=None)

                for id_rule_set in rules:
                    payload = {'status':False}
                    r = self.core_father.API_access("put", "rules", model_id=id_rule_set, data=payload, param=None)


    @rule_action(params = {"uuid": FIELD_TEXT,"url": FIELD_TEXT})
    def get_extern_sensor(self,uuid,url):
        #problema do gathring/LJ
        url  = "http://10.0.50.184:8081/sensor={0}".format(uuid)
        r    = requests.get(url)
        #print(r.json())

    @rule_action(params = {"foo": FIELD_TEXT})
    def notify_servers_edge(self,foo):
        # inserir notificação
        pass

# from core.event_treatment import *
from core.gathering import Gathering
