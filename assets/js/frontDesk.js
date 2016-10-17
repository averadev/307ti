/**
* @fileoverview Funciones del screen frontDesk (busqueda)
* Abandona toda esperanza aquellos que entren aqui
* @author Alfredo Chi
* @version 0.1
*/

//var maxHeight = 400;
var maxHeight = screen.height * .10;
maxHeight = screen.height - maxHeight;

/*var dialogEditContract = modalEditReservations();
var dialogHKConfig = modalHKConfig(0);
var peopleDialogHK = addPeopleDialogHKC("");
var unitDialogHK = addUnitDialogHKC();
var chgStatusDialog = editHKStatus();*/
var exchangeRate = null;

var FloorplanFD;
var OCCTYPE;
var OCCSTATUS;
var AUDITTRX;
var msgFrontDesk = null;

/**************Index****************/

$('.searchFD').off();
$('.searchFD').on('click', function(){ $('.orderRow').removeClass("active"); getFrontDesk("",1); });

$(document).off( 'click', '#btnNewFrontExchange');
$("#btnNewFrontExchange").on('click', function(){
	getModalNewExchangeRate();
});

$('#orderRow').off();
$('.orderRow').on('click', function(){ orderRowFront(this); });

$('#btnCleanFrontDesk').off();
$('#btnCleanFrontDesk').on('click', function(){ cleanFilterFrontDesk(); });

$('#btnCleanAuditUnit').off();
$('#btnCleanAuditUnit').on('click', function(){ cleanAuditUnit(); });

$('#btnCleanAuditTransactions').off();
$('#btnCleanAuditTransactions').on('click', function(){ cleanAuditUnitTRX(); });


$('#typeSearchFrontDesk').on('change', function(){ showSection($(this).val()); });

//muestra el modal para agregar
$('#newFontDesk').off();
$('#newFontDesk').on('click', function() {  showModaFrontDesk(0); });



$('#btnHKREPORT').off();
$('#btnHKREPORT').on('click', function() {  generateReportFrontDesk(); });

$('#btnHKLUREPORT').off();
$('#btnHKLUREPORT').on('click', function() {  generateReportFrontDesk(); });

$('#btnChgStatus').off();
$('#btnChgStatus').on('click', function() {  showModaChgStatus(); });


$('#btnAddTrxAuditUnit').off();
$('#btnAddTrxAuditUnit').on('click', function() {
	var SRSS = getArrayValuesColumnTableC("tablaAuditUnits", 1);
	if (SRSS>0) {
		alertify.error("Units Without Reservations");
	}else{
		showModalAuditAddTrx();
	} 
	
});

$('#btnReporAuditUnit').off();
$('#btnReporAuditUnit').on('click', function() {  generateReportAuditUnits(); });

$('#btnReporAuditTrx').off();
$('#btnReporAuditTrx').on('click', function() {  generateReportAuditTrx(); });

$('#btncloseDayAuditTransactions').off();
$('#btncloseDayAuditTransactions').on('click', function() {  
	var SRSS = getArrayValuesColumnTable("tablaAuditTrx", 8).length;
	if (SRSS > 0) {
		alertify.error("There are Transactions Audited");
	}else{
		closeDAYTRX();
	}
});


/************Funciones**************/

/**
* Carga las opciones que se inicializan cuando entran a la pagina
*/
var dateArrival = null;
var dateDeparture = null;
var dateYear = null;
var dateUnitHK = null;
var dateHKLookUp = null;
var dateDepartureER = null;
var dateDepartureER = null;
var dateYearER = null;

$(function() {
	
	//dateField
	datepickerZebra = $( "#dateArrivalFront, #dateDepartureFront, #dateHKConfig, #dateHKLookUp, #dateArrivalReport, #dateDepartureReport, #dateArrivalExchange, #dateDepartureExchange" ).Zebra_DatePicker({
		format: 'm/d/Y',
		show_icon: false,
		onSelect: function(date1, date2, date3, elements){
			dateYear.clear_date();
			dateYearER.clear_date();
			$('#textIntervalFront').html("<option value=''>Select a interval</option>");
			$('#textIntervalExchange').html("<option value=''>Select a interval</option>");
		},
	});
		
	$( "#dateYearFront, #dateYearExchange" ).Zebra_DatePicker({
		format: 'Y',
		view: 'years',
		show_icon: false,
		onSelect: function(year, date2, date3, elements) {
			var selectorId = $(elements).attr('id');
			var selectorBox = $(elements).attr('box');
			if( selectorId == "dateYearFront"){
				dateDeparture.clear_date();
				dateArrival.clear_date();
			}else{
				dateDepartureER.clear_date();
				dateDepartureER.clear_date();
			}
			getWeekByYear( year, selectorId, selectorBox );
		},
	});
	
	dateArrival = $("#dateArrivalFront").data('Zebra_DatePicker');
	dateDeparture = $("#dateDepartureFront").data('Zebra_DatePicker');
	dateYear = $("#dateYearFront").data('Zebra_DatePicker');
	dateUnitHK = $("#dateHKConfig").data('Zebra_DatePicker');
	dateHKLookUp = $("#dateHKLookUp").data('Zebra_DatePicker');
	dateDepartureER = $("#dateArrivalExchange").data('Zebra_DatePicker');
	dateDepartureER = $("#dateDepartureExchange").data('Zebra_DatePicker');
	dateYearER = $("#dateYearExchange").data('Zebra_DatePicker');
	//$('#dateArrivalFront').val("04/13/2016");
	$('#dateArrivalFront').val(getCurrentDate());
	//$('#dateHKConfig').val(getCurrentDate());
	//$('#dateHKLookUp').val(getCurrentDate());
	//$('#dateArrivalReport').val(getCurrentDate());
	
	FloorplanFD =  $('#textFloorPlanHKConfig').multipleSelect({
		width: '100%',
		placeholder: "Select a floor plan",
		selectAll: false,
		onClick: function(view) {
		},
	});
	OCCTYPE = $('#occTypeAudit').multipleSelect({
		filter: true,
		width: '100%',
		placeholder: "Select one",
		selectAll: false,
		onClick: function(view) {
		},
	});

	OCCSTATUS = $('#statusAudit').multipleSelect({
		filter: true,
		width: '100%',
		placeholder: "Select one",
		selectAll: false,
		onClick: function(view) {
		},
	});
	
	activatePaginador('paginationHKConfig', gepPageFrontDesk);
	activatePaginador('paginationHKLookUp', gepPageFrontDesk);
	
	var addReservation = null;
	
	getFrontDesk("",1);
	initDatesAudit();
});

function gepPageFrontDesk(page){
	getFrontDesk("",page)
}

function initDatesAudit(){
	$( "#DateAudit" ).Zebra_DatePicker({
		format: 'm/d/Y',
		show_icon: false,
	});
	$('#DateAudit').val(getCurrentDateMENOS(1));

	$("#dateAuditTRX").Zebra_DatePicker({
		format: 'm/d/Y',
		show_icon: false,
	});
	$('#dateAuditTRX').val(getCurrentDateMENOS(1));

	// $( "#DateArrival" ).Zebra_DatePicker({
	// 	format: 'm/d/Y',
	// 	show_icon: false,
	// });
	// $( "#DateDeparture" ).Zebra_DatePicker({
	// 	format: 'm/d/Y',
	// 	show_icon: false,
	// });
}
/**
* Muestra la lista de front desk
*/
function getFrontDesk(order, page){
	
	var filters = null;
	var dates = null;
	var words = null;
	var options = null;
	var url = "";
	var section = $('#typeSearchFrontDesk').val();
	if(section == "section1"){
		$('.rightPanel').remove();
		$('.panelLeft').remove();
		$('#tableFrontDesk tbody').empty();
		filters = {};
		dates = getDates(["dateArrivalFront", "dateDepartureFront", "textIntervalFront"]);
		words = getWords(["textUnitCodeFront","textConfirmationFront","textViewFront"]);
		options = getWords(["textIntervalFront"]);
		url = "frontDesk/getFrontDesk";
	}else if(section == "section2"){
		
	}else if(section == "section3"){
		filters = getFiltersCheckboxs('FilterHKConfiguration');
		dates = getDates(["dateHKConfig"]);
		words = getWords(["textUnitHKConfig","textSectionHKConfig","textMaidHKConfig","textSupervisorHKConfig"]);
		options = getWordsByArray(FloorplanFD.multipleSelect('getSelects'));
		url = "frontDesk/getHousekeepingConfiguration";
	}else if(section == "section4"){
		filters = getFiltersCheckboxs('statusHKLookUp');
		dates = getDates(["dateHKLookUp"]);
		words = getWords(["textUnitHKConfig"]);
		options = getWords(["ServiceTypeLookUp"]);
		url = "frontDesk/getHousekeepingLookUp";
	}else if(section == "section5"){
		filters = getFiltersCheckboxs('checkReport');
		//filters = {};
		dates = getDates(["dateArrivalReport"]);
		words = {};
		options = {};
		url = "frontDesk/getHousekeepingReport";
	}else if(section == "section6"){
		filters = {};
		dates = getDates(["dateArrivalExchange","dateDepartureExchange","textIntervalExchange"]);
		words = getWords(["textIntervalExchange"]);
		options = {};
		url = "frontDesk/getExchangeRate";
	}else if(section == "section7"){
		filters = {};
		dates = {};
		//words = getWords(["unitAudit", "DateAudit", "DateArrival", "DateDeparture"]);
		words = getWords(["unitAudit", "DateAudit"]);
		var Seleccionado = $("#ArrivalDeparture").val();
		switch(Seleccionado) {
		    case "1":
		        words.DateArrival = $("#DateAudit").val();
		        break;
		    case "2":
		         words.DateDeparture = $("#DateAudit").val();
		        break;
		}

		words.statusAudit = OCCSTATUS.multipleSelect('getSelects');
		words.occTypeAudit = OCCTYPE.multipleSelect('getSelects');
		options = {};
		//options = getWordsByArray(OCCTYPE.multipleSelect('getSelects'));
		
		url = "frontDesk/getAuditUnits";
	}else if(section == "section8"){
		filters = {};
		dates = {};
		words = getWords(["dateAuditTRX","userTrxAudit", "Transaction", "isAudited"]);
		options = {};
		url = "frontDesk/getAuditTrx";
	}

	
	ajaxFrontDesk( url, filters, dates, words, options, order, page );
}
function getWordsByArrayAudit(names, values) {
	
    words = {};
	for(i=0;i<names.length;i++){
		words[names[i]] = values[i];
	}
    return words;
}

function ajaxFrontDesk( url, filters, dates, words, options, order, page ){
	noResults('#table-frontDesk',false);
	showLoading( '#table-frontDesk', true );
	$.ajax({
		data:{
			filters:filters,
			dates: dates,
			words: words,
			options: options,
			order:order,
			page:page,
		},
   		type: "POST",
       	url: url,
		dataType:'json',
		success: function(data){
			//var section = $('.SectionFrontDesk:checked').val();
			var section = $('#typeSearchFrontDesk').val();
			switch(section) {
				case "section1":
					createTableLookUp(data);
				break;
			}
			if(data.items){
				switch(section) {
					case "section1":
						//createTableLookUp(data);
						$("#NFL").text("Total: "+ data.items.length);
					break;
					case "section2":
						//$("#NHK").text("Total: "+ data.items.length);
					break;
					case "section3":
						$("#NHK").text("Total: "+ data.items.length);
						drawTable2(data.items,"tableHKConfiguration","showModaFrontDesk","Edit");
						paginadorFrontDesk(data.total,"paginationHKConfig",0);
						
						//alert( 'Column '+order[0][0]+' is the ordering column' );
					break;
					case "section4":
						$("#NHKL").text("Total: "+ data.items.length);
						var option = {type:"input", input:"checkbox", title:"Change_status", name:"HKLookUpStatus", id:"ID"};
						drawTable2( data.items,"tableHKLookUp","showModaFrontDesk","Edit", option );
						paginadorFrontDesk(data.total,"paginationHKLookUp",0);
					break;
					case "section5":
						$("#NHKR").text("Total: "+ data.items.length);
						drawTable2( data.items, "tableHKReport", false, "" );
					break;
					case "section6":
						$("#NRF").text("Total: "+ data.items.length);
						drawTable2( data.items, "tableExchangeRateFront", false, "" );
					break;
					case "section7":
						$("#NUA").text("Total: "+ data.items.length);
						drawTable4( data.items, "tablaAuditUnits", false, "" );
					break;
					case "section8":
						$("#NTA").text("Total: "+ data.items.length);
						drawTable4( data.items, "tablaAuditTrx", false, "" );
					break;
				}
			}else{
				switch(section) {
					case "section1":
						alertify.error("No reservations found");
					break;
					case "section3":
						noResultsTable("table-frontDesk", "tableHKConfiguration", "no results found");
						paginadorFrontDesk(1,"paginationHKConfig",0);
					break;
					case "section4":
						noResultsTable("table-frontDesk", "tableHKLookUp", "no results found");
						paginadorFrontDesk(1,"paginationHKLookUp",0);
					break;
					case "section5":
						noResultsTable("table-frontDesk", "tableHKReport", "no results found");
						//paginadorFrontDesk(1,"paginationHKLookUp",0);
					break;
					case "section7":
						alertify.success("No data Found");
						$("#tablaAuditUnits").empty();
					break;
					case "section8":
						alertify.success("No Data Found");
						$("#tablaAuditTrx tbody").empty();
				}
			}
			showLoading('#table-frontDesk',false);	
		},
		error: function(){
			alertify.error("Try again");
			showLoading('#table-frontDesk',false);
		}
    });
	
}

function cleanAuditUnit(){
	$("#unitAudit").val('');
	//$("#DateArrival").val('');
	//$("#DateDeparture").val('');
	$("#ArrivalDeparture").val(0);
	OCCTYPE.multipleSelect("uncheckAll");
	OCCSTATUS.multipleSelect("uncheckAll");	
}
function cleanAuditUnitTRX(){
	$("#userTrxAudit").val('');
	$("#idTrx").val("");
	$("#isAudited").val("");
}
/**
* obtiene los semanas dependiendo del año seleccionado
*/
function getWeekByYear(year, selectorId, selectorBox){
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
				
				$( '#' + selectorBox ).html(optionWeek);
				optionWeek = null;
			}else{
				$( '#' + selectorBox ).html("<option value=''>intervals he not found</option>");
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
	
	//var maxHeight = screen.height * .25;
	//maxHeight = screen.height - maxHeight;
	
	showLoading('#dialog-Edit-Reservations',true);
	dialogo = $("#dialog-Edit-Reservations").dialog ({
  		open : function (event){
	    	$(this).load ("reservations/modalEdit" , function(){
	 			showLoading('#dialog-Edit-Reservations',false);	
				/*var hTabs = $('#dialog-Edit-Reservations .contentModalHeader').height();
				var hContent = $('#dialog-Edit-Reservations .contentModal').height();
				$('#dialog-Edit-Reservations .contentModal').css('height', ( hContent - (hTabs) + 25 ));*/ 
	    	});
		},
		autoOpen: false,
     	height: maxHeight,
     	width: "50%",
     	modal: true,
		dialogClass: 'dialogModal',
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

/****************************************/
/****************************************/
/****************************************/

function modalHKConfig(id){
	//maxHeight = screen.height * .25;
	//maxHeight = screen.height - maxHeight;
	
	dialog = $("#dialog-HKConfig").dialog ({
  		open : function (event){
			showLoading('#dialog-HKConfig',true);
	    	$(this).load ("frontDesk/modalHKConfig" , function(){
	 				
				/*var hTabs = $('#dialog-HKConfig .contentModalHeader').height();
				var hContent = $('#dialog-HKConfig .contentModal').height();
				$('#dialog-HKConfig .contentModal').css('height', ( hContent - (hTabs) + 25 )); */
				ajaxSelectsFrontDesk('frontDesk/getHkServiceType','try again', generalSelectsFront, 'SltServiceTypeHKC', 'Select a service type');
				$('#btnAddPeopleHKCMaid').off();
				$('#btnAddPeopleHKCMaid').on('click', function() { 
					//peopleDialogHK = addPeopleDialogHKC('maid');
					//peopleDialogHK.dialog( "open" );
					if (peopleDialogHK != null) {
						peopleDialogHK.dialog( "destroy" );
					}
					peopleDialogHK = addPeopleDialogHKC('maid');
					peopleDialogHK.dialog( "open" );
				});
				$('#btnAddPeopleHKCSupe').off();
				$('#btnAddPeopleHKCSupe').on('click', function() { 
					//peopleDialogHK = addPeopleDialogHKC('superior');
					//peopleDialogHK.dialog( "open" );
					if (peopleDialogHK != null) {
						peopleDialogHK.dialog( "destroy" );
					}
					peopleDialogHK = addPeopleDialogHKC('superior');
					peopleDialogHK.dialog( "open" );
				});
				$('#btnAddUnitHKC').off();
				$('#btnAddUnitHKC').on('click', function() { 
					unitDialogHK = addUnitDialogHKC();
					unitDialogHK.dialog( "open" );
				});
				if(id == 0){
					showLoading('#dialog-HKConfig',false);
				}else{
					$('#unitHKConfig').hide();
					showHKConfiguration(id);
				}
				
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
       		text: "Save",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
				var results = validateHKCForm();
				if(results){
					saveHKConfig(id);
				}
       		}
     	}],
     close: function() {
    	$('#dialog-HKConfig').empty();
     }
	});
	
	return dialog;
}

function showSection(section){
	$('#generalPage').hide();
	$('#paginationHKConfig').hide();
	$('#paginationHKLookUp').hide();
	$('#section-frontDesk .sectionFrontDesk, #section-frontDesk .tableSection').hide();
	$('#section-frontDesk .' + section).toggle(500);
	if( section == "section3" || section == "section4" || section == "section5" ){
		getFrontDesk("",1);
	}
	if( section == "section3" || section == "section4" || section == "section5" ){
		$('#newExchangeRate').show();
	}if( section == "section7" || section == "section8"){
		getFrontDesk("",1);
	}else{
		$('#newExchangeRate').hide();
	}
	
}

function createTableLookUp(data){
	
	$('.showReservation').off();
	$('.emptyUnitsFront').off();
	var headYearHTML = "";
	var headMonthHTML = "";
	var headHTML = "";
	var dates = data.dates;
	var items = data.items;
	var units = data.units;
	
	var existMoth = "";
	var existYear = "";
	var wiCell = 73/dates.length;
	for (var j in dates) {
		/*if(existYear != dates[j].year ){
			headYearHTML = "<th colspan='1' id='thYear" + dates[j].year + "' class='rightPanel'>"+dates[j].year+"</th>";
			existYear = dates[j].year;
			$('#tableFrontDesk .gHeaderYear').append(headYearHTML);
		}else{
			var colspan = $('#thYear' + dates[j].year ).attr('colspan');
			$('#thYear' + dates[j].year ).attr('colspan', (parseInt(colspan) + 1));
		}*/
				
		if(existMoth != dates[j].month ){
			headMonthHTML = "<th colspan='1' id='thMonth" + dates[j].month + "' class='rightPanel'>"+dates[j].month+ "/" + dates[j].year +"</th>";
			existMoth = dates[j].month;
			$('#tableFrontDesk .gHeaderMonth').append(headMonthHTML);
			$('#thMonth' + dates[j].month ).css('width', (wiCell * 1 ) + "%");
		}else{
			var colspan = $('#thMonth' + dates[j].month ).attr('colspan');
			$('#thMonth' + dates[j].month ).attr('colspan', (parseInt(colspan) + 1));
			// console.log(colspan);
			// console.log(wiCell * colspan);
			// console.log("");
			//colspan = colspan + 1;
			//console.log(wiCell * colspan);
			$('#thMonth' + dates[j].month ).css('width', (wiCell * (parseInt(colspan) + 1) ) + "%");
		}
				
		headHTML+="<th id='"+dates[j].pkCalendarId+"' class='rightPanel'>"+dates[j].day+"</th>";
	}		
	$('#tableFrontDesk .gHeaderDay').append(headHTML);
	var isUnit = 0;
	for(i=0;i<units.length;i++){
		
		var itemUnit = units[i];
		
		
		bodyHTML = "<tr id='tr" + i + "'>";
		bodyHTML+="<td nowrap class='panelLeft typeFd'>"+ itemUnit.FloorPlan +"</th>";
		bodyHTML+="<td nowrap class='panelLeft NumFd' >"+ itemUnit.unit +"</th>";
		bodyHTML+="<td nowrap class='panelLeft StatusFd' >"+itemUnit.hkStatus+"</th>";
		bodyHTML+="<td nowrap title='" + itemUnit.views + "' class='panelLeft last Tooltips ViewFd'>" + itemUnit.viewsCode + "</th>";
		bodyHTML += "</tr>";
		$('#tableFrontDesk tbody').append(bodyHTML);
		
		
		
		for(j = 0;j<dates.length;j++){
			bodyHTML="<td class='rightPanel emptyUnitsFront' id='" + i + "-" + dates[j].pkCalendarId + "' day='" + dates[j].Date + "' unit='" + itemUnit.unit + "'  unitId='" + itemUnit.pkUnitId + "'></td>";
			$('#tableFrontDesk tbody #tr' + i).append(bodyHTML);
			//$('#' + + j + "-" + dates[j].pkCalendarId).css('width', wiCell + "%");
		}
		
		for(l=0;l<items.length;l++){
			var item = items[l];
			if( itemUnit.unit == item.unit ){
				//console.log(item.isUnit);
				for(k = 0;k<items[l].values.length;k++){
					var values = items[l].values[k]
					var valueToolTip = {Confirmation:values.ResConf, Room:item.unit, Guest:values.people, Arrival:values.dateFrom, Departure:values.dateTo};
					var vToolTip = JSON.stringify(valueToolTip);
					var exist = false;
					for(j = 0;j<dates.length;j++){
						var totaltd = (values.to - values.from) + 1;
						if(dates[j].pkCalendarId >= values.from && dates[j].pkCalendarId <= values.to){
							if(exist == false){
								$('#' + + i + "-" + dates[j].pkCalendarId).attr('colspan',totaltd);
								$('#' + + i + "-" + dates[j].pkCalendarId).attr('titleCustom',vToolTip);
								$('#' + + i + "-" + dates[j].pkCalendarId).attr('reservation',values.ResId);
								if(item.isUnit == 1){
									isUnit = i;
									//$('#' + + i + "-" + dates[j].pkCalendarId).attr('class',values.occType + " rightPanel Tooltips showReservation FDBorder");
								}
								$('#' + + i + "-" + dates[j].pkCalendarId).attr('class',values.occType + " rightPanel Tooltips showReservation");
								if( totaltd == 1 ){
									values.people = values.people.slice(0,9) + "...";
								}else if( totaltd == 2 ){
									values.people = values.people.slice(0,18) + "...";
								}
								$('#' + + i + "-" + dates[j].pkCalendarId).text(values.people);
								$('#' + + i + "-" + dates[j].pkCalendarId).css('width', (wiCell * totaltd ) + "%");
								exist = true;
							}else{
								$('#' + + i + "-" + dates[j].pkCalendarId).remove();
							}
						}
					}
				}
			}
		}
	}
	if(isUnit != 0){
		var currentTopFK = $('#tr' + isUnit).position().top;
		$('#tableFrontDesk tbody').scrollTop( currentTopFK -250 );
		$('#tr' + isUnit).addClass('borderSelectFront');
		
	}else if( isUnit == 0 && ( $('#textUnitCodeFront').val().trim().length != 0 || $('#textConfirmationFront').val().trim().length != 0 ) ){
		alertify.error("No reservations found");
	}

	
	$('.showReservation').on('click', function(){ showReservation(this); });
	$('.emptyUnitsFront').on('click', function(){ showNewReservation(this); });
	
	initializeTooltips('.Tooltips');
	
}

function showHKConfiguration(id){
	showLoading('#dialog-HKConfig',true);
	$.ajax({
		type: "POST",
		data:{
			id:id
		},
		url: "frontDesk/getHKConfigurationById",
		dataType:'json',
		success: function(data){
			if(data.items.length > 0){
				var item = data.items[0];
				$('.rowSpace').remove();
				$('#textSectionHKC').val(item.Section);
				var rowSelect = [];
				var row = [item.MaidId, item.MaidName, item.MaidLName];
				rowSelect.push(row);
				tableSelectHKC(rowSelect,"tablePeople","tablePeopleMaidSelectedHKC");
				var rowSelect = [];
				var row = [item.SuperId, item.SuperName, item.SuperLName];
				rowSelect.push(row);
				tableSelectHKC(rowSelect,"tablePeople","tablePeopleSupeSelectedHKC");
				$('#SltServiceTypeHKC').val(item.fkHKServiceTypeId);
				var rowSelect = [];
				var row = [item.pkUnitId, item.UnitCode, item.FloorPlanDesc, item.PropertyName];
				rowSelect.push(row);
				tableSelectHKC(rowSelect,"tblUnitHKC","tableUnitsSelectedHKC");
				$('#SltServiceTypeHKC').val(item.fkHKServiceTypeId);
			}
			showLoading('#dialog-HKConfig',false);
			
			//funcion(data, divSelect, firtOption);
		},
		error: function(data){
			if(data)
			showLoading('#dialog-HKConfig',false);
			//alertify.error(errorMsj);
		}
	});
	
}

function showModaFrontDesk(id){
	if (dialogHKConfig!=null) {
		dialogHKConfig.dialog( "destroy" );
	}
	dialogHKConfig = modalHKConfig(id);
	dialogHKConfig.dialog('open');
	//dialogHKConfig = modalHKConfig(id)
	//dialogHKConfig.dialog('open');
}

/***************************/
/***************************/
/***************************/

function addPeopleDialogHKC(typePeople) {
	var div = "#dialog-people-hkConfig";
	
	/*if($(div).dialog() != null){
		$(div).dialog( "destroy" );
	}*/
	dialog = $(div).dialog({
		open : function (event){
			if ($(div).is(':empty')) {
				showLoading(div, true);
				$(this).load ("people/index" , function(){
		    		showLoading(div, false);
		    		$("#dialog-User").hide();
					$("#dialog-people-hkConfig").find('#btnSearch').attr('attr_people',typePeople);
					if(typePeople == "maid"){
						selectTableFrontDesk("tablePeople","tablePeopleMaidSelectedHKC", 1);
					}else{
						selectTableFrontDesk("tablePeople","tablePeopleSupeSelectedHKC", 1);
					}
	            	//
	    		});
			}
			if( jQuery.isFunction( markRowTableFrontDesk ) ) {
				if(typePeople == "maid"){
					markRowTableFrontDesk( "tablePeople", "tablePeopleMaidSelectedHKC" );
				}else{
					markRowTableFrontDesk( "tablePeople", "tablePeopleSupeSelectedHKC" );
				}
			}
		},
		autoOpen: false,
		height: maxHeight,
		width: "50%",
		modal: true,
		buttons: [{
			text: "Ok",
			"class": 'dialogModalButtonAccept',
			click: function() {
				
				$(this).dialog('close');
				//$(this).dialog( "destroy" );
				$("#dialog-people-hkConfig").empty();
			}
		}],
		close: function() {
			//$('#dialog-people-hkConfig').empty();
			$("#dialog-people-hkConfig").empty();
		}
	});
	return dialog;
}

function selectTableFrontDesk(div,div2, total){
	$("#"+div).off();
	$("#"+div).on("click", "tr", function(){
		$("#" + div2 + " tbody .rowSpace").remove();
		if(total == 1){
			$('#' + div + ' tbody tr' ).removeClass("yellow");
			$(this).addClass("yellow");
			$('#' + div2 + ' tbody' ).empty();
			selectAllTableFontDesk(this, div, div2);
		}else{
			var totalTr = $("#" + div2 + " tbody tr").length;
			if($(this).attr('class') == "even yellow" || $(this).attr('class') == "odd yellow"){
				$(this).removeClass("yellow");
				deselectedPeople(this,div2);
			}else if(totalTr < total){
				$(this).addClass("yellow");
				selectAllTableFontDesk(this, div, div2);
			}
		}
	});
}

function markRowTableFrontDesk( div, div2 ){
	$("#"+div + " tbody tr").removeClass("yellow");
	$("#" + div2 + " tbody tr").each(function (){
		var selector1 = this;
		selector1 = $(selector1).attr('id');
		if(selector1 != undefined){
			var res = selector1.split("PS");
			var idRwo1 = res[1];
			$("#" + div + " tbody tr").each(function (){
				var selector2 = this;
				var idRwo2 = $(selector2).attr('id');
				if(idRwo1 == idRwo2){
					$(selector2).addClass('yellow');
				}
			});
		}
	});
}

function selectAllTableFontDesk(selector, div, div2){
	var rowSelect = [];

	var array = $(selector);
	for (var i = 0; i < array.length; i++) {
		var fullArray = $(array[i]).find("td");
		if(div == "tablePeople"){
			row = [
				fullArray.eq(1).text().replace(/\s+/g, " "),
				fullArray.eq(2).text().replace(/\s+/g, " "),
				fullArray.eq(3).text().replace(/\s+/g, " "),
			];
		}else{
			row = [
				fullArray.eq(0).text().replace(/\s+/g, " "),
				fullArray.eq(1).text().replace(/\s+/g, " "),
				fullArray.eq(2).text().replace(/\s+/g, " "),
				fullArray.eq(3).text().replace(/\s+/g, " "),
			];
		}
		rowSelect.push(row);
	}
	if (rowSelect.length>0) {
		tableSelectHKC(rowSelect,div, div2);
	}
}

function tableSelectHKC(rowSelect,div, div2){
	
	//$('#tablePeopleMaidSelectedHKC tbody').empty();
	var bodyHTML = '';
	    //creación del body
    for (var i = 0; i < rowSelect.length; i++) {
        bodyHTML += "<tr class='rowValid' id='PSrow" + rowSelect[i][0] + "' >";
        for (var j in rowSelect[i]) {
            bodyHTML+="<td>" + rowSelect[i][j] + "</td>";
        };
		/*if(div == "tablePeople"){
			var nameRadio = "people" + rowSelect[i][0]
			bodyHTML += "<td><div class='rdoField'><input class='typeRollHKC' attr_type='maid' value='" + rowSelect[i][0] + "' type='radio' name='" + nameRadio + "'><label for='folio'>&nbsp;</label></div></td>";
			bodyHTML += "<td><div class='rdoField'><input class='typeRollHKC' attr_type='superior' value='" + rowSelect[i][0] + "' type='radio' name='" + nameRadio + "'><label for='folio'>&nbsp;</label></div></td>";
        }*/
		bodyHTML += "<td><button type='button' class='alert button'><i class='fa fa-minus-circle fa-lg' aria-hidden='true'></i></button></td>";
        bodyHTML+="</tr>";
    }
    $("#" + div2 + " tbody").append(bodyHTML);
    deleteElementTable(div2);
}

function deselectedPeople(selector,div2){
	var idRow = $(selector).attr('id');
	$('#' + div2 + ' tbody #PS' + idRow ).remove();
}

//reducir a una funcion
function deleteElementTable(div){
	$("#"+div+" tr").on("click", "button", function(){
		$(this).closest("tr").remove();
	});
}

function addUnitDialogHKC(){
	var div = "#dialog-unit-hkConfig";	
	dialog = $(div).dialog({
		open : function (event){
			if ($(div).is(':empty')) {
				showLoading(div, true);
				$(this).load ("frontDesk/modalUnitHKConfig" , function(){
		    		showLoading(div, false);
					ajaxSelectsFrontDesk('contract/getProperties','try again', generalSelectsFront, 'propertyHKC', 'Select a propety');
	    			ajaxSelectsFrontDesk('contract/getUnitTypes','try again', generalSelectsFront, 'unitTypeHKC', 'Select a floor plan');
					$('#btnGetUnities').off();
					$('#btnGetUnities').on('click', function(){ getUnitiesHKC(0); });
					$('.comboHKC').off("change");
					$('.comboHKC').change(function(){ disableOtherComboHKC(this)});
					activatePaginador('paginationUnitHKC', getUnitiesHKC);
					selectTableFrontDesk("tblUnitHKC","tableUnitsSelectedHKC", 1);
	    		});
			}
			if( jQuery.isFunction( "markRowTableFrontDesk" ) ) {
				//markRowTableFrontDesk("tablePeople");
			}
		},
		autoOpen: false,
		height: maxHeight,
		width: "50%",
		modal: true,
		buttons: [{
			text: "Ok",
			"class": 'dialogModalButtonAccept',
			click: function() {
				$(this).dialog('close');
			}
		}],
		close: function() {
			//$('#dialog-people-hkConfig').empty();
		}
	});
	return dialog;
}

function ajaxSelectsFrontDesk(url,errorMsj, funcion, divSelect, firtOption) {
	$.ajax({
		type: "POST",
		url: url,
		dataType:'json',
		success: function(data){
			funcion(data, divSelect, firtOption);
		},
		error: function(){
			alertify.error(errorMsj);
		}
	});
}

function generalSelectsFront(data, div, firtOption){
	var select = '';
	select += '<option value="">' + firtOption + '</option>';
    for (var i = 0; i < data.length; i++) {
        select += '<option value="'+data[i].ID+'">';
        for (var j in data[i]) {
            if(data[i][j] != data[i].ID){
                select+= data[i][j].trim();
            }
        };
        select+='</option>';
    }
    $("#"+div).html(select);
}

function getUnitiesHKC(page){
	
	var options = ["",""];
	if( $('#propertyHKC option').length > 0 && $('#unitTypeHKC option').length > 0){
		options = getWords(["propertyHKC","unitTypeHKC"]);
	}
	words = getWords(["searchUnitHKC"]);
	showLoading('#table-unitsHKC',true);

	$.ajax({
		data:{
			words: words,
			options: options,
			page:page,
		},
   		type: "POST",
       	url: "frontDesk/getUnities",
		dataType:'json',
		success: function(data){
			if(data.items.length > 0){
				var total = data.total;
				paginadorFrontDesk(total,"paginationUnitHKC",page);
				drawTable2(data.items,"tblUnitHKC",false,"Edit");
				alertify.success("Found "+ total + " units");
			}else{
				noResultsTable("table-unitsHKC", "tblUnitHKC", "no results found");
			}
			showLoading('#table-unitsHKC',false);	
		},
		error: function(){
			showLoading('#table-unitsHKC',false);
			noResultsTable("table-unitsHKC", "tblUnitHKC", "Try again");
		}
    });
}

function paginadorFrontDesk(totalItems,div,page){
	var total = totalItems;
	if( parseInt(total) == 0 ){ total = 1; }
		total = parseInt( total/25 );
	if(totalItems%25 == 0){
		total = total - 1;		
	}
	total = total + 1
	if(page == 0){
		$('#' + div).val(true);
		changeIndexPaginator( div, total );
	}
}

function disableOtherComboHKC(selector){
	var value = $(selector).val();
	$('.comboHKC').val("");
	$(selector).val(value);
}

function validateHKCForm(){
	var result = true;
	hideFieldHKCForm();
	if($("#textSectionHKC").val().trim().length == 0){
		$("#textSectionHKC").addClass('error');
		$('#textSectionHKC').siblings('small').removeClass('hidden');
		result = false;
	}
	
	if($("#SltServiceTypeHKC").val() == ""){
		result = false;
		$('#SltServiceTypeHKC').parent().addClass('error');
		$('#SltServiceTypeHKC').parent().siblings('small').removeClass('hidden');
	}
	
	totalTr = $("#tablePeopleMaidSelectedHKC tbody tr.rowValid").length;
	if(totalTr != 1){
		$('#tablePeopleMaidSelectedHKC').siblings('small').removeClass('hidden');
		result = false;
	}
	
	totalTr = $("#tablePeopleSupeSelectedHKC tbody tr.rowValid").length;
	if(totalTr != 1){
		$('#tablePeopleSupeSelectedHKC').siblings('small').removeClass('hidden');
		result = false;
	}
	if( $('#unitHKConfig').is(":visible") ){
		totalTr = $("#tableUnitsSelectedHKC tbody tr.rowValid").length;
		if(totalTr != 1){
			$('#tableUnitsSelectedHKC').siblings('small').removeClass('hidden');
			result = false;
		}
	}
		
	return result;	
}

function hideFieldHKCForm(){
	$('#section-HKC').find('small').addClass('hidden');
	$('#section-HKC').find('input').removeClass('error');
	$('#section-HKC').find('.caja').removeClass('error');
}

function saveHKConfig(id){
	
	//showAlert(true,"Saving changes, please wait ....",'progressbar');
	msgFrontDesk = alertify.success('Saving changes, please wait ....', 0);
	
	var maid = $('#tablePeopleMaidSelectedHKC tbody tr').find('td').first().text().trim();
	var supervisor = $('#tablePeopleSupeSelectedHKC tbody tr').find('td').first().text().trim();
	var unit = $('#tableUnitsSelectedHKC tbody tr').find('td').first().text().trim();
	
	$.ajax({
		data:{
			id: id,
			section: $('#textSectionHKC').val(),
			serviceType: $('#SltServiceTypeHKC').val(),
			maid: maid,
			supervisor: supervisor,
			unit: unit,
		},
   		type: "POST",
       	url: "frontDesk/saveUnitHKConfig",
		dataType:'json',
		success: function(data){
			//showAlert(true,data.message,'button',showAlert);
			msgFrontDesk.dismiss();
			dialogHKConfig.dialog('close');
			getFrontDesk("",0);
		},
		error: function(){
			//showAlert(true,"Error inserting data, try again later. ",'button',showAlert);
			msgFrontDesk.dismiss();
			dialogHKConfig.dialog( 'open' );
		}
    });
}

function showModaChgStatus(){
	
	var filters = getFiltersCheckboxs('HKLookUpStatus');
	if($.isEmptyObject(filters)){
		alertify.error("Select an option on the table");
	}else{
		var chgStatusDialog = editHKStatus(filters);
		chgStatusDialog.dialog( 'open' );
	}
	
	/**/
}

function editHKStatus(filters){
	
	var div = "#dialog-edit-HKStatus";
	
	//maxHeight = screen.height * .25;
	//maxHeight = screen.height - maxHeight;
	
	dialog = $(div).dialog ({
		open : function (event){
			showLoading(div,true);
	    	$(this).load ("frontDesk/modalHKStatusDesc" , function(){
				getHKstatusLookUp(filters);
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
       		text: "Save",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
				getStatusUnit();
				$(this).dialog('close');
       		}
     	}],
		close: function() {
			$(div).empty();
		}
	});
	
	return dialog;
	
}

function getHKstatusLookUp(filters){
	var div = "#dialog-edit-HKStatus";
	showLoading(div,false);
	showLoading(div,true);
	$.ajax({
		data:{
			filters: filters,
		},
   		type: "POST",
       	url: "frontDesk/getHKstatusLookUp",
		dataType:'json',
		success: function(data){
			$('#contentHKStatus').empty();
			
			var items = data.status;
			var optionHtml = "";
			for(var i=0;i<items.length;i++){
				var item = items[i];
				optionHtml += '<option value="' + item.pkHKStatusId + '">' + item.HKStatusDesc + '</option>';
			}
			
			for(var i=0;i<data.items.length;i++){
				var item = data.items[i];
				
				var selectHtml = '<div class="caja" ><select id="txthkStatus' + item.ID + '" class="input-group-field round">';
				selectHtml += optionHtml;
				selectHtml += '</select></div>';
				
				var bodyHtml = '<div class="fieldset large-12 columns">';
				bodyHtml += '<table class="tablehkStatus" id="tablehkStatus' + item.ID + '"  width="100%">';
				bodyHtml += '<thead><tr><th>Id</th><th>Unit</th><th>HK Status</th></tr></thead>';
				bodyHtml += '<tbody>';
				bodyHtml += '<td>' + item.ID + '</td>';
				bodyHtml += '<td>' + item.UnitCode + '</td>';
				bodyHtml += '<td>' + selectHtml + '</td>';
				bodyHtml += '</tbody>';
				bodyHtml += '</table">';
				bodyHtml += '</div>';
				$('#contentHKStatus').append(bodyHtml);
				
				$('#txthkStatus' + item.ID).val(item.fkHkStatusId);
			}
			
			var div = "#dialog-edit-HKStatus";
			showLoading(div,false);
		},
		error: function(){
			alertify.error("Try, again");
			var div = "#dialog-edit-HKStatus";
			$(div).dialog('close');
		}
    });
	
}

function getStatusUnit(){
	
	//var khstatus = {};
	rowStatus = [];
	
	$(".tablehkStatus tbody tr").each(function (index){
		var idUnitStatus = 0, idStatus;
		$(this).children("td").each(function (index2) {
			switch (index2) {
				case 0:
					idUnitStatus = $(this).text();
				break;
				case 2:
					idStatus = $(this).find('select').val();
				break;
			}
		});
		var status = {pkUnitHKStatusId:idUnitStatus, fkHkStatusId:idStatus};
		//var status = {pkUnitHKStatusId:idUnitStatus, fkHkStatusId:$("#txthkStatus1").val()};
		rowStatus.push(status);
	});
	saveHKStatus(rowStatus);
	
}

function saveHKStatus(rowStatus){
	var div = "#dialog-edit-HKStatus";
	showLoading(div,true);
	$.ajax({
		data:{
			rowStatus:rowStatus
		},
   		type: "POST",
       	url: "frontDesk/saveHKStatus",
		dataType:'json',
		success: function(data){
			showLoading(div,false);
			alertify.success(data);
			getFrontDesk("",0);
		},
		error: function(){
			showLoading(div,false);
			alertify.error('Error updating data, try again later.');
		}
    });
}

function generateReportFrontDesk(){
	
	var filters = null;
	var filters2 = null;
	var dates = null;
	var words = null;
	var options = null;
	var url = "";
	var section = $('#typeSearchFrontDesk').val();
	
	if(section == "section4"){
		filters = getFiltersCheckboxs('statusHKLookUp');
		filters2 = {};
		dates = getDates(["dateHKLookUp"]);
		words = getWords(["textUnitHKConfig"]);
		options = getWords(["ServiceTypeLookUp"]);
		url = "?type=lookUp";
	}else if(section == "section5"){
		filters = getFiltersCheckboxs('checkReport');
		filters2 = $('#checkReport').prop('checked');
		dates = getDates(["dateArrivalReport"]);
		words = {};
		options = {};
		url = "?type=report";
	}
	
	filters = JSON.stringify(filters);
	filters2 = JSON.stringify(filters2);
	dates = JSON.stringify(dates);
	words = JSON.stringify(words);
	options = JSON.stringify(options);
	
	url += "&filters=" + filters;
	url += "&filters2=" + filters2;
	url += "&dates=" + dates;
	url += "&words=" + words;
	url += "&options=" + options;
	createExcel(url)
	
}

function createExcel(url){
	window.location = "frontDesk/getReportFrontDesk" + url;
}

/**************reservation*********************/

/**
* @todo muestra formulario para nueva reservacion
* @param selector objeto seleccionado del grid
*/
function showNewReservation(selector){
	var unit = $(selector).attr('unit');
	var iniDate = $(selector).attr('day');
	var unitId = $(selector).attr('unitId');
	var div = "#table-frontDesk";
	showLoading(div,true);
	
	$.ajax({
		data:{
			unitId:unitId
		},
   		type: "POST",
       	url: "frontDesk/getUnitForReservation",
		dataType:'json',
		success: function(data){
			showLoading(div,false);
			if ( data.items.length > 0 ){
				var addReservation = null;
				var unidadResDialog = addUnidadResDialog();
				addReservation = createDialogReservation(addReservation, 'alta');
				addReservation.dialog("open");
				if (unidadResDialog!=null) {
					unidadResDialog.dialog( "destroy" );
				}
				unidadResDialog = addUnidadResDialog(iniDate,data.items[0], 'alta');
				unidadResDialog.dialog( "open" );
			}else{
				alertify.error('no unit found');
			}
		},
		error: function(){
			showLoading(div,false);
			//showAlert(true,"Error to open new reservation, try again later. ",'button',showAlert);
			msgFrontDesk = alertify.success('Error to open new reservation, try again later.');
		}
    });
	
	//getUnitsReservation( unitId, day );
	
	//console.log(unitId)
	
		/*var addReservation = null;
		var unidadResDialog = addUnidadResDialog();
		addReservation = createDialogReservation(addReservation);
		addReservation.dialog("open");
		if (unidadResDialog!=null) {
			unidadResDialog.dialog( "destroy" );
		}
		unidadResDialog = addUnidadResDialog(day,unit);
		unidadResDialog.dialog( "open" );*/
}


function showReservation(selector){
	//dialogEditContract.dialog('open');
	var idRes = $(selector).attr('reservation');
	 var dialogEditReservation = modalEditReservation(idRes);
	dialogEditReservation.dialog("open");
}

function getModalNewExchangeRate(){
	var ajaxData =  {
			url: "frontDesk/modalNewExchangeRate",
			tipo: "html",
			datos: {},
			funcionExito : addHtmlExchangeRate,
			funcionError: mensajeAlertify
		};
	var modalPropiedades = {
		div: "dialog-ExchangeRate",
		altura: 480,
		width: 560,
		onOpen: ajaxDATA,
		onSave: saveExchangeRate,
		botones :[{
	       	text: "Cancel",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	       		
	         	$(this).dialog('close');
	       }
	   	},{
       		text: "Ok",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			saveExchangeRate();
       		}
     	}]
	};

	if (exchangeRate!=null) {
			exchangeRate.dialog( "destroy" );
	}
	exchangeRate = modalGeneral2(modalPropiedades, ajaxData);
	exchangeRate.dialog( "open" );
}

function addHtmlExchangeRate(data){
	$("#dialog-ExchangeRate").html(data);
	$( "#validFromEx" ).Zebra_DatePicker({
		format: 'm/d/Y',
		show_icon: false,
	});
	$('#validFromEx').val(getCurrentDate());
}

function saveExchangeRate() {
    if ($("#fromCurrency").val() == $("#toCurrency").val()) {
        alertify.error("Verify Data");
    } else {
        if ($("#fromAmount").val() && $("#toAmount").val() && $("#validFromEx").val()) {
            alertify.success("saving");
            var ajaxData = {
                url: "frontDesk/createNewExchangeRate",
                tipo: "json",
                datos: {
                    exchangeRate: getDatosExchangeRate()
                },
                funcionExito: mensajeExchangeRate,
                funcionError: mensajeAlertify
            };
            ajaxDATA(ajaxData);
        } else {
            alertify.error("fill all filds")
        }
    }
}

function getDatosExchangeRate(){
	var datos = {};
		datos.fromCurrency  = $("#fromCurrency").val();
		datos.toCurrency =  $("#toCurrency").val();
		datos.fromAmount = $("#fromAmount").val();
		datos.toAmount = $("#toAmount").val();
		datos.ValidFrom = $("#validFromEx").val();
	return datos
}

function mensajeExchangeRate(data){
	exchangeRate.dialog('close');
	if (data['mensaje']) {
		alertify.success(data["mensaje"]);
	}
	var order = '', page = 0;
	filters = {};
		dates = getDates(["dateArrivalExchange","dateDepartureExchange","textIntervalExchange"]);
		words = getWords(["textIntervalExchange"]);
		options = {};
		url = "frontDesk/getExchangeRate";
	
	
	ajaxFrontDesk( url, filters, dates, words, options, order, page );
}

function showModalAuditAddTrx(){
	var ajaxData =  {
		url: "frontDesk/modalAddTrx",
		tipo: "html",
		datos: {},
		funcionExito : addHTMLAddTrx,
		funcionError: mensajeAlertify
	};
	var modalPropiedades = {
		div: "dialog-addTransactionsAudit",
		altura: 540,
		width: 540,
		onOpen: ajaxDATA,
		botones :[{
	       	text: "Cancel",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');
	       }
	   	},{
       		text: "Add",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			var STRXS = AUDITTRX.multipleSelect('getSelects').length;
				var SRSS = getArrayValuesColumnTable("tablaAuditUnits", 1).length;
       			if (STRXS > 0 && SRSS > 0) {
       				saveTrxAudit();
       				$(this).dialog('close');
       			}else{
       				alertify.error("First Search Transactions");
       			}
       		}
     	}]
	};
	if (modalAddTrxAudit != null) {
			modalAddTrxAudit.dialog( "destroy" );
	}
	modalAddTrxAudit = modalGeneral2(modalPropiedades, ajaxData);
	modalAddTrxAudit.dialog( "open" );
}

function addHTMLAddTrx(data){
	$("#dialog-addTransactionsAudit").html(data);

}

function saveTrxAudit(){
		msgTrxAudit = alertify.success('Saving changes, please wait <i class="fa fa-spinner fa-spin fa-fw"></i>', 0);
	var TRXS = AUDITTRX.multipleSelect('getSelects');
	var TRXSTEXT = AUDITTRX.multipleSelect('getSelects', 'text');
	var RSS = getArrayValuesColumnTable("tablaAuditUnits", 1);
	var fecha = $("#DateAudit").val();
	var ajaxDatos =  {
		url: "frontDesk/createTrxAudit",
		tipo: "json",
		datos: {
			TRX: TRXS,
			TRXSTEXT: TRXSTEXT,
			RS: RSS,
			fecha: fecha
		},
		funcionExito : saveExitoTrx,
		funcionError: mensajeAlertify
	};
	ajaxDATA(ajaxDatos);
}

function saveExitoTrx(data){
	msgTrxAudit.dismiss();
	alertify.success(data.mensaje);
}

function generateReportAuditUnits(){
	filters = {};
	dates = {};
	//words = getWords(["unitAudit", "DateAudit", "DateArrival", "DateDeparture"]);
	words = getWords(["unitAudit", "DateAudit"]);
	var Seleccionado = $("#ArrivalDeparture").val();
	switch(Seleccionado) {
		case "1":
			words.DateDeparture = "";
			words.DateArrival = $("#DateAudit").val();
			break;
		case "2":
			words.DateArrival = "";
		    words.DateDeparture = $("#DateAudit").val();
		    break;
	}
	words.statusAudit = OCCSTATUS.multipleSelect('getSelects');
	words.occTypeAudit = OCCTYPE.multipleSelect('getSelects');
	options = {};
	url = "?type=report";
	dates = JSON.stringify(dates);
	words = JSON.stringify(words);
	url += "&words=" + words;
	window.open("frontDesk/getAuditUnitsReport"+ url);
	
}

function dowloadExcel(url){
	window.location = url;
}

function generateReportAuditTrx(){
	filters = {};
	dates = {};
	words = getWords(["dateAuditTRX", "userTrxAudit", "Transaction", "isAudited"]);
	options = {};
	url = "?type=report";
	for(j in words){
		url+= "&"+j+"="+words[j];
	}
	window.open("frontDesk/getAuditTrxReport"+ url);
}

function closeDAYTRX(){
	var TRXS = getArrayValuesColumnTable("tablaAuditTrx", 1);
	var ajaxDatos =  {
		url: "frontDesk/createTrxAuditById",
		tipo: "json",
		datos: {
			TRX: TRXS,
			fecha: $("#dateAuditTRX").val()
		},
		funcionExito : saveExitoTrxID,
		funcionError: mensajeAlertify
	};
	if (ajaxDatos.datos.TRX.length > 0) {
		ajaxDATA(ajaxDatos);
	}else{
		alertify.error("First Search Transactions");
	}
	
}

function saveExitoTrxID(data){
	alertify.success(data.mensaje);
}

function getArrayValuesColumnTableC(tabla, columna){
	var items= 0;
	$('#'+tabla+' tbody tr td:nth-child('+columna+')').each( function(){
		if ($(this).text().replace(/\s+/g, " ")=="") {
			items++;
		}       
	});
	return items;
}

function getCurrentDateMENOS(dias){
	var today = new Date();
	var dd = today.getDate() - dias;
	var mm = today.getMonth()+1;
	var yyyy = today.getFullYear();
	
	if(dd<10) {
		dd='0'+dd
	} 

	if(mm<10) {
		mm='0'+mm
	} 
	
	return  mm+'/'+dd+'/'+yyyy;
}

function ConvertDate(fecha){
	var today = new Date(fecha);
	var dd = today.getDate() - 1;
	var mm = today.getMonth()+1;
	var yyyy = today.getFullYear();
	
	if(dd<10) {
		dd='0'+dd
	} 

	if(mm<10) {
		mm='0'+mm
	} 
	
	return  mm+'/'+dd+'/'+yyyy;
}