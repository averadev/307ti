getContratos();

$(document).foundation();
$('#newContract').click(function(){ showModals('dialog-Contract', cleanAddPeople); });
$('#btnAddTourID').click(function(){ showModals('dialog-casa', cleanAddPeople); });
$('#btnAddPeople').click(function(){showModals('dialog-Personas', cleanAddPeople);});
$('#btnAddUnidades').click(function(){showModals('dialog-Unidades', cleanAddUnidades);});
$('#btnCleanWord').click(function () {
	document.getElementById("stringContrat").value = "";
});
$('#btnfind').click(function(){
	getContratos();
});

/*(function($) {
    "use strict";

    $("[data-widget='collapse']").click(function() {
        //Find the box parent        
        var box = $(this).parents(".box").first();
        //Find the body and the footer
        var bf = box.find(".box-body, .box-footer");
        if (!box.hasClass("collapsed-box")) {
            box.addClass("collapsed-box");
            bf.slideUp();
        } else {
            box.removeClass("collapsed-box");
            bf.slideDown();
        }
    });

})(jQuery);*/

(function($) {
    "use strict";
    $("[data-widget='remove']").click(function() {
        var box = $(this).parents(".box").first();
        box.slideUp();
    });
})(jQuery);


$(function(){
$("#busquedaAvanazada").click(function(){
        $("#avanzada").slideToggle("slow");
    });

	


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
});

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


function createNewContract(id){

	var formData = new FormData(document.getElementById("saveDataContract"));
	//legalName
	var idioma = $("#idiomaContract").val().trim();

	var formData = new FormData(document.getElementById(id));
    formData.append("peticion", "agregarServicio");

    $.ajax({
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        type: "POST",
        dataType: "JSON",
        url: ""
    })
        .done(function( data, textStatus, jqXHR ) {
            //alertify.success(data.message);
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            //alertify.error("Ocurrio un error vuelve a intentarlo");
        });
}

function EnviaFormularioCliente(id){
	//var formData = new FormData(document.getElementById("contract"));
    //formData.append("peticion", "agregarServicio");

    var formData = new FormData(document.getElementById("saveDataContract"));

    //formData.append("IDpersona", 12345);
    //var divs = ["contractR", "precioUNITY"];
    //form = getInputsByID(formData, divs)
	$.ajax({
		data:formData,
   		type: "POST",
   		cache: false,
   		processData: false,
       	url: "contract/saveContract",
		dataType:'json',
		contentType: false,
		
		success: function(data){
			//console.log("dta"+data);
		},
		error: function(){

		}
	});	
}


function getContratos(){

    var arrayFilters = ["filtro_contrato"];
    var filters = getFilters(arrayFilters);
    var arrayDate = ["startDate", "endDate"];
    var dates = getDates(arrayDate);
    var arrayWords = ["stringContrat"];
    var words = getWords(arrayWords);
    showLoading("#tblContratosbody", true);

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
			if(data != null){
				alertify.success("Found "+ data.length);
				drawTable(data, 'getDetalleContratoByID', "details");
                $("#tblContrat").DataTable();
                //tablas("tblContrat");
			}else{
				alertify.error("No data found");
				showLoading("#tblContratosbody", false);
			}
		},
		error: function(){

		}
    });
}

function tablas(tabla){
    $('#'+tabla).DataTable({
        "dom": 'T<"clear">lfrtip',
        keys: true
    } );
}


function getWords(divs){
	words ={};
	for (var i = 0; i < divs.length; i++) {
		 words[divs[i]] =  $("#"+divs[i]).val().trim();
	}
	return words;	
}
function getDates(divs){
	dates ={};
	for (var i = 0; i < divs.length; i++) {
		 dates[divs[i]] =  $("#"+divs[i]).val().trim();
	}
	return dates;	
}

function getFilters(divs){
	filters = {};
	for (var i = 0; i < divs.length; i++) {
		 filters[divs[i]] =  $('input[name='+divs[i]+']:checked').val();
	}
	return filters;
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

// function verifyInputsByID(divs){

// 	var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;


// 	for (var i = 0; i < divs.length; i++) {
// 		 if($('#'+divs[i]).val().trim().length > 0){
// 		 	if(!regex.test($('#'+divs[i]).val().trim())){
// 		 		return true;
// 		 	}else{
// 		 		//$('#alertValidateContrato').show(100);
// 		 		addClassTime(divs[i]);
// 		 	}
// 		 }else{
// 		 	addClassTime(divs[i]);
// 		 	$('#alertValidateContrato').show(100);
// 		 	//addClassTime(divs[i]);
// 		 	return false;
// 		 }
// 	}
// }


// function addClassTime(div){
// 	$("#"+div).addClass("alertInput").delay(5000).queue(function(next){
//     	$(this).removeClass("error");
//     	next();
// 	});
// }

