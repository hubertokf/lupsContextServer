define (["context/ConditionsRules"], function(ConditionsRules){

  var SelectCondition = function (select,data_condition,selected,compare_selected){
      // console.log(data_condition);

      this.select_construct = $('<select>',{
        class: "form-control select_rules_context conditions",
        id: "condition"+select,
      });

      this.select_compare = $('<select>',{class: "form-control select_rules_context compare",id: "compare"+select})
      var opt = data_condition;
      this.select = new ConditionsRules(this.select_construct,opt,selected);
      //cria div referente ao seletor de condição,
      this.generateRow(this.select_construct,4,select);
      //cria div referente ao seletor de comparação
      this.generateRow(this.select_compare,3,select);

      if(selected !== undefined){ // se for umas string, seta o valor
        console.log(selected)
        var type = $("#condition"+select).val(selected).find(':selected').data("type");

        switch (type){
            case "string":
              option_string("compare"+select,compare_selected)
              break;

            case "number":
              option_number("compare"+select,compare_selected);
              break;

            default:
              break;
        }
      }
      this.set_events();

  }

  SelectCondition.prototype.generateRow = function (select_condition,size,select) {

    var col = $('<div>',{class: "col-md-"+size});
    col.append(select_condition);
    $('#Condition'+select).append(col)

  }

  SelectCondition.prototype.set_events = function(){

    var id_operator = this.select_compare.attr("id");
    this.select_construct.change(function(ev){

        var type = $(this).find(':selected').data("type")
            switch (type){
                case "string":
                  option_string(id_operator,undefined)
                  break;
                case "number":
                  option_number(id_operator,undefined);
                  break;

                default:
                  break;
            }
      });



    }
var option_string = function(id_operator,compare_selected){
  select_compare = $("#"+id_operator)
  select_compare.empty();
  var  information = [{text:"Inicia  com",value:"starts_with"},
                      {text:"Finaliza com",value:"ends_with"},
                      {text:"Contém",value:"contains"},
                      {text:"Expressão Regular",value:"matches_regex"},
                      {text:"Igual",value:"equal_to"}];

  for (i = 0; i <information.length; i++){
          var div_opt = $('<option>',information[i])
          select_compare.append(div_opt);
  }
  if(compare_selected!==undefined){
          // console.log("chegou aqui");
    select_compare.val(compare_selected);
  }
}

var option_number = function (id_operator,compare_selected){
    // ver se edite é indefinido
    select_compare = $("#"+id_operator);
    // console.log(select_compare,compare_selected);
    select_compare.empty();
    // select_compare.
    var  information = [{text:"Maior que",value:"greater_than"},
                        {text:"Maior ou igual",value:"greater_than_or_equal_to"},
                        {text:"Menor que",value:"less_than"},
                        {text:"Menor ou igual",value:"less_than_or_equal_to"},
                        {text:"Igual",value:"equal_to"}];

    for (i = 0; i <information.length; i++){
            var div_opt = $('<option>',information[i])
            select_compare.append(div_opt);
    }
    if(compare_selected!==undefined){
      select_compare.val(compare_selected);
    }
  }

    return SelectCondition;



});
