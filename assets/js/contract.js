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
	var dialogAccount = opcionAccount();



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
		var dialogAccount = opcionAccount($(this).attr('attr_type'));
		dialogAccount.dialog("open");
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

	// var dialogEditContract = modalEditContract(224);
	// dialogEditContract.dialog("open");
	
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
			showLoading(div,true);
			$(this).load ("contract/modal" , function(){
		    	showLoading(div,false);
		 		ajaxSelects('contract/getLanguages','try again', generalSelects, 'selectLanguage');
				ajaxSelects('contract/getSaleTypes','try again', generalSelects, 'typeSales');
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
	    			//ajaxSelects('contract/getFrequencies','try again', generalSelects, 'frequency');
	    			ajaxSelects('contract/getSeasons','try again', generalSelects, 'season');
					$('#btngetUnidades').click(function(){
					        getUnidades();
					});
		            selectTable("tblUnidades");
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
			if(data){
				alertify.success("Found "+ data.length);
				drawTable3(data, "details", "contracts");
			}else{
				$('#contractstbody').empty();
				mensajeDatosVacios('contractstbody');
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
						weeks: getArrayValuesColumnTable("tableUnidadesSelected", 6),
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
					},
					type: "POST",
					dataType:'json',
					url: 'contract/saveContract'
				})
				.done(function( data, textStatus, jqXHR ) {
					showAlert(false,"Saving changes, please wait ....",'progressbar');
					if (data== 1) {
						elem.resetForm();
						var arrayWords = ["legalName", "TourID", "depositoEnganche", "precioUnidad", "precioVenta", "downpayment"];
						clearInputsById(arrayWords);
						 if (modalFin!=null) {
				    		modalFin.dialog( "destroy" );
				    	}
				    	modalFin = modalFinanciamiento();
				        modalFin.dialog( "open" );
						$('#dialog-Weeks').empty();
						$('#tablePeopleSelected tbody').empty();
						$('#tableUnidadesSelected tbody').empty();
						alertify.success("Contract Save");
					}
					
				})
				.fail(function( jqXHR, textStatus, errorThrown ) {
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
	    		ajaxSelects('contract/getFrequencies','try again', generalSelects, 'frequency');
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
       		text: "ok",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			var frequency = $("#frequency option:selected" ).text();
       			var primero = $("#firstYearWeeks").val();
       			var ultimo = $("#lastYearWeeks").val();
       			tablUnidadades(unidades, frequency, primero, ultimo);	
       			$(this).dialog('close');
       			setValueUnitPrice();
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
       		text: "ok",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			$("#precioVenta").val($("#finalPricePack").val());
       			$("#packReference").val($("#quantityPack").val());
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
                season: $("#season").val(),
                interval: $("#interval").val()
            },
            type: "POST",
            url: "contract/getUnidades",
            dataType:'json',
            success: function(data){
				showLoading('#tblUnidades',false);
                if(data != null){
                    alertify.success("Found "+ data.length);
                    drawTable(data, 'add', "details", "Unidades");
                }else{
                    $('#contractstbody').empty();
                    alertify.error("No data found");
                    mensajeDatosVacios("Unidadestbody");
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
	console.log(id);
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
			getAccounts( id, "account", "maintenance" );
			getAccounts( id, "account", "loan" );
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
	console.log("vendedores");
	
}
function getDatosContractProvisions(id){
	console.log("Provisiones" + id);
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
	console.log("Archivos " + id);
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
	    	//drawDataContract(data["contract"][0]);
	    	drawTerminosVenta(data["terminosVenta"][0]);
	    	drawTerminoFinanciamiento(data["terminosFinanciamiento"][0]);
			var contraTemp = data["contract"][0];
			$('td.folioAccount').text(contraTemp.Folio);
			setHeightModal('dialog-Edit-Contract');
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function getAccounts( id, typeInfo, typeAcc ){
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
			var sales = data["sales"];
			if(typeInfo == "account"){
				if(typeAcc == "sale"){
					drawTable2(sales, "tableAccountSeller", false, "");
				}else if(typeAcc == "maintenance"){
					drawTable2(sales, "tableAccountMaintenance", false, "");
				}else if(typeAcc == "loan"){
					drawTable2(sales, "tableAccountLoan", false, "");
				}
				
				setTableAccount(sales, "");
				$('#btNewTransAcc').data( 'idRes', id )
				$('#btNewTransAcc').data( 'idAcc', sales[0].AccID );
			}else{
				drawTable2(sales, "tabletPaymentAccoun", false, "");
				$(".checkPayAcc").off( 'change' );
				$(".checkPayAcc").on('change', function (){
					var amoutCur = 0;
					$("input[name='checkPayAcc[]']:checked").each(function(){
						amoutCur = amoutCur + parseFloat($(this).val());
					});
					$('#amountSettledAcc').text( '$ ' + amoutCur.toFixed(4) );
				});
			}
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function setTableAccount(items){
	var balance = 0, balanceDeposits = 0, balanceSales = 0, defeatedDeposits = 0, defeatedSales = 0;
	for(i=0;i<items.length;i++){
		var item = items[i];
		var tempTotal = 0, tempTotal2 = 0;
		if( item.Transaccion_Signo == 1 ){
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
	
	$('td.balanceAccount').text('$ ' + balance.toFixed(2));
	$('td.balanceDepAccount').text('$ ' + balanceDeposits.toFixed(2));
	$('td.balanceSaleAccount').text('$ ' + balanceSales.toFixed(2));
	$('td.defeatedDepAccount').text('$ ' + defeatedDeposits.toFixed(2));
	$('td.defeatedSaleAccount').text('$ ' + defeatedSales.toFixed(2));
	
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
	$('#tabsContrats .tabs-title').on('click', function() { 
		changeTabsModalContract($(this).attr('attr-screen'), id);
	});
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
    			alertify.success("Financiamiento guardado");
    			$(this).dialog('close');
	       
       		}
     	}],
     close: function() {
    	//$('#dialog-ScheduledPayments').empty();
     }
	});
	return dialogo;
}


function initEventosFinanciamiento(){
	setDate("fechaPrimerPagoF");
	var palabras = $("#terminosFinanciamientoF option:selected").text();
		palabras = palabras.split(",");
		$("#numeroMesesF").text(palabras[0]);
		$("#tasaInteresF").text(palabras[1]);

	$("#btnCalcularF").click(function(){
		var pagoTotal = parseFloat($("#balanceFinanciarF").text());
		var meses = parseFloat($("#numeroMesesF").text().split(" ")[0]);
		var interes = parseFloat($("#tasaInteresF").text().split("%")[0]);
		var pagoMensual = pagoTotal / meses;
		$("#pagoMF").text(pagoMensual);
		$("#CargoCF").text("8.95");
		var totalMensual = pagoMensual + 8.95;
		$("#totalPagarF").text(totalMensual);


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
					showLoading(div, false);
				});
		},
		autoOpen: false,
     	height: maxHeight/3,
     	width: "25%",
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
    			alertify.success("File added");
    			$(this).dialog('close');
	       
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
	    	drawTableId(data,"tableCOccupationSelectedbody");
	    	selectTable("tableCOccupationSelectedbody");
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
	    	console.table(data);
	    	if (data) {
	    		drawTableId(data,"tableFlagsListBody");
	    		selectTable("tableFlagsListBody");
	    	}else{
	    		mensajeDatosVacios("tableFlagsListBody");
	    	}
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}
function mensajeDatosVacios(div){
	var html = '<div class="divNoResults"><div class="noResultsScreen"><img src="' + BASE_URL + 'assets/img/common/SIN RESULTADOS-01.png' + '" /> <label> Oh no! No Results. Try again. </label></div></div>';
	$('#'+div).html(html);
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
	    		mensajeDatosVacios("tableCNotesSelectedBody");
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
	    		drawTableId(data,"flagsAsignedBody");
	    	}else{
	    		mensajeDatosVacios("flagsAsignedBody");
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
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
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
// function selectStatusContract(){
// 	$.ajax({
// 	    data:{
// 	        id: 2,
// 	    },
// 	    type: "POST",
// 	    url: "contract/getPropertyStatus",
// 	    dataType:'json',
// 	    success: function(data){
// 	    	$("#editContracStatus").text(data['propiedad']);
// 	    },
// 	    error: function(){
// 	        alertify.error("Try again");
// 	    }
// 	});
// }
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
				$("#slcTransTypeAcc").attr('disabled', true);
				getTrxType('contract/getTrxType', attrType, 'try again', generalSelects, 'slcTransTypeAcc');
				setDataOpcionAccount(attrType);
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
		getAccounts( $('#btNewTransAcc').data( 'idRes' ), "payment" );
		$('#grpTrxClassAcc').hide();
		$('#grpTablePayAcc').show();
	}
	$('#accountIdAcc').text( $('#btNewTransAcc').data( 'idAcc' ) );
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
	
	//console.log($('#btNewTransAcc').data( 'idRes' ));
	showAlert(true,"Saving changes, please wait ....",'progressbar');
	$.ajax({
		data: {
			attrType:attrType,
			accId:$('#btNewTransAcc').data( 'idAcc' ),
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
			getAccounts( $('#btNewTransAcc').data( 'idRes' ), "account" );
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
	$.ajax({
		type: "POST",
		data: {
			attrType:attrType
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