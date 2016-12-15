define (["lib/ConditionsRules"], function(ConditionsRules){

    var AddActions = function (select,data,selected){
      // constroi a estrutura para seleção de ações
        this.id_select = "#"+select;
        this.select_construct = $('<select>',{
          class: "form-control select_rules_context actions",
          id: select
        }); // cria um bloco do tipo select, para selecionar a açaõ
        this.group_rule = $('<select>',{ // inserir ao menos outra classe, para diferenciar do seletor de ações
          class: "form-control select_rules_context select_parameters1",
          id: "group"+select
        }).hide(); // cria um bloco do tipo select, selecionar parametros, como grupos de regras, atuadores, usuários e etc
        this.select_for_parameter2 =$('<select>',{
                                class: "form-control select_rules_context select_parameters2",
                                id: "group"+select}
                                ).hide();
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
        this.generateRow(this.select_construct,this.group_rule,4,select);
        this.generate_groups(this.group_rule,select);

        input_email.click(function functionName() {
          $(this).val("");
        })

        if(isNaN(selected)){ // se for umas string, seta o valor
            var type = $("#"+select).val(selected);
        }
    }

    AddActions.prototype.generateRow = function (select_acoes,group_rule,size,select) {
      var row  = $('<div>',{class: "row bin"})
      var col  = $('<div>',{class: "col-md-"+size});
      var div_param_1 = $('<div>',{class: "col-md-"+size, id:"group_div"+select})
      var div_param_2  = $('<div>',{class: "col-md-"+3, id:"parameter2-"+select})
      var insert_icon    = $('<i>',{class: "fa fa-times fa-2x"});
      col.append(select_acoes);
      row.append(col);
      row.append(div_param_1);
      div_param_1.append(this.form_control);
      div_param_1.append(this.group_rule);
      row.append(div_param_2);
      this.button_remove.append(insert_icon);
      this.div_col.append(this.button_remove);
      row.append(this.div_col)
      // console.log(this.select_for_parameter2);
      div_param_2.append(this.select_for_parameter2);
      $('#div_action').append(row)

    }
    AddActions.prototype.generateOption = function (select,data){
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
      }
    }
    AddActions.prototype.generate_groups = function (group_select,select) {
      var group = [{'nome': "Janela Dia", 'id' : 32},{'nome': "Janela Noite", 'id' : 33}]
      var group_rules  = group_select;
      var input_action = this.form_control;
      var select_parametes2 = this.select_for_parameter2;
      this.select_construct.change(function () {
          input_action.hide();
          select_parametes2.hide();
          group_rules.show();

          if($(this).val()=="active_rules_group"){
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

          }
          else if ($(this).val()=="test_post_event") {
            group_rules.hide();
            select_parametes2.hide();
            input_action.show().children().children().prop('type','email');;
          }
          else if ($(this).val()== "proceeding") {
            group_rules.hide();
            input_action.show().children().children().prop('type','text');
            input_action.show().children().children().val("digite tempo (minutos)");
            select_parametes2.show();
            var opt_base = $('<option value selected disabled>Selecionar atuador</option>');
            select_parametes2.append(opt_base)


          }
      });
    };

    return AddActions;

});
