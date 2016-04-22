
//$(document).foundation();

$('#newContract').click(function(){
	ajaxHTML('dialog-Contract', 'contract/modal');
    showModals('dialog-Contract', cleanAddPeople);
	ajaxSelects('contract/getLanguages','try again', generalSelects, 'selectLanguage');
	ajaxSelects('contract/getSaleTypes','try again', generalSelects, 'typeSales');
});

//contracts
$('#btnCleanWord').click(function (){ document.getElementById("stringContrat").value = "";});
$('#btnfind').click(function(){getContratos();});

//Advance Search
$("#busquedaAvanazada").click(function(){ $("#avanzada").slideToggle("slow");});

(function($) {
    "use strict";
    $("[data-widget='remove']").click(function() {
        var box = $(this).parents(".box").first();
        box.slideUp();
    });
})(jQuery);

	// maxHeight = screen.height * .25;
	// maxHeight = screen.height - maxHeight;

	// dialogContract = $( "#dialog-Contract" ).dialog({
	// 	autoOpen: false,
	// 	height: maxHeight,
	// 	width: "50%",
	// 	modal: true,
	// 	dialogClass: 'dialogModal',
	// 	buttons: [
	// 		{
	// 			text: "Cancelar",
	// 			"class": 'dialogModalButtonCancel',
	// 			click: function() {
	// 				dialogContract.dialog('close');
	// 				cleanContractFields("contract");
	// 			}
	// 		},
	// 		{
	// 			text: "Guardar y cerrar",
	// 			"class": 'dialogModalButtonAccept',
	// 			click: function() {
	// 				createNewContract("contract",false)
	// 			}
	// 		},
	// 		{
	// 			text: "Guardar",
	// 			"class": 'dialogModalButtonAccept',
	// 			click: function() {
	// 				createNewContract("contract", true)
	// 			}
	// 		},
	// 	],
	// 	close: function() {
	// 		cleanContractFields("contract");
	// 	}
	// });

	// dialogTourID = $( "#dialog-tourID" ).dialog({
	// 	autoOpen: false,
	// 	height: maxHeight,
	// 	width: "40%",
	// 	modal: true,
	// 	dialogClass: 'dialogModal',
	// 	buttons: [
	// 		{
	// 			text: "Cancelar",
	// 			"class": 'dialogModalButtonCancel',
	// 			click: function() {
	// 				dialogTourID.dialog('close');
	// 			}
	// 		},
	// 		{
	// 			text: "Guardar y cerrar",
	// 			"class": 'dialogModalButtonAccept',
	// 			click: function() {
					
	// 			}
	// 		},
	// 		{
	// 			text: "Guardar",
	// 			"class": 'dialogModalButtonAccept',
	// 			click: function() {
					
	// 			}
	// 		},
	// 	],
	// 	close: function() {
	// 		//cleanContractFields("contract");
	// 	}
	// });	




function showModals(div, funcion){

	maxHeight = screen.height * .75;

	dialog = $( "#"+div ).dialog({
      autoOpen: false,
      height: maxHeight,
      width: "50%",
      modal: true,
      dialogClass: 'dialogModal',
      buttons: [
		  {
		  text: "Cancel",
		  "class": 'dialogModalButtonCancel',
		  click: function() {
			  dialog.dialog('close');
		  }
		  },
		  {
			  text: "Save and close",
			  "class": 'dialogModalButtonAccept',
			  click: function() {

			  }
		  },
		  {
			  text: "Save",
			  "class": 'dialogModalButtonAccept',
			  click: function() {
			  }
		  }
	  ],
		close: function() {
			dialog.dialog('close');
		}
    });

    dialog.dialog('open');
}

function cleanAddPeople(){
	console.log("clean form Add people");
}

function cleanAddUnidades(){
	console.log("clean form Add people");
}


function goodBye(){
	console.log("BYE");
}

function cleanContractFields(id){
	// var formData = document.getElementById(id);
 //    formData.reset();
}


function getContratos(){

	showLoading('#contracts',true);
    var filters = getFiltersCheckboxs('filtro_contrato');
    var arrayDate = ["startDateContract", "endDateContract"];
    var dates = getDates(arrayDate);
    var arrayWords = ["stringContrat"];
    var words = getWords(arrayWords);

    $.ajax({
		data:{
			filters: filters,
			dates: dates,
			words: words
		},
   		type: "POST",
       	url: "contract/getContratos",
		dataType:'json',
		success: function(data){
			showLoading('#contracts',false);
			if(data != null){
				alertify.success("Found "+ data.length);
				drawTable(data, 'getDetalleContratoByID', "details", "contracts");
			}else{
				$('#contractstbody').empty();
				alertify.error("No data found");
			}
		},
		error: function(){
			alertify.error("Try again");
		}
    });
}

function getDetalleContratoByID(i){
	console.log(i);
}

function getInputsByID(formData, divs){
	for (var i = 0; i < divs.length; i++) {
		 formData.append(divs[i], $("#"+divs[i]).val().trim()); 
	}
	return formData;	
}

function verifyInputsByID(divs){

	//var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
	for (var i = 0; i < divs.length; i++) {
		 if($('#'+divs[i]).val().trim().length > 0){
			 $('#'+divs[i]).removeClass('is-invalid-input');
		 	if(!regex.test($('#'+divs[i]).val().trim())) {
				return true;
			}
		 }else{
			 $('#'+divs[i]).addClass('is-invalid-input');
		 	return false;
		 }
	}
}


function addClassTime(div){
	$("#"+div).addClass("alertInput").delay(5000).queue(function(next){
    	$(this).removeClass("error");
    	next();
	});
}

function ajaxSelects(url,errorMsj, funcion, divSelect) {
	$.ajax({
		type: "POST",
		url: url,
		dataType:'json',
		success: function(data){
			funcion(data, divSelect);
		},
		error: function(){
			alertify.error(errorMsj);
		}
	});
}

function createNewContract(id){


	var form = $("#"+id);
	var elem = new Foundation.Abide(form, {});
	$('#'+id).foundation('validateForm');

	var tourId = $("#TourID").val().trim();
	var nombreLegal = $("#legalName").val().trim();
	var idiomaId = $( "#selectLanguage" ).val();

	
	//$('#'+id).foundation('destroy');
	//var formData = new FormData(document.getElementById(""+id));
	//legalName
	//var idioma = $("#idiomaContract").val().trim();

	var formData = new FormData(document.getElementById(id));
	formData.append("peticion", "agregarServicio");

	$.ajax({
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			type: "POST",
			dataType: "JSON",
			url: 'contract/saveContract'
		})
		.done(function( data, textStatus, jqXHR ) {
			//alertify.success(data.message);
		})
		.fail(function( jqXHR, textStatus, errorThrown ) {
			//alertify.error("Ocurrio un error vuelve a intentarlo");
		});
}
$('.tk-contact').on('submit', function () {
	$(this).on('valid', function () {});
	$(this).on('invalid', function () {});
});

function getDataFormContract(){

	var idsContract = ['legalName', 'TourID'];
	var dataContact = getWords(dataContract);
	data.selectLanguage = $( "#selectLanguage" ).val();


}

