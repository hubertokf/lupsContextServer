define (['jquery'], function($){

  var LogicOperators = function(id,set,selectd){

    this.option_any = $('<option>',{text: "ou",
    value: "any"});
    this.option_all = $('<option>',{text: "e",
     value: "all"});
    this.div_row = $('<div>',{class: "row",id: "div_condtions"});
    this.col_operator = $('<div>',{class: "col-md-1 col-md-offset-1"})
    if(set){
      this.select_logic_operator = $('<select>',{class: "form-control select_rules_context operators",id: "logic"+id});
      this.select_logic_operator.append(this.option_all);
      this.select_logic_operator.append(this.option_any);
      this.col_operator.append(this.select_logic_operator);
  }
    //this.div_row.append(this.col_operator);
    $('#Condition'+id).append(this.col_operator);
    if(selectd !== undefined){
      console.log(id,selectd,"#logic"+id);
      $("#logic"+id).val(selectd);
    }
  }


  return LogicOperators;

});
