/**
* @fileoverview funciones del login
*
* @author alfredo chi
* @version 0.1
*/

var progressbar;

//$('#btnLogin').click(function(){ login(); });
$('#btnLogin').on('click',function(){ login(); });
$('#btnCloseModal').click(function(){ hideModal(); });

$('#txtUser,#txtPassword').keyup(function(e){
    if(e.keyCode ==13){
		login();	
    }
});


function login(){
	if ($('#txtUser').val().trim().length == 0
       || $('#txtPassword').val().trim().length == 0){
		   
        showMsg('El usuario y password son requeridos.');
    }else{
		$('#subModal label').html('Conectando');
		$('#modalLogin').show();
		progress(true)
        $.ajax({
            type: "POST",
            url: "login/checkLogin",
            dataType:'json',
            data: { 
                email: $('#txtUser').val(),
                password: $('#txtPassword').val()
            },
            success: function(data){
                if (data.success){
					window.location.href = URL_BASE + "Home";
                }else{
					progress(false)
					clearTimeout(timer);
					$('#progressbar').hide();
					$('#btnCloseModal').show();
					$('#subModal label').html('Acceso denegado!');
                }
            }
        });
    }
	
	//window.location="home";
}

function hideModal(){
	$('#modalLogin').hide();
	$('#progressbar').show();
	$('#btnCloseModal').hide();
	progressbar.progressbar( "value", 0 );
}

function progress(stop) {
	if(stop == undefined){ stop = true; }
	if(stop == true){
		var val = progressbar.progressbar( "value" ) || 0;
		
		progressbar.progressbar( "value", val + 2 );
 
		if ( val < 99 ) {
			
		}else{
			progressbar.progressbar( "value", 0 );
		}
		timer = setTimeout( progress, 80 );
	}
}

function showMsg(mensaje){
	$('#alertLogin').hide();
    $('#alertLogin').html(mensaje);
    $('#alertLogin').show('slow');
}

$(function() {
	progressbar = $( "#progressbar" ).progressbar({
      value: 0
    });
});