define(["aquisitionsRules/sensors","aquisitionsRules/create_sched","aquisitionsRules/type_of_scheduler","aquisitionsRules/checkbox","aquisitionsRules/model_aquisition","jquery"],function(Sensors,CreateSchedulerOptions,TypeOfScheduler,CheckBoxs,ModelAquisition,$){
 // as eventos setados pelas tag select estão em suas respectivas classes
    var ControllerAquisition = function(){

      this.get_has_scheduler;
      this.has_scheduler = true; // true se a pessoa vai gerar uma nova regra, false se a pessoa vai pegar uma regra já existente referente ao sensor x
      //inerir new sensor no ajax.Este ajax pega como parametro, um vetor com os sensores
      new Sensors();

      this.model             = new ModelAquisition();
      this.buttons           = new CreateSchedulerOptions();
      this.checkboxs         = new CheckBoxs();
      this.type_of_scheduler = new TypeOfScheduler();
      this.set_events_buttons();

    }


ControllerAquisition.prototype.set_events_buttons = function () {

         this.buttons.button_create.click(this.press_button_create_scheduler.bind(this));
         this.buttons.button_get.click(this.press_button_get_scheduler.bind(this));
         this.buttons.send_scheduler.click(this.press_button_send.bind(this));
        //  this.buttons.button_view.click(this.press_button_view.bind(this));
         this.checkboxs.check_minutes.click(this.verify_check.bind(this));
         this.checkboxs.check_hours.click(this.verify_check.bind(this));
         this.checkboxs.check_days.click(this.verify_check.bind(this));
         this.checkboxs.check_months.click(this.verify_check.bind(this));

};

ControllerAquisition.prototype.press_button_create_scheduler = function () { //pega evento do botão criar agendamento
     this.get_has_scheduler = true;
     this.type_of_scheduler.select_type.show(); // mostra a opção de seleção dos tipos de agendamento
};

ControllerAquisition.prototype.press_button_get_scheduler = function () {
    this.get_has_scheduler = false;
    //método para coletar regra exixtente --> passar como referencia id do sensor
    this.super_hide();

};

ControllerAquisition.prototype.press_button_send = function () {
    if(this.get_has_scheduler){

      this.model.get_selected_type_scheduler(); // tem_que_dar nome ao agendamento, interessante id + nome da pessoa

    }
    else{
      this.get_has_scheduler;
      //método para regra antiga -- gerar um id especifico para o usuário
    }
};

ControllerAquisition.prototype.verify_check = function () {
        if (this.checkboxs.check_minutes.is(':checked')) {
            this.checkboxs.input_minutes.show();
        }

        else{
         this.checkboxs.input_minutes.hide();

        }
        if (this.checkboxs.check_hours.is(':checked')) {
          this.checkboxs.input_hours.show();
        }

        else{
          this.checkboxs.input_hours.hide()
        }
        if (this.checkboxs.check_days.is(':checked')) {
          this.checkboxs.input_days.show();
        }

        else{
          this.checkboxs.input_days.hide();
        }
        if (this.checkboxs.check_months.is(':checked')) {
          this.checkboxs.input_months.show();
        }

        else{
          this.checkboxs.input_months.hide()
        }
};
// ControllerAquisition.prototype.press_button_view = function () {
//         this.model.view_rule();
//   };
ControllerAquisition.prototype.super_hide = function () {
  this.checkboxs.label_minutes.hide();
  this.checkboxs.label_hours.hide();
  this.checkboxs.label_days.hide();
  this.checkboxs.label_months.hide();
  this.type_of_scheduler.select_type.hide();
  this.checkboxs.input_minutes.hide()
  this.checkboxs.input_hours.hide()
  this.checkboxs.input_days.hide();
  this.checkboxs.input_months.hide()

}

    return ControllerAquisition;
})
