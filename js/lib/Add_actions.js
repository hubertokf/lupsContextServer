define (["lib/ConditionsRules"], function(ConditionsRules){

    var AddActions = function (select,data,selected,set_parameteres,set_parameteres_ation){
      // constroi a estrutura para seleção de ações

        this.div_param_1 = $('<div>',{class: "col-md-"+4, id:"group_div"+select});
        this.div_param_2 = $('<div>',{class: "col-md-"+3, id:"parameter2-"+select});
        this.div_param_3 = $('<div>',{class: "col-md-"+3, id:"parameter3-"+select});
        this.id_select        = "#"+select;
        this.select_construct = $('<select>',{
          class: "form-control select_rules_context actions",
          id: select
        }); // cria um bloco do tipo select, para selecionar a açaõ

        this.group_rule = $('<select>',{ // inserir ao menos outra classe, para diferenciar do seletor de ações
          class: "form-control select_rules_context select_parameters1",
          id: "group"+select
        }).hide(); // seletor para parametros grupos de regras,

        this.select_for_parameter2 =$('<select>',{
                                class: "form-control select_rules_context select_parameters2",
                                id: "group"+select}
                                ).hide();

        this.sensors_selector_for_paramater =$('<select>',{
                                class: "form-control select_rules_context select_parameters3",
                                id: "group"+select}
                              ).hide();//seletor de sensores como parametros de ação

        this.button_remove = $('<a>',{class:"botaoExcluir remove",id: "exc"+select});
        this.div_col       = $('<div>',{class: "col-md-1",id: "mid"+select})
        // console.log(iterator != "ed-0",iterator);
        this.button_remove.click(function () {
              $(this).parent().parent().remove();
        })
        // cria um tipo input
        this.form_control = $('<form>',{class: 'form-inline'}).hide();
        var inline_form   = $('<div>',{class: 'form-group input_action', style: "padding-top: 6px"});
        var input_email   = $('<input>',{class:'form-control',type:'email'});
        inline_form.append(input_email);
        this.form_control.append(inline_form);

        this.generateOption(select,data);
        this.generateRow(this.select_construct,this.group_rule,select);
        this.generate_groups(this.group_rule,select);

        input_email.click(function functionName() {
          $(this).val("");
        })

        if(isNaN(selected)){ // se for umas string, é uma ediçaõ de regra e seta o seletor
            var type = $("#"+select).val(selected);
            this.set_DOM_parameters(this.group_rule,select,selected,set_parameteres_ation);
        }
    }

    AddActions.prototype.generateRow = function (select_acoes,group_rule,select) {
      var row         = $('<div>',{class: "row bin"});
      var col         = $('<div>',{class: "col-md-"+4});
      var insert_icon = $('<i>',{class: "fa fa-times fa-2x"});

      col.append(select_acoes);
      row.append(col);
      row.append(this.div_param_1);
      this.div_param_1.append(this.form_control);
      this.div_param_1.append(this.group_rule);
      this.button_remove.append(insert_icon);
      row.append(this.div_param_2);
      this.div_col.append(this.button_remove);
      row.append(this.div_col);
      this.div_param_2.append(this.select_for_parameter2);

      $('#div_action').append(row)

      return
    }

    AddActions.prototype.generateOption = function (select,data){
      /**/
      var opt_base = $('<option value selected disabled>Selecione</option>');
      this.select_construct.append(opt_base);
      for(i = 0; i < Object.keys(data).length; i++){
          if(typeof data[i] === "string"){
            // console.log(data[i]);
            data[i] = JSON.parse(data[i]);
          }
            var opt = $('<option>', {
                value: data[i]['nome'],
                text: data[i]['nome_legivel']
            });
            this.select_construct.append(opt);
      }      };

    AddActions.prototype.generate_groups = function (group_select,select) {

      var group             = [{'nome': "Janela Dia", 'id' : 32},{'nome': "Janela Noite", 'id' : 33}]
      //elementos HTML referente aos parâmetros das ações
      var group_rules       = group_select; // seletor de grupo de regras (em breve)
      var input_action      = this.form_control; //tem info sobre campo input,
      var select_parametes2 = this.select_for_parameter2; // seletor usado para possível atuação (nesse ira os atuadores)
      var sensors_selector  = this.sensors_selector_for_paramater; //seletor com sensores para serem publicados
      var div_param_1       = this.div_param_1; //div pai do input_action
      var div_param_2       = this.div_param_2; //div pai do  group_rules, select_parametes2 e sensors_selector

      /* quando o seletor de ações é alterado: realiza a alteração na DOM, mostrando e ocultando os elementos
      relacioados à suas respectivas ações*/
      this.select_construct.change(function () {

          var run_ajax_sensors = function(get_ajax_sensors){
            var path = window.location.pathname.split('/');
            $.ajax({
                type:"POST",
                dataType: 'json',
                url:window.base_url+"cadastros/"+path[3]+"/get_sensors",
                complete: function (data) {
                    get_ajax_sensors(data["responseJSON"]);
                },
                // async: false
                  });
        };

          var get_ajax_sensors = function (data) { // serve para manipular os dados vindos do ajax

            for(i = 0; i < Object.keys(data).length; i++){
                json_data = JSON.parse(data[i])
                var opt = $('<option>', {
                value: json_data['uuid'],
                text:  json_data['nome']
            });
            sensors_selector.append(opt);
            }
        }

          input_action.hide();
          select_parametes2.hide();
          sensors_selector.hide()
          group_rules.show();
          var ajax_sensor_selector = sensors_selector;
          switch ($(this).val()) {

            case "active_rules_group":

              select_parametes2.hide();
              var opt_base = $('<option value selected disabled>Selecione</option>');
              group_rules.append(opt_base)
              for(i = 0; i < group.length; i++){
                  var opt = $('<option>', {
                      value: group[i]['id'],
                      text:  group[i]['nome']
                  });
                  group_rules.append(opt);
            }
              break;

            case "test_post_event":

              div_param_1.show();
              div_param_1.children().remove();
              div_param_2.show(); //para deixar o tamanho da row padrão
              group_rules.hide();
              select_parametes2.hide();
              input_action.show().children().children().prop('type','email');
              div_param_1.append(input_action);
              console.log(input_action.parent());
              break;

            case "group_rules":

              var opt_base = $('<option value selected disabled>Selecionar atuador</option>');
              group_rules.hide();
              div_param_2.show()
              input_action.show().children().children().prop('type','text');
              input_action.show().children().children().val("digite tempo (minutos)");
              sensors_selector.hide();
              select_parametes2.show();
              select_parametes2.append(opt_base);
              break;

            case "publish":
              // var sensor   = JSON.parse($("#sensor_for_action").val());

              var opt_base = $('<option value selected disabled> sensor</option>');
              group_rules.hide();
              div_param_2.hide()
              div_param_1.show();
              div_param_1.children().remove();
              if(sensors_selector.children().length == 0){
                sensors_selector.append(opt_base);
                run_ajax_sensors(get_ajax_sensors);
              }
              div_param_1.append(sensors_selector);
              sensors_selector.show();
              break;
              case "publisher_all":
                // var sensor   = JSON.parse($("#sensor_for_action").val());

                group_rules.hide();
                div_param_1.hide();
                div_param_2.hide();
                div_param_1.children().remove();
                break;
            default:
            break;

          }

      });

    };

    AddActions.prototype.set_DOM_parameters = function (group_select,select,action_selected,set_parameteres) {
      /*possui a função de configurar os parametros das ações de regras editadas*/
      var group_rules       = group_select; // seletor de grupo de regras (em breve)
      var input_action      = this.form_control; //tem info sobre campo input,
      var select_parametes2 = this.select_for_parameter2; // seletor usado para possível atuação (nesse ira os atuadores)
      var sensors_selector  = this.sensors_selector_for_paramater; //seletor com sensores para serem publicados
      var div_param_1       = this.div_param_1; //div pai do input_action
      var div_param_2       = this.div_param_2; //div pai do  group_rules, select_parametes2 e sensors_selector

      var run_ajax_sensors = function(get_ajax_sensors){
          var path = window.location.pathname.split('/');
          $.ajax({
              type:"POST",
              dataType: 'json',
              url:window.base_url+"cadastros/"+path[3]+"/get_sensors",
              complete: function (data) {
                  get_ajax_sensors(data["responseJSON"]);
              },
              // async: false
                });
      };

      var get_ajax_sensors = function (data) { // serve para manipular os dados vindos do ajax

          for(i = 0; i < Object.keys(data).length; i++){
              json_data = JSON.parse(data[i])
              var opt = $('<option>', {
              value: json_data['uuid'],
              text:  json_data['nome']
          });
          sensors_selector.append(opt);
          }
      }

        input_action.hide();
        select_parametes2.hide();
        sensors_selector.hide()
        group_rules.show();
        var ajax_sensor_selector = sensors_selector;
        switch (action_selected) { //verifica qual é a ação e seta os DOM dos parametros

          /*case "active_rules_group":
            select_parametes2.hide();
            var opt_base = $('<option value selected disabled>Selecione</option>');
            group_rules.append(opt_base)
            for(i = 0; i < group.length; i++){
                var opt = $('<option>', {
                    value: group[i]['id'],
                    text:  group[i]['nome']
                });
                group_rules.append(opt);
          }
            break;*/

          case "test_post_event":

            div_param_1.show();
            div_param_1.children().remove();
            div_param_2.show(); //para deixar o tamanho da row padrão
            group_rules.hide();
            select_parametes2.hide();
            input_action.show().children().children().prop('type','email');
            input_action.children().children().val(set_parameteres['email']);
            div_param_1.append(input_action);
            // console.log(input_action.parent());
            break;

      /*    case "group_rules":
            var opt_base = $('<option value selected disabled>Selecionar atuador</option>');
            group_rules.hide();
            div_param_2.show()
            input_action.show().children().children().prop('type','text');
            input_action.show().children().children().val("digite tempo (minutos)");
            sensors_selector.hide();
            select_parametes2.show();
            select_parametes2.append(opt_base);
            break;*/

          case "publish":
            // var sensor   = JSON.parse($("#sensor_for_action").val());

            var opt_base = $('<option value selected disabled> sensor</option>');
            group_rules.hide();
            div_param_2.hide()
            div_param_1.show();
            div_param_1.children().remove();
            if(sensors_selector.children().length == 0){
              sensors_selector.append(opt_base);
              run_ajax_sensors(get_ajax_sensors);
            }
            div_param_1.append(sensors_selector);
            sensors_selector.show();
            sensors_selector.val(set_parameteres['uuid']);
            break;
            case "publisher_all":
              // var sensor   = JSON.parse($("#sensor_for_action").val());

              group_rules.hide();
              div_param_1.show().children().remove();
              div_param_2.hide();
              div_param_1.children().remove();
              break;
          default:
          break;

        }
    };

    return AddActions;

});
