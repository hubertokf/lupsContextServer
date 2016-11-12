define(["jquery"],function($){

  var ButtonRemove =  function(iterator){
    var insert_icon    = $('<i>',{class: "fa fa-times fa-2x"});
    this.button_remove = $('<a>',{class:"botaoExcluir remove",id: "exc"+iterator});
    this.div_col       = $('<div>',{class: "col-md-1",id: "mid"+iterator})
    this.button_remove.append(insert_icon);
    // console.log(iterator != "ed-0",iterator);
    if((iterator > 0) || (iterator != "ed-0")){
      this.div_col.append(this.button_remove);
    }
    $('#Condition'+iterator).append(this.div_col);
    this.set_events();
  }

  ButtonRemove.prototype.set_events = function () {
    this.button_remove.click(function () {
      $(this).parent().parent().remove();
    })
  };
  return ButtonRemove;
})
