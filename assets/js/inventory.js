/**
* @fileoverview Funciones del screen inventory (alta/editar/busqueda)
*
* @author Alfredo Chi
* @version 0.1
*/

var maxHeight = 400;
isSearch = true;
var xhrPeople
var dataTableInventary = null;

/**************Index****************/

//busqueda Detailed Availability
$('#btnInvSearch').off();
$('#btnInvSearch').on('click', function() {  searchInvDetailed(0); });
//busqueda de usuarios mediante enter
/*$('#txtSearch').keyup(function(e){
    if(e.keyCode ==13){
		searchPeople(0);	
    }
});*/
//limpia el campo busqueda Detailed Availability
$('#btnCleanSearch').off();
$('#btnCleanSearch').on('click', function() {  CleandFieldSearch(); });

$('.comboBoxInvDetailed').change(function(){ disableOtherCombo(this)});

//seleciona el tipo de busqueda de inventario
$('.RadioSearchInventary').on('click',function(){ choseTypeSearchInv(this); });


/************Funciones**************/

/**
* Carga las opciones que se inicializan cuando entran a la pagina
*/
$(document).ready(function() {
	
	$('#textInvStartDate').fdatepicker({
		//format: 'mm-dd-yyyy',
		disableDblClickSelection: true,
	});
	
	/*$('#tableInvDetailed').DataTable({
					"scrollY": 350,
					"scrollX": true,
					"paging":   false,
					"ordering": false,
					"info":     false,
					"filter": 	false,
				});*/
	
	/**/
	
});

function searchInvDetailed(page){
	var url = "";
	if($("#RadioDetailedAvailability").is(':checked')){
		url = "inventory/getInvDetailedAvailability"
	}else if($("#RadioRoomsControl").is(':checked')){
		url = "inventory/getInvRoomsControl"
	}
	
	showLoading('#divTableInvDetailed',true);
	
	$.ajax({
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
			//$('.divLoadingTable').hide();
		},
		error: function(error){
			showLoading('#divTableInvDetailed',false);
			showAlert(true,"Error in the search, try again later.",'button',showAlert);
		}
	});	
}

function disableOtherCombo( selector ){
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
* muestra el modal de personas
* @param id id de la persona
*/