/**
* @fileoverview Funciones del screen inventory (alta/editar/busqueda)
*
* @author Alfredo Chi
* @version 0.1
*/

var maxHeight = 400;
var xhrInventary = null;

/**************Index****************/

//busqueda Detailed Availability
$('#btnInvSearch').off();
$('#btnInvSearch').on('click', function() {  searchInventary(0); });
//busqueda de usuarios mediante enter
$('#textInvStartDate').keyup(function(e){
    if(e.keyCode ==13){
		searchInventary(0);	
    }
});
//limpia el campo busqueda Detailed Availability
$('#btnInvCleanSearch').off();
$('#btnInvCleanSearch').on('click', function() { CleandFilterInventary(); });

$('.comboBoxInvDetailed').change(function(){ disableOtherCombo(this)});

//seleciona el tipo de busqueda de inventario
$('.RadioSearchInventary').on('click',function(){ choseTypeSearchInv(this); });


/************Funciones**************/

/**
* Carga las opciones que se inicializan cuando entran a la pagina
*/
$(document).ready(function() {
	//alertify.success("Found "+ 50);
	$( "#textInvStartDate" ).Zebra_DatePicker({
		format: 'm/d/Y',
		show_icon: false,
	});
	
	$('#textInvStartDate').val(getCurrentDate())
});

/**
* Hace la busqueda de inventario
* @param page numero del paginador
*/
function searchInventary(page){
	
	var result = validateFieldInventary()
	
	if(result){
	
		if( xhrInventary && xhrInventary.readyState != 4 ){
			xhrInventary.abort();
			xhrInventary = null;
			showLoading('#divTableInvDetailed',false);
		}
	
		var url = "";
		if($("#RadioDetailedAvailability").is(':checked')){
			url = "inventory/getInvDetailedAvailability";
		}else if($("#RadioRoomsControl").is(':checked')){
			url = "inventory/getInvRoomsControl";
		}
	
		showLoading('#divTableInvDetailed',true);
		
		xhrInventary = $.ajax({
			type: "POST",
			url: url,
			dataType:'json',
			data:{
				date:$("#textInvStartDate").val().trim(),
				floorPlan:$("#textInvFloorPlan").val(),
				property:$("#textInvProperty").val(),
				availability:$('.RadioSearchInv:checked').val(),
				nonDeducted: $('#CheckInvNonDeducted').is(":checked"),
				Overbooking: $('#CheckInvOverbooking').is(":checked"),
				OOO: $('#CheckInvOOO').is(":checked"),
				page:page,
			},
			success: function(data){
				drawTable2(data.items,"tableInvDetailed",false,"tabla");
				showLoading('#divTableInvDetailed',false);
				$('#tableInvDetailed').show();
			},
			error: function(error){
				if(error.statusText != "abort"){
					showLoading('#divTableInvDetailed',false);
					alertify.error(error.statusText);
					noResults('#divTableInvDetailed',true);
					if ( $.fn.dataTable.isDataTable( '#tableInvDetailed' ) ) {
						var tabla = $( '#tableInvDetailed' ).DataTable();
						tabla.destroy();
					}
					$('#tableInvDetailed').hide();
					//showAlert(true,"$('#tableInvDetailed').hide();",'button',showAlert);
				}
			}
		});
	}else{
		$('#alertInventaryUnit').show(500)
	}
	
}

/**
* valida que este seleccionado una unidad
*/
function validateFieldInventary(){
	var resultc = true;
	$('#alertInventaryUnit').hide()
	if($('#RadioDetailedAvailability').is(":checked")){
		if($('#textInvFloorPlan').val() == 0 && $('#textInvProperty').val() == 0 ){
			console.log("entro")
			resultc = false;
		}
	}else{
		if($('#textInvProperty').val() == 0 ){
			console.log("tambien aqui")
			resultc = false;
		}
	}
	
	return resultc;
	
}

/**
* cambia la opcion de los combobox cuando se selecciona uno
*/
function disableOtherCombo( selector ){
	console.log("entro")
	var value = $(selector).val();
	$('.comboBoxInvDetailed').val(0);
	$(selector).val(value);
}

/**
* cambia el tipo de busquedad de inventario
*/
function choseTypeSearchInv(selector){
	if($(selector).attr('value') == "detailedAvailability"){
		$('.filterDetailedAvailability').show(500);
	}else if($(selector).attr('value') == "roomsControl"){
		$('.filterDetailedAvailability').hide(500);
	}
}

/**
* limpia los filtros de busqueda
*/
function CleandFilterInventary(){
	$('#textInvStartDate').val(getCurrentDate());
	$('.comboBoxInvDetailed ').val(0);
	$('.CheckSearchInv').attr('checked',false);
	$('#RadioDetailedAvailability').prop("checked", true);
	$('#RadioInvAvailability').prop("checked", true);
	$('.filterDetailedAvailability').show(500);
}

/**
* muestra el modal de personas
* @param id id de la persona
*/