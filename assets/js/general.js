// Init events

var dialogUser = null;
var modalVendedores = null;
var modalProvisiones = null;
var modalNotas = null;
var modalNewFile = null;
var modalFin = null;
var modalAllNotes = null;
$(function() {
	
    // Button Dropdown Menu
    $('.btn-menu').on('click', function() {
        toggeMenu();
    });
    // Module selection
    $('.menu-sel').on('click', function() {
        // validate module exist
        var isNew = true;
        //var x = document.getElementsByClassName("tabs-title");
		var x = $('.top-title .tabs .tabs-title');
        for (var i = 0; i < x.length; i++) {
            if ($(x[i]).children().text().trim() == $(this).text().trim()) {
                $('.tabs-title').removeClass('active');
                $(x[i]).addClass('active');
                isNew = false;
				//cambia las opciones si el tap ya existe
				$('.tabs-title').removeClass('active');
				 $(x[i]).addClass('active');
				$(".module").addClass("moduleHide")
				$("#module-"+ $(x[i]).attr("attr-screen")).removeClass("moduleHide");
				getElementBoxActive();
            }
        }
        // Add new tab
        if(isNew){
            $('.tabs-title').removeClass('active');
            var screen = $(this).attr('attr-screen');
            var iconClose = '<img class="iconCloseTab" src="'+BASE_URL+'assets/img/common/iconClose.png" />'
			iconClose = '<span class="iconCloseTab"><i class="fa fa-close"><i></span>'
            $('.tabs').append( '<li class="tabs-title active" attr-screen="'+screen+'"><a>'+$(this).text().trim()+'</a>'+iconClose+'</li>' );
            $(".module").addClass("moduleHide");
			$('.menu-sel').removeClass('active');
			$('.menu-content').find('div[attr-screen="' + screen + '"]').addClass('active');
            addTabEvent();
            loadModule(screen);
			
        }
    });
	
	//Progressbar Alert
	progressBarAlert = $( "#progressbarAlert" ).progressbar({
      value: 0
    });
	
});

// Add event tab
function addTabEvent(){
    // Event Open Tab
    $('.tabs-title').unbind( "click" );
    $('.tabs-title').on('click', function() {
        // Validar seleccion
        if (! $(this).hasClass('active')){
            $('.tabs-title').removeClass('active');
            $(this).addClass('active');
            $(".module").addClass("moduleHide")
            $("#module-"+$(this).attr("attr-screen")).removeClass("moduleHide")
			$('.menu-sel').removeClass('active');
			var screen = $(this).attr("attr-screen");
			$('.menu-content').find('div[attr-screen="' + screen + '"]').addClass('active');
			getElementBoxActive();
        }
    });
    // Event Close Tab
    $('.iconCloseTab').unbind( "click" );
    $('.iconCloseTab').on('click', function() {
        // Eliminos contenido 
        var tab = $(this).parent();
		var screen = tab.attr("attr-screen");
		var tabParent = $(tab).parent();
		var children = $(tabParent).children();
		if(children.length > 1){
			if($(tab).attr("class") == "tabs-title active"){
				var screenBrother = null;
				var tabBrother = null;
				if($(tab).prev().attr("attr-screen") != undefined){
					tabBrother = $(tab).prev();
				}else{
					tabBrother = $(tab).next();
				}
				screenBrother = $(tabBrother).attr("attr-screen");
				$('.tabs-title').removeClass('active');
				$(tabBrother).addClass('active');
				$(".module").addClass("moduleHide")
				$("#module-"+screenBrother).removeClass("moduleHide")
				$('.menu-sel').removeClass('active');
				$('.menu-content').find('div[attr-screen="' + screenBrother + '"]').addClass('active');
			}
			//
		}else{
			$('.menu-sel').removeClass('active');
		}
		
        $("#module-"+screen).remove();
        tab.remove();
		
    });
}

// Show Menu
function toggeMenu(){
    if ($('.btn-menu').hasClass('btn-menu-sel')){
        $('.general-section').css('padding', '0 30px');
		$('.espacio ').css('margin-left', '27px')
        $('.menu-section').hide('slow');
        $('.btn-menu').removeClass('btn-menu-sel');
    }else{
        $('.general-section').css('padding', '0 20px 0 240px');
		$('.espacio ').css('margin-left', '236px');
        $('.menu-section').show('slow');
        $('.btn-menu').addClass('btn-menu-sel');
    }
}

// Show Menu
function showMenu(){
    $('.menu-section').show();
    $('.btn-menu').addClass('btn-menu-sel');
}

// Load Module
function loadModule(screen){
    $( ".general-section" ).append('<div class="module" id="module-'+screen+'"></div>');
	showLoading('#module-'+screen,true);
	$( "#module-"+screen ).load( BASE_URL+screen, function() {
		showLoading('.general-section',false);
		getElementBoxActive();
	});
}

//menu pegajoso
$(document).ready(function(){
	var altura = $('.menu-section').offset().top;
	$(window).on('scroll', function(){
		if ( $(window).scrollTop() < 91 ){
			var currentTop = altura - $(window).scrollTop()
			$('.menu-section').css('top', currentTop + "px");
		}else{
			$('.menu-section').css('top', "0px");
		}
	});
 
});

/**
* muestra una alerta en pantalla
* @param isOpen indica si la alerta se abre o cierra
* @param message mensaje que se muestra en la pantalla
* @param typeForm typo de contenido que tendra (progressbar o button)
* @param success funcion que se llama si tiene un boton aceptar si esta vacio no aparece
* @param cancel funcion que se llama si tiene un boton cancelar si esta vacio no aparece
*/
function showAlert(isOpen, message, typeForm, success, cancel){
	//isOpen = false,message = null,typeForm = null, success = null, cancel = null
	//indica si la alerta se muestra o escond
	if(isOpen){
		progressBarAlert.progressbar( "option", "value", false );
		$('.alertScreen .alertMessage .bodyAlertMessage #progressbarAlert').hide();
		$('.alertScreen .alertMessage .bodyAlertMessage button').hide();
		//indica si se mostrar un progressbar o botones
		if(typeForm == "progressbar"){
			$('.alertScreen .alertMessage .bodyAlertMessage #progressbarAlert').show();
		}else if(typeForm == "button"){
			$('.alertScreen .alertMessage .bodyAlertMessage button').show();
			if(success == null){
				$('.alertScreen .alertMessage .bodyAlertMessage .success').hide();
			}else{
				$("#btnSuccessAlertPeople").off();
				$("#btnSuccessAlertPeople").on('click',function(){
					//funcion del boton
					success();
				});
			}
			
			if(cancel == null){
				$('.alertScreen .alertMessage .bodyAlertMessage .cancel').hide();
			}else{
				$("#btnCancelAlertPeople").off();
				$("#btnCancelAlertPeople").on('click',function(){
					//funcion del boton
					cancel();
				});
			}
		}
		$('.alertScreen .alertMessage .bodyAlertMessage label').html(message);
		$('.alertScreen').show();
		/*var heightAlert = $('.alertMessage').css('height')
		alert(heightAlert)
		$('.alertMessage').css('margin-top', - heightAlert )*/
	}else{
		$('.alertScreen').hide();
		//$('.alertMessage').css('margin-top', "-55px" )
		progressBarAlert.progressbar( "option", "value", 0 );
	}
}

/**
* screen cargando
* @param isElement elemento hijo de la tabla principal
* @param isOpen indica si la alerta se abre o cierra
* @param message mensaje que se muestra en la pantalla
* @param typeForm typo de contenido que tendra (progressbar o button)
* @param success funcion que se llama si tiene un boton aceptar si esta vacio no aparece
* @param cancel funcion que se llama si tiene un boton cancelar si esta vacio no aparece
*/
function showLoading(parentElement, isOpen,message, success){
	//parentElement, isOpen = false,message = null, success = null 
	//indica si la alerta se muestra o escond
	if(isOpen){
		var messageLoading = "LOADING";
		if(message != null){ messageLoading = message }
		var widthLoading = $(parentElement).css('width')
		var loandingElements = '<div class="divLoadingTable">' +
				'<div class="loadingScreen" >' +
					'<div class="imgLoadingScreen"><img src="' + BASE_URL + 'assets/img/common/712.gif' + '" /></div> ' +
					'<label>' + messageLoading + '</label>' +
				'</div>' +
			'</div>';
		$(parentElement).prepend(loandingElements);
		var loading = $(parentElement).children('.divLoadingTable');
		
		$(loading).find("#progressbar").progressbar({
			value: false
		});
	}else{
		var loading = $(parentElement).children('.divLoadingTable');
		$(loading).remove();
		if(success != null){
			success();
		}
	}
} 


function drawTable(data, funcion, cadena, table){


    var headHTML = "<th>"+cadena+"</th>";
    var bodyHTML = '';
    //creación de la cabecera
	for (var j in data[0]) {
        headHTML+="<th>"+j+"</th>";
    }
    //creación del body
    for (var i = 0; i < data.length; i++) {
        bodyHTML += "<tr>";
       	bodyHTML += '<td class="iconEdit" onclick="'+funcion+'('+data[i].ID+');"><i class="fa fa-info-circle" aria-hidden="true"></i></td>';
        for (var j in data[i]) {
            bodyHTML+="<td>" + data[i][j] + "</td>";
        };
        bodyHTML+="</tr>";
    }
    $('#' + table + "thead" ).html(headHTML);
    $('#' + table + "tbody" ).html(bodyHTML);
    //pluginTables(table);
}

function pluginTables(table) {
    if ( $.fn.dataTable.isDataTable( '#' + table ) ) {
        var tabla = $('#' + table).DataTable();
        tabla.destroy();
    }
    $('#' + table ).DataTable({
        "scrollY": 350,
        "scrollX": true,
        "paging":   true,
        "ordering": false,
        "info":     false,
        "filter": 	false,
    });
}

function drawTable2(data, table ,funcion, cadena, option){
	if( option == undefined ){
		option = false;
	}
	if ( $.fn.dataTable.isDataTable( '#' + table ) ) {
		var tabla = $('#' + table).DataTable();
		tabla.destroy();
	}
	
	var headHTML = "<tr>";
	if(funcion != false){ 
		headHTML += "<th>"+cadena+"</th>";
	}
    var bodyHTML = '';
	
    //creación de la cabecera
	for (var j in data[0]) {
        headHTML+="<th>"+j+"</th>";
    }
	if( option != false ){
		if(option.type == "input"){
			 headHTML+="<th>"+option.title+"</th>";
		}
	}
	
	headHTML += "</tr>";
    //creación del body
    for (var i = 0; i < data.length; i++) {
        bodyHTML += "<tr id='row" + data[i].ID + "'>";
		if(funcion != false){
			bodyHTML += '<td class="iconEdit" nowrap onclick="'+funcion+'('+data[i].ID+');"><i class="fa fa-info-circle" aria-hidden="true"></i></td>';
		}
        for (var j in data[i]) {
            bodyHTML+="<td nowrap>" + data[i][j] + "</td>";
        };
		
		if( option != false ){
			if(option.type == "input"){
				var idOption = data[i].ID;
				if(typeof(option.id) != "undefined"){
					var opt = option.id;
					idOption = data[i][opt];
				}
				bodyHTML+='<td nowrap><input name="' + option.name + '" type="checkbox" id="'+idOption+'" class="' + option.name + '" value="'+idOption+'"><label>&nbsp;</label></td>';
			}
		}
		
        bodyHTML+="</tr>";
    }
	$('#' + table + " thead" ).html(headHTML);
	$('#' + table + " tbody" ).html(bodyHTML);
	
	$('#' + table ).show();
	
	var heightScroll = $('#' + table ).parents(".table").first();
	heightScroll = heightScroll.height();
	if(heightScroll == null){
		heightScroll = 250;
	}
	$('#' + table ) .on( 'order.dt',  function (event, a){
		console.log(a);
	}).DataTable({
		"scrollY": heightScroll - 50,
		"scrollX": true,
		"paging":   false,
		//"ordering": false,
		"info":     false,
		"filter": 	false,
	});
	
}

/*function drawTableInput(data, table ,funcion, cadena, input){
	
	if ( $.fn.dataTable.isDataTable( '#' + table ) ) {
		var tabla = $('#' + table).DataTable();
		tabla.destroy();
	}
	
	var headHTML = "<tr>";
	if(funcion != false){ 
		headHTML += "<th>"+cadena+"</th>";
	}
    var bodyHTML = '';
	
    //creación de la cabecera
	for (var j in data[0]) {
        headHTML+="<th>"+j+"</th>";
    }
	headHTML += "</tr>";
    //creación del body
    for (var i = 0; i < data.length; i++) {
        bodyHTML += "<tr id='row" + data[i].ID + "'>";
		if(funcion != false){
			bodyHTML += '<td class="iconEdit" nowrap onclick="'+funcion+'('+data[i].ID+');"><i class="fa fa-info-circle" aria-hidden="true"></i></td>';
		}
        for (var j in data[i]) {
            bodyHTML+="<td nowrap>" + data[i][j] + "</td>";
        };
        bodyHTML+="</tr>";
    }
	$('#' + table + " thead" ).html(headHTML);
	$('#' + table + " tbody" ).html(bodyHTML);
	
	$('#' + table ).show();
	
	var heightScroll = $('#' + table ).parents(".table").first();
	heightScroll = heightScroll.height();
	
	$('#' + table ).DataTable({
		"scrollY": heightScroll - 50,
		"scrollX": true,
		"paging":   false,
		"ordering": false,
		"info":     false,
		"filter": 	false,
	});
	
}*/

function activeTable(table){
	
	if ( $.fn.dataTable.isDataTable( '#' + table ) ) {
		var tabla = $('#' + table).DataTable();
		tabla.destroy();
	}
	
	$('#' + table ).DataTable({
		"scrollX": true,
		"paging":   false,
		"ordering": false,
		"info":     false,
		"filter": 	false,
	});
}

(function($) {
    "use strict";

    //$("[data-widget='collapse']").click(function() {
	$(document).on("click","[data-widget='collapse']", function() {
        //Find the box parent        
        var box = $(this).parents(".box").first();
		var section = $(this).parents(".section").attr('id');
		var relation = $(box).attr('relation-attr');
        //Find the body and the footer
        var bf = box.find(".box-body, .box-footer");
        if (!box.hasClass("collapsed-box")) {
            box.addClass("collapsed-box");
            bf.slideUp( function() {
				expandBox(section,relation);
			});
			
        } else {
            box.removeClass("collapsed-box");
            bf.slideDown( function() {
				expandBox(section,relation);
			});
        }
    });

})(jQuery);


function expandBox(section,relation){
	$(".module").css('height',($( window ).height() - 110) + "px");
	if(section != undefined && relation != undefined){
		var position = $('#' + relation).position();
		//var hRelation = $('#' + relation).height();
		if(position.top != undefined){
			var neHeight = ($("#" + section).height() - (position.top + 80));
			if($('#' + relation + ' .pagina').length){
				if ($('#' + relation + ' .pagina').is(':visible')){
					neHeight = neHeight - 35;
				}
				
			}
			$('#' + relation + ' .table').css('height', neHeight + "px" );
			var tableH = $('#' + relation + ' .table').find("table");
			tableH.each( function( index ) {
				idT = $(this).attr('id');
				if ( $.fn.dataTable.isDataTable( '#' + idT ) ) {
					var tabla = $('#' + idT).DataTable();
					var newHeightTable = neHeight - 50;
					$('#' + idT + '_wrapper').children('.dataTables_scroll').children('.dataTables_scrollBody').css('height', newHeightTable + "px");
					
				}
			}
    );
		}
	}
}

function noResultsTable(section, table, message){
	alertify.error(message);
	noResults('#' + section,true);
	deleteTable(table);
}

function deleteTable(table){
	if ( $.fn.dataTable.isDataTable( '#' + table ) ) {
		var tabla = $( '#' + table ).DataTable();
		tabla.destroy();
	}
	$('#' + table).hide();
}

function getWords(divs){
    words ={};
    for (var i = 0; i < divs.length; i++) {
        words[divs[i]] =  $("#"+divs[i]).val().trim();
    }
    return words;
}
function getDates(divs){
    dates ={};
    for (var i = 0; i < divs.length; i++) {
        dates[divs[i]] =  $("#"+divs[i]).val().trim();
    }
    return dates;
}

function getFiltersCheckboxs(name) {
    filters = {};
    $('input[name='+name+']:checked').each(
        function() {
            filters[$(this).val()] = $(this).val()
        }
    );
    return filters;
}

function getWordsByArray(name) {
    words = {};
	for(i=0;i<name.length;i++){
		words[name[i]] = name[i];
	}
    return words;
}

function generalSelects(data, div){
     var select = ' <option value="0">Choose an option</option>';
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

function ajaxHTML(div, url){
    if ($('#'+div).html().trim() == ""){
        $.ajax({
            url: url,
            success: function(result) {
                $('#'+div).html(result);
            }
        });
    }
}

/**
* screen collapse fieldset
* @param selector elemento el cual se quiere colapsar
* todo mustra u oculta los fieldset
*/
$(document).on('click', '.btnCollapseField', function(){ collapsableFieldset(this); });
function collapsableFieldset(selector){
	var screen = $(selector).attr('attr-screen');
	if($('#' + screen).is(':hidden')){
		$(selector).find('img').attr('src', BASE_URL + 'assets/img/common/iconCollapseUp.png');
	}else{
		$(selector).find('img').attr('src', BASE_URL + 'assets/img/common/iconCollapseDown.png');
	}
	$('#' + screen).toggle(400);
}


/**
* cambia el contenido de los modales dependiendo del tabs
* @param selector elemento el cual se va a mostrar
*/
$(document).on('click', '.tabsModal .tabs .tabs-title', function(){ changeTabs(this); });
function changeTabs(selector){
	var screen = $(selector).attr('attr-screen');
	var parentTabs = $(selector).parent().attr('id');
	$('#' + parentTabs + " .tabs-title").removeClass('active');
	$(selector).addClass('active');
	var parent = $('#' + screen).parent().attr('class');
	//$('.' + parent + ' .tab-modal').hide();
	//$('.' + parent + ' #' + screen).show();
	$('.' + parent).children('.tab-modal').hide();
	$('.' + parent).children('#' + screen).show();
}

/**
* Obtiene la fecha actual
*/
function getCurrentDate(){
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
	
	return  mm+'/'+dd+'/'+yyyy;
}

$(document).on('click', '.spanSelect', function(){ 
	$('#textViewFront').click();
});

/**
* cambia el contenido de los modales dependiendo del tabs
* @param selector elemento el cual se va a mostrar
*/
function initializeTooltips(tooltips){
	$( tooltips ).tooltip({
		track: true,
		items: "[titleCustom], [title]",
		content: function() {
			var element = $( this );
			if ( element.is( "[data-geo]" ) ) {
				var text = element.text();
				return "<img class='map' alt='" + text +
				"' src='http://maps.google.com/maps/api/staticmap?" +
				"zoom=11&size=350x350&maptype=terrain&sensor=false&center=" +
				text + "'>";
			}
			if ( element.is( "[title]" ) ) {
				return element.attr( "title" );
			}
			if ( element.is( "[titleCustom]" ) ) {
				var tips = element.attr( "titleCustom" )
				tips = JSON.parse(tips);
				var divReturn = "<div class='boxTips'>";
				divReturn += "<div class='boxTitleTips'>Information</div>";
				for (var j in tips) {
					divReturn += "<div class='boxInfoTips'>" + j + ": " + tips[j] +"</div>"
				}
				divReturn += "</div>";
				return divReturn;
			}
		}
	});
}

function drawTable3(data,titulo, table){
    var headHTML = "<td>"+titulo+"</td>";
    var bodyHTML = "";
    //creación de la cabecera
	for (var j in data[0]) {
        headHTML+="<th>"+j+"</th>";
    }
    //creación del body
    for (var i = 0; i < data.length; i++) {
        bodyHTML += "<tr>";
        bodyHTML += '<td class="iconEdit"><i class="fa fa-info-circle"></i></td>';
        for (var j in data[i]) {
            bodyHTML+="<td>" + data[i][j] + "</td>";
        };
        bodyHTML+="</tr>";
    }
    $('#' + table + "thead" ).html(headHTML);
    $('#' + table + "tbody" ).html(bodyHTML);
}

changeColor("#000000");

function changeColor(color, color2){
	$(".pr-color").css('background-color', color);
}

function noResults(parentElement, isOpen){
	//parentElement, isOpen = false
	//indica si la alerta se muestra o escond
	if(isOpen){
		var widthLoading = $(parentElement).css('width')
		var loandingElements = '<div class="divNoResults">' +
				'<div class="noResultsScreen" >' +
					'<img src="' + BASE_URL + 'assets/img/common/SIN RESULTADOS-01.png' + '" /> ' +
					'<label> Oh no! No Results. Try again. </label>' +
				'</div>' +
			'</div>';
		$(parentElement).prepend(loandingElements);
		var loading = $(parentElement).children('.divNoResults');
		
	}else{
		var loading = $(parentElement).children('.divNoResults');
		$(loading).remove();
		
	}

}

$( window ).resize(function() {
	//getElementBoxActive();
});

function getElementBoxActive(){
	$('#tab-general .tabs-title.active').each(function (index) { 
		var screen = $(this).attr("attr-screen");
		var section = $('#module-' + screen).find('.section').first();
		var box = $(section).find(".box").first();
		section = $(section).attr('id');
		var relation = $(box).attr('relation-attr');
		expandBox(section,relation);
	});
}

function activatePaginador(div, funcion){
	$('#' + div).jqPagination({
		max_page: 1,
		paged: function(page) {
			if($('#' + div).val() == true){
				$('#' + div).val(false);
			}else{
				funcion(page);
			}
		}
	});
}

function changeIndexPaginator(div, maxPage){
	$('#' + div).jqPagination('option', 'max_page', maxPage);
}

function validateCardNumber(number) {
	var regex = new RegExp("^[0-9]{16}$");
	if (!regex.test(number))
	    return false;

 	return luhnCheck(number);
 }

function luhnCheck(val) {
    var sum = 0;
    for (var i = 0; i < val.length; i++) {
        var intVal = parseInt(val.substr(i, 1));
        if (i % 2 == 0) {
            intVal *= 2;
            if (intVal > 9) {
                intVal = 1 + (intVal % 10);
            }
        }
        sum += intVal;
    }
    return (sum % 10) == 0;
}

var formatNumber = {
 separador: ",", // separador para los miles
 sepDecimal: '.', // separador para los decimales
 formatear:function (num){
	 num +='';
	 var splitStr = num.split('.');
	 var splitLeft = splitStr[0];
	 var splitRight = splitStr.length; 1 ? this.sepDecimal + splitStr[1] : '';
	 var regx = /(\d+)(\d{3})/;
	 while (regx.test(splitLeft)) {
	 	splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
	 }
	 return this.simbol + splitLeft +splitRight;
 },
 new:function(num, simbol){
 this.simbol = simbol ||'';
 return this.formatear(num);
 }
}
function number_format(amount, decimals) {

    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) 
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

    return amount_parts.join('.');
}

//var price = $("#unitPricePack").val().replace("$", "");

function errorInput(div, s){
	var segundos = s * 1000;
	$("#"+div).addClass("is-invalid-input").delay(segundos).queue(function(){
		$(this).removeClass("is-invalid-input").dequeue();
	});
}
function drawTableId(data, table){
    var bodyHTML = '';
    for (var i = 0; i < data.length; i++) {
        bodyHTML += "<tr>";
        for (var j in data[i]) {
            bodyHTML+="<td>" + data[i][j] + "</td>";
        };
        bodyHTML+="</tr>";
    }
    $('#' + table).html(bodyHTML);
}

function setHeightModal(div){
	var hTabs = $('#' + div + ' .contentModalHeader').height();
	var hContent = $('#' + div + ' .contentModal').height();
	$('#' + div + ' .contentModal').css('height', ( hContent - (hTabs) + 25 ));
}