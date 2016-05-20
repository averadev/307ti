/**
* @fileoverview Funciones del screen frontDesk (busqueda)
*
* @author Alfredo Chi
* @version 0.1
*/

var maxHeight = 400;

var dialogEditContract = modalEditReservations();

/**************Index****************/
$('#btnSearchFrontDesk').off();
$('#btnSearchFrontDesk').on('click', function(){ $('.orderRow').removeClass("active"); getFrontDesk(""); });
$('#btnSearchHKConfig').on('click', function(){ getFrontDesk(""); });

$('#orderRow').off();
$('.orderRow').on('click', function(){ orderRowFront(this); });

$('#btnCleanFrontDesk').off();
$('#btnCleanFrontDesk').on('click', function(){ cleanFilterFrontDesk(); })

$('.SectionFrontDesk').on('click', function(){ showSection($(this).val()); });

/************Funciones**************/

/**
* Carga las opciones que se inicializan cuando entran a la pagina
*/
var dateArrival = null;
var dateDeparture = null;
var dateYear = null;
var dateUnitHK = null;

$(function() {
	
	//dateField
	datepickerZebra = $( "#dateArrivalFront, #dateDepartureFront, #dateHKConfig" ).Zebra_DatePicker({
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
	dateUnitHK = $("#dateHKConfig").data('Zebra_DatePicker');
	$('#dateArrivalFront').val("04/13/2016");
	$('#dateHKConfig').val(getCurrentDate());
});

/**
* Muestra la lista de front desk
*/
function getFrontDesk(order){
	
	var filters = null;
	var dates = null;
	var words = null;
	var options = null;
	var url = "";
	
	if($('.SectionFrontDesk').val() == "section1"){
		$('.rightPanel').remove();
		$('.panelLeft').remove();
		$('#tableFrontDesk tbody').empty();
		filters = getFiltersCheckboxs('FilterFrontDesk');
		dates = getDates(["dateArrivalFront", "dateDepartureFront", "textIntervalFront"]);
		words = getWords(["textUnitCodeFront","textConfirmationFront","textViewFront"]);
		options = getWords(["textIntervalFront"]);
		url = "frontDesk/getFrontDesk";
	}else if($('.SectionFrontDesk').val() == "section2"){
		filters = getFiltersCheckboxs('FilterHKConfiguration');
		dates = getDates(["dateHKConfig"]);
		words = getWords(["textUnitHKConfig","textSectionHKConfig","textMaidHKConfig","textSupervisorHKConfig"]);
		options = getWords(["textFloorPlanHKConfig"]);
		url = "frontDesk/getHousekeepingConfiguration";
	}
	
	ajaxFrontDesk( url, filters, dates, words, options, order );
}

function ajaxFrontDesk( url, filters, dates, words, options, order ){
	
	showLoading( '#table-frontDesk', true );
	
	$.ajax({
		data:{
			filters:filters,
			dates: dates,
			words: words,
			options: options,
			order:order,
		},
   		type: "POST",
       	url: url,
		dataType:'json',
		success: function(data){
			console.log(data);
			if($('.SectionFrontDesk').val() == "section1"){
				createTableLookUp(data);
			}
			
			
			showLoading('#table-frontDesk',false);
			
		},
		error: function(){
			alertify.error("Try again");
			showLoading('#table-frontDesk',false);
		}
    });
	
}

/**
* obtiene los semanas dependiendo del año seleccionado
*/
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
					optionWeek += "<option value='" + item.date + "'>" + item.Intv + "</option>";
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

/**
* ordena el grid
*/
function orderRowFront(selector){
	var field = $(selector).parent().attr('attr-field');
	var order = $(selector).attr('attr-order');
	$('.orderRow').removeClass("active");
	$(selector).addClass("active");
	getFrontDesk(field + " " + order);
}

/**
* limpia los filtros de busqueda
*/
function cleanFilterFrontDesk(){
	dateYear.clear_date();
	dateDeparture.clear_date();
	dateArrival.clear_date();
	$('#textIntervalFront').html('<option value="">Select a interval</option>');
	$('#textUnitCodeFront').val("");
	$('#textConfirmationFront').val("");
	$('#textViewFront').val("");
	$('.checkFilterFrontDesk').attr('checked', false)
	$('#dateArrivalFront').val(getCurrentDate())
}


function modalEditReservations(){
	
	maxHeight = screen.height * .25;
	maxHeight = screen.height - maxHeight;
	
	showLoading('#dialog-Edit-Reservations',true);
	dialogo = $("#dialog-Edit-Reservations").dialog ({
  		open : function (event){
	    	$(this).load ("reservations/modalEdit" , function(){
	 			showLoading('#dialog-Edit-Reservations',false);	
				var hTabs = $('#dialog-Edit-Reservations .contentModalHeader').height();
				var hContent = $('#dialog-Edit-Reservations .contentModal').height();
				$('#dialog-Edit-Reservations .contentModal').css('height', ( hContent - (hTabs) + 25 )); 
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
    	$('#dialog-Edit-Reservations').empty();
     }
	});
	return dialogo;
}

function showReservation(){
	dialogEditContract.dialog('open');
}

function showSection(section){
	$('#section-frontDesk .sectionFrontDesk, #section-frontDesk .tableSection').hide();
	$('#section-frontDesk .' + section).toggle(500);
}

function createTableLookUp(data){
	$('.showReservation').off();
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
			
			
			var bodyHTML = "";
			for(i=0;i<items.length;i++){
				
				var item = items[i]
				bodyHTML = "<tr id='tr" + i + "'>";
				bodyHTML+="<td nowrap class='panelLeft'>"+item.type+"</th>";
				bodyHTML+="<td nowrap class='panelLeft' >"+item.unit+"</th>";
				bodyHTML+="<td nowrap class='panelLeft' >"+item.status+"</th>";
				bodyHTML+="<td nowrap title='" + item.viewDesc + "' class='panelLeft last Tooltips'>"+item.view+"</th>";
				bodyHTML += "</tr>";
				$('#tableFrontDesk tbody').append(bodyHTML);
				
				for(j = 0;j<dates.length;j++){
					bodyHTML="<td class='rightPanel' id='" + i + "-" + dates[j].pkCalendarId + "'></td>";
					$('#tableFrontDesk tbody #tr' + i).append(bodyHTML);
				}
				
				for(k = 0;k<items[i].values.length;k++){
					var values = items[i].values[k]
					var valueToolTip = {Confirmation:values.ResConf, Room:item.unit, Guest:values.people, Arrival:values.dateFrom, Departure:values.dateTo};
					var vToolTip = JSON.stringify(valueToolTip);
					var exist = false;
					
					for(j = 0;j<dates.length;j++){
						var totaltd = (values.to - values.from) + 1;
						if(dates[j].pkCalendarId >= values.from && dates[j].pkCalendarId <= values.to){
							if(exist == false){
								$('#' + + i + "-" + dates[j].pkCalendarId).attr('colspan',totaltd);
								$('#' + + i + "-" + dates[j].pkCalendarId).attr('titleCustom',vToolTip);
								$('#' + + i + "-" + dates[j].pkCalendarId).attr('reservation',1);
								$('#' + + i + "-" + dates[j].pkCalendarId).attr('class',values.occType + " rightPanel Tooltips showReservation");
								$('#' + + i + "-" + dates[j].pkCalendarId).text(values.people);
								/*bodyHTML="<td titleCustom='" +vToolTip +"' colspan='" + totaltd + "' class='" + values.occType + " rightPanel Tooltips'>" + values.people + "</td>";*/
								//$('#tableFrontDesk tbody #tr' + i).append(bodyHTML);
								
								exist = true;
							}else{
								$('#' + + i + "-" + dates[j].pkCalendarId).remove();
							}
							
						}
					}
				}
				
			}
			
			//$('#tableFrontDesk tbody').html(bodyHTML);
			$('.showReservation').on('click', function(){ showReservation() });
			initializeTooltips('.Tooltips');
}