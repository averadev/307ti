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
var dateYear = null

$(function() {
	//dateField
	datepickerZebra = $( "#dateArrivalFront, #dateDepartureFront" ).Zebra_DatePicker({
		format: 'm/d/Y',
		show_icon: false,
		onSelect: function(date1, date2, date3, elements) {
			dateYear.clear_date();
			$('#textIntervalFront').html("<option value=''>Select a interval</option>");
		},
	});
	

	
	$( "#dateYearFront" ).Zebra_DatePicker({
		format: 'Y',
		view: 'years',
		show_icon: false,
		onSelect: function(year, elements) {
			dateDeparture.clear_date();
			dateArrival.clear_date();
			getWeekByYear(year);
		},
	});
	
	dateArrival = $("#dateArrivalFront").data('Zebra_DatePicker');
	dateDeparture = $("#dateDepartureFront").data('Zebra_DatePicker');
	dateYear = $("#dateYearFront").data('Zebra_DatePicker');
	
	//$('#dateArrivalFront').val(getCurrentDate());
	$('#dateArrivalFront').val("04/13/2016")
	
});

/**
* Muestra la lista de front desk
*/
function getFrontDesk(){
	showLoading( '#table-frontDesk', true );
	
	var filters = getFiltersCheckboxs('FilterFrontDesk');
	var dates = getDates(["dateArrivalFront", "dateDepartureFront", "textIntervalFront"]);
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
			
			for(i=0;i<items.length;i++){
				var item = items[i]
				bodyHTML+="<td class='panelLeft'>"+item.type+"</th>";
				bodyHTML+="<td class='panelLeft' >"+item.unit+"</th>";
				bodyHTML+="<td class='panelLeft' >"+item.status+"</th>";
				bodyHTML+="<td title='" + item.viewDesc + "' class='panelLeft last Tooltips'>"+item.view+"</th>";
				
				var values = items[i].values
				var valueToolTip = {Confirmation:values.ResConf, Room:item.unit, Guest:values.people, Arrival:values.dateFrom, Departure:values.dateTo};
				var vToolTip = JSON.stringify(valueToolTip);
				var exist = false;
				for(j = 0;j<dates.length;j++){
					var totaltd = (values.to - values.from) + 1;
					if(dates[j].pkCalendarId >= values.from && dates[j].pkCalendarId <= values.to){
						if(exist == false){
							bodyHTML+="<td titleCustom='" +vToolTip +"' colspan='" + totaltd + "' class='" + values.occType + " rightPanel Tooltips'>" + values.people + "</td>";
							exist = true;
						}
					}else{
						bodyHTML+="<td class='rightPanel'></td>";
					}
				}
				bodyHTML += "</tr>";
			}
			
			$('#tableFrontDesk tbody').html(bodyHTML);
			
			initializeTooltips('.Tooltips');
			
			showLoading('#table-frontDesk',false);
			
		},
		error: function(){
			alertify.error("Try again");
			showLoading('#table-frontDesk',false);
		}
    });
}

function getWeekByYear(year){
	$.ajax({
		type: "POST",
		url: "frontDesk/getWeekByYear",
		dataType:'json',
		data:{
			year: year,
		},
		success: function(data){
			var items = data.items
			if(items.length > 0){
				var optionWeek = ""
				for(i=0;i<items.length;i++){
					var item = items[i];
					optionWeek += "<option value='" + item.date + "'>" + item.Week + "</option>";
				}
				$('#textIntervalFront').html(optionWeek);
				optionWeek = null;
			}else{
				$('#textIntervalFront').html("<option value=''>intervals he not found</option>");
			}
		},
		error: function(){
			alertify.error("try again");
		}
	});
}