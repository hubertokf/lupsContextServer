define([], function(){
  var i = 0;
  var HandleSelections = function() {
    this.teste;
  }
  HandleSelections.prototype.set_events = function () {
    this.verify_checked_box();
    // this.remove_rule();
    // this.add_rule();
  };

  // HandleSelections.prototype.add_rule = function () {
  //   $("#new_rule").click(function () {
  //       $("#init").clone().appendTo(".cadastro-box");
  //       $(".cadastro-box > #init").show();
  //       $(".cadastro-box > #init").attr("id","rule"+i)
  //       i++
  //       console.log("OK");
  //   })
  // };
  //
  // HandleSelections.prototype.remove_rule = function () {
  //
  //   $('.cadastro-box').on('click', 'div.purge', function(){
  //     console.log("earaeraer");
  // 		$(this).parent().parent().remove();
  //   });
  //
  // };

  HandleSelections.prototype.verify_checked_box = function () {

    $("#has_value").click(function () {
      console.log("llll");
      if($(this).is(":checked")){
        $(".status").show()
      } else {
        $(".status").hide();
        $("#input_status").val("");
        $("#compare_transition_status").val("greater_than");
        $("#select_value_sensor").val("pin");
      }
    });

    $("#has_time").click(function () {
      if($(this).is(":checked")){
        $(".time").show()
      } else {
        $(".time").hide();
        $("#input_time").val("");
        $("#compare_transition_time").val("greater_than");
        $("#select_type_time").val("");
      }
    })
  };
 return HandleSelections;

});
