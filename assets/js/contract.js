$(document).ready(function(){

	maxHeight = screen.height * .25;
	maxHeight = screen.height - maxHeight;

	
    var unidadDialog = addUnidadDialog();
    var peopleDialog = addPeopleDialog();
	var addContract = createDialogContract();
	//var addUnidadDialogYears = addUnidadYears();


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
            $("#dialog-User").hide();
            selectTable("tablePeople");
        });
         peopleDialog.dialog( "open" );
	});

	 $(document).on( 'click', '#btnAddUnidades', function () {
	        showLoading('#dialog-Unidades',true);
	        $( "#dialog-Unidades" ).load( 'contract/modalUnidades', function() {
	            showLoading('#dialog-Unidades',false);
	            selectTableUnico("tblUnidades");
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
			text: "add",
			"class": 'dialogModalButtonAccept',
			click: function() {
				if(selectAllUnities()){
					$(this).dialog('close');
					//addUnidadDialogYears.dialog("open");
				};
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
			text: "add",
			"class": 'dialogModalButtonAccept',
			click: function() {
				if(selectAllPeople()){
					$(this).dialog('close');
				};
			}
		}],
		close: function() {
		
		}
	});
	return dialog;
}

function addUnidadYears() {

	dialog = $( "#dialog-People" ).dialog({
		autoOpen: false,
		height: maxHeight/4,
		width: "10%",
		modal: true,
		buttons: [{
			text: "Cancel",
			"class": 'dialogModalButtonCancel',
			click: function() {
				$(this).dialog('close');
			}
		},{
			text: "add",
			"class": 'dialogModalButtonAccept',
			click: function() {
				if(selectAllPeople()){
					$(this).dialog('close');
				};
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
				legalName : $("#legalName").val().trim(),
				tourID : $("#TourID").val().trim(),
				idiomaID : $( "#selectLanguage" ).val(),
				
				peoples : getValoresTablas("tablePeopleSelected"),
				primario : selectTypePeople("primario"),
				secundaria: selectTypePeople("secundaria"),
				baneficiario: selectTypePeople("baneficiario"),
				// peoples : {
				// 	"idPeople": 3,
				// 	"type":2,
				// },
				unidades : getValoresTablas("tableUnidadesSelected"),
				// "frecuenciaId": 2,
				// "temporadaId": 1,
				"weeks": 1,
				firstYear : 2016,
				lastYear : 2017,
				tipoVentaId : 1,
				viewId: 1,
				floorPlanId: 1,
				SeassonId: 10,
				FrequencyId: 2
				contratoRelacionadoId : 0,
				pkResPeopleAccId: 2,
				fkAccId: 3,
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

function selectAllPeople(){
	var personas = [];

	var array = $("#tablePeople .yellow");
	for (var i = 0; i < array.length; i++) {
		// var persona = {
		// 	id:array[i].childNodes[1].textContent,
		// 	name:array[i].childNodes[2].textContent,
		// 	lastName:array[i].childNodes[3].textContent,
		// 	address:array[i].childNodes[4].textContent
		// };
		persona = [
			array[i].childNodes[1].textContent.replace(/\s+/g, " "),
			array[i].childNodes[2].textContent.replace(/\s+/g, " "),
			array[i].childNodes[3].textContent.replace(/\s+/g, " "),
			array[i].childNodes[8].textContent.replace(/\s+/g, " ")
		];
		personas.push(persona);
	}
	if (personas.length <= 0) {
		alertify.error("Click over for choose one");
		return false;
	}else{
		tablaPersonas(personas);
		return true;
	}
	
}

function tablaPersonas(personas){
	var bodyHTML = '';
	    //creación del body
    for (var i = 0; i < personas.length; i++) {
        bodyHTML += "<tr>";
        for (var j in personas[i]) {
            bodyHTML+="<td>" + personas[i][j] + "</td>";
        };
        bodyHTML += "<td><input  type='checkbox' name='principal'></td>";
        bodyHTML += "<td><input  type='checkbox' name='secundaria'></td>";
        bodyHTML += "<td><input  type='checkbox' name='baneficiario'></td>";
        bodyHTML += "<td><button type='button' class='alert button'><i class='fa fa-minus-circle fa-lg' aria-hidden='true'></i></button></td>";
        bodyHTML+="</tr>";
    }
    $('#tablePeopleSelected tbody').append(bodyHTML);
    deleteElementTable("tablePeopleSelected");
    //checkBoxes();
}

function deleteElementTable(div){
	$("#"+div+" tr").on("click", "button", function(){
		$(this).closest("tr").remove();
	});
}

function checkBoxes(){
	var radioButtons = $('input[name="principal"]');
	var selectedIndex = radioButtons.index(radioButtons.filter(':checked'));
	radioButtons.checked(0);

	$('#tablePeopleSelected tbody .radiocheckbox').click(function() {
    	this.checked && $(this).siblings('input[name="' + this.name + '"]:checked.' + this.className).prop('checked', false);
	});
}

function selectTable(div){
	$("#"+div).on("click", "tr", function(){
		$(this).toggleClass("yellow");
	});
}
function selectTableUnico(div){
	var pickedup;
	$("#"+div).on("click", "tr", function(){
          if (pickedup != null) {
              pickedup.removeClass("yellow");
          }
          $( this ).addClass("yellow");
          pickedup = $(this);
	});
}

function selectAllUnities(){
	var unidades = [];

	var array = $("#tblUnidades .yellow");
	for (var i = 0; i < array.length; i++) {
		unidad = [
			array[i].childNodes[1].textContent.replace(/\s+/g, " "),
			array[i].childNodes[2].textContent.replace(/\s+/g, " "),
			array[i].childNodes[3].textContent.replace(/\s+/g, " ")
		];
		unidades.push(unidad);
	}
	if (unidades.length <= 0) {
		alertify.error("Click over for choose one");
		return false;
	}else{
		tablUnidadades(unidades);
		return true;
	}
}

function tablUnidadades(unidades){
	var bodyHTML = '';
	    //creación del body
    for (var i = 0; i < unidades.length; i++) {
        bodyHTML += "<tr>";
        for (var j in unidades[i]) {
            bodyHTML+="<td>" + unidades[i][j] + "</td>";
        };
        bodyHTML += "<td>1</td>";
        bodyHTML += "<td>2016</td>";
        bodyHTML += "<td>2017</td>";
        bodyHTML += "<td>Odd years</td>";
        bodyHTML += "<td><button type='button' class='alert button'><i class='fa fa-minus-circle fa-lg' aria-hidden='true'></i></button></td>";
        bodyHTML+="</tr>";
    }
    $('#tableUnidadesSelected tbody').html(bodyHTML);
    deleteElementTable("tableUnidadesSelected");
}

function verificarTablas(div){
	var array = $("#"+div+" tbody tr");
	if (array.length>0) {
		return true;
	}else{
		return false;
	}
	//tablePeopleSelected
	//tableUnidadesSelected
}
//tablePeopleSelected
//tableUnidadesSelected
function getValoresTablas(div){
	var personas = [];
	var array = $("#"+div+" tbody tr");
	for (var i = 0; i < array.length; i++) {
		var fullArray = $(array[i]).find("td");
		// persona = [
		// 	fullArray.eq(0).text().trim()
		// ];
		personas.push(fullArray.eq(0).text().trim());
	}

	return personas;
}

//secundaria
function selectTypePeople(tipo){
	var radioButtons = $('input[name="'+tipo+'"]');
	var selectedIndex = radioButtons.index(radioButtons.filter(':checked'));
	return selectedIndex;
}