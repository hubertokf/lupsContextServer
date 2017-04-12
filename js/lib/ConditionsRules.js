
define (["jquery"],function($){

    var ConditionRules = function(seletor,data) {
      var opt_base = $('<option value selected disabled>Selecione</option>');
      seletor.append(opt_base);
      // console.log(data);
      for(i = 0; i < Object.keys(data).length; i++){

              if(typeof data[i] === "string"){
                data[i] = JSON.parse(data[i]);
              }
                // console.log(data[i]['sensor']);
                var opt = $('<option>', {
                "data-type" : data[i]['tipo'],
                "data-url": data[i]['url'],
                "data-name": data[i]['nome'],
                value: data[i]['sensor']+"|"+data[i]['nome'],
                text: data[i]['nome_legivel']

            })

            seletor.append(opt);
      }

    }
      return ConditionRules;
});
