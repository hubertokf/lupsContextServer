define(["jquery"], function($){

    var Sensors = function(){
      this.select_sensor = ("#select_sensors");
      this.createOption();
      this.set_events();
      this.information = {};
    }

    Sensors.prototype.createOption = function() {
      //inserir aqui ajax get_ nomes dos sensores,id dos mesmos, bordas vinculadas, se há regras vinculadas e  as regras de aquisição
      var option_sensors = [["SensorLups1",18,"10.1.1.1",true, '{minutes: "*" , hour: "2"}'],["SensorLups2",18,"10.1.1.2",true, '{minutes: "*", hour: "2"}'],["SensorLups3",18,"10.1.1.3",false, null],["SensorLups4",18,"10.1.1.4",true, '{minutes: "5", hour: "*"}']];
      for(i = 0; i < option_sensors.length ; i++){
        //Segunda ideia: enviar o id do sensor para o back, lá verifica a borda e a regra
        var option = $('<option>',{ text: option_sensors[i][0],
                                    "fata-id-sensor": option_sensors[i][1],
                                    "data-Borda": option_sensors[i][2],
                                    "data-have_rule": option_sensors[i][3],
                                    "data-rule": option_sensors[i][4]
        });

      $('#select_sensors').append(option);
      }
  }

    Sensors.prototype.set_events = function () {
          $('#select_sensors').change(function() {
               var selected = $(this).find(':selected').data();
               var selected_value = $(this).find(':selected').val();

              if(selected['have_rule']){
                 $("#alert_sensor").show();
                 $(".button_rule.visible").show();
              }
              else{
                $("#alert_sensor").hide();
                $(".button_rule.visible").hide();
              }

          });
    };

    return Sensors;
});
