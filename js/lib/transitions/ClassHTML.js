define([], function(){

  var ClassHTML = function() {

    this.objs_html                     = {};
    this.objs_html["array_rules"]      = [];
    this.objs_html["condition_status"] = {};
    this.objs_html["condition_time"]   = {};
  }

  ClassHTML.prototype.get_values_html = function () {

      var params                       = {};
      var array_rules                  = [];
      this.objs_html["name_rule"]      = $('#name_rule').val();
      this.objs_html["sensor_trigger"] = $('#sensors').val();
      this.objs_html["status_trigger"] = $('#box_status_rules').is(':checked');

      $(".ciSensorList > li").each(function () {
        array_rules.push($(this).data('id'));
      });

      this.objs_html["array_rules"]                  =  array_rules;
      this.objs_html["condition_status"]["name"]     = $("#select_value_sensor").find(":selected").data("name");
      this.objs_html["condition_status"]["operator"] = $("#compare_transition_status").find(":selected").val();
      this.objs_html["condition_status"]["value"]    = $("#input_status").val();
      params["uuid"] = $("#select_value_sensor").find(":selected").val();
      this.objs_html["condition_status"]["params"]   = params;

      params  = {};
      params['type_time']  = $("#select_type_time").find(":selected").val();
      this.objs_html["condition_time"]["params"]   = params;
      this.objs_html["condition_time"]["name"]     = $("#select_type_time").find(":selected").data("name");;
      this.objs_html["condition_time"]["operator"] = $("#compare_transition_time").find(":selected").val();
      this.objs_html["condition_time"]["value"]    = $("#input_status").val();

      console.log(this.objs_html);
      return null;

  };

 return ClassHTML;

});
