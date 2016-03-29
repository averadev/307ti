/**
* @fileoverview funciones del login
*
* @author alfredo chi
* @version 0.1
*/


$('#btnLogin').click(function(){ setTimeout ("login()", 500); });

function login(){
	window.location="home";
}

/**
* funcionalidad del efecto ripple
*/
var ripple = document.querySelectorAll('.ripple-container'); 
/*Guardamos un array con todos los botones. Para compatibilidad con navegadores 
antiguos puedes reemplazar el querySelectorAll con un getElementsByClassName*/
[].forEach.call(ripple, function(e) {
	e.addEventListener('click', function(e) {
		/*Esto se activar� cada vez que haya un click en un bot�n*/
		var offset = this.parentNode.getBoundingClientRect(); 
		//Toma los limites del padre (el padre es el <button> para 
		//los botones, o el <div> principal en la imagen
		var effect = this.querySelector('.ripple-effect'); 
		//Toma SOLO el span ripple-effect que est� dentro del boton clicado
    
		/*pageX y pageY devuelven el punto de la p�gina en el cual se hizo clic, 
		siendo el origen la esquina superior izquierda. En offset.top y offset.left 
		tenemos almacenados la distancia al origen de la esquina superior izquierda 
		del bot�n. La resta de estos elementos nos indicar� el punto en el cual se 
		hizo clic, teniendo como origen la esquina superior izquierda del bot�n*/
		effect.style.top = (e.pageY - offset.top) + "px";
		effect.style.left = (e.pageX - offset.left) + "px";

		this.classList.add('ripple-effect-animation'); //Agregamos la clase con la animaci�n

	}, false);

	/*Cuando la animaci�n finalice, se disparan eventos llamando a removeAnimation, 
	este m�todo eliminar� la clase ripple-effect-animation*/
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