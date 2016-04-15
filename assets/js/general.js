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
            if ($(x[i]).children().html() == $(this).html()) {
                $('.tabs-title').removeClass('active');
                $(x[i]).addClass('active');
                isNew = false;
            }
        }
        // Add new tab
        if(isNew){
            $('.tabs-title').removeClass('active');
            var screen = $(this).attr('attr-screen');
            var iconClose = '<img class="iconCloseTab" src="'+BASE_URL+'assets/img/common/iconClose.png" />'
            $('.tabs').append( '<li class="tabs-title active" attr-screen="'+screen+'"><a>'+$(this).html()+'</a>'+iconClose+'</li>' );
            $(".module").addClass("moduleHide")
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
        }
    });
    // Event Close Tab
    $('.iconCloseTab').unbind( "click" );
    $('.iconCloseTab').on('click', function() {
        // Eliminos contenido 
        var tab = $(this).parent();
		//dialogUser.dialog('destroy').remove()
        $("#module-"+tab.attr("attr-screen")).remove();
        tab.remove();
		
    });
}

// Show Menu
function toggeMenu(){
    if ($('.btn-menu').hasClass('btn-menu-sel')){
        $('.general-section').css('padding', '0 30px');
        $('.menu-section').hide('slow');
        $('.btn-menu').removeClass('btn-menu-sel');
    }else{
        $('.general-section').css('padding', '0 20px 0 240px');
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
    $( "#module-"+screen ).load( BASE_URL+screen );
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
		
		var messageLoading = "Loading...";
		if(message != null){ messageLoading = message }
		var widthLoading = $(parentElement).css('width')
		var loandingElements = '<div class="divLoadingTable">' +
			'<div class="bgLoadingTable" ></div>' +
				'<div class="loadingTable" >' +
					'<div class="subLoadingTable">' +
						'<label>' + messageLoading + '</label>' +
						'<div id="progressbar"></div>' +
					'</div>' +
				'</div>' +
			'</div>';
		
		$(parentElement).prepend(loandingElements);
		
		var loading = $(parentElement).children('.divLoadingTable');
		
		/*$(loading).css('width',"100%");*/
		
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


function drawTable(data, funcion, cadena){

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
    //añadiendo los componentes a la tabla
     var body = document.getElementById("tblContratosbody");
     var head = document.getElementById("tblContratoshead");
     head.innerHTML = headHTML;
     body.innerHTML  = bodyHTML;
}

function drawTable2(data, funcion, cadena){

    var headHTML = "<th>"+cadena+"</th>";
    var bodyHTML = '';
    //creación de la cabecera
	/*for (var j in data[0]) {
        headHTML+="<th>"+j+"</th>";
    }*/
    //creación del body
    for (var i = 0; i < data.length; i++) {
        bodyHTML += "<tr>";
       	bodyHTML += '<td onclick="'+funcion+'('+data[i].ID+');"><i class="fa fa-info-circle" aria-hidden="true"></i></td>';
        for (var j in data[i]) {
            bodyHTML+="<td>" + data[i][j] + "</td>";
        };
        bodyHTML+="</tr>";
    }
    //añadiendo los componentes a la tabla
     var body = document.getElementById("bodyInvDetailed");
    // var head = document.getElementById("headInvDetailed");
   //  head.innerHTML = headHTML;
     body.innerHTML  = bodyHTML;
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