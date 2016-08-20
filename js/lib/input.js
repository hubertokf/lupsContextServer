define(["jquery"], function($){

  var Inputs = function(id){

      this.inputs =$('<input>',{type : "text", class:   "form-control  inputs"});
      this.div_column = $('<div>',{class: "col-md-2"});
      this.input_form = $('<form>', {class: "form-inline"});
      this.div = $('<div>',{class: "form-group select_rules_context"})
      this.div.append(this.inputs)
      this.input_form.append(this.div)
      this.div_column.append(this.input_form)
      $('#Condition'+id).append(this.div_column);

  }

  return Inputs
});
