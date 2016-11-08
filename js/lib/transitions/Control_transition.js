define (["transitions/CreateRules","transitions/HanleSelections","transitions/ClassHTML"], function(CreateRules,HanleSelections,ClassHTML){

    var ControlTransition = function () {

        this.create_rules            = new CreateRules();
        this.handle_selections       = new HanleSelections();
        this.obj_html                = new ClassHTML();
        this.button_create_send_rule = $("#submit_rules_transition"); // botão de criação de envio da regra.
        this.set_events();
    }
    ControlTransition.prototype.set_events = function () {

        this.button_create_send_rule.click(this.press_button.bind(this));
        this.handle_selections.set_events();

    };

    ControlTransition.prototype.press_button = function () {
        var obj_html = this.obj_html.get_values_html();
        this.create_rules.construct_rule(obj_html);
        this.create_rules.invert_operator("greater_than");
        // this.create_rules.send_rule();
      };

    return ControlTransition;

});
