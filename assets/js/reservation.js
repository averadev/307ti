var unitReservacion = [];
var iniDateRes = null;
var endDateRes = null;
var msgReservation = null;
var statusResMS;

/*var maxHeight = screen.height * .10;
maxHeight = screen.height - maxHeight;*/

$(document).ready(function(){
	getSizeModalGeneral();
	//dateField
	$( "#startDateRes, #endDateRes, #createDtRes" ).Zebra_DatePicker({
		format: 'm/d/Y',
		show_icon: false,
	});
	
	$( "#startDateRes" ).val( getCurrentDate() );
	
	statusResMS =  $('#statusRes').multipleSelect({
		width: '100%',
		placeholder: "Choose an option",
		selectAll: false,
		onClick: function(view) {
		},
	});
	
	var addReservation = null;
	var unidadResDialog = addUnidadResDialog( null, null, 'alta' );
    
	var dialogWeeksRes = getWeeksResDialog();
	var dialogPackRes = PackReferenceRes();
	var dialogEngancheRes = modalDepositDownpaymentRes();
	var dialogScheduledPaymentsRes = modalScheduledPaymentsRes();
	var dialogDiscountAmountRes = modalDiscountAmountRes();
	var dialogEditReservation = modalEditReservation();
	var dialogAccount = opcionAccountRes();
	var dialogStatusRes = modalStatusRes();
	var dialogNewOccRes = modalNewOccRes();
	
	$(document).off( 'click', '#newReservation');
	$(document).on( 'click', '#newReservation', function () {
		addReservation = createDialogReservation(addReservation, 'alta');
		addReservation.dialog("open");
		if (unidadResDialog!=null) {
			unidadResDialog.dialog( "destroy" );
		}
		unidadResDialog = addUnidadResDialog( null, null, 'alta' );
		unidadResDialog.dialog( "open" );
	});

	$(document).off( 'click', '#btnRefinancingReservation');
	$(document).on( 'click', '#btnRefinancingReservation', function () {
		var id = $("#idReservationX").text();
		showModalFinRes(id);
	});
	
	$(document).off( 'click', '#btnAddPeopleRes, #btnAddPeopleResEdit');
	$(document).on( 'click', '#btnAddPeopleRes, #btnAddPeopleResEdit', function () {
		if (peopleResDialog != null) {
			peopleResDialog.dialog( "destroy" );
		}
		peopleResDialog = addPeopleResDialog( $(this).attr('attr_table') );
        peopleResDialog.dialog( "open" );
	});
	
	$(document).off( 'click', '#btnChangeUnitRes');
	$(document).on( 'click', '#btnChangeUnitRes', function () {
		changeStatus();
	});
	
	$(document).off( 'click', '#btnChangeUnitRes');
	$(document).on( 'click', '#btnChangeUnitRes', function () {
		changeStatus();
	});

	$(document).off( 'click', '#btnCheckAll');
	$(document).on( 'click', '#btnCheckAll', function () {
		$('.checkPayAcc:checkbox').prop('checked', true);
		updatePriceAccount();
	});

	$(document).off( 'click', '#btnUnCheckAll');
	$(document).on( 'click', '#btnUnCheckAll', function () {
		$('.checkPayAcc:checkbox').prop('checked', false);
		updatePriceAccount();
	});
 	
	$(document).off( 'click', '#btnNewSellerRes');
 	$(document).on( 'click', '#btnNewSellerRes', function () {
 		if (modalVendedores!=null) {
	    		modalVendedores.dialog( "destroy" );
	    	}
	    	modalVendedores = modalSellersRes();
	        modalVendedores.dialog( "open" );
	 });
	
	$(document).off( 'click', '#btnNewFileRes');
 	 $(document).on( 'click', '#btnNewFileRes', function () {
 		if (modalNewFile!=null) {
	    		modalNewFile.dialog( "destroy" );
	    	}
	    	modalNewFile = modalNewFileContractRes();
	        modalNewFile.dialog( "open" );
	 });
	 
	$(document).off( 'click', '#btnNewProvisionRes');
	$(document).on( 'click', '#btnNewProvisionRes', function () {
 		if (modalProvisiones!=null) {
	    		modalProvisiones.dialog( "destroy" );
	    	}
	    	modalProvisiones = modalProvisionsRes();
	        modalProvisiones.dialog( "open" );
	 });
	 
	$(document).off( 'click', '#btnNewNoteRes');
	$(document).on( 'click', '#btnNewNoteRes', function () {
 		if (modalNotas!=null) {
	    		modalNotas.dialog( "destroy" );
	    	}
	    	modalNotas = modalAddNotasRes();
	        modalNotas.dialog( "open" );
	 });
	
	$(document).off( 'click', '#btnGetAllNotesRes');
	$(document).on( 'click', '#btnGetAllNotesRes', function () {
 		if (modalAllNotes!=null) {
	    		modalAllNotes.dialog( "destroy" );
	    	}
	    	modalAllNotes = modalGetAllNotesRes();
	        modalAllNotes.dialog( "open" );
	 });
	
	$(document).off( 'click', '#btnPackReferenceRes');
	$(document).on( 'click', '#btnPackReferenceRes', function () {
		var dialogPackRes = PackReferenceRes();
		dialogPackRes.dialog("open");
	});
	$(document).off( 'click', '#btnShowPayCardASR');
	$(document).on( 'click', '#btnShowPayCardASR', function () {
		showCreditCardASR();
	});
	//
	$(document).off( 'click', '#btnDownpaymentRes');
	$(document).on( 'click', '#btnDownpaymentRes', function () {
		var dialogEngancheRes = modalDepositDownpaymentRes();
		dialogEngancheRes.dialog("open");
	});
	
	$(document).off( 'click', '#btnScheduledPaymentsRes');
	$(document).on( 'click', '#btnScheduledPaymentsRes', function () {
		var dialogScheduledPaymentsRes = modalScheduledPaymentsRes();
		dialogScheduledPaymentsRes.dialog("open");
	});
	
	$(document).off( 'click', '#btnDiscountAmountRes');
	$(document).on( 'click', '#btnDiscountAmountRes', function () {
		var dialogDiscountAmountRes = modalDiscountAmountRes();
		dialogDiscountAmountRes.dialog("open");
	});
	$(document).off('click', '#tabsContratsAccounts');
	$(document).on( 'click', '#tabsContratsAccounts', function(){
		var accCode = $('#tab-RAccounts .tabsModal .tabs .active').attr('attr-accCode');
		if (accCode == "FDK") {
			$("#btAddCreditLimitRes").show();
		}else{
			$("#btAddCreditLimitRes").hide();
		}
	});
	$(document).off('change', '#RRelated');
	$(document).on( 'change', '#RRelated', function () {
		var ajaxDatos =  {
			url: "reservation/verifyConfirmationCode",
			tipo: "json",
			datos: {
					ResRelated: $("#RRelated").val()
			},
			funcionExito : messageRR,
			funcionError: mensajeAlertify
		};
	ajaxDATAG(ajaxDatos);
	});
	$(document).off( 'click', '#btNewTransAccRes, #btAddPayAccRes'); 
	$(document).on( 'click', '#btNewTransAccRes, #btAddPayAccRes', function ( ) {
		eventTransAccRes(this);
	});
	
	$(document).off( 'change', '#occupancyTypeGroupRes');
	$(document).on( 'change', '#occupancyTypeGroupRes', function () {
		id = $(this).val();
		ajaxSelectRes('reservation/getOccupancyTypes?id='+id,'try again', getOccupancyTypes, 'occupancySalesRes');
		getOpctionOccType();
	});

$(document).off( 'click', '#btAddCreditLimitRes');
$(document).on( 'click', '#btAddCreditLimitRes', function(){
	var ajaxData =  {
			url: "reservation/modalCreditLimit",
			tipo: "html",
			datos: {},
			funcionExito : addHTMLCreditLimit,
			funcionError: mensajeAlertify
		};
	var modalPropiedades = {
		div: "dialog-CreditLimit",
		altura: 260,
		width: 500,
		onOpen: ajaxDATA,
		onSave: createNewLimit,
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
       			var precio = $("#tableReservationAccRes .balanceAccount").text();
			
       			precio = parseFloat(precio.replace("$", "").trim());
       			var creditLimit = getNumberTextInputRes("creditLimitResInput");
       			if (creditLimit >= precio) {
       				createNewLimit();
       				$(this).dialog('close');
       			}else{
       				alertify.error("Verify the Amount");
       			}
       		}
     	}]
	};

	if (modalCreditLimit!=null) {
			modalCreditLimit.dialog( "destroy" );
		}
		modalCreditLimit = modalGeneral2(modalPropiedades, ajaxData);
		modalCreditLimit.dialog( "open" );
	});

$(document).off( 'click', '#btAddLinkACC');
$(document).on( 'click', '#btAddLinkACC', function(){
	var ajaxData =  {
			url: "reservation/modalLinkAcc",
			tipo: "html",
			datos: {},
			funcionExito : addHTMLLinkAcc,
			funcionError: mensajeAlertify
		};
	var modalPropiedades = {
		div: "dialog-LinkAcc",
		altura: 260,
		width: 500,
		onOpen: ajaxDATA,
		onSave: updateLinkAcc,
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
       			var accauntType = $('#tab-RAccounts .tabsModal .tabs .active').attr('attr-accCode');
				var accauntID = $('#btNewTransAccRes').data( 'idAcc' + accauntType );
				var ResConf = $("#resConfReservation").val().trim();
       			if ( ResConf != "" && accauntID != "") {
       				updateLinkAcc(ResConf, accauntID);
       				$(this).dialog('close');
       			}else{
       				alertify.error("Add a Reservation Code");
       			}
       			
       		}
     	}]
	};

	if (modalLinkAcc!=null) {
			modalLinkAcc.dialog( "destroy" );
		}
		modalLinkAcc = modalGeneral2(modalPropiedades, ajaxData);
		modalLinkAcc.dialog( "open" );
	});

	$(document).off( 'click', '#btnNewOccRes');
	$(document).on( 'click', '#btnNewOccRes', function () {
			if (dialogNewOccRes!=null) {
				dialogNewOccRes.dialog( "destroy" );
			}
			dialogNewOccRes = modalNewOccRes();
			dialogNewOccRes.dialog("open");
	});


	$( "#btnCleanWordRes").unbind( "click" );
	$('#btnCleanWordRes').click(function (){
		$( "#stringRes, #startDateRes, #endDateRes" ).val("");
		$("#nombreRes").prop("checked", true);
		$("#advancedSearchRes").prop("checked", false);
		$("#advancedRes").hide("slow");
	});
	
	$( "#btnfindRes").unbind( "click" );
	$('#btnfindRes').click(function(){
		$("#NR").text("Reservations");
		getReservations();
	});

	$( "#advancedSearchRes").unbind( "click" );
	$("#advancedSearchRes").click(function(){
		$("#advancedRes").slideToggle("slow");
	});
	
	$(document).off( 'change', '#downpaymentRes')
	$(document).on( 'change', '#downpaymentRes', function () {
		$("#montoTotalRes").val($(this).val());
		var monto = $("#montoTotalRes").val();
		cambiarCantidadPRes(monto);
	});
	
	$(document).off( 'change', "input[name='engancheRRes']:checked")
	$(document).on( 'change', "input[name='engancheRRes']:checked", function () {
		var monto = $("#downpaymentRes").val();
		cambiarCantidadPRes(monto);
	});
	
	$(document).off( 'change', '#descuentoEspecialRes')
	$(document).on( 'change', '#descuentoEspecialRes', function () {
		var monto = $("#descuentoEspecialRes").val();
		cambiarCantidadDERes(monto);
	});
	
	$(document).off( 'change', "input[name='especialDiscount']:checked")
	$(document).on( 'change', "input[name='especialDiscount']:checked", function () {
		var monto = $("#descuentoEspecialRes").val();
		cambiarCantidadDERes(monto);
	});
	/*$(document).on('change', "#precioVentaRes", function () {
		updateBalanceFinalRes();
	});*/
	
	$(document).off( 'change', '#amountTransferRes');
	$(document).on('change', "#amountTransferRes", function () {
		var balanceFinal = $("#financeBalanceRes").val();
		var transferido = $("#amountTransferRes").val();
		$("#financeBalanceRes").val(balanceFinal - transferido);
	});
	
/*	$(document).off( 'change', '#StatusPeople')
	$(document).on('change', "#StatusPeople", function () {
		var id = $(this).val();
		var idReserva = getValueFromTableSelectedRes("reservationsTable", 1);
		var idPersona = getValueFromTableSelectedRes("peopleContract", 1);
		updateStatusPeople(id, idReserva, idPersona);
	});*/
	$(document).off( 'change', '.checkInPeople');
	$(document).on( 'change', '.checkInPeople', function () {
	    var id = $(this).val();
		//var idReserva = getValueFromTableSelectedRes("reservationsTable", 1);
		var idReserva = $("#idReservationX").text();
		var idPersona = getValueFromTableSelectedRes("peopleContractRes", 1);
		updateStatusPeople(id, idReserva, idPersona);
	});
	
	$(document).off( 'change', '#RateRes')
	$(document).on( 'change', '#RateRes', function () {
		var unidades = getValueTableUnidadesRes();
		if (unidades.length<=0) {
			alertify.error("You should add one unit or more");	
		}else {
			setValueUnitPriceRes(null);
		}
	});
	
	$(document).off( 'click', '#btnSavePeopleRes');
	$(document).on('click', "#btnSavePeopleRes", function () {
		savePeopleRes();
	});
	
	$('#OccTypeGroupRes').off( 'change' );
	$('#OccTypeGroupRes').on( 'change', function(){
		id = $(this).val();
		ajaxSelectRes('collection/getOccupancyTypes?id='+id,'try again', generalSelects, 'OccTypeRes');
	});
	
	getDatailByIDRes("reservationstbody");
	
});

function eventTransAccRes(selector){

	var accCode = $('#tab-RAccounts .tabsModal .tabs .active').attr('attr-accCode');
	//var idAccColl = $('#btNewTransAccRes').data( 'idAcc' + accCode );
	var idAccColl = getTypeAccount(accCode);

	var statusRes = $('#editReservationStatus').attr( 'statusRes' );
	if(idAccColl != undefined){
		if( accCode == "FDK" && statusRes != "In House" && $(selector).attr('id') == "btNewTransAccRes" ){
			alertify.error('You can not add transactions');
		}else{
			var dialogAccount = opcionAccountRes($(selector).attr('attr_type'));
			dialogAccount.dialog("open");
		}	
	}else{
		alertify.error('No acc found');
	}
}

function addHTMLLinkAcc(data){
	$("#dialog-LinkAcc").html(data);
	//initEventosFinanciamiento();
}

function updateLinkAcc(ResConf, accauntID){
	var ajaxData =  {
		url: "reservation/LinkAcc",
		tipo: "json",
		datos: {
			'resConfR': ResConf,
			'accauntID': accauntID
		},
		funcionExito : mesnajeLinkAcc,
		funcionError: mensajeAlertify
	};
	ajaxDATA(ajaxData);
}

function messageRR(data){
if (data['success'] == 1) {
		alertify.success(data["mensaje"]);
	}
	if (data['success'] == 0) {
		alertify.error(data["mensaje"]);
	}
}

function mesnajeLinkAcc(data){
	getAccountsRes( $('#btNewTransAccRes').data( 'idRes' ), "account", "" );
	if (data['success'] == 1) {
		alertify.success(data["mensaje"]);
	}
	if (data['success'] == 0) {
		alertify.error(data["mensaje"]);
	}
}

function updateDownpaymentRes(){
	var downpayment = getNumberTextInput("downpaymentRes");
	$("#montoTotalRes").val(downpayment.toFixed(2));
	var monto = getNumberTextInput("montoTotalRes");
	if (monto) {
		cambiarCantidadP(monto);
	}else{
		$("#montoTotalRes").val(0);
	}
}
function updateDescuentoEspecialRes(){
	var monto = $("#descuentoEspecialRes").val();
	if (monto) {
		cambiarCantidadDE(monto);
	}else{
		$("#montoTotalDERes").val(0);
	}
}

function addHTMLCreditLimit(data){
	$("#dialog-CreditLimit").html(data);
	//initEventosFinanciamiento();
}
function createNewLimit (){
	var accauntType = $('#tab-RAccounts .tabsModal .tabs .active').attr('attr-accCode');
	var accauntID = $('#btNewTransAccRes').data( 'idAcc' + accauntType );
	var amount = $("#creditLimitResInput").val();
	var ajaxData =  {
		url: "reservation/updateCreditLimit",
		tipo: "json",
		datos: {
			'accauntID': accauntID,
			'accauntType': accauntType,
			'amount': amount
		},
		funcionExito : mensajeLimit,
		funcionError: mensajeAlertify
	};
	ajaxDATA(ajaxData);
	
}

function mensajeLimit(data){
	if (data['mensaje']) {
		alertify.success(data["mensaje"]);
	}
	if (data['creditLimit']) {
		$("#creditLimitRes").text(parseFloat(data['creditLimit']).toFixed(2));
	}
}

function ajaxSelectsRes(url,errorMsj, funcion, divSelect) {
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

function updateBalanceFinalRes(){
	var precioVenta = getNumberTextInputRes("precioVentaRes");

	var descuentoEspecial = getNumberTextInputRes("montoTotalDERes");
	var deposito = getNumberTextInputRes("depositoEngancheRes");
	var pagosProgramados = getNumberTextInputRes("scheduledPaymentsRes");

	var descuentoEfectivo = getNumberTextInputRes("totalDiscountPacksRes"); 
	var transferencia = getNumberTextInputRes("amountTransferRes");

	var descuento = descuentoEspecial + deposito + pagosProgramados + descuentoEfectivo + transferencia;
	var costoTotal = precioVenta; //+ closingCost;
	var total = costoTotal - descuento;
	$("#financeBalanceRes").val(total);
	
}

function getNumberTextInputRes(div){
	var valor = $("#"+div).val();
	if(valor){
		return parseFloat(valor);
	}else{
		return 0;
	}
}
function getNumberTextStringRes(div){
	var valor = $("#"+div).text();
	if(valor){
		return parseFloat(valor);
	}else{
		return 0;
	}
}	
function cambiarCantidadPRes(monto){
	var seleccionado = $("input[name='engancheRRes']:checked").val();
	var precioVenta = getNumberTextInputRes("precioVentaRes"); 
	var descuento = getNumberTextInputRes("montoTotalDERes");
	var total = precioVenta - descuento;
	if (seleccionado == "porcentaje") {
		var porcentaje = total * (monto/100);
		$("#montoTotalRes").val(porcentaje.toFixed(2));
	}else{
		$("#montoTotalRes").val(monto);
	}
}

function cambiarCantidadDERes(monto){
	var seleccionado = $("input[name='especialDiscount']:checked").val();
	var precioVenta = $("#precioVenta").val();
	if (seleccionado == 'porcentaje') {
		var porcentaje = precioVenta * (monto/100);
		$("#montoTotalDERes").val(porcentaje);
	}else{
		$("#montoTotalDERes").val(monto);
	}
	updateBalanceFinalRes();
}



function createDialogReservation(addReservation, typeRes) {
	var div = "#dialog-Reservations";
	if (addReservation!=null) {
	    	addReservation.dialog( "destroy" );
	    }
	
	dialog = $(div).dialog({
		open : function (event){
			showLoading(div,true);
			$(this).load ("reservation/modal" , function(){
		    	showLoading(div,false);
				if( typeRes == "change"){
					$('#languageDialogRes').remove();
					$('#peopleDialogRes').remove();
				}
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
				text: "Save",
				"class": 'dialogModalButtonAccept',
				click: function() {
					if( typeRes == "alta"){
						if (verifyContractALLRes()){
							createNewReservation();
							$(this).dialog('close');
						}
					}else if( typeRes == "change"){
						if (verifyChangeUnitRes()) {
							changeUnitRes();
							$(this).dialog('close');
						}
					}
					
				}/*,{
				text: "Save",
				"class": 'dialogModalButtonAccept',
				click: function() {
					if (verifyContractALLRes()) {
						createNewReservation();
					}
				}*/
			}
		],
		close: function() {
			$('#dialog-Reservations').empty();
			
			//$(this).dialog('destroy');
			addReservation = null;
		}
	});
	return dialog;
}

function getOpctionOccType(){
	var unidades = getValueTableUnidadesRes();
	if (unidades.length<=0) {
		alertify.error("You should add one unit or more");	
	}else {
		getRateRes();
	}
}
					

function verifyContractALLRes(){
	var value = false;
	if (verifyContractRes()) {
		if (verifyTablesContractRes()) {
			if (verifyLanguageRes()) {
				value = true;
			}
			
		}
	}
	return value;
}

function verifyChangeUnitRes(){
	var value = false;
	if (verifyContractRes()) {
		if (verifyTablesUnitsRes()) {
			value = true;
		}
	}
	return value;
}

function verifyContractRes(){
	//var arrayWords = ["depositoEngancheRes", "precioUnidadRes", "precioVentaRes"];
	var value = true;
	$("#RateRes").removeClass('is-invalid-input');
	var valueRate = getNumberTextInputRes("RateRes");
	if($('#RateRes').val().trim().length == 0 || valueRate < 0){
		value = false;
		gotoDiv("contentModalReservation", "RateRes");
		$("#RateRes").addClass('is-invalid-input');
		alertify.error("Choose a rate");
	}else{
		if (!/^[0-9]+(\.[0-9]+)?$/.test($('#RateRes').val().trim())){
			value = false;
			gotoDiv("contentModalReservation", "RateRes");
			$("#RateRes").addClass('is-invalid-input');
			alertify.error("Only numbers are allowed");
		}
	}
	return value;
}

function verifyTablesContractRes(){
	var value = true;
	var unidades = getValueTableUnidadesRes();
	var personas = getValueTablePersonasRes("tablePeopleResSelected");
	if (personas.length<=0) {
		alertify.error("You should add one people or more");
		value = false;
	}else if (unidades.length<=0) {
		alertify.error("You should add one unity or more");
		value = false;
	}
	return value;
}

function verifyTablesUnitsRes(){
	var value = true;
	var unidades = getValueTableUnidadesRes();
	if (unidades.length<=0) {
		alertify.error("You should add one unity or more");
		value = false;
	}
	return value;
}

function verifyLanguageRes(){
	var value = true;
	var languageValue = getNumberTextInputRes("selectLanguageRes");
	if(languageValue == 0){
		value = false;
		gotoDiv("contentModalReservation", "selectLanguageRes");
		$("#selectLanguageRes").addClass('is-invalid-input');
		alertify.error("Choose a language");
	}
	return value;
}

function addUnidadResDialog(iniDate, unit, typeUnit){
	var div = "#dialog-UnidadesRes";
	dialog = $( "#dialog-UnidadesRes" ).dialog({
		open : function (event){
				showLoading(div,true);
				$(this).load ("reservation/modalUnidades" , function(){
		    		showLoading(div,false);
		    		//ajaxSelectRes('contract/getProperties','try again', generalSelects, 'propertyRes');
	    			//ajaxSelectRes('contract/getUnitTypes','try again', generalSelects, 'floorPlanUnitRes');
					//ajaxSelectRes('reservation/getView','try again', generalSelects, 'viewUnitRes');
					//if( typeUnit == 'alta' ){
						$( "#DatesUnitRes" ).show();
						$( "#fromDateUnitRes" ).Zebra_DatePicker({
							format: 'm/d/Y',
							show_icon: false,
							//direction: true,
							pair: $('#toDateUnitRes'),
						});
						$( "#toDateUnitRes" ).Zebra_DatePicker({
							format: 'm/d/Y',
							show_icon: false,
							//direction: 1
						});
					
					if(iniDate != null){
						$('#fromDateUnitRes').val(iniDate);
					}
					if(unit != null){
						if( typeof(unit.fkPropertyId) != "undefined"  ){
							if( $('#propertyRes option').length > 1){
								$('#propertyRes').val(unit.fkPropertyId);
								//clearInterval(timer1);
							}
						}
						if( typeof(unit.fkFloorPlanId) != "undefined"  ){
							if( $('#floorPlanUnitRes option').length > 1){
								$('#floorPlanUnitRes').val(unit.fkFloorPlanId);
								//clearInterval(timer2);
							}
						}
						if( typeof(unit.fkViewId) != "undefined"  ){
							if( $('#viewUnitRes option').length > 1){
								$('#viewUnitRes').val(unit.fkViewId);
								//clearInterval(timer2);
							}
						}
						if( typeof(unit.MaxAdults) != "undefined"  ){
							if( $('#guestsAdultRes option').length > 1){
								$('#guestsAdultRes').val(unit.MaxAdults);
								//clearInterval(timer2);
							}
						}
						if( typeof(unit.MaxKids) != "undefined"  ){
							if( $('#guestChildRes option').length > 1){
								$('#guestChildRes').val(unit.MaxKids);
								//clearInterval(timer2);
							}
						}
						if( typeof(unit.iniDate) != "undefined"  ){
							$('#fromDateUnitRes').val(unit.iniDate);
						}
						if( typeof(unit.endDate) != "undefined"  ){
							$('#toDateUnitRes').val(unit.endDate);
						}
						//if(typeof(miVariable) != "undefined")
						/*var delay=1000;
						var timer1 = setInterval(function(){ 
							if( $('#propertyRes option').length > 1){
								$('#propertyRes').val(unit.fkPropertyId);
								clearInterval(timer1);
							}
						}, delay);
						var timer2 = setInterval(function(){ 
							if( $('#floorPlanUnitRes option').length > 1){
								$('#floorPlanUnitRes').val(unit.fkFloorPlanId);
								clearInterval(timer2);
							}
						}, delay);
						var timer3 = setInterval(function(){ 
							if( $('#viewUnitRes option').length > 1){
								$('#viewUnitRes').val(unit.fkViewId);
								clearInterval(timer3);
							}
						}, delay);
						$('#guestsAdultRes').val(unit.MaxAdults);
						$('#guestChildRes').val(unit.MaxKids);*/
					}
					$('#btnGetUnidadesRes').unbind('click');
					$('#btnGetUnidadesRes').click(function(){
						if($('#fromDateUnitRes').val().trim().length > 0 && $('#toDateUnitRes').val().trim().length > 0 ){
							iniDateRes = $('#fromDateUnitRes').val();
							endDateRes = $('#toDateUnitRes').val();
							getUnidadesRes(typeUnit);
						}else{
							alertify.error("Choose dates for the reservation");
						}
					});
		            //selectTableRes("tblUnidadesRes");
					selectTableUnicoRes("tblUnidadesRes");
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
				var unidades = getValueTableUnidadesSeleccionadasRes();
				if (unidades.length > 0) {
					var intDate = iniDateRes.split("/");
					intDate = intDate[2];
					var endDate = endDateRes.split("/");
					endDate = endDate[2];
					var frequency = "every Year";
	       			tablUnidadadesRes(unidades, frequency, intDate, endDate);
					id = $('#occupancyTypeGroupRes').val();
					ajaxSelectRes('reservation/getOccupancyTypes?id='+id,'try again', getOccupancyTypes, 'occupancySalesRes');
	       			$(this).dialog('close');
				}else{
					alertify.error("Search and click over for choose one");
				}
			}
		}],
		close: function() {
			$('#dialog-UnidadesRes').empty();
		}
	});
	return dialog;
}

function addPeopleResDialog(table){
	var div = "#dialog-PeopleRes";	
	dialog = $(div).dialog({
		open : function (event){
			if ($(div).is(':empty')) {
				showLoading(div, true);
				$(this).load ("people/indexReservations" , function(){
		    		showLoading(div, false);
		    		$("#dialog-User").hide();
	            	selectTableRes(SECCION+"-tablePeople");
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
				if(selectAllPeopleRes(table)){
					updateValuePeopleRes();
					$(this).dialog('close');
				};
			}
		}],
		close: function() {
			$('#dialog-PeopleRes').empty();
		}
	});
	return dialog;
}

function getReservations(){
	//noResultsTable("table-reservations", "reservationsTable", "no results found");}
	noResults( '#table-reservations', false );
	showLoading( '#table-reservations', true );
	
    var filters = getFiltersCheckboxs('filtro_reservations');
    var arrayDate = ["startDateRes", "endDateRes", "createDtRes"];
    var dates = getDates(arrayDate);
    var arrayWords = ["stringRes", "createByRes"];
    var words = getWords(arrayWords);
	var arrayOption = ["OccTypeGroupRes", "OccTypeRes"];
    var options = getWords(arrayOption);
    options.statusRes = statusResMS.multipleSelect('getSelects');
	
	if( dates.startDateRes == "" && dates.endDateRes == "" && words.stringRes == "" ){
		alertify.error("Choose at least filtering field");
		showLoading( '#table-reservations', false );
	}else{
		$('#reservationstbody').empty();
		$.ajax({
			data:{
				filters: filters,
				dates: dates,
				words: words,
				options: options
			},
			type: "POST",
			url: "reservation/getReservations",
			dataType:'json',
			success: function(data){
				if( data.items ){
					alertify.success("Found "+ data["items"].length);
					$("#NR").text(data["items"].length +" Reservations");
					drawTable2(data.items,"reservationsTable","getDatailByIDRes","editRes");
				}else{
					noResultsTable("table-reservations", "reservationsTable", "no results found");
				}
				showLoading('#table-reservations',false);
			},
			error: function(){
				alertify.error("Try again");
				showLoading('#table-reservations',false);
			}
		});
	}
}

function selectAllPeopleRes(table){
	var personasSeleccionaDas = getArrayValuesColumnTableRes("tablePeopleResSelected", 1);
	var personas = [];

	var array = $("#"+SECCION+"-tablePeople .yellow");
	for (var i = 0; i < array.length; i++) {
		var fullArray = $(array[i]).find("td");
		if (personasSeleccionaDas.length>0) {
			if (!isInArrayRes(fullArray.eq(1).text().replace(/\s+/g, " ") ,personasSeleccionaDas)) {
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
			tablePeopleRes(personas, table);
		}
		return true;
	}
	
}

function isInArrayRes(value, array) {
  return array.indexOf(value) > -1;
}

function getArrayValuesColumnTableRes(tabla, columna){
	var items=[];
	$('#'+tabla+' tbody tr td:nth-child('+columna+')').each( function(){
		if ($(this).text().replace(/\s+/g, " ")!="") {
			items.push( $(this).text().replace(/\s+/g, " "));
		}       
	});
	return items;
}

function getValueTableUnidadesSeleccionadasRes(){
	var unidadesId = getArrayValuesColumnTableRes("tableUnidadesResSelected", 1);
	var semanas= getArrayValuesColumnTableRes("tableUnidadesResSelected", 7);
	var tabla = "tblUnidadesRes";
	var unidades = [];
	$('#'+tabla+' tbody tr.yellow').each( function(){
		if ($(this).text().replace(/\s+/g, " ")!="") {
			var unidad = {};
			unidad.id = $(this).find('td').eq(1).text(),
			unidad.code = $(this).find('td').eq(2).text(),
			unidad.description = $(this).find('td').eq(3).text(),
			unidad.view = $(this).find('td').eq(4).text(),
			unidad.floor = $(this).find('td').eq(5).text(),			
			unidad.week = $(this).find('td').eq(6).text(),
			unidad.season = $(this).find('td').eq(7).text(),
			unidades.push(unidad); 
		}
	});
	unitReservacion = unidades;
	return unidades;
	//$('#fromDateUnitRes').val();
	//endDateRes = $('#toDateUnitRes').val();
}

function tablePeopleRes(personas, table){
	var bodyHTML = '';
	    //creación del body
    for (var i = 0; i < personas.length; i++) {
		bodyHTML += "<tr>";
		if(table == "peopleContractRes"){
			bodyHTML+="<td></td>";
		}
        for (var j in personas[i]) {
            bodyHTML+="<td>" + personas[i][j] + "</td>";
        };
		
        bodyHTML += "<td><div class='rdoField'><input class='primy' value='"+i+"'  type='radio' name='peopleType1'><label for='folio'>&nbsp;</label></div></td>";
        bodyHTML += "<td><div class='rdoField'><input disabled class='benefy' value='"+i+"' type='checkbox' name='peopleType2'><label for='folio'>&nbsp;</label></div></td>";
        bodyHTML += "<td><button type='button' class='alert button'><i class='fa fa-minus-circle fa-lg' aria-hidden='true'></i></button></td>";
        bodyHTML+="</tr>";
    }
    $('#' + table + ' tbody').append(bodyHTML);
    defaultValuesRes(table);
    onChangePrimaryRes();
	deleteElementTableRes(table);
}

function onChangePrimaryRes(){
	$(document).off( 'change', '.primy');
	$(document).on( 'change', '.primy', function () {
		//var selected = getIndexCheckbox();
		checkAllBeneficiary(this.value);
	});
}
function defaultValuesRes(div){
	if ($('.primy').length>0) {
		var index = PrimaryPeopleRes2(div);
		$('.primy')[index].checked = true;
		checkAllBeneficiary(index);
	}
}

//reducir a una funcion
function deleteElementTableRes(div){
	$("#"+div+" tr").off( 'click', 'button');
	$("#"+div+" tr").on( 'click', 'button', function () {
	//$("#"+div+" tr").on("click", "button", function(){
		$(this).closest("tr").remove();
		updateValuePeopleRes();
		if (!PrimaryPeopleRes()) {
			defaultValuesRes(div);
		}
	});
}
function updateValuePeopleRes(){
	$(".primy").each(function (i) {
		this.value= i;
	});
}
function getArrayValuesCheckboxRes(){
	var items=[];
	var Primario = $("#peopleContractRes .primy");
	for (var i = 0; i < Primario.length; i++) {
		items.push(Primario[i].checked);
	}
	return items;
}
function PrimaryPeopleRes(){
	var P = false;
	var items = getArrayValuesCheckboxRes();
	for (var i = 0; i < items.length; i++) {
		if (items[i]) {
			P = true;
		}
	}
	return P;
}
function PrimaryPeopleRes2(div){
	var P = 0;
	var items = getArrayValuesCheckboxRes(div);
	for (var i = 0; i < items.length; i++) {
		if (items[i]) {
			P = i;
		}
	}
	return P;
}
function deleteElementTableUnidadesRes(div){
	$("#"+div+" tr").on("click", "button", function(){
		$(this).closest("tr").remove();
		setValueUnitPriceRes(null);
	});
}
function deleteElementTableFuncionRes(div, funcion){
	$("#"+div+" tr").on("click", "button", function(){
		$(this).closest("tr").remove();
		funcion();
	});
}


function getDetalleContratoByID(i){
	showLoading('#reservationsTable',true);
	ajaxHTML('dialog-Edit-Reservation', 'contract/modalEdit');
    showModals('dialog-Edit-Reservation', cleanAddPeople);
}

function getInputsByID(formData, divs){
	for (var i = 0; i < divs.length; i++) {
		 formData.append(divs[i], $("#"+divs[i]).val().trim());
	}
	return formData;
}

function verifyInputsByIDRes(divs){
	var v = true;
	for (var i = 0; i < divs.length; i++) {
		 if($('#'+divs[i]).val().trim().length <= 0){
		 	v = false;
		 }
	}
	return v;
}
function clearInputsByIdRes(divs){
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


function ajaxSelectRes(url,errorMsj, funcion, divSelect) {
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

function createNewReservation(){
	
	var id = "saveDataReservation";
	var arrayWords = ["depositoEngancheRes", "precioUnidadRes", "precioVentaRes"];
	var form = $("#"+id);
	var elem = new Foundation.Abide(form, {});

	//if(!verifyInputsByIDRes(arrayWords)){
		//$('#'+id).foundation('validateForm');
		//alertify.success("Please fill required fields (red)");
		//return false;
	//}else{
		var unidades = getValueTableUnidadesRes();
		var personas = getValueTablePersonasRes("tablePeopleResSelected");
		if (personas.length<=0) {
			alertify.error("You must add at least one person");
		}else if (unidades.length<=0) {
			alertify.error("You must add at least one unit");
		}else if($("#selectLanguageRes").val()=="0"){
			$("#selectLanguageRes").addClass('is-invalid-input');
			alertify.error("Choose a language");
		}else{
			var unidadRes = getValueTableUnidadesRes();
			var date1 = new Date(iniDateRes);
			var date2 = new Date(endDateRes);
			var dayDif = date2.getTime() - date1.getTime();
			var day = Math.round(dayDif/(1000 * 60 * 60 * 24));
			//showAlert(true,"Saving changes, please wait ....",'progressbar');
			msgReservation = alertify.success('Saving changes, please wait ....', 0);
			$.ajax({
					data: {
						idiomaID : $("#selectLanguageRes").val(),
						peoples: getValueTablePersonasRes("tablePeopleResSelected"),
						types: typePeopleRes(),
						unidades: unidadRes,
						weeks: getArrayValuesColumnTableRes("tableUnidadesResSelected",7),
						firstYear : unidadRes[0].fyear,
						lastYear : unidadRes[0].lyear,
						occType : $("#occupancySalesRes").val(),
						occCode : $('#occupancyTypeGroupRes option:selected').attr('occCode'),
						listPrice: getNumberTextInputRes("precioUnidadRes"),
						salePrice: getNumberTextInputRes("precioVentaRes"),
						specialDiscount:getNumberTextInputRes("montoTotalDERes"),
						downpayment:getNumberTextInputRes("montoTotalRes"),
						amountTransfer:getNumberTextInputRes("amountTransferRes"),
						packPrice:sumarArrayRes(getArrayValuesColumnTableRes("tableDescuentosRes", 3)),
						financeBalance: $("#financeBalanceRes").val(),
						tablapagos: getValueTableDownpaymentRes(),
						tablaPagosProgramados:getValueTableDownpaymentScheduledRes(),
						//tablaPacks: getValueTablePacksRes(),
						extras: getNumberTextInputRes("packReferenceRes"),
						tablaDownpayment : getValueTableDownpaymentRes(),
						gifts: getValueTablePacksRes(),
						viewId: 1,
						card: datosCardRes(),
						deposito:getNumberTextInputRes("depositoEngancheRes"),
						day:day,
						iniDate:iniDateRes,
						endDate:endDateRes,
						RelatedR: $("#RRelated").val(),
						RateAmtNight:$('#RateRes').val(),
					},

					type: "POST",
					dataType:'json',
					url: 'reservation/saveReservacion'
				})
				.done(function( data, textStatus, jqXHR ) {
					//showAlert(false,"Saving changes, please wait ....",'progressbar');
					msgReservation.dismiss();
					if (data['status']== 1) {
						elem.resetForm();
						var arrayWords = ["depositoEngancheRes", "precioUnidadRes", "precioVentaRes", "downpaymentRes"];
						clearInputsByIdRes(arrayWords);
						if (data['balance'].financeBalance > 0 ) {
							showModalFinRes(data['idContrato']);
						}else{
							var dialogEditReservation = modalEditReservation(data['idContrato']);
							dialogEditReservation.dialog("open");
						}
						$('#dialog-Weeks').empty();
						$('#tablePeopleResSelected tbody').empty();
						$('#tableUnidadesResSelected tbody').empty();
						alertify.success(data['mensaje']);
						var tabCurrent = $('#tab-general .active').attr('attr-screen');
						if(tabCurrent == "frontDesk"){
							getFrontDesk("",1);
						}else{
							
							getReservations();
						}
					}else{
						alertify.error(data["mensaje"]);
					}
				})
				.fail(function( jqXHR, textStatus, errorThrown ) {
					alertify.error("Try again");
				});
		//}
	}
}

//funciona para pagos enganches
function getValueTableDownpaymentRes(){
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

function getValueTablePacksRes(){
	var tabla = "tableDescuentosRes";
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

function getValueTableDownpaymentScheduledRes(){
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

function getValueTableUnidadesRes(){
	var tabla = "tableUnidadesResSelected";
	var unidades = [];
	$('#'+tabla+' tbody tr').each( function(){
		if ($(this).text().replace(/\s+/g, " ")!="") {
			var unidad = {};
			unidad.id = $(this).find('td').eq(0).text(),
			unidad.floorPlan = $(this).find('td').eq(1).text(),
			unidad.view = $(this).find('td').eq(2).text(),
			unidad.frequency = $(this).find('td').eq(3).text(),
			unidad.floor = $(this).find('td').eq(4).text(),
			unidad.season = $(this).find('td').eq(5).text(),
			unidad.week = $(this).find('td').eq(6).text(),
			unidad.fyear = $(this).find('td').eq(7).text(),
			unidad.lyear = $(this).find('td').eq(8).text()
			unidades.push(unidad); 
		}
	});
	return unidades;
}
function getValueTablePersonasRes(tabla){
	var unidades = [];
	var personas = [];
	$('#'+tabla+' tbody tr').each( function(i){
		if ($(this).text().replace(/\s+/g, " ")!="") {
			var persona = {};
			if(tabla == "tablePeopleResSelected"){
				persona.id = $(this).find('td').eq(0).text(),
				persona.primario = $(this).find('td').eq(4).find('input[name=peopleType1]').is(':checked'),
				persona.beneficiario = $(this).find('td').eq(5).find('input[name=peopleType2]').is(':checked')
				personas.push(persona);
			}else{
				persona.id = $(this).find('td').eq(1).text(),
				persona.primario = $(this).find('td').eq(5).find('input[name=peopleType1]').is(':checked'),
				persona.beneficiario = $(this).find('td').eq(6).find('input[name=peopleType2]').is(':checked')
				persona.exist = 0
				personas.push(persona);
			}
		}
	});
	return personas;
}

function converCheked(val){
	var c;
	if (val == "on") {
		c = 1;
	}else{
		c = 0;
	}
	return c;
}

function sumarArrayRes(array){
	var sum = 0;
	$.each(
		array,function(){
			sum+=parseFloat(this) || 0;
		}
	);
	return sum;
}

function typePeopleRes(){
	var typePeople =[];
	var people = getArrayValuesColumnTableRes("tablePeopleResSelected", 1);
	var primario = selectTypePeopleRes("primario");
	var secundario = selectTypePeopleRes("secundario");
	var beneficiario = selectTypePeopleRes("beneficiario");
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

function editRes(id){
	alert(id);
}

function selectTableRes(div){
	$("#"+div).off("click", "tr");
	$("#"+div).on("click", "tr", function(){
		$(this).toggleClass("yellow");
	});
}
function selectTableUnicoRes(div){
	var pickedup;
	$("#"+div).off("click", "tr");
	$("#"+div).on("click", "tr", function(){
          if (pickedup != null) {
              pickedup.removeClass("yellow");
          }
          $( this ).addClass("yellow");
          pickedup = $(this);
	});
}

function getWeeksResDialog(unidades){
	showLoading('#dialog-WeeksRes', true);
	var unidades = unidades;
	dialogo = $("#dialog-WeeksRes").dialog ({
  		open : function (event){
	    	$(this).load ("reservation/modalWeeks", function(){
	    		showLoading('#dialog-WeeksRes', false);
	    		ajaxSelectRes('contract/getFrequencies','try again', generalSelects, 'frequency');
	    		$("#weeksNumber").val(1);
	    		setYearRes("firstYearWeeks", 0);
	    		setYearRes("lastYearWeeks", 25);
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
       			var frequency = $("#frequency option:selected" ).text();
				var intDate = iniDateRes.split("/");
				intDate = intDate[2];
				var endDate = endDateRes.split("/");
				endDate = endDate[2];
       			//var primero = $("#firstYearWeeks").val();
       			//var ultimo = $("#lastYearWeeks").val();
       			tablUnidadadesRes(unidades, frequency, intDate, endDate);	
       			$(this).dialog('close');
       			//setValueUnitPriceRes();
       		}
     	}],
     close: function() {
     }
	});
	return dialogo;
}

function setYearRes(id, n){
	var d = new Date().getFullYear();
	$("#"+id).val(d + n);
}

function PackReferenceRes(){
	showLoading('#dialog-Pack', true);
	dialogo = $("#dialog-Pack").dialog ({
  		open : function (event){
	    	$(this).load ("contract/modalPack" , function(){
	    		showLoading('#dialog-Pack', false);
	    		var precioUnidad = $("#precioUnidadRes").val();
				var precioUnidadPack = $("#unitPricePack").val(precioUnidad);
				$("#finalPricePack").val(precioUnidad);
				calcularPackRes();
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
       			$("#precioVentaRes").val($("#finalPricePack").val());
       			$("#packReferenceRes").val($("#quantityPack").val());
				updateBalanceFinalRes();
       			$(this).dialog('close');
       		}
     	}],
     close: function() {
     }
	});
	return dialogo;
}

function modalDepositDownpaymentRes(){
	showLoading('#dialog-DownpaymentRes', true);
	dialogo = $("#dialog-DownpaymentRes").dialog ({
  		open : function (event){
	    	/*$(this).load ("contract/modalDepositDownpayment" , function(){
	    		showLoading('#dialog-DownpaymentRes', false);
	    		initEventosDownpaymentRes();
	    	});*/
			getPlantillaDownpaymentRes();
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
				var deposito = getNumberTextInputRes("finalPriceDownpayment");
       			var total = getNumberTextInputRes("downpaymentPrice");
       			if (deposito>total || deposito<= 0) {
       				alertify.error("Please Verify Total to Pay");
       			}else if(!isCreditCardValidRes()){
					alertify.error("Please Verify your Credit Card");
       			}else{
       				$("#depositoEngancheRes").val(deposito);
       				$(this).dialog('close');
       				updateBalanceFinalRes();	
       			}
       			
       		}
     	}],
     close: function() {
     }
	});
	return dialogo;
}

function isCreditCardValidRes(){
	var payType = $("#tiposPago").val();
	if (payType == "1" || payType == "5") {
		return true;
	}else{
		var R = true;
		var creditCard = datosCardRes();
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

function getPlantillaDownpaymentRes(){
		var ajaxData =  {
		url: "reservation/modalDepositDownpayment",
		tipo: "html",
		datos: {},
		funcionExito : addHTMLDownpaymentRes,
		funcionError: mensajeAlertify
	};
	ajaxDATA(ajaxData);
}

function addHTMLDownpaymentRes(datos){
	showLoading('#dialog-DownpaymentRes', false);
	$("#dialog-DownpaymentRes").html(datos);
	initEventosDownpaymentRes();
}

function modalScheduledPaymentsRes() {
	var div = "#dialog-ScheduledPayments";
	dialogo = $(div).dialog ({
  		open : function (event){
  			//if ($(div).is(':empty')) {
  				showLoading(div, true);
				$(this).load ("contract/ScheduledPayments" , function(){
					showLoading(div, false);
					initEventosDownpaymentProgramadosRes();
				});
  			/*}else{
				$(this).dialog('open');
				//initEventosDownpaymentProgramadosRes();
  			}*/
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
				var totalProgramado = getNumberTextInputRes("totalProgramado"); 
       			var totalInicial = getNumberTextInputRes("downpaymentProgramado");
       			if (totalProgramado == totalInicial) {
       				$("#scheduledPaymentsRes").val($("#totalProgramado").val());
       				$(this).dialog('close');
       				updateBalanceFinalRes();
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

function modalDiscountAmountRes(){
	var div = "#dialog-DiscountAmount";
	dialogo = $("#dialog-DiscountAmount").dialog ({
  		open : function (event){
  			if ($(div).is(':empty')) {
  				showLoading(div, true);
		    	$(this).load ("contract/modalDiscountAmount" , function(){
		 			showLoading(div, false);
		 			initEventosDiscountRes();
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
       			$("#totalDiscountPacksRes").val($("#totalDescPack").val());	
       			var a = $('#tbodytablePackgSelected').html();
				var b = $('#packSeleccionadosRes').html(a);
				deleteElementTableFuncionRes("tableDescuentosRes", totalDescPackMainRes);
				$(this).dialog('close');
       		}
     	}],
     close: function() {
    	//$('#dialog-DiscountAmount').empty();
     }
	});
	return dialogo;
}

function tablUnidadadesRes(unidades, frequency, primero, ultimo){
	var bodyHTML = '';
	for (var i = 0; i < unidades.length; i++) {
		bodyHTML += "<tr>";
		bodyHTML += "<td>"+unidades[i].id+"</td>";
		bodyHTML += "<td>"+unidades[i].description+"</td>";
		bodyHTML += "<td>"+unidades[i].view+"</td>";
		bodyHTML += "<td>"+frequency+"</td>";
		bodyHTML += "<td>"+unidades[i].floor+"</td>";
		bodyHTML += "<td>"+unidades[i].season+"</td>";
		bodyHTML += "<td>"+unidades[i].week+"</td>";
		bodyHTML += "<td>"+primero+"</td>";
        bodyHTML += "<td>"+ultimo+"</td>";
        bodyHTML += "<td>"+ unidades[i].code +"</td>";
        bodyHTML += "<td><button type='button' class='alert button'><i class='fa fa-minus-circle fa-lg' aria-hidden='true'></i></button></td>";
        bodyHTML+="</tr>";
	}
   
    $('#tableUnidadesResSelected tbody').append(bodyHTML);
    deleteElementTableUnidadesRes("tableUnidadesResSelected");
}

function verificarTablas(div){
	var array = $("#"+div+" tbody tr");
	if (array.length>0) {
		return true;
	}else{
		return false;
	}
}

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
function selectTypePeopleRes(tipo){
	var radioButtons = $('input[name="'+tipo+'"]');
	var selectedIndex = radioButtons.index(radioButtons.filter(':checked'));
	return selectedIndex;
}

function setValueInput(id, value){
	var elemento = document.getElementById("precioUnidadRes");
	elemento.value = value;
}

function getValueFromTable(id, posicion){
	var fullArray = $("#"+id).find("td");
	return fullArray.eq(posicion).text().trim();
}

function getValueFromTableSelectedRes(id, posicion){
	var array = $("#"+id+" .yellow").find("td");
	return array.eq(posicion).text().trim();
}

function setValueUnitPriceRes(data){
	
	var value = $('#RateRes').val();
	/*var date1 = new Date(iniDateRes);
	var date2 = new Date(endDateRes);
	var dayDif = date2.getTime() - date1.getTime();
	var day = Math.round(dayDif/(1000 * 60 * 60 * 24));
	var precio = 0;
	if(data != null){
		var seasonDay = data.seasonDay;
		for( j = 0; j<day; j++ ){
			var seasonD = seasonDay[j];
			precio =  precio + seasonD.RateAmtNight;
		}
	}
	$("#precioUnidadRes").val(precio);
	$("#precioVentaRes").val(precio);*/
	
	
	var value = $('#RateRes').val();
	var date1 = new Date(iniDateRes);
	var date2 = new Date(endDateRes);
	var dayDif = date2.getTime() - date1.getTime();
	var day = Math.round(dayDif/(1000 * 60 * 60 * 24));
	var precio = 0;
	//precio = value * day;
	$("#precioUnidadRes").val(precio);
	$("#precioVentaRes").val(precio);
	updateBalanceFinalRes();
}

function getDatailByIDRes(id){
	var pickedup;
	$("#"+id).on("click", "tr", function(){
		if (pickedup != null) {
        	pickedup.removeClass("yellow");
			var id = $(this).find("td").eq(1).text().trim();
			//var id = getValueFromTableSelectedRes("reservationsTable, 1);
            var dialogEditReservation = modalEditReservation(id);
            dialogEditReservation.dialog("open");
          }
          $( this ).addClass("yellow");
          pickedup = $(this);
	});
}

function modalEditReservation(id){
	console.log(maxWidth);
	showLoading('#dialog-Edit-Reservation',true);
	dialogo = $("#dialog-Edit-Reservation").dialog ({
  		open : function (event){
	    	$(this).load("reservation/modalEdit?id="+id , function(){
				//$('#tab-general .tabs-title.active').attr('attr-screen'));
				var screen = $('#tab-general .tabs-title.active').attr('attr-screen');
				if( screen == "frontDesk" ){
					$('#tab-general .tabs-title.active').data('idRes', id);
				}
	 			showLoading('#dialog-Edit-Reservation',false);
				if ($('#editReservationStatus').text() == "Status: Out") {
					$(document).off( 'click', '#btNewTransAccRes'); 
				}else{
					$(document).off( 'click', '#btNewTransAccRes, #btAddPayAccRes'); 
					$(document).on( 'click', '#btNewTransAccRes, #btAddPayAccRes', function ( ) {
						eventTransAccRes(this);
					});
				}
	 			getDatosReservation(id);
	 			setEventosEditarReservation(id);
				selectTableUnicoRes("tableCDocumentsSelected");
				
	    	});
		},
		autoOpen: false,
     	height: maxHeight,
     	width: "75%",
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
    	$('#dialog-Edit-Reservation').empty();
     }
	});
	return dialogo;
}

function calcularPackRes(){

	var value = parseFloat($("#porcentajePack").val());
	var valueQ = parseFloat($("#quantityPack").val());
	var precioInicial = parseFloat($("#unitPricePack").val());
	var precioFinal = parseFloat($("#finalPricePack").val());

	$("#porcentajePack").off();
	$("#porcentajePack").on('keyup change click', function () {
	    if(this.value !== value) {
	    	value = this.value;
	       var p = porcentajePackRes(this.value,precioInicial);
	       $("#quantityPack").val(p);
	       if(p+precioInicial>0){
	       		$("#finalPricePack").val(p+precioInicial);
	       }else{
	       		$("#finalPricePack").val(precioInicial);
	       }
	    }        
	});
	$("#quantityPack").on('keyup change click', function () {
	    if(this.value !== valueQ) {
	    	 valueQ = parseFloat(this.value);
	    	 var porcentaje = cantidadRes(valueQ, precioInicial);
	    	 $("#porcentajePack").val(porcentaje.toFixed(3));
	    	 if(valueQ+precioInicial>0){
	    	 	$("#finalPricePack").val(precioInicial+valueQ);
	    	 }else{
	    	 	$("#finalPricePack").val(precioInicial);
	    	 }
	    }        
	});
}

function porcentajePackRes(porcentaje, cantidad){
	return parseFloat(porcentaje/100)*cantidad;
}

function cantidadRes(cantidad, precio){
	return parseFloat((cantidad / precio)*100);
}

function selectMetodoPagoProgramadosRes(){
	$('#tiposPagoProgramados').on('change', function() {
  		if(this.value == 2){
  			$("#datosTarjetaProgramados").show();
  		}else{
  			$("#datosTarjetaProgramados").hide();
  		}
  	});
}

////////////////////////////////////////////////////////////////
function selectMetodoPagoRes(){
	$('#tiposPago').on('change', function() {
  		if(this.value != 1 && this.value != 5){
  			$("#datosTarjeta").show();
  		}else{
  			$("#datosTarjeta").hide();
  		}
  	});
}

/****************Unit*****************/

function getUnidadesRes(typeUnit){
	showLoading('#tblUnidadesRes',true);
	var id;
	/*if(typeUnit == "alta"){
		id = 0;
	}else{
		id: $("#idReservationX").text()
	}*/
	
	$.ajax({
		data:{
			property: $("#propertyRes").val(),
			guestsAdult:$('#guestsAdultRes').val(),
			guestChild:$('#guestChildRes').val(),
			fromDate:$('#fromDateUnitRes').val(),
			toDate:$('#toDateUnitRes').val(),
			floorPlan:$('#floorPlanUnitRes').val(),
			view:$('#viewUnitRes').val(),
		},
		type: "POST",
		url: "reservation/getUnidades",
		dataType:'json',
		success: function(data){
			showLoading('#tblUnidadesRes',false);
			if(data != null){
				alertify.success("Found "+ data.items.length);
				drawTable(data.items, 'add', "details", "Unidades");
				$('#newReservation').data( 'season1', data.season[0].Season );
				var screen = $('#tab-general .tabs-title.active').attr('attr-screen');
				if( screen == "frontDesk" ){
					$('#section-frontDesk').data( 'season2', data.season[0].Season2 );
				}else{
					$('#section-reservations').data( 'season2', data.season[0].Season2 );
				}
			}else{
				alertify.error("No records found");
			}
		},
		error: function(){
			alertify.error("Try again");
		}
	});
}

function setDateRes(id){
	document.getElementById(id).valueAsDate = new Date();
}

function initEventosDownpaymentRes(){
	
	//var closingCost = sumarArrayRes(getArrayValuesColumnTable("tableUnidadesResSelected", 7));
	//closingCost = 350
	//$("#downpaymentGastos").val(closingCost);
	
	$( "#dateExpiracion, #datePayDawnpayment" ).Zebra_DatePicker({
		format: 'm/d/Y',
		show_icon: false,
	});
	$('#datePayDawnpayment').val(getCurrentDate())
	
	var precioUnidad = $("#montoTotalRes").val();
	if (precioUnidad>0) {
		var precioUnidadPack = $("#downpaymentPrice").val(precioUnidad);
	}else{
		var precioUnidadPack = $("#downpaymentPrice").val(0);
	}
	calcularDepositDownpaymentRes();
	selectMetodoPagoRes();
	
	$('#btnAddmontoDownpayment').click(function (){
		var amount = getNumberTextInputRes("montoDownpayment");
		var added = getNumberTextInputRes("downpaymentPrice");
		if(ValidateDownpaymentRes()){
			if(amount>0 && amount <= added){
				tableDownpaymentSelectedRes(amount);
				totalDownpaymentRes();
				$("#montoDownpayment").val(0);
			}else{
				alertify.error("The amount should be greater to zero and minus than total amount");
				errorInput("montoDownpayment", 2);
			}
		}
	});

	$('#btnCleanmontoDownpayment').click(function (){
		$("#montoDownpayment").val(0);
	});
	
	$('#numeroTarjeta').on('change', function() {
		$("#numeroTarjeta").val(splitNumberTarjetaRes());

	  /*$('#numeroTarjeta').validateCreditCard(function(result) {
	  	if (result.valid) {
	  		//$("#cardType").val(result.card_type.name);
	  		$("#numeroTarjeta").removeClass('is-invalid-input');

	  	}else{
	  		$("#numeroTarjeta").addClass('is-invalid-input');
	  	}
        });*/
	});
	
}

function ValidateDownpaymentRes(){
	var result = true;
	if( $('#tiposPago').val() == 2 || $('#tiposPago').val() == 3 || $('#tiposPago').val() == 4 ){
		if( $('#numeroTarjeta').val().trim().length > 19  ){
			alertify.error('Card Number must be less than 17');
			result = false;
		}else if( $('#numeroTarjeta').val().trim().length == 0  ){
			alertify.error('Select a Card Number');
			result = false;
		}
		if( $('#codigoPostal').val().trim().length > 9  ){
			alertify.error('The Postcode must be less than 10');
			result = false;
		}else if( $('#codigoPostal').val().trim().length == 0  ){
			alertify.error('Select a Postcode');
			result = false;
		}
		if( $('#codigoTarjeta').val().trim().length > 3  ){
			alertify.error('The CVC must be less than 4');
			result = false;
		}else if( $('#codigoTarjeta').val().trim().length == 0  ){
			alertify.error('Select a CVC');
			result = false;
		}
		if( $('#dateExpiracion').val().trim().length == 0  ){
			alertify.error('Select a date');
			result = false;
		}
	}
	return result;
}

function datosCardRes(){
	var tipoPago = $("#tiposPago").val();
	if(tipoPago != undefined ){
		if(tipoPago != 1 && tipoPago != 5 ){
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
	}else{
		return null;
	}
}

function splitNumberTarjetaRes(){
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

function initEventosDownpaymentProgramadosRes(){
	$( "#datePaymentPrg" ).Zebra_DatePicker({
		format: 'm/d/Y',
		show_icon: false,
	});
	$('#datePaymentPrg').val(getCurrentDate())
	var downpayment = $("#downpaymentPrice").val();
	var deposit = $("#depositoEngancheRes").val();
	$("#montoDownpaymentPrg").val(0);
	var programado = (downpayment-deposit).toFixed(2);
	$("#downpaymentProgramado").val(programado);
	selectMetodoPagoProgramadosRes();
	//setDate("datePaymentPrg");

	$('#btnCleanmontoDownpaymentPrg').click(function (){
		$("#montoDownpaymentPrg").val(0);
	});

	$('#btnAddmontoDownpaymentPrg').click(function () {
		var amount = getNumberTextInputRes("montoDownpaymentPrg"); 
		var total = getNumberTextInputRes("downpaymentProgramado");
		if(amount>0 && amount <= total){
			tableDownpaymentSelectedPrgRes();
			totalDownpaymentPrgRes();
		}else{
			alertify.error("The amount should be greater to zero and minus than total amount");
		}
	});

	if($("#montoDownpaymentPrg").val()>0){
		tableDownpaymentSelectedPrgRes();
		totalDownpaymentPrgRes();
	}
}

function initEventosDiscountRes(){
	getTypeGifts();
	$("#btnAddmontoPack").click(function(){
		if ($("#montoPack").val()<=0) {
			alertify.error("the amount should be greater to zero");
			errorInput("montoPack", 2);
		}else if($("#tiposPakc").val()<=0){
			alertify.error("choose a pack type");
			errorInput("tiposPakc", 2);
		}else{
			PacksAddsRes();
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
	generalSelects(data, "tiposPakc");
}

function PacksAddsRes(){
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
	totalDescPackRes();
	deleteElementTableFuncionRes("tablePackgSelected", totalDescPackRes);
}

function calcularDepositDownpaymentRes(){
	var total = parseFloat($("#downpaymentPrice").val());
	//var value = parseFloat($("#downpaymentGastos").val());
	//$("#downpaymentTotal").val(value+total);
	/*$("#downpaymentGastos").on('keyup change click', function () {
	    if(this.value !== value) {
	    	value = parseFloat(this.value);
	       if(value+total>0){
	       		$("#downpaymentTotal").val(value+total);
	       }else{
	       		$("#downpaymentTotal").val(total);
	       }
	    }        
	});*/
}

function tableDownpaymentSelectedPrgRes(){
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
	deleteElementTableFuncionRes("tablePagosPrgSelected", totalDownpaymentPrgRes);
}

function tableDownpaymentSelectedRes(){
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
	deleteElementTableFuncionRes("tablePagosSelected", totalDownpaymentRes);
}

function totalDownpaymentRes(){
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

function totalDownpaymentPrgRes(){
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

function totalDescPackRes(){
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

function totalDescPackMainRes(){
	var packs = [];
	totalCp = 0;
	var array = $("#tableDescuentosRes .montoPacks");
	for (var i = 0; i < array.length; i++) {
		var cantidad = parseFloat($(array[i]).text());
		packs.push(cantidad);
		totalCp += cantidad;
	}
	$("#totalDiscountPacksRes").val(totalCp);
}

function getArrayValuesColumnTable(tabla, columna){
	var items=[];
	$('#'+tabla+' tbody tr td:nth-child('+columna+')').each( function(){
		if ($(this).text().replace(/\s+/g, " ")!="") {
			items.push( $(this).text().replace(/\s+/g, " "));
		}       
	});
	return items;
}

function getArrayValuesSelectedColumRes(tabla, columna){
	var items=[];
	$('#'+tabla+' tbody tr.yellow td:nth-child('+columna+')').each( function(){
	   items.push( $(this).text().replace(/\s+/g, " "));       
	});
	return items;
}

/**
 * cambia los pantallas del modal con los tabs
 */
function changeTabsModalContractRes(screen, id){
	$('#tabsContratsRes .tabs-title').removeClass('active');
	$('#tabsContratsRes li[attr-screen=' + screen + ']').addClass('active');
	//muestra la pantalla selecionada
	$('#tabsContratsRes .tab-modal').hide();
	$('#' + screen).show();
	switch(screen){
		case "tab-CGeneral":
			//getDatosReservation(id);
			break;
		case "tab-RAccounts":
			//getDatosContractAccounts(id);
			getAccountsRes( id, "account", "sale" );
			//getAccountsRes( id, "account", "maintenance" );
			//getAccountsRes( id, "account", "loan" );
			break;
		case "tab-CVendors":
			getDatosContractSellersRes(id);
			break;
		case "tab-CProvisions":
			getDatosContractProvisionsRes(id);
			break;
		case "tab-COccupation":
			getDatosContractOcupationRes(id);
			break;
		case "tab-CDocuments":
			getDatosContractDocumentsREs(id);
			break;
		case "tab-CNotes":
			getDatosContractNotesRes(id);
			break;
		case "tab-CFlags":
			getDatosContractFlagsRes(id);
			break;
		case "tab-CFiles":
			getDatosContractFilesRes(id);
			break;


	}
}

function getDatosContractAccounts(id){
	console.log("Cuentas " + id);
}
function getDatosContractSellersRes(id){
	console.log("vendedores");
	
}
function getDatosContractProvisionsRes(id){
	console.log("Provisiones" + id);
}
function getDatosContractOcupationRes(id){
	//if ($("#tableCOccupationSelectedbodyRes").is(':empty')) {
		getWeeksRes(id);	
	//}
}
function getDatosContractDocumentsREs(id){
	getDocumentsRes(id);
}
function getDatosContractNotesRes(id){
	if ($('#tableCNotesSelectedBodyRes').is(':empty')){
  		getNotesRes(id);
	}
	
}
function getDatosContractFlagsRes(id){
	if ($("#tableFlagsListBodyRes").is(':empty')) {
		getTypesFlagsRes();
	}
	if ($("#flagsAsignedBodyRes").is(':empty')) {
		getFlagsRes(id);
		initEventosFlagsRes();
	}
}
function getDatosContractFilesRes(id){
	getFilesRes(id);
}

function initEventosFlagsRes(){
	$("#btnSAveFlagsRes").click(function (){
		var flags = getArrayValuesSelectedColumRes("tableFlagsListRes", 1).length;
		if (flags>0) {
			SaveFlagsContractRes();
		}else{
			alertify.error("You should pick one");
		}
	});
	//activeEvent('btnNextStatusRes', 'nextStatusContractRes');
}

function activeEventClick(id, funcionA){
	$("#"+id).click(function(){
		funcionA();
	});
}
function deactiveEventClickRes(id){
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
//var b = $('#tableUnidadesResSelected tbody').html(a);


function getPeopleContract(id){
	$.ajax({
	    data:{
	        idContrato: id
	    },
	    type: "POST",
	    url: "contract/getPeopleContract",
	    dataType:'json',
	    success: function(data){
	    	drawTableSinHeadReservation(data, "peoplesReservation");
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
	    	drawTableSinHeadReservation(data, "tableUnidadesReservation");
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function drawTableSinHeadReservation(data, table){
	var deleteButton = "<td><button type='button' class='alert button'><i class='fa fa-minus-circle fa-lg' aria-hidden='true'></i></button></td>";
    var bodyHTML = '';
    for (var i = 0; i < data.length; i++) {
        bodyHTML += "<tr>";
        for (var j in data[i]) {
            bodyHTML+="<td>" + data[i][j] + "</td>";
        };
        //bodyHTML += deleteButton;
        bodyHTML+="</tr>";
    }
    $('#' + table).html(bodyHTML);
}

function ajaxSelectsPeopleStatus(status) {
	$.ajax({
		type: "POST",
		url: "reservation/getPeopleStatus",
		dataType:'json',
		success: function(data){
			var select = '';
			 for (var i = 0; i < data.length; i++) {
		        select += '<option value="'+data[i].ID+'">';
		        for (var j in data[i]) {
		            if(data[i][j] != data[i].ID){
		                select+= data[i][j].trim();
		            }
		        };
        		select+='</option>';
        	}
        	$(".checkInPeople").html(select);
        	for (var i = 0; i < status.length; i++) {
   		 			$(".checkInPeople")[i].value = status[i];
   			}
		},
		error: function(){
			alertify.error(errorMsj);
		}
	});
}
function drawTableSinHeadReservationPeople(data, table){
	var statusActuales = [];
	var status = $("#editReservationStatus").text().replace("Status: ", "");
	var option1 = "<select class='checkInPeople'>"+status+"</select>";
	var option2 = "<select class='checkInPeople'>"+status+"</select>";
	var checkboxT = "<td><div class='rdoField'>"+option1+"</td>";
	var checkboxT2 = "<td><div class='rdoField'>"+option2+"</div></td>";
	
	var X;
	$('#' + table).empty();
    for (var i = 0; i < data.length; i++) {
    	statusActuales.push(data[i].fkPeopleStatusId);
		var bodyHTML = '';
		bodyHTML += "<tr>";
		bodyHTML += checkboxT;
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
	//defaultValuesRes();
    onChangePrimaryRes();
	deleteElementTableRes(table);
    return statusActuales;
}

function getDatosReservation(id){
	$.ajax({
	    data:{
	        idReservation: id
	    },
	    type: "POST",
	    url: "reservation/getDatosReservationById",
	    dataType:'json',
	    success: function(data){
	
			var c = parseFloat(data['CollectionCost']);
	    	$("#CollectionCostRes").text(c);
			if(data["peoples"].length > 0){
				updateLegalName(data["peoples"]);
				var status = drawTableSinHeadReservationPeople(data["peoples"], "peoplesReservation");
				ajaxSelectsPeopleStatus(status);
			}
	    	if(data["unities"].length > 0){
				drawTableSinHeadReservation(data["unities"], "tableUnidadesReservation");
			}
	    	if(data["terminosFinanciamiento"].length > 0){
				drawTerminoFinanciamientoRes(data["terminosFinanciamiento"][0]);
			}
			if(data["terminosVenta"].length > 0){
				drawTerminosVentaRes(data["terminosVenta"][0]);
			}
			var contraTemp = 0;
			if(data["reservation"]){
				contraTemp = data["reservation"][0];
				$('td.folioAccount').text(contraTemp.Folio);
				$('#editReservationStatus').attr( 'statusRes', contraTemp.StatusDesc );
			}
			//setHeightModal('dialog-Edit-Reservation');
			addFunctionalityRes();
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function addFunctionalityRes(){
	var div = "peoplesReservation";
	selectTableUnicoRes(div);
	tableOnclickRes(div);
}

function tableOnclickRes(id){
	$("#"+id).on("click", "tr", function(){
		var idPeople = $(this).find("td").eq(0).text().trim();
		//showModalContractXD(idPeople);
	});
}

function getAccountsRes( id, typeInfo, typeAcc ){
	$.ajax({
	    data:{
	        idReservation: id,
			typeInfo:typeInfo,
			typeAcc: typeAcc
	    },
	    type: "POST",
	    url: "reservation/getAccountsById",
	    dataType:'json',
	    success: function(data){
			if(typeInfo == "account"){
				var reservation = data["reservation"];
				var frontDesk = data["frontDesk"];
				var avdDeposit = data["ADV"];

				var acc = data["acc"];
				if(reservation.length > 0){
					var reservation = parsearSALERes(reservation);
					drawTable2(reservation, "tableAccountSeller", false, "");
					setTableAccountRes( reservation, "tableReservationAccRes" );
				}else{
					alertify.error('no results found');
					$("#tableAccountSeller tbody").empty();
				}
				if (avdDeposit.length>0) {
					var avdDeposit = parsearSALERes(avdDeposit);
					drawTable2(avdDeposit, "tableAccountLoan", false, "");
					setTableAccountRes( avdDeposit, "tableAccountLoanDetail" );
				}
				for( i=0; i<acc.length; i++ ){
					var nameSafe = acc[i].accType;
					$('#btNewTransAccRes').data( 'idAcc' + nameSafe, acc[i].fkAccId );
					if (nameSafe == 'RES') {
						console.log("La reserva es "+ acc[i].fkAccId);
						$("#NEWRES").text(acc[i].fkAccId);
					}
					if(nameSafe == 'ADep'){
						console.log("La cuenta AVDeposito es "+ acc[i].fkAccId);
						$("#NEWDEPS").text(acc[i].fkAccId);
					}	
				}
				$('#btNewTransAccRes').data( 'idRes', id );
			}else{
				var acc = data["acc"];
				if(acc.length > 0){
					drawTable2(acc, "tabletPaymentAccoun", false, "");
					$(".checkPayAcc").off( 'change' );
					$(".checkPayAcc").on('change', function (){
						updatePriceAccount();
					});
				}
			}
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function updatePriceAccount(){
	var amoutCur = 0;
	$("input[name='checkPayAcc[]']:checked").each(function(){
		amoutCur = amoutCur + parseFloat($(this).val());
	});
	$('#amountSettledAcc').text( '$ ' + amoutCur.toFixed(2) );
}

function verificarRED(status, balance){
	if (status== "Status: In House") {
		if (balance>0) {
	    	$(".headerDescriptionTitle").addClass("colorRED");
			$(".headerGeneral").addClass("colorRED");
	    }
	 }
}

function parsearSALERes(sales){
	var Balance = 0;
	for(var i = 0; i < sales.length; i++){
		if( sales[i].Sign_transaction == "1" ){
			Balance += parseFloat(sales[i].Amount);
			sales[i].Balance = Balance.toFixed(2);
		}
		if( sales[i].Sign_transaction == "-1" ){
			Balance -= parseFloat(sales[i].Amount);
			sales[i].Balance = Balance.toFixed(2);
			
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
	return sales;	
}

function parsearFrontDesk(frontDesk){
	var Balance = 0;
	for(var i = 0; i < frontDesk. length; i++){
		if( frontDesk[i].Sign_transaction == "1" ){
			Balance += parseFloat(frontDesk[i].Amount);
			frontDesk[i].Balance = Balance.toFixed(2);
		}
		if( frontDesk[i].Sign_transaction == "-1" ){
			Balance -= parseFloat(frontDesk[i].Amount);
			frontDesk[i].Balance = Balance.toFixed(2);
			
		}
		if (frontDesk[i].Amount !=".0000") {
			frontDesk[i].Amount = parseFloat(frontDesk[i].Amount).toFixed(2);
		}else{
			frontDesk[i].Amount = 0;
		}
		if (frontDesk[i].Pay_Amount !=".0000") {
			frontDesk[i].Pay_Amount = parseFloat(frontDesk[i].Pay_Amount).toFixed(2);
		}else{
			frontDesk[i].Pay_Amount = 0;
		}
		if (frontDesk[i].Overdue_Amount !=".0000") {
			frontDesk[i].Overdue_Amount = parseFloat(frontDesk[i].Overdue_Amount).toFixed(2);
		}else{
			frontDesk[i].Overdue_Amount = 0;
		}
		if (frontDesk[i].Euros !=".0000") {
			frontDesk[i].Euros = parseFloat(frontDesk[i].Euros).toFixed(2);
		}else{
			frontDesk[i].Euros = 0;
		}
		if (frontDesk[i].Nederlands_Florins !=".0000") {
			frontDesk[i].Nederlands_Florins = parseFloat(frontDesk[i].Nederlands_Florins).toFixed(2);
		}else{
			frontDesk[i].Nederlands_Florins = 0;
		}
	}
	return frontDesk;	
}

function setTableAccountRes(items, table){
	var balance = 0, balanceDeposits = 0, balanceSales = 0, defeatedDeposits = 0, defeatedSales = 0;
	var tempTotal = 0, tempTotal2 = 0;
	var downpayment = 0;
	var atrasadoDownpayment = 0;
	var atrasadoLoan = 0;
	var loan = 0;
	var sales = 0;
	for(i=0;i<items.length;i++){
		var item = items[i];
		if( item.Sign_transaction == "1" ){
			tempTotal += parseFloat(item.Amount);
		}
		if (item.Sign_transaction == "-1") {
			tempTotal2 += parseFloat(item.Amount);
		}
		if( item.Concept_Trxid.trim() == "Down Payment" && item.Type.trim() == "Schedule Payment"){
			atrasadoDownpayment += parseFloat(item.Overdue_Amount);
		}
		if(item.Sign_transaction == "-1" && item.Concept_Trxid.trim() == "Loan"){
			downpayment += parseFloat(item.Amount);
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
	$('#' + table +  ' tbody tr td.balanceAccount').text('$ ' + balance.toFixed(2));
	$('#' + table +  ' tbody tr td.balanceDepAccount').text('$ ' + downpayment.toFixed(2));
	$('#' + table +  ' tbody tr td.balanceSaleAccount').text('$ ' + loan.toFixed(2));

	$('#' + table +  ' tbody tr td.defeatedDepAccount').text('$ ' + atrasadoDownpayment.toFixed(2));
	$('#' + table +  ' tbody tr td.defeatedSaleAccount').text('$ ' + atrasadoLoan.toFixed(2));
}

function drawTerminosVentaRes(data){
	var price = parseFloat(data.ListPrice).toFixed(2);
	var semanas = data.WeeksNumber;
	var SpecialDiscount = parseFloat(data.SpecialDiscount);
	var salePrice = parseFloat(data.NetSalePrice).toFixed(2);
	var enganche = parseFloat(data.Deposit).toFixed(2);
	var transferido = parseFloat(data.TransferAmt).toFixed(2);
	var costoContract = parseFloat(data.ClosingFeeAmt).toFixed(2);
	var packAmount = parseFloat(data.PackPrice).toFixed(2);
	var balanceFinal = parseFloat(data.BalanceActual).toFixed(2);

	$("#cventaPriceRes").text(price);
	$("#cventaWeeksRes").text(semanas);
	//$("#cventaPackRRes").text(packReference);
	$("#cventaSalePriceRes").text(salePrice);
	$("#cventaHitchRes").text(enganche);
	$("#cventaTransferARes").text(transferido);
	$("#cventaCostContractRes").text(costoContract);
	$("#cventapackAmountRes").text(packAmount);
	$("#cventaFinancedRes").text(balanceFinal);
	//$("#cventaAmountTransfer").text(enganche + transferido);
}

function drawTerminoFinanciamientoRes(data){
	var balanceFinal  = parseFloat(data.FinanceBalance);
	var pagoMensual = parseFloat(data.MonthlyPmtAmt);
	var porEnganche = parseFloat(data.porcentaje);
	var balanceFinal = parseFloat(data.TotalFinanceAmt);

	$("#cfbalanceFinancedRes").text(balanceFinal);
	$("#cfPagoMensualRes").text(pagoMensual);
	$("#cfEngancheRes").text(porEnganche);
	$("#typeFinanceRes").text(data.FactorDesc);
	//$(".balanceAccount").text(balanceFinal);
	$("#totalMonthlyPaymentRes").text(pagoMensual);

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
	$("#editReservationStatus").text(status);
}

function setEventosEditarReservation(id){
	$('#tabsContratsRes .tabs-title').on('click', function() { 
		changeTabsModalContractRes($(this).attr('attr-screen'), id);
	});

	$("#finTerminos").click(function(){
		gotoDiv('ContenidoModalContractEdit', 'tourEditCon');
	});
	$("#ventaCondi").click(function(){
		gotoDiv('ContenidoModalContractEdit', 'finTerminos');
	});
	$("#btnNextStatusRes").click(function(){
		dialogStatusRes = modalStatusRes();
		dialogStatusRes.dialog("open");
		//nextStatusContractRes();
	});

	$('.btnReportRes').off('click');
	$('.btnReportRes').on('click', function(){
		generateReportRes(id, this);
	});
	// $('#btnDeleteDocRes').off('click');
	// $('#btnDeleteDocRes').on('click', function(){
	// 	//var idDoc = $('')
	// 	var array = $("#tableCDocumentsSelected .yellow");
	// 	if( array.length > 0 ){
	// 		var fullArray = $(array[0]).find("td");
	// 		var idDoc = fullArray.eq(1).text().replace(/\s+/g, " ");
	// 		alertify.confirm('Delete document .', "You want to delete the document.", 
	// 			function(){ deleteDocumentRes(idDoc, id); },
	// 			function(){ }
	// 		).moveTo(screen.width - 500,screen.height - 100).set('resizable',true).resizeTo('25%',210).isOpen(
	// 			$('.ajs-dialog').css('min-width','100px')
	// 		);
	// 	}else{
	// 		alertify.error('You must select a document');
	// 	}
	// });
	var status = $("#editReservationStatus").text();
	var balance = $("#tableReservationAccRes .balanceAccount").text().replace("$ ", "");
	    balance = parseFloat(balance);
	 verificarRED(status, balance);
}

function modalFinanciamientoRes() {
	var div = "#dialog-FinanciamientoRes";
	dialogo = $(div).dialog ({
  		open : function (event){
  				showLoading(div, true);
				$(this).load ("reservation/modalFinanciamiento" , function(){
					showLoading(div, false);
					initEventosFinanciamientoRes();
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
    			//alertify.success("Financiamiento guardado");
    			updateFinanciamientoRes(421);
    			//$(this).dialog('close');
				modalEditReservation(data['idContrato']);
       		}
     	}],
     close: function() {
    	//$('#dialog-ScheduledPayments').empty();
     }
	});
	return dialogo;
}

function addHTMLModalFinRes(data){
	$("#dialog-FinanciamientoRes").html(data);
	initEventosFinanciamientoRes();
}

function showModalFinRes(id){
	var ajaxData =  {
		url: "reservation/modalFinanciamiento",
		tipo: "html",
		datos: {
			idReservation: id
		},
		funcionExito : addHTMLModalFinRes,
		funcionError: mensajeAlertify
	};
	var modalPropiedades = {
		div: "dialog-FinanciamientoRes",
		altura: maxHeight,
		width: "70%",
		onOpen: ajaxDATA,
		onSave: createNewReservation,
		botones :[{
	       	text: "Cancel",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');
				var dialogEditReservation = modalEditReservation(id);
				dialogEditReservation.dialog("open");
	       }
	   	},{
       		text: "Ok",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			var totaltoPay = getNumberTextString("totalPagarF");
       			if (totaltoPay>0) {
       				updateFinanciamientoRes(id);
    				$(this).dialog('close');
					var dialogEditReservation = modalEditReservation(id);
					dialogEditReservation.dialog("open");
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

function updateFinanciamientoRes(id){
	var fechaPP = $("#fechaPrimerPagoF").val();
    var factor = $("#terminosFinanciamientoF").val();
    var pagoMensual = getArrayValuesColumnTable("tablePagosSelectedFin", 3)[0];
    var meses = parseFloat($("#numeroMesesF").text().split(" ")[0]);
    var balanceActual = getNumberTextString("balanceFinanciarF");
    var ajaxData =  {
		url: "reservation/updateFinanciamiento",
		tipo: "json",
		datos: {
			idReservation: id,
	        factor:factor,
	        pagoMensual: pagoMensual,
	        meses : meses,
	        fecha: fechaPP,
	        balanceActual: balanceActual
		},
		funcionExito : afterUpdateFinanciamientoRes,
		funcionError: mensajeAlertify
	};
	ajaxDATA(ajaxData);
}

function afterUpdateFinanciamientoRes(data){
	alertify.success(data['mensaje']);
}

function initEventosFinanciamientoRes(){
	/*setDateRes("fechaPrimerPagoFRes");
	var palabras = $("#terminosFinanciamientoFRes option:selected").text();
		palabras = palabras.split(",");
		$("#numeroMesesFRes").text(palabras[0]);
		$("#tasaInteresFRes").text(palabras[1]);

	$("#btnCalcularFRes").click(function(){
		var pagoTotal = parseFloat($("#balanceFinanciarFRes").text());
		var meses = parseFloat($("#numeroMesesFRes").text().split(" ")[0]);
		var interes = parseFloat($("#tasaInteresFRes").text().split("%")[0]);
		var pagoMensual = parseFloat(pagoTotal / meses);
		var pagoMensual = (pagoMensual).toFixed(2);
		$("#pagoMFRes").text(pagoMensual);
		$("#CargoCFRes").text("8.95");
		var totalMensual = parseFloat(pagoMensual) + parseFloat(8.95);
		$("#totalPagarFRes").text(totalMensual);

	});
	$('#terminosFinanciamientoFRes').on('change', function() {
		var palabras = $("#terminosFinanciamientoFRes option:selected").text();
		palabras = palabras.split(",");
		$("#numeroMesesFRes").text(palabras[0]);
		$("#tasaInteresFRes").text(palabras[1]);
	});*/
	
	$( "#fechaPrimerPagoF" ).Zebra_DatePicker({
		format: 'm/d/Y',
		show_icon: false,
	});
	$('#fechaPrimerPagoF').val(getCurrentDate());
	var palabras = $("#terminosFinanciamientoF option:selected").text();
		palabras = palabras.split(",");
		$("#numeroMesesF").text(palabras[0]);
		$("#tasaInteresF").text(palabras[1]);

	$( "#btnCalcularF" ).unbind( "click" );
	$( "#btnCalcularF" ).click(function(){
		var factor = $("#terminosFinanciamientoF option:selected").attr("code");
		var factor = parseFloat(factor.replace(",", "."));
		var pagoTotal = parseFloat($('#balanceFinanciarF').text().trim());
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

function setUnitiesContractPrueba(){
	$.ajax({
	    data:{
	        idContrato: 186
	    },
	    type: "POST",
	    url: "contract/createSemanaOcupacion",
	    dataType:'json',
	    success: function(data){
	    	//drawTableSinHeadReservation(data, "tableUnidadesContract");
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}


function modalSellersRes() {
	var div = "#dialog-SellersRes";
	dialogo = $(div).dialog ({
  		open : function (event){
  				showLoading(div, true);
				$(this).load ("contract/modalSellers" , function(){
					showLoading(div, false);
					initEventosSellersRes();
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
    	$('#dialog-SellersRes').empty();
     }
	});
	return dialogo;
}

function modalNewFileContractRes() {
	var div = "#dialog-newFileRes";
	dialogo = $(div).dialog ({
  		open : function (event){
  				showLoading(div, true);
				$(this).load ("reservation/modalAddFileReservation" , function(){
					ajaxSelectsRes('contract/getDocType', 'try again', generalSelects, 'slcTypeFileUp');
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
				if(verifyFileRes( arrayInput, arraySelect )){
					uploadFileContRes();
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

function initEventosSellersRes(){
	$("#btnSearchSeller").click(function(){
		getSellersRes();
	});
	$("#btnCleanSearchSeller").click(function(){
		$("#txtSearchSeller").val("");
	});
}

function getSellersRes(){
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
	    	selectTableRes("tableSellerbody");
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

/*function selectTableRes(div){
	$("#"+div).on("click", "tr", function(){
		$(this).toggleClass("yellow");
	});
}*/

function modalProvisionsRes() {
	var div = "#dialog-ProvisionesRes";
	dialogo = $(div).dialog ({
  		open : function (event){
  				showLoading(div, true);
				$(this).load ("contract/modalProvisions" , function(){
					showLoading(div, false);
					initEventosProvisionsRes();
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
    			alertify.success("added employees");
    			$(this).dialog('close');
	       
       		}
     	}],
     close: function() {
    	$('#dialog-SellersRes').empty();
     }
	});
	return dialogo;
}

function initEventosProvisionsRes(){
	$("#btnAddPovisionesDI").click(function(){
		if ($("#montoProvisiones").val()<=0) {
			alertify.error("the amount should be greater to zero");
			errorInput("montoProvisiones", 2);
		}else if($("#tiposPacksD").val()<=0){
			alertify.error("choose a pack type");
			errorInput("tiposPacksD", 2);
		}else{
			addProvisionesEventosRes();

		}
	});

	$("#btnCleanAmountProvisiones").click(function(){
		$("#montoProvisiones").val('');
	});

}

function addProvisionesEventosRes(){
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
	deleteElementTableFuncionRes( "tableProvisionesDI", addProRes );
}

function addProRes(){
	alertify.success("deleted");
}

function getWeeksRes(id){
	var div = "#content-OccupationRes";
	showLoading(div, true);
	$.ajax({
	    data:{
	        idreservation: id,
			idResType: $("#idResTypeX").text()
	    },
	    type: "POST",
	    url: "reservation/selectWeeksReservation",
	    dataType:'json',
	    success: function(data){
			if(data.length > 0){
				data = parsearOCC(data);
				drawTable2(data,"tableCOccupationSelected", false, "");
				$(document).off('click','.btnDeleteOccRes')
				$(document).on('click','.btnDeleteOccRes', function(){ 
/*					if( $("#idResTypeX").text() == 7 ){*/
						confirmDeleteOccRes(this); 
/*					}else{
						alertify.error('You can not delete nights Occupancy');
					}*/
				});
			}else{
				noResultsTable(div, "tableCOccupationSelected", "No results found");
			}
	    	//
			showLoading(div, false);
	    },
	    error: function(){
	        alertify.error("Try again");
			showLoading(div, false);
	    }
	});
}

function parsearOCC(data){
	for(var i = 0; i < data.length; i++){
		if (data[i].RateAmtNight != 0) {
			data[i].RateAmtNight = parseFloat(data[i].RateAmtNight ).toFixed(2);
		}
		
	}

	return data;
}

function confirmDeleteOccRes(selector){
	var idOcc = $(selector).attr('attr_id');
	var msg = "sure you want to delete the Occupancy?";
	alertify.confirm('Delete Occupancy .', msg, 
		function(){ deleteOccRes(idOcc); },
		function(){ }
	).moveTo(screen.width - 500,screen.height - 100).set('resizable',true).resizeTo('25%',210).isOpen(
		$('.ajs-dialog').css('min-width','100px')
	);
}

function deleteOccRes(idOcc){
	var div = "#content-OccupationRes";
	showLoading(div, true);
	$.ajax({
	    data:{
	        idResOcc: idOcc,
			idRes: $("#idReservationX").text()
	    },
	    type: "POST",
	    url: "reservation/deleteResOcc",
	    dataType:'json',
	    success: function(data){
	    	showLoading(div, false);
			alertify.success(data.message);
			var id = $("#idReservationX").text();
			getWeeksRes(id);
	    },
	    error: function(){
	        alertify.error("Try again");
			showLoading(div, false);
	    }
	});
}

function getTypesFlagsRes(id){
	var div = "#tableFlagsListBodyRes";
	showLoading(div, true);
	$.ajax({
	    data:{
	        idReservation: id
	    },
	    type: "POST",
	    url: "reservation/getTypesFlags",
	    dataType:'json',
	    success: function(data){
	    	showLoading(div, false);
	    	if (data) {

	    		//drawTableId(data,"tableFlagsListBodyRes");
	    		//selectTableRes("tableFlagsListBodyRes");
				//drawTableFlagsRes(data,"tableFlagsListBody");
	    		//saveFlagsRes("tableFlagsListBody");

				drawTableFlagsRes(data,"tableFlagsListBodyRes");
				saveFlagsRes("tableFlagsListBodyRes");

	    		//selectTableRes("tableFlagsListBodyRes");

	    	}else{
	    		alertify.error("No records found");
	    	}
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}
function saveFlagsRes(div){
	var pickedup;
	$("#"+div).on("click", "tr", function(){
          if (pickedup != null) {
              pickedup.removeClass("yellow");
          }
          $( this ).addClass("yellow");
          pickedup = $(this);
          saveFlagREs();
	});
}
function saveFlagREs(){
	var flags = getArrayValuesSelectedColumRes("tableFlagsListRes", 1).length;
	if (flags>0) {
		SaveFlagsContractRes();
	}
}

function drawTableFlagsRes(data, table){
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

function modalAddNotasRes() {
	var div = "#dialog-NotasRes";
	dialogo = $(div).dialog ({
  		open : function (event){
  				showLoading(div, true);
				$(this).load ("contract/modalAddNotas" , function(){
					showLoading(div, false);
					//initEventosSellersRes();
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
       			SaveNotesContractRes();
    			$(this).dialog('close');
	       
       		}
     	}],
     close: function() {
    	//$('#dialog-SellersRes').empty();
     }
	});
	return dialogo;
}
function modalGetAllNotesRes() {
	var id = $("#idReservationX").text();
	var div = "#dialog-NotasRes";
	dialogo = $(div).dialog ({
  		open : function (event){
  				showLoading(div, true);
				$(this).load ("reservation/modalgetAllNotes?id="+id , function(){
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

function SaveNotesRes(){
	/*var id = getValueFromTableSelectedRes("reservationsTable", 1);
	var noteType = $("#notesTypes").val();
	var noteDescription = $("#NoteDescription").val();
	$.ajax({
	    data:{
	        idReservation: id,
	        noteType:noteType,
	        noteDescription : noteDescription
	    },
	    type: "POST",
	    url: "reservation/createNote",
	    dataType:'json',
	    success: function(data){
	    	alertify.success(data['mensaje']);
	    	getNotesRes(id);
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});*/
	var noteType = $("#notesTypes").val();
	var noteDescription = $("#NoteDescription").val();
}

function SaveNotesContractRes(){
	//var id = getValueFromTableSelectedRes("contracts", 1);
	var id = $("#idReservationX").text();
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
	    	getNotesRes(id);
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function getNotesRes(id){
	var url = "reservation/getNotesReservation";
	var div = "#tableCNotesSelectedBodyRes";
	showLoading(div, true);
	$.ajax({
	    data:{
	        idReservation: id
	    },
	    type: "POST",
	    url: url,
	    dataType:'json',
	    success: function(data){
	    	showLoading(div, false);
	    	if (data) {
	    		drawTableId(data,"tableCNotesSelectedBodyRes");
	    	}else{
	    		alertify.error("No records found");
	    	}
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}
function getFlagsRes(id){
	var url = "reservation/getFlagsContract";
	var div = "#flagsAsignedBodyRes";
	showLoading(div, true);
	$.ajax({
	    data:{
	        idReservation: id
	    },
	    type: "POST",
	    url: url,
	    dataType:'json',
	    success: function(data){
	    	showLoading(div, false);
	    	if (data) {

	    		//drawTableId(data,"flagsAsignedBodyRes");
				//drawTableFlagsAsignedRes(data,"flagsAsignedBody");

	    		drawTableFlagsAsignedRes(data,"flagsAsignedBodyRes");

	    	}else{
	    		alertify.error("No records found");
	    	}
	    	
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function drawTableFlagsAsignedRes(data, table){
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
    deleteSelectFlagRes(table);
}
function deleteSelectFlagRes(div){
	/*$("#"+div).on("click", "tr", function(){
		var id = $(this).find('td').eq(1).text();
        $(this).closest("tr").remove();
        deleteFlagRes(id);
        console.log("SE elimna");
	});*/
	$("#"+div).on("click", "tr", function(){
		var id = $(this).find('td').eq(1).text();
        $(this).closest("tr").remove();
        deleteFlagRes(id);
	});
}

function deleteFlagRes(id){
	var idReservation = $("#idReservationX").text();
	var datos =  {
		url: "reservation/deleteFlag",
		tipo: "json",
		datos: {
			id:id,
			idReservation:idReservation
		},
		funcionExito : drawTableFlagsAsignedFlagsRes,
		funcionError: mensajeAlertify
	};
	ajaxDATA(datos);
}

function drawTableFlagsAsignedFlagsRes(data){
	alertify.success(data['mensaje']);
	if (data["banderas"]) {
		updateTagBanderasRes(data["banderas"]);
	}else{
		$("#flagsReservationEdit").text("Flags:");
	}
	
}


function SaveFlagsContractRes(){

	var flags = getArrayValuesSelectedColumRes("tableFlagsListRes", 1);
	//var id = getValueFromTableSelectedRes("reservationsTable", 1);
	var id = $("#idReservationX").text();
	$.ajax({
	    data:{
	        idReservation: id,
	        flags:flags
	    },
	    type: "POST",
	    url: "reservation/createFlags",
	    dataType:'json',
	    success: function(data){
	    	alertify.success(data['mensaje']);

	    	/*drawTableFlagsAsignedRes(data['banderas'],"flagsAsignedBody");
	    	if (data["banderas"]) {
	    		updateTagBanderasRes(data["banderas"]);
	    	}else{
	    		$("#flagsContracEditRes").text("Flags:");*/

	    	drawTableFlagsAsignedRes(data['banderas'],"flagsAsignedBodyRes");
	    	if (data["banderas"]) {
	    		updateTagBanderasRes(data["banderas"]);
	    	}else{
	    		$("#flagsReservationEdit").text("Flags:");
	    	}
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function updateTagBanderasRes(banderas){
	var textoBanderas = "Flags: ";
	for(var i = 0; i < banderas.length; i++){
		textoBanderas += banderas[i].FlagDesc;
		if (banderas.length != i) {
			textoBanderas += ",";
		}
	}

	$("#flagsContracEditRes").text(textoBanderas);
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

    $('#flagsAsignedBody').off('click');
    deleteSelectFlag("flagsAsignedBody");
}

function updateTagBanderasRes(banderas){
	var textoBanderas = "Flags: ";
	for(var i = 0; i < banderas.length; i++){
		textoBanderas += banderas[i].FlagDesc;
		if (banderas.length != i) {
			textoBanderas += ",";
		}
	}
	$("#flagsContracEditRes").text(textoBanderas);
}

   // $('#flagsAsignedBodyRes').off('click');
   // deleteSelectFlag("flagsAsignedBodyRes");
//}

function modalStatusRes(){
	var div = "#dialog-StatusRes";
	var id = $("#idReservationX").text();
	dialogo = $(div).dialog ({
		open : function (event){
			showLoading(div, true);
			$(this).load ("reservation/modalChangeStatus?id="+id , function(){
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
				var newStatus = $('#statusResChange option:selected').text();
				if( newStatus == "Cancel" || newStatus == "Exchange" ){
					var msg = "Are you sure you want to change the status? It eliminated the reservation.";
					alertify.confirm('Change Status.', msg, 
					function(){ nextStatusContractRes();
						var screen = $("#tab-general .tabs-title.active").attr('attr-screen');
						if ( screen == "frontDesk") {
							$("#dialog-Edit-Reservation").dialog('close');
							getFrontDesk("",1);
						} },
					function(){ }
					).moveTo(screen.width - 500,screen.height - 100).set('resizable',true).resizeTo('25%',210).isOpen(
						$('.ajs-dialog').css('min-width','100px')
					);
				}else{
					nextStatusContractRes();
				}
				
       		}
     	}],
     close: function() {
     }
	});
	return dialogo;
}

function nextStatusContractRes(){

	var div = "#dialog-StatusRes";
	showLoading(div, true);
	$("#iNextStatus").addClass("fa-spin");

	var id = $("#idReservationX").text();
	var idRestype = $("#idResTypeX").text();
	$.ajax({
	    data:{
	        idContrato: id,
			idNextStatus: $('#statusResChange').val(),
			NextStatus: $('#statusResChange option:selected').text(),
			idRestype:idRestype
	    },
	    type: "POST",
	    url: "reservation/nextStatusReservation",
	    dataType:'json',
	    success: function(data){
			
	    	if (data["dateCheckOut"]) {
	    		$("#dateCheckOut").text("Check Out: "+ data["dateCheckOut"]);
	    	}
	    	if (data["dateCheckIn"]) {
	    		$("#dateCheckIn").text("Check In: "+ data["dateCheckIn"]);
	    	}
	    	if (data['status'] == "In House") {
	    			var status = "Status: In House";
					var balance = $("#tableReservationAccRes .balanceAccount").text().replace("$ ", "");
					    balance = parseFloat(balance);
					 verificarRED(status, balance);
	    	}else{
				if( data['status'] == "Cancel" || data['status'] == "Exchange" ){
					$('#btnNextStatusRes').remove();
					$('#btnsTransRes').empty();
					$('#btnNewOccRes').remove();
				}
	    		//$( ".checkInPeople" ).prop( "disabled", true);
	    	}
			if (data['status'] == "Out") {
				$('#btNewTransAccRes').hide();
				$(document).off( 'click', '#btNewTransAccRes'); 
			}else{
				$('#btNewTransAccRes').show();
				$(document).off( 'click', '#btNewTransAccRes, #btAddPayAccRes'); 
				$(document).on( 'click', '#btNewTransAccRes, #btAddPayAccRes', function ( ) {
					eventTransAccRes(this);
				});
			}
			
	    	$("#iNextStatus").removeClass("fa-spin");
			$("#editReservationStatus").text("Status: "+data['status']);
			$('#editReservationStatus').attr( 'statusRes', data['status'] );
			showLoading(div, false);
			dialogStatusRes.dialog('close');
	    	alertify.success(data['mensaje']);
			/*
			var newStatus = $('#statusRes option:selected').text();
				if( newStatus == "Cancel" || newStatus == "Exchange" ){
			*/
	    		
	    },
	    error: function(){
			showLoading(div, false);
	        alertify.error("Try again");
	    }
	});
}
function generalSelectsDefaultRes(data, div){
     var select = '';
    for (var i = 0; i < data.length; i++) {
        select += '<option value="'+data[i].ID+'" Signo="'+data[i].TrxSign+'">';
        select += data[i].TrxTypeDesc;
        select+='</option>';
    }
    $("#"+div).html(select);
}

function getOccupancyTypes(data, div){
    var select = '';
    for (var i = 0; i < data.length; i++) {
        select += '<option value="'+data[i].ID+'">';
        for (var j in data[i]) {
            if(data[i][j] != data[i].ID){
                select+= data[i][j].trim();
            }
        };
        select+='</option>';
    }
    $("#"+div).html(select);
	getRateRes();
}



//tt.pkTrxTypeId as ID, tt.TrxTypeDesc, tt.TrxSign
function opcionAccountRes(attrType){
	var div = "#dialog-accountsRes";
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
					setDataOpcionAccountRes(attrType);

					getTrxTypeRes('contract/getTrxTypeSigno', attrType, 'try again', generalSelectsDefaultRes, 'slcTransTypeAcc');
					ajaxSelectsRes('contract/getTrxClass', 'try again', generalSelectsDefault, 'slcTrxClassAcc');
					ajaxSelectsRes('contract/getCurrency', 'try again', generalSelectsDefault, 'CurrencyTrxClassAcc');

				});
			}else{
				showLoading(div, true);
				$("#slcTransTypeAcc").attr('disabled', true);
				getTrxTypeRes('contract/getTrxTypeSigno', attrType, 'try again', generalSelectsDefaultRes, 'slcTransTypeAcc');
				setDataOpcionAccountRes(attrType);
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
       			var signo = $("#slcTransTypeAcc  option:selected").attr("Signo");
       			var cantidad = $("#tableReservationAccRes .balanceAccount").text().replace("$ ", "");
       			cantidad = parseFloat(cantidad);
       			var limiteCredito = $("#creditLimitRes").text().replace("$ ", "");
       			limiteCredito = parseFloat(limiteCredito);
       			var nuevoCantidad  = getNumberTextInput("AmountAcc");
       			var nuevaAmount = nuevoCantidad + cantidad;
       			if (signo == "1" && (nuevaAmount > limiteCredito)) {
       				alertify.error("Credit limit Exceeded");
       			}else{
					var id = "saveAccCont";
					var form = $("#"+id);
					var elem = new Foundation.Abide(form, {});
					var arrayInput = ["AmountAcc", "dueDateAcc"];
					var arraySelect = ["slcTransTypeAcc", "slcTrxClassAcc"];
					if(attrType == "addPayAcc"){
						arraySelect = ["slcTransTypeAcc"];
					}
					if(!verifyAccount(arrayInput, arraySelect )){
						$('#'+id).foundation('validateForm');
						alertify.success("Please fill required fields (red)");
					}else{
						var amoutCur = 0;
						var PAGO = parseFloat($('#AmountAcc').val().trim());
						$("input[name='checkPayAcc[]']:checked").each(function(){
							amoutCur = amoutCur + parseFloat($(this).val());
						});
						if( amoutCur > PAGO){
							var msg = "The stated amount does not cover all of the selected concepts. A partial payment was stored.";
							alertify.confirm('Transactions.', msg, 
								function(){ saveAccContRes(attrType); },
								function(){ }
							).moveTo(screen.width - 500,screen.height - 100).set('resizable',true).resizeTo('25%',210).isOpen(
								$('.ajs-dialog').css('min-width','100px')
							);
						}else{
							saveAccContRes(attrType);
						}
					}
       			}
       		}
     	}],
     close: function() {
    	$('#AmountAcc').val("");
    	$('#documentAcc').val("");
    	$('#referenceAcc').val("");
    	$("#tabletPaymentAccoun tbody").empty();
     }
	});
	return dialogo;
}



function setDataOpcionAccountRes(attrType){
	var accType = $('#tab-RAccounts .tabsModal .tabs .active').attr('attr-accType');
	if(attrType == "newTransAcc"){
		$('#grpTrxClassAcc').show();
		$('#grpTablePayAcc').hide();
		$('#inputCheckAll').hide();
		$('#inputUnCheckAll').hide();
	}else{
		var id = $("#idReservationX").text();
		getAccountsRes( id , "payment", accType );
		$('#grpTrxClassAcc').hide();
		$('#inputCheckAll').show();
		$('#inputUnCheckAll').show();
		$('#grpTablePayAcc').show();
	}

	if(accType == 6){
		//$('#accountIdAcc').text( $('#btNewTransAccRes').data( 'idAccRes' ) );
		var cuentaRES = $("#NEWRES").text();
		$('#accountIdAcc').text(cuentaRES);
	}else if(accType == 7){
		//$('#accountIdAcc').text( $('#btNewTransAccRes').data( 'idAccADep' ) );
		var cuentaDEP = $("#NEWDEPS").text();
		$('#accountIdAcc').text(cuentaDEP);
	}
	$('#dueDateAcc').val(getCurrentDate());
	$('#legalNameAcc').text($('#editContractTitle').text());
	var BALANCE = $('.balanceAccount').text();
	BALANCE = parseFloat(BALANCE.replace("$", "")).toFixed(2);
	$('#balanceAcc').text(BALANCE);
}

function getTypeAccount(accCode){
	if (accCode == "RES") {
		var idAccColl = $('#NEWRES').text();
	}else if (accCode == "ADep") {
		var idAccColl = $('#NEWDEPS').text();
	}
	return idAccColl
}

function saveAccContRes(attrType){
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

	msgReservation = alertify.success('Saving changes, please wait ....', 0);
	var accType = $('#tab-RAccounts .tabsModal .tabs .active').attr('attr-accType');
	var accCode = $('#tab-RAccounts .tabsModal .tabs .active').attr('attr-accCode');
	var idAccColl = getTypeAccount(accCode);
	
	$.ajax({
		data: {
			attrType:attrType,
			accId:idAccColl,
			trxTypeId:$('#slcTransTypeAcc').val(),
			trxClassID:$('#slcTrxClassAcc').val(),
			currency:$("#CurrencyTrxClassAcc").val().trim(),
			amount:parseFloat($('#AmountAcc').val()).toFixed(2),
			dueDt:$('#dueDateAcc').val(),
			doc:$('#documentAcc').val(),
			remark:$('#referenceAcc').val(),
			idTrans:idTrans,
			valTrans:valTrans,
			trxClass:trxClass,
		},type: "POST",
		dataType:'json',
		url: 'reservation/saveTransactionAcc'
	}).done(function( data, textStatus, jqXHR ) {
		if( data.success ){
			var id = $("#idReservationX").text();
			getAccountsRes( id, "account", "" );
			$("#dialog-accountsRes").dialog('close');
			msgReservation.dismiss();
		}else{
			$("#dialog-accountsRes").dialog('close');
			msgReservation.dismiss();
		}
	}).fail(function( jqXHR, textStatus, errorThrown ) {
		msgReservation.dismiss();
		alertify.error("Try Again");
	});
}

function getTrxTypeRes(url, attrType, errorMsj, funcion, divSelect){
	var trxType = $('#tab-RAccounts .tabsModal .tabs .active').attr('attr-accType');
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

function uploadFileContRes(){
	
	//showAlert(true,"Saving changes, please wait ....",'progressbar');
	msgReservation = alertify.success('Saving changes, please wait ....', 0);
	
	var id = $("#idReservationX").text();
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
		
	var archivos = document.getElementById("fileToUpload");//Damos el valor del input tipo file
 	var archivo = archivos.files; //obtenemos los valores de la imagen
	data.append('image',archivo[0]);
	ruta = "assets/pdf/";
	
	//rutaJson = JSON.stringify(ruta);
	data.append('ruta',ruta);
		
	//data.append('nameImage',$('#imagenName').val());
		
	//cargamos los parametros para enviar la imagen
	Req.open("POST", "reservation/saveFile", true);
		
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
			getFilesRes(id);
			var div = "#dialog-newFileRes";
			$(div).dialog('close');
			//showAlert(false,"Saving changes, please wait ....",'progressbar');
			msgReservation.dismiss();
		} else { 
			getFilesRes(id);
			alertify.error("Try again");
			var div = "#dialog-newFileRes";
			$(div).dialog('close');
			//showAlert(false,"Saving changes, please wait ....",'progressbar');
			msgReservation.dismiss();
		} 	
	};
		
	//Enviamos la petición 
 	Req.send(data);	
}

function getFilesRes(id){
	var url = "reservation/getFilesReservation";
	//var div = "#tableCFilesSelectedRes";
	showLoading("#tableCFilesSelectedRes", true);
	$.ajax({
	    data:{
	        idRes: id
	    },
	    type: "POST",
	    url: url,
	    dataType:'json',
	    success: function(data){
			if(data.length > 0){
				drawTableFiles(data, "tableCFilesSelectedRes", "seeDocumentRes", "See", "deleteFileRes");
			}else{
				alertify.error("No results found");
				$("#tableCFilesSelectedRes tbody").empty();
			}
			
			showLoading("#tableCFilesSelectedRes", false);
	    },
	    error: function(){
			showLoading("#tableCFilesSelectedRes", false);
			noResultsTable("tableCFilesSelectedRes", "tableCFilesSelectedRes", "Try again");
	        alertify.error("Try again");
	    }
	});
}

function getDocumentsRes(id){
	var url = "reservation/getDocumentsReservation";
	showLoading("#tableCDocumentsSelected", true);
	$.ajax({
	    data:{
	        idRes: id
	    },
	    type: "POST",
	    url: url,
	    dataType:'json',
	    success: function(data){
			if(data.length > 0){
				drawTableFiles(data, "tableCDocumentsSelected", "seeDocumentRes", "See", "deleteDocumentRes");
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

function seeDocumentRes(idFile){
	var url = "Pdfs/seeDocument?idFile=" + idFile;
	window.open(url);
}

function deleteFileRes(idFile){
	
	
	
	alertify.confirm('Delete File.', "To delete the file?", 
		function(){ 
			showLoading("#tableCFilesSelectedRes", true);
			$.ajax({
				data:{
					idFile: idFile
				},
				type: "POST",
				url: "reservation/deleteFile",
				dataType:'json',
				success: function(data){
					//var id = getValueFromTableSelectedRes("contracts", 1);
					var id = $("#idReservationX").text();
					getFilesRes(id);
					showLoading("#tableCFilesSelectedRes", false);
					alertify.success("deleted file");
				},
				error: function(){
					alertify.error("Try again");
					showLoading("#tableCFilesSelectedRes", false);
				}
			});
		},
		function(){ }
	).moveTo(screen.width - 500,screen.height - 100).set('resizable',true).resizeTo('25%',210).isOpen( $('.ajs-dialog').css('min-width','100px') );
	
	/*alertify.confirm("To delete the file?", function (e) {
		if (e) {
			
			// user clicked "ok"
		} else {
			// user clicked "cancel"
		}
	});*/
	//alert('id');
}
function deleteDocumentRes(idDoc, id){
	id = $("#idReservationX").text().trim();
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
				getDatosContractDocumentsREs(id);
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
function verifyFileRes( inputArray, selectArray ){
	
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

function drawTableIdOcupacionRes(data, table){
	/*var primero = data[0].FirstOccYear;
	var last = data[0].LastOccYear;
	var rango = last - primero;
	var bodyHTML = '';

	for (var i = 0; i < data.length; i++) {
        	bodyHTML += "<tr>";
        	for (var j in data[i]) {
        		bodyHTML+="<td>" + data[i][j] + "</td>";
            	
            };

        	bodyHTML+="</tr>";
   //      	for (var j = 0; j <= rango; j++) {
			// 	bodyHTML+=	bodyHTML;
			// }
        }
    $('#' + table).html(bodyHTML);*/
	
}

function getRateRes(){
	
	//$("#RateRes").attr('disabled', true);
	//var intDate = iniDateRes.split("/");
	//var occYear = intDate[2];
	//var season2 = 0;
	/*var screen = $('#tab-general .tabs-title.active').attr('attr-screen');
	if( screen == "frontDesk" ){
		season2 = $('#section-frontDesk').data( 'season2' );
	}else{
		season2 = $('#section-reservations').data( 'season2' );
	}*/
	$.ajax({
	    data:{
			/*id:unitReservacion[0].id,
			season:unitReservacion[0].season,
			occupancy:$('#occupancySalesRes').val(),
			occYear:occYear,
			intDate:iniDateRes,
			endDate:endDateRes,
			season2:season2,*/
			//season: $('#newReservation').data( 'season1' ),
			//season2: $('#newReservation').data( 'season2' ),
			idGroup:$('#occupancyTypeGroupRes').val()
		},
	    type: "POST",
	    url: "reservation/getRateType",
	    dataType:'json',
	    success: function(data){
			if(data.items.length > 0){
				item = data.items[0];
				$('#RateRes').val(item.RateAmtNight);
				setValueUnitPriceRes(null);
			}
			/*if(data.items.length > 0){
				generalSelectsDefault(data.items, "RateRes");
				//$("#RateRes").attr('disabled', false);
				setValueUnitPriceRes(data);
			}else{
				alertify.error("no price list found");
			}*/
	    },
	    error: function(){
	        alertify.error("Try again");
			$("#RateRes").attr('disabled', false);
	    }
	});
}

function generateReportRes(id, selector){
	var type = $(selector).attr("attr_type");
	var url = "";
	if(type == "CheckOutRes"){
		var url = "Pdfs/CheckOut?idRes=" + id;
	}else if(type == "FarewellRes"){
		var url = "Pdfs/Farewell?idRes=" + id;
	}else if(type == "GuestInfromationRes"){
		var url = "Pdfs/GuestInfromation?idRes=" + id;
	}else if(type == "Statement"){
		var url = "Pdfs/Statement?idRes=" + id;
	}else if( type == "ReservationConfirmation" ){
		var url = "Pdfs/ReservationConfirmation?idRes=" + id;
	}else if( type == "RoomChange" ){
		var url = "Pdfs/RoomChange?idRes=" + id;
	}
	else if( type == "Invoice" ){
		var url = "Pdfs/Invoice?idRes=" + id;
	}
	window.open(url);
}

function updateStatusPeople(id, idReserva,  idPersona){
	/*var id = getValueFromTableSelectedRes("peopleContract", 1);
	var idReserva = getValueFromTableSelectedRes("reservationsTable", 1);*/
	var ajaxData =  {
		url: "reservation/updateStatusPeople",
		tipo: "json",
		datos: {
			'idPeople': idPersona,
			'idReserva': idReserva,
			'idStatus': id
		},
		funcionExito : mensajeGeneral,
		funcionError: mensajeAlertify
	};
	ajaxDATA(ajaxData);
	
}

function mensajeGeneral(data){
	if (data['status'] == "1") {
		alertify.success(data["mensaje"]);
		var checkIn = data['CheckIn'];
		$("#dateCheckIn").text("Check In: "+checkIn);
	}else if (data['status'] == "0") {
		alertify.error(data["mensaje"]);
	}
}

function showCreditCardASR(){
	var accCode = $('#tab-RAccounts .tabsModal .tabs .active').attr('attr-accCode');
	//var idAccColl = $('#btNewTransAccRes').data( 'idAcc' + accCode );
	var idAccColl = getTypeAccount(accCode);
	if (idAccColl) {
		var ajaxData =  {
		url: "reservation/modalCreditCardAS",
		tipo: "html",
		datos: {
			idAccount: idAccColl
		},
		funcionExito : addHTMLDIVR,
		funcionError: mensajeAlertify
	};
	var modalPropiedades = {
		div: "dialog-CreditCardASR",
		altura: 540,
		width: 540,
		onOpen: ajaxDATA,
		onSave: createCreditCardR,
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
       			if (validateCreditCardASR()) {
       				createCreditCardR(idAccColl);
       				$(this).dialog('close');
       			}else{
       				alertify.error("Verify Card Data");
       			}
       		}
     	}]
	};
	if (modalCCR != null) {
		modalCCR.dialog( "destroy" );
	}
	modalCCR = modalGeneral2(modalPropiedades, ajaxData);
	modalCCR.dialog( "open" );
}else{
	alertify.error("ID Account error");
}
	
}
function validateCreditCardASR(){
	var R = true;
	var creditCard = datosCardASR();
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

function addHTMLDIVR(data){
	showLoading("#dialog-CreditCardASR",false);
	$("#dialog-CreditCardASR").html(data);

	$( "#dateExpiracionASR" ).Zebra_DatePicker({
		format: 'm/d/Y',
		show_icon: false,
	});
}

function datosCardASR(){
	var datos = {};
		datos.number = $('#numeroTarjetaASR').val().replace(/[^\d]/g, '');
		datos.type = $("#cardTypesASR").val();
		datos.dateExpiration = $("#dateExpiracionASR").val();
		datos.poscode = $("#codigoPostalASR").val();
		datos.code = $("#codigoTarjetaASR").val();
	return datos
}

function createCreditCardR(id){
	var ajaxData =  {
		url: "reservation/createCreditCardAcc",
		tipo: "json",
		datos: {
			idAccount: id,
			card: datosCardASR(),
		},
		funcionExito : creditCardMsgR,
		funcionError: mensajeAlertify
	};
	ajaxDATA(ajaxData);
}

function creditCardMsgR(data){
	if (data["status"] == 1) {
		alertify.success(data["mensaje"]);
	}else{
		alertify.error(data["mensaje"]);
	}
	
}

function updateLegalName(peoples){
	console.table(peoples);
	var nombre = $("#legalNAMER").text().trim();
	var legalName = "Legal Name :";
	for(var i = 0; i < peoples.length; i++){
		legalName += peoples[i].Name + " " + peoples[i].lastName;
		if (i+1 != peoples.length) {
			legalName += " and ";
		}
	}
	if (nombre == "Legal Name :") {
		$("#legalNAMER").text(legalName);
	}
}

function savePeopleRes(){
	
	var personas = getValueTablePersonasRes('peopleContractRes');
	if (personas.length<=0) {
			alertify.error("You must add at least one person");
	}else{
		msgReservation = alertify.success('Saving People, please wait ....', 0);
			$.ajax({
				data: {
					peoples: getValueTablePersonasRes('peopleContractRes'),
					id: $("#idReservationX").text(),
				},
				type: "POST",
				dataType:'json',
				url: 'reservation/savePeople'
			}).done(function( data, textStatus, jqXHR ) {
				msgReservation.dismiss();
				if(data.items.length > 0){
					updateLegalName(data.items);
					var status = drawTableSinHeadReservationPeople(data.items, "peoplesReservation");
					ajaxSelectsPeopleStatus(status);
				}
			}).fail(function( jqXHR, textStatus, errorThrown ) {
				msgReservation.dismiss();
				alertify.error("Try again");
			});
		//}
	}
}

function modalNewOccRes(){
	var div = "#dialog-NewOccRes";
	var id = $("#idReservationX").text().trim();	
	dialog = $(div).dialog({
		open : function (event){
			if ($(div).is(':empty')) {
				showLoading(div, true);
				$(this).load ("reservation/modalNewOccRes?id="+id , function(){
		    		showLoading(div, false);
					$( "#fromDateNewOccRes" ).Zebra_DatePicker({
						format: 'm/d/Y',
						show_icon: false,
						direction: true,
						pair: $('#toDateNewOccRes'),
					});
					$( "#toDateNewOccRes" ).Zebra_DatePicker({
						format: 'm/d/Y',
						show_icon: false,
						direction: 1
					});
	    		});
			}
		},
		autoOpen: false,
		height: maxHeight/2,
		width: "50%",
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
				if($('#fromDateNewOccRes').val().trim().length > 0 && $('#toDateNewOccRes').val().trim().length > 0 ){
					if ($("#rateNewNigth").val().trim().length>0) {
						savedayForOccRes( $('#fromDateNewOccRes').val(), $('#toDateNewOccRes').val(), $("#rateNewNigth").val().trim() );
					}else{
						alertify.error("Add a Rate");
					}
				}else{
					alertify.error("Choose dates for the reservation");
				}
			}
		}],
		close: function() {
			$('#dialog-NewOccRes').empty();
		}
	});
	return dialog;
}

function savedayForOccRes(iniDate, endDate, Rate){
	var div = "#dialog-NewOccRes";
	showLoading(div, true);
	var id = $("#idReservationX").text();
	$.ajax({
	    data:{
	        id: id,
			fromDate: iniDate,
			toDate: endDate,
			RateNight: Rate
	    },
	    type: "POST",
	    url: "reservation/savedayForOccRes",
	    dataType:'json',
	    success: function(data){
			showLoading(div, false);
			if( data.success ){
				alertify.success(data.message);
				var id = $("#idReservationX").text();
				getWeeksRes(id);
				$(div).dialog('close');
			}else{
				alertify.error(data.message);
			}
			
	    },
	    error: function(){
	        alertify.error("Try again");
			showLoading(div, false);
	    }
	});
}

function changeUnitRes(){
	var id = "saveDataReservation";
	var arrayWords = ["depositoEngancheRes", "precioUnidadRes", "precioVentaRes"];
	var form = $("#"+id);
	var elem = new Foundation.Abide(form, {});

		var unidades = getValueTableUnidadesRes();
		if (unidades.length<=0) {
			alertify.error("You must add at least one unit");
		}else{
			var id = $('#idReservationX').text();
			var unidadRes = getValueTableUnidadesRes();
			var date1 = new Date(iniDateRes);
			var date2 = new Date(endDateRes);
			var dayDif = date2.getTime() - date1.getTime();
			var day = Math.round(dayDif/(1000 * 60 * 60 * 24));
			//showAlert(true,"Saving changes, please wait ....",'progressbar');
			msgReservation = alertify.success('Saving changes, please wait ....', 0);
			$.ajax({
					data: {
						id: id,
						unidades: unidadRes,
						weeks: getArrayValuesColumnTableRes("tableUnidadesResSelected",7),
						firstYear : unidadRes[0].fyear,
						lastYear : unidadRes[0].lyear,
						occType : $("#occupancySalesRes").val(),
						occCode : $('#occupancyTypeGroupRes option:selected').attr('occCode'),
						amountTransfer:getNumberTextInputRes("amountTransferRes"),
						financeBalance: $("#financeBalanceRes").val(),
						viewId: 1,
						day:day,
						iniDate:iniDateRes,
						endDate:endDateRes,
						RateAmtNight:$('#RateRes').val()
					},

					type: "POST",
					dataType:'json',
					url: 'reservation/changeUnitRes'
				})
				.done(function( data, textStatus, jqXHR ) {
					//showAlert(false,"Saving changes, please wait ....",'progressbar');
					msgReservation.dismiss();
					if(data["unities"].length > 0){
						drawTableSinHeadReservation(data["unities"], "tableUnidadesReservation");
					}
					$('#tableUnidadesResSelected tbody').empty();
					alertify.success(data['mensaje']);
					var tabCurrent = $('#tab-general .active').attr('attr-screen');
					if(tabCurrent == "frontDesk"){
						getFrontDesk("",1);
					}else{	
						getReservations();
					}
					
				})
				.fail(function( jqXHR, textStatus, errorThrown ) {
					alertify.error("Try again");
				});
		//}
		}
}

function changeStatus(){
	
	var div = "#dialog-Edit-Reservation";
	showLoading(div,true);
	
	$.ajax({
		data:{
			id:$("#idReservationX").text()
		},
   		type: "POST",
       	url: "reservation/getDataChangeRoom",
		dataType:'json',
		success: function(data){
			showLoading(div,false);
			if ( data.items.length > 0 ){
				
				var addReservation = null;
				var unidadResDialog = addUnidadResDialog();
				addReservation = createDialogReservation(addReservation, 'change');
				addReservation.dialog("open");
				if (unidadResDialog!=null) {
					unidadResDialog.dialog( "destroy" );
				}
				unidadResDialog = addUnidadResDialog( null, data.items[0], 'change' );
				unidadResDialog.dialog( "open" );
				
			}else{
				alertify.error('no unit found');
			}
		},
		error: function(){
			showLoading(div,false);
			//showAlert(true,"Error to open new reservation, try again later. ",'button',showAlert);
			alertify.error('Error to open new reservation, try again later.');
		}
    });
	
	/*addReservation = createDialogReservation(addReservation, 'change');
		addReservation.dialog("open");
		if (unidadResDialog!=null) {
			unidadResDialog.dialog( "destroy" );
		}
		unidadResDialog = addUnidadResDialog( null, null, 'change' );
		unidadResDialog.dialog( "open" );*/
}

function testReservations(){
	var ajaxData =  {
		url: "reservation/pruebasReservations",
		tipo: "json",
		datos: {
		},
		funcionExito : mensajeTEST,
		funcionError: mensajeAlertify
	};
	ajaxDATA(ajaxData);
}

function mensajeTEST(data){
	console.table(data);
}