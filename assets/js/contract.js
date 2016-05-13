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

	getDatailByID("contractstbody");
});
	
function createDialogContract(addContract) {

	if (addContract!=null) {
	    	addContract.dialog( "destroy" );
	    }
	showLoading('#dialog-Contract',true);
	dialog = $("#dialog-Contract").dialog({
		open : function (event){
	    	$(this).load ("contract/modal" , function(){
	    		showLoading('#dialog-Contract',false);
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
	showLoading('#dialog-tourID',true);
	var unidades = unidades;
	dialogo = $("#dialog-tourID").dialog ({
  		open : function (event){
	    	$(this).load ("tours/index" , function(){
	    		showLoading('#dialog-tourID',false);
	    		selectTableUnico("tours");
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
       		text: "ok",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			var tourID = getValueFromTableSelected("tours", 1);
       			$("#TourID").val(tourID);
       			$(this).dialog('close');
       		}
     	}],
     close: function() {
    	$('#dialog-tourID').empty();
     }
	});
	return dialogo;
}
function addUnidadDialog() {
	showLoading('#dialog-Unidades',true);
	dialog = $( "#dialog-Unidades" ).dialog({
		open : function (event){
	    	$(this).load ("contract/modalUnidades" , function(){
	    		showLoading('#dialog-Unidades',false);
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
				$(this).dialog('close');
				var dialogWeeks = getWeeksDialog(unidades);
				dialogWeeks.dialog("open");
				// tablUnidadades(unidades);
				// if(selectAllUnities()){
				// 	$(this).dialog('close');
				// 	//addUnidadDialogYears.dialog("open");
				// };
			}
		}],
		close: function() {
			$('#dialog-Unidades').empty();
		}
	});
	return dialog;
}
function addPeopleDialog() {

	showLoading('#dialog-People', true);
	dialog = $( "#dialog-People" ).dialog({
		open : function (event){
	    	$(this).load ("people/index" , function(){
	    		showLoading('#dialog-People', false);
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
				};
			}
		}],
		close: function() {
			$('#dialog-People').empty();
		}
	});
	return dialog;
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
				FrequencyId: 2,
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
		var fullArray = $(array[i]).find("td");
		persona = [
			fullArray.eq(1).text().replace(/\s+/g, " "),
			fullArray.eq(2).text().replace(/\s+/g, " "),
			fullArray.eq(3).text().replace(/\s+/g, " "),
			fullArray.eq(9).text().replace(/\s+/g, " ")
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
function selectAllUnities(){
	var unidades = [];

	var array = $("#tblUnidades .yellow");
	for (var i = 0; i < array.length; i++) {
		var fullArray = $(array[i]).find("td");
		unidad = [
			fullArray.eq(1).text().replace(/\s+/g, " "),
			fullArray.eq(2).text().replace(/\s+/g, " "),
			fullArray.eq(3).text().replace(/\s+/g, " "),
			fullArray.eq(4).text().replace(/\s+/g, " "),
			fullArray.eq(5).text().replace(/\s+/g, " ")
		];
		unidades.push(unidad);
	}
	if (unidades.length <= 0) {
		alertify.error("Click over for choose one");
		//return false;
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
        bodyHTML += "<td><div class='rdoField'><input  type='checkbox' name='principal'></div></td>";
        bodyHTML += "<td><input  type='checkbox' name='secundaria'></td>";
        bodyHTML += "<td><input  type='checkbox' name='baneficiario'></td>";
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
	    		setYear("lastYearWeeks", 1);
	    	});
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
    	$('#dialog-Weeks').empty();
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
       			$("#precioVenta").val($("#finalPricePack").val());
       			$(this).dialog('close');
       		}
     	}],
     close: function() {
    	$('#dialog-Pack').empty();
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

       		}
     	}],
     close: function() {
    	$('#dialog-Downpayment').empty();
     }
	});
	return dialogo;
}
function modalScheduledPayments(){
	showLoading('#dialog-ScheduledPayments', true);
	dialogo = $("#dialog-ScheduledPayments").dialog ({
  		open : function (event){
	    	$(this).load ("contract/ScheduledPayments" , function(){
	 			showLoading('#dialog-ScheduledPayments', false);
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

       		}
     	}],
     close: function() {
    	$('#dialog-ScheduledPayments').empty();
     }
	});
	return dialogo;
}
function modalDiscountAmount(){
	showLoading('#dialog-DiscountAmount', true);
	dialogo = $("#dialog-DiscountAmount").dialog ({
  		open : function (event){
	    	$(this).load ("contract/modalDiscountAmount" , function(){
	 			showLoading('#dialog-DiscountAmount', false);
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

       		}
     	}],
     close: function() {
    	$('#dialog-DiscountAmount').empty();
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
        };
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
	$("#precioUnidad").val(precio.toFixed(2) * multiplicador);
	$("#precioVenta").val(precio.toFixed(2) * multiplicador);
}


function getDatailByID(id){
	var pickedup;
	$("#"+id).on("click", "tr", function(){
		if (pickedup != null) {
        	pickedup.removeClass("yellow");
			var id = $(this).find("td").eq(1).text().trim();
			console.log(id);
            var dialogEditContract = modalEditContract();
            dialogEditContract.dialog("open");
          }
          $( this ).addClass("yellow");
          pickedup = $(this);
	});
}

function modalEditContract(){

	showLoading('#dialog-Edit-Contract',true);
	dialogo = $("#dialog-Edit-Contract").dialog ({
  		open : function (event){
	    	$(this).load ("contract/modalEdit" , function(){
	 			showLoading('#dialog-Edit-Contract',false);	
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
// $(document).ready(function(){
//     $("#myTable td").click(function() {     
 
//         var column_num = parseInt( $(this).index() ) + 1;
//         var row_num = parseInt( $(this).parent().index() )+1;    
 
//         $("#result").html( "Row_num =" + row_num + "  ,  Rolumn_num ="+ column_num );   
//     });
// });

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


function selectMetodoPago(){
	$('#tiposPago').on('change', function() {
  		if(this.value == 2){
  			$("#datosTarjeta").show();
  		}else{
  			$("#datosTarjeta").hide();
  		}
  	});
}

 function getUnidades(){
        showLoading('#tblUnidades',true);
        $.ajax({
            data:{
                words: "1"
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
	setDate("datePayment");
	$("#montoDownpayment").val(0);
	$('#btnAddmontoDownpayment').click(function (){
		tableDownpaymentSelected();
	});
}

function tableDownpaymentSelected(){
	var tipoPago = $("#tiposPago option:selected").text();
	var fecha = $("#datePayment").val();
	var monto = $("#montoDownpayment").val();
	var td = "<tr>";
		td += "<td>"+fecha+"</td>";
		td += "<td>"+tipoPago+"</td>";
		td += "<td>"+monto+"</td>";
		td += "<td><button type='button' class='alert button'><i class='fa fa-minus-circle fa-lg' aria-hidden='true'></i></button></td>";
		td += "</tr>";
	$("#tbodyPagosSelected").append(td);
}