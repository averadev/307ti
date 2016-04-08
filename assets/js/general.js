// Init events
$(function() {
    // Button Dropdown Menu
    $('.btn-menu').on('click', function() {
        toggeMenu();
    });
    // Module selection
    $('.menu-sel').on('click', function() {
        // validate module exist
        var isNew = true;
        var x = document.getElementsByClassName("tabs-title");
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


