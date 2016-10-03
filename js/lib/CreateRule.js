define(["jquery","bootbox"],function ($,bootbox) {

  var path       = window.location.pathname.split('/');
  var CreateRule = function() {

      this.compose_rule;
      this.rules_list;
      this.rules_main = {};
      this.send_informations = {}
      this.rules_main = {};

  }

  CreateRule.prototype.create_rule = function () {
        // variavel do método responsável por armazenar info da app web
        this.rules_list                = [];
        var compose_rule               = {};
        compose_rule['compare']        = [];
        compose_rule['conditions']     = [];
        compose_rule['id_sensor']      = [];
        compose_rule['condtions_type'] = [];
        compose_rule['logic_op']       = [];
        compose_rule['inputs']         = [];
        compose_rule['actions']        = [];
        compose_rule['url']            = [];
        //-----------inicia coleta:
        // atributo this não podem ser inseridos em funções do tipo each, change,
        $('.form-control.select_rules_context.compare').each(function(){
            compose_rule['compare'].push($(this).val());
        });
        $('.form-control.select_rules_context.conditions').each(function(){
            compose_rule['conditions'].push($(this).find(":selected").data('name'));
            compose_rule['condtions_type'].push($(this).find(":selected").data('type'));
            compose_rule['url'].push($(this).find(":selected").data('url'))
            var index = $(this).val();
              compose_rule['id_sensor'].push(index);

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
        this.send_informations['status']    = true;
        this.send_informations['tipo']      = 2;
        this.send_informations['has_ajax']  = '';
        this.send_informations['id_rule']   = $("#editable_id_rule").val();
        if(this.send_informations['id_rule']){
            console.log("ok");
        }

        var str = $("#sensors").find(":selected").attr('id');
        var res = str.split("-");
        this.send_informations['id_sensor'] = Number(res[1]);
        console.log(this.send_informations['id_sensor']);
        //------finaliza coleta
        this.compose_rule              = compose_rule;
        var finish                     = this.compose_rule['conditions'];
        this.to_number();
        this.rules_main['conditions']  = this.composition_conditions(finish.length);
        this.rules_main['actions']     = this.composition_actions();
        this.rules_list.push(this.rules_main);
        this.send_informations['rule'] = JSON.stringify(this.rules_list);
        // this.insert_rules_error();
        console.log(JSON.stringify(this.rules_list));
        this.send_data();

  };
  CreateRule.prototype.send_data = function () { //função que envia os dados para o servidor
    if(true){
      this.send_informations['context'] = '';
    };
    $.ajax({
      type:"POST",
      data: this.send_informations,
      dataType: 'json',
      url:window.base_url+"cadastros/"+path[3]+"/gravar",
      complete: function (response) {
          //  console.log("bugg",response['responseText']);
          window.location.replace(window.base_url+"/cadastros/"+path[3]);
          }
    });
  };

  CreateRule.prototype. composition_conditions = function (finish) {
    var i               = 0;
    var before          = {}; // objeto de condição
    var parameters      = {};
    var rule        = {}; //  este vetor é o vetor pase para criar as regras
    var all         = {}; // vetor para combinação secundárias, do tipo all
    rule['any']     = [];  //  este vetor é o vetor pase para criar as regras
    all['all']      = []; // vetor para combinação secundárias, do tipo all


    do {
      if(finish == 2){ // se possui apenas duas condições
        if(this.compose_rule['logic_op'][i] == "any"){ // se OU coloca as condições na vet base
          before['name']         = this.compose_rule['conditions'][i];
          before['operator']     = this.compose_rule['compare'][i];
          parameters['sensor']   = this.compose_rule['id_sensor'][i];
          before['value']        = this.compose_rule['inputs'][i];
          parameters['url']      = this.compose_rule['url'][i];
          before['parameters']   = parameters;
          rule['any'].push(before);
          before                 = {};
          parameters             = {};
          before['name']         = this.compose_rule['conditions'][i+1];
          before['operator']     = this.compose_rule['compare'][i+1];
          before['value']        = this.compose_rule['inputs'][i+1];
          parameters['sensor']   = this.compose_rule['id_sensor'][i+1];
          parameters['url']      = this.compose_rule['url'][i+1];
          before['parameters']   = parameters;
          rule['any'].push(before);
        }
        else{ // Se op E insere condiçoes em um vetor all, este vetor é inserido no vetor base
          before['name']         = this.compose_rule['conditions'][i];
          before['operator']     = this.compose_rule['compare'][i];
          before['value']        = this.compose_rule['inputs'][i];
          parameters['sensor']   = this.compose_rule['id_sensor'][i];
          parameters['url']      = this.compose_rule['url'][i];
          before['parameters']   = parameters;
          all['all'].push(before);
          before                 = {};
          parameters             = {};
          before['name']         = this.compose_rule['conditions'][i+1];
          before['operator']     = this.compose_rule['compare'][i+1];
          before['value']        = this.compose_rule['inputs'][i+1];
          parameters['sensor']   = this.compose_rule['id_sensor'][i+1];
          parameters['url']      = this.compose_rule['url'][i+1];
          before['parameters']   = parameters;
          all['all'].push(before);
          rule['any'].push(all);

        }
        i = i + 2;

      }
      else if(i == 0 && finish == 1){ // se finish é 1, condiz com uma regra que possiu apenas uma condição
            before['name']         = this.compose_rule['conditions'][i];
            before['operator']     = this.compose_rule['compare'][i];
            before['value']        = this.compose_rule['inputs'][i];
            parameters['sensor']   = this.compose_rule['id_sensor'][i];
            parameters['url']      = this.compose_rule['url'][i];
            before['parameters']   = parameters;
            rule['any'].push(before);
            i = i + 2 ;
          }
      else{
          // verifica os a relação dos dois primeiros termos
          if(i == 0 && this.compose_rule['logic_op'][i] == "any"){ // coloca a primeira condição no vetor base. O segundo deve ser nalisado em uma proxima etapa (considere que uma relação AvB^C)
              before['name']         = this.compose_rule['conditions'][i];
              before['operator']     = this.compose_rule['compare'][i];
              before['value']        = this.compose_rule['inputs'][i];
              parameters['sensor']   = this.compose_rule['id_sensor'][i];
              parameters['url']      = this.compose_rule['url'][i];
              before['parameters']   = parameters;
              rule['any'].push(before);
              i= i + 2;
          }
          else if(i == 0 && this.compose_rule['logic_op'][i] == "all"){//cria vetor secundário e insere os dois termos no mesmo, não insere tal vetor no vetor base pois neessita de uma segunda analise
            before['name']         = this.compose_rule['conditions'][i];
            before['operator']     = this.compose_rule['compare'][i];
            before['value']        = this.compose_rule['inputs'][i];
            parameters['sensor']   = this.compose_rule['id_sensor'][i];
            parameters['url']      = this.compose_rule['url'][i];
            before['parameters']   = parameters;
            all['all'].push(before);
            before                 = {};
            // console.log(JSON.stringify(all));
            parameters             = {};
            before['name']         = this.compose_rule['conditions'][i+1];
            before['operator']     = this.compose_rule['compare'][i+1];
            before['value']        = this.compose_rule['inputs'][i+1];
            parameters['sensor']   = this.compose_rule['id_sensor'][i+1];
            parameters['url']      = this.compose_rule['url'][i+1];
            before['parameters']   = parameters;
            all['all'].push(before);

            // rule['any'].push(all);

            i = i + 2;
          }
          else if(this.compose_rule['logic_op'][i-1] == "all"){
            if(this.compose_rule['logic_op'][i-2] == "all"){ // Se operador atual for e o anterior tbm, insere a condição atual no vetor sec existente
              before                 = {};
              parameters             = {};
              before['name']         = this.compose_rule['conditions'][i];
              before['operator']     = this.compose_rule['compare'][i];
              before['value']        = this.compose_rule['inputs'][i];
              parameters['sensor']   = this.compose_rule['id_sensor'][i];
              parameters['url']      = this.compose_rule['url'][i];
              before['parameters']   = parameters;
              all['all'].push(before);

            }
            else{ //caso o op anterior for ou, insere vetor sec no vetor base
              // rule['any'].push(all);
              all                    = {};
              all['all']             = [];
              before                 = {};
              parameters             = {};
              before['name']         = this.compose_rule['conditions'][i];
              before['operator']     = this.compose_rule['compare'][i];
              before['value']        = this.compose_rule['inputs'][i];
              parameters['sensor']   = this.compose_rule['id_sensor'][i];
              parameters['url']      = this.compose_rule['url'][i];
              before['parameters']   = parameters;
              all['all'].push(before);
              before                 = {};
              parameters             = {};
              before['name']         = this.compose_rule['conditions'][i-1];
              before['operator']     = this.compose_rule['compare'][i-1];
              before['value']        = this.compose_rule['inputs'][i-1];
              parameters['sensor']   = this.compose_rule['id_sensor'][i-1];
              parameters['url']      = this.compose_rule['url'][i-1];
              before['parameters']   = parameters;
              all['all'].push(before);

            }
            if(i == finish-1){// chegou no final, deve colocar o vetor sec. all dentro do vetor base, incrementa +3 para sair do laço
              rule['any'].push(all);
              i = i + 3 ;
            }
            else{
              i++;
            }
          }
          else if(this.compose_rule['logic_op'][i-1] == "any"){
            if(this.compose_rule['logic_op'][i-2] == "any"){
              before                 = {};
              parameters             = {};
              before['name']         = this.compose_rule['conditions'][i-1];
              before['operator']     = this.compose_rule['compare'][i-1];
              before['value']        = this.compose_rule['inputs'][i-1];
              parameters['sensor']   = this.compose_rule['id_sensor'][i-1];
              parameters['url']      = this.compose_rule['url'][i-1];
              before['parameters']   = parameters;
              rule['any'].push(before);
              if(i == finish-1){
                before               = {};
                parameters           = {};
                before['name']       = this.compose_rule['conditions'][i];
                before['operator']   = this.compose_rule['compare'][i];
                before['value']      = this.compose_rule['inputs'][i];
                parameters['sensor'] = this.compose_rule['id_sensor'][i];
                parameters['url']    = this.compose_rule['url'][i];
                before['parameters'] = parameters;
                rule['any'].push(before);
                i = i + 3;
              }
              else{i++;}
            }
            else{
              rule['any'].push(all);

              if(i == finish-1){
                before                 = {};
                parameters             = {};
                before['name']         = this.compose_rule['conditions'][i];
                before['operator']     = this.compose_rule['compare'][i];
                before['value']        = this.compose_rule['inputs'][i];
                parameters['sensor']   = this.compose_rule['id_sensor'][i];
                parameters['url']      = this.compose_rule['url'][i];
                before['parameters']   = parameters;
                rule['any'].push(before);
                i = i + 3;
              }
              else{i++;}
            }
          }

        }

    }while (i < finish);
      return rule;
  };

  CreateRule.prototype.composition_actions = function () {

      var action_group = [];
      for(i = 0; i < this.compose_rule['actions'].length; i++){
        var action       = {};
        var params       = {};
        action['name']   = this.compose_rule['actions'][i];
        params["foo"]    = "";
        action['params'] = params;
        action_group.push(action);
      }
      return action_group
  };

  CreateRule.prototype.to_number = function () {
      for(i = 0; i < this.compose_rule['condtions_type'].length ;i++){
        // var regex = new RegExp(/\d\d|\d/);
        var regex = new RegExp(/[0-9]|[0-9].[0-9]+|[0-9][0-9]|[0-9][0-9].[0-9]+/);
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

  CreateRule.prototype.insert_rules_error = function () { // insere regras de verificação de erro dos sensores nas lista de regra
    var before    = {};
    var rule      = {};
    var rules_sensor       = this.compose_rule['id_sensor'];
    var action             = {name: "test_post_Event", params:{info_adicional:""}};
    for(i=0; i < rules_sensor.length;i++){
        before['name']     = "fault_check"+rules_sensor[i];
        before['operator'] = "equal"
        before['value']    = false;
        rule['conditions'] = before;
        rule['actions']    = [];
        rule['actions'].push(action);
        this.rules_list.push(rule);
        rule               = {};
        before             = {};
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
