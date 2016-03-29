	$(document).ready(function(){
		$('#dt-inicio').datetimepicker({
			dateFormat: "yy-mm-dd",
		    onClose: function(dateText, inst) {
		        var endDateTextBox = $('#dt-final');
		        if (endDateTextBox.val() != '') {
		            var testStartDate = new Date(dateText);
		            var testEndDate = new Date(endDateTextBox.val());
		            if (testStartDate > testEndDate) {
		                endDateTextBox.val(dateText);
	               }
		        }
		        else {
		            endDateTextBox.val(dateText);
		        }
		    },
		    onSelect: function (selectedDateTime){
		        var start = $(this).datetimepicker('getDate');
		        var end = $('#dt-final').val();
		        
		        if (end != "") {
		        	var arrEnd = end.split(' ');
		        	var arrDate = arrEnd[0].split('-');
		        	var formatedDate = arrDate[1] + '-' + arrDate[0] + '-' + arrDate[2] + ' ' + arrEnd[1];
		        	var dateEnd = new Date(formatedDate);
			
			        if (start > dateEnd) {
				        $('#dt-final').val(selectedDateTime);
			        	$('#dt-final').datetimepicker('option', 'minDate', new Date(start.getTime()));
					}
		        }
		    }
		});
				
		$('#dt-final').datetimepicker({
			dateFormat : "yy-mm-dd",
		    onClose: function(dateText, inst) {
		        var startDateTextBox = $('#dt-inicio');
		        if (startDateTextBox.val() != '') {
		            var testStartDate = new Date(startDateTextBox.val());
		            var testEndDate = new Date(dateText);
		            if (testStartDate > testEndDate) {
		                startDateTextBox.val(dateText);
		        	}
		        }
		        else {
		            startDateTextBox.val(dateText);
		        }
		    },
		    onSelect: function (selectedDateTime){
		        var end = $(this).datetimepicker('getDate');
		        var start = $('#dt-final').val();
		        
		        if (start != "") {
		        	var arrStart = start.split(' ');
		        	var arrDate = arrStart[0].split('-');
		        	var formatedDate = arrDate[1] + '-' + arrDate[0] + '-' + arrDate[2] + ' ' + arrStart[1];
		        	var dateStart = new Date(formatedDate);
			
			        if (start > dateStart) {
				        $('#dt-inicio').val(selectedDateTime);
			        	$('#dt-inicio').datetimepicker('option', 'minDate', new Date(start.getTime()));
					}
		        }
		    }
		});

  $('#dt-coleta').datetimepicker({
      dateFormat: "yy-mm-dd",
        onClose: function(dateText, inst) {
            var endDateTextBox = $('#dt-coleta');
            if (endDateTextBox.val() != '') {
                var testStartDate = new Date(dateText);
                var testEndDate = new Date(endDateTextBox.val());
                if (testStartDate > testEndDate) {
                    endDateTextBox.val(dateText);
                 }
            }
            else {
                endDateTextBox.val(dateText);
            }
        },
        onSelect: function (selectedDateTime){
            var start = $(this).datetimepicker('getDate');
            var end = $('#dt-publicacao').val();
            
            if (end != "") {
              var arrEnd = end.split(' ');
              var arrDate = arrEnd[0].split('-');
              var formatedDate = arrDate[1] + '-' + arrDate[0] + '-' + arrDate[2] + ' ' + arrEnd[1];
              var dateEnd = new Date(formatedDate);
      
              if (start > dateEnd) {
                $('#dt-coleta').val(selectedDateTime);
                $('#dt-coleta').datetimepicker('option', 'minDate', new Date(start.getTime()));
          }
            }
        }
    });
        
    $('#dt-publicacao').datetimepicker({
      dateFormat : "yy-mm-dd",
        onClose: function(dateText, inst) {
            var startDateTextBox = $('#dt-publicacao');
            if (startDateTextBox.val() != '') {
                var testStartDate = new Date(startDateTextBox.val());
                var testEndDate = new Date(dateText);
                if (testStartDate > testEndDate) {
                    startDateTextBox.val(dateText);
              }
            }
            else {
                startDateTextBox.val(dateText);
            }
        },
        onSelect: function (selectedDateTime){
            var end = $(this).datetimepicker('getDate');
            var start = $('#dt-coleta').val();
            
            if (start != "") {
              var arrStart = start.split(' ');
              var arrDate = arrStart[0].split('-');
              var formatedDate = arrDate[1] + '-' + arrDate[0] + '-' + arrDate[2] + ' ' + arrStart[1];
              var dateStart = new Date(formatedDate);
      
              if (start > dateStart) {
                $('#dt-publicacao').val(selectedDateTime);
                $('#dt-publicacao').datetimepicker('option', 'minDate', new Date(start.getTime()));
          }
            }
        }
    });
	});