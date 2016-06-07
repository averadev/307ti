$(document).ready(function(){
	maxHeight = screen.height * .25;
	maxHeight = screen.height - maxHeight;
	var addContract = null;
    var unidadDialog = addUnidadDialog();
    var peopleDialog = addPeopleDialog();
	var dialogWeeks = getWeeksDialog();
	var dialogPack = PackReference();
	var dialogEnganche = modalDepositDownpayment();
	var dialogScheduledPayments = modalScheduledPayments();
	var dialogDiscountAmount = modalDiscountAmount();
	var dialogEditContract = modalEditContract();
	var dialogAddTour = addTourContract();

	$(document).on( 'click', '#newContract', function () {
		addContract = createDialogContract(addContract);
		addContract.dialog("open");
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

	$(document).on( 'click', '#btnAddTourID', function () {
		var dialogAddTour = addTourContract();
		dialogAddTour.dialog("open");
	});
	$(document).on( 'click', '#btnDeleteTourID', function () {
		$('#TourID').val('0');
	});
	$(document).on( 'click', '#btnAddmontoDownpaymentPrg', function () {
		if($("#montoDownpaymentPrg").val()>0){
			tableDownpaymentSelectedPrg();
			totalDownpaymentPrg();
		}
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

	$(document).on( 'change', '#downpayment', function () {
		$("#montoTotal").val($(this).val());
		var monto = $("#montoTotal").val();
		cambiarCantidadP(monto);
	});
	$(document).on( 'change', "input[name='engancheR']:checked", function () {
		var monto = $("#downpayment").val();
		cambiarCantidadP(monto);
	});
	$(document).on('change', "#precioVenta", function () {
		updateBalanceFinal();
	});
	$(document).on('change', "#amountTransfer", function () {
		var balanceFinal = $("#financeBalance").val();
		var transferido = $("#amountTransfer").val();
		$("#financeBalance").val(balanceFinal - transferido);
	});

	getDatailByID("contractstbody");
});

function updateBalanceFinal(){
	var precioVenta = $("#precioVenta").val();
	var enganche = $("#montoTotal").val();
	var balanceFinal = $("#financeBalance").val(precioVenta - enganche);
}
	
function cambiarCantidadP(monto){
	var seleccionado = $("input[name='engancheR']:checked").val();
	var precioVenta = $("#precioVenta").val();
	if (seleccionado == 'porcentaje') {
		var porcentaje = precioVenta * (monto/100);
		$("#montoTotal").val(porcentaje);
	}else{
		$("#montoTotal").val(monto);
	}
	updateBalanceFinal();
}


function createDialogContract(addContract) {
	var div = "#dialog-Contract";
	if (addContract!=null) {
	    	addContract.dialog( "destroy" );
	    }
	
	dialog = $(div).dialog({
		open : function (event){
			// if ($(div).is(':empty')) {
				showLoading(div,true);
				$(this).load ("contract/modal" , function(){
		    		showLoading(div,false);
		 			ajaxSelects('contract/getLanguages','try again', generalSelects, 'selectLanguage');
					ajaxSelects('contract/getSaleTypes','try again', generalSelects, 'typeSales');
	    		});
			// }else{
			// 	$(this).dialog('open');
			// }
	    	
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
					createNewContract();
					$(this).dialog('close');
					alertify.success("Se guardo correctamente");
				
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
			$('#dialog-Contract').empty();
			// $('#dialog-ScheduledPayments').empty();
			// $('#dialog-tourID').empty();
			// $('#dialog-People').empty();
			// $('#dialog-Unidades').empty();
		}
	});
	
	return dialog;
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
       			var tourID = getValueFromTableSelected("tours", 1);
       			$("#TourID").val(tourID);
       			$(this).dialog('close');
       		}
     	}],
     close: function() {
    	//$('#dialog-tourID').empty();
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
		    		ajaxSelects('contract/getProperties','try again', generalSelects, 'property');
	    			ajaxSelects('contract/getUnitTypes','try again', generalSelects, 'unitType');
	    			ajaxSelects('contract/getFrequencies','try again', generalSelects, 'frequency');
	    			ajaxSelects('contract/getSeasons','try again', generalSelects, 'season');
					$('#btngetUnidades').click(function(){
					        getUnidades();
					});
		            selectTableUnico("tblUnidades");
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
				var unidades = selectAllUnities();
				if (unidades.length>0) {
					$(this).dialog('close');
					var dialogWeeks = getWeeksDialog(unidades);
					dialogWeeks.dialog("open");
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
			if(data != null){
				alertify.success("Found "+ data.length);
				drawTable3(data, "details", "contracts");
			}else{
				$('#contractstbody').empty();
				alertify.error("No data found");
				var img = '<div class="divNoResults"><div class="noResultsScreen"><img src="http://localhost/307ti/assets/img/common/SIN RESULTADOS-01.png"> <label> Oh no! No Results. Try again. </label></div></div>';
				$('#contractstbody').html(img);
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

function saveContract() {
	console.log("ok esto es genial");
}

function createNewContract(){
	
	var id = "saveDataContract";
	var arrayWords = ["legalName", "TourID", "depositoEnganche", "precioUnidad", "precioVenta"];
	var form = $("#"+id);
	var elem = new Foundation.Abide(form, {});

	if(!verifyInputsByID(arrayWords)){
		$('#'+id).foundation('validateForm');
		alertify.success("Please fill required fields (red)");
		return false;
	}else{
		var personas = getValueTableUnidades();
		var unidades = getValueTablePersonas();
		if (personas.length<=0) {
			alertify.error("Debes de agregar al menos una persona");
		}else if (unidades.length<=0) {
			alertify.error("Debes de agregar al menos una persona");
		}else{
			showAlert(true,"Saving changes, please wait ....",'progressbar');
			$.ajax({
					data: {
						legalName : $("#legalName").val().trim(),
						tourID : $("#TourID").val().trim(),
						idiomaID : $("#selectLanguage").val(),
						peoples: getValueTablePersonas(),
						types: typePeople(),
						unidades: getValueTableUnidades(),
						weeks: $("#weeksNumber").val().trim(),
						firstYear :$("#firstYearWeeks").val().trim(),
						lastYear : $("#lastYearWeeks").val().trim(),
						tipoVentaId : $("#typeSales").val(),
						listPrice: $("#precioUnidad").val(),
						salePrice: $("#precioVenta").val(),
						specialDiscount:$("#totalDiscountPacks").val(),
						downpayment:$("#downpayment").val(),
						amountTransfer:$("#amountTransfer").val(),

						packPrice:sumarArray(getArrayValuesColumnTable("tableDescuentos", 2)),
						financeBalance: $("#financeBalance").val(),
						tablapagos: getValueTableDownpayment(),
						tablaPagosProgramados:getValueTableDownpaymentScheduled(),
						tablaPacks: getValueTablePacks(),

						viewId: 1,
						floorPlanId: 1,
						SeassonId: 10,
						FrequencyId: 2,
						contratoRelacionadoId : 0,
						fkAccId: 10,
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
					if (data== 1) {
						elem.resetForm();
						showAlert(false,"Saving changes, please wait ....",'progressbar');
						var arrayWords = ["legalName", "TourID", "depositoEnganche", "precioUnidad", "precioVenta", "downpayment"];
						clearInputsById(arrayWords);
						var fin = modalFinanciamiento();
						fin.dialog("show");
						$('#dialog-Weeks').empty();
						$('#tablePeopleSelected tbody').empty();
						$('#tableUnidadesSelected tbody').empty();
						alertify.success("Contract Save");
					}
					
				})
				.fail(function( jqXHR, textStatus, errorThrown ) {
					//alertify.error("Ocurrio un error vuelve a intentarlo");
				});
		}
	}
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
			pack.amount = $(this).find('td').eq(1).text()
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
			unidad.frequency = $(this).find('td').eq(3).text(),
			unidad.season = $(this).find('td').eq(4).text(),
			unidad.week = $(this).find('td').eq(5).text()
			unidades.push(unidad); 
		}
	});
	return unidades;
}
function getValueTablePersonas(){
	var tabla = "tablePeopleSelected";
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
	console.log(value);
  return array.indexOf(value) > -1;
}
function selectAllUnities(){
	var unidades = [];

	var array = $("#tblUnidades .yellow");
	for (var i = 0; i < array.length; i++) {
		var fullArray = $(array[i]).find("td");
		unidad = [
			fullArray.eq(1).text(),
			fullArray.eq(2).text(),
			// fullArray.eq(2).attr("idfloorplan"),
			fullArray.eq(3).text(),
			fullArray.eq(4).text(),
			fullArray.eq(5).text()
		];
		unidades.push(unidad);
	}
	if (unidades.length <= 0) {
		alertify.error("Search and click over for choose one");
		return unidades;
	}else{
		return unidades;
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
        bodyHTML += "<td><div class='rdoField'><input type='radio' name='primario'><label for='folio'>&nbsp;</label></div></td>";
        bodyHTML += "<td><div class='rdoField'><input type='radio' name='secundario'><label for='folio'>&nbsp;</label></div></td>";
        bodyHTML += "<td><div class='rdoField'><input type='radio' name='beneficiario'><label for='folio'>&nbsp;</label></div></td>";
        bodyHTML += "<td><button type='button' class='alert button'><i class='fa fa-minus-circle fa-lg' aria-hidden='true'></i></button></td>";
        bodyHTML+="</tr>";
    }
    $('#tablePeopleSelected tbody').append(bodyHTML);
    deleteElementTable("tablePeopleSelected");
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
	    		$("#weeksNumber").val(1);
	    		setYear("firstYearWeeks", 0);
	    		setYear("lastYearWeeks", 25);
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
       			var weeks = $("#weeksNumber").val();
       			var primero = $("#firstYearWeeks").val();
       			var ultimo = $("#lastYearWeeks").val();
       			tablUnidadades(unidades, weeks, primero, ultimo);	
       			$(this).dialog('close');
       			setValueUnitPrice();
       		}
     	}],
     close: function() {
    	//$('#dialog-Weeks').empty();
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
       		text: "ok",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			$("#precioVenta").val($("#finalPricePack").val());
       			$("#packReference").val($("#quantityPack").val());
       			$(this).dialog('close');
       		}
     	}],
     close: function() {
    	//$('#dialog-Pack').empty();
     }
	});
	return dialogo;
}
function modalDepositDownpayment(){
	showLoading('#dialog-Downpayment', true);
	dialogo = $("#dialog-Downpayment").dialog ({
  		open : function (event){
	    	$(this).load ("contract/modalDepositDownpayment" , function(){
	    		showLoading('#dialog-Downpayment', false);
	    		initEventosDownpayment();
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
       				$("#depositoEnganche").val(deposito);
       				$(this).dialog('close');	
       			}
       			
       		}
     	}],
     close: function() {
    	//$('#dialog-Downpayment').empty();
     }
	});
	return dialogo;
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
				initEventosDownpaymentProgramados();
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
    	//$('#dialog-ScheduledPayments').empty();
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

function tablUnidadades(unidades, weeks, primero, ultimo){
	var weeks = parseInt(weeks);
	var bodyHTML = '';
	for (var k = 1; k<weeks+1; k++) {
		 for (var i = 0; i < unidades.length; i++) {
        bodyHTML += "<tr>";
        for (var j in unidades[i]) {
        	bodyHTML+="<td>" + unidades[i][j] + "</td>";
        }
        bodyHTML += "<td>"+k+"</td>";
        bodyHTML += "<td>"+primero+"</td>";
        bodyHTML += "<td>"+ultimo+"</td>";
        bodyHTML += "<td><button type='button' class='alert button'><i class='fa fa-minus-circle fa-lg' aria-hidden='true'></i></button></td>";
        bodyHTML+="</tr>";
    }
	}
   
    $('#tableUnidadesSelected tbody').html(bodyHTML);
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
	var precio = parseFloat(getValueFromTable("tableUnidadesSelected", 2));
	precio.toFixed(2);
	var multiplicador = $("#tableUnidadesSelected").find("tr").length - 1;
	//var precioUnida = "$"+number_format(precio.toFixed(2) * multiplicador, 2);
	var precioUnida = precio.toFixed(2) * multiplicador;
	$("#precioUnidad").val(precioUnida);
	$("#precioVenta").val(precioUnida);
}


function getDatailByID(id){
	var pickedup;
	$("#"+id).on("click", "tr", function(){
		if (pickedup != null) {
        	pickedup.removeClass("yellow");
			var id = $(this).find("td").eq(1).text().trim();
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
	    	$(this).load ("contract/modalEdit" , function(){
	 			showLoading('#dialog-Edit-Contract',false);
	 			getDatosContract(id);
	 			setEventosEditarContrato(id);
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
  		if(this.value == 2){
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
                frequency: $("#frequency").val(),
                season: $("#season").val(),
                interval: $("#interval").val()
            },
            type: "POST",
            url: "contract/getUnidades",
            dataType:'json',
            success: function(data){
                if(data != null){
                    showLoading('#tblUnidades',false);
                    alertify.success("Found "+ data.length);
                    drawTable(data, 'add', "details", "Unidades");
                }else{
                    $('#contractstbody').empty();
                    alertify.error("No data found");
                    var img = '<div class="divNoResults"><div class="noResultsScreen"><img src="http://localhost/307ti/assets/img/common/SIN RESULTADOS-01.png"> <label> Oh no! No Results. Try again. </label></div></div>';
					$('#Unidadestbody').html(img);
                }
            },
            error: function(){
                alertify.error("Try again");
            }
        });
    }

function setDate(id){
	document.getElementById(id).valueAsDate = new Date();
}

function initEventosDownpayment(){
	var precioUnidad = $("#downpayment").val();
	if (precioUnidad>0) {
		var precioUnidadPack = $("#downpaymentPrice").val(precioUnidad);
	}else{
		var precioUnidadPack = $("#downpaymentPrice").val(0);
	}
	calcularDepositDownpayment();
	selectMetodoPago();
	setDate("datePayDawnpayment");
	
	$('#btnAddmontoDownpayment').click(function (){
		if($("#montoDownpayment").val()>0){
			tableDownpaymentSelected();
			totalDownpayment();
		}else{
			alertify.error("the amount should be greater to zero and minus than the amount total");
			errorInput("montoDownpayment", 2);
		}
	});
	$('#btnCleanmontoDownpayment').click(function (){
		$("#montoDownpayment").val(0);
	});
	
}

function initEventosDownpaymentProgramados(){
	var downpayment = $("#downpayment").val();
	$("#downpaymentProgramado").val(downpayment);
	selectMetodoPagoProgramados();
	setDate("datePaymentPrg");
	$('#btnCleanmontoDownpaymentPrg').click(function (){
		$("#montoDownpaymentPrg").val(0);
	});
}

function initEventosDiscount(){
	$("#btnAddmontoPack").click(function(){
		if ($("#montoPack").val()>0) {
			PacksAdds();
		}else{
			alertify.error("the amount should be greater to zero");
			errorInput("montoPack", 2);
		}
	});
}

function PacksAdds(){
	var td = "";
	var tipoPack = $("#tiposPakc option:selected").text();
	var monto = $("#montoPack").val();
		td = "<tr>";
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
	console.log(screen);
	console.log(id)
	$('#tabsContrats .tabs-title').removeClass('active');
	$('#tabsContrats li[attr-screen=' + screen + ']').addClass('active');
	//muestra la pantalla selecionada
	$('#tabsContrats .tab-modal').hide();
	$('#' + screen).show();
	switch(screen){
		case "tab-CGeneral":
			getDatosContract(id);
			break;
		case "tab-CAccounts":
			getDatosContractAccounts(id);
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
	console.log("Vendedores " + id);
}
function getDatosContractProvisions(id){
	console.log("Provisiones" + id);
}
function getDatosContractOcupation(id){
	console.log("Ocupacion " + id);
}
function getDatosContractDocuments(id){
	console.log("Documentos " + id);
}
function getDatosContractNotes(id){
	console.log("Notas " + id);
}
function getDatosContractFlags(id){
	console.log("Banderas " + id);
}
function getDatosContractFiles(id){
	console.log("Archivos " + id);
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
        bodyHTML += deleteButton;
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
	    	drawTableSinHead(data["peoples"], "peoplesContract");
	    	drawTableSinHead(data["unities"], "tableUnidadesContract");
	    	drawDataContract(data["contract"][0]);
	    	drawTerminosVenta(data["terminosVenta"][0]);
	    	drawTerminoFinanciamiento(data["terminosFinanciamiento"][0]);
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function drawTerminosVenta(data){
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

function drawTerminoFinanciamiento(data){
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
	// $('#tabsContrats .tabs-title').on('click', function() { 
	// 	changeTabsModalContract($(this).attr('attr-screen'), id);
	// });
}



function modalFinanciamiento() {
	var div = "#dialog-Financiamiento";
	dialogo = $(div).dialog ({
  		open : function (event){
  				showLoading(div, true);
				$(this).load ("contract/modalFinanciamiento" , function(){
					showLoading(div, false);
					initEventosFinanciamiento();
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
    
       		}
     	}],
     close: function() {
    	//$('#dialog-ScheduledPayments').empty();
     }
	});
	return dialogo;
}


function initEventosFinanciamiento(){
	$("#btnCalcularF").click(function(){
		var palabras = $("#terminosFinanciamientoF option:selected").text();
		palabras = palabras.split(",");
		console.log(palabras[0]);
		console.log(palabras[1]);

	});
}


//$("#terminosFinanciamientoF option:selected").attr('code')
//var palabras = $("#terminosFinanciamientoF option:selected").text()
//palabras[0] = "52 Meses";
//palabras[1] = ""