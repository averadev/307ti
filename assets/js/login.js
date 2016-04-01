/**
* @fileoverview funciones del login
*
* @author alfredo chi
* @version 0.1
*/

var progressbar;

$('#btnLogin').click(function(){ login(); });
$('#btnCloseModal').click(function(){ hideModal(); });

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

function progress(stop = true) {
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


/**
* funcionalidad del efecto ripple
*/
var ripple = document.querySelectorAll('.ripple-container'); 
/*Guardamos un array con todos los botones. Para compatibilidad con navegadores 
antiguos puedes reemplazar el querySelectorAll con un getElementsByClassName*/
[].forEach.call(ripple, function(e) {
	e.addEventListener('click', function(e) {
		/*Esto se activará cada vez que haya un click en un botón*/
		var offset = this.parentNode.getBoundingClientRect(); 
		//Toma los limites del padre (el padre es el <button> para 
		//los botones, o el <div> principal en la imagen
		var effect = this.querySelector('.ripple-effect'); 
		//Toma SOLO el span ripple-effect que está dentro del boton clicado
    
		/*pageX y pageY devuelven el punto de la página en el cual se hizo clic, 
		siendo el origen la esquina superior izquierda. En offset.top y offset.left 
		tenemos almacenados la distancia al origen de la esquina superior izquierda 
		del botón. La resta de estos elementos nos indicará el punto en el cual se 
		hizo clic, teniendo como origen la esquina superior izquierda del botón*/
		effect.style.top = (e.pageY - offset.top) + "px";
		effect.style.left = (e.pageX - offset.left) + "px";

		this.classList.add('ripple-effect-animation'); //Agregamos la clase con la animación

	}, false);

	/*Cuando la animación finalice, se disparan eventos llamando a removeAnimation, 
	este método eliminará la clase ripple-effect-animation*/
	e.addEventListener('animationend', removeAnimation);
	e.addEventListener('webkitAnimationEnd', removeAnimation);
	e.addEventListener('oanimationend', removeAnimation);
	e.addEventListener('MSAnimationEnd', removeAnimation);
});

function removeAnimation() {
  if (this.classList) {
    this.classList.remove('ripple-effect-animation');
  } else {
    this.className = this.className.replace(new RegExp('(^|\\b)' + 'ripple-effect-animation'.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
  }
}