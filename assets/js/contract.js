var msgContract = null;


$(document).ready(function(){
	getSizeModalGeneral();
	var dialogAddTour = null;
	var dialogStatus = null;

	initDatesContract();

	$(document).off( 'click', '#newContract');
	$(document).on( 'click', '#newContract', function () {
		showModalContract();
	});
	$(document).off( 'click', '#btnRefinancingContract');
	$(document).on( 'click', '#btnRefinancingContract', function () {
		var id = getIDContrato();
		showModalFin2(id);
	});

	$(document).off( 'click', '#btnSavePeople');
	$(document).on('click', "#btnSavePeople", function () {
		savePeople();
	});
	
	$(document).off( 'click', '#btnSaveUnit');
	$(document).on('click', "#btnSaveUnit", function () {
		changeUnits();
	});
	
	$(document).off( 'click', '#btnAddPeople');
	$(document).on( 'click', '#btnAddPeople', function () {
		if (peopleDialog != null) {
			peopleDialog.dialog( "destroy" );
		}
		peopleDialog = addPeopleDialog($(this).attr('attr_table'));
		peopleDialog.dialog( "open" );
	});
	$(document).off( 'click', '#btnAddUnidades');
	$(document).on( 'click', '#btnAddUnidades', function () {
		if (unidadDialog!=null) {
			unidadDialog.dialog( "destroy" );
		}
		unidadDialog = addUnidadDialog('new');
		unidadDialog.dialog( "open" );
	});
	$(document).off( 'click',  '#btnAddPeopleEdit');
	$(document).on( 'click', '#btnAddPeopleEdit', function () {
		if (peopleDialog != null) {
			peopleDialog.dialog( "destroy" );
		}
		peopleDialog = addPeopleDialog( $(this).attr('attr_table') );
        peopleDialog.dialog( "open" );
	});
	$(document).off( 'click', '#btnNewSeller'); 	
	$(document).on( 'click', '#btnNewSeller', function () {
		if (modalVendedores!=null) {
			modalVendedores.dialog( "destroy" );
		}
		modalVendedores = modalSellers();
		modalVendedores.dialog( "open" );
	 });
	$(document).off( 'click', '#btnNewFile'); 
 	 $(document).on( 'click', '#btnNewFile', function () {
 		if (modalNewFile!=null) {
	    		modalNewFile.dialog( "destroy" );
	    	}
	    	modalNewFile = modalNewFileContract();
	        modalNewFile.dialog( "open" );
	 });
	$(document).off( 'click', '#btnNewProvision'); 
	$(document).on( 'click', '#btnNewProvision', function () {
 		if (modalProvisiones!=null) {
	    		modalProvisiones.dialog( "destroy" );
	    	}
	    	modalProvisiones = modalProvisions();
	        modalProvisiones.dialog( "open" );
	 });
	$(document).off( 'click', '#btnNewNote'); 
	$(document).on( 'click', '#btnNewNote', function () {
 		if (modalNotas!=null) {
	    		modalNotas.dialog( "destroy" );
	    	}
	    	modalNotas = modalAddNotas();
	        modalNotas.dialog( "open" );
	 });
	$(document).off( 'click', '#btnGetAllNotes'); 
	$(document).on( 'click', '#btnGetAllNotes', function () {
 		if (modalAllNotes!=null) {
	    		modalAllNotes.dialog( "destroy" );
	    	}
	    	modalAllNotes = modalGetAllNotes();
	        modalAllNotes.dialog( "open" );
	 });
	$(document).off( 'click', '#btnPackReference'); 
	$(document).on( 'click', '#btnPackReference', function () {
		if (dialogPack!=null) {
	    	dialogPack.dialog( "destroy" );
	    }
		dialogPack = PackReference();
		dialogPack.dialog("open");
	});
	$(document).off( 'click', '#btnDownpayment'); 
	$(document).on( 'click', '#btnDownpayment', function () {
		if (dialogEnganche!=null) {
	    	dialogEnganche.dialog( "destroy" );
	    }
		dialogEnganche = modalDepositDownpayment();
		dialogEnganche.dialog("open");
	});
	$(document).off( 'click', '#btnScheduledPayments'); 
	$(document).on( 'click', '#btnScheduledPayments', function () {
		if (dialogScheduledPayments!=null) {
	    	dialogScheduledPayments.dialog( "destroy" );
	    }
		dialogScheduledPayments = modalScheduledPayments();
		dialogScheduledPayments.dialog("open");
	});
	$(document).off( 'click', '#btnDiscountAmount'); 
	$(document).on( 'click', '#btnDiscountAmount', function () {
		if (dialogDiscountAmount!=null) {
	    	dialogDiscountAmount.dialog( "destroy" );
	    }
		dialogDiscountAmount = modalDiscountAmount();
		dialogDiscountAmount.dialog("open");
	});
	$(document).off('change', '#contractR');
	$(document).on( 'change', '#contractR', function () {
		var ajaxDatos =  {
			url: "contract/verifyConfirmationCode",
			tipo: "json",
			datos: {
					ResRelated: $("#contractR").val().replace("1-", "")
			},
			funcionExito : messageRC,
			funcionError: mensajeAlertify
		};
	ajaxDATAG(ajaxDatos);
	});
	$(document).off('change', '#legalNameEdit');
	$(document).on( 'change', '#legalNameEdit', function () {
		editLegalName();
	});
	$(document).off( 'click', '#btnAddTourID');
	$(document).on( 'click', '#btnAddTourID', function () {
		if (dialogAddTour!=null) {
	    	dialogAddTour.dialog( "destroy" );
	   	}
		dialogAddTour = addTourContract();
		dialogAddTour.dialog("open");
	});
	$(document).off( 'click', '#btNewTransAcc'); 
	$(document).off( 'click', '#btAddPayAcc'); 
	$(document).on( 'click', '#btNewTransAcc, #btAddPayAcc', function () {
		var accCode = $('#tabsContratsAccounts .active').attr('attr-accCode');
		var idAccColl = $('#btNewTransAcc').data( 'idAcc' + accCode );
		if(idAccColl != undefined){
			if (dialogAccount!=null) {
	    		dialogAccount.dialog( "destroy" );
	   		}
			dialogAccount = opcionAccount($(this).attr('attr_type'));
			dialogAccount.dialog("open");
		}else{
			alertify.error('No acc found');
		}
	});
	$(document).off( 'click', '#btnShowPayCardAS');
	$(document).on( 'click', '#btnShowPayCardAS', function () {
		showCreditCardAS();
	});

	$(document).off( 'click', '#btnDeleteTourID');
	$(document).on( 'click', '#btnDeleteTourID', function () {
		$('#TourID').val('0');
	});
	$(document).off( 'click', '#btnCleanWord');
	$('#btnCleanWord').click(function (){
		$('#stringContrat').val('');
	});
	$(document).off( 'click', '#btnfind');
	$('#btnfind').click(function(){
		$('#contractstbody').empty();
		getContratos();
	});
	$(document).off( 'click', '#busquedaAvanazada');
	$("#busquedaAvanazada").click(function(){
		$("#avanzada").slideToggle("slow");
	});

	//Enganche
	$(document).off( 'change', '#downpayment');
	$(document).on( 'change', '#downpayment', function () {
		updateDownpayment();
	});
	$(document).off( 'change', "input[name='engancheR']:checked");
	$(document).on('change', "input[name='engancheR']:checked", function () {
		updateDownpayment();
	});
	$(document).off( 'change', '#descuentoEspecial');
	$(document).on( 'change', '#descuentoEspecial', function () {
		updateDescuentoEspecial();
	});
	$(document).off( 'change', "input[name='especialDiscount']:checked");
	$(document).on( 'change', "input[name='especialDiscount']:checked", function () {
		updateDescuentoEspecial();
	});
	$(document).off( 'change', "#amountTransfer");
	$(document).on('change', "#amountTransfer", function () {
		updateBalanceFinal();
	});
	
	$(document).off( 'click', '#btnChangeUnit');
	$(document).on( 'click', '#btnChangeUnit', function (){
		if (unidadDialog!=null) {
			unidadDialog.dialog( "destroy" );
		}
		unidadDialog = addUnidadDialog('change');
		unidadDialog.dialog( "open" );
		//changeStatusUnitCon();
	});
	
	getDatailByID("contractstbody");
});

function getSizeModalGeneral(){
	maxHeight = screen.height;
	if (screen.width < 760) {
		maxWidth = "100%";
		maxHeight = parseInt(screen.height);
	}else{
		maxWidth = "70%";
		maxHeight =  parseInt(screen.height * .85);
	}
}

function getSizeModalContract(){
	maxHeight = screen.height;
	if (screen.width < 760) {
		maxWidth = "100%";
	}else{
		maxWidth = "60%";
		maxHeight = screen.height - parseInt(screen.height * .17);
	}
}
function messageRC(data){
	if (data['success'] == 1) {
		var msg = data["mensaje"];
					alertify.confirm(msg, "Primary: "+ data["primary"], 
					function(){
						console.log("Ok");
					},
					function(){
						console.log("Cancel");
						$("#contractR").val(0);
					}
					).moveTo(screen.width - 500,screen.height - 100).set('resizable',true).resizeTo('25%',210).isOpen(
						$('.ajs-dialog').css('min-width','100px')
					);
	}else{
		alertify.error(data["mensaje"]);
		$("#contractR").val(0);
	}

	
// if (data['success'] == 1) {
// 		alertify.success(data["mensaje"]);
// 	}
// 	if (data['success'] == 0) {
// 		alertify.error(data["mensaje"]);
// 	}
}

function initDatesContract(){
	$( "#startDateContract" ).Zebra_DatePicker({
		format: 'm/d/Y',
		show_icon: false,
	});
	$( "#endDateContract" ).Zebra_DatePicker({
		format: 'm/d/Y',
		show_icon: false,
	});
}

function updateDownpayment(){
	var downpayment = getNumberTextInput("downpayment");
	$("#montoTotal").val(downpayment.toFixed(2));
	var monto = getNumberTextInput("montoTotal");
	if (monto) {
		cambiarCantidadP(monto);
	}else{
		$("#montoTotal").val(0);
	}
}
function updateDescuentoEspecial(){
	var monto = $("#descuentoEspecial").val();
	if (monto) {
		cambiarCantidadDE(monto);
	}else{
		$("#montoTotalDE").val(0);
	}
}

function updateBalanceFinal(){
	var closingCost = getClosingCost();
	var precioVenta = getNumberTextInput("precioVenta");

	var descuentoEspecial = getNumberTextInput("montoTotalDE");
	var deposito = getNumberTextInput("depositoEnganche");
	var pagosProgramados = getNumberTextInput("scheduledPayments");


	var descuentoEfectivo = getNumberTextInput("totalDiscountPacks"); 
	var transferencia = getNumberTextInput("amountTransfer");

	var descuento = descuentoEspecial + deposito + pagosProgramados + descuentoEfectivo + transferencia;
	var costoTotal = precioVenta + closingCost;
	var total = (costoTotal - descuento).toFixed(2);
	$("#financeBalance").val(total);
	
}

function getClosingCost(){
	return sumarArray(getArrayValuesColumnTable("tableUnidadesSelected", 8));
}		
function cambiarCantidadP(monto)
{
	var seleccionado = $("input[name='engancheR']:checked").val();
	var precioVenta = getNumberTextInput("precioVenta"); 
	var descuento = getNumberTextInput("montoTotalDE");
	var total = precioVenta - descuento;
	if (seleccionado == "porcentaje") {
		var porcentaje = total * (monto/100);
		$("#montoTotal").val(porcentaje.toFixed(2));
	}else{
		$("#montoTotal").val(monto.toFixed(2));
	}
	//updateBalanceFinal();
}
function cambiarCantidadDE(monto){
	var m = parseFloat(monto);
	var seleccionado = $("input[name='especialDiscount']:checked").val();
	var precioVenta = getNumberTextInput('precioVenta');
	if (seleccionado == 'porcentaje') {
		var porcentaje = precioVenta * (m/100);
		$("#montoTotalDE").val(porcentaje.toFixed(2));
	}else{
		$("#montoTotalDE").val(m.toFixed(2));
	}
	updateBalanceFinal();
}
function createContractSelect(datos){
	$("#dialog-Contract").html(datos);
	ajaxSelects('contract/getSaleTypes','try again', generalSelectsDefault, 'typeSales');
}
function showModalContract(){
	var ajaxData =  {
		url: "contract/modalContract",
		tipo: "html",
		datos: {},
		funcionExito : createContractSelect,
		funcionError: mensajeAlertify
	};
	var modalPropiedades = {
		div: "dialog-Contract",
		altura: maxHeight,
		width: maxWidth,
		onOpen: ajaxDATA,
		onSave: createNewContract,
		cerrar : cerrarContract,
		botones :[{
			text: "Close",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');
	         }
		},{
			text: "Save",
			"class": 'dialogModalButtonAccept',
			click: function() {
				if (verifyContractALL()) {
					if ($('#tableUnidadesSelected tr').hasClass('redI')) {
						alertify.error("Verify the Unities");
					}else{
						createNewContract();
						$(this).dialog('close');
					}
					
				}
			}
		}]
		};

	if (addContract!=null) {
		addContract.dialog( "destroy" );
	}
	addContract = modalGeneral3(modalPropiedades, ajaxData);
	addContract.dialog( "open" );
}

function showModalDetailWeek(){
	var id = getIDContrato();
	var year = getValueFromTableSelected("tableCOccupationSelected", 1);
	var week = getValueFromTableSelected("tableCOccupationSelected", 2);
	var ajaxData =  {
		url: "contract/getResByContCon",
		tipo: "html",
		datos: {
			idContrato: id,
			year: year,
			week: week
		},
		funcionExito : addHTMLDetailWeek,
		funcionError: mensajeAlertify
	};
	var modalPropiedades = {
		div: "dialog-DetailWeek",
		altura: maxHeight,
		width: maxWidth,
		onOpen: ajaxDATA,
		onSave: createNewContract,
		cerrar : cerrarContract,
		botones :[{
			text: "Close",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');
	         }
		}]
		};

	if (dialogWeekDetail!=null) {
		dialogWeekDetail.dialog( "destroy" );
	}
	dialogWeekDetail = modalGeneral2(modalPropiedades, ajaxData);
	dialogWeekDetail.dialog( "open" );
}
function addHTMLDetailWeek(data){
	$("#dialog-DetailWeek").html(data);
} 

function cerrarContract(){
	$('#dialog-DiscountAmount').empty();
}
function addTourContract(){
	var div = '#dialog-tourID';
	dialogo = $("#dialog-tourID").dialog ({
  		open : function (event){
  				showLoading(div,true);
  				$(this).load ("tours/index" , function(){
	    			showLoading(div,false);
	    			selectTableUnico("tours");
	    		});
		},
		autoOpen: false,
     	height: maxHeight,
     	width: maxWidth,
     	modal: true,
     	buttons: [{
	       	text: "Cancel",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');
	       }
	   	},{
       		text: "Ok",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			var tourID = getValueFromTableSelected("tours", 1);
       			$("#TourID").val(tourID);
       			$(this).dialog('close');
       		}
     	}],
     close: function() {
     }
	});
	return dialogo;
}

/*************************************/
/**@todo muestra el modal para agregar/cambiar unidades/
/**@param --typeModal indica si se trata de agregar nuevas o cambiar unidades ya asignadas a un contrato **/
/*************************************/
function addUnidadDialog(typeModal){
	var div = "#dialog-Unidades";
	dialog = $( "#dialog-Unidades" ).dialog({
		open : function (event){
				showLoading(div,true);
				$(this).load ("contract/modalUnidades" , function(){
		    		showLoading(div,false);
		    		ajaxSelects('contract/getProperties','try again', generalSelectsDefault, 'property');
	    			ajaxSelects('contract/getUnitTypes','try again', generalSelects, 'unitType');
	    			ajaxSelects('contract/getViewsType','try again', generalSelects, 'unitView');
	    			ajaxSelects('contract/getSeasons','try again', generalSelects, 'season');
					//$('#btngetUnidades').click(function(){
					$('#btngetUnidades').off( 'click' );
					$('#btngetUnidades').on( 'click', function(){
						getUnidades(typeModal);
					});
		            selectTable("tblUnidades");
	    		});
		},
		autoOpen: false,
		height: maxHeight,
		width: maxWidth,
		modal: true,
		buttons: [{
			text: "Cancel",
			"class": 'dialogModalButtonCancel',
			click: function() {
				$(this).dialog('close');
			}
		},{
			text: "Add",
			"class": 'dialogModalButtonAccept',
			click: function() {
				var unidades = getValueTableUnidadesSeleccionadas();
				var repeat = 0
				var isRepeat = false;
				//detecta que una unidad no este seleccionado mas de una vez
				for (var i = 0; i < unidades.length; i++) {
					if(repeat != unidades[i].id){
						repeat = unidades[i].id;
					}else{
						isRepeat = true;
						break;
					}
				}
				if (unidades.length>0) {
					if(!isRepeat){
						var ultimos = [];
						$(this).dialog('close');
						for (var i = 0; i < unidades.length; i++) {
							ultimos.push(parseInt(unidades[i].lastYear));
						}
						ultimo = Math.max.apply( Math, ultimos);
						if (dialogWeeks!=null) {
							dialogWeeks.dialog( "destroy" );
						}
						dialogWeeks = getWeeksDialog(unidades, ultimo,typeModal);
						dialogWeeks.dialog("open");
					}else{
						alertify.error("Only one unit can be selected once");
					}
				}else{
					alertify.error("Search and click over for choose one");
				}
			}
		}],
		close: function() {
			$('#dialog-Unidades').empty();
		}
	});
	return dialog;
}

function addPeopleDialog(table) {
	console.log("stoy en el dialog" + table);
	var div = "#dialog-People";	
	dialog = $(div).dialog({
		open : function (event){
			if ($(div).is(':empty')) {
				showLoading(div, true);
				$(this).load ("people/indexContratos" , function(){
		    		showLoading(div, false);
		    		$("#dialog-User").hide();
	            	selectTable("Contrato-tablePeople");
	    		});
			}
		},
		autoOpen: false,
		height: maxHeight,
		width: maxWidth,
		modal: true,
		buttons: [{
			text: "Cancel",
			"class": 'dialogModalButtonCancel',
			click: function() {
				$(this).dialog('close');
			}
		},{
			text: "Add",
			"class": 'dialogModalButtonAccept',
			click: function() {
				if(selectAllPeople(table)){
					$(this).dialog('close');
					updateValuePeople();
					createNombreLegal();
				};
			}
		}],
		close: function() {
			$('#dialog-People').empty();
		}
	});
	return dialog;
}

function createNombreLegal(){
	var texto = "";
	var nombres = getArrayValuesColumnTable("tablePeopleSelected", 2);
	var apellidos = getArrayValuesColumnTable("tablePeopleSelected", 3);
	for (var i = 0; i < nombres.length; i++) {
		texto += nombres[i]+" "+apellidos[i];
		if (i!=nombres.length-1) {
			texto += " and ";
		}
	}
	if ($("#legalName").val()=="") {
		$("#legalName").val(texto);
	}
}
function onChangeNombreLegal(){
	var texto = "";
	var nombres = getArrayValuesColumnTable("peopleContract", 2);
	var apellidos = getArrayValuesColumnTable("peopleContract", 3);
	for (var i = 0; i < nombres.length; i++) {
		texto += nombres[i]+" "+apellidos[i];
		if (i!=nombres.length-1) {
			texto += " and ";
		}
	}
	if ($("#legalNameEdit").val()=="") {
		$("#legalNameEdit").val(texto);
	}
}

function getContratos(){
	//
	showLoading('#contracts',true);
    var filters = getFiltersCheckboxs('filtro_contrato');
    var arrayDate = ["startDateContract", "endDateContract"];
    var dates = getDates(arrayDate);
    var arrayWords = ["stringContrat"];
    var words = getWords(arrayWords);
    if (filters.folio) {
    	words.stringContrat = words.stringContrat.replace("1-", "");
    }
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
			if(data){
				$("#NC").text("Total: "+ data.length);
				alertify.success("Found "+ data.length + " Contracts");
				drawTable2(data,"contracts","details","details");
			}else{
				$('#contractstbody').empty();
				alertify.error("No records found");
			}
		},
		error: function(){
			alertify.error("Try again");
		}
    });
}

function details(){
	
}

function getDetalleContratoByID(i){
	showLoading('#contracts',true);
	ajaxHTML('dialog-Edit-Contract', 'contract/modalEdit');
    showModals('dialog-Edit-Contract', cleanAddPeople);
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
function clearInputsById(divs){
	for (var i = 0; i < divs.length; i++) {
		 $('#'+divs[i]).val("");
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

function verifyContract(){
	var value = true;
	var arrayWords = ["legalName", "TourID", "depositoEnganche", "precioUnidad", "precioVenta"];
	var id = "saveDataContract";
	var form = $("#"+id);
	var elem = new Foundation.Abide(form, {});

	if(!verifyInputsByID(arrayWords)){
		$('#'+id).foundation('validateForm');
		alertify.success("Please fill required fields (red)");
		value = false;
	}
	return value;
}
function verifyTablesContract(){
	var value = true;
	var unidades = getValueTableUnidades('tableUnidadesSelected');
	var personas = getValueTablePersonas();
	if (personas.length<=0) {
		alertify.error("You should add one people or more");
		value = false;
	}else if (unidades.length<=0) {
		alertify.error("You should add one unity or more");
		value = false;
	}
	return value;
}
function verifyLanguage(){
	var value = true;
	var languageValue = getNumberTextInput("selectLanguage");
	if(languageValue == 0){
		value = false;
		gotoDiv("contentModalContract", "selectLanguage");
		$("#selectLanguage").addClass('is-invalid-input');
		alertify.error("Choose a language");
	}
	return value;
}
function verifyContractALL(){
	var value = false;
	if (verifyContract()) {
		if (verifyTablesContract()) {
			if (verifyLanguage()) {
				value = true;
			}
			
		}
	}
	return value;
}
function createNewContract(){
		var id = "saveDataContract";
		var form = $("#"+id);
		var elem = new Foundation.Abide(form, {});
		//showAlert(true,"Saving changes, please wait ....",'progressbar');
		msgContract = alertify.success('Saving changes, please wait ....', 0);
		$.ajax({
			data: {
				idiomaID : $("#selectLanguage").val(),
				firstYear :$("#firstYearWeeks").val().trim(),
				lastYear : $("#lastYearWeeks").val().trim(),
				legalName : $("#legalName").val().trim(),
				tourID : $("#TourID").val().trim(),
				peoples: getValueTablePersonas(),
				types: 	typePeople(),
				unidades: getValueTableUnidades('tableUnidadesSelected'),
				weeks: getArrayValuesColumnTable("tableUnidadesSelected", 7),
				tipoVentaId : $("#typeSales").val(),
				listPrice: getNumberTextInput("precioUnidad"),
				salePrice: getNumberTextInput("precioVenta"),
				extras: getNumberTextInput("packReference"),
				specialDiscount: getNumberTextInput("montoTotalDE"),
				downpayment:getNumberTextInput("montoTotal"),
				deposito:getNumberTextInput("depositoEnganche"),
				amountTransfer:getNumberTextInput("amountTransfer"),
				packPrice:sumarArray(getArrayValuesColumnTable("tableDescuentos", 3)),
				financeBalance: $("#financeBalance").val(),
				//tablapagos: getValueTableDownpayment(),
				tablaPagosProgramados:getValueTableDownpaymentScheduled(),
				tablaDownpayment : getValueTableDownpayment(),
				gifts: getValueTablePacks(),
				viewId: 1,
				closingCost: getClosingCost(),
				card: datosCard(),
				RelatedR: $("#contractR").val().replace("1-", "")
				//totalDiscountPacks
			},
			type: "POST",
			dataType:'json',
			url: 'contract/saveContract'
		}).done(function( data, textStatus, jqXHR ) {
				//showAlert(false,"Saving changes, please wait ....",'progressbar');
				msgContract.dismiss();
				if (data['status']== 1) {
					$("#tablePagosPrgSelected").empty();
					$("#tablePagosSelected").empty();
					elem.resetForm();
					var arrayWords = ["legalName", "TourID", "depositoEnganche", "precioUnidad", "precioVenta", "downpayment"];
					clearInputsById(arrayWords);
					if (data['balance'].financeBalance >0) {
						showModalFin(data['idContrato']);
					}else{
						if (dialogEditContract!=null) {
							dialogEditContract.dialog( "destroy" );
						}
						dialogEditContract = modalEditContract(data['idContrato']);
 						dialogEditContract.dialog("open");
					}
					
					$('#dialog-Weeks').empty();
					$('#tablePeopleSelected tbody').empty();
					$('#tableUnidadesSelected tbody').empty();
					alertify.success(data['mensaje']);
				}else{
					alertify.error(data["mensaje"]);
				}
			}).fail(function( jqXHR, textStatus, errorThrown ) {
				msgContract.dismiss();
			});
}

//funciona para pagos enganches
	function getValueTableDownpayment(){
		var tabla = "tablePagosSelected";
		var pagos = [];
		$('#'+tabla+' tbody tr').each( function(){
			if ($(this).text().replace(/\s+/g, " ")!="") {
				var pago = {};
				pago.date = $(this).find('td').eq(0).text(),
				pago.type = $(this).find('td').eq(1).text(),
				pago.amount = $(this).find('td').eq(2).text()
				pagos.push(pago); 
			}
		});
		return pagos;
	}

function getValueTablePacks(){
	var tabla = "tableDescuentos";
	var packs = [];
	$('#'+tabla+' tbody tr').each( function(){
		if ($(this).text().replace(/\s+/g, " ")!="") {
			var pack = {};
			pack.id = $(this).find('td').eq(0).text(),
			pack.amount = $(this).find('td').eq(2).text()
			packs.push(pack); 
		}
	});
	return packs;
}

function getValueTableDownpaymentScheduled(){
	var tabla = "tablePagosPrgSelected";
	var pagos = [];
	$('#'+tabla+' tbody tr').each( function(){
		if ($(this).text().replace(/\s+/g, " ")!="") {
			var pago = {};
			pago.date = $(this).find('td').eq(0).text(),
			pago.type = $(this).find('td').eq(1).text(),
			pago.amount = $(this).find('td').eq(2).text()
			pagos.push(pago); 
		}
	});
	return pagos;
}
function getValueTableDownpayment(){
	var tabla = "tablePagosSelected";
	var pagos = [];
	$('#'+tabla+' tbody tr').each( function(){
		if ($(this).text().replace(/\s+/g, " ")!="") {
			var pago = {};
			pago.date = $(this).find('td').eq(0).text(),
			pago.type = $(this).find('td').eq(1).text(),
			pago.amount = $(this).find('td').eq(2).text()
			pagos.push(pago); 
		}
	});
	return pagos;
}

function getValueTableUnidades(table){
	var tabla = table;
	var unidades = [];
	$('#'+tabla+' tbody tr').each( function(){
		if ($(this).text().replace(/\s+/g, " ")!="") {
			var unidad = {};
			unidad.id = $(this).find('td').eq(0).text(),
			unidad.floorPlan = $(this).find('td').eq(2).text(),
			unidad.price = $(this).find('td').eq(3).text(),
			unidad.frequency = $(this).find('td').eq(4).text(),
			unidad.season = $(this).find('td').eq(5).text(),
			unidad.week = $(this).find('td').eq(6).text(),
			unidad.fyear = $(this).find('td').eq(8).text(),
			unidad.lyear = $(this).find('td').eq(9).text()
			unidades.push(unidad); 
		}
	});
	return unidades;
}
function getValueTableUnidadesSize(){
	var tabla = "tableUnidadesContract";
	return $( "#"+tabla+" tr" ).length;
}
function getValueTablePersonas(){
	var tabla = "tablePeopleSelected";
	var unidades = [];
	var personas = [];
	$('#'+tabla+' tbody tr').each( function(i){
		if ($(this).text().replace(/\s+/g, " ")!="") {
			var persona = {};
			persona.id = $(this).find('td').eq(0).text(),
			persona.primario = $(this).find('td').eq(4).find('input[name=peopleType1]').is(':checked'),
			persona.beneficiario = $(this).find('td').eq(5).find('input[name=peopleType2]').is(':checked')
			personas.push(persona);
		}
	});
	return personas;
}
function getValueTablePersonasMOD(){
	var tabla = "peopleContract";
	var unidades = [];
	var personas = [];
	$('#'+tabla+' tbody tr').each( function(i){
		if ($(this).text().replace(/\s+/g, " ")!="") {
			var persona = {};
			persona.id = $(this).find('td').eq(0).text(),
			persona.primario = $(this).find('td').eq(4).find('input[name=peopleType1]').is(':checked'),
			persona.beneficiario = $(this).find('td').eq(5).find('input[name=peopleType2]').is(':checked')
			persona.exist = 0
			personas.push(persona);
		}
	});
	return personas;
}

function converCheked(val){
	console.log(val);
	var c;
	if (val == "on") {
		c = 1;
	}else{
		c = 0;
	}
	return c;
}

function sumarArray(array){
	var sum = 0;
	$.each(
		array,function(){
			sum+=parseFloat(this) || 0;
		}
	);
	return sum;
}

function typePeople(){
	var typePeople =[];
	var people = getArrayValuesColumnTable("tablePeopleSelected", 1);
	var primario = selectTypePeople("primario");
	var secundario = selectTypePeople("secundario");
	var beneficiario = selectTypePeople("beneficiario");
	for (var i = 0; i < people.length; i++) {
		var persona = [];
		if (people[primario]!= "undefined" && people[primario] == people[i]) {
			persona = [1,0,0];
			typePeople.push(persona);
		}else if (persona[secundario]!= "undefined" && people[secundario] == people[i]) {
			persona = [0,1,0];
			typePeople.push(persona);
		}else if (persona[beneficiario]!= "undefined" && people[beneficiario] == people[i]){
			persona = [0,0,1];
			typePeople.push(persona);
		}else{
			persona = [0,0,0];
			typePeople.push(persona);	
		}
	}
	return typePeople;
}

function getDataFormContract(){

	var idsContract = ['legalName', 'TourID'];
	var dataContact = getWords(dataContract);
	data.selectLanguage = $( "#selectLanguage" ).val();
}

function selectAllPeople(table){
	var personasSeleccionaDas = getArrayValuesColumnTable("tablePeopleSelected", 1);
	var personas = [];

	var array = $("#"+SECCION+"-tablePeople .yellow");
	for (var i = 0; i < array.length; i++) {
		var fullArray = $(array[i]).find("td");
		if (personasSeleccionaDas.length>0) {
			if (!isInArray(fullArray.eq(1).text().replace(/\s+/g, " ") ,personasSeleccionaDas)) {
				persona = [
					fullArray.eq(1).text().replace(/\s+/g, " "),
					fullArray.eq(2).text().replace(/\s+/g, " "),
					fullArray.eq(3).text().replace(/\s+/g, " "),
					fullArray.eq(9).text().replace(/\s+/g, " ")
					];
					personas.push(persona);
			}
		}else{
			persona = [
				fullArray.eq(1).text().replace(/\s+/g, " "),
				fullArray.eq(2).text().replace(/\s+/g, " "),
				fullArray.eq(3).text().replace(/\s+/g, " "),
				fullArray.eq(9).text().replace(/\s+/g, " ")
			];
			personas.push(persona);
		}
	}
	if (personas.length <= 0) {
		alertify.error("Search and click over for choose one");
		return false;
	}else{
		if (personas.length>0) {
			tablaPersonas(personas, table);
		}
		return true;
	}
	
}

function isInArray(value, array) {
  return array.indexOf(value) > -1;
}

function getValueTableUnidadesSeleccionadas(){
	var unidadesId = getArrayValuesColumnTable("tableUnidadesSelected", 1);
	var semanas= getArrayValuesColumnTable("tableUnidadesSelected", 6);
	var tabla = "tblUnidades";
	var unidades = [];
	$('#'+tabla+' tbody tr.yellow').each( function(){
		if ($(this).text().replace(/\s+/g, " ")!="") {
			var unidad = {};
			unidad.id = $(this).find('td').eq(1).text(),
			unidad.code = $(this).find('td').eq(2).text(),
			unidad.description = $(this).find('td').eq(3).text(),
			unidad.price = $(this).find('td').eq(4).text(),
			unidad.week = $(this).find('td').eq(5).text(),			
			unidad.season = $(this).find('td').eq(6).text(),
			unidad.costoClosing = $(this).find('td').eq(7).text(),
			unidad.lastYear = $(this).find('td').eq(9).text(),
			unidades.push(unidad); 
		}
	});
	return unidades;
}



function tablaPersonas(personas, table){
	var bodyHTML = '';
	    //creación del body
    for (var i = 0; i < personas.length; i++) {
        bodyHTML += "<tr>";
        for (var j in personas[i]) {
            bodyHTML+="<td>" + personas[i][j] + "</td>";
        };
        bodyHTML += "<td><div class='rdoField'><input class='primy' value='"+i+"'  type='radio' name='peopleType1'><label for='folio'>&nbsp;</label></div></td>";
        bodyHTML += "<td><div class='rdoField'><input disabled class='benefy' value='"+i+"' type='checkbox' name='peopleType2'><label for='folio'>&nbsp;</label></div></td>";
        bodyHTML += "<td><button type='button' class='alert button'><i class='fa fa-minus-circle fa-lg' aria-hidden='true'></i></button></td>";
        bodyHTML+="</tr>";
    }
    $('#'+table+' tbody').append(bodyHTML);

    defaultValues(table);
    onChangePrimary();
    deleteElementTable(table);
}

function onChangePrimary(){
	$(document).off( 'change', '.primy');
	$(".primy").change(function(){
		checkAllBeneficiary(this.value);
	});
}
function defaultValues(div){
	if ($('.primy').length>0) {
		var index = PrimaryPeople2(div);
		$('.primy')[index].checked = true;
		$( ".primy:checked" ).length
		checkAllBeneficiary(index);
	}
	
}
//reducir a una funcion
function deleteElementTable(div){
	$("#"+div+" tr").on("click", "button", function(){
		$(this).closest("tr").remove();
		updateValuePeople();
		if (!PrimaryPeople(div)) {
			defaultValues(div);
		}
	});
}

function updateValuePeople(){
	$(".primy").each(function (i) {
		this.value= i;
	});
}

function deleteElementTableUnidades(div){
	$("#"+div+" tr").on("click", "button", function(){
		$(this).closest("tr").remove();
		setValueUnitPrice();
	});
}
function deleteElementTableFuncion(div, funcion){
	$("#"+div+" tr").on("click", "button", function(){
		$(this).closest("tr").remove();
		funcion();
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

/*************************************/
/**@todo muestra el modal para asignar el tiempo de ocupacion de las unidades **/
/**@param --typeModal indica si se trata de agregar nuevas o cambiar unidades ya asignadas a un contrato **/
/*************************************/
function getWeeksDialog(unidades, ultimo, typeModal){
	showLoading('#dialog-Weeks', true);
	var unidades = unidades;
	dialogo = $("#dialog-Weeks").dialog ({
  		open : function (event){
	    	$(this).load ("contract/modalWeeks", function(){
	    		showLoading('#dialog-Weeks', false);
	    		ajaxSelects('contract/getFrequencies','try again', generalSelectsDefault, 'frequency');
	    		$("#weeksNumber").val(1);
				if( typeModal == "new" ){
					if (ultimo>0) {
						$("#firstYearWeeks").val(ultimo);
						$('#firstYearWeeks').attr('min',ultimo);
						$('#lastYearWeeks').attr('min',ultimo);
					}else{
						setYear("firstYearWeeks", 0);
						$('#firstYearWeeks').attr('min',getOnlyYear());
						$('#lastYearWeeks').attr('min',getOnlyYear());
					}
					$("#firstYearWeeks").prop('disabled', false);
					$("#lastYearWeeks").prop('disabled', false);
					$("#lastYearWeeks").val(2087);
				}else{
					$("#firstYearWeeks").prop('disabled', true);
					$("#lastYearWeeks").prop('disabled', true);
					$("#firstYearWeeks").val( $('#FirstYearCon').text() );
					$("#lastYearWeeks").val( $('#LastYearCon').text() );
					$('#firstYearWeeks').attr('min',ultimo);
					$('#lastYearWeeks').attr('min',ultimo);
				}
	    		
				
	    	});
		},
		autoOpen: false,
     	height: 360,
     	width: 400,
     	modal: true,
     	buttons: [{
	       	text: "Cancel",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');
	       }
	   	},{
       		text: "Ok",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			var Valorfrequency = getNumberTextInput("frequency");
       			if (Valorfrequency == 0) {
       				alertify.error("You should choose a frequency");
       			}else{
       				var frequency = $("#frequency option:selected" ).text();
       				var primero = $("#firstYearWeeks").val();
	       			var ultimo = $("#lastYearWeeks").val(); 
					//var ultimo = getYear( $("#firstYearWeeks").val() );
					if( typeModal == "new" ){
						tablUnidadades(unidades, frequency, primero, ultimo, "tableUnidadesSelected");	
						$(this).dialog('close');
						setValueUnitPrice();
					}else{
						tablUnidadades(unidades, frequency, primero, ultimo, "tableUnidades");	
						$(this).dialog('close');
					}
					//setYear("firstYearWeeks", 0);
	    		//setYear("lastYearWeeks", 10);
       			}
       			
       		}
     	}],
     close: function() {
     }
	});
	return dialogo;
}

function setYear(id, n){
	var d = new Date().getFullYear();
	$("#"+id).val(d + n);
}

function getYear(year){
	var first = $("#firstYearWeeks").val().trim();
	first = parseInt(first)
	if (year <= first + 10) {
		return year;
	}else{
		return (first + 10);
	}	
}

function getOnlyYear(){
	var d = new Date();
	var n = d.getFullYear();
	return n;
}

function PackReference(){
	showLoading('#dialog-Pack', true);
	dialogo = $("#dialog-Pack").dialog ({
  		open : function (event){
	    	$(this).load ("contract/modalPack" , function(){
	    		showLoading('#dialog-Pack', false);
	    		var precioUnidad = $("#precioUnidad").val();
				var precioUnidadPack = $("#unitPricePack").val(precioUnidad);
				$("#finalPricePack").val(precioUnidad);
				calcularPack();
	    	});
		},
		autoOpen: false,
     	height: maxHeight/2,
     	width: "25%",
     	modal: true,
     	buttons: [{
	       	text: "Cancel",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');
	       }
	   	},{
       		text: "Ok",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			$("#precioVenta").val($("#finalPricePack").val());
       			$("#packReference").val($("#quantityPack").val());
       			updateBalanceFinal();
       			$(this).dialog('close');
       		}
     	}],
     close: function() {
     }
	});
	return dialogo;
}
function modalDepositDownpayment(){
	showLoading('#dialog-Downpayment', true);
	dialogo = $("#dialog-Downpayment").dialog ({
  		open : function (event){
	    	getPlantillaDownpayment();
		},
		autoOpen: false,
     	height: maxHeight,
     	width: maxWidth,
     	modal: true,
     	buttons: [{
	       	text: "Cancel",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');
	       }
	   	},{
       		text: "Ok",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			var deposito = getNumberTextInput("finalPriceDownpayment");
       			var total = getNumberTextInput("downpaymentTotal");
       			if (deposito>total || deposito<= 0) {
       				alertify.error("Please Verify Total to Pay");
       			}else if(!isCreditCardValid()){
					alertify.error("Please Verify your Credit Card");
       			}else{
       				$("#depositoEnganche").val(deposito);
       				$(this).dialog('close');
       				updateBalanceFinal();	
       			}
       		}
     	}],
     close: function() {
     }
	});
	return dialogo;
}

function isCreditCardValid(){
	var payType = $("#tiposPago").val();
	if (payType == "1" || payType == "5") {
		return true;
	}else{
		var R = true;
		var creditCard = datosCard();
		if (creditCard) {
			for(var key in creditCard)
			{
				 if(!creditCard[key]) {
				 	R = false;
				 }
			}
			return R;
		}else{
			return false;
		}
	}
}

function recorrerObjeto(){
	var creditCard = datosCard();
	if (creditCard) {
		for(var key in creditCard)
		{
			 if(creditCard.hasOwnProperty(key) && creditCard[key]) {
			 	return true;
			 }else{
			 	return false;
			 }
		}
	}else{
		return false;
	}
}

function getPlantillaDownpayment(){
	var ajaxData =  {
		url: "contract/modalDepositDownpayment",
		tipo: "html",
		datos: {},
		funcionExito : addHTMLDownpayment,
		funcionError: mensajeAlertify
	};
	ajaxDATA(ajaxData);
}

function addHTMLDownpayment(datos){
	showLoading('#dialog-Downpayment', false);
	$("#dialog-Downpayment").html(datos);
	initEventosDownpayment();
}


function modalScheduledPayments() {
	var div = "#dialog-ScheduledPayments";
	dialogo = $(div).dialog ({
  		open : function (event){
  			showLoading(div, true);
			$(this).load ("contract/ScheduledPayments" , function(){
				showLoading(div, false);
				initEventosDownpaymentProgramados();
			});

		},
		autoOpen: false,
     	height: maxHeight,
     	width: maxWidth,
     	modal: true,
     	buttons: [{
	       	text: "Cancel",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');
	       }
	   	},{
       		text: "Ok",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			var totalProgramado = getNumberTextInput("totalProgramado"); 
       			var totalInicial = getNumberTextInput("downpaymentProgramado");
       			if (totalProgramado == totalInicial) {
       				$("#scheduledPayments").val($("#totalProgramado").val());
       				$(this).dialog('close');
       				updateBalanceFinal();
       			}else{
       				alertify.error("Verify total to pay");
       			}
				
       		}
     	}],
     close: function() {
     }
	});
	return dialogo;
}
function modalDiscountAmount(){
	var div = "#dialog-DiscountAmount";
	dialogo = $("#dialog-DiscountAmount").dialog ({
  		open : function (event){
  			if ($(div).is(':empty')) {
  				showLoading(div, true);
		    	$(this).load ("contract/modalDiscountAmount" , function(){
		 			showLoading(div, false);
		 			initEventosDiscount();
		    	});
		    }else{
		    	$(this).dialog('open');
		    }
		},
		autoOpen: false,
     	height: maxHeight,
     	width: maxWidth,
     	modal: true,
     	buttons: [{
	       	text: "Cancel",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');
	       }
	   	},{
       		text: "Ok",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			$("#totalDiscountPacks").val($("#totalDescPack").val());	
       			var a = $('#tbodytablePackgSelected').html();
				var b = $('#packSeleccionados').html(a);
				deleteElementTableFuncion("tableDescuentos", totalDescPackMain);
				$(this).dialog('close');
       		}
     	}],
     close: function() {
    	//$('#dialog-DiscountAmount').empty();
     }
	});
	return dialogo;
}

function tablUnidadades(unidades, frequency, primero, ultimo, tabla){
	//console.table(unidades);
	var bodyHTML = '';
	for (var i = 0; i < unidades.length; i++) {
		bodyHTML += "<tr>";
		bodyHTML += "<td>"+unidades[i].id+"</td>";
		bodyHTML += "<td>"+unidades[i].code+"</td>";
		bodyHTML += "<td>"+unidades[i].description+"</td>";
		bodyHTML += "<td>"+unidades[i].price+"</td>";
		bodyHTML += "<td>"+frequency+"</td>";
		bodyHTML += "<td>"+unidades[i].season+"</td>";
		bodyHTML += "<td>"+unidades[i].week+"</td>";
		bodyHTML += "<td style='display:none;'>"+ parseFloat(unidades[i].costoClosing).toFixed(2)+"</td>";
		bodyHTML += "<td>"+primero+"</td>";
        bodyHTML += "<td>"+ultimo+"</td>";
        bodyHTML += "<td><button type='button' class='alert button'><i class='fa fa-minus-circle fa-lg' aria-hidden='true'></i></button></td>";
        bodyHTML+="</tr>";
	}
   
    $('#' + tabla + ' tbody').append(bodyHTML);
    deleteElementTableUnidades(tabla);
    selectUnidadOcupada(tabla);
}

function selectUnidadOcupada(tabla){
	var ajaxDatos =  {
		url: "contract/selectUnidadesOcupadas",
		tipo: "json",
		datos: {
			unidades: getValueTableUnidades(tabla)
		},
		funcionExito : UnidadesOcupadas,
		funcionError: mensajeAlertify
	};
	ajaxDATAG(ajaxDatos, tabla);

}
function UnidadesOcupadas(data, table){
	var myTable = document.getElementById(table);
	var rows =  myTable.rows;
	for(j in data) {
		if (data[j]>0) {
			$(rows[parseInt(j)+2]).addClass("redI");
			alertify.error("Unit in red is in use");
		}
	}
	
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


function setValueInput(id, value){
	var elemento = document.getElementById("precioUnidad");
	elemento.value = value;
}

function getValueFromTable(id, posicion){
	var fullArray = $("#"+id).find("td");
	return fullArray.eq(posicion).text().trim();
}

function getValueFromTableSelected(id, posicion){
	var array = $("#"+id+" .yellow").find("td");
	return array.eq(posicion).text().trim();
}

function setValueUnitPrice(){
	var closingCost = getClosingCost();
	var precio = sumarArray(getArrayValuesColumnTable("tableUnidadesSelected", 4));
	$("#closingCostLabel").val(closingCost);
	$("#precioUnidad").val(precio);
	$("#precioVenta").val(precio);
	updateBalanceFinal();
}


function getDatailByID(id){
	var pickedup;
	$("#"+id).on("click", "tr", function(){
		if (pickedup != null) {
        	pickedup.removeClass("yellow");
			var id = $(this).find("td").eq(1).text().trim();
			if (dialogEditContract!=null) {
				dialogEditContract.dialog( "destroy" );
			}
            dialogEditContract = modalEditContract(id);
            dialogEditContract.dialog("open");
          }
          $( this ).addClass("yellow");
          pickedup = $(this);
	});
}

function modalEditContract(id){
	showLoading('#dialog-Edit-Contract',true);
	dialogo = $("#dialog-Edit-Contract").dialog ({
  		open : function (event){
	    	$(this).load("contract/modalEdit?id="+id , function(){
	 			showLoading('#dialog-Edit-Contract',false);
	 			getDatosContract(id);
	 			setEventosEditarContrato(id);
	    	});
		},
		autoOpen: false,
     	height: maxHeight,
     	width: maxWidth,
     	modal: true,
     	buttons: [
	   	{
       		text: "Close",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			$(this).dialog('close');
       		}
     	}],
     close: function() {
    	$('#dialog-Edit-Contract').empty();
     }
	});
	return dialogo;
}

function calcularPack(){

	var value = getNumberTextInput("porcentajePack");
	var valueQ = getNumberTextInput("quantityPack");
	var precioInicial = getNumberTextInput("unitPricePack");
	var precioFinal = getNumberTextInput("finalPricePack");

	$("#porcentajePack").on('keyup change click', function () {
		console.log(this.value);
	    if(this.value !== value) {
	    	value = this.value;
	      	var p = porcentajePack(this.value,precioInicial);
	       $("#quantityPack").val(p);
	       if(p+precioInicial>0){
	       		$("#finalPricePack").val(p+precioInicial);
	       }else{
	       		$("#finalPricePack").val(precioInicial);
	       }
	    }        
	});
	$("#quantityPack").on('keyup change click', function () {
		if (this.value) {
			if(this.value !== valueQ) {
		    	 valueQ = parseFloat(this.value);
		    	 var porcentaje = cantidad(valueQ, precioInicial);
		    	 $("#porcentajePack").val(porcentaje.toFixed(3));
		    	 if(valueQ+precioInicial>0){
		    	 	$("#finalPricePack").val(precioInicial+valueQ);
		    	 }else{
		    	 	$("#finalPricePack").val(precioInicial);
		    	 }
	    }      
		}  
	});
}
function porcentajePack(porcentaje, cantidad){
	return parseFloat(porcentaje/100)*cantidad;
}

function cantidad(cantidad, precio){
	return parseFloat((cantidad / precio)*100);
}

function porcetajeDownpayment(){
	var unitPrice = $("#downpayment").val();
	var downpayment =  $("#downpayment").val();
	$("input[name='engancheR']").on( 'change', function() {
    if( $(this).is(':checked') && $(this).val() == 'porcentaje' ) {
        alert("El checkbox con valor " + $(this).val() + " porcentaje ha sido seleccionado");
    }
    else if ($(this).is(':checked') && $(this).val() == 'cantidad') {
	 	alert("El checkbox con valor " + $(this).val() + " porcentaje ha sido seleccionado");
	}
});
}

function calcularDepositDownpayment(){
	var total = parseFloat($("#downpaymentPrice").val());
	var value = parseFloat($("#downpaymentGastos").val());
	$("#downpaymentTotal").val(value+total);
	$("#downpaymentGastos").on('keyup change click', function () {
	    if(this.value !== value) {
	    	value = parseFloat(this.value);
	       if(value+total>0){
	       		$("#downpaymentTotal").val(value+total);
	       }else{
	       		$("#downpaymentTotal").val(total);
	       }
	    }        
	});
}

////////////////////////////////////////////////////////////////
function selectMetodoPago(){
	$('#tiposPago').on('change', function() {
  		if(this.value != 1 && this.value != 5){
  			$("#datosTarjeta").show();
  		}else{
  			$("#datosTarjeta").hide();
  		}
  	});
}

function selectMetodoPagoProgramados(){
	$('#tiposPagoProgramados').on('change', function() {
  		if(this.value == 2){
  			$("#datosTarjetaProgramados").show();
  		}else{
  			$("#datosTarjetaProgramados").hide();
  		}
  	});
}
/////////////////////////////////////////////////////////////////
 function getUnidades(typeModal){
	var table = "";
	if( typeModal == "new" ){
		table = "tableUnidadesSelected";
	}else{
		table = "tableUnidades";
	}
	showLoading('#table-units',true);
	$.ajax({
		data:{
			property: $("#property").val(),
			unitType: $("#unitType").val(),
			season: $("#season").val(),
			interval: $("#interval").val(),
			view: $("#unitView").val(),
			units:getArrayValuesColumnTable(table, 1),
		},
		type: "POST",
		url: "contract/getUnidades",
		dataType:'json',
		success: function(data){
			showLoading('#table-units',false);
			if(data != null){
				alertify.success("Found "+ data.length);
				drawTable(data, 'add', "Details", "Unidades");
				//drawTable2(data,"Unidades","add","Details");
			}else{
				$('#contractstbody').empty();
				alertify.error("No records found");
			}
		},
		error: function(){
			alertify.error("Try again");
		}
	});
}

function initEventosDownpayment(){

	$( "#datePayDawnpayment" ).Zebra_DatePicker({
		format: 'm/d/Y',
		show_icon: false,
	});
	$( "#dateExpiracion" ).Zebra_DatePicker({
		format: 'm/d/Y',
		show_icon: false,
	});
	
	$('#datePayDawnpayment').val(getCurrentDate());
	var closingCost = getClosingCost();
	$("#downpaymentGastos").val(closingCost);
	var Downpayment = getNumberTextInput('montoTotal');
	if (Downpayment > 0) {
		var precioUnidadPack = $("#downpaymentPrice").val(Downpayment);
	}else{
		var precioUnidadPack = $("#downpaymentPrice").val(0);
	}
	calcularDepositDownpayment();
	selectMetodoPago();
	
	$('#btnAddmontoDownpayment').click(function (){
		var amount = getNumberTextInput("montoDownpayment");
		var added = getNumberTextInput("downpaymentTotal");

		if(amount>0 && amount <= added){
			tableDownpaymentSelected(amount);
			totalDownpayment();
			
		}else{
			alertify.error("The amount should be greater to zero and minus than total amount");
			errorInput("montoDownpayment", 2);
		}
		$("#montoDownpayment").val(0);
	});

	$('#btnCleanmontoDownpayment').click(function (){
		$("#montoDownpayment").val(0);
	});
	
	$('#numeroTarjeta').on('change', function() {
	$("#numeroTarjeta").val(splitNumberTarjeta());

	  $('#numeroTarjeta').validateCreditCard(function(result) {
	  	if (result.valid) {
	  		//$("#cardType").val(result.card_type.name);
	  		$("#numeroTarjeta").removeClass('is-invalid-input');

	  	}else{
	  		$("#numeroTarjeta").addClass('is-invalid-input');
	  	}
        });
	});
	  
}

function datosCard(){
	var tipoPago = $("#tiposPago").val();
	if(tipoPago != 1 && tipoPago != 5){
		var datos = {};
		datos.number = $('#numeroTarjeta').val().replace(/[^\d]/g, '');
		datos.type = $("#cardTypes").val();
		datos.dateExpiration = $("#dateExpiracion").val();
		datos.poscode = $("#codigoPostal").val();
		datos.code = $("#codigoTarjeta").val();
		return datos
	}else{
		return null;
	}
	
}

function splitNumberTarjeta(){
	var n =   $('#numeroTarjeta').val().replace(/[^\d]/g, '');
	if (n) {
		var numero = n.match(/.{1,4}/g);
		var tarjeta = "";
		for(var i = 0; i < numero.length; i++)
		{
			if (i!= numero.length-1) {
				tarjeta += numero[i] + "-";
			}else{
				tarjeta += numero[i];
			}
		}
		return tarjeta;
	}else{
		return "";
	}
	
}

function initEventosDownpaymentProgramados(){

	$( "#datePaymentPrg" ).Zebra_DatePicker({
		format: 'm/d/Y',
		show_icon: false,
	});
	$('#datePaymentPrg').val(getCurrentDate());
	var downpayment = getNumberTextInput("downpaymentTotal");
	var deposit = getNumberTextInput("depositoEnganche");
	$("#montoDownpaymentPrg").val(0);
	var programado = (downpayment-deposit).toFixed(2);
	$("#downpaymentProgramado").val(programado);
	selectMetodoPagoProgramados();

	$('#btnCleanmontoDownpaymentPrg').click(function (){
		$("#montoDownpaymentPrg").val(0);
	});

	$('#btnAddmontoDownpaymentPrg').click(function () {
		var amount = getNumberTextInput("montoDownpaymentPrg"); 
		var total = getNumberTextInput("downpaymentProgramado");
		if(amount>0 && amount <= total){
			tableDownpaymentSelectedPrg();
			totalDownpaymentPrg();
		}else{
			alertify.error("The amount should be greater to zero and minus than total amount");
		}
	});

	if($("#montoDownpaymentPrg").val()>0){
			tableDownpaymentSelectedPrg();
			totalDownpaymentPrg();
		}
}

function initEventosDiscount(){
	getTypeGifts();
	$("#btnAddmontoPack").click(function(){
		if ($("#montoPack").val()<=0) {
			alertify.error("the amount should be greater to zero");
			errorInput("montoPack", 2);
		}else if($("#tiposPakc").val()<=0){
			alertify.error("choose a pack type");
			errorInput("tiposPakc", 2);
		}else{
			PacksAdds();
		}
	});
}

function getTypeGifts(){
	var ajaxDatos =  {
		url: "contract/getTypesGiftContract",
		tipo: "json",
		datos: {},
		funcionExito : typesGift,
		funcionError: mensajeAlertify
	};
	ajaxDATA(ajaxDatos);
}

function typesGift(data){
	//console.table(data);
	generalSelects(data, "tiposPakc");
}

function PacksAdds(){
	var td = "";
	var IdTipoPack = $("#tiposPakc").val();
	var tipoPack = $("#tiposPakc option:selected").text();
	var monto = $("#montoPack").val();
		td = "<tr>";
		td += "<td style='display:none'>"+IdTipoPack+"</td>";
		td += "<td>"+tipoPack+"</td>";
		td += "<td class='montoPacks'>"+monto+"</td>";
		td += "<td><button type='button' class='alert button'><i class='fa fa-minus-circle fa-lg' aria-hidden='true'></i></button></td>";
		td += "</tr>";
	$("#tbodytablePackgSelected").append(td);
	totalDescPack();
	deleteElementTableFuncion("tablePackgSelected", totalDescPack);
}

function tableDownpaymentSelectedPrg(){
	var td = "";
	var tipoPago = $("#tiposPagoProgramados option:selected").text();
	var fecha = $("#datePaymentPrg").val();
	var monto = $("#montoDownpaymentPrg").val();
		td = "<tr>";
		td += "<td>"+fecha+"</td>";
		td += "<td>"+tipoPago+"</td>";
		td += "<td class='montoDownpaymentPrg'>"+monto+"</td>";
		td += "<td><button type='button' class='alert button'><i class='fa fa-minus-circle fa-lg' aria-hidden='true'></i></button></td>";
		td += "</tr>";
	$("#tbodyPagosPrgSelected").append(td);
	deleteElementTableFuncion("tablePagosPrgSelected", totalDownpaymentPrg);
}

function tableDownpaymentSelected(){
	var tipoPago = $("#tiposPago option:selected").text();
	var fecha = $("#datePayDawnpayment").val();
	var monto = $("#montoDownpayment").val();
	var td = "<tr>";
		td += "<td>"+fecha+"</td>";
		td += "<td>"+tipoPago+"</td>";
		td += "<td class='montoDownpayment'>"+monto+"</td>";
		td += "<td><button type='button' class='alert button'><i class='fa fa-minus-circle fa-lg' aria-hidden='true'></i></button></td>";
		td += "</tr>";
	$("#tbodyPagosSelected").append(td);
	deleteElementTableFuncion("tablePagosSelected", totalDownpayment);
}

function totalDownpayment(){
	var pagos = [];
	total = 0;
	var array = $("#tablePagosSelected .montoDownpayment");
	for (var i = 0; i < array.length; i++) {
		var cantidad = parseFloat($(array[i]).text());
		pagos.push(cantidad);
		total += cantidad;
	}
	$("#finalPriceDownpayment").val(total);
}

function totalDownpaymentPrg(){
	var pagos = [];
	totalCp = 0;
	var array = $("#tablePagosPrgSelected .montoDownpaymentPrg");
	for (var i = 0; i < array.length; i++) {
		var cantidad = parseFloat($(array[i]).text());
		pagos.push(cantidad);
		totalCp += cantidad;
	}
	var totalPrg = $("#downpaymentProgramado").val();
	$("#totalProgramado").val(totalCp);
	$("#pendiente").val(totalPrg-totalCp);
}

function totalDescPack(){
	var packs = [];
	totalCp = 0;
	var array = $("#tablePackgSelected .montoPacks");
	for (var i = 0; i < array.length; i++) {
		var cantidad = parseFloat($(array[i]).text());
		packs.push(cantidad);
		totalCp += cantidad;
	}
	$("#totalDescPack").val(totalCp);
}

function totalDescPackMain(){
	var packs = [];
	totalCp = 0;
	var array = $("#tableDescuentos .montoPacks");
	for (var i = 0; i < array.length; i++) {
		var cantidad = parseFloat($(array[i]).text());
		packs.push(cantidad);
		totalCp += cantidad;
	}
	$("#totalDiscountPacks").val(totalCp);
}

function getArrayValuesCheckbox(div){
	console.log(div);
	var items=[];
	var Primario = $("#"+ div +" .primy");
	for (var i = 0; i < Primario.length; i++) {
		items.push(Primario[i].checked);
	}
	return items;
}
function PrimaryPeople(div){
	var P = false;
	var items = getArrayValuesCheckbox(div);
	for (var i = 0; i < items.length; i++) {
		if (items[i]) {
			P = true;
		}
	}
	return P;
}
function PrimaryPeople2(div){
	var P = 0;
	var items = getArrayValuesCheckbox(div);
	for (var i = 0; i < items.length; i++) {
		if (items[i]) {
			P = i;
		}
	}
	return P;
}
function getArrayValuesSelectedColum(tabla, columna){
	var items=[];
	$('#'+tabla+' tbody tr.yellow td:nth-child('+columna+')').each( function(){
	   items.push( $(this).text().replace(/\s+/g, " "));       
	});
	return items;
}




/**
 * cambia los pantallas del modal con los tabs
 */
function changeTabsModalContract(screen, id){
	$('#tabsContrats .tabs-title').removeClass('active');
	$('#tabsContrats li[attr-screen=' + screen + ']').addClass('active');
	//muestra la pantalla selecionada
	$('#tabsContrats .tab-modal').hide();
	$('#' + screen).show();
	switch(screen){
		case "tab-CGeneral":
			//getDatosContract(id);
			break;
		case "tab-CAccounts":
			getAccounts( id, "account", "sale" );
			break;
		case "tab-CVendors":
			getDatosContractSellers(id);
			break;
		case "tab-CProvisions":
			getDatosContractProvisions(id);
			break;
		case "tab-COccupation":
			getDatosContractOcupation(id);
			//var heightNote = $('#tab-COccupation').height() - 250;
			//$('#fieldsetOccuCon').height( heightNote + "px" );
			break;
		case "tab-CDocuments":
			getDatosContractDocuments(id);
			break;
		case "tab-CNotes":
			getDatosContractNotes(id);
			/*var heightNote = $('#tab-CNotes').height() - 100;
			$('#fieldsetNoteCon').height( heightNote + "px" );*/
			break;
		case "tab-CFlags":
			getDatosContractFlags(id);
			break;
		case "tab-CFiles":
			getDatosContractFiles(id);
			break;


	}
}

function getDatosContractAccounts(id){
	console.log("Cuentas " + id);
}
function getDatosContractSellers(id){
	console.log("vendedores");
	
}
function getDatosContractProvisions(id){
var ajaxData =  {
		url: "contract/getGiftsByID",
		tipo: "json",
		datos: {
			'gift': id
		},
		funcionExito : verDatos,
		funcionError: mensajeAlertify
	};
	if ($("#tablaGiftsbody").is(':empty')) {
			showLoading("#tablaGiftsbody", true);
			ajaxDATA(ajaxData);
		}
}
function verDatos(data){
	if (data) {
		drawTableSinHead(data, "tablaGiftsbody");
	}else{
		alertify.error("No records found");
		showLoading("#tablaGiftsbody", false);
	}
	
}
function getDatosContractOcupation(id){
	if ($("#tableCOccupationSelectedbody").is(':empty')) {
		getWeeks(id);	
	}
}
function getDatosContractDocuments(id){
	getDocumentsCon(id);
}
function getDatosContractNotes(id){
	if ($('#tableCNotesSelectedBody').is(':empty')){
  		getNotes(id);
	}
	
}
function getDatosContractFlags(id){
	if ($("#tableFlagsListBody").is(':empty')) {
		getTypesFlags();
	}
	if ($("#flagsAsignedBody").is(':empty')) {
		getFlags(id);
		initEventosFlags();
	}
}
function getDatosContractFiles(id){
	getFiles(id);
}

function initEventosFlags(){
	$("#btnSAveFlags").click(function (){
		var flags = getArrayValuesSelectedColum("tableFlagsList", 1).length;
		if (flags>0) {
			SaveFlagsContract();
		}else{
			alertify.error("You should pick one");
		}
	});
	//activeEvent('btnNextStatus', 'nextStatusContract');
}

function activeEventClick(id, funcionA){
	$("#"+id).click(function(){
		funcionA();
	});
}
function deactiveEventClick(id){
	console.log("desactivado");
	$('#'+id).unbind('click');
}

function drawTableUnidades(data, funcion, cadena, table){
    var headHTML = "<th>"+cadena+"</th>";
    var bodyHTML = '';
    //creación de la cabecera
	for (var j in data[0]) {
		if (j != "IDFloorPlan") {
			headHTML+="<th>"+j+"</th>";
		}
    }
    //creación del body
    for (var i = 0; i < data.length; i++) {
        bodyHTML += "<tr>";
       	bodyHTML += '<td class="iconEdit" onclick="'+funcion+'('+data[i].ID+');"><i class="fa fa-info-circle" aria-hidden="true"></i></td>';
        for (var j in data[i]) {
        	if (data[i][j] != data[i].IDFloorPlan) {
        		if(data[i][j] == data[i].Description){
        			bodyHTML+="<td IDFloorPlan="+data[i].IDFloorPlan+">" + data[i][j] + "</td>";
        		}else if (data[i][j] != data[i].IDFloorPlan) {
        			bodyHTML+="<td IDFloorPlan="+data[i].IDFloorPlan+">" + data[i][j] + "</td>";
        		}
        		else{
        			bodyHTML+="<td>" + data[i][j] + "</td>";
        		}
        	}
        };
        bodyHTML+="</tr>";
    }
    $('#' + table + "thead" ).html(headHTML);
    $('#' + table + "tbody" ).html(bodyHTML);
    //pluginTables(table);
}

//var a = $('#tblUnidades tbody .yellow').html();
//var b = $('#tableUnidadesSelected tbody').html(a);


function getPeopleContract(id){
	$.ajax({
	    data:{
	        idContrato: id
	    },
	    type: "POST",
	    url: "contract/getPeopleContract",
	    dataType:'json',
	    success: function(data){
	    	drawTableSinHead(data, "peoplesContract");
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}
function getUnitiesContract(id){
	$.ajax({
	    data:{
	        idContrato: id
	    },
	    type: "POST",
	    url: "contract/getUnitiesContract",
	    dataType:'json',
	    success: function(data){
	    	if (data) {
	    		drawTableSinHeadUnit(data, "tableUnidadesContract");
	    	}
	    	
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}



function getDatosContract(id){
	$.ajax({
	    data:{
	        idContrato: id
	    },
	    type: "POST",
	    url: "contract/getDatosContractById",
	    dataType:'json',
	    success: function(data){

	    	var c = parseFloat(data['CollectionCost']);
	    	$("#CollectionCost").text(c);
	    	
	    	if(data["peoples"].length > 0){
				//var status = drawTableSinHeadReservationPeople(data["peoples"], "peoplesContract");
				drawTableSinHeadPeople(data["peoples"], "peoplesContract");
			}
			if (data["unities"]) {
				if (data['unities'].length>0) {
					drawTableSinHeadUnit(data["unities"], "tableUnidadesContract");
				}
				
			}
	    	
	    	drawTerminosVenta(data["terminosVenta"][0]);
	    	drawTerminoFinanciamiento(data["terminosFinanciamiento"][0]);
			var contraTemp = data["contract"][0];
			$('td.folioAccount').text(contraTemp.Folio);
			setHeightModal('dialog-Edit-Contract');
			//addFunctionality();
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function drawTableSinHeadPeople(data, table){
	$('#' + table).empty();
    for (var i = 0; i < data.length; i++) {
		var bodyHTML = '';
		bodyHTML += "<tr>";
        bodyHTML += "<td>" +data[i].ID + "</td>";
		bodyHTML += "<td>" +data[i].Name + "</td>";
		bodyHTML += "<td>" +data[i].lastName + "</td>";
		bodyHTML += "<td>" +data[i].address + "</td>";
        bodyHTML += "<td><div class='rdoField'><input class='primy' value='"+i+"'  type='radio'  name='peopleType1'><label for='folio'>&nbsp;</label></div></td>";
        bodyHTML += "<td><div class='rdoField'><input disabled class='benefy' value='"+i+"' type='checkbox' name='peopleType2'><label for='folio'>&nbsp;</label></div></td>";
        bodyHTML += "<td><button type='button' class='alert button'><i class='fa fa-minus-circle fa-lg' aria-hidden='true'></i></button></td>";
        bodyHTML+="</tr>";
		$('#' + table).append(bodyHTML);
		if(data[i].ynPrimaryPeople){
			$('.primy')[i].checked = true;
		}else{
			$('.benefy')[i].checked = true;
		}
    }
	onChangePrimary();
	deleteElementTable(table);
}

function drawTableSinHeadUnit(data, table){
	$('#' + table).empty();
    for (var i = 0; i < data.length; i++) {
		var bodyHTML = '';
		bodyHTML += "<tr>";
        bodyHTML += "<td>" +data[i].ID + "</td>";
		bodyHTML += "<td>" +data[i].UnitCode + "</td>";
		bodyHTML += "<td>" +data[i].description + "</td>";
		bodyHTML += "<td>" +data[i].Price + "</td>";
		bodyHTML += "<td>" +data[i].FrequencyDesc + "</td>";
		bodyHTML += "<td>" +data[i].SeasonDesc + "</td>";
		bodyHTML += "<td>" +data[i].WeeksNumber + "</td>";
		bodyHTML += "<td>" +data[i].FirstOccYear + "</td>";
		bodyHTML += "<td>" +data[i].LastOccYear + "</td>";
        bodyHTML += "<td><button type='button' class='alert button'><i class='fa fa-minus-circle fa-lg' aria-hidden='true'></i></button></td>";
        bodyHTML+="</tr>";
		$('#' + table).append(bodyHTML);
		
    }
	deleteElementTable(table);
}

function addFunctionality(){
	var div = "peoplesContract";
	selectTableUnico(div);
	tableOnclick(div);
}

function tableOnclick(id){
	$("#"+id).on("click", "tr", function(){
		var idPeople = $(this).find("td").eq(0).text().trim();
		showModalContractXD(idPeople);
	});
}

function getAccounts( id, typeInfo, typeAcc ){
	var id = getIDContrato();
	$.ajax({
		data:{
			idContrato: id,
			typeInfo:typeInfo,
			typeAcc: typeAcc
		},
		type: "POST",
		url: "contract/getAccountsById",
		dataType:'json',
		success: function(data){
			data["balance"] = parseFloat(data["balance"]);
			data["downpayment"] = parseFloat(data["downpayment"]);
			$("#balanceAccount").text(data["balance"]);
			if(typeInfo == "account"){
				var sale = data["sale"];

				var maintenance = data["maintenance"];
				var acc = data["acc"];
				if (sale.length > 0) {
					var sale = parsearSALE(sale);
					drawTable2( sale, "tableAccountSeller", false, "" );
					setTableAccount( sale, "tableSaleAccRes" );
				}
				
				if (maintenance.length > 0) {
					var maintenance = parsearSALE(maintenance);
					drawTable2( maintenance, "tableAccountMaintenance", false, "" );
					setTableAccount( maintenance, "tableMainteAccRes" );
				}

				for( i=0; i<acc.length; i++ ){
					var nameSafe = acc[i].accType;
					$('#btNewTransAcc').data( 'idAcc' + nameSafe, acc[i].fkAccId );
					console.log('idAcc' + nameSafe, acc[i].fkAccId);	
				}
			}else{
				var acc = data["acc"];
				if(acc.length > 0){
					drawTable2(acc, "tabletPaymentAccoun", false, "");
					$(".checkPayAcc").off( 'change' );
					$(".checkPayAcc").on('change', function (){
						var amoutCur = 0;
						$("input[name='checkPayAcc[]']:checked").each(function(){
							amoutCur = amoutCur + parseFloat($(this).val());
						});
						$('#amountSettledAcc').text( '$ ' + amoutCur.toFixed(2) );
					});
				}
			}
		},
		error: function(){
			alertify.error("Try again");
		}
	});
}

function getIDContrato(){
	var id = $("#idContratoX").text();
	return id;
}
function parsearSALE(sales){
	var Balance = 0;
	for(var i = 0; i < sales.length; i++){
		if( sales[i].Sign_transaction == "-1" ){
			Balance -= parseFloat(sales[i].Amount);
			sales[i].Balance = Balance.toFixed(2);
		}
		if( sales[i].Sign_transaction == "1" ){
			if (sales[i].Concept_Trxid != "Down Payment" || sales[i].Code != "SPDP") {
				Balance += parseFloat(sales[i].Amount);
				sales[i].Balance = Balance.toFixed(2);
			}
		}
		if( sales[i].Sign_transaction == "0" ){
			sales[i].Balance = Balance;
		}
		if (sales[i].Amount !=".0000") {
			sales[i].Amount = parseFloat(sales[i].Amount).toFixed(2);
		}else{
			sales[i].Amount = 0;
		}
		if (sales[i].Pay_Amount !=".0000") {
			sales[i].Pay_Amount = parseFloat(sales[i].Pay_Amount).toFixed(2);
		}else{
			sales[i].Pay_Amount = 0;
		}
		if (sales[i].Overdue_Amount !=".0000") {
			sales[i].Overdue_Amount = parseFloat(sales[i].Overdue_Amount).toFixed(2);
		}else{
			sales[i].Overdue_Amount = 0;
		}
		if (sales[i].Euros !=".0000") {
			sales[i].Euros = parseFloat(sales[i].Euros).toFixed(2);
		}else{
			sales[i].Euros = 0;
		}
		if (sales[i].Nederlands_Florins !=".0000") {
			sales[i].Nederlands_Florins = parseFloat(sales[i].Nederlands_Florins).toFixed(2);
		}else{
			sales[i].Nederlands_Florins = 0;
		}
	}
	// for(var i = 0; i < sales. length; i++){
	// 	if (sales[i].Balance == 0) {
	// 		sales[i].Balance = '';
	// 	}
	// }
	return sales;	
}

function setTableAccount(items, table){

	var balance = 0, balanceDeposits = 0, balanceSales = 0, defeatedDeposits = 0, defeatedSales = 0;
	var tempTotal = 0, tempTotal2 = 0;
	var downpayment = 0;
	var atrasadoDownpayment = 0;
	var atrasadoLoan = 0;
	var loan = 0;
	var sales = 0;
	
	for(i=0;i<items.length;i++){
		var item = items[i];
		if( item.Sign_transaction == "1"){
			tempTotal += parseFloat(item.Amount);
		}
		if (item.Sign_transaction == "-1") {
			tempTotal2 += parseFloat(item.Amount);
		}
		if( item.Concept_Trxid.trim() == "Down Payment" && item.Type.trim() == "Schedule Payment"){
			downpayment += parseFloat(item.Amount);
			atrasadoDownpayment += parseFloat(item.Overdue_Amount);
		}
		if( item.Concept_Trxid.trim() == "Sale"){
			sales += parseFloat(item.Amount);
		}
		if (item.Concept_Trxid.trim() == "Loan") {
			loan += parseFloat(item.Amount);
			atrasadoLoan += parseFloat(item.Overdue_Amount);
		}
	}
	balance = tempTotal - tempTotal2;

	//Actualiza el encabezado de las tablas 
	$('#' + table +  ' tbody tr td.balanceAccount').text('$ ' + balance.toFixed(2));
	$('#' + table +  ' tbody tr td.balanceDepAccount').text('$ ' + downpayment.toFixed(2));
	$('#' + table +  ' tbody tr td.balanceSaleAccount').text('$ ' + loan.toFixed(2));
	$('#' + table +  ' tbody tr td.defeatedDepAccount').text('$ ' + atrasadoDownpayment.toFixed(2));
	$('#' + table +  ' tbody tr td.defeatedSaleAccount').text('$ ' + atrasadoLoan.toFixed(2));
	
}
function setTableAccount12(items, table){
	//console.log(items)
	var balance = 0, balanceDeposits = 0, balanceSales = 0, defeatedDeposits = 0, defeatedSales = 0;
	for(i=0;i<items.length;i++){
		var item = items[i];
		var tempTotal = 0, tempTotal2 = 0;
		if( item.Sign_transaction == 1 ){
			tempTotal = parseFloat(item.Pay_Amount);
			tempTotal2 = parseFloat(item.Overdue_Amount);
		}
		if( item.Concept_Trxid.trim() == "Sale" ){
			if(tempTotal2 != 0){
				defeatedSales += tempTotal;
			}else{
				balanceSales += tempTotal;
			}
		}else{
			if(tempTotal2 != 0){
				defeatedDeposits += tempTotal;
			}else{
				balanceDeposits += tempTotal;
			}
		}
	}
	balance = balanceDeposits + balanceSales;
	
	$('#balanceAccount').text('$ ' + balance.toFixed(2));
	$('#' + table +  ' tbody tr td.balanceDepAccount').text('$ ' + balanceDeposits.toFixed(2));
	$('#' + table +  ' tbody tr td.balanceSaleAccount').text('$ ' + balanceSales.toFixed(2));
	$('#' + table +  ' tbody tr td.defeatedDepAccount').text('$ ' + defeatedDeposits.toFixed(2));
	$('#' + table +  ' tbody tr td.defeatedSaleAccount').text('$ ' + defeatedSales.toFixed(2));
	
}

function drawTerminosVenta(data){
	var price = parseFloat(data.ListPrice);
	var semanas = data.WeeksNumber;
	//var packReference = parseFloat(data.PackPrice);
	var SpecialDiscount = parseFloat(data.SpecialDiscount);
	var salePrice = parseFloat(data.NetSalePrice);
	var enganche = parseFloat(data.Deposit);
	var transferido = parseFloat(data.TransferAmt);
	var costoContract = parseFloat(data.ClosingFeeAmt);
	var packAmount = parseFloat(data.PackPrice);
	var balanceFinal = parseFloat(data.BalanceActual);
	var unidades = getValueTableUnidadesSize();

	$("#cventaPrice").text("$" + price.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
	$("#cventaWeeks").text(unidades);
	$("#cventaPackR").text("$" + SpecialDiscount.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
	$("#cventaSalePrice").text("$" + salePrice.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
	$("#cventaHitch").text("$" + enganche.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
	$("#cventaTransferA").text("$" + transferido.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
	$("#cventaCostContract").text("$" + costoContract.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
	//$("#cventapackAmount").text(packAmount.toFixed(2));
	$("#cventaFinanced").text("$" + balanceFinal.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
	//$("#cventaAmountTransfer").text(transferido);
}


function moneyFormat(price){
	price.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
	return "$" + price;
}

function drawTerminoFinanciamiento(data){
	var balanceFinal  = parseFloat(data.FinanceBalance);
	var pagoMensual = parseFloat(data.MonthlyPmtAmt);
	var porEnganche = parseFloat(data.porcentaje);
	var balanceFinal = parseFloat(data.TotalFinanceAmt);

	$("#cfbalanceFinanced").text("$" + balanceFinal.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
	$("#cfPagoMensual").text("$" + pagoMensual.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
	$("#cfEnganche").text("$" + porEnganche.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
	$("#typeFinance").text(data.FactorDesc);
	$("#totalFounding").text("$" + balanceFinal.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
	$("#totalMonthlyPayment").text("$" + pagoMensual.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));

}


function drawDataContract(data){
	var numero = "["+data.Folio+"-"+data.ID+"]";
	var nombreLegal= data.LegalName;
	var titulo = numero + " " + nombreLegal;
	var floorPlan = data.FloorPlan + ","+ data.FrequencyDesc;
	var year ="Year: "+ data.FirstOccYear;
	var status = "Status: " + data.StatusDesc;
	$("#editContractTitle").text(titulo);
	$("#editContracFloorPlan").text(floorPlan);
	$("#editContracYear").text(year);
	$("#editContracStatus").text(status);
}

function updateTourContrato(id){
	$.ajax({
	    data:{
	        idContrato: id,
	        tourID: $("#TourID").val()
	    },
	    type: "POST",
	    url: "contract/updateTourContrato",
	    dataType:'json',
	    success: function(data){
	    	if (data.afectados>0) {
	    		alertify.success(data.mensaje);
	    	}else{
	    		alertify.error(data.mensaje);
	    	}
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}
function setEventosEditarContrato(id){
	$("#btnUpdateTourID").click(function(){
		updateTourContrato(id);
	});
	$('#tabsContrats .tabs-title').on('click', function() { 
		changeTabsModalContract($(this).attr('attr-screen'), id);
	});

	$("#finTerminos").click(function(){
		gotoDiv('ContenidoModalContractEdit', 'tourEditCon');
	});
	$("#ventaCondi").click(function(){
		gotoDiv('ContenidoModalContractEdit', 'finTerminos');
	});
	$("#btnNextStatus").click(function(){
		dialogStatus = modalStatusCon();
		dialogStatus.dialog("open");
		//nextStatusContract();
	});
}

function addHTMLModalFin(data){
	$("#dialog-Financiamiento").html(data);
	initEventosFinanciamiento();
}

function showModalFin(id){

	var ajaxData =  {
		url: "contract/modalFinanciamiento",
		tipo: "html",
		datos: {
			idContrato: id
		},
		funcionExito : addHTMLModalFin,
		funcionError: mensajeAlertify
	};
	var modalPropiedades = {
		div: "dialog-Financiamiento",
		altura: maxHeight,
		width: maxWidth,
		onOpen: ajaxDATA,
		onSave: createNewContract,
		botones :[{
	       	text: "Cancel",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');
	         	
				var dialogEditContract = modalEditContract(id);
 				dialogEditContract.dialog("open");
	       }
	   	},{
       		text: "Ok",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			var totaltoPay = getNumberTextString("totalPagarF");
       			if (totaltoPay>0) {
       				updateFinanciamiento(id);
    				$(this).dialog('close');
    				var dialogEditContract = modalEditContract(id);
 					dialogEditContract.dialog("open");
       			}else{
       				alertify.error("Please Calculate the Monthly Payment");
       			}
       		}
     	}]
	};

	if (modalFin!=null) {
		modalFin.dialog( "destroy" );
	}
	modalFin = modalGeneral2(modalPropiedades, ajaxData);
	modalFin.dialog( "open" );
}
function showModalFin2(id){

	var ajaxData =  {
		url: "contract/modalFinanciamiento",
		tipo: "html",
		datos: {
			idContrato: id
		},
		funcionExito : addHTMLModalFin,
		funcionError: mensajeAlertify
	};
	var modalPropiedades = {
		div: "dialog-Financiamiento",
		altura: maxHeight,
		width: maxWidth,
		onOpen: ajaxDATA,
		onSave: createNewContract,
		botones :[{
	       	text: "Cancel",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');	         	
	       }
	   	},{
       		text: "Ok",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			var totaltoPay = getNumberTextString("totalPagarF");
       			if (totaltoPay>0) {
       				updateFinanciamiento(id);
    				$(this).dialog('close');
    				var dialogEditContract = modalEditContract(id);
 					dialogEditContract.dialog("open");
       			}else{
       				alertify.error("Please Calculate the Monthly Payment");
       			}
       		}
     	}]
	};

	if (modalFin!=null) {
		modalFin.dialog( "destroy" );
	}
	modalFin = modalGeneral2(modalPropiedades, ajaxData);
	modalFin.dialog( "open" );
}
function updateFinanciamiento(id){
	var fechaPP = $("#fechaPrimerPagoF").val();
    var factor = $("#terminosFinanciamientoF").val();
    var pagoMensual = getArrayValuesColumnTable("tablePagosSelectedFin", 3)[0];
    var meses = parseFloat($("#numeroMesesF").text().split(" ")[0]);
    var balanceActual = getNumberTextString("balanceFinanciarF");
    var ajaxData =  {
		url: "contract/updateFinanciamiento",
		tipo: "json",
		datos: {
			idContrato: id,
	        factor:factor,
	        pagoMensual: pagoMensual,
	        meses : meses,
	        fecha: fechaPP,
	        balanceActual: balanceActual
		},
		funcionExito : afterUpdateFinanciamiento,
		funcionError: mensajeAlertify
	};
	ajaxDATA(ajaxData);
}

function afterUpdateFinanciamiento(data){
	showLoading("#dialog-Financiamiento",false);
	showLoading("#dialog-Edit-Contract", false);
	alertify.success(data['mensaje']);
}

function initEventosFinanciamiento(){

	$( "#fechaPrimerPagoF" ).Zebra_DatePicker({
		format: 'm/d/Y',
		show_icon: false,
	});
	$('#fechaPrimerPagoF').val(getCurrentDate());
	var palabras = $("#terminosFinanciamientoF option:selected").text();
		palabras = palabras.split(",");
		$("#numeroMesesF").text(palabras[0]);
		$("#tasaInteresF").text(palabras[1]);

	$("#btnCalcularF").click(function(){
		var factor = $("#terminosFinanciamientoF option:selected").attr("code");
		var factor = parseFloat(factor.replace(",", "."));
		var pagoTotal = $('#balanceFinanciarF').text().trim().replace("$", "");
		pagoTotal = parseFloat(pagoTotal.replace(",", ""));
		var meses = parseFloat($("#numeroMesesF").text().split(" ")[0]);
		var pagoMensual = parseFloat((pagoTotal*factor));
		var pagoMensual = parseFloat(pagoMensual.toFixed(2));

		$("#pagoMF").text(pagoMensual);
		var cargo = getNumberTextInput("CargoCF");
		var totalMensual = parseFloat(pagoMensual) + parseFloat(cargo);
		$("#totalPagarF").text(totalMensual.toFixed(2));

	});
	$('#terminosFinanciamientoF').on('change', function() {
		var palabras = $("#terminosFinanciamientoF option:selected").text();
		palabras = palabras.split(",");
		$("#numeroMesesF").text(palabras[0]);
		$("#tasaInteresF").text(palabras[1]);
	});
}


//$("#terminosFinanciamientoF option:selected").attr('code')
//var palabras = $("#terminosFinanciamientoF option:selected").text()
//palabras[0] = "52 Meses";
//palabras[1] = ""



function setUnitiesContractPrueba(){
	$.ajax({
	    data:{
	        idContrato: 186
	    },
	    type: "POST",
	    url: "contract/createSemanaOcupacion",
	    dataType:'json',
	    success: function(data){
	    	//drawTableSinHead(data, "tableUnidadesContract");
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}


function modalSellers() {
	var div = "#dialog-Sellers";
	dialogo = $(div).dialog ({
  		open : function (event){
  				showLoading(div, true);
				$(this).load ("contract/modalSellers" , function(){
					showLoading(div, false);
					initEventosSellers();
				});
		},
		autoOpen: false,
     	height: maxHeight,
     	width: maxWidth,
     	modal: true,
     	buttons: [{
	       	text: "Cancel",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');
	       }
	   	},{
       		text: "Add",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
    			alertify.success("added employees");
    			$(this).dialog('close');
	       
       		}
     	}],
     close: function() {
    	$('#dialog-Sellers').empty();
     }
	});
	return dialogo;
}

function modalNewFileContract() {
	var div = "#dialog-newFile";
	dialogo = $(div).dialog ({
  		open : function (event){
  				showLoading(div, true);
				$(this).load ("contract/modalAddFileContract" , function(){
					ajaxSelects('contract/getDocType', 'try again', generalSelects, 'slcTypeFileUp');
					showLoading(div, false);
				});
		},
		autoOpen: false,
     	height: maxHeight/2,
     	width: "40%",
     	modal: true,
     	buttons: [{
	       	text: "Cancel",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');
	       }
	   	},{
       		text: "Add",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
				var arrayInput = ["fileDescription","fileToUpload"];
				var arraySelect = ["slcTypeFileUp"];
				if(verifyFile( arrayInput, arraySelect )){
					uploadFileCont();
				}else{
					var id = "saveFileCont";
					var form = $("#"+id);
					var elem = new Foundation.Abide(form, {});
					$('#'+id).foundation('validateForm');
					alertify.success("Please fill required fields");
				}
				
       		}
     	}],
     close: function() {
     }
	});
	return dialogo;
}

function initEventosSellers(){
	$("#btnSearchSeller").click(function(){
		getSellers();
	});
	$("#btnCleanSearchSeller").click(function(){
		$("#txtSearchSeller").val("");
	});
}

function getSellers(){
	var div = "#section-table-seller";
	showLoading(div, true);
	$.ajax({
	    data:{
	        idContrato: 186
	    },
	    type: "POST",
	    url: "contract/getSellers",
	    dataType:'json',
	    success: function(data){
	    	showLoading(div, false);
	    	drawTableId(data,"tableSellerbody");
	    	selectTable("tableSellerbody");
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function modalProvisions() {
	var div = "#dialog-Provisiones";
	dialogo = $(div).dialog ({
  		open : function (event){
  				showLoading(div, true);
				$(this).load ("contract/modalProvisions" , function(){
					showLoading(div, false);
					initEventosProvisions();
				});
		},
		autoOpen: false,
     	height: maxHeight/1.5,
     	width: "40%",
     	modal: true,
     	buttons: [{
	       	text: "Cancel",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');
	       }
	   	},{
       		text: "Save",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
    			alertify.success("added");
    			$(this).dialog('close');
	       
       		}
     	}],
     close: function() {
    	$('#dialog-Sellers').empty();
     }
	});
	return dialogo;
}

function initEventosProvisions(){
	$("#btnAddPovisionesDI").click(function(){
		if ($("#montoProvisiones").val()<=0) {
			alertify.error("the amount should be greater to zero");
			errorInput("montoProvisiones", 2);
		}else if($("#tiposPacksD").val()<=0){
			alertify.error("choose a pack type");
			errorInput("tiposPacksD", 2);
		}else{
			addProvisionesEventos();

		}
	});

	$("#btnCleanAmountProvisiones").click(function(){
		$("#montoProvisiones").val('');
	});

}

function addProvisionesEventos(){
	var td = "";
	var IdTipoPack = $("#tiposPacksD").val();
	var tipoPack = $("#tiposPacksD option:selected").text();
	var monto = $("#montoProvisiones").val();
		td = "<tr>";
		td += "<td style='display:none'>"+IdTipoPack+"</td>";
		td += "<td>"+tipoPack+"</td>";
		td += "<td class='montoPacks'>"+monto+"</td>";
		td += "<td><button type='button' class='alert button'><i class='fa fa-minus-circle fa-lg' aria-hidden='true'></i></button></td>";
		td += "</tr>";
	$("#tbodytableProvisionesDI").append(td);

	//totalDescPack();
	//deleteElementTableFuncion("tablePackgSelected", totalDescPack);
	deleteElementTableFuncion("tableProvisionesDI", addPro);
}

function addPro(){
	alertify.success("deleted");
}
function getWeeks(id){
	var div = "#content-OccupationCont";
	showLoading(div, true);
	$.ajax({
	    data:{
	        idContrato: id
	    },
	    type: "POST",
	    url: "contract/selectWeeksContract",
	    dataType:'json',
	    success: function(data){
	    	showLoading(div, false);
	    	//drawTableIdOcupacion(data,"tableCOccupationSelectedbody");
			
			
			if(data){
				drawTable2( data, "tableCOccupationSelected", false, "" );
			}else{
				noResultsTable("content-OccupationCont", "tableCOccupationSelected", "No results found");
				//alertify.error("No Results Found");
			}
			
	    },
	    error: function(){
	        alertify.error("Try again");
			showLoading(div, false);
	    }
	});
}

function getTypesFlags(id){
	var div = "#tableFlagsListBody";
	showLoading(div, true);
	$.ajax({
	    data:{
	        idContrato: id
	    },
	    type: "POST",
	    url: "contract/getTypesFlags",
	    dataType:'json',
	    success: function(data){
	    	showLoading(div, false);
	    	if (data) {
	    		drawTableFlags(data,"tableFlagsListBody");
	    		saveFlags("tableFlagsListBody");
	    	}else{
	    		alertify.error("No records found");
	    	}
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}
function saveFlags(div){
	var pickedup;
	$("#"+div).on("click", "tr", function(){
          if (pickedup != null) {
              pickedup.removeClass("yellow");
          }
          $( this ).addClass("yellow");
          pickedup = $(this);
          saveFlag();
	});
}
function saveFlag(){
	var flags = getArrayValuesSelectedColum("tableFlagsList", 1).length;
	if (flags>0) {
		SaveFlagsContract();
	}
}

function deleteSelectTable(table){
	$('#'+table+' tr').each( function(){
		$(this).removeClass("yellow");
	});
}

function drawTableFlags(data, table){
    var bodyHTML = '';
    for (var i = 0; i < data.length; i++) {
        bodyHTML += "<tr>";
        for (var j in data[i]) {
            bodyHTML+="<td>" + data[i][j] + "</td>";
        }
        bodyHTML+="<td>" + '<i class="fa fa-long-arrow-right fa-2x" aria-hidden="true"></i>' + "</td>";
        bodyHTML+="</tr>";
    }
    $('#' + table).html(bodyHTML);
}
function modalAddNotas() {
	var div = "#dialog-Notas";
	dialogo = $(div).dialog ({
  		open : function (event){
  				showLoading(div, true);
				$(this).load ("contract/modalAddNotas" , function(){
					showLoading(div, false);
					//initEventosSellers();
				});
		},
		autoOpen: false,
     	height: maxHeight/1.5,
     	width: "40%",
     	modal: true,
     	buttons: [{
	       	text: "Cancel",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');
	       }
	   	},{
       		text: "Save",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			SaveNotesContract();
    			$(this).dialog('close');
	       
       		}
     	}],
     close: function() {
    	$('#dialog-Notas').empty();
     }
	});
	return dialogo;
}
function modalGetAllNotes() {
	var id = getIDContrato();
	var div = "#dialog-Notas";
	dialogo = $(div).dialog ({
  		open : function (event){
  				showLoading(div, true);
				$(this).load ("contract/modalgetAllNotes?id="+id , function(){
					showLoading(div, false);
				});
		},
		autoOpen: false,
     	height: maxHeight,
     	width: maxWidth,
     	modal: true,
     	buttons: [{
	       	text: "Close",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');
	       }
	   	}],
     close: function() {
    	$(this).empty();
     }
	});
	return dialogo;
}

function SaveNote(){
	var noteType = $("#notesTypes").val();
	var noteDescription = $("#NoteDescription").val();
}

function SaveNotesContract(){
	var id = getIDContrato();// getValueFromTableSelected("contracts", 1);
	var noteType = $("#notesTypes").val();
	var noteDescription = $("#NoteDescription").val();
	$.ajax({
	    data:{
	        idContrato: id,
	        noteType:noteType,
	        noteDescription : noteDescription
	    },
	    type: "POST",
	    url: "contract/createNote",
	    dataType:'json',
	    success: function(data){
	    	alertify.success(data['mensaje']);
	    	getNotes(id);
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function getNotes(id){
	var url = "contract/getNotesContract";
	var div = "#tableCNotesSelectedBody";
	showLoading(div, true);
	$.ajax({
	    data:{
	        idContrato: id
	    },
	    type: "POST",
	    url: url,
	    dataType:'json',
	    success: function(data){
	    	//console.table(data);
	    	showLoading(div, false);
	    	if (data) {
	    		drawTableId(data,"tableCNotesSelectedBody");
	    	}else{
	    		alertify.error("No records found");
	    	}
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}
function getFlags(id){
	var url = "contract/getFlagsContract";
	var div = "#flagsAsignedBody";
	showLoading(div, true);
	$.ajax({
	    data:{
	        idContrato: id
	    },
	    type: "POST",
	    url: url,
	    dataType:'json',
	    success: function(data){
	    	showLoading(div, false);
	    	if (data) {
	    		drawTableFlagsAsigned(data,"flagsAsignedBody");
	    	}else{
	    		alertify.error("No records found");
	    	}
	    	
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function SaveFlagsContract(){

	var flags = getArrayValuesSelectedColum("tableFlagsList", 1);
	var id = getIDContrato();
	$.ajax({
	    data:{
	        idContrato: id,
	        flags:flags
	    },
	    type: "POST",
	    url: "contract/createFlags",
	    dataType:'json',
	    success: function(data){
	    	alertify.success(data['mensaje']);
	    	drawTableFlagsAsigned(data['banderas'],"flagsAsignedBody");
	    	if (data["banderas"]) {
	    		updateTagBanderas(data["banderas"]);
	    	}else{
	    		$("#flagsContracEdit").text("Flags:");
	    	}
	    	
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function updateTagBanderas(banderas){
	var textoBanderas = "Flags: ";
	for(var i = 0; i < banderas.length; i++){
		textoBanderas += banderas[i].FlagDesc;
		if (banderas.length != i) {
			textoBanderas += ",";
		}
	}
	$("#flagsContracEdit").text(textoBanderas);
}

function drawTableFlagsAsigned(data, table){
	var bodyHTML = '';
    for (var i = 0; i < data.length; i++) {
        bodyHTML += "<tr>";
        bodyHTML +="<td>" + '<i class="fa fa-long-arrow-left fa-2x" aria-hidden="true"></i>' + "</td>";
        for (var j in data[i]) {
            bodyHTML+="<td>" + data[i][j] + "</td>";
        };
        bodyHTML+="</tr>";
    }
    $('#' + table).html(bodyHTML);
    $('#'+table).off('click');
    deleteSelectFlag(table);
}
function drawTableFlagsAsignedFlags(data){
	alertify.success(data['mensaje']);
	if (data["banderas"]) {
		updateTagBanderas(data["banderas"]);
	}else{
		$("#flagsContracEdit").text("Flags:");
	}
	
}

function deleteSelectFlag(div){
	$("#"+div).on("click", "tr", function(){
		var id = $(this).find('td').eq(1).text();
        $(this).closest("tr").remove();
        deleteFlag(id);
	});
}

function deleteFlag(id){
	var idContrat = getIDContrato();// getValueFromTableSelected("contracts", 1);
	var datos =  {
		url: "contract/deleteFlag",
		tipo: "json",
		datos: {
			id:id,
			idContrat:idContrat
		},
		funcionExito : drawTableFlagsAsignedFlags,
		funcionError: mensajeAlertify
	};
	ajaxDATA(datos);
}

function modalStatusCon(){
	var div = "#dialog-Status";
	var id = getIDContrato();;
	dialogo = $(div).dialog ({
		open : function (event){
			showLoading(div, true);
			$(this).load ("contract/modalChangeStatus?id="+id , function(){
				showLoading(div, false);
			});
		},
		autoOpen: false,
     	height: maxHeight/2,
     	width: "40%",
     	modal: true,
     	buttons: [{
	       	text: "Cancel",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');
	       }
	   	},{
       		text: "Change",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
				var newStatus = $('#statusContract option:selected').text();
				if( newStatus == "Cancel" || newStatus == "Exchange" ){
					var msg = "Are you sure you want to cancel the contract?";
					alertify.confirm('Change Status.', msg, 
					function(){ nextStatusContract(); },
					function(){ }
					).moveTo(screen.width - 500,screen.height - 100).set('resizable',true).resizeTo('25%',210).isOpen(
						$('.ajs-dialog').css('min-width','100px')
					);
				}else{
					nextStatusContract();
				}
       		}
     	}],
     close: function() {
     }
	});
	return dialogo;
}

function nextStatusContract(){
	$("#iNextStatus").addClass("fa-spin");
	var id = getIDContrato();
	$.ajax({
	    data:{
	        idContrato: id,
			idNextStatus: $('#statusContract').val(),
			NextStatus: $('#statusContract option:selected').text()
	    },
	    type: "POST",
	    url: "contract/nextStatusContract",
	    dataType:'json',
	    success: function(data){
	    	dialogStatus.dialog('close');
	    	$("#iNextStatus").removeClass("fa-spin");
	    	$("#editContracStatus").text("Status: "+data['status']);
	    	/*if (data['next'] != null) {
	    		$("#btnNextStatus span").text("Next Status: "+data['next']);
	    	}else{
	    		$("#btnNextStatus").remove();
	    	}*/
	    	
	    	alertify.success(data['mensaje']);
	    		/*$("#btnNextStatus").click(function(){
					nextStatusContract();
				});*/
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}
/*** modal Account ***/
function opcionAccount(attrType){
	var div = "#dialog-accounts";
	dialogo = $(div).dialog ({
  		open : function (event){
			
			if ($(div).is(':empty')) {
  				showLoading(div, true);
				$(this).load ("contract/modalAccount" , function(){
					showLoading(div, false);
					$( "#dueDateAcc" ).Zebra_DatePicker({
						format: 'm/d/Y',
						show_icon: false,
					});
					$("#slcTransTypeAcc").attr('disabled', true);
					setDataOpcionAccount(attrType);
					getTrxType('contract/getTrxType', attrType, 'try again', generalSelectsDefault, 'slcTransTypeAcc');
					ajaxSelects('contract/getTrxClass', 'try again', generalSelectsDefault, 'slcTrxClassAcc');
					ajaxSelects('contract/getCurrency', 'try again', generalSelectsDefault, 'CurrencyTrxClassAcc');
				});
			}else{
				showLoading(div, true);
				$("#slcTransTypeAcc").attr('disabled', true);
				getTrxType('contract/getTrxType', attrType, 'try again', generalSelectsDefault, 'slcTransTypeAcc');
				setDataOpcionAccount(attrType);
				showLoading(div, false);
			}
		},
		autoOpen: false,
     	height: maxHeight,
     	width: maxWidth,
     	modal: true,
     	buttons: [{
	       	text: "Cancel",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');
	       }
	   	},{
       		text: "Save",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
				var id = "saveAccCont";
				var form = $("#"+id);
				var elem = new Foundation.Abide(form, {});
				var arrayInput = ["AmountAcc", "dueDateAcc"];
				var arraySelect = ["slcTransTypeAcc", "slcTrxClassAcc", "CurrencyTrxClassAcc"];
				if(attrType == "addPayAcc"){
					arraySelect = ["slcTransTypeAcc"];
				}
				if(!verifyAccount(arrayInput, arraySelect )){
					$('#'+id).foundation('validateForm');
					alertify.success("Please fill required fields (red)");
				}else{
					var amoutCur = 0;
					$("input[name='checkPayAcc[]']:checked").each(function(){
						amoutCur = amoutCur + parseFloat($(this).val());
					});
					if( amoutCur.toFixed(4) > parseFloat($('#AmountAcc').val().trim()).toFixed(4)){
						var msg = "The stated amount does not cover all of the selected concepts.</br>A partial payment was stored.";
						alertify.confirm(msg, function (e){
							if(e){
								saveAccCont(attrType);
							}
						});
					}else{
						saveAccCont(attrType);
					}
				}
       		}
     	}],
     close: function() {
    	$('#AmountAcc').val("");
    	$('#documentAcc').val("");
    	$('#referenceAcc').val("");
     }
	});
	return dialogo;
}

function setDataOpcionAccount(attrType){
	if(attrType == "newTransAcc"){
		$('#grpTrxClassAcc').show();
		$('#grpTablePayAcc').hide();
	}else{
		var trxType = $('#tab-CAccounts .active').attr('attr-accType');
		getAccounts( $('#btNewTransAcc').data( 'idRes' ), "payment", trxType );
		$('#grpTrxClassAcc').hide();
		$('#grpTablePayAcc').show();
	}
	var accCode = $('#tab-CAccounts .active').attr('attr-accCode');
	var idAccColl = $('#btNewTransAcc').data( 'idAcc' + accCode );
	$('#accountIdAcc').text( idAccColl );
	$('#dueDateAcc').val(getCurrentDate());
	$('#legalNameAcc').text($('#editContractTitle').text());

	var PRECIOS = $('.balanceAccount').text().split("$");
	var total = "Total: $"+ PRECIOS[1] + "  Sales: $"+ PRECIOS[2] + "  Loan: $" + PRECIOS[3];
	$('#balanceAcc').text(total);
}

function saveAccCont(attrType){
	var idTrans = new Array();
	var valTrans = new Array();
	var trxClass = new Array();
	if( attrType == "addPayAcc" ){
		$('.checkPayAcc:checked').each( function() {
			idTrans.push($(this).attr('id'));
			valTrans.push($(this).val());
			trxClass.push($(this).attr('trxclass'));
		});
	}
	var accCode = $('#tab-CAccounts .active').attr('attr-accCode');
	var idAccCon = $('#btNewTransAcc').data( 'idAcc' + accCode );
	//showAlert(true,"Saving changes, please wait ....",'progressbar');
	msgContract = alertify.success('Saving changes, please wait ....', 0);
	$.ajax({
		data: {
			attrType:attrType,
			accId:idAccCon,
			trxTypeId:$('#slcTransTypeAcc').val(),
			trxClassID:$('#slcTrxClassAcc').val(),
			currency:$("#CurrencyTrxClassAcc").val().trim(),
			amount:$('#AmountAcc').val(),
			dueDt:$('#dueDateAcc').val(),
			doc:$('#documentAcc').val(),
			remark:$('#referenceAcc').val(),
			idTrans:idTrans,
			valTrans:valTrans,
			trxClass:trxClass,
		},type: "POST",
		dataType:'json',
		url: 'contract/saveTransactionAcc'
	}).done(function( data, textStatus, jqXHR ) {

		if( data.success ){
			getAccounts( $('#btNewTransAcc').data( 'idRes' ), "account", "" );
			$("#dialog-accounts").dialog('close');
			//showAlert(false,"Saving changes, please wait ....",'progressbar');
			msgContract.dismiss();
		}else{
			$("#dialog-accounts").dialog('close');
			//showAlert(false,"Saving changes, please wait ....",'progressbar');
			msgContract.dismiss();
		}
	}).fail(function( jqXHR, textStatus, errorThrown ) {
		//showAlert(false,"Saving changes, please wait ....",'progressbar');
		msgContract.dismiss();
		alertify.error("Try Again");
	});
}

function getTrxType(url, attrType, errorMsj, funcion, divSelect){
	var trxType = $('#tab-CAccounts .active').attr('attr-accType');
	$.ajax({
		type: "POST",
		data: {
			attrType:attrType,
			trxType:trxType
			
		},
		url: url,
		dataType:'json',
		success: function(data){
			funcion(data, divSelect);
			$("#slcTransTypeAcc").attr('disabled', false);
		},
		error: function(){
			$("#slcTransTypeAcc").attr('disabled', false);
			alertify.error(errorMsj);
		}
	});
}

function verifyAccount( inputArray, selectArray ){
	var v = true;
	for (var i = 0; i < inputArray.length; i++){
		 if($('#'+inputArray[i]).val().trim().length <= 0){
		 	v = false;
		 }
	}
	
	for (var i = 0; i < selectArray.length; i++){
		if($('#'+selectArray[i]).val() == 0){
		 	v = false;
		}
	}
	
	//AmountAcc
	if( $('#grpTablePayAcc').is(":visible") ){
		if( $("input[name='checkPayAcc[]']:checked").length == 0){
			v = false;
		}else{
			var amoutCur = $('#amountSettledAcc').text();
			amoutCur = amoutCur.replace("$", "");
			amoutCur = parseFloat(amoutCur.trim());
			if($('#AmountAcc').val().trim() > amoutCur){
				v = false;
				alertify.error("The amount of selected positions is less than the payment amount captured.");
			}
		}
	}
	
	return v;
}

function uploadFileCont(){
	
	//showAlert(true,"Saving changes, please wait ....",'progressbar');
	msgContract = alertify.success('Saving changes, please wait ....', 0);
	
	var id = getIDContrato();
	//creamos la variable Request 
	if(window.XMLHttpRequest) {
 		var Req = new XMLHttpRequest(); 
 	}else if(window.ActiveXObject) { 
 		var Req = new ActiveXObject("Microsoft.XMLHTTP"); 
 	}	
	
	var data = new FormData(); 
	
	data.append('id',id);
	data.append('description',$('#fileDescription').val().trim());
	data.append('typeDoc',$('#slcTypeFileUp').val());
		
	//var ruta = new Array();
	//var archivos = $('#fileToUpload').prop('files')[0];	
	var archivos = document.getElementById("fileToUpload");//Damos el valor del input tipo file
 	var archivo = archivos.files; //obtenemos los valores de la imagen
	data.append('image',archivo[0]);
	ruta = "assets/pdf/";
	
	//rutaJson = JSON.stringify(ruta);
	data.append('ruta',ruta);
		
	//data.append('nameImage',$('#imagenName').val());
		
	//cargamos los parametros para enviar la imagen
	Req.open("POST", "contract/saveFile", true);
		
	//nos devuelve los resultados
	Req.onload = function(Event) {
		//Validamos que el status http sea ok 
		if (Req.status == 200) {
			/*var obj = JSON.parse(Req.responseText);
			if(obj.success){
				alertify.success(obj.message);
			}else{
				alertify.error("Try again");
			}*/
			alertify.success("File uploaded correctly");
			getFiles(id);
			var div = "#dialog-newFile";
			$(div).dialog('close');
			//showAlert(false,"Saving changes, please wait ....",'progressbar');
			msgContract.dismiss();
		} else { 
			getFiles(id);
			alertify.error("Try again");
			var div = "#dialog-newFile";
			$(div).dialog('close');
			//showAlert(false,"Saving changes, please wait ....",'progressbar');
			msgContract.dismiss();
		} 	
	};
		
	//Enviamos la petición 
 	Req.send(data);	
}

function getFiles(id){
	var url = "contract/getFilesContract";
	//var div = "#tableCFilesSelected";
	showLoading("#tableCFilesSelected", true);
	$.ajax({
	    data:{
	        idRes: id
	    },
	    type: "POST",
	    url: url,
	    dataType:'json',
	    success: function(data){
			console.log(data);
			if(data.length > 0){
				//drawTable2(data, "tableCFilesSelected", "deleteFile", "eliminar");
				drawTableFiles(data, "tableCFilesSelected", "seeDocumentCon", "See", "deleteFile");
			}else{
				//noResultsTable("contentTableFile", "tableCFilesSelected", "No results found");
				alertify.error("No Results Found");
			}
			
			showLoading("#tableCFilesSelected", false);
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function deleteFile(idFile){
	alertify.confirm("To delete the file?", function (e) {
		if (e) {
			showLoading("#tableCFilesSelected", true);
			$.ajax({
				data:{
					idFile: idFile
				},
				type: "POST",
				url: "contract/deleteFile",
				dataType:'json',
				success: function(data){
					var id = $("#idContratoX").text().trim();
					getFiles(id);
					showLoading("#tableCFilesSelected", false);
					alertify.success("deleted file");
				},
				error: function(){
					alertify.error("Try again");
					showLoading("#tableCFilesSelected", false);
				}
			});
			// user clicked "ok"
		} else {
			// user clicked "cancel"
		}
	});
	//alert('id');
}

function verifyFile( inputArray, selectArray ){
	
	var v = true;
	for (var i = 0; i < inputArray.length; i++){
		 if($('#'+inputArray[i]).val().trim().length <= 0){
		 	v = false;
		 }
	}
	
	for (var i = 0; i < selectArray.length; i++){
		if($('#'+selectArray[i]).val() == 0){
		 	v = false;
		}
	}
	
	if($('#fileToUpload').val().length > 0){
		var archivos = document.getElementById("fileToUpload");//Damos el valor del input tipo file
		var archivo = archivos.files; //obtenemos los valores de la imagen
		var sizeByte = parseInt(archivo[0].size / 1024);
		//var sizekiloByte = parseInt(sizeByte / 1024);
		if( sizeByte > 2048){
			v = false;
			alertify.error("the file must not exceed 2 mb");
		}
	}
	
	return v;
}

function pruebas(){
	$.ajax({
	    data:{
	        id: 2,
	    },
	    type: "POST",
	    url: "people/peopleDetailView",
	    dataType:'html',
	    success: function(data){
	    	console.table(data);
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}


function showModalContractXD(id){
	var ajaxData =  {
		url: "people/peopleDetailView",
		tipo: "html",
		datos: {
			id:id
		},
		funcionExito : managePeopleRequest,
		funcionError: mensajeAlertify
	};
	var modalPropiedades = {
		div: "dialog-Contract",
		altura: maxHeight,
		width: maxWidth,
		onOpen: ajaxDATA,
		onSave: createNewContract,
		botones :[{
			text: "Close",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');
	         }
		},{
			text: "Save and Close",
			"class": 'dialogModalButtonAccept',
			click: function() {
				if (verifyContractALL()) {
					if ($('#tableUnidadesSelected tr').hasClass('redI')) {
						alertify.error("Verify the Unities");
					}else{
						createNewContract();
					}
					
				}
				
			}
		},{
			text: "Save",
			"class": 'dialogModalButtonAccept',
			click: function() {
				if (verifyContractALL()) {
					createNewContract();
				}
			}
		}]
	};

	if (addContract!=null) {
		addContract.dialog( "destroy" );
	}
	addContract = modalGeneral2(modalPropiedades, ajaxData);
	addContract.dialog( "open" );
	getDatosP(id);
}

function managePeopleRequest(data){
	$("#dialog-Contract").html(data);
}
function getDatosP(id){
	var ajaxData =  {
		url: "people/getPeopleById",
		tipo: "json",
		datos: {
			id:id
		},
		funcionExito : manageDatosPeople,
		funcionError: mensajeAlertify
	};
	ajaxDATA(ajaxData);
}

function manageDatosPeople(data){
	var item = data.item[0];
			$('#textName').val(item.Name.trim().toUpperCase());
			$('#textMiddleName').val(item.SecondName.trim());
			$('#textLastName').val(item.LName.trim());
			$('#TextSecondLastName').val(item.LName2.trim());
			
			if(item.Gender == "M"){
				$('#RadioMale').prop("checked", true);
			}else if(item.Gender == "F"){
				$("#RadioFemale").prop("checked", true);
			}
			$('#textBirthdate').val(item.birthdate);
			$('#textWeddingAnniversary').val(item.Anniversary);
			$('#textNationality').val(item.Nationality.trim())
			$('#textQualification').val(item.Qualification.trim());
			$('#textStreet').val(item.Street1.trim());
			$('#textColony').val(item.Street2.trim());
			$('#textCity').val(item.City.trim());
			$('#textPostalCode').val(item.ZipCode.trim());
			if(item.pkCountryId != null || item.pkCountryId == ""){
				$("select#textCountry").val(item.pkCountryId);
			}else{
				$("select#textCountry").val(0);
			}
			$('#textState').empty();
			$('#textState').append('<option value="0" code="0">Select your state</option>');
			if(data.states.length > 0){
				for(i=0;i<data.states.length;i++){
					var state = data.states[i];
					$('#textState').append('<option value="' + state.pkStateId + '" code="' + state.StateCode + '">' + state.StateDesc + '</option>');
				}
			}
			if(item.pkStateId != null || item.pkStateId == ""){
				$("select#textState").val(item.pkStateId);
			}else{
				$("select#textState").val(0);
			}
			
			$('#textPhone1').val(item.phone1.trim());
			$('#textPhone2').val(item.phone2.trim());
			$('#textPhone3').val(item.phone3.trim());
			$('#textEmail1').val(item.email1.trim());
			$('#textEmail2').val(item.email2.trim());
			
			$('#textTypeSeller').empty();
			$('#textTypeSeller').append('<option value="0" code="0">Select a type of seller</option>');
			for(i=0;i<data.peopleType.length;i++){
				var peopleType = data.peopleType[i];
				$('#textTypeSeller').append('<option value="' + peopleType.pkPeopleTypeId + '" code="' + peopleType.PeopleTypeCode + '">' + peopleType.PeopleTypeDesc + '</option>');
			}
			
			if(item.pkEmployeeId > 0){
				$("#checkPeopleEmployee").prop( "checked", true );
				$('#textCodeCollaborator').val(item.EmployeeCode.trim());
				$('#textInitials').val(item.InitialsEmplo.trim());
				$('#textCodeNumber').val(item.NumericCode);
				$('#textTypeSeller').val(item.fkPeopleTypeId);
				$('#textRoster').val(0);
				$('#textTypeSeller').val(item.fkPeopleTypeId);
				$('#textRoster').val(item.fkVendorTypeId);
			}
			
			$("#idPeople").data("pkPeopleId",item.pkPeopleId);
			$("#idPeople").data("pkEmployeeId",item.pkEmployeeId);
			$('#imgCloseModal').off();
			$('.imgCloseModal').on('click', function() {  hideModal(); });
			$('body, html').animate({
				scrollTop: '0px'
			}, 0);
}


function drawTableIdOcupacion(data, table){
	var primero = data[0].FirstOccYear;
	var last = data[0].LastOccYear;
	var rango = last - primero;
	var bodyHTML = '';
	for (var i = 0; i < data.length; i++) {
        	for(var j = 0; j <= rango; j++){
        		var year = primero + j;
        		bodyHTML += "<tr>";
        		bodyHTML+="<td>" + data[i].Descripcion + "</td>";
        		bodyHTML+="<td>" + year + "</td>";
        		bodyHTML+="<td>" + data[i].Intv + "</td>";
        		bodyHTML+="</tr>";
        	} 	
        }
    $('#' + table).html(bodyHTML);
    selectTableUnico("tableCOccupationSelectedbody");

	$("#"+"tableCOccupationSelected").on("click", "tr", function(){
    	showModalDetailWeek();
	});
}

function pruebaAltaContrato(){
	$("#legalName").val(makeRandonNames(13));
	$("#selectLanguage").val(getRandomInt(2,2));
	$("#TourID").val(0);
	getPeopleRandom();
	ajaxUnidadesR();
}



function makePeople(datos){
	var numeroPersonas = getRandomInt(1,6);
	var personas = [];
	for(var i = 0; i < numeroPersonas; i++){
		var posicion = getRandomInt(1, datos.items.length);
		var p = [
			datos.items[posicion].ID,
			datos.items[posicion].Name,
			datos.items[posicion].LastName,
			datos.items[posicion].Street
		]
		personas.push(p);
	}

	tablaPersonas(personas, 'tablePeopleSelected');
}

// function getUnitidadesRandom(){
// 	var unidades = ajaxUnidadesR();
// 	var frecuencias = ["Every Year", "Even Years", "Odd Years"];
// 	var frequency = frecuencias[getRandomInt(0,2)]
// 	var primero = 2016;
// 	var ultimo = getRandomInt(2016, 2025);
//     tablUnidadades(unidades, frequency, primero, ultimo);	
// 	setValueUnitPrice();
// }

function recivePeople(datos){

	var frecuencias = ["Every Year", "Even Years", "Odd Years"];
	var frequency = frecuencias[getRandomInt(0,2)]
	var primero = 2016;
	var ultimo = getRandomInt(2016, 2025);
	var numeroUnidades = getRandomInt(1,6);
	unidades = [];
	for(var i = 0; i < numeroUnidades; i++){
		var posicion = getRandomInt(1, datos.length);
		var unidad = {};
		unidad.id = datos[posicion].ID;
		unidad.code = datos[posicion].UnitCode;
		unidad.description = datos[posicion].FloorPlanDesc;
		unidad.price = datos[posicion].Price;
		unidad.week = datos[posicion].Week;
		unidad.season = datos[posicion].SeasonDesc;
		unidad.costoClosing = datos[posicion].ClosingCost;
		unidades.push(unidad);
	}

	//console.table(unidades);
	tablUnidadades(unidades, frequency, primero, ultimo, "tableUnidadesSelected");	
	setValueUnitPrice();
}

/*
var unidad = {};
unidad.id = $(this).find('td').eq(1).text(),
unidad.code = $(this).find('td').eq(2).text(),
unidad.description = $(this).find('td').eq(3).text(),
unidad.price = $(this).find('td').eq(4).text(),
unidad.week = $(this).find('td').eq(5).text(),
unidad.season = $(this).find('td').eq(6).text(),
unidad.costoClosing = $(this).find('td').eq(7).text(),
unidades.push(unidad);
*/


function ajaxUnidadesR(){
	var ajaxData =  {
		url: "contract/getUnidades",
		tipo: "json",
		datos: {
			property:0,
			unitType:0,
			season:0,
			interval:0,
			view:0
		},
		funcionExito : recivePeople,
		funcionError: mensajeAlertify
	};
	ajaxDATA(ajaxData);
}

function getPeopleRandom(){
	var ajaxData =  {
		url: "people/getPeopleBySearch",
		tipo: "json",
		datos: {
			search:'',
			peopleId:false,
			lastName:true,
			name:true,
			advanced:'',
			typePeople:'',
			page:0
		},
		funcionExito : makePeople,
		funcionError: mensajeAlertify
	};
	ajaxDATA(ajaxData);
}


function testContract(){
	var ajaxData =  {
		url: "contract/pruebasContract",
		tipo: "json",
		datos: {
			//card:datosCard()
		},
		funcionExito : table,
		funcionError: mensajeAlertify
	};
	ajaxDATA(ajaxData);
}
function testContract2(){
	var fechaPP = "2016-08-23";
	var id = 2775;
    var pagoMensual = 800;
    var meses = 12;
    var ajaxData =  {
		url: "contract/pruebasContract",
		tipo: "json",
		datos: {
			idContrato: id,
	        pagoMensual: pagoMensual,
	        meses : meses,
	        fecha: fechaPP
		},
		funcionExito : afterUpdateFinanciamiento,
		funcionError: mensajeAlertify
	};
	ajaxDATA(ajaxData);
}

function table(datos){
	// console.table(datos['balance']);
	// console.log(datos['balance'].financeBalance);
	// if (datos['balance'].financeBalance >0) {
	// 	console.log("lo voy a mostrar");
	// }else{
	// 	console.log("no lo muestro");
	// }
	// console.table(datos);
}

function showCreditCardAS(){
	var accCode = $('#tabsContratsAccounts .active').attr('attr-accCode');
	var idAccColl = $('#btNewTransAcc').data( 'idAcc' + accCode );
	if (idAccColl) {
		var ajaxData =  {
		url: "contract/modalCreditCardAS",
		tipo: "html",
		datos: {
			idAccount: idAccColl
		},
		funcionExito : addHTMLDIV,
		funcionError: mensajeAlertify
	};
	var modalPropiedades = {
		div: "dialog-CreditCardAS",
		altura: 540,
		width: 540,
		onOpen: ajaxDATA,
		onSave: createCreditCard,
		botones :[{
	       	text: "Cancel",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');
	       }
	   	},{
       		text: "Save",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			if (validateCreditCardAS()) {
       				createCreditCard(idAccColl);
       				$(this).dialog('close');
       			}else{
       				alertify.error("Verify Card Data");
       			}
       		}
     	}]
	};

	if (modalFin!=null) {
		modalFin.dialog( "destroy" );
	}
	modalFin = modalGeneral2(modalPropiedades, ajaxData);
	modalFin.dialog( "open" );
}else{
	alertify.error("ID Account error");
}
	
}

function addHTMLDIV(data){
	$("#dialog-CreditCardAS").html(data);

	$( "#dateExpiracionAS" ).Zebra_DatePicker({
		format: 'm/d/Y',
		show_icon: false,
	});
}

function datosCardAS(){
	var datos = {};
		datos.number = $('#numeroTarjetaAS').val().replace(/[^\d]/g, '');
		datos.type = $("#cardTypesAS").val();
		datos.dateExpiration = $("#dateExpiracionAS").val();
		datos.poscode = $("#codigoPostalAS").val();
		datos.code = $("#codigoTarjetaAS").val();
	return datos
}

function validateCreditCardAS(){
	var R = true;
	var creditCard = datosCardAS();
		if (creditCard) {
			for(var key in creditCard)
			{
				 if(!creditCard[key]) {
				 	R = false;
				 }
			}
			return R;
		}else{
			return false;
		}
}


function createCreditCard(id){
	var ajaxData =  {
		url: "contract/createCreditCardAcc",
		tipo: "json",
		datos: {
			idAccount: id,
			card: datosCardAS(),
		},
		funcionExito : creditCardMsg,
		funcionError: mensajeAlertify
	};
	ajaxDATA(ajaxData);
}

function creditCardMsg(data){
	if (data["status"] == 1) {
		alertify.success(data["mensaje"]);
	}else{
		alertify.error(data["mensaje"]);
	}
	
}
function savePeople(){
	
	var personas = getSizeTablePeoples();
	if (personas <= 0) {
			alertify.error("You must add at least one person");
	}else{
		msgSavePeople = alertify.success('Saving People, please wait ....', 0);
			$.ajax({
				data: {
					peoplesMOD: getValueTablePersonasMOD(),
					id: $("#idContratoX").text(),
					LegalName: $("#legalNameEdit").val()
				},
				type: "POST",
				dataType:'json',
				url: 'contract/savePeople'
			}).done(function( data, textStatus, jqXHR ) {
				msgSavePeople.dismiss();
				if(data.items.length > 0){
					$("#legalNameEdit").val(data.legalName);
					drawTableSinHeadPeople(data.items, "peoplesContract");
				}
			}).fail(function( jqXHR, textStatus, errorThrown ) {
				msgSavePeople.dismiss();
				alertify.error("Try again");
			});
		//}
	}
}

function getSizeTablePeoples(){
	var tabla = "peoplesContract";
	return $( "#"+tabla+" tr" ).length;
}

function getSizeTableUnits(){
	var tabla = "tableUnidades";
	return $( "#"+tabla+" tr" ).length;
}

function editLegalName(){
	var ajaxData =  {
		url: "contract/updateLegalName",
		tipo: "json",
		datos: {
			ID: $("#idContratoX").text().trim(),
			LegalName: $("#legalNameEdit").val().trim()
		},
		funcionExito : msgeditLegalName,
		funcionError: mensajeAlertify
	};
	ajaxDATA(ajaxData);
}

function msgeditLegalName(data){
	if (data['afectados']>0) {
		alertify.success(data['mensaje']);
		$("#legalNameEdit").val(data["legalName"]);
	}else{
		alertify.error(data['mensaje']);
		$("#legalNameEdit").val('');
	}
}

/********************************/
/********** Documents ***********/
/********************************/

function getDocumentsCon(id){
	var url = "contract/getDocumentsContract";
	showLoading("#tableCDocumentsSelected", true);
	$.ajax({
	    data:{
	        idCon: id
	    },
	    type: "POST",
	    url: url,
	    dataType:'json',
	    success: function(data){
			if(data.length > 0){
				drawTableFiles(data, "tableCDocumentsSelected", "seeDocumentCon", "See", "deleteDocumentCon");
			}else{
				alertify.error("No results found");
				$("#tableCDocumentsSelected tbody").empty();
			}
			showLoading("#tableCDocumentsSelected", false);
	    },
	    error: function(){
			//showLoading("#tableCDocumentsSelected", false);
			//noResultsTable("tableCDocumentsSelected", "tableCDocumentsSelected", "Try again");
	        alertify.error("Try again");
	    }
	});
}

function seeDocumentCon(idFile){
	var url = "Pdfs/seeDocument?idFile=" + idFile;
	window.open(url);
}

function deleteDocumentCon(idDoc, id){
	id = $("#idContratoX").text().trim();
	alertify.confirm('Delete document .', "You want to delete the document.", 
				function(){ 
					$.ajax({
		data:{
			idDoc: idDoc
		},
   		type: "POST",
       	url: "reservation/deleteDocumentRes",
		dataType:'json',
		success: function(data){
			if(data.success){
				getDatosContractDocuments(id);
			}
			alertify.success(data.message);
			//showLoading('#table-reservations',false);
		},
		error: function(){
			alertify.error("Try again");
			//showLoading('#table-reservations',false);
		}
    }) },
				function(){ }
			).moveTo(screen.width - 500,screen.height - 100).set('resizable',true).resizeTo('25%',210).isOpen(
				$('.ajs-dialog').css('min-width','100px')
			);

}

/////////change units//////////////

/***************************************************/
/**@todo cambia las unidades asignadas al contrato**/
/***************************************************/
function changeUnits(){
	
	var units = getSizeTableUnits();
	console.log(units)
	if (units <= 0) {
			alertify.error("You must add at least one unit");
	}else{
		msgUnits = alertify.success('Saving changes, please wait ....', 0);
		$.ajax({
			data: {
				id:$("#idContratoX").text(),
				unidades: getValueTableUnidades('tableUnidades'),
				firstYear : $('#FirstYearCon').text(),
				lastYear : $('#LastYearCon').text(),
				weeks: getArrayValuesColumnTable("tableUnidades", 7),
				viewId: 1,
				//totalDiscountPacks
			},
			type: "POST",
			dataType:'json',
			url: 'contract/changeUnits'
		}).done(function( data, textStatus, jqXHR ){
			msgUnits.dismiss();
			if(data.success){
				alertify.success(data.message);
			}else{
				alertify.error("Try again");
			}
			//alertify.success("Susses");
			/*if(data.items.length > 0){
				$("#legalNameEdit").val(data.legalName);
				drawTableSinHeadPeople(data.items, "peoplesContract");
			}*/
		}).fail(function( jqXHR, textStatus, errorThrown ) {
			msgUnits.dismiss();
			alertify.error("Try again");
		});
	}
}



