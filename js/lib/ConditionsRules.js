
define (["jquery"],function($){

    var ConditionRules = function(seletor,data) {
      console.log(seletor);
      this.conditions = [["get_value","number"],["set_value","number"],["compare_vent","string"]];

      for(i = 0; i < this.conditions.length; i++){

              data[i] = JSON.parse(data[i]);
              // console.log(typeof data[i]);
            var opt = $('<option>', {
                "data-type" : data[i]['tipo'],
                value: data[i]['nome'],
                text: data[i]['nome_legivel']
                // "data-type" :0,
                // value: 1,
                // text: 2

            })

            seletor.append(opt);

      }

    }

      return ConditionRules;
});
