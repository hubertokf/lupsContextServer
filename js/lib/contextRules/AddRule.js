define (["jquery","context/selects_condition","context/select_logic_operators","context/input","context/Add_actions","bootbox","context/CreateRule","context/ButtonRemove"], function($,SelectCondition,LogicOperators,Inputs,AddActions,bootbox,CreateRule,ButtonRemove){

    var set_button_logic     = false; //resposnável por instanciar a primeira condição se, o botão de operadores logicos
    var path                 = window.location.pathname.split('/');
    var AddRule = function(){
        // console.log(window.location.pathname.split('/'));
        this.controller_conditition = 0; // controla quantas condiçoes podem ser instanciadas
        this.create_rule          = new CreateRule();
        this.iterator             = 0;
        this.button_add_condition = $("#button_add");  //pega referência do botão adiconar condição
        this.button_add_action    = $("#button_add_action"); //pega referência do botão adiconar ação
        this.button_create_rule   = $("#create_rule");
        this.data_contition;
        if($("#editable").val()=== "true"){
            this.setDOM();
        }
        this.set_events(); // seta os eventos dos botões
    };
    AddRule.prototype.set_events = function(){ //seta eventos da pagina,

        // console.log(this.data_contition);
        this.button_add_condition.click(this.press_button.bind(this));
        this.button_add_action.click(this.press_button_action.bind(this));
        this.button_create_rule.click(this.press_button_create_rule.bind(this));
        this.checkbox_group()

    }

    AddRule.prototype.press_button = function () {

          if(this.controller_conditition <= 5){
            if($('#condition_label').is(':hidden')){
                $('#condition_label').show();
                $('#sub_labels').show();
                }
            var condition         = $('<div>',{class: "row", id: "Condition"+this.iterator})
            $("#div_conditions").append(condition);
            // $("#div_conditions").css({"border": "double 1px", "border-color": "red"});
            get_bd_conditions(handle_data_condition);
            var logicOperators    = new LogicOperators(this.iterator,set_button_logic);
            set_button_logic      = true;
            this.iterator++;
            iterator_condition++;
            iterator_action++;
            this.controller_conditition++;
          }
    };

    AddRule.prototype.press_button_action = function () {
      if($('#action_label').is(':hidden')){
          $('#action_label').show();
      }
      get_bd_action(handle_data_action);
    };

    AddRule.prototype.press_button_create_rule = function () {

        this.create_rule.create_rule();

    };

    AddRule.prototype.checkbox_group = function () {
      $("#box_group_rules").click(function () {
          // console.log("ok");
          if($(this).is(":checked")){
              $("#button_condition_action").hide();
              $("#group_rule").show();
              $("#label_name_rule").html("Nome do Grupo");
          }
          else{
              $("#button_condition_action").show();
              $("#group_rule").hide();
              $("#label_name_rule").html("Nome da regra");

          }
      })
    };

    AddRule.prototype.setDOM = function () {
      set_button_logic = true;
      $("#name_rule").val($("#editable_ruler_name").val());
      $("#name_rule").prop("disabled","true");
      var sensor = $("#editable_sensor_chose").val();
      $("#sensors").val(sensor);
      $("#sensors").prop("disabled","true");
      get_information_editable(handle_edit);
    };

    var iterator_condition   = 0;
    var iterator_action      = 0;

    function handle_data_condition(data) {
      // console.log(iterator_condition);
      new SelectCondition(iterator_condition-1,data);
      new Inputs(iterator_condition-1);
      new ButtonRemove(iterator_condition-1);
      // iterator_condition++;
    }

    function handle_data_action(data) {
      var action = new AddActions(iterator_action,data);
      $("#div_action").append(action);
      iterator_action++;
    }

    var get_bd_conditions= function(handle){
      $.ajax({
        type:"POST",
        dataType: 'json',
        url:window.base_url+"cadastros/"+path[3]+"/getConditions",
        complete: function (data) {
          // console.log(data['responseJSON']);
            handle(data['responseJSON']);
         }
      });
    }

    var get_bd_action = function(handle_act) {
      $.ajax({
        type:"POST",
        dataType: 'json',
        url:window.base_url+"cadastros/"+path[3]+"/getActions",
        complete: function (data) {
            handle_act(data['responseJSON']);
          }
        });

      }

    var get_information_editable = function (handle_edit) {
      var index      = {};
      index['index'] = $("#editable_id_rule").val();
      $('#condition_label').show();
      $.ajax({
        type:"POST",
        data: index,
        dataType: 'json',
        url:window.base_url+"cadastros/"+path[3]+"/sendInformation",
        complete: function (information) {
          console.log(JSON.stringify(information['responseJSON']));
          handle_edit(information['responseJSON']);
        }
    });

  }
  function handle_edit(data) {
    var iterator        = 0;
    var iterator_action = 0;
    var e;
    var option_select_condition = data['condictions']; // informações para construição do  seletor de condições
    var option_select_action    = data['action'];
    var rules                   = JSON.parse(data['rule']);
    rule                        = rules[0]['conditions']['any'];
    // console.log(option_select_condition);
    for(i = 0; i < Object.keys(option_select_condition).length; i++){
      option_select_condition[i] = JSON.parse(option_select_condition[i]);
    }
    for (var i = 0; i < rule.length; i++){
      e  = "ed-"+iterator;
      if(rule[i].hasOwnProperty('all')){ // verifica se o elemento i do vetor base é um vetor tipo e
        var all = rule[i]['all'];
        var enable_logic;
        if(i==0){
          enable_logic = false;
        }
        else{
          enable_logic = true;
          }
          var objetc_condition = all[0]; // pega o primeiro obj do vetor
          var condition_div = $('<div>',{class: "row", id: "Condition"+e})
          $("#div_conditions").append(condition_div);
          //processo de setagem dos parametros
          new LogicOperators(e,enable_logic,'any'); // cria e seta botão de seleção de operadores logicos
          new SelectCondition(e,option_select_condition,objetc_condition['parameters']['sensor']+"|"+objetc_condition['name'],objetc_condition['operator']);
          new Inputs(e,objetc_condition['value']); //cria e set os valores de input
          if(i != 0){ // caso seja a primeira inserçã no DOM, botão de remover não sera inserido
          new ButtonRemove(e); // cria botão de remover
          }
          // console.log(typeof option_select_condition[0]);
          iterator++;
          e  = "ed-"+iterator;

          for(var j = 1 ; j< all.length; j++){
              objetc_condition = all[j];
              var condition_div = $('<div>',{class: "row", id: "Condition"+e})
              $("#div_conditions").append(condition_div);
              new LogicOperators(e,true,'all');
              new SelectCondition(e,option_select_condition,objetc_condition['parameters']['sensor']+"|"+objetc_condition['name'],objetc_condition['operator']);
              new Inputs(e,objetc_condition['value']);
              new ButtonRemove(e);
              iterator++;
              e  = "ed-"+iterator;
          }

      }
      else{
        var enable_logic
        if(i==0){
            enable_logic = false;
        }
        else{
            enable_logic = true;
        }
        var objetc_condition = rule[i]; // pega o  obj do vetor base
        var condition_div = $('<div>',{class: "row", id: "Condition"+e})
        $("#div_conditions").append(condition_div);

        new LogicOperators(e,enable_logic,'any');
        new SelectCondition(e,option_select_condition,objetc_condition['parameters']['sensor']+"|"+objetc_condition['name'],objetc_condition['operator']);
        new Inputs(e,objetc_condition['value']);
        new ButtonRemove(e);
        iterator++;
        e  = "ed-"+iterator;
      }
    }

    $('#action_label').show();
    var rules = JSON.parse(data['rule']);
    e        = "ed"+iterator_action;
    rules    = rules[0]['actions'];

    for (var i = 0; i < rules.length; i++) {
      console.log(rules[i]);
      var action = new AddActions(e,option_select_action,rules[i]['name'],rules[i]['params'],rules[i]['params']);
      $("#div_action").append(action);
      iterator_action++;
      e = "ed"+iterator_action;
    }
  }
    return AddRule;

});
