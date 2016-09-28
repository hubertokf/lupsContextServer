define (["context/ConditionsRules"], function(ConditionsRules){

    var AddActions = function (select,data,selected){
      // constroi a estrutura para seleção de ações
        this.id_select = "#"+select;
        this.select_construct = $('<select>',{
          class: "form-control select_rules_context actions",
          id: select
        }); // cira um bloco do tipo select

        this.generateOption(select,data);
        this.generateRow(this.select_construct,2,select);
        if(isNaN(selected)){ // se for umas string, seta o valor
          // console.log(JSON.stringify(selected));
            var type = $("#"+select).val(selected);
        }
    }

    AddActions.prototype.generateRow = function (select_acoes,size,select) {

      var col = $('<div>',{class: "col-md-"+size+" col-md-offset-1"});
      var diff = $('<div>',{class: "col-md-"+ (12-size)})
      col.append(select_acoes);
      $('.row.bin').append(col);
      $('.row.bin').append(diff);
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


    return AddActions;

});
