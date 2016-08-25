define (["jquery","lib/selects_condition","lib/select_logic_operators","lib/input","lib/Add_actions","bootbox","lib/CreateRule"], function($,SelectCondition,LogicOperators,Inputs,AddActions,bootbox,CreateRule){

    var AddRule = function(){

        this.create_rule          = new CreateRule();
        this.iterator             = 0;
        this.button_add_condition = $("#button_add");  //pega referência do botão adiconar condição
        this.button_add_action    = $("#button_add_action"); //pega referência do botão adiconar ação
        this.button_create_rule   = $("#create_rule");
        this.data_contition;
        this.set_events(); // seta os eventos dos botões
    };
    AddRule.prototype.set_events = function(){

        // console.log(this.data_contition);
        this.button_add_condition.click(this.press_button.bind(this));
        this.button_add_action.click(this.press_button_action.bind(this));
        this.button_create_rule.click(this.press_button_create_rule.bind(this));

    }

    AddRule.prototype.press_button = function () {

        if($('#condition_label').is(':hidden')){
            $('#condition_label').show();
            }
        // console.log(this.data_contition);
        var condition      = $('<div>',{class: "row", id: "Condition"+this.iterator})
        $("#div_conditions").append(condition);
        $("#div_conditions").css({"border": "double 1px", "border-color": "red"});
        get_bd_conditions(handle_data);
        var logicOperators = new LogicOperators(this.iterator);
        // var seletor        = new SelectCondition(this.data_contition);

        var inputs         = new Inputs(this.iterator);


        this.iterator++;
    };

    AddRule.prototype.press_button_action = function () {
      if($('#action_label').is(':hidden')){
          $('#action_label').show();
          }
      var action = new AddActions(this.iterator);
      $("#div_action").append(action);
      this.iterator++;
    };

    AddRule.prototype.press_button_create_rule = function () {

      if($('#action_label').is(':hidden')){view_error("Escolha ao menos uma Ação")}
      else if($('#condition_label').is(':hidden')){view_error("Escolha ao menos uma condição")}
      else {
        this.create_rule.create_rule();
      }
    };

    var view_error = function(string) {

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
    var iterator = 0;
    function handle_data(data) {
       console.log(iterator);
      new SelectCondition(iterator,data);
      iterator++;
    }
    var get_bd_conditions= function(handle){

      $.ajax({
        type:"POST",
        dataType: 'json',
        url:window.base_url+"cadastros/CI_Regra_SB/getConditions",
        complete: function (data) {
            handle(data['responseJSON']);
         }
      });
  }
    return AddRule;

});
