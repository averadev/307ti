var unitReservacion = [];
var iniDateRes = null;
var endDateRes = null;

$(document).ready(function(){
	maxHeight = screen.height * .10;
	maxHeight = screen.height - maxHeight;
	
	//dateField
	$( "#startDateRes, #endDateRes" ).Zebra_DatePicker({
		format: 'm/d/Y',
		show_icon: false,
	});
	
	var addReservation = null;
	var unidadResDialog = addUnidadResDialog();
    var peopleResDialog = addPeopleResDialog();
	var dialogWeeksRes = getWeeksResDialog();
	var dialogPackRes = PackReferenceRes();
	var dialogEngancheRes = modalDepositDownpaymentRes();
	var dialogScheduledPaymentsRes = modalScheduledPaymentsRes();
	var dialogDiscountAmountRes = modalDiscountAmountRes();
	var dialogEditReservation = modalEditReservation();
	/*var dialogAddTour = addTourContract();*/
	var dialogAccount = opcionAccountRes();

	$(document).on( 'click', '#newReservation', function () {
		addReservation = createDialogReservation(addReservation);
		addReservation.dialog("open");
		if (unidadResDialog!=null) {
			unidadResDialog.dialog( "destroy" );
		}
		unidadResDialog = addUnidadResDialog();
		unidadResDialog.dialog( "open" );
	});

	$(document).on( 'click', '#btnRefinancingResevation', function () {
		var id = getValueFromTableSelectedRes("reservationsTable", 1);
		showModalFinRes(id);
	});
	
	$(document).on( 'click', '#btnAddPeopleRes', function () {
         peopleResDialog = addPeopleResDialog();
         peopleResDialog.dialog( "open" );
	});

	$(document).on( 'click', '#btnAddUnidadesRes', function () {
		if (unidadResDialog!=null) {
			unidadResDialog.dialog( "destroy" );
		}
		unidadResDialog = addUnidadResDialog();
		unidadResDialog.dialog( "open" );
	        
	});
 	
 	$(document).on( 'click', '#btnNewSellerRes', function () {
 		if (modalVendedores!=null) {
	    		modalVendedores.dialog( "destroy" );
	    	}
	    	modalVendedores = modalSellersRes();
	        modalVendedores.dialog( "open" );
	 });

 	 $(document).on( 'click', '#btnNewFileRes', function () {
 		if (modalNewFile!=null) {
	    		modalNewFile.dialog( "destroy" );
	    	}
	    	modalNewFile = modalNewFileContractRes();
	        modalNewFile.dialog( "open" );
	 });
	$(document).on( 'click', '#btnNewProvisionRes', function () {
 		if (modalProvisiones!=null) {
	    		modalProvisiones.dialog( "destroy" );
	    	}
	    	modalProvisiones = modalProvisionsRes();
	        modalProvisiones.dialog( "open" );
	 });
	$(document).on( 'click', '#btnNewNoteRes', function () {
 		if (modalNotas!=null) {
	    		modalNotas.dialog( "destroy" );
	    	}
	    	modalNotas = modalAddNotasRes();
	        modalNotas.dialog( "open" );
	 });
	
	$(document).on( 'click', '#btnGetAllNotesRes', function () {
 		if (modalAllNotes!=null) {
	    		modalAllNotes.dialog( "destroy" );
	    	}
	    	modalAllNotes = modalGetAllNotesRes();
	        modalAllNotes.dialog( "open" );
	 });
	
	$(document).on( 'click', '#btnPackReferenceRes', function () {
		var dialogPackRes = PackReferenceRes();
		dialogPackRes.dialog("open");
	});

	$(document).on( 'click', '#btnDownpaymentRes', function () {
		var dialogEngancheRes = modalDepositDownpaymentRes();
		dialogEngancheRes.dialog("open");
	});
	
	$(document).on( 'click', '#btnScheduledPaymentsRes', function () {
		var dialogScheduledPaymentsRes = modalScheduledPaymentsRes();
		dialogScheduledPaymentsRes.dialog("open");
	});

	$(document).on( 'click', '#btnDiscountAmountRes', function () {
		var dialogDiscountAmountRes = modalDiscountAmountRes();
		dialogDiscountAmountRes.dialog("open");
	});
	
	$(document).on( 'click', '#btNewTransAccRes, #btAddPayAccRes', function () {
		var accCode = $('#tab-RAccounts .tabsModal .tabs .active').attr('attr-accCode');
		var idAccColl = $('#btNewTransAccRes').data( 'idAcc' + accCode );
		if(idAccColl != undefined){
			var dialogAccount = opcionAccountRes($(this).attr('attr_type'));
			dialogAccount.dialog("open");
		}else{
			alertify.error('No acc found');
		}
	});

	/*$(document).on( 'click', '#btnAddTourID', function () {
		var dialogAddTour = addTourContract();
		dialogAddTour.dialog("open");
	});
	$(document).on( 'click', '#btnDeleteTourID', function () {
		$('#TourID').val('0');
	});*/
	/*$(document).on( 'click', '#btnAddmontoDownpaymentPrg', function () {
		if($("#montoDownpaymentPrg").val()>0){
			tableDownpaymentSelectedPrgRes();
			totalDownpaymentPrgRes();
		}
	});*/
	$('#btnCleanWordRes').click(function (){
		$( "#stringRes, #startDateRes, #endDateRes" ).val("");
		$("#nombreRes").prop("checked", true);
		$("#advancedSearchRes").prop("checked", false);
		$("#advancedRes").hide("slow");
	});
	
	$('#btnfindRes').click(function(){
		$('#reservationstbody').empty();
		getReservations();
	});

	$("#advancedSearchRes").click(function(){
		$("#advancedRes").slideToggle("slow");
	});
	
	$(document).on( 'change', '#downpaymentRes', function () {
		$("#montoTotalRes").val($(this).val());
		var monto = $("#montoTotalRes").val();
		cambiarCantidadPRes(monto);
	});
	$(document).on( 'change', "input[name='engancheRRes']:checked", function () {
		var monto = $("#downpaymentRes").val();
		cambiarCantidadPRes(monto);
	});
	$(document).on( 'change', '#descuentoEspecialRes', function () {
		var monto = $("#descuentoEspecialRes").val();
		cambiarCantidadDERes(monto);
	});
	$(document).on( 'change', "input[name='especialDiscount']:checked", function () {
		var monto = $("#descuentoEspecialRes").val();
		cambiarCantidadDERes(monto);
	});
	/*$(document).on('change', "#precioVentaRes", function () {
		updateBalanceFinalRes();
	});*/
	$(document).on('change', "#amountTransferRes", function () {
		var balanceFinal = $("#financeBalanceRes").val();
		var transferido = $("#amountTransferRes").val();
		$("#financeBalanceRes").val(balanceFinal - transferido);
	});
	
	getDatailByIDRes("reservationstbody");
});

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
	/*var precioVenta = $("#precioVentaRes").val();
	var enganche = $("#montoTotalRes").val();
	var balanceFinal = $("#financeBalanceRes").val(precioVenta - enganche);*/
	
	//var closingCost = sumarArrayRes(getArrayValuesColumnTable("tableUnidadesResSelected", 7));
	//var closingCost = $('#RateRes').val();
	//var closingCost = sumarArrayRes(getArrayValuesColumnTable("tableUnidadesSelected", 7));
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

function cambiarCantidadPRes(monto){
	/*var seleccionado = $("input[name='engancheRRes']:checked").val();
	var precioVenta = $("#precioVentaRes").val();
	if (seleccionado == 'porcentaje') {
		var porcentaje = precioVenta * (monto/100);
		$("#montoTotalRes").val(porcentaje);
	}else{
		$("#montoTotalRes").val(monto);
	}
	updateBalanceFinalRes();*/
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
	console.log(monto);
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

function createDialogReservation(addReservation) {
	var div = "#dialog-Reservations";
	if (addReservation!=null) {
	    	addReservation.dialog( "destroy" );
	    }
	
	dialog = $(div).dialog({
		open : function (event){
			showLoading(div,true);
			$(this).load ("reservation/modal" , function(){
		    	showLoading(div,false);
		 		ajaxSelectRes('contract/getLanguages','try again', generalSelects, 'selectLanguageRes');
				ajaxSelectRes('reservation/getOccupancyTypes','try again', generalSelects, 'occupancySalesRes');
				
				$(document).on( 'change', '#occupancySalesRes', function () {
					getRateRes();
				});
				
				$(document).on( 'change', '#RateRes', function () {
					setValueUnitPriceRes();
				});
	    	});
		},
		autoOpen: false,
		height: maxHeight,
		width: "75%",
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
					createNewReservation();
					$(this).dialog('close');
					alertify.success("Se guardo correctamente");
			}
		},
			{
				text: "Save",
				"class": 'dialogModalButtonAccept',
				click: function() {
					createNewReservation();
				}
			}],
		close: function() {
			$('#dialog-Reservations').empty();
		}
	});
	return dialog;
}

function addUnidadResDialog(){
	var div = "#dialog-UnidadesRes";
	dialog = $( "#dialog-UnidadesRes" ).dialog({
		open : function (event){
				showLoading(div,true);
				$(this).load ("reservation/modalUnidades" , function(){
		    		showLoading(div,false);
		    		ajaxSelectRes('contract/getProperties','try again', generalSelects, 'propertyRes');
	    			ajaxSelectRes('contract/getUnitTypes','try again', generalSelects, 'floorPlanUnitRes');
					ajaxSelectRes('reservation/getView','try again', generalSelects, 'viewUnitRes');
					$( "#fromDateUnitRes, #toDateUnitRes" ).Zebra_DatePicker({
						format: 'm/d/Y',
						show_icon: false,
					});
					$('#btnGetUnidadesRes').click(function(){
						if($('#fromDateUnitRes').val().trim().length > 0 && $('#fromDateUnitRes').val().trim().length > 0 ){
							iniDateRes = $('#fromDateUnitRes').val();
							endDateRes = $('#toDateUnitRes').val();
							getUnidadesRes();
						}else{
							alertify.error("Choose dates for the reservation");
						}
						
					});
		            selectTableRes("tblUnidadesRes");
	    		});
	    	
		},
		autoOpen: false,
		height: maxHeight,
		width: "75%",
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
				if (unidades.length == 1) {
					var intDate = iniDateRes.split("/");
					intDate = intDate[2];
					var endDate = endDateRes.split("/");
					endDate = endDate[2];
					var frequency = "every Year";
	       			tablUnidadadesRes(unidades, frequency, intDate, endDate);
	       			$(this).dialog('close');
				}else{
					alertify.error("Find and click only one unit");
				}
			}
		}],
		close: function() {
			$('#dialog-UnidadesRes').empty();
		}
	});
	return dialog;
}

function addPeopleResDialog(){
	var div = "#dialog-PeopleRes";	
	dialog = $(div).dialog({
		open : function (event){
				showLoading(div, true);
				$(this).load ("people/index" , function(){
		    		showLoading(div, false);
		    		$("#dialog-User").hide();
	            	selectTableRes("tablePeople");
	    		});
		},
		autoOpen: false,
		height: maxHeight,
		width: "75%",
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
				if(selectAllPeopleRes()){
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
	
	noResults('#table-reservations',false);
	showLoading( '#table-frontDesk', true );
	
    var filters = getFiltersCheckboxs('filtro_reservations');
    var arrayDate = ["startDateRes", "endDateRes"];
    var dates = getDates(arrayDate);
    var arrayWords = ["stringRes"];
    var words = getWords(arrayWords);
    $.ajax({
		data:{
			filters: filters,
			dates: dates,
			words: words
		},
   		type: "POST",
       	url: "reservation/getReservations",
		dataType:'json',
		success: function(data){
			if( data.items ){
				alertify.success("Found "+ data.length);
				drawTable2(data.items,"reservationsTable","edit","editRes");
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

function selectAllPeopleRes(){
	var personasSeleccionaDas = getArrayValuesColumnTableRes("tablePeopleResSelected", 1);
	var personas = [];

	var array = $("#tablePeople .yellow");
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
			tablePeopleRes(personas);
		}
		return true;
	}
	
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
	var semanas= getArrayValuesColumnTableRes("tableUnidadesResSelected", 6);
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

function tablePeopleRes(personas){
	var bodyHTML = '';
	    //creación del body
    for (var i = 0; i < personas.length; i++) {
		bodyHTML += "<tr>";
        for (var j in personas[i]) {
            bodyHTML+="<td>" + personas[i][j] + "</td>";
        };
        bodyHTML += "<td><div class='rdoField'><input class='primy' value='"+i+"'  type='radio' name='peopleType1'><label for='folio'>&nbsp;</label></div></td>";
        bodyHTML += "<td><div class='rdoField'><input class='benefy' value='"+i+"' type='checkbox' name='peopleType2'><label for='folio'>&nbsp;</label></div></td>";
        bodyHTML += "<td><button type='button' class='alert button'><i class='fa fa-minus-circle fa-lg' aria-hidden='true'></i></button></td>";
        bodyHTML+="</tr>";
    }
    $('#tablePeopleResSelected tbody').append(bodyHTML);
    defaultValuesRes();
    onChangePrimaryRes();
	deleteElementTableRes("tablePeopleResSelected");
}

function onChangePrimaryRes(){
	$(".primy").change(function(){
		//var selected = getIndexCheckbox();
		checkAllBeneficiary(this.value);
	});
}
function defaultValuesRes(){
	$('.primy')[0].checked = true;
	checkAllBeneficiary(0);
}

//reducir a una funcion
function deleteElementTableRes(div){
	$("#"+div+" tr").on("click", "button", function(){
		$(this).closest("tr").remove();
	});
}

function deleteElementTableUnidadesRes(div){
	$("#"+div+" tr").on("click", "button", function(){
		$(this).closest("tr").remove();
		setValueUnitPriceRes();
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

	if(!verifyInputsByIDRes(arrayWords)){
		$('#'+id).foundation('validateForm');
		alertify.success("Please fill required fields (red)");
		return false;
	}else{
		var unidades = getValueTableUnidadesRes();
		var personas = getValueTablePersonasRes();
		if (personas.length<=0) {
			alertify.error("You must add at least one person");
		}else if (unidades.length<=0) {
			alertify.error("You must add at least one unit");
		}else if($("#selectLanguageRes").val()=="0"){
			$("#selectLanguageRes").addClass('is-invalid-input');
			alertify.error("Choose a language");
		}else{
			var unidadRes = getValueTableUnidadesRes();
			showAlert(true,"Saving changes, please wait ....",'progressbar');
			$.ajax({
					data: {
						idiomaID : $("#selectLanguageRes").val(),
						peoples: getValueTablePersonasRes(),
						types: typePeopleRes(),
						unidades: unidadRes,
						weeks: getArrayValuesColumnTableRes("tableUnidadesResSelected", 6),
						firstYear : unidadRes[0].fyear,
						lastYear : unidadRes[0].lyear,
						tipoVentaId : $("#occupancySalesRes").val(),
						listPrice: $("#precioUnidadRes").val(),
						salePrice: $("#precioVentaRes").val(),
						specialDiscount:$("#totalDiscountPacksRes").val(),
						downpayment:$("#downpaymentRes").val(),
						amountTransfer:$("#amountTransferRes").val(),
						packPrice:sumarArrayRes(getArrayValuesColumnTableRes("tableDescuentosRes", 2)),
						financeBalance: $("#financeBalanceRes").val(),
						tablapagos: getValueTableDownpaymentRes(),
						tablaPagosProgramados:getValueTableDownpaymentScheduledRes(),
						tablaPacks: getValueTablePacksRes(),
						viewId: 1,
					},
					type: "POST",
					dataType:'json',
					url: 'reservation/saveReservacion'
				})
				.done(function( data, textStatus, jqXHR ) {
					showAlert(false,"Saving changes, please wait ....",'progressbar');
					if (data['status']== 1) {
						elem.resetForm();
						var arrayWords = ["depositoEngancheRes", "precioUnidadRes", "precioVentaRes", "downpaymentRes"];
						clearInputsByIdRes(arrayWords);
						 if (modalFinRes!=null) {
				    		modalFinRes.dialog( "destroy" );
				    	}
				    	modalFinRes = modalFinResanciamientoRes();
				        modalFinRes.dialog( "open" );
						$('#dialog-Weeks').empty();
						$('#tablePeopleResSelected tbody').empty();
						$('#tableUnidadesResSelected tbody').empty();
						alertify.success(data['mensaje']);
					}
					
				})
				.fail(function( jqXHR, textStatus, errorThrown ) {
					alertify.error("Try again");
				});
		}
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
			pack.amount = $(this).find('td').eq(1).text()
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
function getValueTablePersonasRes(){
	/*var tabla = "tablePeopleResSelected";
	var unidades = [];
	var personas = [];
	$('#'+tabla+' tbody tr').each( function(){
		if ($(this).text().replace(/\s+/g, " ")!="") {
			var persona = {};
			persona.id = $(this).find('td').eq(0).text(),
			persona.primario = converCheked($(this).find('td').eq(4).find('input[name=primario]').filter(':checked').val()),
			persona.secundario = converCheked($(this).find('td').eq(5).find('input[name=secundario]').filter(':checked').val()),
			persona.beneficiario = converCheked($(this).find('td').eq(6).find('input[name=beneficiario]').filter(':checked').val())
			personas.push(persona); 
		}
	});
	return personas;*/
	
	var tabla = "tablePeopleResSelected";
	var unidades = [];
	var personas = [];
	$('#'+tabla+' tbody tr').each( function(i){
		if ($(this).text().replace(/\s+/g, " ")!="") {
			var persona = {};
			persona.id = $(this).find('td').eq(0).text(),
			persona.primario = $(this).find('td').eq(4).find('input[name=peopleType1]').is(':checked'),
			persona.beneficiario = $(this).find('td').eq(5).find('input[name=peopleType2]').is(':checked')
			personas.push(persona);
			console.log(i); 
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
	$("#"+div).on("click", "tr", function(){
		$(this).toggleClass("yellow");
	});
}
function selectTableUnicoRes(div){
	var pickedup;
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
     	width: "75%",
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
  			if ($(div).is(':empty')) {
  				showLoading(div, true);
				$(this).load ("contract/ScheduledPayments" , function(){
					showLoading(div, false);
					initEventosDownpaymentProgramadosRes();
				});
  			}else{
				$(this).dialog('open');
				//initEventosDownpaymentProgramadosRes();
  			}
		},
		autoOpen: false,
     	height: maxHeight,
     	width: "75%",
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
       			/*var totalProgramado = $("#totalProgramado").val();
       			var totalInicial = $("#downpaymentProgramado").val();
       			if (totalProgramado==totalInicial) {
       				$("#scheduledPaymentsRes").val($("#totalProgramado").val());
       				$(this).dialog('close');
       			}else{
       				alertify.error("verifica los pagos")
       			}*/
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
     	width: "75%",
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
       			$("#totalDiscountPacksRes").val($("#totalDescPackRes").val());	
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
		//bodyHTML += "<td>"+unidades[i].intv+"</td>";
		bodyHTML += "<td>"+unidades[i].season+"</td>";
		bodyHTML += "<td>"+unidades[i].week+"</td>";
		bodyHTML += "<td>"+primero+"</td>";
        bodyHTML += "<td>"+ultimo+"</td>";
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

function setValueUnitPriceRes(){
	/*var value = $('#RateRes').val();
	var date1 = new Date(iniDateRes);
	var date2 = new Date(endDateRes);
	var dayDif = date2.getTime() - date1.getTime();
	var day = Math.round(dayDif/(1000 * 60 * 60 * 24));
	var precio = value * day;
	$("#precioUnidadRes").val(precio);
	$("#precioVentaRes").val(precio);*/
	var precio = //sumarArrayRes(getArrayValuesColumnTableRes("tableUnidadesResSelected", 3));
	precio = $('#RateRes').val();
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
	showLoading('#dialog-Edit-Reservation',true);
	dialogo = $("#dialog-Edit-Reservation").dialog ({
  		open : function (event){
	    	$(this).load("reservation/modalEdit?id="+id , function(){
	 			showLoading('#dialog-Edit-Reservation',false);
	 			getDatosReservation(id);
	 			setEventosEditarReservation(id);
	    	});
		},
		autoOpen: false,
     	height: maxHeight,
     	width: "75%",
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

function getUnidadesRes(){
	showLoading('#tblUnidadesRes',true);
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
			console.log(data)
			showLoading('#tblUnidadesRes',false);
			if(data != null){
				alertify.success("Found "+ data.items.length);
				drawTable(data.items, 'add', "details", "Unidades");
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
	var precioUnidad = $("#montoTotalRes").val();
	if (precioUnidad>0) {
		var precioUnidadPack = $("#downpaymentPrice").val(precioUnidad);
	}else{
		var precioUnidadPack = $("#downpaymentPrice").val(0);
	}
	calcularDepositDownpaymentRes();
	selectMetodoPagoRes();
	setDate("datePayDawnpayment");
	
	$('#btnAddmontoDownpayment').click(function (){
		var amount = getNumberTextInputRes("montoDownpayment");
		var added = getNumberTextInputRes("downpaymentPrice");

		if(amount>0 && amount <= added){
			tableDownpaymentSelectedRes(amount);
			totalDownpaymentRes();
			
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
	$("#numeroTarjeta").val(splitNumberTarjetaRes());

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
	/*var downpayment = $("#downpaymentRes").val();
	$("#downpaymentProgramado").val(downpayment);
	selectMetodoPagoProgramadosRes();
	setDateRes("datePaymentPrg");
	$('#btnCleanmontoDownpaymentPrg').click(function (){
		$("#montoDownpaymentPrg").val(0);
	});*/
	var downpayment = $("#downpaymentPrice").val();
	var deposit = $("#depositoEngancheRes").val();
	$("#montoDownpaymentPrg").val(0);
	$("#downpaymentProgramado").val(downpayment-deposit);
	selectMetodoPagoProgramadosRes();
	setDate("datePaymentPrg");

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
	$("#btnAddmontoPack").click(function(){
		if ($("#montoPack").val()>0) {
			PacksAddsRes();
		}else{
			alertify.error("the amount should be greater to zero");
			errorInput("montoPack", 2);
		}
	});
}

function PacksAddsRes(){
	var td = "";
	var tipoPack = $("#tiposPakc option:selected").text();
	var monto = $("#montoPack").val();
		td = "<tr>";
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
	$('#tabsContrats .tabs-title').removeClass('active');
	$('#tabsContrats li[attr-screen=' + screen + ']').addClass('active');
	//muestra la pantalla selecionada
	$('#tabsContrats .tab-modal').hide();
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
			getDatosContractDocuments(id);
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
	if ($("#tableCOccupationSelectedbodyRes").is(':empty')) {
		getWeeksRes(id);	
	}
}
function getDatosContractDocuments(id){
	console.log("Documentos " + id);
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
	$("#btnNextStatus").click(function(){
		nextStatusContractRes();
	});
	//activeEvent('btnNextStatus', 'nextStatusContractRes');
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

function getDatosReservation(id){
	$.ajax({
	    data:{
	        idReservation: id
	    },
	    type: "POST",
	    url: "reservation/getDatosReservationById",
	    dataType:'json',
	    success: function(data){
	    	drawTableSinHeadReservation(data["peoples"], "peoplesReservation");
	    	drawTableSinHeadReservation(data["unities"], "tableUnidadesReservation");
	    	drawTerminosVentaRes(data["terminosVenta"][0]);
	    	drawTerminoFinanciamientoRes(data["terminosFinanciamiento"][0]);
			var contraTemp = data["reservation"][0];
			$('td.folioAccount').text(contraTemp.Folio);
			setHeightModal('dialog-Edit-Reservation');
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
		showModalContractXD(idPeople);
	});
}

function getAccountsRes( id, typeInfo, typeAcc ){
	console.log(id)
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
			console.log(data)
			if(typeInfo == "account"){
				var reservation = data["reservation"];
				var frontDesk = data["frontDesk"];
				var acc = data["acc"];
				if(reservation.length > 0){
					drawTable2(reservation, "tableAccountSeller", false, "");
					setTableAccountRes( reservation, "tableReservationAccRes" );
				}else{
					alertify.error('no results found')
				}
				if(frontDesk.length > 0){
					drawTable2(frontDesk, "tableAccountLoan", false, "");
					setTableAccountRes( frontDesk, "tableFrontDeskAccRes" );
				}else{
					alertify.error('no results found')
				}
				for( i=0; i<acc.length; i++ ){
					var nameSafe = acc[i].accType;
					$('#btNewTransAccRes').data( 'idAcc' + nameSafe, acc[i].fkAccId );	
				}
				$('#btNewTransAccRes').data( 'idRes', id )
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
						$('#amountSettledAcc').text( '$ ' + amoutCur.toFixed(4) );
					});
				}
			}
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function setTableAccountRes(items, table){
	var balance = 0, balanceDeposits = 0, balanceSales = 0, defeatedDeposits = 0, defeatedSales = 0;
	for(i=0;i<items.length;i++){
		var item = items[i];
		var tempTotal = 0, tempTotal2 = 0;
		if( item.Sign_transaction == 1 ){
			tempTotal = parseFloat(item.AbsAmount);
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
	
	$('#' + table +  ' tbody tr td.balanceAccount').text('$ ' + balance.toFixed(2));
	$('#' + table +  ' tbody tr td.balanceDepAccount').text('$ ' + balanceDeposits.toFixed(2));
	$('#' + table +  ' tbody tr td.balanceSaleAccount').text('$ ' + balanceSales.toFixed(2));
	$('#' + table +  ' tbody tr td.defeatedDepAccount').text('$ ' + defeatedDeposits.toFixed(2));
	$('#' + table +  ' tbody tr td.defeatedSaleAccount').text('$ ' + defeatedSales.toFixed(2));
	
}

function drawTerminosVentaRes(data){
	var price = parseFloat(data.ListPrice).toFixed(2);
	var semanas = data.WeeksNumber;
	var packReference = parseFloat(data.PackPrice).toFixed(2);
	var salePrice = parseFloat(data.NetSalePrice).toFixed(2);
	var enganche = parseFloat(data.Deposit).toFixed(2);
	var transferido = parseFloat(data.TransferAmt).toFixed(2);
	var costoContract = parseFloat(data.ClosingFeeAmt).toFixed(2);
	var packAmount = parseFloat(data.PackPrice).toFixed(2);
	var balanceFinal = parseFloat(data.BalanceActual).toFixed(2);


	$("#cventaPrice").text(price);
	$("#cventaWeeks").text(semanas);
	$("#cventaPackR").text(packReference);
	$("#cventaSalePrice").text(salePrice);
	$("#cventaHitch").text(enganche);
	$("#cventaTransferA").text(transferido);
	$("#cventaCostContract").text(costoContract);
	$("#cventapackAmount").text(packAmount);
	$("#cventaFinanced").text(balanceFinal);
	$("#cventaAmountTransfer").text(enganche + transferido);
}

function drawTerminoFinanciamientoRes(data){
	var balanceFinal  = data.FinanceBalance;
	var pagoMensual = data.MonthlyPmtAmt;
	var porEnganche = data.porcentaje;
	//var balanceFinal = data.TotalFinanceAmt;

	$("#cfbalanceFinanced").text(balanceFinal);
	$("#cfPagoMensual").text(pagoMensual);
	$("#cfEnganche").text(porEnganche);

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

function setEventosEditarReservation(id){
	$('#tabsContrats .tabs-title').on('click', function() { 
		changeTabsModalContractRes($(this).attr('attr-screen'), id);
	});

	$("#finTerminos").click(function(){
		gotoDiv('ContenidoModalContractEdit', 'tourEditCon');
	});
	$("#ventaCondi").click(function(){
		gotoDiv('ContenidoModalContractEdit', 'finTerminos');
	});
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
     	width: "75%",
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
		width: "75%",
		onOpen: ajaxDATA,
		onSave: createNewReservation,
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
    			updateFinanciamientoRes(id);
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
	var fechaPP = $("#fechaPrimerPagoFRes").val();
    var factor = $("#terminosFinanciamientoFRes").val();
    var pagoMensual = getArrayValuesColumnTableRes("tablePagosSelected", 3);
	$.ajax({
	    data:{
	        idContrato: id,
	        factor:factor,
	        pagoMensual: pagoMensual[0]
	    },
	    type: "POST",
	    url: "reservation/updateFinanciamiento",
	    dataType:'json',
	    success: function(data){
	    	alertify.success(data['mensaje']);
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function initEventosFinanciamientoRes(){
	setDateRes("fechaPrimerPagoFRes");
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
	    	//drawTableSinHead(data, "tableUnidadesContract");
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
     	width: "75%",
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
	    	selectTable("tableSellerbody");
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function modalProvisionsRes() {
	var div = "#dialog-ProvisionesRes";
	dialogo = $(div).dialog ({
  		open : function (event){
  				showLoading(div, true);
				$(this).load ("contract/modalProvisions" , function(){
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

function getWeeksRes(id){
	var div = "#tableCOccupationSelectedbodyRes";
	showLoading(div, true);
	$.ajax({
	    data:{
	        idreservation: id
	    },
	    type: "POST",
	    url: "reservation/selectWeeksReservation",
	    dataType:'json',
	    success: function(data){
	    	drawTableIdOcupacionRes(data,"tableCOccupationSelectedbodyRes");
	    	selectTableRes("tableCOccupationSelectedbodyRes");
			showLoading(div, false);
	    },
	    error: function(){
	        alertify.error("Try again");
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
	    	//console.table(data);
	    	if (data) {
	    		drawTableId(data,"tableFlagsListBodyRes");
	    		selectTableRes("tableFlagsListBodyRes");
	    	}else{
	    		alertify.error("No records found");
	    	}
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
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
       			SaveNotesRes();
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
	var id = getValueFromTableSelectedRes("reservationsTable", 1);
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
     	width: "75%",
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
	var id = getValueFromTableSelectedRes("reservationsTable", 1);
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
	    		drawTableId(data,"flagsAsignedBodyRes");
	    	}else{
	    		alertify.error("No records found");
	    	}
	    	
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function SaveFlagsContractRes(){

	var flags = getArrayValuesSelectedColumRes("tableFlagsListRes", 1);
	var id = getValueFromTableSelectedRes("reservationsTable", 1);
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
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}
function nextStatusContractRes(){
	deactiveEventClick("btnNextStatus");
	$("#iNextStatus").addClass("fa-spin");
	var id = getValueFromTableSelectedRes("reservationsTable", 1);
	$.ajax({
	    data:{
	        idContrato: id,
	    },
	    type: "POST",
	    url: "contract/nextStatusContract",
	    dataType:'json',
	    success: function(data){
	    	$("#iNextStatus").removeClass("fa-spin");
	    	$("#editContracStatus").text("Status: "+data['status']);
	    	alertify.success(data['mensaje']);
	    		$("#btnNextStatus").click(function(){
					nextStatusContractRes();
				});
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function opcionAccountRes(attrType){
	var div = "#dialog-accountsRes";
	dialogo = $(div).dialog ({
  		open : function (event){
			if ($(div).is(':empty')) {
  				showLoading(div, true);
				$(this).load ("contract/modalAccount" , function(){
					showLoading(div, false);
					//initEventosSellers();
					$( "#dueDateAcc" ).Zebra_DatePicker({
						format: 'm/d/Y',
						show_icon: false,
					});
					$("#slcTransTypeAcc").attr('disabled', true);
					setDataOpcionAccountRes(attrType);
					getTrxTypeRes('contract/getTrxType', attrType, 'try again', generalSelects, 'slcTransTypeAcc');
					ajaxSelectsRes('contract/getTrxClass', 'try again', generalSelects, 'slcTrxClassAcc');
				});
			}else{
				showLoading(div, true);
				$("#slcTransTypeAcc").attr('disabled', true);
				getTrxTypeRes('contract/getTrxType', attrType, 'try again', generalSelects, 'slcTransTypeAcc');
				setDataOpcionAccountRes(attrType);
				showLoading(div, false);
			}
		},
		autoOpen: false,
     	height: maxHeight,
     	width: "75%",
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
				var arraySelect = ["slcTransTypeAcc", "slcTrxClassAcc"];
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
								saveAccContRes(attrType);
							}
						});
					}else{
						saveAccContRes(attrType);
					}
				}
       		}
     	}],
     close: function() {
    	//$('#dialog-ScheduledPayments').empty();
     }
	});
	return dialogo;
}

function setDataOpcionAccountRes(attrType){
	var accType = $('#tab-RAccounts .tabsModal .tabs .active').attr('attr-accType');
	if(attrType == "newTransAcc"){
		$('#grpTrxClassAcc').show();
		$('#grpTablePayAcc').hide();
	}else{
		getAccountsRes( $('#btNewTransAccRes').data( 'idRes' ), "payment", accType );
		$('#grpTrxClassAcc').hide();
		$('#grpTablePayAcc').show();
	}
	if(accType == 6){
		$('#accountIdAcc').text( $('#btNewTransAccRes').data( 'idAccRes' ) );
	}else if(accType == 5){
		$('#accountIdAcc').text( $('#btNewTransAccRes').data( 'idAccFront' ) );
	}
	$('#dueDateAcc').val(getCurrentDate());
	$('#legalNameAcc').text($('#editContractTitle').text());
	$('#balanceAcc').text($('.balanceAccount').text());
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
	showAlert(true,"Saving changes, please wait ....",'progressbar');
	var accType = $('#tab-RAccounts .tabsModal .tabs .active').attr('attr-accType');
	//var accId = 0;
	/*if(accType == 6){
		accId = $('#btNewTransAccRes').data( 'idAccRes' );
	}else if(accType == 5){
		accId = $('#btNewTransAccRes').data( 'idAccFront' );
	}*/
	var accCode = $('#tab-RAccounts .tabsModal .tabs .active').attr('attr-accCode');
		var idAccColl = $('#btNewTransAccRes').data( 'idAcc' + accCode );
	$.ajax({
		data: {
			attrType:attrType,
			accId:idAccColl,
			trxTypeId:$('#slcTransTypeAcc').val(),
			trxClassID:$('#slcTrxClassAcc').val(),
			amount:$('#AmountAcc').val(),
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
			//alert("guardeishion");
			//getDatailByID("contractstbody");
			getAccountsRes( $('#btNewTransAccRes').data( 'idRes' ), "account", "" );
			$("#dialog-accountsRes").dialog('close');
			showAlert(false,"Saving changes, please wait ....",'progressbar');
		}else{
			$("#dialog-accountsRes").dialog('close');
			showAlert(false,"Saving changes, please wait ....",'progressbar');
			//alert("no transacenshion");
		}
	}).fail(function( jqXHR, textStatus, errorThrown ) {
		//alert("no guardeishion");
		//$("#dialog-accountsRes").dialog('close');
		showAlert(false,"Saving changes, please wait ....",'progressbar');
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
	
	showAlert(true,"Saving changes, please wait ....",'progressbar');
	
	var id = getValueFromTableSelectedRes("reservationsTable", 1);
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
	ruta = "assets/img/files/";
	
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
			showAlert(false,"Saving changes, please wait ....",'progressbar');
		} else { 
			getFilesRes(id);
			alertify.error("Try again");
			var div = "#dialog-newFileRes";
			$(div).dialog('close');
			showAlert(false,"Saving changes, please wait ....",'progressbar');
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
				drawTable2(data, "tableCFilesSelectedRes", "deleteFileRes", "eliminar");
			}else{
				noResultsTable("contentTableFileRes", "tableCFilesSelectedRes", "No results found");
			}
			
			showLoading("#tableCFilesSelectedRes", false);
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function deleteFileRes(idFile){
	alertify.confirm("To delete the file?", function (e) {
		if (e) {
			showLoading("#tableCFilesSelectedRes", true);
			$.ajax({
				data:{
					idFile: idFile
				},
				type: "POST",
				url: "reservation/deleteFile",
				dataType:'json',
				success: function(data){
					var id = getValueFromTableSelectedRes("contracts", 1);
					getFilesRes(id);
					showLoading("#tableCFilesSelectedRes", false);
					alertify.success("deleted file");
				},
				error: function(){
					alertify.error("Try again");
					showLoading("#tableCFilesSelectedRes", false);
				}
			});
			// user clicked "ok"
		} else {
			// user clicked "cancel"
		}
	});
	//alert('id');
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
	var primero = data[0].FirstOccYear;
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
    $('#' + table).html(bodyHTML);
}

function getRateRes(){
	$("#RateRes").attr('disabled', true);
	var intDate = iniDateRes.split("/");
	var occYear = intDate[2];
	$.ajax({
	    data:{
			id:unitReservacion[0].id,
			season:unitReservacion[0].season,
			occupancy:$('#occupancySalesRes').val(),
			occYear:occYear
		},
	    type: "POST",
	    url: "reservation/getRateType",
	    dataType:'json',
	    success: function(data){
			if(data.length > 0){
				generalSelects(data, "RateRes");
			}else{
				alertify.error("no price list found");
			}
			$("#RateRes").attr('disabled', false);
	    },
	    error: function(){
	        alertify.error("Try again");
			$("#RateRes").attr('disabled', false);
	    }
	});
}