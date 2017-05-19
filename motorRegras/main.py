#!/usr/bin/env python3
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
    rules          = json.load(sys.argv[1]) # recebe a regra e extrai a regra do json
    condiction_satisfied = run_all(rule_list=rule,
                defined_variables=ConditionsRules(json.load),
                defined_actions=ActionRules(json.load),
                stop_on_first_trigger=True
                )
    print(condiction_satisfied)
except Exception as inst:
    print(type(inst))    # the exception instance
    print(inst.args)     # arguments stored in .args
