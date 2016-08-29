define(["jquery","bootbox"],function ($,bootbox) {

  var CreateRule = function() {

      this.compose_rule;
      this.ruler;
      this.condition = {};
      this.send_informations = {}
      this.action = {};

  }

  CreateRule.prototype.create_rule = function () {
        // variavel do método responsável por armazenar info da app web
        this.ruler                     = [];
        var compose_rule               = {};
        compose_rule['compare']        = [];
        compose_rule['conditions']     = [];
        compose_rule['condtions_type'] = [];
        compose_rule['logic_op']       = [];
        compose_rule['inputs']         = [];
        compose_rule['actions']        = [];
        //-----------inicia coleta:
        $('.form-control.select_rules_context.compare').each(function(){
            compose_rule['compare'].push($(this).val());
        });
        $('.form-control.select_rules_context.conditions').each(function(){
            compose_rule['conditions'].push($(this).val());

            compose_rule['condtions_type'].push($(this).find(":selected").data('type'));
        });
        $('.form-control.select_rules_context.operators').each(function(){
            compose_rule['logic_op'].push($(this).val());
        });
        $('.form-control.select_rules_context.actions').each(function(){
            compose_rule['actions'].push($(this).val());
        });
        $('.inputs').each(function(){
            compose_rule['inputs'].push($(this).val());
        });
        this.send_informations['name_rule'] = $("#name_rule").val();
        var str = $("#sensors").find(":selected").attr('id');
        var res = str.split("-")
        this.send_informations['id_sensor'] = Number(res[1]);
        // console.log(this.send_informations['id_sensor']);
        //------finaliza coleta

        this.compose_rule              = compose_rule;
        var finish                     = this.compose_rule['conditions'];
        this.to_number();
        this.condition['conditions']   = this.composition_conditions(0,finish.length);
        this.action['actions']         = this.composition_actions();
        this.ruler.push(this.condition);
        this.ruler.push(this.action);
        this.send_informations['rule'] = JSON.stringify(this.ruler);
        this.send_data();
        // console.log(JSON.stringify(this.ruler));

  };
  CreateRule.prototype.send_data = function () { //função que envia os dados para o servidor
    if(true){
      this.send_informations['context'] = '';
    };
    // else{};
    $.ajax({
      type:"POST",
      data: this.send_informations,
      dataType: 'json',
      url:window.base_url+"cadastros/CI_Regra_SB/gravar",
      complete: function (response) {
        console.log(response);
          }
    });
  };

  CreateRule.prototype. composition_conditions = function (init,finish) {

    var before = {};
    var rule;
    var merger;
    var before_logic;

    for(i = finish-1; i >= init; i--){
      rule   = {};
      rule['name']     = this.compose_rule['conditions'][i];
      rule['operator'] = this.compose_rule['compare'][i];
      rule['value']    = this.compose_rule['inputs'][i];
      if(i === finish-1){

        before[this.compose_rule['logic_op'][i]] = []
        before[this.compose_rule['logic_op'][i]].push(rule);
      }
      else if(i === 0){

        before[this.compose_rule['logic_op'][i+1]].push(rule);
      }
      else{

        if(this.compose_rule['logic_op'][i] != this.compose_rule['logic_op'][i+1]){
            merger = before;
            before = {};
            before[this.compose_rule['logic_op'][i]] = [];
            before[this.compose_rule['logic_op'][i]].push(merger);
            before[this.compose_rule['logic_op'][i]].push(rule);
        }
        else {

            before[this.compose_rule['logic_op'][i]].push(rule);
        }
      }
      //  console.log(JSON.stringify(before));
    }
      // console.log(before);
      return before;
  };

  CreateRule.prototype.composition_actions = function () {
      var action_group = [];
      var action = {};

      for(i=0; i<this.compose_rule['actions'].length; i++){
        action['name'] = this.compose_rule['actions'][i];
        action['params'] = '"foo": ""';
        action_group.push(action);
      }
      return action_group
  };

  CreateRule.prototype.to_number = function () {
      for(i = 0; i < this.compose_rule['condtions_type'].length ;i++){
        // var regex = new RegExp(/\d\d|\d/);
        var regex = new RegExp(/[0-9]|[0-9].[0-9]+|[0-9][0-9]|[0-9][0-9].[0-9]+/);
        // console.log(this.compose_rule['condtions_type'][i]);
        if(this.compose_rule['condtions_type'][i] == 'number' && regex.test(this.compose_rule['inputs'][i])){
            this.compose_rule['inputs'][i] = Number(this.compose_rule['inputs'][i]);
        }
      }
  };
  CreateRule.prototype.analysis_type = function () {

    var correct_information = true;
    var iterator = 0;
    while (iterator < this.compose_rule['condtions_type'].length) {
      if(this.compose_rule['inputs'] == null){

        correct_information = false;
      }
      else if(isNaN(this.compose_rule['inputs'][iterator]) && this.compose_rule['condtions_type'][iterator] == "number"){
        view_error("Erro de Tipo: palavra/frase","Condição "+(iterator+1)+"espera uma frase, não um numero");
        correct_information = false;

      }
      else if(!isNaN(this.compose_rule['inputs'][iterator]) && this.compose_rule['condtions_type'][iterator] == "string"){
        view_error("Erro de Tipo: palavra/frase","Condição "+(iterator+1)+"espera um numero, não um numero");
        correct_information = false;
      }
      iterator++;
    }

  };
  var view_error = function(title_error,string) {

    bootbox.dialog({
         message: string,
         title: title_error,
           buttons: {
               success: {
                   label: "ok!!",
                   className: "btn-danger",

               },
             }}).find('.modal-content').css({'background-color': '#fcf8e3','border-color':'#faebcc', 'font-weight' : 'bold', 'color': '#8a6d3b', 'font-size': '2em', 'font-weight' : 'bold'} );

  }


  return CreateRule;


})
