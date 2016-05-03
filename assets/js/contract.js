$(document).ready(function(){

	maxHeight = screen.height * .25;
	maxHeight = screen.height - maxHeight;

	
    var unidadDialog = addUnidadDialog();
    var peopleDialog = addPeopleDialog();
	var addContract = createDialogContract();
	//var tourDialog = 

	$(document).on( 'click', '#newContract', function () {
		showLoading('#dialog-Contract',true);
		$( "#dialog-Contract" ).load( 'contract/modal', function() {
			showLoading('#dialog-Contract',false);
		});
		ajaxSelects('contract/getLanguages','try again', generalSelects, 'selectLanguage');
		ajaxSelects('contract/getSaleTypes','try again', generalSelects, 'typeSales');
		addContract.dialog("open");
	});


	$(document).on( 'click', '#btnAddPeople', function () {
	     showLoading('#dialog-People',true);
         $( "#dialog-People" ).load( 'people/index', function() {
            showLoading('#dialog-People',false);
        });
         peopleDialog.dialog( "open" );
	});

	 $(document).on( 'click', '#btnAddUnidades', function () {
	        showLoading('#dialog-Unidades',true);
	        $( "#dialog-Unidades" ).load( 'contract/modalUnidades', function() {
	            showLoading('#dialog-Unidades',false);
	        });
	        unidadDialog.dialog( "open" );
	    });


	// $(document).on( 'click', '#btnAddTourID', function () {
	//      showLoading('#dialog-tourID',true);
 //         $("#dialog-tourID").load( 'tours/modal', function() {
 //            showLoading('#dialog-tourID',false);
 //        });
 //        peopleDialog.dialog( "open" );
	// });

	$('#btnCleanWord').click(function (){
		btnCleanWord.val('');
	});
	$('#btnfind').click(function(){
		getContratos();
	});

	$("#busquedaAvanazada").click(function(){
		$("#avanzada").slideToggle("slow");
	});

});


function createDialogContract() {

	dialog = $("#dialog-Contract").dialog({
		autoOpen: false,
		height: maxHeight,
		width: "50%",
		modal: true,
		buttons: [{
			text: "Cancel",
			"class": 'dialogModalButtonCancel',
			click: function() {
				dialog.dialog("close");
			}
		},{
			text: "Save and close",
			"class": 'dialogModalButtonAccept',
			click: function() {

			}
		},
			{
				text: "Save",
				"class": 'dialogModalButtonAccept',
				click: function() {
					createNewContract();
				}
			}],
		close: function() {
		
		}
	});
	return dialog;
}
function addUnidadDialog() {

	dialog = $( "#dialog-Unidades" ).dialog({
		autoOpen: false,
		height: maxHeight,
		width: "50%",
		modal: true,
		buttons: [{
			text: "Cancel",
			"class": 'dialogModalButtonCancel',
			click: function() {
				$(this).dialog('close');
			}
		},{
			text: "Save and close",
			"class": 'dialogModalButtonAccept',
			click: function() {
			}
		},
			{
				text: "Save",
				"class": 'dialogModalButtonAccept',
				click: function() {
					saveContract();
				}
			}],
		close: function() {
		
		}
	});
	return dialog;
}
function addPeopleDialog() {

	dialog = $( "#dialog-People" ).dialog({
		autoOpen: false,
		height: maxHeight,
		width: "50%",
		modal: true,
		buttons: [{
			text: "Cancel",
			"class": 'dialogModalButtonCancel',
			click: function() {
				$(this).dialog('close');
			}
		},{
			text: "Save and close",
			"class": 'dialogModalButtonAccept',
			click: function() {
			}
		},
			{
				text: "Save",
				"class": 'dialogModalButtonAccept',
				click: function() {
					saveContract();
				}
			}],
		close: function() {
		
		}
	});
	return dialog;
}



// function goodBye(){
// 	console.log("BYE");
// }

// function cleanContractFields(id){
// 	// var formData = document.getElementById(id);
//  //    formData.reset();
// }


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
	showLoading('#contracts',true);
	ajaxHTML('dialog-Edit-Contract', 'contract/modalEdit');
    showModals('dialog-Edit-Contract', cleanAddPeople);
	//ajaxSelects('contract/getLanguages','try again', generalSelects, 'selectLanguage');
	//ajaxSelects('contract/getSaleTypes','try again', generalSelects, 'typeSales');
}

function getInputsByID(formData, divs){
	for (var i = 0; i < divs.length; i++) {
		 formData.append(divs[i], $("#"+divs[i]).val().trim());
	}
	return formData;
}

function verifyInputsByID(divs){
	var v = true;
	for (var i = 0; i < divs.length; i++) {
		 if($('#'+divs[i]).val().trim().length <= 0){
		 	v = false;
		 }
	}
	return v;
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

function saveContract() {
	console.log("ok esto es genial");
}

function createNewContract(){

	var id = "saveDataContract";
	var arrayWords = ["legalName", "selectLanguage", "TourID", "deposito", "precioUnidad", "precioVenta"];
	var form = $("#"+id);
	var elem = new Foundation.Abide(form, {});

	// if(!verifyInputsByID(arrayWords)){
	// 	$('#'+id).foundation('validateForm');
	// }else{

	$.ajax({
			data: {
				ID : 0,
				Folio : 0,
				tourId : $("#TourID").val().trim(),
				nombreLegal : $("#legalName").val().trim(),
				idiomaId : $( "#selectLanguage" ).val(),
				peoples : [33,34,35],
				unidades : [{
					"propiedadId": 1,
					"frecuenciaId": 2,
					"temporadaId": 1,
					"weeks": 3,
				}],
				firstYear : 2016,
				lastYear : 2017,
				tipoVentaId : 1,
				viewId: 1,
				contratoRelacionadoId : 0,
				precioUnidad : 29714,
				descuentoTotal :  0,
				precioVenta :  29714,
				deposito :  1500,
				totalEnganche : 1500,
				totalPagosProg : 1500,
				depClosingFee : 1295,
				montoTransfer : 6000,
				balance : 42711.8
			},
			type: "POST",
			dataType:'json',
			url: 'contract/saveContract'
		})
		.done(function( data, textStatus, jqXHR ) {
			//alertify.success(data.message);
		})
		.fail(function( jqXHR, textStatus, errorThrown ) {
			//alertify.error("Ocurrio un error vuelve a intentarlo");
		});
		// ID = 0;
		// Folio = 0;
		// tourId = $("#TourID").val().trim();
		// nombreLegal = $("#legalName").val().trim();
		// idiomaId = $( "#selectLanguage" ).val();
		// peoples = [33,34,35];
		// unidades = [{
		// 	"propiedadId": 1,
		// 	"frecuenciaId": 2,
		// 	"temporadaId": 1,
		// 	"weeks": 3,
		// }];
		// tipoVentaId = 1;
		// contratoRelacionadoId = 0;
		// precioUnidad = 29714;
		// descuentoTotal =  0;
		// precioVenta =  29714;
		// deposito =  1500;
		// totalEnganche = 1500
		// totalPagosProg = 1500
		// depClosingFee = 1295
		// montoTransfer = 6000;
		// balance = 42711.8;
	// }
	
	// var tourId = $("#TourID").val().trim();
	// var nombreLegal = $("#legalName").val().trim();
	// var idiomaId = $( "#selectLanguage" ).val();


	//$('#'+id).foundation('destroy');
	//var formData = new FormData(document.getElementById(""+id));
	//legalName
	//var idioma = $("#idiomaContract").val().trim();

	// var formData = new FormData(document.getElementById(id));
	// formData.append("peticion", "agregarServicio");

}


function getDataFormContract(){

	var idsContract = ['legalName', 'TourID'];
	var dataContact = getWords(dataContract);
	data.selectLanguage = $( "#selectLanguage" ).val();


}

