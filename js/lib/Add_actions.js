define (["lib/ConditionsRules"], function(ConditionsRules){

    var AddActions = function (select,data,selected){
      // constroi a estrutura para seleção de ações
        this.id_select = "#"+select;
        this.select_construct = $('<select>',{
          class: "form-control select_rules_context actions",
          id: select
        }); // cira um bloco do tipo select
        this.group_rule = $('<select>',{
          class: "form-control select_rules_context actions",
          id: "group"+select
        }); // cira um bloco do tipo select

        this.generateOption(select,data);
        this.generateRow(this.select_construct,this.group_rule,4,select);
        this.generate_groups(this.group_rule,select);
        if(isNaN(selected)){ // se for umas string, seta o valor
          // console.log(JSON.stringify(selected));
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
      var group_rules = group_select;
      console.log("ummm");
      this.select_construct.change(function () {
          if($(this).val()=="active_rules_group"){
            // console.log("XXXXXXXXXXXXXXXXXXXXXXXXx",group_rules);
            var opt_base = $('<option value selected disabled>Selecione</option>');
            group_rules.append(opt_base)
            for(i = 0; i < group.length; i++){

                  var opt = $('<option>', {
                      value: group[i]['id'],
                      text:  group[i]['nome']
                  });
                  group_rules.append(opt);
            }
            $("#group_div"+select).append(group_rules);
          }
      });
    };

    return AddActions;

});
