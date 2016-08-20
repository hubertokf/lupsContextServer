define(["jquery"],function($){

    var CheckBoxs = function () {

      this.label_minutes = $("#labelminutes");
      this.label_hours   = $("#labelhour");
      this.label_days    = $("#labelday");
      this.label_months  = $("#labelmonth");
      this.check_minutes = $("#checkminutes");
      this.check_hours   = $("#checkhour");
      this.check_days    = $("#checkday");
      this.check_months  = $("#checkmonth");

      this.input_minutes = $("#inputminutes");
      this.input_hours   = $("#inputhours");
      this.input_days    = $('#inputdays');
      this.input_months  = $('#inputmonths');
    }

    return CheckBoxs;
})
