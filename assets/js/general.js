// Init events

var dialogUser = null;

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
			//console.log($($(tab)).prev().attr("attr-screen"));
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
		$('.espacio ').css('margin-left', '0px')
        $('.menu-section').hide('slow');
        $('.btn-menu').removeClass('btn-menu-sel');
    }else{
        $('.general-section').css('padding', '0 20px 0 240px');
		$('.espacio ').css('margin-left', '220px');
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
function showAlert(isOpen = false,message = null,typeForm = null, success = null, cancel = null){
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
function showLoading(parentElement, isOpen = false,message = null, success = null ){
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
       	bodyHTML += '<td onclick="'+funcion+'('+data[i].ID+');"><i class="fa fa-info-circle" aria-hidden="true"></i></td>';
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

function drawTable2(data, table ,funcion, cadena){

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
        bodyHTML += "<tr>";
		if(funcion != false){
			bodyHTML += '<td nowrap onclick="'+funcion+'('+data[i].ID+');"><i class="fa fa-info-circle" aria-hidden="true"></i></td>';
		}
        for (var j in data[i]) {
            bodyHTML+="<td nowrap>" + data[i][j] + "</td>";
        };
        bodyHTML+="</tr>";
    }
	$('#' + table + " thead" ).html(headHTML);
	$('#' + table + " tbody" ).html(bodyHTML);
	
	$('#' + table ).show();
	
	$('#' + table ).DataTable({
		"scrollY": 350,
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
        //Find the body and the footer
        var bf = box.find(".box-body, .box-footer");
        if (!box.hasClass("collapsed-box")) {
            box.addClass("collapsed-box");
            bf.slideUp();
        } else {
            box.removeClass("collapsed-box");
            bf.slideDown();
        }
    });

})(jQuery);


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

function generalSelects(data, div){
    var select = '';
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
					console.log()
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
        bodyHTML += '<td><i class="fa fa-info-circle"></i></td>';
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

function noResults(parentElement, isOpen = false ){
	/*if(!isOpen){
		isOpen = false;
	}*/
	//indica si la alerta se muestra o escond
	if(isOpen){
		var widthLoading = $(parentElement).css('width')
		var loandingElements = '<div class="divNoResults">' +
				'<div class="noResultsScreen" >' +
					'<img src="' + BASE_URL + 'assets/img/common/no-results.jpg' + '" /> ' +
				'</div>' +
			'</div>';
		$(parentElement).prepend(loandingElements);
		var loading = $(parentElement).children('.divNoResults');
		
	}else{
		var loading = $(parentElement).children('.divNoResults');
		$(loading).remove();
		
	}

}