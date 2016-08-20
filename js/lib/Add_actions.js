define (["lib/ConditionsRules"], function(ConditionsRules){

    var AddActions = function (select){
      // constroi a estrutura para seleção de ações
        this.id_select = "#"+select;
        this.select_construct = $('<select>',{
          class: "form-control select_rules_context actions",
          id: select
        }); // cira um bloco do tipo select
        this.generateOption(select);
        this.generateRow(this.select_construct,2,select);

    }

    AddActions.prototype.generateRow = function (select_condition,size,select) {

      var col = $('<div>',{class: "col-md-"+size+" col-md-offset-1"});
      var diff = $('<div>',{class: "col-md-"+ (12-size)})
      col.append(select_condition);
      console.log($('.row.bin'));
      $('.row.bin').append(col);
      $('.row.bin').append(diff);
    }
    AddActions.prototype.generateOption = function (select){
      //inserir ajax com o get com as opções de ações
      var option_action = [["enviar email","send_email"],["acionar alerta","alert"],["Destriur tudo","DestroyAll"],];
      for(i = 0; i < option_action.length; i++){

            var opt = $('<option>', {
                id: "Opr"+select,
                value: option_action[i][1],
                text: option_action[i][0]
            });
            this.select_construct.append(opt);

      }
    }


    return AddActions;

});
