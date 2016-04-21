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
	//alertify.success("Found "+ 50);
	$( "#textInvStartDate" ).Zebra_DatePicker({
		format: 'm/d/Y',
	});
	
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();
	
	if(dd<10) {
		dd='0'+dd
	} 

	if(mm<10) {
		mm='0'+mm
	} 
	
	today = mm+'/'+dd+'/'+yyyy;
	$('#textInvStartDate').val(today)
});

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
			url = "inventory/getInvDetailedAvailability"
		}else if($("#RadioRoomsControl").is(':checked')){
			url = "inventory/getInvRoomsControl"
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
				//console.log(xhrInventary)
				drawTable2(data.items,"tableInvDetailed",false,"tabla");
				showLoading('#divTableInvDetailed',false);
				//$('.divLoadingTable').hide();
			},
			error: function(error){
				if(error.statusText != "abort"){
					showLoading('#divTableInvDetailed',false);
					showAlert(true,"Error in the search, try again later.",'button',showAlert);
				}
			}
		});
	}else{
		$('#alertInventaryUnit').show(500)
	}
	
}

function validateFieldInventary(){
	var resultc = true;
	$('#alertInventaryUnit').hide()
	if($('#RadioDetailedAvailability').is(":checked")){
		if($('#textInvFloorPlan').val() == 0 && $('#textInvProperty').val() == 0 ){
			resultc = false;
		}
	}else{
		if($('#textInvProperty').val() == 0 ){
			resultc = false;
		}
	}
	
	return resultc;
	
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