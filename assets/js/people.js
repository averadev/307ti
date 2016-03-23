/**
* @fileoverview Funciones del screen people (alta)
*
* @author Alfredo Chi
* @version 0.1
*/
var dialogUser = null;
var maxHeight = 400;


/**************Index****************/

//muestra el modal de usuarios
$('#newUser').click(function(){ showModal('alta'); });
//muestra o oculta los datos del domicilio
$('#btnAddressData').click(function(){ showDivModal('address'); });
//muestra o oculta la informacion de contacto
$('#btnContactData').click(function(){ showDivModal('contact'); });

/************Funciones**************/

/**
* Carga el modal
*/
$( document ).ready(function() {
	
	//maxHeight
	maxHeight = screen.height * .25;
	maxHeight = screen.height - maxHeight;
	
	dialogUser = $( "#dialog-User" ).dialog({
		autoOpen: false,
		height: maxHeight,
		width: "50%",
		modal: true,
		dialogClass: 'dialogModal',
		buttons: [{
            text: "Aceptar",
            "class": 'dialogModalButtonAccept',
            click: function() {
                CreateNewUser()
            }
        }],
		close: function() {
		}
	});
});

/**
* muestra el modal de alta de usuario
* @param type tipo de 
*/
function showModal(type){
    dialogUser.dialog('open');
	/**/
}

/**
* muestra el modal de alta de usuario
* @param div divicion que se va a mostrar o esconder
*/
function showDivModal(div){
	if(div == "address"){
		$('#containerAddress').toggle(1000);
	}else if(div == "contact"){
		$('#containerContact').toggle(1000);
	}
}

/**
* llama a las funciones para crear un nuevo usuario 
*/
function CreateNewUser(){
	var result = validateUserFields()
	if(result){
		saveUserData(0)
	}
}

/**
* guarda la informacion del usuario
* @param id identificador del usuario / si es 0 es nuevo usuario
*/
function saveUserData(id){
	
	$.ajax({
   		type: "POST",
       	url: "people/savePeople",
		dataType:'json',
		data: { 
			id:id,
			name:$('#txtEventName').val()
		},
		success: function(data){
		},
		error: function(){
			
		}
	});
	
	
}

/**
* valida los campos de usuario
*/
function validateUserFields(){
	
	var result = true;
	var infoAddress = true;
	var infoContact = true;
	hideAlertUserFields();
	
	//Email
	if($('#textEmail1').val().trim().length == 0){
		$('#alertEmail1').addClass('error');
		$('#textEmail1').focus();
		result = false;
		infoContact = false;
	}
	//Telefono
	if($('#textPhone1').val().trim().length == 0){
		$('#alertPhone1').addClass('error');
		$('#textPhone1').focus();
		result = false;
		infoContact = false;
	}
	
	if(infoContact == false){
		$('#containerContact').show();
	}
	
	//fecha de nacimiento
	if($('#textPostalCode').val().trim().length == 0){
		$('#alertPostalCode').addClass('error');
		$('#textPostalCode').focus();
		result = false;
		infoAddress = false;
	}
	//pais
	if($('#textCountry').val().trim().length == 0){
		$('#alertCountry').addClass('error');
		$('#textCountry').focus();
		result = false;
		infoAddress = false;
	}
	//estado
	if($('#textState').val().trim().length == 0){
		$('#alertState').addClass('error');
		$('#textState').focus();
		result = false;
		infoAddress = false;
	}
	
	//Ciudad
	if($('#textCity').val().trim().length == 0){
		$('#alertCity').addClass('error');
		$('#textCity').focus();
		result = false;
		infoAddress = false;
	}
	//colonia
	if($('#textColony').val().trim().length == 0){
		$('#alertColony').addClass('error');
		$('#textColony').focus();
		result = false;
		infoAddress = false;
	}
	//calle
	if($('#textStreet').val().trim().length == 0){
		$('#alertStreet').addClass('error');
		$('#textStreet').focus();
		result = false;
		infoAddress = false;
	}
	if(infoAddress == false){
		$('#containerAddress').show();
	}
	
	//fecha de nacimiento
	if($('#textBirthdate').val().trim().length == 0){
		$('#alertBirthdate').addClass('error');
		$('#textBirthdate').focus();
		result = false;
	}
	//apellido paterno
	if($('#textLastName').val().trim().length == 0){
		$('#alertLastName').addClass('error');
		$('#textLastName').focus();
		result = false;
	}
	//nombre
	if($('#textName').val().trim().length == 0){
		$('#alertName').addClass('error');
		$('#textName').focus();
		result = false;
	}
	
	if(result == false){
		$('#alertValidateUSer').show(100);
	}
	
	return result;
}

/**
* esconde las alertas de validacion
*/
function hideAlertUserFields(){
	$('#alertValidateUSer').hide();
	
	$('#alertName').removeClass('error');
	$('#alertLastName').removeClass('error');
	$('#alertBirthdate').removeClass('error');
	
	$('#alertStreet').removeClass('error');
	$('#alertColony').removeClass('error');
	$('#alertCity').removeClass('error');
	$('#alertState').removeClass('error');
	$('#alertCountry').removeClass('error');
	$('#alertPostalCode').removeClass('error');
	
	$('#alertPhone1').removeClass('error');
	$('#alertEmail1').removeClass('error');
}