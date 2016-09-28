define(["jquery"], function($){

    var Sensors = function(){
      // this.select_sensor = $("#select_sensors");
      // this.createOption();
      this.set_events();
      this.information = {};
    }

  //   Sensors.prototype.createOption = function() {
  //     //
  //     var option_sensors = [["SensorLups1",18,"10.1.1.1",true, '{minutes: "*" , hour: "2"}'],["SensorLups2",18,"10.1.1.2",true, '{minutes: "*", hour: "2"}'],["SensorLups3",18,"10.1.1.3",false, null],["SensorLups4",18,"10.1.1.4",true, '{minutes: "5", hour: "*"}']];
  //     for(i = 0; i < option_sensors.length ; i++){
  //       //Segunda ideia: enviar o id do sensor para o back, lá verifica a borda e a regra
  //       var option = $('<option>',{ text: option_sensors[i][0],
  //                                   "fata-id-sensor": option_sensors[i][1],
  //                                   // "data-Borda": option_sensors[i][2],
  //                                   "data-have_rule": option_sensors[i][3],
  //                                   // "data-rule": option_sensors[i][4]
  //       });
  //
  //     $('#select_sensors').append(option);
  //     }
  // }

    Sensors.prototype.set_events = function () {
          $('#select_sensors').change(function() {
              //  var selected = $(this).find(':selected').data();
               var selected_value = $(this).find(':selected').val();
               $.ajax({
                 type:"POST",
                 data: {id_sensor:selected_value},
                 dataType: 'json',
                 url:window.base_url+"cadastros/CI_Regra_Aquisicao/get_rules_names",
                 complete: function (response) {
                   $("#select_rules").empty();
                   $("#select_rules").append($('<option value selected disabled>Selecione</option> '));
                    if(response['responseJSON'].length === 0){
                        $("#alert_sensor").hide();
                    }

                    else{
                      $("#alert_sensor").show();

                      for (var i = 0; i < response['responseJSON'].length; i++) {
                          var opt = $('<option>',{value:response['responseJSON'][i]['regra_id'] ,text:response['responseJSON'][i]['nome']});
                          $("#select_rules").append(opt);
                      }
                    }

                  }
               });

          });
    };

    return Sensors;
});
