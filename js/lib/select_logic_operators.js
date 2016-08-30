define (['jquery'], function($){

  var LogicOperators = function(id,set){

    this.option_any = $('<option>',{text: "ou",
    value: "any"});
    this.option_all = $('<option>',{text: "e",
     value: "all"});
    this.div_row = $('<div>',{class: "row",id: "div_condtions"});
    this.col_operator = $('<div>',{class: "col-md-1 col-md-offset-1"})
    if(set){
      this.select_logic_operator = $('<select>',{class: "form-control select_rules_context operators"});
      this.select_logic_operator.append(this.option_all);
      this.select_logic_operator.append(this.option_any);
      this.col_operator.append(this.select_logic_operator);
  }
    //this.div_row.append(this.col_operator);
    $('#Condition'+id).append(this.col_operator);
  }

  return LogicOperators;

});
