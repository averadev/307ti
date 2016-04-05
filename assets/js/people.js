/**
* @fileoverview Funciones del screen people (alta/busqueda)
*
* @author Alfredo Chi
* @version 0.1
*/
var dialogUser = null;
var maxHeight = 400;
isSearch = true;
var xhrPeople
var idPeople = 0;

/**************Index****************/

//muestra el modal de usuarios
$('#newUser').click(function(){ showModal(0); });
//esconde el modal de usuarios
//$('.imgCloseModal').click(function(){ hideModal(); });
//$(".imgCloseModal").button().on( "click", function() { hideModal(); });
$(document).on('click','.imgCloseModal', function(){ hideModal(); });

//muestra o oculta los datos del domicilio
//$(document).on('click','.btnAddressData', function(){ showDivModal('address'); });
$('.btnAddressData').on('click', function(){ showDivModal('address'); });
//muestra o oculta la informacion de contacto
//$(document).on('click','.btnContactData', function(){ showDivModal('contact'); });
$('.btnContactData').on('click', function(){ showDivModal('contact'); });


//busqueda de usuarios
$('#btnSearch').click(function(){ searchPeople(0); });
//busqueda de usuarios mediante enter
$('#txtSearch').keyup(function(e){
    if(e.keyCode ==13){
		searchPeople(0);	
    }
});
//limpia el campo busqueda
$('#btnCleanSearch').click(function(){ CleandFieldSearch(); });
//muestra u oculta la busqueda avanzada
$('#checkFilterAdvance').click(function(){ searchAdvanced(); });

//editar persomas
// revisar busqueda de personas :)


//$(document).off( "click", ".iconEdit" );

//activa los tap del modal
//$('#tabsModalPeople .tabs .tab-title').unbind( "click" );
$('#tabsModalPeople .tabs .tab-title').on('click', function() { changeTabsModalPeople($(this).attr('attr-screen')) });

/************Funciones**************/

/**
* Carga el modal
*/
$(function() {
	
	//maxHeight
	maxHeight = screen.height * .25;
	maxHeight = screen.height - maxHeight;
	
	dialogUser = $( "#dialog-User" ).dialog({
		autoOpen: false,
		height: maxHeight,
		width: "50%",
		modal: true,
		dialogClass: 'dialogModal',
		buttons: [
			{
				text: "Cancelar",
				"class": 'dialogModalButtonCancel',
				click: function() {
					dialogUser.dialog('close');
					cleanUserFields();
					//$('.ui-dialog-titlebar').empty();
					//dialogUser.dialog('destroy');
				}
			},
			{
				text: "Guardar y cerrar",
				"class": 'dialogModalButtonAccept',
				click: function() {
					if($("#idPeople").data("pkPeopleId") == undefined || $("#idPeople").data("pkPeopleId") == 0 ){
						CreateNewUser(false)
					}else{
						EditUser(false, $("#idPeople").data("pkPeopleId") )
					}
				}
			},
			{
				text: "Guardar",
				"class": 'dialogModalButtonAccept',
				click: function() {
					//$("#idPeople").data("pkPeopleId",item.pkPeopleId);
					if($("#idPeople").data("pkPeopleId") == undefined || $("#idPeople").data("pkPeopleId") == 0 ){
						CreateNewUser(true)
					}else{
						EditUser(true, $("#idPeople").data("pkPeopleId") )
					}
					
				}
			},
		],
		close: function() {
			cleanUserFields();
			//$('.ui-dialog-titlebar').empty();
		}
	});
	
	$( "#progressbar" ).progressbar({
      value: false
    });
	
	$( "#progressbarAlert" ).progressbar({
      value: false
    });
	
	
	$('#paginationPeople').jqPagination({
		max_page: 1,
		paged: function(page) {
			if($('#paginationPeople').val() == true){
				$('#paginationPeople').val(false);
			}else{
				searchPeople(page);
			}
		}
	});
	
	//$( "#tabs" ).tabs();
	
});

/**
* muestra el modal de personas
* @param id id de la persona
*/
function showModal(id){
	$("#idPeople").removeData("pkPeopleId");
	cleanUserFields();
	if(id == 0){
		$("#tabsModalPeople").hide();
		dialogUser.dialog('open');
		$('.ui-dialog-titlebar').append(
			'<div class="ui-dialog-titlebar2"><label>Alta de personas</label></div><img class="imgCloseModal" src="' + BASE_URL+'assets/img/common/iconClose2.png">'
		)
	}else{
		$("#tabsModalPeople").show();
		getInfoPeople(id);
	}
	/**/
}

/**
*esconde
*/
function hideModal(){
	cleanUserFields();
    dialogUser.dialog('close');
	//$('.ui-dialog-titlebar').empty();
	/**/
}

/**
* muestra el modal de alta de usuario
* @param div divicion que se va a mostrar o esconder
*/
function showDivModal(div){
	if(div == "address"){
		$('.containerAddress').toggle(1000);
		if($("#imgCoppapseAddress").attr('class') == "imgCollapseFieldset down"){
			$("#imgCoppapseAddress").removeClass('down');
			$("#imgCoppapseAddress").addClass('up');
			$("#imgCoppapseAddress").attr( 'src', BASE_URL+'assets/img/common/iconCollapseUp.png' )
		}else{
			$("#imgCoppapseAddress").removeClass('up');
			$("#imgCoppapseAddress").addClass('down');
			$("#imgCoppapseAddress").attr( 'src', BASE_URL+'assets/img/common/iconCollapseDown.png' )
		}
	}else if(div == "contact"){
		$('#containerContact').toggle(1000);
		if($("#imgCoppapseContact").attr('class') == "imgCollapseFieldset down"){
			$("#imgCoppapseContact").removeClass('down');
			$("#imgCoppapseContact").addClass('up');
			$("#imgCoppapseContact").attr( 'src', BASE_URL+'assets/img/common/iconCollapseUp.png' )
		}else{
			$("#imgCoppapseContact").removeClass('up');
			$("#imgCoppapseContact").addClass('down');
			$("#imgCoppapseContact").attr( 'src', BASE_URL+'assets/img/common/iconCollapseDown.png' )
		}
	}
}

/**
* llama a las funciones para crear un nuevo usuario 
* @param isClosed indica si el modal se mantendra abierto cuando se guarde la info
*/
function CreateNewUser(isClosed){
	var result = validateUserFields()
	if(result){
		saveUserData(0,isClosed)
	}
}

/**
* llama a las funciones para editar un usuario 
* @param isClosed indica si el modal se mantendra abierto cuando se guarde la info
* @param idPeople identificador de la persona a editar
*/
function EditUser(isClosed, idPeople){
	var result = validateUserFields()
	if(result){
		saveUserData(idPeople,isClosed)
	}
}

/**
* guarda la informacion del usuario
* @param id identificador del usuario / si es 0 es nuevo usuario
* @param isClosed indica si el modal se mantendra abierto cuando se guarde la info
*/
function saveUserData(id, isClosed){
	
	showAlertPeople(true,"Guardando cambios, porfavor espere....",'progressbar');
	
	var phoneArray = new Array();
	$(".phonePeople").each(function (index){
		if($(this).val().trim().length != 0){
			phoneArray.push($(this).val().trim());
		}
	});
	var jsonPhone = JSON.stringify(phoneArray);
	
	var emailArray = new Array();
	$(".emailPeople").each(function (index){
		if($(this).val().trim().length != 0){
			emailArray.push($(this).val().trim());
		}
	});
	var jsonEmail = JSON.stringify(emailArray);
	
	var gender;
	
	if($("#RadioMale").is(':checked')) {
		gender = "M";
	}else{
		gender = "F";
	}
	
	$.ajax({
   		type: "POST",
       	url: "people/savePeople",
		dataType:'json',
		data: { 
			id:id,
			name:$('#textName').val().trim(),
			SecondName:$('#textMiddleName').val().trim(),
			lName:$('#textLastName').val().trim(),
			lName2:$('#TextSecondLastName').val().trim(),
			birthDate:$('#textBirthdate').val().trim(),
			gender:gender,
			WeddingAnniversary:$('#textWeddingAnniversary').val().trim(),
			nationality:$('#textNationality').val().trim(),
			street:$('#textStreet').val().trim(),
			colony:$('#textColony').val().trim(),
			city:$('#textCity').val().trim(),
			state:$('#textState').val().trim(),
			country:$('#textCountry').val().trim(),
			postalCode:$('#textPostalCode').val().trim(),
			stateCode:$('#textState option:selected').attr('code'),
			countryCode:$('#textCountry option:selected').attr('code'),
			phone:jsonPhone,
			email:jsonEmail,
		},
		success: function(data){
			showAlertPeople(true,data,'button',showAlertPeople);
			if(!isClosed){
				dialogUser.dialog('close');
				cleanUserFields();
				$("#idPeople").removeData("pkPeopleId");
			}
			if($('#tablePeople >tbody >tr').length != 0){
				var currentPage = $('#paginationPeople').jqPagination('option', 'current_page');
				searchPeople(currentPage);
			}
			
		},
		error: function(){
			showAlertPeople(true,"error al insertar los datos, intentelo mas tarde.",'button',showAlertPeople);
			dialogUser.dialog('close');
			cleanUserFields();
			$("#idPeople").removeData("pkPeopleId");
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
	var infoPeople = true;
	var errorText = "";
	hideAlertUserFields();
	
	var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
	//email 2
	if($('#textEmail2').val().trim().length > 0){
		if(!regex.test($('#textEmail2').val().trim())){
			$('#alertEmail2').addClass('error');
			$('#textEmail2').focus();
			errorText = "El correo 2 debe ser valido<br>"  + errorText;
			infoContact = false;
		}
	}
	
	//Email
	if($('#textEmail1').val().trim().length == 0){
		$('#alertEmail1').addClass('error');
		$('#textEmail1').focus();
		errorText = "Correo<br>"  + errorText;
		infoContact = false;
	}else if(!regex.test($('#textEmail1').val().trim())){
		$('#alertEmail1').addClass('error');
		$('#textEmail1').focus();
		errorText = "EL correo debe ser valido</br>"  + errorText;
		infoContact = false;
    }
	
	//Telefono 3
	if($('#textPhone3').val().trim().length > 0 && $('#textPhone3').val().trim().length > 7 ){
		$('#alertPhone3').addClass('error');
		$('#textPhone3').focus();
		errorText = "El telefono 3 debe tener maximo 7 caracteres<br>"  + errorText;
		infoContact = false;
	}
	
	//Telefono 2
	if($('#textPhone2').val().trim().length > 0 && $('#textPhone2').val().trim().length > 7 ){
		$('#alertPhone2').addClass('error');
		$('#textPhone2').focus();
		errorText = "El telefono 2 debe tener maximo 7 caracteres<br>"  + errorText;
		infoContact = false;
	}
	
	//Telefono
	if($('#textPhone1').val().trim().length == 0){
		$('#alertPhone1').addClass('error');
		$('#textPhone1').focus();
		errorText = "Telefono<br>"  + errorText;
		infoContact = false;
	}
	if($('#textPhone1').val().trim().length > 7){
		$('#alertPhone1').addClass('error');
		$('#textPhone1').focus();
		errorText = "El telefono debe tener maximo 7 caracteres<br>"  + errorText;
		infoContact = false;
	}
	
	if(infoContact == false){
		
		result = false;
		$('#alertValPeopleContact .alert-box').html("<label>Por favor rellene los campos Obligatorios(rojo)</label>" + errorText );
		$('#alertValPeopleContact').show(100);
		$('#containerContact').show();
	}
	
	errorText = "";
	
	//fecha de nacimiento
	if($('#textPostalCode').val().trim().length == 0){
		$('#alertPostalCode').addClass('error');
		$('#textPostalCode').focus();
		errorText = "Codigo postal<br>"  + errorText;
		infoAddress = false;
	}
	
	//Ciudad
	if($('#textCity').val().trim().length == 0){
		$('#alertCity').addClass('error');
		$('#textCity').focus();
		errorText = "Ciudad<br>"  + errorText;
		infoAddress = false;
	}
	//colonia
	if($('#textColony').val().trim().length == 0){
		$('#alertColony').addClass('error');
		$('#textColony').focus();
		errorText = "Colonia<br>"  + errorText;
		infoAddress = false;
	}
	//calle
	if($('#textStreet').val().trim().length == 0){
		$('#alertStreet').addClass('error');
		$('#textStreet').focus();
		errorText = "Calle<br>"  + errorText;
		infoAddress = false;
	}
	if(infoAddress == false){
		result = false;
		$('#alertValPeopleAddress .alert-box').html("<label>Por favor rellene los campos Obligatorios(rojo)</label>" + errorText );
		$('#alertValPeopleAddress').show(100);
		$('.containerAddress').show();
	}
	
	errorText = "";
	
	//fecha de nacimiento
	if($('#textBirthdate').val().trim().length == 0){
		$('#alertBirthdate').addClass('error');
		$('#textBirthdate').focus();
		errorText = "Fecha de nacimiento<br>"  + errorText;
		infoPeople = false;
	}
	//genero
	var gender = 0;
	$(".RadioGender").each(function (index){
		if(!$(this).is(':checked')) {
			gender = gender + 1;
        } 
	});
	
	if(gender != 1){
		console.log(gender)
		$('#alertGender').addClass('error');
		errorText = "Genero<br>"  + errorText;
		infoPeople = false;
	}
	
	//apellido paterno
	if($('#textLastName').val().trim().length == 0){
		$('#alertLastName').addClass('error');
		$('#textLastName').focus();
		errorText = "Apellido paterno<br>"  + errorText;
		infoPeople = false;
	}
	//nombre
	if($('#textName').val().trim().length == 0){
		$('#alertName').addClass('error');
		$('#textName').focus();
		errorText =  "Nombre<br>" + errorText;
		infoPeople = false;
	}
	
	if(infoPeople == false){
		$('#alertValPeopleGeneral .alert-box').html("<label>Por favor rellene los campos Obligatorios(rojo)</label>" + errorText );
		$('#alertValPeopleGeneral').show(100);
		result = false;
	}
	
	return result;
}

/**
* esconde las alertas de validacion
*/
function hideAlertUserFields(){
	$('#alertValPeopleGeneral').hide();
	$('#alertValPeopleAddress').hide();
	$('#alertValPeopleContact').hide();
	
	$('#alertName').removeClass('error');
	$('#alertLastName').removeClass('error');
	$('#alertBirthdate').removeClass('error');
	$('#alertGender').removeClass('error');
	
	$('#alertStreet').removeClass('error');
	$('#alertColony').removeClass('error');
	$('#alertCity').removeClass('error');
	$('#alertCountry').removeClass('error');
	$('#alertPostalCode').removeClass('error');
	
	$('#alertPhone1').removeClass('error');
	$('#alertPhone2').removeClass('error');
	$('#alertPhone3').removeClass('error');
	$('#alertEmail1').removeClass('error');
	$('#alertEmail2').removeClass('error');
}

/**
* limpia los campos de people
*/
function cleanUserFields(){
	hideAlertUserFields();
	$('#textName').val("");
	$('#textLastName').val("");
	$('#TextSecondLastName').val("");
	$('#textBirthdate').val("");
	$('#textWeddingAnniversary').val("");
	//$('#textNationality').val("");
	$('#textQualification').val("");
	$('#RadioMale').prop( "checked", false );
	$("#RadioFemale").prop( "checked", false );
	
	$('#textStreet').val("");
	$('#textColony').val("");
	$('#textCity').val("");
	////$('#textCountry option[value=0]').attr('selected', 'selected');
	//$('#textState option[value=0]').attr('selected', 'selected');
	$("select#textCountry").val("0");
	$("select#textState").val("0");
	$('#textPostalCode').val("");
	
	$('#textPhone1').val("");
	$('#textPhone2').val("");
	$('#textPhone3').val("");
	$('#textEmail1').val("");
	$('#textEmail2').val("");
	
}

//////
/**
* genera una busqueda de usuarios filtrado
* @param page nueva pagina a buscar/ si es 0 es una busqueda nueva
*/
function searchPeople(page){
	$('#tablePeople tbody').empty();
	$('.divLoadingTable').show();
	
	/*if(xhrPeople && xhrPeople.readyState != 4) { 
		xhrPeople.abort();
		xhrPeople = null;
	}*/
	
	//if($('#checkFilterAdvance').val())
	//console.log($('.RadioSearchPeople:checked').val());
	opcionAdvanced = "";
	if($('#checkFilterAdvance').is(':checked')){
		opcionAdvanced = $('.RadioSearchPeople:checked').val();
	}
	
	$.ajax({
   		type: "POST",
       	url: "people/getPeopleBySearch",
		dataType:'json',
		data: {
			search:$("#txtSearch").val().trim(),
			peopleId:$("#checkFilter1").is(':checked'),
			lastName:$("#checkFilter2").is(':checked'),
			name:$("#checkFilter3").is(':checked'),
			advanced:opcionAdvanced,
			page:page,
		},
		success: function(data){
			var total = data.total;
			if( parseInt(total) == 0 ){ total = 1; }
			total = parseInt( total/10 );
			if(data.total%10 == 0){
				total = total - 1;		
			}
			total = total + 1
			if(page == 0){
				$('#paginationPeople').val(true);
				loadPaginatorPeople( total );
			}
			for(i=0;i<data.items.length;i++){
				var item = data.items[i];
				$('#tablePeople tbody').append(
					'<tr>' +
						'<td class="cellEdit"><img class="iconEdit" value="' + item.pkPeopleId +'" src="' + BASE_URL+ 'assets/img/common/editIcon2.png"/></td>' +
						'<td>' + item.pkPeopleId + '</td>' +
						'<td>' + item.Name + '</td>' +
						'<td>' + item.LName + " " + item.LName2 + '</td>' +
						'<td>' + item.Gender + '</td>' +
						'<td>' + item.birthdate + '</td>' +
						'<td>' + item.Street1 + '</td>' +
						'<td>' + item.City + '</td>' +
						'<td>' + item.StateDesc + '</td>' +
						'<td>' + item.CountryDesc + '</td>' +
						'<td>' + item.ZipCode + '</td>' +
						'<td>' + item.phone1 + '</td>' +
						'<td>' + item.phone2 + '</td>' +
						'<td>' + item.phone3 + '</td>' +
						'<td>' + item.email1 + '</td>' +
						'<td>' + item.email2 + '</td>' +
					'</tr>'
				);
			}
			
			//$('.iconEdit').on()
			$("#tablePeople tbody tr .cellEdit .iconEdit").off( "click", ".iconEdit" );
			$("#tablePeople tbody tr .cellEdit .iconEdit").on("click", function(){ showModal($(this).attr('value')); });
			$('.divLoadingTable').hide();
		},
		error: function(error){
			console.log(error)
			$('.divLoadingTable').hide();
			showAlertPeople(true,"Error en la busqueda, intentelo mas tarde.",'button',showAlertPeople);
		}
	});	
}

/**
* Limpia el campo de busqueda de personas
*/
function CleandFieldSearch(){
	$("#txtSearch").val("");
}

/**
* muestra las busquedas avanzadas
*/
function searchAdvanced(){
	$('#containerFilterAdv').toggle(1000);
	if($("#checkFilterAdvance").is(':checked')) {
		$('#fieldsetFilterAdvanced').removeClass('fieldsetFilter-advanced-hide');
		$('#fieldsetFilterAdvanced').addClass('fieldsetFilter-advanced-show');
	}else{
		$('#fieldsetFilterAdvanced').addClass('fieldsetFilter-advanced-hide');
		$('#fieldsetFilterAdvanced').removeClass('fieldsetFilter-advanced-show');
	}
}

/**
 * Carga el paginador
 */
function loadPaginatorPeople(maxPage){
	$('#paginationPeople').jqPagination('option', 'max_page', maxPage);
}

/**
 * CObtiene la informacion de una persona por identificador
 * @param id identificador de persona a buscar
 */
function getInfoPeople(id){
	$('.divLoadingTable').show();
	$.ajax({
   		type: "POST",
       	url: "people/getPeopleById",
		dataType:'json',
		data: {
			id:id,
		},
		success: function(data){
			console.log(data[0]);
			var item = data[0];
			$('#textName').val(item.Name.trim());
			$('#textMiddleName').val(item.SecondName.trim());
			$('#textLastName').val(item.LName.trim());
			$('#TextSecondLastName').val(item.LName2.trim());
			
			if(item.Gender == "M"){
				$('#RadioMale').prop("checked", true);
			}else if(item.Gender == "F"){
				$("#RadioFemale").prop("checked", true);
			}
			$('#textBirthdate').val(convertToDateFormat(item.BirthDayDay, item.BirthDayMonth, item.BirthDayYear ));
			$('#textStreet').val(item.Street1.trim());
			$('#textColony').val(item.Street2.trim());
			$('#textCity').val(item.City.trim());
			$('#textPostalCode').val(item.ZipCode.trim());
			if(item.pkCountryId != null || item.pkCountryId != ""){
				$("select#textCountry").val(item.pkCountryId);
			}else{
				$("select#textCountry").val(0);
			}
			if(item.pkStateId != null || item.pkStateId != ""){
				$("select#textState").val(item.pkStateId);
			}else{
				$("select#textState").val(0);
			}
			
			$('#textPhone1').val(item.phone1.trim());
			$('#textPhone2').val(item.phone2.trim());
			$('#textPhone3').val(item.phone3.trim());
			$('#textEmail1').val(item.email1.trim());
			$('#textEmail2').val(item.email2.trim());
				
			//$('#idPeople').val(item.pkPeopleId);
			$("#idPeople").data("pkPeopleId",item.pkPeopleId);
			//$('#textState').val("");
			//$('#textCountry').val("");
			$('.ui-dialog-titlebar').append(
				'<div class="ui-dialog-titlebar2"><label>Alta de personas</label></div><img class="imgCloseModal" src="' + BASE_URL+	'assets/img/common/iconClose2.png">'
			)
			dialogUser.dialog( 'open' )
			$('.divLoadingTable').hide();
		},
		error: function(error){
			console.log(error)
			$('.divLoadingTable').hide();
			showAlertPeople(true,"Error en la busqueda, intentelo mas tarde.",'button',showAlertPeople);
		}
	});	
	
}

 /*
 * Convierte a una fecha aceptable para los input date
 * @param id identificador de persona a buscar
 */
function convertToDateFormat( dd, mm, yy ){
	if(parseInt(dd) < 9){
		dd = "0" + dd;
	}
	if(parseInt(mm) < 9){
		mm = "0" + mm;
	}
	return yy + "-" + mm + "-" + dd;
}

/**
 * cambia los pantallas del modal con los tabs
 * @param screen divicion que se va a mostrar en el modal
 */
function changeTabsModalPeople(screen){
	//asigna la clase active
	$('#tabsModalPeople .tabs .tab-title').removeClass('active');
	$('#tabsModalPeople .tabs li[attr-screen=' + screen + ']').addClass('active');
	//muestra la pantalla selecionada
	$('#contentModalPeople .tab-modal').hide();
	$('#' + screen).show();
}

/**
* muestra una alerta al usuario
* @param isOpen indica si la alerta se abre o cierra
* @param message mensaje que se muestra en la pantalla
* @param typeForm typo de contenido que tendra (progressbar o button)
* @param success funcion que se llama si tiene un boton aceptar si esta vacio no aparece
* @param cancel funcion que se llama si tiene un boton cancelar si esta vacio no aparece
*/
function showAlertPeople(isOpen = false,message = null,typeForm = null, success = null, cancel = null){
	if(isOpen){
		$('#alertPeople .alertMessage .bodyAlertMessage #progressbarAlert').hide();
		$('#alertPeople .alertMessage .bodyAlertMessage button').hide();
		if(typeForm == "progressbar"){
			$('#alertPeople .alertMessage .bodyAlertMessage #progressbarAlert').show();
		}else if(typeForm == "button"){
			$('#alertPeople .alertMessage .bodyAlertMessage button').show();
			if(success == null){
				$('#alertPeople .alertMessage .bodyAlertMessage .success').hide();
			}else{
				$("#btnSuccessAlertPeople").off();
				$("#btnSuccessAlertPeople").on('click',function(){
					success();
				});
			}
			
			if(cancel == null){
				$('#alertPeople .alertMessage .bodyAlertMessage .cancel').hide();
			}else{
				$("#btnCancelAlertPeople").off();
				$("#btnCancelAlertPeople").on('click',function(){
					cancel();
				});
			}
		}
		$('#alertPeople .alertMessage .bodyAlertMessage label').html(message);
		$('#alertPeople').show();
	}else{
		$('#alertPeople').hide();
	}
}