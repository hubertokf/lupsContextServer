define (["lib/ConditionsRules"], function(ConditionsRules){

    var AddActions = function (select,data,selected){
      // constroi a estrutura para seleção de ações
        this.id_select = "#"+select;
        this.select_construct = $('<select>',{
          class: "form-control select_rules_context actions",
          id: select
        }); // cria um bloco do tipo select, para selecionar a açaõ
        this.group_rule = $('<select>',{
          class: "form-control select_rules_context actions",
          id: "group"+select
        }).hide(); // cria um bloco do tipo select, selecionar parametros, como grupos de regras, atuadores, usuários e etc

        // cria um tipo input
        this.form_control = $('<form>',{class: 'form-inline'}).hide();
        var inline_form  = $('<div>',{class: 'form-group input_action', style: "padding-top: 6px"});
        var input_email  = $('<input>',{class:'form-control',type:'email'});
        inline_form.append(input_email);
        this.form_control.append(inline_form);

        this.generateOption(select,data);
        this.generateRow(this.select_construct,this.group_rule,4,select);
        this.generate_groups(this.group_rule,select);
        if(isNaN(selected)){ // se for umas string, seta o valor
            var type = $("#"+select).val(selected);
        }
    }

    AddActions.prototype.generateRow = function (select_acoes,group_rule,size,select) {
      var row  = $('<div>',{class: "row bin"})
      var col  = $('<div>',{class: "col-md-"+size+" col-md-offset-1"});
      var diff = $('<div>',{class: "col-md-"+size, id:"group_div"+select})
      var dof  = $('<div>',{class: "col-md-"+3})
      col.append(select_acoes);
      row.append(col);
      row.append(diff);
      diff.append(this.form_control);
      diff.append(this.group_rule);
      row.append(dof);
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
      this.select_construct.change(function () {
          input_action.hide();
          group_rules.show();

          if($(this).val()=="active_rules_group"){
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
            input_action.show().children().children().prop('type','email');;
          }
          else if ($(this).val()== "proceeding") {
            group_rules.hide();
            input_action.show().children().children().prop('type','text');

          }
      });
    };

    return AddActions;

});
