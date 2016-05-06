/**
* @fileoverview Funciones del screen frontDesk (busqueda)
*
* @author Alfredo Chi
* @version 0.1
*/

/**************Index****************/

$('#btnSearchFrontDesk').on('click', function(){ getFrontDesk(); });

/************Funciones**************/

/**
* Carga las opciones que se inicializan cuando entran a la pagina
*/
var dateArrival = null
var dateDeparture = null

$(function() {
	//dateField
	datepickerZebra = $( "#dateArrivalFront, #dateDepartureFront" ).Zebra_DatePicker({
		format: 'm/d/Y',
		show_icon: false,
		onSelect: function(date1, date2, date3, elements) {
			/*if($(elements).attr('id') == "dateArrivalFront"){
				dateDeparture.clear_date();
			}else if($(elements).attr('id') == "dateDepartureFront"){
				dateArrival.clear_date();
			}*/
		},
	});
	
	dateArrival = $("#dateArrivalFront").data('Zebra_DatePicker');
	dateDeparture = $("#dateDepartureFront").data('Zebra_DatePicker');
	
	$( "#dateYearFront" ).Zebra_DatePicker({
		format: 'Y',
		view: 'years',
		show_icon: false,
	});
	
	$('#dateArrivalFront').val(getCurrentDate())
	
});

/**
* Muestra la lista de front desk
*/
function getFrontDesk(){
	showLoading( '#table-frontDesk', true );
	
	var filters = getFiltersCheckboxs('FilterFrontDesk');
	var dates = getDates(["dateArrivalFront", "dateDepartureFront", "dateYearFront"]);
	var words = getWords(["textUnitCodeFront","textConfirmationFront","textViewFront"]);
	var options = getWords(["textIntervalFront"]);
	$.ajax({
		data:{
			filters:filters,
			dates: dates,
			words: words,
			options: options,
		},
   		type: "POST",
       	url: "frontDesk/getFrontDesk",
		dataType:'json',
		success: function(data){
			
			$('.rightPanel').remove();
			
			console.log(data);
			var headYearHTML = "";
			var headMonthHTML = "";
			var headHTML = "";
			var dates = data.dates;
			var items = data.items;
			
			var existMoth = "";
			var existYear = "";
			for (var j in dates) {
				
				
				if(existYear != dates[j].year ){
					headYearHTML = "<th colspan='1' id='thYear" + dates[j].year + "' class='rightPanel'>"+dates[j].year+"</th>";
					existYear = dates[j].year;
					$('#tableFrontDesk .gHeaderYear').append(headYearHTML);
				}else{
					var colspan = $('#thYear' + dates[j].year ).attr('colspan');
					$('#thYear' + dates[j].year ).attr('colspan', (parseInt(colspan) + 1));
				}
				
				if(existMoth != dates[j].month ){
					headMonthHTML = "<th colspan='1' id='thMonth" + dates[j].month + "' class='rightPanel'>"+dates[j].month+"</th>";
					existMoth = dates[j].month;
					$('#tableFrontDesk .gHeaderMonth').append(headMonthHTML);
				}else{
					var colspan = $('#thMonth' + dates[j].month ).attr('colspan');
					$('#thMonth' + dates[j].month ).attr('colspan', (parseInt(colspan) + 1));
				}
				
				headHTML+="<th id='"+dates[j].pkCalendarId+"' class='rightPanel'>"+dates[j].day+"</th>";
			}
			
			
			$('#tableFrontDesk .gHeaderDay').append(headHTML);
			
			var bodyHTML = "<tr>";
			
			//console.log(items[0].values.from)
			
			for(i=0;i<items.length;i++){
				bodyHTML+="<td class='panelLeft'>"+items[i].type+"</th>";
				bodyHTML+="<td class='panelLeft' >"+items[i].unit+"</th>";
				bodyHTML+="<td class='panelLeft last'>"+items[i].view+"</th>";
				
				var values = items[i].values
				var exist = false;
				for(j = 0;j<dates.length;j++){
					var totaltd = (values.to - values.from) + 1;
					if(dates[j].pkCalendarId >= values.from && dates[j].pkCalendarId <= values.to){
						if(exist == false){
							bodyHTML+="<td colspan='" + totaltd + "' class='" + values.occType + " rightPanel'>" + values.people + "</td>";
							exist = true;
						}
					}else{
						bodyHTML+="<td class='rightPanel'></td>";
					}
					
				}
				
				bodyHTML += "</tr>";
			}
			
			/*for (var j in items) {
				bodyHTML+="<th>"+items[j].type+"</th>";
				bodyHTML+="<th>"+items[j].unit+"</th>";
				bodyHTML+="<th class='panelLeft last'>"+items[j].view+"</th>";
				console.log(items[j].values.length);
				for (var k in items[j].values.length) {
					console.log(k);
				}
				 bodyHTML += "</tr>";
			}*/
			
			$('#tableFrontDesk tbody').html(bodyHTML);
			
			/*$( '#tableFrontDesk' ).DataTable({
				"scrollY": 350,
				"scrollX": true,
				"paging":   false,
				"ordering": false,
				"info":     false,
				"filter": 	false,
			});*/
			
			showLoading('#table-frontDesk',false);
		},
		error: function(){
			alertify.error("Try again");
			showLoading('#table-frontDesk',false);
		}
    });
}


$(function() {
	//console.log(ganttData);
});