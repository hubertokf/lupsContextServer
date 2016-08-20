define(["jquery","aquisitionsRules/checkbox"], function($,CheckBoxs){

     var TypeOfScheduler = function() {
        this.check       = new CheckBoxs();
        this.select_type = $("#select_aquisiiton");
        this.setOptions();
        this.set_events();

     }

     TypeOfScheduler.prototype.setOptions = function () {
       var option_sensors = [["De x em x"],["A cada"],["Exatamente"],["Todos os dias as"],["Todos os meses"]];
       for(i = 0; i < option_sensors.length ; i++){
         //Segunda ideia: enviar o id do sensor para o back, lá verifica a borda e a regra
         var option = $('<option>',{ text: option_sensors[i][0],
                                     value: option_sensors[i][0],
         });

        this.select_type.append(option);
     };
};

     TypeOfScheduler.prototype.set_events = function () {

       var minutes       = this.check.label_minutes;
       var hours         = this.check.label_hours;
       var days          = this.check.label_days;
       var months        = this.check.label_months;
       var input_minutes = this.check.input_minutes;
       var input_hours   = this.check.input_hours;
       var input_days    = this.check.input_days;
       var input_months  = this.check.input_months;

       this.select_type.change(function () {

           var  infomarion = $(this).find(":selected").val();

           var input_hide = function(){
             days.hide();
             months.hide();
             input_minutes.hide();
             input_hours.hide();
             input_days.hide();
             input_months.hide();
             input_minutes.val('');
             input_hours.val('');
             input_days.val('');
             input_months.val('');
             $( "input[type='checkbox']" ).prop('checked',false);

           }


           switch (infomarion) {

             case "A cada":
                input_hide();
                minutes.show();
                hours.show();



                break;
             case "Exatamente":
                input_hide();
                minutes.show();
                hours.show();
                days.show();
                months.show();
                break;
             case "Todos os dias as":
                input_hide();
                minutes.show();
                hours.show();


                break;
             case "Todos os meses":
                input_hide();
                minutes.show();
                hours.show();
                days.show();

                break;

             default:
              break;

           }
       });
     };


     return TypeOfScheduler;
});
