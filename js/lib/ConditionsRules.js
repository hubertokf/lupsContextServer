
define (["jquery"],function($){

    var ConditionRules = function(seletor) {

      this.conditions = [["get_value","number"],["set_value","number"],["compare_vent","string"]];
      this.id_seletor = seletor.attr('id');

      for(i = 0; i < this.conditions.length; i++){

            var opt = $('<option>', {
                id: "Opr"+this.id_seletor,
                "data-type" : this.conditions[i][1],
                value: this.conditions[i][0],
                text: this.conditions[i][0]
            })
            seletor.append(opt);

      }

    }

      return ConditionRules;
});
