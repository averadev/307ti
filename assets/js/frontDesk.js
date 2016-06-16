/**
* @fileoverview Funciones del screen frontDesk (busqueda)
* Abandona toda esperanza aquellos que entren aqui
* @author Alfredo Chi
* @version 0.1
*/

var maxHeight = 400;

var dialogEditContract = modalEditReservations();
var dialogHKConfig = modalHKConfig(0);
var peopleDialogHK = addPeopleDialogHKC("");
var unitDialogHK = addUnitDialogHKC();
var chgStatusDialog = editHKStatus();

var FloorplanFD;

/**************Index****************/

$('.searchFD').off();
$('.searchFD').on('click', function(){ $('.orderRow').removeClass("active"); getFrontDesk("",1); });

$('#orderRow').off();
$('.orderRow').on('click', function(){ orderRowFront(this); });

$('#btnCleanFrontDesk').off();
$('#btnCleanFrontDesk').on('click', function(){ cleanFilterFrontDesk(); })

$('.SectionFrontDesk').on('click', function(){ showSection($(this).val()); });

//muestra el modal para agregar
$('#newFontDesk').off();
$('#newFontDesk').on('click', function() {  showModaFrontDesk(0); });

$('#btnChgStatus').off();
$('#btnChgStatus').on('click', function() {  showModaChgStatus(); });

$('#btnHKREPORT').off();
$('#btnHKREPORT').on('click', function() {  generateReportFrontDesk(); });

$('#btnHKLUREPORT').off();
$('#btnHKLUREPORT').on('click', function() {  generateReportFrontDesk(); });

/************Funciones**************/

/**
* Carga las opciones que se inicializan cuando entran a la pagina
*/
var dateArrival = null;
var dateDeparture = null;
var dateYear = null;
var dateUnitHK = null;
var dateHKLookUp = null;

$(function() {
	
	//dateField
	datepickerZebra = $( "#dateArrivalFront, #dateDepartureFront, #dateHKConfig, #dateHKLookUp, #dateArrivalReport, #dateDepartureReport" ).Zebra_DatePicker({
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
	dateHKLookUp = $("#dateHKLookUp").data('Zebra_DatePicker');
	$('#dateArrivalFront').val("04/13/2016");
	//$('#dateHKConfig').val(getCurrentDate());
	FloorplanFD =  $('#textFloorPlanHKConfig').multipleSelect({
		width: '100%',
		placeholder: "Select a floor plan",
		selectAll: false,
		onClick: function(view) {
		},
	});
	activatePaginador('paginationHKConfig', gepPageFrontDesk);
	activatePaginador('paginationHKLookUp', gepPageFrontDesk);
});

function gepPageFrontDesk(page){
	getFrontDesk("",page)
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
	var section = $('.SectionFrontDesk:checked').val();
	if(section == "section1"){
		$('.rightPanel').remove();
		$('.panelLeft').remove();
		$('#tableFrontDesk tbody').empty();
		filters = getFiltersCheckboxs('FilterFrontDesk');
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
		dates = getDates(["dateArrivalReport","dateDepartureReport"]);
		words = {};
		options = {};
		url = "frontDesk/getHousekeepingReport";
	}
	
	ajaxFrontDesk( url, filters, dates, words, options, order, page );
}

function ajaxFrontDesk( url, filters, dates, words, options, order, page ){
	noResults('#table-frontDesk',false);
	showLoading( '#table-frontDesk', true );
	
	console.log(dates)
	
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
			console.log(data);
			var section = $('.SectionFrontDesk:checked').val();
			if(data.items.length > 0){
				switch(section) {
					case "section1":
						createTableLookUp(data);
					break;
					case "section2":
						
					break;
					case "section3":
						drawTable2(data.items,"tableHKConfiguration","showModaFrontDesk","Edit");
						paginadorFrontDesk(data.total,"paginationHKConfig",0);
						
						//alert( 'Column '+order[0][0]+' is the ordering column' );
					break;
					case "section4":
						var option = {type:"input", input:"checkbox", title:"editStatus", name:"HKLookUpStatus", id:"idStatus"};
						drawTable2( data.items,"tableHKLookUp","showModaFrontDesk","Edit", option );
						paginadorFrontDesk(data.total,"paginationHKLookUp",0);
					break;
					case "section5":
						drawTable2( data.items, "tableHKReport", false, "" );
					break;
				}
			}else{
				switch(section) {
					case "section1":
						
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
	getFrontDesk(field + " " + order,1);
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
	maxHeight = screen.height * .25;
	maxHeight = screen.height - maxHeight;
	
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
					peopleDialogHK = addPeopleDialogHKC('maid');
					peopleDialogHK.dialog( "open" );
				});
				$('#btnAddPeopleHKCSupe').off();
				$('#btnAddPeopleHKCSupe').on('click', function() { 
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

function showReservation(){
	dialogEditContract.dialog('open');
}

function showSection(section){
	if(section == "section3"){
		$('#generalPage').show();
		$('#paginationHKConfig').show();
		$('#paginationHKLookUp').hide();
	}else if(section == "section4"){
		$('#generalPage').show();
		$('#paginationHKLookUp').show();
		$('#paginationHKConfig').hide();
	}else{
		$('#generalPage').hide();
		$('#paginationHKConfig').hide();
		$('#paginationHKLookUp').hide();
	}
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
			//console.log(data);
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
	dialogHKConfig = modalHKConfig(id)
	dialogHKConfig.dialog('open');
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

function createNombreLegal(){
	/*var texto = "";
	var nombres = getArrayValuesColumnTable("tablePeopleMaidSelectedHKC", 2);
	var apellidos = getArrayValuesColumnTable("tablePeopleMaidSelectedHKC", 3);
	for (var i = 0; i < nombres.length; i++) {
		texto += nombres[i]+" "+apellidos[i];
		if (i!=nombres.length-1) {
			texto += " and ";
		}
	}
	if ($("#legalName").val()=="") {
		$("#legalName").val(texto);
	}*/
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
	
	showAlert(true,"Saving changes, please wait ....",'progressbar');
	
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
			showAlert(true,data.message,'button',showAlert);
			dialogHKConfig.dialog('close');
			getFrontDesk("",0);
		},
		error: function(){
			showAlert(true,"Error inserting data, try again later. ",'button',showAlert);
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
	
	maxHeight = screen.height * .25;
	maxHeight = screen.height - maxHeight;
	
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
			console.log(data)
			
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
		rowStatus.push(status);
	});
	//console.log(rowStatus);
	saveHKStatus(rowStatus)
	
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
			chgStatusDialog.dialog( 'close' );
			getFrontDesk("",0);
		},
		error: function(){
			showLoading(div,false);
			showAlert(true,"Error updating data, try again later. ",'button',showAlert);
			chgStatusDialog.dialog( 'close' );
		}
    });
	
}

function generateReportFrontDesk(){
	
	var filters = null;
	var dates = null;
	var words = null;
	var options = null;
	var url = "";
	var section = $('.SectionFrontDesk:checked').val();
	
	if(section == "section4"){
		filters = getFiltersCheckboxs('statusHKLookUp');
		dates = getDates(["dateHKLookUp"]);
		words = getWords(["textUnitHKConfig"]);
		options = getWords(["ServiceTypeLookUp"]);
		url = "?type=lookUp";
	}else if(section == "section5"){
		filters = getFiltersCheckboxs('checkReport');
		dates = getDates(["dateArrivalReport","dateDepartureReport"]);
		words = {};
		options = {};
		url = "?type=report";
	}
	
	filters = JSON.stringify(filters);
	dates = JSON.stringify(dates);
	words = JSON.stringify(words);
	options = JSON.stringify(options);
	
	//dates = dates.serialize()
	
	url += "&filters=" + filters;
	url += "&dates=" + dates;
	url += "&words=" + words;
	url += "&options=" + options;
	
	//console.log(url);
	//console.log(filters);
	createExcel(url)
	
}

function createExcel(url){
	
	window.location = "frontDesk/getReportFrontDesk" + url;
}