# -*- coding: utf-8 -*-
from business_rules.variables import BaseVariables, numeric_rule_variable, boolean_rule_variable
import requests
import json
import datetime
import psycopg2
import math
import core.event_treatment
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

        '''Método responsável por retorna o valor coletado do sensor'''
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
        headers = {}
        try:
            get_sensor_data = requests.get(''.format(),headers = headers)

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
