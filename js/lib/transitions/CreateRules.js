define([], function(){

  var path        = window.location.pathname.split('/');
  var CreateRules = function() {
    this.data_information = {};
  }

 CreateRules.prototype.construct_rule = function (obj_html) {

    this.data_information["name"]   = obj_html["name_rule"];
    this.data_information["status"] = obj_html["status_trigger"];
    this.data_information["sensor"] = obj_html["sensor_trigger"];

    var rule       = [];
    var basic_rule = {};
    var condition  = {};
    var array_any  = [];

    array_any.push(obj_html["condition_status"]);
    array_any.push(obj_html["condition_time"]);

    condition["any"]         = array_any;
    basic_rule["conditions"] = condition;
    basic_rule["actions"]    = obj_html["action_next_windows"];

    rule.push(basic_rule);

    basic_rule = {};
    condition  = {};
    array_all  = [];

    obj_html["condition_status"]["operator"] =  this.invert_operator(obj_html["condition_status"]["operator"]);
    obj_html["condition_time"]["operator"]   = "equal_to";

    array_all.push(obj_html["condition_status"]);
    array_all.push(obj_html["condition_time"]);

    condition["all"]         = array_all;
    basic_rule["conditions"] = condition;
    basic_rule["actions"]    = obj_html["action_next_windows"];

    rule.push(basic_rule);
    this.data_information["rule"] = rule;
    console.log(JSON.stringify(this.data_information));
 };

 CreateRules.prototype.invert_operator = function (operator) {

    var get_opositor = function (operator, element) {
       return element.op = operator
    }

    var array_operator = [{op: "less_than", opositor: "greater_than"},{op: "greater_than", opositor: "less_than"},{op: "less_than_or_equal_to", opositor: "greater_than_or_equal_to"},{op: "greater_than_or_equal_to", opositor: "less_than_or_equal_to"}]
    var new_operator = array_operator.find(get_opositor.bind(this, operator));

    return new_operator.opositor;

 };

 CreateRules.prototype.send_rule = function () {
   $.ajax({
     type:"POST",
     data: this.data_information,
     dataType: 'json',
     url:window.base_url+"cadastros/"+path[3]+"/gravar?has_ajax=s",
     complete: function (response) {
        window.location.replace(window.base_url+"cadastros/"+path[3]+"?msg="+response['responseText']);
         }
   });
 };
 return CreateRules;
});
