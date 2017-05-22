# -*- coding: utf-8 -*-
from business_rules.variables import BaseVariables, numeric_rule_variable, boolean_rule_variable
import requests
import json
import datetime
import psycopg2
import math
# import core.event_treatment
class ConditionsRules(BaseVariables):

    def __init__ (self, parameters):

        self.parameters = parameters
        # self.headers ={'Authorization':'token %s' % "9517048ac92b9f9b5c7857e988580a66ba5d5061"} # este token sera coletado na base de parametros do bd de borda

    @numeric_rule_variable
    def getNumber(self,a):

        self.parameters.set_i(a)
        return 9

    @numeric_rule_variable
    def get_value_sensor(self,params):

        '''Método responsável por retornar o valor coletado do sensor'''
        try:
            params_data = json.loads(params) #recebe o json com a informação sobre o uuID do sensor
            conn        = psycopg2.connect("dbname='contextServer' user='postgres' host='localhost' password='batata'")
            cur         = conn.cursor()
            r           = """SELECT valorcoletado from publicacoes as p where p.sensor_id in (SELECT s.sensor_id from sensores as s where uuid = '{0}')""".format(params_data['sensor'])
            cur.execute(r)
            rows   = cur.fetchall()
            value  = rows[len(rows)-1] #pega o último valor lido
            return float(value[0]) # Força o resultado ser float
        except:
            return None
        ''' Abaixo quando  API para uuid estiver funcionando '''
        params_data = json.loads(params) #recebe o json com a informação sobre o uuID do sensor
        # headers     = {'Content-type': 'application/json', 'X-API-KEY': 'cfb281929c3574091ad2a7cf80274421e6a87c59'}
        # try:
        #     sensor_data  = requests.get('http://localhost/lupsContextServer/api/sensores/uuid/{0}'.format(params_data['sensor']),headers = headers)
        #     sensor_data  = json.loads(get_sensor_data.json())
        #     publish_data = requests.get(''.format(get_sensor_data['sensor_id']),headers = headers)
        #     publish_data = json.loads(publish_data.jsom())
        #     index = len(publish_data) - 1
        #     return publish_data[index]['value']
        # except:
        #     return None

    @numeric_rule_variable
    def diff_values_sensor(self,params):

        '''Método responsável por retorna o valor coletado do sensor'''
        try:
            params_data = json.loads(params)
            conn        = psycopg2.connect("dbname='contextServer' user='postgres' host='localhost' password='batata'")
            cur         = conn.cursor()
            r           = """SELECT valorcoletado from publicacoes as p where p.sensor_id in (SELECT s.sensor_id from sensores as s where uuid = '{0}')""".format(params_data['sensor'])
            cur.execute(r)
            rows            = cur.fetchall()
            current_value   = float(rows[len(rows)-1])
            preceding_value = float(rows[len(rows)-2])
            return float(math.fabs(current_value - preceding_value))
        except:
            return None
