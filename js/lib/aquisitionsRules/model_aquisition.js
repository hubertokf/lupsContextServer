define(["jquery","bootbox"],function($,bootbox){

  ModelAquisition = function(){
    this.select_sensor             = $("#select_sensor");
    this.parent_element            =   $("#create_aquisiton");
    this.option_generate_scheduler = {}; //contem todas as informações para da regra de aquisição, bem como infromações do sensor selecionado
    this.rules_scheduler           = {}; // objeto para criar regra de aquisição,
    this.checked_information;
  } //construtor


  ModelAquisition.prototype.get_informations= function () { //coleta informaços do view.

    var bar = {};
    this.option_generate_scheduler['value']  = this.parent_element.find(":selected").val(); //pega valor da opção de aquisição
    this.option_generate_scheduler['sensor'] = this.select_sensor.find(":selected").val(); //pega id do sensor
    this.option_generate_scheduler['data']   = this.select_sensor.find(":selected").data(); //pega os dados do sensors selecionado
    this.parent_element.find("input:checked").each(function() { //pega informações de cada checkobx selecionado e seus respectivos inputs

        var name_val         = $(this).val();
        bar[name_val]        = name_val;
        var number           = number_NaN($("#input"+name_val).val());
        bar[name_val+"text"] = number;
    });

    this.checked_information = bar;

  };
// this.object.hasOwnProperty('algo') verifica se este atributo existe, no escopo desta implemntação serve na verificação da escohla de opções temporais de agendamento

 // ------- inicio: métodos voltados para criação e edição de regras de aquisição --------
  ModelAquisition.prototype.get_selected_type_scheduler = function(){//método para verificar qual  função de agendamento foi escolhido

    var generate_open = true;
    this.get_informations();
    switch (this.option_generate_scheduler['value']) {

      case "A cada":
         if(this.checked_information.hasOwnProperty('minutes')){
           if(isNaN(this.checked_information['minutestext'])){
             generate_open = false;
             view_error("Campo 'Minutos' não preenchido")
           }
         }
         if(this.checked_information.hasOwnProperty('hours')){
           if(isNaN(this.checked_information['hourstext'])){
             generate_open = false;
             view_error("Campo 'Horas' não preenchido")
           }
         }

         if(generate_open){this.generate_rule_each()}
         break;

      case "Exatamente":
          if(this.checked_information.hasOwnProperty('minutes')){
            if(isNaN(this.checked_information['minutestext'])){
              generate_open = false;
              view_error("Campo 'Minutos' não preenchido")
            }
          }
          if(this.checked_information.hasOwnProperty('hours')){
            if(isNaN(this.checked_information['hourstext'])){
              generate_open = false;
              view_error("Campo 'Horas' não preenchido")
            }
          }
          if(this.checked_information.hasOwnProperty('days')){
            if(isNaN(this.checked_information['daystext'])){
              generate_open = false;
              view_error("Campo 'Dias' não preenchido")
            }
          }
          if(this.checked_information.hasOwnProperty('months')){
            if(isNaN(this.checked_information['monthstext'])){
              generate_open = false;
              view_error("Campo 'Meses' não preenchido")
            }
          }
          if(generate_open){
            this.generate_rule_exactly();
          }

         break;

      case "Todos os dias as":

            if(this.checked_information.hasOwnProperty('minutes')){
              if(isNaN(this.checked_information['minutestext'])){
                generate_open = false;
                view_error("Campo 'Minutos' não preenchido")
              }
            }
            if(this.checked_information.hasOwnProperty('hours')){
              if(isNaN(this.checked_information['hourstext'])){
                generate_open = false;
                view_error("Campo 'Horas' não preenchido")
              }
            }
            if(generate_open){
              this.generate_rule_everyday()}

         break;

      case "Todos os meses":
            if(this.checked_information.hasOwnProperty('minutes') && isNaN(this.checked_information['minutestext'])){
                generate_open = false;
                view_error("Campo 'Minutos' não preenchido");

            }
            else if(this.checked_information.hasOwnProperty('hours') && isNaN(this.checked_information['hourstext'])){
                generate_open = false;
                view_error("Campo 'Horas' não preenchido")
              }

            else if(this.checked_information.hasOwnProperty('days') && isNaN(this.checked_information['daystext'])){
                generate_open = false;
                view_error("Campo 'Dias' não preenchido")
              }

            if(generate_open){this.generate_rule_everymonth()}
         break;

      default:
       break;

    }
    if(generate_open){this.send_scheduler();}


  }

  ModelAquisition.prototype.generate_rule_everyday = function () {

    if(this.checked_information.hasOwnProperty('minutes')){
      this.rules_scheduler['minutes'] = String(this.checked_information['minutestext']);
    }
    else{
      this.rules_scheduler['minutes'] = "*";
    }
    if(this.checked_information.hasOwnProperty('hours')){
        this.rules_scheduler['hours'] = String(this.checked_information['hourstext']);
    }
    else{
      this.rules_scheduler['hours']   = "*";
    }
    this.rules_scheduler['days']   = "*";
    this.rules_scheduler['months'] = "*";
    // console.log(this.rules_scheduler);
  };

  ModelAquisition.prototype.generate_rule_exactly= function () {

      var date = new Date();

      if(this.checked_information.hasOwnProperty('minutes')){
        this.rules_scheduler['minutes'] = String(this.checked_information['minutestext']);
      }
      else{
        this.rules_scheduler['minutes'] = date.getMinutes(); //repensar
      }

      if(this.checked_information.hasOwnProperty('hours')){
          this.rules_scheduler['hours'] = String(this.checked_information['hourstext']);
      }
      else{
        this.rules_scheduler['hours']   = date.getHours();
      }

      if(this.checked_information.hasOwnProperty('days')){
        this.rules_scheduler['days'] = String(this.checked_information['daystext']);
      }
      else{
        this.rules_scheduler['days'] = date.getDate();
      }

      if(this.checked_information.hasOwnProperty('months')){
          this.rules_scheduler['months'] = String(this.checked_information['monthstext']);
      }
      else{
        this.rules_scheduler['months']   = date.getMonth();
      }

      // console.log(this.rules_scheduler);
  };

  ModelAquisition.prototype.generate_rule_everymonth = function () {
    if(this.checked_information.hasOwnProperty('minutes')){
      this.rules_scheduler['minutes'] = String(this.checked_information['minutestext'])
    }
    else{
      this.rules_scheduler['minutes'] = "*";
    }

    if(this.checked_information.hasOwnProperty('hours')){
        this.rules_scheduler['hours'] = String(this.checked_information['hourstext']);
    }
    else{
      this.rules_scheduler['hours'] = "*";
    }

    if(this.checked_information.hasOwnProperty('days')){
        this.rules_scheduler['days'] = String(this.checked_information['daystext'])
    }
    else{
      this.rules_scheduler['days'] = "*";
    }
    this.rules_scheduler['months'] = "*";
    // console.log(this.rules_scheduler);

  };

  ModelAquisition.prototype.generate_rule_each = function () {

    if(this.checked_information.hasOwnProperty('minutes')){
      if(60 % this.checked_information['minutestext']===0){
          i = 0;

          this.rules_scheduler['minutes']  = '';
          while((60-i*this.checked_information['minutestext']) != 0){

            this.rules_scheduler['minutes'] = this.rules_scheduler['minutes']+i*this.checked_information['minutestext']+" ";
            i++;
          }
          index = this.rules_scheduler['minutes']; //objeto não possui propriedade length, solução: passar a string para uma variável
          index = index.length; // pega o tamanho de variável

          this.rules_scheduler['minutes'] = this.rules_scheduler['minutes'].substr(0,index -1); //

      }
      else {
        this.rules_scheduler['minutes'] = "*/"+this.checked_information['minutestext']
      }
    }
    else{
      this.rules_scheduler['minutes']= "*";
    }

    if(this.checked_information.hasOwnProperty('hours')){
        this.rules_scheduler['hours'] = "*/"+this.checked_information['hourstext'];
    }
    else{
      this.rules_scheduler['hours'] = "*";
    }
    this.rules_scheduler['days']   = "*";
    this.rules_scheduler['months'] = "*";
    console.log(this.rules_scheduler);

  };

  ModelAquisition.prototype.send_scheduler = function () {
    if(this.option_generate_scheduler['sensor'] === ''){
      view_error("Sensor não selecionado");
    }
    else{
      this.option_generate_scheduler['rule'] = this.rules_scheduler;
    }
    console.log(this.option_generate_scheduler);
  };
  //--------- fim ------------------

  ModelAquisition.prototype.view_rule = function () {
    this.option_generate_scheduler['sensor'] = this.select_sensor.find(":selected").val();
    // inserir ajax
    var view_rule = construct_view_rules(this.option_generate_scheduler);
    console.log(view_rule);
     bootbox.dialog({
          message: view_rule,
          title: "Regra a ser selecionada",
            buttons: {
                success: {
                    label: "ok!!",
                    className: "btn-danger mind",

                },
              }})
              $('.modal-content').css({'background-color': '#E5E6E4','border-color':'#E5E6E4','font-weight': 'normal', 'color': '#847577', 'font-size': '20px'} );
              $(".modal-title").css({'text-align':'center','font-weight': 'bold'})
  }
var number_NaN = function(num){ // transforma string em numero, se ampo vazio retorna NaN
    if(num == ''){return NaN}
    else{return Number(num)}

}
var construct_view_rules = function (data) { // estrutura a função em um formato legíel para o usuário

   var view_rule = 'Tipo de agendamento: "'+ data['value'] +'"\n';
   var minutes   = data['rule']['minutes'];
   var hours     = data['rule']['hours'];
   var days      = data['rule']['days'];
   var months    = data['rule']['months'];


   if(minutes.length > 5){ // tam minimo para "30 60"
      var minutes_split = minutes.split(" ");
      view_rule = view_rule + "Minutos: " + minutes_split[1] +"\n";
   }
   else if(minutes.length >= 3 && minutes.length <= 4){
       view_rule = view_rule + "Minutos: " + minutes.substr(2,minutes.length) +"\n";
   }
   else if(minutes === "*"){
      view_rule = view_rule + "Minutos: De minuto em Minuto\n";
   }
   else{
      view_rule = view_rule + "Minutos: " + minutes +"\n";
   }
   if(hours.length >= 3 && hours.length <= 4){
       view_rule = view_rule + "Horas: " + hours.substr(2,hours.length) +"\n";
   }
   else if(hours === "*"){
      view_rule = view_rule + "Horas: De hora em hora\n";
   }
   else{
      view_rule = view_rule + "Horas: " + hours +"\n";
   }
  if(days === "*"){
      view_rule = view_rule + "Horas: Todo os dias \n";
   }
   else{
      view_rule = view_rule + "Horas: " + days +"\n";
   }
   if(months === "*"){
      view_rule = view_rule + "Dia: Todo os meses\n";
   }
   else{
      view_rule = view_rule + "Mês: " + months +"\n";
   }
   view_rule = view_rule.replace(/\n/g, "<br />");

   return view_rule;
}
var view_error = function(string){
    bootbox.dialog({
         message: string,
         title: "Cuidado",
           buttons: {
               success: {
                   label: "ok!!",
                   className: "btn-danger",

               },
             }}).find('.modal-content').css({'background-color': '#fcf8e3','border-color':'#faebcc', 'font-weight' : 'bold', 'color': '#8a6d3b', 'font-size': '2em', 'font-weight' : 'bold'} );

  }

  return ModelAquisition;
}) // função que apresenta uma informação visual sobre algum erro
