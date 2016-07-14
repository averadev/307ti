var unitReservacion = [];
var iniDateRes = null;
var endDateRes = null;

$(document).ready(function(){
	maxHeight = screen.height * .25;
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
	/*var dialogEditContract = modalEditContract();
	var dialogAddTour = addTourContract();
	var dialogAccount = opcionAccount();*/

	$(document).on( 'click', '#newReservation', function () {
		addReservation = createDialogReservation(addReservation);
		addReservation.dialog("open");
		if (unidadResDialog!=null) {
			unidadResDialog.dialog( "destroy" );
		}
		unidadResDialog = addUnidadResDialog();
		unidadResDialog.dialog( "open" );
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
 	
 	/*$(document).on( 'click', '#btnNewSeller', function () {
 		if (modalVendedores!=null) {
	    		modalVendedores.dialog( "destroy" );
	    	}
	    	modalVendedores = modalSellers();
	        modalVendedores.dialog( "open" );
	 });

 	 $(document).on( 'click', '#btnNewFile', function () {
 		if (modalNewFile!=null) {
	    		modalNewFile.dialog( "destroy" );
	    	}
	    	modalNewFile = modalNewFileContract();
	        modalNewFile.dialog( "open" );
	 });
	$(document).on( 'click', '#btnNewProvision', function () {
 		if (modalProvisiones!=null) {
	    		modalProvisiones.dialog( "destroy" );
	    	}
	    	modalProvisiones = modalProvisions();
	        modalProvisiones.dialog( "open" );
	 });
	$(document).on( 'click', '#btnNewNote', function () {
 		if (modalNotas!=null) {
	    		modalNotas.dialog( "destroy" );
	    	}
	    	modalNotas = modalAddNotas();
	        modalNotas.dialog( "open" );
	 });*/
	
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
	
	/*$(document).on( 'click', '#btNewTransAcc, #btAddPayAcc', function () {
		var dialogAccount = opcionAccount($(this).attr('attr_type'));
		dialogAccount.dialog("open");
	});

	$(document).on( 'click', '#btnAddTourID', function () {
		var dialogAddTour = addTourContract();
		dialogAddTour.dialog("open");
	});
	$(document).on( 'click', '#btnDeleteTourID', function () {
		$('#TourID').val('0');
	});*/
	$(document).on( 'click', '#btnAddmontoDownpaymentPrg', function () {
		if($("#montoDownpaymentPrg").val()>0){
			tableDownpaymentSelectedPrgRes();
			totalDownpaymentPrgRes();
		}
	});
	$('#btnCleanWordRes').click(function (){
		$( "#stringRes, #startDateRes, #endDateRes" ).val("");
		$("#nombreRes").prop("checked", true);
		$("#advancedSearchRes").prop("checked", false);
		$("#advancedRes").hide("slow");
	});
	
	$('#btnfindRes').click(function(){
		$('#contractstbody').empty();
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
	$(document).on( 'change', "input[name='engancheR']:checked", function () {
		var monto = $("#downpaymentRes").val();
		cambiarCantidadPRes(monto);
	});
	$(document).on('change', "#precioVentaRes", function () {
		updateBalanceFinalRes();
	});
	$(document).on('change', "#amountTransferRes", function () {
		var balanceFinal = $("#financeBalanceRes").val();
		var transferido = $("#amountTransferRes").val();
		$("#financeBalanceRes").val(balanceFinal - transferido);
	});
	
	//getDatailByID("contractstbody");
});

function updateBalanceFinalRes(){
	var precioVenta = $("#precioVentaRes").val();
	var enganche = $("#montoTotalRes").val();
	var balanceFinal = $("#financeBalanceRes").val(precioVenta - enganche);
}

function cambiarCantidadPRes(monto){
	var seleccionado = $("input[name='engancheR']:checked").val();
	var precioVenta = $("#precioVentaRes").val();
	if (seleccionado == 'porcentaje') {
		var porcentaje = precioVenta * (monto/100);
		$("#montoTotalRes").val(porcentaje);
	}else{
		$("#montoTotalRes").val(monto);
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
				/*(document).on( 'change', '#RateRes', function () {
					console.log("holnasjkasjkasjk")
					setValueUnitPriceRes();
				});*/
	    	});
		},
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
				var unidades = getValueTableUnidadesSeleccionadasRes();
				if (unidades.length == 1) {
					$(this).dialog('close');
					var dialogWeeksRes = getWeeksResDialog(unidades);
					dialogWeeksRes.dialog("open");
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
	showLoading('#reservationsTable',true);
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
			console.log(data)
			if( data.items ){
				alertify.success("Found "+ data.length);
				drawTable2(data.items,"reservationsTable","edit","editRes");
			}else{
				noResultsTable("table-reservations", "reservationsTable", "no results found");
			}
			showLoading('#reservationsTable',false);
		},
		error: function(){
			alertify.error("Try again");
			showLoading('#reservationsTable',false);
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
			unidad.intv = $(this).find('td').eq(6).text(),
			unidad.season = $(this).find('td').eq(7).text(),
			unidad.week = $(this).find('td').eq(8).text(),
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
        bodyHTML += "<td><div class='rdoField'><input type='radio' name='primario'><label for='folio'>&nbsp;</label></div></td>";
        bodyHTML += "<td><div class='rdoField'><input type='radio' name='secundario'><label for='folio'>&nbsp;</label></div></td>";
        bodyHTML += "<td><div class='rdoField'><input type='radio' name='beneficiario'><label for='folio'>&nbsp;</label></div></td>";
        bodyHTML += "<td><button type='button' class='alert button'><i class='fa fa-minus-circle fa-lg' aria-hidden='true'></i></button></td>";
        bodyHTML+="</tr>";
    }
    $('#tablePeopleResSelected tbody').append(bodyHTML);
    deleteElementTableRes("tablePeopleResSelected");
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
			showAlert(true,"Saving changes, please wait ....",'progressbar');
			$.ajax({
					data: {
						idiomaID : $("#selectLanguageRes").val(),
						peoples: getValueTablePersonasRes(),
						types: typePeopleRes(),
						unidades: getValueTableUnidadesRes(),
						weeks: getArrayValuesColumnTableRes("tableUnidadesResSelected", 6),
						firstYear :$("#firstYearWeeks").val().trim(),
						lastYear : $("#lastYearWeeks").val().trim(),
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
			unidad.price = $(this).find('td').eq(2).text(),
			unidad.frequency = $(this).find('td').eq(3).text(),
			unidad.season = $(this).find('td').eq(4).text(),
			unidad.week = $(this).find('td').eq(5).text(),
			unidad.fyear = $(this).find('td').eq(6).text(),
			unidad.lyear = $(this).find('td').eq(7).text()
			unidades.push(unidad); 
		}
	});
	return unidades;
}
function getValueTablePersonasRes(){
	var tabla = "tablePeopleResSelected";
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
       		text: "ok",
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
       		text: "ok",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			$("#precioVentaRes").val($("#finalPricePack").val());
       			$("#packReference").val($("#quantityPack").val());
       			$(this).dialog('close');
       		}
     	}],
     close: function() {
     }
	});
	return dialogo;
}

function modalDepositDownpaymentRes(){
	showLoading('#dialog-Downpayment', true);
	dialogo = $("#dialog-Downpayment").dialog ({
  		open : function (event){
	    	$(this).load ("contract/modalDepositDownpayment" , function(){
	    		showLoading('#dialog-Downpayment', false);
	    		initEventosDownpaymentRes();
	    	});
		},
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
       		text: "ok",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			var deposito = $("#finalPriceDownpayment").val();
       			var total = $("#downpaymentTotal").val();
       			if (deposito>total) {
       				alertify.error("la cantidad es mayor al total")
       			}else{
       				$("#depositoEngancheRes").val(deposito);
       				$(this).dialog('close');	
       			}
       			
       		}
     	}],
     close: function() {
     }
	});
	return dialogo;
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
				initEventosDownpaymentProgramadosRes();
  			}
		},
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
       		text: "ok",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			var totalProgramado = $("#totalProgramado").val();
       			var totalInicial = $("#downpaymentProgramado").val();
       			if (totalProgramado==totalInicial) {
       				$("#scheduledPayments").val($("#totalProgramado").val());
       				$(this).dialog('close');
       			}else{
       				alertify.error("verifica los pagos")
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
     	width: "50%",
     	modal: true,
     	buttons: [{
	       	text: "Cancel",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');
	       }
	   	},{
       		text: "ok",
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
		bodyHTML += "<td>"+unidades[i].intv+"</td>";
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

function getValueFromTableSelected(id, posicion){
	var array = $("#"+id+" .yellow").find("td");
	return array.eq(posicion).text().trim();
}

function setValueUnitPriceRes(){
	var value = $('#RateRes').val();
	var date1 = new Date(iniDateRes);
	var date2 = new Date(endDateRes);
	var dayDif = date2.getTime() - date1.getTime();
	var day = Math.round(dayDif/(1000 * 60 * 60 * 24));
	var precio = value * day;
	$("#precioUnidadRes").val(precio);
	$("#precioVentaRes").val(precio);
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
				alertify.success("Found "+ data.length);
				drawTable(data, 'add', "details", "Unidades");
			}else{
				//$('#contractstbody').empty();
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
	var precioUnidad = $("#downpaymentRes").val();
	if (precioUnidad>0) {
		var precioUnidadPack = $("#downpaymentPrice").val(precioUnidad);
	}else{
		var precioUnidadPack = $("#downpaymentPrice").val(0);
	}
	calcularDepositDownpaymentRes();
	selectMetodoPagoRes();
	setDateRes("datePayDawnpayment");
	
	$('#btnAddmontoDownpayment').click(function (){
		if($("#montoDownpayment").val()>0){
			tableDownpaymentSelectedRes();
			totalDownpaymentRes();
		}else{
			alertify.error("the amount should be greater to zero and minus than the amount total");
			errorInput("montoDownpayment", 2);
		}
	});
	$('#btnCleanmontoDownpayment').click(function (){
		$("#montoDownpayment").val(0);
	});
	
}

function initEventosDownpaymentProgramadosRes(){
	var downpayment = $("#downpaymentRes").val();
	$("#downpaymentProgramado").val(downpayment);
	selectMetodoPagoProgramadosRes();
	setDateRes("datePaymentPrg");
	$('#btnCleanmontoDownpaymentPrg').click(function (){
		$("#montoDownpaymentPrg").val(0);
	});
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

////////////////////////////////////////////////////////////////
function selectMetodoPagoRes(){
	$('#tiposPago').on('change', function() {
  		if(this.value == 2){
  			$("#datosTarjeta").show();
  		}else{
  			$("#datosTarjeta").hide();
  		}
  	});
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

function calcularPackRes(){

	var value = parseFloat($("#porcentajePack").val());
	var valueQ = parseFloat($("#quantityPack").val());
	var precioInicial = parseFloat($("#unitPricePack").val());
	var precioFinal = parseFloat($("#finalPricePack").val());

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
     	width: "50%",
     	modal: true,
     	buttons: [{
	       	text: "Cancel",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');
	       }
	   	},{
       		text: "ok",
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

function getRateRes(){
	$("#RateRes").attr('disabled', true);
	var intDate = iniDateRes.split("/");
	var occYear = intDate[2];
	$.ajax({
	    data:{
			id:unitReservacion[0].id,
			//season:unitReservacion[0].season,
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