
define (["jquery"],function($){

    var ConditionRules = function(seletor,data) {
      var opt_base = $('<option value selected disabled>Selecione</option>');
      seletor.append(opt_base);

      for(i = 0; i < Object.keys(data).length; i++){

            data[i] = JSON.parse(data[i]);
            var opt = $('<option>', {
                "data-type" : data[i]['tipo'],
                value: data[i]['nome'],
                text: data[i]['nome_legivel']

            })

            seletor.append(opt);
      }
    }
      return ConditionRules;
});
