#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import traceback
try:
    from business_rules import run_all
    from business_rules.actions import BaseActions, rule_action
    from business_rules.fields import FIELD_NUMERIC, FIELD_TEXT
    from ActionRules import ActionRules
    from ConditionsRules import ConditionsRules
    # from Parameters import Parameters
    import json
    import sys
    obj_parameters = sys.argv[2] # recebe o nome da regra
    newstr = sys.argv[1].replace("\\", "")
    rules          = json.loads(newstr) # recebe a regra e extrai a regra do json
    condiction_satisfied = run_all(rule_list=rules,
                defined_variables=ConditionsRules(obj_parameters),
                defined_actions=ActionRules(obj_parameters),
                stop_on_first_trigger=True
                )
    print(condiction_satisfied)
except Exception as inst:
    # raise
    for i in traceback.format_exc().splitlines():
        print(i)
    print(type(inst))    # the exception instance
    # print(inst.args)     # arguments stored in .args
