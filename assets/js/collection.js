/**
* @fileoverview Funciones del screen inventory (alta/editar/busqueda)
*
* @author Alfredo Chi
* @version 0.1
*/

var maxHeight = 400;
var xhrInventary = null;

/**************Index****************/

//busqueda Detailed Availability
$('#btnCollSearch').off();
$('#btnCollSearch').on('click', function() {  getCollection(0); });

/************Funciones**************/

/**
* Carga las opciones que se inicializan cuando entran a la pagina
*/
$(document).ready(function() {
	
	maxHeight = screen.height * .25;
	maxHeight = screen.height - maxHeight;
	
	var editColletionDialog = modalEditColletion(0);
	
	//alertify.success("Found "+ 50);
	$( "#DueDateColl, #PastDueDateColl, #NextIntDateColl" ).Zebra_DatePicker({
		format: 'm/d/Y',
		show_icon: false,
	});
	
	//$('#textInvStartDate').val(getCurrentDate())
});

function modalEditColletion(id){
	
	showLoading('#dialog-Edit-colletion',true);
	dialogo = $("#dialog-Edit-colletion").dialog ({
  		open : function (event){
			$(this).load("collection/modalEdit?id="+id , function(){
				
			});
	    	/*$(this).load("reservation/modalEdit?id="+id , function(){
	 			showLoading('#dialog-Edit-Reservation',false);
	 			getDatosReservation(id);
	 			setEventosEditarReservation(id);
	    	});*/
		},
		autoOpen: false,
     	height: maxHeight,
     	width: "50%",
     	modal: true,
     	buttons: [
     // 	{
	    //    	text: "Cancel",
	    //    	"class": 'dialogModalButtonCancel',
	    //    	click: function() {
	    //      	$(this).dialog('close');
	    //    }
	   	// },
	   	{
       		text: "Close",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			$(this).dialog('close');
       		}
     	}],
     close: function() {
    	$('#dialog-Edit-colletion').empty();
     }
	});
	return dialogo;
	
}

function getCollection(){
	noResults('#section-Colletion',false);
	showLoading('#section-Colletion',true);
    var arrayDate = ["DueDateColl", "PastDueDateColl", "NextIntDateColl"];
    var dates = getDates(arrayDate);
    var arrayWords = ["TrxIdColl", "FolioColl", "TrxAmtColl", "AsignedToColl"];
    var words = getWords(arrayWords);
	var arrayOption = ["TrxTypeColl", "AccTypeColl", "StatusColl"];
    var options = getWords(arrayOption);
	$.ajax({
		data:{
			dates: dates,
			words: words,
			options: options
		},
   		type: "POST",
       	url: "collection/getCollection",
		dataType:'json',
		success: function(data){
			if( data.items.length > 0 ){
				alertify.success("Found "+ data.items.length);
				drawTable2(data.items,"tableColletion","getColletionById","editColletion");
			}else{
				noResultsTable("section-Colletion", "tableColletion", "no results found");
			}
			showLoading('#section-Colletion',false);
		},
		error: function(){
			noResultsTable("section-Colletion", "tableColletion", "Try again");
			showLoading('#section-Colletion',false);
		}
    });
}

function getColletionById(id){
	var editColletionDialog = modalEditColletion(id);
	editColletionDialog.dialog("open");
}
