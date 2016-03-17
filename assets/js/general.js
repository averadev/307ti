// Init events
$(function() {
    // Boton Menu Desplegable
    $('.btn-menu').on('click', function() {
        toggeMenu();
    });
    // Seleccion Modulo
    $('.menu-sel').on('click', function() {
        // Valida si existe modulo
        var isNew = true;
        var x = document.getElementsByClassName("tab-title");
        for (var i = 0; i < x.length; i++) {
            console.log($(x[i]).children().html());
            if ($(x[i]).children().html() == $(this).html()) {
                $('.tab-title').removeClass('active');
                $(x[i]).addClass('active');
                isNew = false;
            }
        }
        // Agrega nuevo tab
        if(isNew){
            $('.tab-title').removeClass('active');
            var iconClose = '<img class="iconCloseTab" src="'+BASE_URL+'assets/img/common/iconClose.png" />'
            $('.tabs').append( '<li class="tab-title active"><a>'+$(this).html()+'</a>'+iconClose+'</li>' );
            addTabEvent();
        }
    });
});

// Agregar evento Tab
function addTabEvent(){
    // Evento Open Tab
    $('.tab-title').unbind( "click" );
    $('.tab-title').on('click', function() {
        // Validar seleccion
        if (! $(this).hasClass('active')){
            $('.tab-title').removeClass('active');
            $(this).addClass('active');
        }
    });
    // Evento Close Tab
    $('.iconCloseTab').unbind( "click" );
    $('.iconCloseTab').on('click', function() {
        // Validar seleccion
        $(this).parent().remove();
    });
}

// Show Menu
function toggeMenu(){
    if ($('.btn-menu').hasClass('btn-menu-sel')){
        $('.menu-section').hide('slow');
        $('.btn-menu').removeClass('btn-menu-sel');
    }else{
        $('.menu-section').show('slow');
        $('.btn-menu').addClass('btn-menu-sel');
    }
}

// Show Menu
function showMenu(){
    $('.menu-section').show();
    $('.btn-menu').addClass('btn-menu-sel');
}