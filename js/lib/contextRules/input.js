define(["jquery"], function($){

  var Inputs = function(id,selected){

      this.inputs =$('<input>',{type : "text", class:   "form-control  inputs",id: "inp"+id});
      this.div_column = $('<div>',{class: "col-md-2"});
      this.input_form = $('<form>', {class: "form-inline"});
      this.div = $('<div>',{class: "form-group select_rules_context"})
      this.div.append(this.inputs)
      this.input_form.append(this.div)
      this.div_column.append(this.input_form)
      $('#Condition'+id).append(this.div_column);
      $("#inp"+id).val(selected);

  }

  return Inputs
});
