define(["jquery","bootbox"],function ($,bootbox) {

  var path       = window.location.pathname.split('/');
  var CreateRule = function() {

      this.compose_rule;
      this.rules_list;
      this.rules_main        = {};
      this.send_informations = {};
      this.rules_main        = {};

  }

  CreateRule.prototype.create_rule = function () {
        // variavel do método responsável por armazenar info da app web
        this.rules_list                   = [];
        var compose_rule                  = {};
        compose_rule['compare']           = [];
        compose_rule['conditions']        = [];
        compose_rule['id_sensor']         = [];
        compose_rule['condtions_type']    = [];
        compose_rule['logic_op']          = [];
        compose_rule['inputs']            = [];
        compose_rule['actions']           = [];
        compose_rule['input_of_action']   = [];
        compose_rule['select_parametes2'] = [];
        compose_rule['url']               = [];
        compose_rule['data_condition']    = [];
        //-----------inicia coleta:
        $('.form-control.select_rules_context.compare').each(function(){
            compose_rule['compare'].push($(this).val());
        });
        /*ideia: pegar a data name e toda a data(), este ultimo passado para um método que padroniza as parametros da condição*/
        $('.form-control.select_rules_context.conditions').each(function(){
            compose_rule['conditions'].push($(this).find(":selected").data('name'));// poderia tirar esses dois e usar só o data
            compose_rule['condtions_type'].push($(this).find(":selected").data('type'));
            compose_rule['data_condition'].push($(this).find(":selected").data());

            // compose_rule['url'].push($(this).find(":selected").data('url'))
            var index        = $(this).val();
            var split_sensor = index.split("|");
            compose_rule['id_sensor'].push(split_sensor[0]);
        });
        $('.form-control.select_rules_context.operators').each(function(){
            compose_rule['logic_op'].push($(this).val());
        });
        $('.form-control.select_rules_context.actions').each(function(){
           compose_rule['actions'].push($(this).val());
       });
      //  console.log(typeof compose_rule['input_of_action']);

        $('.inputs').each(function(){
            compose_rule['inputs'].push($(this).val());
        });
        $('.form-group.input_action:visible').each(function(){
            compose_rule['input_of_action'].push($(this).children().val());
        });
        $('.form-group.select_parameters2:visible').each(function(){
            compose_rule['select_parametes2'].push($(this).val());

        });
        $('.form-control.select_rules_context.select_parameters3:visible').each(function(){
            console.log("Entro");
            compose_rule['select_parametes2'].push($(this).val());
            console.log($(this).val());
        });
        //this.send_informations['topico']  = $('#topicos').find(":selected").val();
        this.send_informations['name_rule'] = $("#name_rule").val();
        this.send_informations['status']    = $("#box_status_rules").is(":checked"); //jeito elegante, sábio
        this.send_informations['tipo']      = 2;

        this.send_informations['id_rule']   = $("#editable_id_rule").val();
        if(this.send_informations['id_rule']){
            // console.log("ok");
        }

        var str = $("#sensors").find(":selected").attr('id');
        var res = str.split("-");
        this.send_informations['id_sensor'] = Number(res[1]);

        //------finaliza coleta
        this.compose_rule              = compose_rule;
        var finish                     = this.compose_rule['conditions'];
        this.to_number();
        this.rules_main['conditions']  = this.composition_conditions(finish.length);
        this.rules_main['actions']     = this.composition_actions();
        this.rules_list.push(this.rules_main);
        this.send_informations['rule'] = JSON.stringify(this.rules_list);
        // this.insert_rules_error();
        // console.log(JSON.stringify(this.rules_list));
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
      url:window.base_url+"cadastros/"+path[3]+"/gravar?has_ajax=s",
      complete: function (response) {
        console.log("Caiu");
         window.location.replace(window.base_url+"cadastros/"+path[3]+"?msg="+response['responseText']);
      }
    });
    // console.log(this.send_informations);
  };

  CreateRule.prototype.composition_conditions = function (finish) {

    var i               = 0;
    // console.log(this.compose_rule['data_condition']);
    var before          = {}; // objeto de condição
    var parameters      = {};
    var rule            = {}; //  este vetor é o vetor pase para criar as regras
    var all             = {}; // vetor para combinação secundárias, do tipo all
    rule['any']         = [];  //  este vetor é o vetor pase para criar as regras
    all['all']          = []; // vetor para combinação secundárias, do tipo all

    do {
      if(finish == 2){ // se possui apenas duas condições
        if(this.compose_rule['logic_op'][i] == "any"){ // se OU coloca as condições na vet base
          before['name']         = this.compose_rule['conditions'][i];
          before['operator']     = this.compose_rule['compare'][i];
          parameters['sensor']   = this.compose_rule['id_sensor'][i];
          before['value']        = this.compose_rule['inputs'][i];
          // parameters['url']      = this.compose_rule['url'][i];
          // before['parameters']   = parameters;
          before['parameters']   = this.standardize_parameters_condition(this.compose_rule['data_condition'][i],this.compose_rule['id_sensor'][i]);
          rule['any'].push(before);
          before                 = {};
          parameters             = {};
          before['name']         = this.compose_rule['conditions'][i+1];
          before['operator']     = this.compose_rule['compare'][i+1];
          before['value']        = this.compose_rule['inputs'][i+1];
          // parameters['sensor']   = this.compose_rule['id_sensor'][i+1];
          // parameters['url']      = this.compose_rule['url'][i+1];
          // before['parameters']   = parameters;
          before['parameters']   = this.standardize_parameters_condition(this.compose_rule['data_condition'][i+1],this.compose_rule['id_sensor'][i+1]);
          rule['any'].push(before);
        }
        else{ // Se op E insere condiçoes em um vetor all, este vetor é inserido no vetor base
          before['name']         = this.compose_rule['conditions'][i];
          before['operator']     = this.compose_rule['compare'][i];
          before['value']        = this.compose_rule['inputs'][i];
          // parameters['sensor']   = this.compose_rule['id_sensor'][i];
          // parameters['url']      = this.compose_rule['url'][i];
          // before['parameters']   = parameters;
          before['parameters']   = this.standardize_parameters_condition(this.compose_rule['data_condition'][i+1],this.compose_rule['id_sensor'][i+1]);
          all['all'].push(before);
          before                 = {};
          parameters             = {};
          before['name']         = this.compose_rule['conditions'][i+1];
          before['operator']     = this.compose_rule['compare'][i+1];
          before['value']        = this.compose_rule['inputs'][i+1];
          // parameters['sensor']   = this.compose_rule['id_sensor'][i+1];
          // parameters['url']      = this.compose_rule['url'][i+1];
          // before['parameters']   = parameters;
          before['parameters']   = this.standardize_parameters_condition(this.compose_rule['data_condition'][i+1],this.compose_rule['id_sensor'][i+1]);
          all['all'].push(before);
          rule['any'].push(all);

        }
        i = i + 2;

      }
      else if(i == 0 && finish == 1){ // se finish é 1, condiz com uma regra que possiu apenas uma condição
            before['name']         = this.compose_rule['conditions'][i];
            before['operator']     = this.compose_rule['compare'][i];
            before['value']        = this.compose_rule['inputs'][i];
            // parameters['sensor']   = this.compose_rule['id_sensor'][i];
            // parameters['url']      = this.compose_rule['url'][i];
            // before['parameters']   = parameters;
            before['parameters']   = this.standardize_parameters_condition(this.compose_rule['data_condition'][i],this.compose_rule['id_sensor'][i]);
            rule['any'].push(before);
            i = i + 2 ;
          }
      else{
          // verifica os a relação dos dois primeiros termos
          if(i == 0 && this.compose_rule['logic_op'][i] == "any"){ // coloca a primeira condição no vetor base. O segundo deve ser nalisado em uma proxima etapa (considere que uma relação AvB^C)
              before['name']         = this.compose_rule['conditions'][i];
              before['operator']     = this.compose_rule['compare'][i];
              before['value']        = this.compose_rule['inputs'][i];
              // parameters['sensor']   = this.compose_rule['id_sensor'][i];
              // parameters['url']      = this.compose_rule['url'][i];
              // before['parameters']   = parameters;
              before['parameters']   = this.standardize_parameters_condition(this.compose_rule['data_condition'][i],this.compose_rule['id_sensor'][i]);
              rule['any'].push(before);
              i= i + 2;
          }
          else if(i == 0 && this.compose_rule['logic_op'][i] == "all"){//cria vetor secundário e insere os dois termos no mesmo, não insere tal vetor no vetor base pois neessita de uma segunda analise
            before['name']         = this.compose_rule['conditions'][i];
            before['operator']     = this.compose_rule['compare'][i];
            before['value']        = this.compose_rule['inputs'][i];
            // parameters['sensor']   = this.compose_rule['id_sensor'][i];
            // parameters['url']      = this.compose_rule['url'][i];
            // before['parameters']   = parameters;
            before['parameters']   = this.standardize_parameters_condition(this.compose_rule['data_condition'][i],this.compose_rule['id_sensor'][i]);
            all['all'].push(before);
            before                 = {};

            parameters             = {};
            before['name']         = this.compose_rule['conditions'][i+1];
            before['operator']     = this.compose_rule['compare'][i+1];
            before['value']        = this.compose_rule['inputs'][i+1];
            // parameters['sensor']   = this.compose_rule['id_sensor'][i+1];
            // parameters['url']      = this.compose_rule['url'][i+1];
            // before['parameters']   = parameters;
            before['parameters']   = this.standardize_parameters_condition(this.compose_rule['data_condition'][i+1],this.compose_rule['id_sensor'][i+1]);
            all['all'].push(before);



            i = i + 2;
          }
          else if(this.compose_rule['logic_op'][i-1] == "all"){
            if(this.compose_rule['logic_op'][i-2] == "all"){ // Se operador atual for e o anterior tbm, insere a condição atual no vetor sec existente
              before                 = {};
              parameters             = {};
              before['name']         = this.compose_rule['conditions'][i];
              before['operator']     = this.compose_rule['compare'][i];
              before['value']        = this.compose_rule['inputs'][i];
              // parameters['sensor']   = this.compose_rule['id_sensor'][i];
              // parameters['url']      = this.compose_rule['url'][i];
              // before['parameters']   = parameters;
              before['parameters']   = this.standardize_parameters_condition(this.compose_rule['data_condition'][i],this.compose_rule['id_sensor'][i]);
              all['all'].push(before);

            }
            else{ //caso o op anterior for ou, insere vetor sec no vetor base

              all                    = {};
              all['all']             = [];
              before                 = {};
              parameters             = {};
              before['name']         = this.compose_rule['conditions'][i];
              before['operator']     = this.compose_rule['compare'][i];
              before['value']        = this.compose_rule['inputs'][i];
              before['parameters']   = this.standardize_parameters_condition(this.compose_rule['data_condition'][i],this.compose_rule['id_sensor'][i]);
              all['all'].push(before);
              before                 = {};
              parameters             = {};
              before['name']         = this.compose_rule['conditions'][i-1];
              before['operator']     = this.compose_rule['compare'][i-1];
              before['value']        = this.compose_rule['inputs'][i-1];
              before['parameters']   = this.standardize_parameters_condition(this.compose_rule['data_condition'][i-1],this.compose_rule['id_sensor'][i-1]);
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
              // parameters['sensor']   = this.compose_rule['id_sensor'][i-1];
              // parameters['url']      = this.compose_rule['url'][i-1];
              // before['parameters']   = parameters;
              before['parameters']   = this.standardize_parameters_condition(this.compose_rule['data_condition'][i-1],this.compose_rule['id_sensor'][i-1]);
              rule['any'].push(before);
              if(i == finish-1){
                before               = {};
                parameters           = {};
                before['name']       = this.compose_rule['conditions'][i];
                before['operator']   = this.compose_rule['compare'][i];
                before['value']      = this.compose_rule['inputs'][i];
                // parameters['sensor'] = this.compose_rule['id_sensor'][i];
                // parameters['url']    = this.compose_rule['url'][i];
                // before['parameters'] = parameters;
                before['parameters'] = this.standardize_parameters_condition(this.compose_rule['data_condition'][i],this.compose_rule['id_sensor'][i]);
                rule['any'].push(before);
                i = i + 3;
              }
              else{
                i++;
              }
            } else {
              rule['any'].push(all);

              if(i == finish-1){
                before                 = {};
                parameters             = {};
                before['name']         = this.compose_rule['conditions'][i];
                before['operator']     = this.compose_rule['compare'][i];
                before['value']        = this.compose_rule['inputs'][i];
                // parameters['sensor']   = this.compose_rule['id_sensor'][i];
                // parameters['url']      = this.compose_rule['url'][i];
                // before['parameters']   = parameters;
                before['parameters']   = this.standardize_parameters_condition(this.compose_rule['data_condition'][i],this.compose_rule['id_sensor'][i]);
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
/*compostion_action: médoto responsável por normalizar as ações para o padrão da regra*/
  CreateRule.prototype.composition_actions = function () {

      var action_group   = [];
      for(i = 0; i < this.compose_rule['actions'].length; i++){
        var action       = {};
        action['name']   = this.compose_rule['actions'][i];
        action['params'] = this.standardize_parameters_actions(action['name']);
        action_group.push(action);
      }
      return action_group
  };
  /*standardize_parameters_actions: método que realiza a padronização dos parametros de uma ação.
  Verifica qual é a ação a ser tratada e gera um objeto javascript params que conterá atributos.
  Cada atributo é referente a um determinado parâmetro da ação*/
  CreateRule.prototype.standardize_parameters_actions = function (action_name) {
    var params = {};

    switch (action_name) {
      case 'send_email':

        params["email"] = this.compose_rule['input_of_action'].shift();
        break;

      case 'proceeding':

        try {
            params["timer"]   = this.compose_rule['input_of_action'].shift();
            params["uuid"]    = this.compose_rule['select_parametes2'].shift();
          } catch (e) {
            alert("Não foi inserido parametro");
          }
        break;

      case 'publish':
        console.log(this.compose_rule['select_parametes2']);
        params["uuid"]    = this.compose_rule['select_parametes2'].shift();
        break;
      default:
        params["foo"] = "";

    }
    return params
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
    var action             = {name: "send_email", params:{info_adicional:""}};

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

  CreateRule.prototype.standardize_parameters_condition = function (data_condtion,sensor_uuid) {

      var parameters                     = {};
      var parameters_contains_sensor_url = data_condtion['name']=="get_verify_sensor"||data_condtion['name']=="diff_values_sensor"||data_condtion['name']=="check_fault";
      var paramaters_contains_url        = data_condtion['name']=="calcule_average";

      if(parameters_contains_sensor_url){
        parameters['url']    = data_condtion['url'];
        parameters['sensor'] = sensor_uuid;

      }else if (paramaters_contains_url) {
          parameters['url']  = data_condtion['url'];
      }

      return parameters;
  };


  return CreateRule;


})
