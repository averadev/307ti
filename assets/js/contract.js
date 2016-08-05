$(document).ready(function(){
	maxHeight = screen.height * .10;
	maxHeight = screen.height - maxHeight;
    var unidadDialog = addUnidadDialog();
    var peopleDialog = addPeopleDialog();
	var dialogWeeks = getWeeksDialog();
	var dialogPack = PackReference();
	var dialogEnganche = modalDepositDownpayment();
	var dialogScheduledPayments = modalScheduledPayments();
	var dialogDiscountAmount = modalDiscountAmount();
	var dialogEditContract = modalEditContract();
	var dialogAddTour = addTourContract();
	var dialogAccount = opcionAccount();


$(document).on( 'click', '#newContract', function () {
	showModalContract();
});
$(document).on( 'click', '#btnRefinancingContract', function () {
	var id = getValueFromTableSelected("contracts", 1);
	showModalFin(id);
});
$(document).on( 'click', '#btnAddPeople', function () {
	peopleDialog = addPeopleDialog();
	peopleDialog.dialog( "open" );
});

	 $(document).on( 'click', '#btnAddUnidades', function () {
	        if (unidadDialog!=null) {
	    		unidadDialog.dialog( "destroy" );
	    	}
	    	unidadDialog = addUnidadDialog();
	        unidadDialog.dialog( "open" );
	        
	    });
 	
 	$(document).on( 'click', '#btnNewSeller', function () {
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
	 });
	$(document).on( 'click', '#btnGetAllNotes', function () {
 		if (modalAllNotes!=null) {
	    		modalAllNotes.dialog( "destroy" );
	    	}
	    	modalAllNotes = modalGetAllNotes();
	        modalAllNotes.dialog( "open" );
	 });
	
	$(document).on( 'click', '#btnPackReference', function () {
		var dialogPack = PackReference();
		dialogPack.dialog("open");
	});

	$(document).on( 'click', '#btnDownpayment', function () {
		var dialogEnganche = modalDepositDownpayment();
		dialogEnganche.dialog("open");
	});
	
	$(document).on( 'click', '#btnScheduledPayments', function () {
		var dialogScheduledPayments = modalScheduledPayments();
		dialogScheduledPayments.dialog("open");
	});

	$(document).on( 'click', '#btnDiscountAmount', function () {
		var dialogDiscountAmount = modalDiscountAmount();
		dialogDiscountAmount.dialog("open");
	});
	
	$(document).on( 'click', '#btNewTransAcc, #btAddPayAcc', function () {
		var accCode = $('#tab-CAccounts .tabsModal .tabs .active').attr('attr-accCode');
		var idAccColl = $('#btNewTransAcc').data( 'idAcc' + accCode );
		if(idAccColl != undefined){
			var dialogAccount = opcionAccount($(this).attr('attr_type'));
			dialogAccount.dialog("open");
		}else{
			alertify.error('No acc found');
		}
		
	});

	$(document).on( 'click', '#btnAddTourID', function () {
		var dialogAddTour = addTourContract();
		dialogAddTour.dialog("open");
	});
	$(document).on( 'click', '#btnDeleteTourID', function () {
		$('#TourID').val('0');
	});
	$('#btnCleanWord').click(function (){
		$('#stringContrat').val('');
	});
	
	$('#btnfind').click(function(){
		$('#contractstbody').empty();
		getContratos();
	});

	$("#busquedaAvanazada").click(function(){
		$("#avanzada").slideToggle("slow");
	});
	//Enganche
	$(document).on( 'change', '#downpayment', function () {
		$("#montoTotal").val($("#downpayment").val());
		var monto = $("#montoTotal").val();
		cambiarCantidadP(monto);
	});
	$(document).on('change', "input[name='engancheR']:checked", function () {
		$("#montoTotal").val($("#downpayment").val());
		var monto = $("#montoTotal").val();
		cambiarCantidadP(monto);
	});
	$(document).on( 'change', '#descuentoEspecial', function () {
		var monto = $("#descuentoEspecial").val();
		cambiarCantidadDE(monto);
	});
	$(document).on( 'change', "input[name='especialDiscount']:checked", function () {
		var monto = $("#descuentoEspecial").val();
		cambiarCantidadDE(monto);
	});
	$(document).on('change', "#amountTransfer", function () {
		var balanceFinal = $("#financeBalance").val();
		var transferido = $("#amountTransfer").val();
		$("#financeBalance").val(balanceFinal - transferido);
	});
	
	getDatailByID("contractstbody");
});

function updateBalanceFinal(){
	var closingCost = sumarArray(getArrayValuesColumnTable("tableUnidadesSelected", 7));
	var precioVenta = getNumberTextInput("precioVenta");

	var descuentoEspecial = getNumberTextInput("montoTotalDE");
	var deposito = getNumberTextInput("depositoEnganche");
	var pagosProgramados = getNumberTextInput("scheduledPayments");


	var descuentoEfectivo = getNumberTextInput("totalDiscountPacks"); 
	var transferencia = getNumberTextInput("amountTransfer");

	var descuento = descuentoEspecial + deposito + pagosProgramados + descuentoEfectivo + transferencia;
	var costoTotal = precioVenta + closingCost;
	var total = costoTotal - descuento;
	$("#financeBalance").val(total);
	
}

function getNumberTextInput(div){
	var valor = $("#"+div).val();
	if(valor){
		return parseFloat(valor);
	}else{
		return 0;
	}
}
function getNumberTextString(div){
	var valor = $("#"+div).text();
	if(valor){
		return parseFloat(valor);
	}else{
		return 0;
	}
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
		$("#montoTotal").val(monto);
	}
	//updateBalanceFinal();
}
function cambiarCantidadDE(monto){
	console.log(monto);
	var seleccionado = $("input[name='especialDiscount']:checked").val();
	var precioVenta = $("#precioVenta").val();
	if (seleccionado == 'porcentaje') {
		var porcentaje = precioVenta * (monto/100);
		$("#montoTotalDE").val(porcentaje);
	}else{
		$("#montoTotalDE").val(monto);
	}
	updateBalanceFinal();
}
function createContractSelect(datos){

	$("#dialog-Contract").html(datos);
	
	//ajaxSelects('contract/getLanguages','try again', generalSelects, 'selectLanguage');
	ajaxSelects('contract/getSaleTypes','try again', generalSelectsDefault, 'typeSales');
	//$('#selectLanguage option:eq(1)').prop('selected', 1);
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
		width: "75%",
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
			text: "Save and Close",
			"class": 'dialogModalButtonAccept',
			click: function() {
				if (verifyContractALL()) {
					createNewContract();
					$(this).dialog('close');
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
	addContract = modalGeneral3(modalPropiedades, ajaxData);
	addContract.dialog( "open" );
}

function cerrarContract(){
	$('#dialog-DiscountAmount').empty();
}
function addTourContract(unidades){
	var div = '#dialog-tourID';
	var unidades = unidades;
	dialogo = $("#dialog-tourID").dialog ({
  		open : function (event){
  			if ($(div).is(':empty')) {
  				showLoading(div,true);
  				$(this).load ("tours/index" , function(){
	    			showLoading(div,false);
	    			selectTableUnico("tours");
	    		});
  			}
		},
		autoOpen: false,
     	height: maxHeight,
     	width: "70%",
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
function addUnidadDialog() {
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
					$('#btngetUnidades').click(function(){
					        getUnidades();
					});
		            selectTable("tblUnidades");
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
				var unidades = getValueTableUnidadesSeleccionadas();
				if (unidades.length>0) {
					$(this).dialog('close');
					var dialogWeeks = getWeeksDialog(unidades);
					dialogWeeks.dialog("open");
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
function addPeopleDialog() {
	var div = "#dialog-People";	
	dialog = $(div).dialog({
		open : function (event){
				showLoading(div, true);
				$(this).load ("people/index" , function(){
		    		showLoading(div, false);
		    		$("#dialog-User").hide();
	            	selectTable("tablePeople");
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
				if(selectAllPeople()){
					$(this).dialog('close');
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
			if(data){
				alertify.success("Found "+ data.length + " Contracts");
				drawTable3(data, "details", "contracts");
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
	var unidades = getValueTableUnidades();
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
		showAlert(true,"Saving changes, please wait ....",'progressbar');
		$.ajax({
			data: {
				idiomaID : $("#selectLanguage").val(),
				firstYear :$("#firstYearWeeks").val().trim(),
				lastYear : $("#lastYearWeeks").val().trim(),
				legalName : $("#legalName").val().trim(),
				tourID : $("#TourID").val().trim(),
				peoples: getValueTablePersonas(),
				types: 	typePeople(),
				unidades: getValueTableUnidades(),
				weeks: getArrayValuesColumnTable("tableUnidadesSelected", 6),
				tipoVentaId : $("#typeSales").val(),
				listPrice: $("#precioUnidad").val(),
				salePrice: $("#precioVenta").val(),
				specialDiscount:$("#montoTotalDE").val(),
				downpayment:$("#montoTotal").val(),
				amountTransfer:$("#amountTransfer").val(),
				packPrice:sumarArray(getArrayValuesColumnTable("tableDescuentos", 3)),
				financeBalance: $("#financeBalance").val(),
				tablapagos: getValueTableDownpayment(),
				tablaPagosProgramados:getValueTableDownpaymentScheduled(),
				gifts: getValueTablePacks(),
				viewId: 1,
				closingCost: sumarArray(getArrayValuesColumnTable("tableUnidadesSelected", 7)),
				card: datosCard()
				//totalDiscountPacks
			},
			type: "POST",
			dataType:'json',
			url: 'contract/saveContract'
		}).done(function( data, textStatus, jqXHR ) {
				showAlert(false,"Saving changes, please wait ....",'progressbar');
				if (data['status']== 1) {
					elem.resetForm();
					var arrayWords = ["legalName", "TourID", "depositoEnganche", "precioUnidad", "precioVenta", "downpayment"];
					clearInputsById(arrayWords);
					if (modalFin!=null) {
						modalFin.dialog( "destroy" );
					}
					if (data['balance'].financeBalance >0) {
						showModalFin(data['idContrato']);
					}
					
					$('#dialog-Weeks').empty();
					$('#tablePeopleSelected tbody').empty();
					$('#tableUnidadesSelected tbody').empty();
					alertify.success(data['mensaje']);
				}}).fail(function( jqXHR, textStatus, errorThrown ) {

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

function getValueTableUnidades(){
	var tabla = "tableUnidadesSelected";
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
			console.log(i); 
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

function selectAllPeople(){
	var personasSeleccionaDas = getArrayValuesColumnTable("tablePeopleSelected", 1);
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
			tablaPersonas(personas);
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
			unidades.push(unidad); 
		}
	});
	return unidades;
}



function tablaPersonas(personas){
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
    $('#tablePeopleSelected tbody').append(bodyHTML);
    defaultValues();
    onChangePrimary();
    deleteElementTable("tablePeopleSelected");
}

function onChangePrimary(){
	$(".primy").change(function(){
		//var selected = getIndexCheckbox();
		checkAllBeneficiary(this.value);
	});
}
function defaultValues(){
	$('.primy')[0].checked = true;
	checkAllBeneficiary(0);
}
//reducir a una funcion
function deleteElementTable(div){
	$("#"+div+" tr").on("click", "button", function(){
		$(this).closest("tr").remove();
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


function getWeeksDialog(unidades){
	showLoading('#dialog-Weeks', true);
	var unidades = unidades;
	dialogo = $("#dialog-Weeks").dialog ({
  		open : function (event){
	    	$(this).load ("contract/modalWeeks", function(){
	    		showLoading('#dialog-Weeks', false);
	    		ajaxSelects('contract/getFrequencies','try again', generalSelectsDefault, 'frequency');
	    		$("#weeksNumber").val(1);
	    		setYear("firstYearWeeks", 0);
	    		setYear("lastYearWeeks", 25);
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
	       			tablUnidadades(unidades, frequency, primero, ultimo);	
	       			$(this).dialog('close');
	       			setValueUnitPrice();
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
  			if ($(div).is(':empty')) {
  				showLoading(div, true);
				$(this).load ("contract/ScheduledPayments" , function(){
					showLoading(div, false);
					initEventosDownpaymentProgramados();
				});
  			}else{
				$(this).dialog('open');
				//initEventosDownpaymentProgramados();
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

function tablUnidadades(unidades, frequency, primero, ultimo){
	var bodyHTML = '';
	for (var i = 0; i < unidades.length; i++) {
		bodyHTML += "<tr>";
		bodyHTML += "<td>"+unidades[i].id+"</td>";
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
   
    $('#tableUnidadesSelected tbody').append(bodyHTML);
    deleteElementTableUnidades("tableUnidadesSelected");
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
	var precio = sumarArray(getArrayValuesColumnTable("tableUnidadesSelected", 3));
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
			//var id = getValueFromTableSelected("contracts", 1);
            var dialogEditContract = modalEditContract(id);
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
    	$('#dialog-Edit-Contract').empty();
     }
	});
	return dialogo;
}

function calcularPack(){

	var value = parseFloat($("#porcentajePack").val());
	var valueQ = parseFloat($("#quantityPack").val());
	var precioInicial = parseFloat($("#unitPricePack").val());
	var precioFinal = parseFloat($("#finalPricePack").val());

	$("#porcentajePack").on('keyup change click', function () {
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
 function getUnidades(){
        showLoading('#tblUnidades',true);
        $.ajax({
            data:{
                property: $("#property").val(),
                unitType: $("#unitType").val(),
                season: $("#season").val(),
                interval: $("#interval").val(),
                view: $("#unitView").val()
            },
            type: "POST",
            url: "contract/getUnidades",
            dataType:'json',
            success: function(data){
				showLoading('#tblUnidades',false);
                if(data != null){
                    alertify.success("Found "+ data.length);
                    drawTable(data, 'add', "Details", "Unidades");
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
	var closingCost = sumarArray(getArrayValuesColumnTable("tableUnidadesSelected", 7));
	$("#downpaymentGastos").val(closingCost);
	var precioUnidad = $("#montoTotal").val();
	if (precioUnidad>0) {
		var precioUnidadPack = $("#downpaymentPrice").val(precioUnidad);
	}else{
		var precioUnidadPack = $("#downpaymentPrice").val(0);
	}
	calcularDepositDownpayment();
	selectMetodoPago();
	setDate("datePayDawnpayment");
	
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
	var downpayment = $("#downpaymentTotal").val();
	var deposit = $("#depositoEnganche").val();
	$("#montoDownpaymentPrg").val(0);
	$("#downpaymentProgramado").val(downpayment-deposit);
	selectMetodoPagoProgramados();
	setDate("datePaymentPrg");

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
	console.table(data);
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


function getArrayValuesColumnTable(tabla, columna){
	var items=[];
	$('#'+tabla+' tbody tr td:nth-child('+columna+')').each( function(){
		if ($(this).text().replace(/\s+/g, " ")!="") {
			items.push( $(this).text().replace(/\s+/g, " "));
		}       
	});
	return items;
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
	console.log("Este es el ID "+ id);
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
			//getDatosContractAccounts(id);
			getAccounts( id, "account", "sale" );
			/*getAccounts( id, "account", "maintenance" );
			getAccounts( id, "account", "loan" );*/
			break;
		case "tab-CVendors":
			getDatosContractSellers(id);
			break;
		case "tab-CProvisions":
			getDatosContractProvisions(id);
			break;
		case "tab-COccupation":
			getDatosContractOcupation(id);
			break;
		case "tab-CDocuments":
			getDatosContractDocuments(id);
			break;
		case "tab-CNotes":
			getDatosContractNotes(id);
			var heightNote = $('#tab-CNotes').height();
			$('#fieldsetNoteCon').height( heightNote + "px" );
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
	console.log("Documentos " + id);
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
	$("#btnNextStatus").click(function(){
		nextStatusContract();
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
	    	drawTableSinHead(data, "tableUnidadesContract");
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function drawTableSinHead(data, table){
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
	    	drawTableSinHead(data["peoples"], "peoplesContract");
	    	drawTableSinHead(data["unities"], "tableUnidadesContract");
	    	drawTerminosVenta(data["terminosVenta"][0]);
	    	drawTerminoFinanciamiento(data["terminosFinanciamiento"][0]);
			var contraTemp = data["contract"][0];
			$('td.folioAccount').text(contraTemp.Folio);
			setHeightModal('dialog-Edit-Contract');
			addFunctionality();
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
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
	var id = getValueFromTableSelected("contracts", 1);
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
			console.log(data);
			if(typeInfo == "account"){
				var sale = data["sale"];
				var maintenance = data["maintenance"];
				var loan = data["loan"];
				var acc = data["acc"];
				if( sale.length > 0 ){
					drawTable2( sale, "tableAccountSeller", false, "" );
					setTableAccount( sale, "tableSaleAccRes" );
				}
				if( maintenance.length > 0 ){
					drawTable2( maintenance, "tableAccountMaintenance", false, "" );
					setTableAccount( maintenance, "tableMainteAccRes" );
				}
				if( loan.length > 0 ){
					drawTable2( loan, "tableAccountLoan", false, "" );
					setTableAccount( loan, "tableLoanAccRes" );
				}
				for( i=0; i<acc.length; i++ ){
					var nameSafe = acc[i].accType;
					$('#btNewTransAcc').data( 'idAcc' + nameSafe, acc[i].fkAccId );	
				}
				//console.log( $('#btNewTransAcc').data() );
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

function setTableAccount(items, table){
	//console.log(items)
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

function drawTerminosVenta(data){
	var price = parseFloat(data.ListPrice);
	var semanas = data.WeeksNumber;
	var packReference = parseFloat(data.PackPrice);
	var salePrice = parseFloat(data.NetSalePrice);
	var enganche = parseFloat(data.Deposit);
	var transferido = parseFloat(data.TransferAmt);
	var costoContract = parseFloat(data.ClosingFeeAmt);
	var packAmount = parseFloat(data.PackPrice);
	var balanceFinal = parseFloat(data.BalanceActual);


	$("#cventaPrice").text(price.toFixed(2));
	$("#cventaWeeks").text(semanas);
	$("#cventaPackR").text(packReference.toFixed(2));
	$("#cventaSalePrice").text(salePrice.toFixed(2));
	$("#cventaHitch").text(enganche.toFixed(2));
	$("#cventaTransferA").text(transferido.toFixed(2));
	$("#cventaCostContract").text(costoContract.toFixed(2));
	$("#cventapackAmount").text(packAmount.toFixed(2));
	$("#cventaFinanced").text(balanceFinal.toFixed(2));
	$("#cventaAmountTransfer").text(enganche + transferido);
}

function drawTerminoFinanciamiento(data){
	var balanceFinal  = parseFloat(data.FinanceBalance);
	var pagoMensual = parseFloat(data.MonthlyPmtAmt);
	var porEnganche = parseFloat(data.porcentaje);
	var balanceFinal = parseFloat(data.TotalFinanceAmt);

	$("#cfbalanceFinanced").text(balanceFinal);
	$("#cfPagoMensual").text(pagoMensual);
	$("#cfEnganche").text(porEnganche);
	$("#typeFinance").text(data.FactorDesc);
	$("#totalFounding").text(balanceFinal);
	$("#totalMonthlyPayment").text(pagoMensual);

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
		width: "75%",
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
    var pagoMensual = getArrayValuesColumnTable("tablePagosSelected", 3);
	$.ajax({
	    data:{
	        idContrato: id,
	        factor:factor,
	        pagoMensual: pagoMensual[0]
	    },
	    type: "POST",
	    url: "contract/updateFinanciamiento",
	    dataType:'json',
	    success: function(data){
	    	alertify.success(data['mensaje']);
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function initEventosFinanciamiento(){

	setDate("fechaPrimerPagoF");
	var palabras = $("#terminosFinanciamientoF option:selected").text();
		palabras = palabras.split(",");
		$("#numeroMesesF").text(palabras[0]);
		$("#tasaInteresF").text(palabras[1]);

	$("#btnCalcularF").click(function(){
		var pagoTotal = getNumberTextString("balanceFinanciarF");
		var meses = parseFloat($("#numeroMesesF").text().split(" ")[0]);
		var interes = parseFloat($("#tasaInteresF").text().split("%")[0]);
		var pagoMensual = parseFloat(pagoTotal / meses);
		var pagoMensual = parseFloat(pagoMensual.toFixed(2)) + (interes * 10);

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
	var div = "#tableCOccupationSelectedbody";
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
	    	drawTableIdOcupacion(data,"tableCOccupationSelectedbody");
	    	//selectTable("tableCOccupationSelectedbody");
	    },
	    error: function(){
	        alertify.error("Try again");
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
    	//$('#dialog-Sellers').empty();
     }
	});
	return dialogo;
}
function modalGetAllNotes() {
	var id = getValueFromTableSelected("contracts", 1);
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

function SaveNote(){
	var noteType = $("#notesTypes").val();
	var noteDescription = $("#NoteDescription").val();
}

function SaveNotesContract(){
	var id = getValueFromTableSelected("contracts", 1);
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
	    	console.table(data);
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
	var id = getValueFromTableSelected("contracts", 1);
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
	    	//deleteSelectFlag("flagsAsignedBody");
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}


function drawTableFlagsAsigned(data, table){
	console.table(data);
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
function drawTableFlagsAsignedFlags(data){
	alertify.success(data['mensaje']);
	//drawTableFlagsAsigned(data['banderas'],"flagsAsignedBody");
}

function deleteSelectFlag(div){
	$("#"+div).on("click", "tr", function(){
		var id = $(this).find('td').eq(1).text();
        $(this).closest("tr").remove();
        deleteFlag(id);
	});
}

function deleteFlag(id){
	var idContrat = getValueFromTableSelected("contracts", 1);
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

function nextStatusContract(){
	deactiveEventClick("btnNextStatus");
	$("#iNextStatus").addClass("fa-spin");
	var id = getValueFromTableSelected("contracts", 1);
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
					nextStatusContract();
				});
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
					//initEventosSellers();
					$( "#dueDateAcc" ).Zebra_DatePicker({
						format: 'm/d/Y',
						show_icon: false,
					});
					$("#slcTransTypeAcc").attr('disabled', true);
					setDataOpcionAccount(attrType);
					getTrxType('contract/getTrxType', attrType, 'try again', generalSelects, 'slcTransTypeAcc');
					ajaxSelects('contract/getTrxClass', 'try again', generalSelects, 'slcTrxClassAcc');
				});
			}else{
				showLoading(div, true);
				$("#slcTransTypeAcc").attr('disabled', true);
				getTrxType('contract/getTrxType', attrType, 'try again', generalSelects, 'slcTransTypeAcc');
				setDataOpcionAccount(attrType);
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
    	//$('#dialog-ScheduledPayments').empty();
     }
	});
	return dialogo;
}

function setDataOpcionAccount(attrType){
	if(attrType == "newTransAcc"){
		$('#grpTrxClassAcc').show();
		$('#grpTablePayAcc').hide();
	}else{
		var trxType = $('#tab-CAccounts .tabsModal .tabs .active').attr('attr-accType');
		getAccounts( $('#btNewTransAcc').data( 'idRes' ), "payment", trxType );
		$('#grpTrxClassAcc').hide();
		$('#grpTablePayAcc').show();
	}
	var accCode = $('#tab-CAccounts .tabsModal .tabs .active').attr('attr-accCode');
	var idAccColl = $('#btNewTransAcc').data( 'idAcc' + accCode );
	$('#accountIdAcc').text( idAccColl );
	$('#dueDateAcc').val(getCurrentDate());
	$('#legalNameAcc').text($('#editContractTitle').text());
	$('#balanceAcc').text($('.balanceAccount').text());
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
	var accCode = $('#tab-CAccounts .tabsModal .tabs .active').attr('attr-accCode');
	var idAccCon = $('#btNewTransAcc').data( 'idAcc' + accCode );
	//console.log($('#btNewTransAcc').data( 'idRes' ));
	showAlert(true,"Saving changes, please wait ....",'progressbar');
	$.ajax({
		data: {
			attrType:attrType,
			accId:idAccCon,
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
		url: 'contract/saveTransactionAcc'
	}).done(function( data, textStatus, jqXHR ) {
		console.log(data);
		if( data.success ){
			//alert("guardeishion");
			//getDatailByID("contractstbody");
			getAccounts( $('#btNewTransAcc').data( 'idRes' ), "account", "" );
			$("#dialog-accounts").dialog('close');
			showAlert(false,"Saving changes, please wait ....",'progressbar');
		}else{
			$("#dialog-accounts").dialog('close');
			showAlert(false,"Saving changes, please wait ....",'progressbar');
			//alert("no transacenshion");
		}
	}).fail(function( jqXHR, textStatus, errorThrown ) {
		//alert("no guardeishion");
		//$("#dialog-accounts").dialog('close');
		showAlert(false,"Saving changes, please wait ....",'progressbar');
		alertify.error("Try Again");
	});
}

function getTrxType(url, attrType, errorMsj, funcion, divSelect){
	var trxType = $('#tab-CAccounts .tabsModal .tabs .active').attr('attr-accType');
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
	
	showAlert(true,"Saving changes, please wait ....",'progressbar');
	
	var id = getValueFromTableSelected("contracts", 1);
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
			showAlert(false,"Saving changes, please wait ....",'progressbar');
		} else { 
			getFiles(id);
			alertify.error("Try again");
			var div = "#dialog-newFile";
			$(div).dialog('close');
			showAlert(false,"Saving changes, please wait ....",'progressbar');
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
				drawTable2(data, "tableCFilesSelected", "deleteFile", "eliminar");
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
					var id = getValueFromTableSelected("contracts", 1);
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
		width: "75%",
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
					createNewContract();
					$(this).dialog('close');
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
	console.log(rango);
	var bodyHTML = '';
	for (var i = 0; i < data.length; i++) {
        	for(var j = 0; j <= rango; j++){
        		var year = primero + j;
        		bodyHTML += "<tr>";
        		bodyHTML+="<td>" + "week ocupancy"+ "</td>";
        		bodyHTML+="<td>" + year + "</td>";
        		bodyHTML+="<td>" + data[i].Intv + "</td>";
        		bodyHTML+="</tr>";
        	} 	
        }
    $('#' + table).html(bodyHTML);
    selectTableUnico("tableCOccupationSelectedbody");

	$("#"+"tableCOccupationSelected").on("click", "tr", function(){
    	var year = $(this).find("td").eq(1).text().trim();
    	var week = $(this).find("td").eq(2).text().trim();
    	console.log(year);
    	console.log(week);
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

	tablaPersonas(personas);
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

	console.table(unidades);
	tablUnidadades(unidades, frequency, primero, ultimo);	
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

function table(datos){
	console.table(datos['balance']);
	console.log(datos['balance'].financeBalance);
	if (datos['balance'].financeBalance >0) {
		console.log("lo voy a mostrar");
	}else{
		console.log("no lo muestro");
	}
	console.table(datos);
}