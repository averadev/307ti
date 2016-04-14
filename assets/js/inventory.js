/**
* @fileoverview Funciones del screen inventory (alta/editar/busqueda)
*
* @author Alfredo Chi
* @version 0.1
*/

var maxHeight = 400;
isSearch = true;
var xhrPeople
var idPeople = 0;

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


/************Funciones**************/

/**
* Carga las opciones que se inicializan cuando entran a la pagina
*/
$(document).ready(function() {
	
	$('#textInvStartDate').fdatepicker({
		//format: 'mm-dd-yyyy',
		disableDblClickSelection: true,
	});
	
	$('#tableInvDetailed').DataTable({
		"scrollY": 200,
        "scrollX": true,
        "scrollX": true,
		"paging":   false,
        "ordering": false,
        "info":     false,
		"filter": 	false,
		/*"paging": false,*/
    });
	
});

function searchInvDetailed(page){
	//$('#divTableInvDetailed tbody').empty();
	//$('.divLoadingTable').show();
	showLoading('#divTableInvDetailed',true);
	/*if(xhrPeople && xhrPeople.readyState != 4) { 
		xhrPeople.abort();
		xhrPeople = null;
	}*/
	
	$.ajax({
   		type: "POST",
       	url: "inventory/getInvDetailedBySearch",
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
			console.log(data);
			drawTable(data.items,disableOtherCombo,"tabla");
			/*var total = data.total;
			if( parseInt(total) == 0 ){ total = 1; }
			total = parseInt( total/10 );
			if(data.total%10 == 0){
				total = total - 1;		
			}
			total = total + 1
			if(page == 0){
				$('#paginationPeople').val(true);
				loadPaginatorPeople( total );
			}*/
			/*for(i=0;i<data.items.length;i++){
				var item = data.items[i];
				$('#tablePeople tbody').append(
					'<tr>' +
						'<td class="cellEdit"><img class="iconEdit" value="' + item.pkPeopleId +'" src="' + BASE_URL+ 'assets/img/common/editIcon2.png"/></td>' +
						'<td>' + item.pkPeopleId + '</td>' +
						'<td>' + item.Name + '</td>' +
						'<td>' + item.LName + " " + item.LName2 + '</td>' +
						'<td>' + item.Gender + '</td>' +
						'<td>' + item.birthdate + '</td>' +
						'<td>' + item.Street1 + '</td>' +
						'<td>' + item.City + '</td>' +
						'<td>' + item.StateDesc + '</td>' +
						'<td>' + item.CountryDesc + '</td>' +
						'<td>' + item.ZipCode + '</td>' +
						'<td>' + item.phone1 + '</td>' +
						'<td>' + item.phone2 + '</td>' +
						'<td>' + item.phone3 + '</td>' +
						'<td>' + item.email1 + '</td>' +
						'<td>' + item.email2 + '</td>' +
					'</tr>'
				);
			}*/
			
			//$('.iconEdit').on()
			/*$("#tablePeople tbody tr .cellEdit .iconEdit").off( "click", ".iconEdit" );
			$("#tablePeople tbody tr .cellEdit .iconEdit").on("click", function(){ showModal($(this).attr('value')); });*/
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
* muestra el modal de personas
* @param id id de la persona
*/