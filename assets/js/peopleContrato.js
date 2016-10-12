/**
* @fileoverview Funciones del screen people (alta/busqueda)
*
* @author Alfredo Chi
* @version 0.1
*/

var dataTablePeople = null;
var dataTableReservationsPeople = null
var maxHeight = 400;
isSearch = true;
var xhrPeople;
var idPeople = 0;
var msgPeople = null;

/**************Index****************/

//muestra el modal de usuarios
$('#'+SECCION+'-newUser').off();
$('#'+SECCION+'-newUser').on('click', function() {
	showModal(0); 
});
$('#'+SECCION+'-btnSearch').off();
$('#'+SECCION+'-btnSearch').on('click', function() {  searchPeople(0); });
$('#'+SECCION+'-txtSearch').keyup(function(e){
    if(e.keyCode ==13){
		searchPeople(0);	
    }
});
//limpia el campo busqueda
$('#'+SECCION+'-btnCleanSearch').off();
$('#'+SECCION+'-btnCleanSearch').on('click', function() {  CleandFieldSearch(); });
//muestra u oculta la busqueda avanzada
$('#'+SECCION+'-checkFilterAdvance').off();
$('#'+SECCION+'-checkFilterAdvance').on('click', function() {  searchAdvanced(); });

//editar persomas

$('#'+SECCION+'-textSearchContractPeople').keyup(function(e){
    if(e.keyCode ==13){
		getInfoTabsPeople( SECCION+"-tab-PContratos", "people/getContractByPeople" ); 	
    }
});

//borra la busqueda
$('#'+SECCION+'-btnCleanSearchContractPeople').off();
$('#'+SECCION+'-btnCleanSearchContractPeople').on('click', function() {  CleandFieldSearchPContract(); });



/************Funciones**************/

/**
* Carga el modal
*/
$(document).ready(function(){
	maxHeight = screen.height * .10;
	maxHeight = screen.height - maxHeight;
	
	dialogUser = createModalDialog();
	
$('#'+SECCION+'-paginationPeople').jqPagination({
		max_page: 1,
		paged: function(page) {
			var PI = $('#'+SECCION+'-paginationPeopleInput').val();
			if(PI == "true"){
				$('#'+SECCION+'-paginationPeopleInput').val(false);
			}
			else if (PI == "false") {
				searchPeople(page);
				$('#'+SECCION+'-paginationPeopleInput').val(true);
			}
		}
	});
	
	expandBox("section-people"+SECCION,"box-people"+SECCION+"-relation")
});

function createModalDialog(id){
	
	var div = "#"+SECCION+"-dialog-User";
	dialog = $( "#"+SECCION+"-dialog-User" ).dialog({
		open : function (event){
				showLoading(div,true);
				$(this).load("people/"+SECCION+"modalPeople" , function(){
		    		showLoading(div,false);
					$("#"+SECCION+"-textPhone1").mask("(999) 999-9999");
					$("#"+SECCION+"-textPhone2").mask("(999) 999-9999");
					$("#"+SECCION+"-textPhone3").mask("(999) 999-9999");
					$( "#"+SECCION+"-textBirthdate" ).Zebra_DatePicker({
						format: 'm/d/Y',
						show_icon: false,
					});
					
					$( "#"+SECCION+"-textWeddingAnniversary" ).Zebra_DatePicker({
						format: 'm/d/Y',
						show_icon: false,
					});
					cleanUserFields();
					$('#'+SECCION+'-contentModalPeople .tab-modal').hide();
					$('#'+SECCION+'-contentModalPeople #'+SECCION+'-tab-PGeneral').show();
					
					//muestra o oculta los datos del domicilio
					$('.btnAddressData').off();
					$('.btnAddressData').on('click', function(){ showDivModal('address'); });
					//muestra o oculta la informacion de contacto
					$('.btnContactData').off();
					$('.btnContactData').on('click', function(){ showDivModal('contact'); });
					
					if(id == 0){
						$('.dialogModalButtonSecondary').hide();
						$("#"+SECCION+"-tabsModalPeople").hide();
						
						$('#'+SECCION+'-imgCloseModal').off();
						$('.imgCloseModal').on('click', function() {  hideModal(); });
					}else{
						//$( "#"+SECCION+"-dialog-User" ).dialog( "option", "title", "People > Edit person" );
						$('.dialogModalButtonSecondary').show();
						$("#"+SECCION+"-tabsModalPeople").show();
						$('#'+SECCION+'-dialog-User .contentModal').css('height', "90%" );
						getInfoPeople(id);
					}
					
					//activa los tap del modal
					$('#'+SECCION+'-tabsModalPeople .tabs .tabs-title').off();
					$('#'+SECCION+'-tabsModalPeople .tabs .tabs-title').on('click', function() { changeTabsModalPeople($(this).attr('attr-screen')) });

					//busqueda de contrado por folio
					$('#'+SECCION+'-btnSearchContractPeople').off();
					$('#'+SECCION+'-btnSearchContractPeople').on('click', function() { getInfoTabsPeople( SECCION+"-tab-PContratos", "people/getContractByPeople" );  });
					
					//detecta cuando se cambia el valor del select de pais(country)
					$(document).off('change', "#"+SECCION+"-textCountry");
					$(document).on('change', "#"+SECCION+"-textCountry", function () {
						changeState(this);
					});
					
					dialogUser.css('overflow', 'hidden');
	    		});
		},
		autoOpen: false,
		height: maxHeight,
		width: "70%",
		modal: true,
		buttons: [
			{
				text: "Clone person",
				"class": 'dialogModalButtonSecondary',
				click: function() {
					clonePeople();
				}
			},
			{
				text: "Cancel",
				"class": 'dialogModalButtonCancel',
				click: function() {
					dialogUser.dialog('close');
					cleanUserFields();
					$("#"+SECCION+"-idPeople").removeData("pkPeopleId");
					$("#"+SECCION+"-idPeople").removeData("pkEmployeeId");
				}
			},
			{
				text: "Save and close",
				"class": 'dialogModalButtonAccept',
				click: function() {
					if($("#"+SECCION+"-idPeople").data("pkPeopleId") == undefined ){
						CreateNewUser(false)
					}else{
						EditUser(false, $("#"+SECCION+"-idPeople").data("pkPeopleId") )
					}
				}
			},
			{
				text: "Save",
				"class": 'dialogModalButtonAccept',
				click: function() {
					if($("#"+SECCION+"-idPeople").data("pkPeopleId") == undefined){
						CreateNewUser(true)
					}else{
						EditUser(true, $("#"+SECCION+"-idPeople").data("pkPeopleId") )
					}
					
				}
			},
		],
		close: function() {
			$("#"+SECCION+"-idPeople").removeData("pkPeopleId");
			$("#"+SECCION+"-idPeople").removeData("pkEmployeeId");
			cleanUserFields();
			$('#'+SECCION+'-dialog-Unidades').empty();
		}
	});
	return dialog;
	
}
function showModal(id){
	
	$("#"+SECCION+"-idPeople").removeData("pkPeopleId");
	$("#"+SECCION+"-idPeople").removeData("pkEmployeeId");
	if (dialogUser!=null) {
		dialogUser.dialog( "destroy" );
	}
	
	dialogUser = createModalDialog(id);
	dialogUser.dialog('open');
	if(id == 0){
		dialogUser.dialog( "option", "title", "People > Create person" );
	}else{
		dialogUser.dialog( "option", "title", "People > Edit person" );
	}
}

function hideModal(){
	cleanUserFields();
    dialogUser.dialog('close');
}

function showDivModal(div){
	if(div == "address"){
		$('#'+SECCION+'-containerAddress').toggle(1000);
		if($("#"+SECCION+"-imgCoppapseAddress").attr('class') == "imgCollapseFieldset down"){
			$("#"+SECCION+"-imgCoppapseAddress").removeClass('down');
			$("#"+SECCION+"-imgCoppapseAddress").addClass('up');
			$("#"+SECCION+"-imgCoppapseAddress").attr( 'src', BASE_URL+'assets/img/common/iconCollapseUp.png' );
			gotoDiv(SECCION+'-contentModalPeople','textPostalCode');
		}else{
			$("#"+SECCION+"-imgCoppapseAddress").removeClass('up');
			$("#"+SECCION+"-imgCoppapseAddress").addClass('down');
			$("#"+SECCION+"-imgCoppapseAddress").attr( 'src', BASE_URL+'assets/img/common/iconCollapseDown.png' )
		}
	}else if(div == "contact"){
		$('#'+SECCION+'-containerContact').toggle(1000);
		if($("#"+SECCION+"-imgCoppapseContact").attr('class') == "imgCollapseFieldset down"){
			$("#"+SECCION+"-imgCoppapseContact").removeClass('down');
			$("#"+SECCION+"-imgCoppapseContact").addClass('up');
			$("#"+SECCION+"-imgCoppapseContact").attr( 'src', BASE_URL+'assets/img/common/iconCollapseUp.png' );
			gotoDiv(SECCION+'-contentModalPeople','textEmail2');
		}else{
			$("#"+SECCION+"-imgCoppapseContact").removeClass('up');
			$("#"+SECCION+"-imgCoppapseContact").addClass('down');
			$("#"+SECCION+"-imgCoppapseContact").attr( 'src', BASE_URL+'assets/img/common/iconCollapseDown.png' )
		}
	}
}


function CreateNewUser(isClosed){
	var result = validateUserFields()
	if(result){
		saveUserData(0,isClosed)
	}
}

function EditUser(isClosed, idPeople){
	var result = validateUserFields()
	if(result){
		saveUserData(idPeople,isClosed)
	}
}

function saveUserData(id, isClosed){
	
	msgPeople = alertify.success('Saving changes, please wait ....', 0);
	
	var phoneArray = new Array();
	$(".phonePeople").each(function (index){
		if($(this).val().trim().length != 0){
			phoneArray.push($(this).val().trim().replace(/[^\d]/g, ''));
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
	if($("#"+SECCION+"-RadioMale").is(':checked')) {
		gender = "2";
	}else{
		gender = "1";
	}
	
	var employee = 0;
	var pkEmployeeId = 0;
	//si se estan editando los datos
	if( id > 0 ){
		//si esta activado la opcion de empleado
		if($("#"+SECCION+"-checkPeopleEmployee").is(':checked')) {
			employee = 1;
			pkEmployeeId = $('#'+SECCION+'-idPeople').data("pkEmployeeId");
		}
	}
	
	$.ajax({
   		type: "POST",
       	url: "people/savePeople",
		dataType:'json',
		data: { 
			id:id,
			name:$('#'+SECCION+'-textName').val().trim().toUpperCase(),
			SecondName:$('#'+SECCION+'-textMiddleName').val().trim().toUpperCase(),
			lName:$('#'+SECCION+'-textLastName').val().trim().toUpperCase(),
			lName2:$('#'+SECCION+'-TextSecondLastName').val().trim().toUpperCase(),
			birthDate:$('#'+SECCION+'-textBirthdate').val().trim(),
			gender:gender,
			WeddingAnniversary:$('#'+SECCION+'-textWeddingAnniversary').val().trim(),
			nationality:$('#'+SECCION+'-textNationality').val(),
			qualification:$('#'+SECCION+'-textQualification').val(),
			street:$('#'+SECCION+'-textStreet').val().trim(),
			colony:$('#'+SECCION+'-textColony').val().trim(),
			city:$('#'+SECCION+'-textCity').val().trim(),
			state:$('#'+SECCION+'-textState').val(),
			country:$('#'+SECCION+'-textCountry').val(),
			postalCode:$('#'+SECCION+'-textPostalCode').val().trim(),
			stateCode:$('#'+SECCION+'-textState option:selected').attr('code'),
			countryCode:$('#'+SECCION+'-textCountry option:selected').attr('code'),
			phone:jsonPhone,
			email:jsonEmail,
			pkEmployeeId:pkEmployeeId,
			employee:employee,
			codeCollaborator:$('#'+SECCION+'-textCodeCollaborator').val().trim(),
			initials:$('#'+SECCION+'-textInitials').val().trim(),
			codeNumber:$('#'+SECCION+'-textCodeNumber').val().trim(),
			typeSeller:$('#'+SECCION+'-textTypeSeller').val(),
			roster:$('#'+SECCION+'-textRoster').val(),
		},
		success: function(data){
			//showAlert(true,data.message,'button',showAlert);
			msgPeople.dismiss();
			alertify.success('People Create');
			//alertify.success('peopñe', 0);
			if(data.success == true){
				if(!isClosed){
					dialogUser.dialog('close');
					cleanUserFields();
					$("#"+SECCION+"-idPeople").removeData("pkPeopleId");
					$("#"+SECCION+"-idPeople").removeData("pkEmployeeId");
				}else{
					$("#"+SECCION+"-idPeople").data("pkPeopleId",data.pkPeopleId);
					$('.dialogModalButtonSecondary').show();
				}
				if($('#'+SECCION+'-tablePeople >tbody >tr').length != 0){
					var currentPage = $('#'+SECCION+'-paginationPeople').jqPagination('option', 'current_page');
					searchPeople(currentPage);
				}
			}
			
		},
		error: function(){
			msgPeople.dismiss();
			alertify.error('Error inserting data, try again later.');
			//showAlert(true,"Error inserting data, try again later. ",'button',showAlert);
			dialogUser.dialog('close');
			cleanUserFields();
			$("#"+SECCION+"-idPeople").removeData("pkPeopleId");
			$("#"+SECCION+"-idPeople").removeData("pkEmployeeId");
		}
	});	
}

/**
* valida los campos de usuario
*/
function validateUserFields(){
	
	var result = true;
	var infoEmployee = true;
	var infoAddress = true;
	var infoContact = true;
	var infoPeople = true;
	var errorText = "";
	hideAlertUserFields();
	
//	alert($("#"+SECCION+"-checkPeopleEmployee").is(':checked'))
	
	if($("#"+SECCION+"-checkPeopleEmployee").is(':checked')){
		
		if($('#'+SECCION+'-textCodeCollaborator').val().trim().length == 0 ){
			$('#'+SECCION+'-alertCodeCollaborator').addClass('error');
			$('#'+SECCION+'-textCodeCollaborator').focus();
			errorText = "Código del colaborador<br>" + errorText;
			infoEmployee = false;
		}
		
		if($('#'+SECCION+'-textInitials').val().trim().length == 0 ){
			$('#'+SECCION+'-alertInitials').addClass('error');
			$('#'+SECCION+'-textInitials').focus();
			errorText = "Iniciales<br>" + errorText;
			infoEmployee = false;
		}
		
		if($('#'+SECCION+'-textCodeNumber').val().trim().length == 0 ){
			$('#'+SECCION+'-alertCodeNumber').addClass('error');
			$('#'+SECCION+'-textCodeNumber').focus();
			errorText = "Código numérico<br>" + errorText;
			infoEmployee = false;
		}
		
		if($('#'+SECCION+'-textTypeSeller').val() == null || $('#'+SECCION+'-textTypeSeller').val() == 0){
			$('#'+SECCION+'-alertTypeSeller').addClass('error');
			$('#'+SECCION+'-textTypeSeller').focus();
			errorText = "Tipo de vendedor<br>" + errorText;
			infoEmployee = false;
		}
		
		if(infoEmployee == false){
			$('#'+SECCION+'-alertValPeopleEmployee .alert-box').html("<label>Please complete fields in red</label>" );
			$('#'+SECCION+'-alertValPeopleEmployee').show(100);
			result = false;
		}
	}
	
	var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
	//email 2
	if($('#'+SECCION+'-textEmail2').val().trim().length > 0){
		if(!regex.test($('#'+SECCION+'-textEmail2').val().trim())){
			$('#'+SECCION+'-alertEmail2').addClass('error');
			$('#'+SECCION+'-textEmail2').focus();
			errorText = "El correo 2 debe ser valido<br>"  + errorText;
			infoContact = false;
		}
	}
	if($('#'+SECCION+'-textEmail1').val().trim().length > 0){
		if(!regex.test($('#'+SECCION+'-textEmail1').val().trim())){
			$('#'+SECCION+'-alertEmail1').addClass('error');
			$('#'+SECCION+'-textEmail1').focus();
			errorText = "EL correo debe ser valido</br>"  + errorText;
			infoContact = false;
		}
	}
	
	//Telefono 3
	if($('#'+SECCION+'-textPhone3').val().trim().length > 0 && $('#'+SECCION+'-textPhone3').val().trim().length > 14 ){
		$('#'+SECCION+'-alertPhone3').addClass('error');
		$('#'+SECCION+'-textPhone3').focus();
		errorText = "El telefono 3 debe tener maximo 11 caracteres<br>"  + errorText;
		infoContact = false;
	}
	
	//Telefono 2
	if($('#'+SECCION+'-textPhone2').val().trim().length > 0 && $('#'+SECCION+'-textPhone2').val().trim().length > 14 ){
		$('#'+SECCION+'-alertPhone2').addClass('error');
		$('#'+SECCION+'-textPhone2').focus();
		errorText = "El telefono 2 debe tener maximo 11 caracteres<br>"  + errorText;
		infoContact = false;
	}
	
	//Telefono 2
	if($('#'+SECCION+'-textPhone1').val().trim().length > 0 && $('#'+SECCION+'-textPhone1').val().trim().length > 14 ){
		$('#'+SECCION+'-alertPhone1').addClass('error');
		$('#'+SECCION+'-textPhone1').focus();
		errorText = "El telefono 1 debe tener maximo 11 caracteres<br>"  + errorText;
		infoContact = false;
	}
	
	if(infoContact == false){
		result = false;
		$('#'+SECCION+'-alertValPeopleContact .alert-box').html("<label>Please complete fields in red</label>" + errorText );
		$('#'+SECCION+'-alertValPeopleContact').show(100);
		$('#'+SECCION+'-containerContact').show();
	}
	
	errorText = "";
	
	//fecha de nacimiento
	if($('#'+SECCION+'-textPostalCode').val().trim().length == 0){
		$('#'+SECCION+'-alertPostalCode').addClass('error');
		$('#'+SECCION+'-textPostalCode').focus();
		errorText = "Codigo postal<br>"  + errorText;
		infoAddress = false;
	}
	
	//Ciudad
	if($('#'+SECCION+'-textCity').val().trim().length == 0){
		$('#'+SECCION+'-alertCity').addClass('error');
		$('#'+SECCION+'-textCity').focus();
		errorText = "Ciudad<br>"  + errorText;
		infoAddress = false;
	}
	
	//country
	if($('#'+SECCION+'-textCountry').val() == 0){
		$('#'+SECCION+'-alertCountry').addClass('error');
		$('#'+SECCION+'-textCountry').focus();
		errorText = "Pais<br>"  + errorText;
		infoAddress = false;
	}
	
	//estado
	if($('#'+SECCION+'-textState').val() == 0){
		$('#'+SECCION+'-alertState').addClass('error');
		$('#'+SECCION+'-textState').focus();
		errorText = "Estado<br>"  + errorText;
		infoAddress = false;
	}
	
	//calle
	if($('#'+SECCION+'-textStreet').val().trim().length == 0){
		$('#'+SECCION+'-alertStreet').addClass('error');
		$('#'+SECCION+'-textStreet').focus();
		errorText = "Calle<br>"  + errorText;
		infoAddress = false;
	}
	if(infoAddress == false){
		result = false;
		$('#'+SECCION+'-alertValPeopleAddress .alert-box').html("<label>Please complete fields in red</label>" + errorText );
		$('#'+SECCION+'-alertValPeopleAddress').show(100);
		$('#'+SECCION+'-containerAddress').show();
	}
	
	errorText = "";
	
	//validate fecha
	
	//aniversario
	if($('#'+SECCION+'-textWeddingAnniversary').val().trim().length > 0){
			if(!isDate($('#'+SECCION+'-textWeddingAnniversary').val())){
			$('#'+SECCION+'-alertWeddingAnniversary').addClass('error');
			//$('#'+SECCION+'-textWeddingAnniversary').focus();
			errorText = "Selecione una fecha de aniversario correcta>"  + errorText;
			infoPeople = false;
		}
	}
	//alert(regex2.test($('#'+SECCION+'-textBirthdate').val())
	//fecha
	if($('#'+SECCION+'-textBirthdate').val().trim().length > 0){
		if(!isDate($('#'+SECCION+'-textBirthdate').val())){
			$('#'+SECCION+'-alertBirthdate').addClass('error');
			//$('#'+SECCION+'-textBirthdate').focus();
			errorText = "Selecione una fecha correctabr>"  + errorText;
			infoPeople = false;
		}
	}
	
	//fecha de nacimiento
	if($('#'+SECCION+'-textBirthdate').val().trim().length == 0){
		$('#'+SECCION+'-alertBirthdate').addClass('error');
		//$('#'+SECCION+'-textBirthdate').focus();
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
		$('#'+SECCION+'-alertGender').addClass('error');
		errorText = "Genero<br>"  + errorText;
		infoPeople = false;
	}
	
	//apellido paterno
	if($('#'+SECCION+'-textLastName').val().trim().length == 0){
		$('#'+SECCION+'-alertLastName').addClass('error');
		$('#'+SECCION+'-textLastName').focus();
		errorText = "Apellido paterno<br>"  + errorText;
		infoPeople = false;
	}
	//nombre
	if($('#'+SECCION+'-textName').val().trim().length == 0){
		$('#'+SECCION+'-alertName').addClass('error');
		$('#'+SECCION+'-textName').focus();
		errorText =  "Nombre<br>" + errorText;
		infoPeople = false;
	}
	
	if(infoPeople == false){
		$('#'+SECCION+'-alertValPeopleGeneral .alert-box').html("<label>Please complete fields in red</label>" + errorText );
		$('#'+SECCION+'-alertValPeopleGeneral').show(100);
		result = false;
	}
	
	return result;
}

/**
* esconde las alertas de validacion
*/
function hideAlertUserFields(){
	$('#'+SECCION+'-alertValPeopleGeneral').hide();
	$('#'+SECCION+'-alertValPeopleAddress').hide();
	$('#'+SECCION+'-alertValPeopleContact').hide();
	$('#'+SECCION+'-alertValPeopleEmployee').hide();
	
	$('#'+SECCION+'-alertName').removeClass('error');
	$('#'+SECCION+'-alertLastName').removeClass('error');
	$('#'+SECCION+'-alertBirthdate').removeClass('error');
	$('#'+SECCION+'-alertGender').removeClass('error');
	$('#'+SECCION+'-alertWeddingAnniversary').removeClass('error');
	
	$('#'+SECCION+'-alertStreet').removeClass('error');
	$('#'+SECCION+'-alertColony').removeClass('error');
	$('#'+SECCION+'-alertCity').removeClass('error');
	$('#'+SECCION+'-alertState').removeClass('error');
	$('#'+SECCION+'-alertCountry').removeClass('error');
	$('#'+SECCION+'-alertPostalCode').removeClass('error');
	
	$('#'+SECCION+'-alertPhone1').removeClass('error');
	$('#'+SECCION+'-alertPhone2').removeClass('error');
	$('#'+SECCION+'-alertPhone3').removeClass('error');
	$('#'+SECCION+'-alertEmail1').removeClass('error');
	$('#'+SECCION+'-alertEmail2').removeClass('error');
	
	$('#'+SECCION+'-alertCodeCollaborator').removeClass('error');
	$('#'+SECCION+'-alertInitials').removeClass('error');
	$('#'+SECCION+'-alertCodeNumber').removeClass('error');
	$('#'+SECCION+'-alertTypeSeller').removeClass('error');
	$('#'+SECCION+'-alertRoster').removeClass('error');
}

/**
* limpia los campos de people
*/
function cleanUserFields(){
	hideAlertUserFields();
	$('#'+SECCION+'-textName').val("");
	$('#'+SECCION+'-textLastName').val("");
	$('#'+SECCION+'-TextSecondLastName').val("");
	$('#'+SECCION+'-textBirthdate').val("");
	$('#'+SECCION+'-textWeddingAnniversary').val("");
	//$('#'+SECCION+'-textNationality').val("");
	//$('#'+SECCION+'-textQualification').val("");
	$('#'+SECCION+'-RadioMale').prop( "checked", false );
	$("#"+SECCION+"-RadioFemale").prop( "checked", false );
	
	$('#'+SECCION+'-textStreet').val("");
	$('#'+SECCION+'-textColony').val("");
	$('#'+SECCION+'-textCity').val("");
	$('#'+SECCION+'-textCountry').val(0);
	$('#'+SECCION+'-textState').val(0);
	$("select#textCountry").val("0");
	$("select#textState").val("0");
	$('#'+SECCION+'-textPostalCode').val("");
	
	$('#'+SECCION+'-textPhone1').val("");
	$('#'+SECCION+'-textPhone2').val("");
	$('#'+SECCION+'-textPhone3').val("");
	$('#'+SECCION+'-textEmail1').val("");
	$('#'+SECCION+'-textEmail2').val("");
	
	$('#'+SECCION+'-textCodeCollaborator').val("");
	$('#'+SECCION+'-textInitials').val("");
	$('#'+SECCION+'-textCodeNumber').val("");
	$('#'+SECCION+'-textTypeSeller').val(0);
	$('#'+SECCION+'-textRoster').val(0);
	$('#'+SECCION+'-checkPeopleEmployee').prop( "checked", false );
	
	$('#'+SECCION+'-containerAddress').hide();
	$('#'+SECCION+'-containerContact').hide();
	
	$("#"+SECCION+"-idPeople").removeData("pkPeopleId");
	$("#"+SECCION+"-idPeople").removeData("pkEmployeeId");
	
	$('#'+SECCION+'-tableReservationsPeople tbody').empty();
	$('#'+SECCION+'-tableContractPeople tbody').empty();
	
	$('#'+SECCION+'-textSearchContractPeople').val("");
	
	changeTabsModalPeople(SECCION+'-tab-PGeneral');
}

function searchPeople(page){
	
	$('#'+SECCION+'-tablePeople tbody').empty();
	showLoading('#'+SECCION+'-section-table-people',true);
	
	var typePeople = $('#'+SECCION+'-btnSearch').attr('attr_people');
	
	//noResults('#'+SECCION+'-section-table-people',false);
	opcionAdvanced = "";
	if($('#'+SECCION+'-checkFilterAdvance').is(':checked')){
		opcionAdvanced = $('.RadioSearchPeople:checked').val();
	}
	$.ajax({
   		type: "POST",
       	url: "people/getPeopleBySearch",
		dataType:'json',
		data: {
			search:$("#"+SECCION+"-txtSearch").val().trim(),
			peopleId:$("#"+SECCION+"-checkFilter1").is(':checked'),
			lastName:$("#"+SECCION+"-checkFilter2").is(':checked'),
			name:$("#"+SECCION+"-checkFilter3").is(':checked'),
			advanced:opcionAdvanced,
			typePeople:typePeople,
			page:page,
		},
		success: function(data){
			if(data.items.length > 0){
				$("#"+SECCION+"-NP").text("Total: "+ data.items.length);
				var total = data.total;
				alertify.success("Found "+ data.items.length  + " People");
				if( parseInt(total) == 0 ){ total = 1; }
				total = parseInt( total/25 );
				if(data.total%25 == 0){
					total = total - 1;		
				}
				total = total + 1
				$('#'+SECCION+'-paginationPeopleInput').val(true);
				loadPaginatorPeople(total);

				drawTable2(data.items,SECCION+"-tablePeople","showModal","Edit");
				
				if( jQuery.isFunction( "markRowTableFrontDesk" ) ){
					var typePeople = $("#"+SECCION+"-dialog-people-hkConfig").find('#'+SECCION+'-btnSearch').attr('attr_people');
					if(typePeople == "maid"){
						markRowTableFrontDesk( SECCION+"-tablePeople", "tablePeopleMaidSelectedHKC" );
					}else if(typePeople == "superior"){
						markRowTableFrontDesk( SECCION+"-tablePeople", "tablePeopleSupeSelectedHKC" );
					}
				}
			}else{
				noResultsPeople("section-table-people", SECCION+"-tablePeople", "No results found");
			}
			showLoading('#'+SECCION+'-section-table-people',false);
		},
		error: function(error){
			noResultsPeople("section-table-people", SECCION+"-tablePeople", "Try again");
			showLoading('#'+SECCION+'-section-table-people',false);
		}
	});
}

/**
* Limpia el campo de busqueda de personas
*/
function CleandFieldSearch(){
	$("#"+SECCION+"-txtSearch").val("");
}

/**
* muestra las busquedas avanzadas
*/
function searchAdvanced(){
	$('#'+SECCION+'-containerFilterAdv').toggle(1000);
	if($("#"+SECCION+"-checkFilterAdvance").is(':checked')) {
		$('#'+SECCION+'-fieldsetFilterAdvanced').removeClass('fieldsetFilter-advanced-hide');
		$('#'+SECCION+'-fieldsetFilterAdvanced').addClass('fieldsetFilter-advanced-show');
	}else{
		$('#'+SECCION+'-fieldsetFilterAdvanced').addClass('fieldsetFilter-advanced-hide');
		$('#'+SECCION+'-fieldsetFilterAdvanced').removeClass('fieldsetFilter-advanced-show');
	}
}

/**
 * Carga el paginador
 */
function loadPaginatorPeople(maxPage){
	$('#'+SECCION+'-paginationPeople').jqPagination('option', 'max_page', maxPage);
}

function getInfoPeople(id){
	showLoading('#'+SECCION+'-section-table-people',true);
	$.ajax({
   		type: "POST",
       	url: "people/getPeopleById",
		dataType:'json',
		data: {
			id:id,
		},
		success: function(data){
			console.table(data);
			var item = data.item[0];
			$('#'+SECCION+'-textName').val(item.Name.toUpperCase());
			$('#'+SECCION+'-textMiddleName').val(item.SecondName);
			$('#'+SECCION+'-textLastName').val(item.LName);
			$('#'+SECCION+'-TextSecondLastName').val(item.LName2);
			
			if(item.fkGenderId == "2"){
				$('#'+SECCION+'-RadioMale').prop("checked", true);
			}else if(item.fkGenderId == "1"){
				$("#"+SECCION+"-RadioFemale").prop("checked", true);
			}
			$('#'+SECCION+'-textBirthdate').val(item.birthdate);
			$('#'+SECCION+'-textWeddingAnniversary').val(item.Anniversary);
			$('#'+SECCION+'-textNationality').val(item.Nationality.trim())
			$('#'+SECCION+'-textQualification').val(item.Qualification.trim());
			$('#'+SECCION+'-textStreet').val(item.Street1.trim());
			$('#'+SECCION+'-textColony').val(item.Street2.trim());
			$('#'+SECCION+'-textCity').val(item.City.trim());
			$('#'+SECCION+'-textPostalCode').val(item.ZipCode.trim());
			if(item.pkCountryId != null || item.pkCountryId == ""){
				$("select#textCountry").val(item.pkCountryId);
			}else{
				$("select#textCountry").val(0);
			}
			$('#'+SECCION+'-textState').empty();
			$('#'+SECCION+'-textState').append('<option value="0" code="0">Select your state</option>');
			if(data.states.length > 0){
				for(i=0;i<data.states.length;i++){
					var state = data.states[i];
					$('#'+SECCION+'-textState').append('<option value="' + state.pkStateId + '" code="' + state.StateCode + '">' + state.StateDesc + '</option>');
				}
			}
			if(item.pkStateId != null || item.pkStateId == ""){
				$("select#textState").val(item.pkStateId);
			}else{
				$("select#textState").val(0);
			}
			
			$('#'+SECCION+'-textPhone1').val(item.phone1.trim());
			$('#'+SECCION+'-textPhone2').val(item.phone2.trim());
			$('#'+SECCION+'-textPhone3').val(item.phone3.trim());
			$('#'+SECCION+'-textEmail1').val(item.email1.trim());
			$('#'+SECCION+'-textEmail2').val(item.email2.trim());
			$("#"+SECCION+"-textPhone1").mask("(999) 999-9999");
			$("#"+SECCION+"-textPhone2").mask("(999) 999-9999");
			$("#"+SECCION+"-textPhone3").mask("(999) 999-9999");
			$('#'+SECCION+'-textTypeSeller').empty();
			$('#'+SECCION+'-textTypeSeller').append('<option value="0" code="0">Select a type of seller</option>');
			for(i=0;i<data.peopleType.length;i++){
				var peopleType = data.peopleType[i];
				$('#'+SECCION+'-textTypeSeller').append('<option value="' + peopleType.pkPeopleTypeId + '" code="' + peopleType.PeopleTypeCode + '">' + peopleType.PeopleTypeDesc + '</option>');
			}
			
			if(item.pkEmployeeId > 0){
				$("#"+SECCION+"-checkPeopleEmployee").prop( "checked", true );
				$('#'+SECCION+'-textCodeCollaborator').val(item.EmployeeCode.trim());
				$('#'+SECCION+'-textInitials').val(item.InitialsEmplo.trim());
				$('#'+SECCION+'-textCodeNumber').val(item.NumericCode);
				$('#'+SECCION+'-textTypeSeller').val(item.fkPeopleTypeId);
				$('#'+SECCION+'-textRoster').val(0);
				$('#'+SECCION+'-textTypeSeller').val(item.fkPeopleTypeId);
				$('#'+SECCION+'-textRoster').val(item.fkVendorTypeId);
			}
			
			$("#"+SECCION+"-idPeople").data("pkPeopleId",item.pkPeopleId);
			$("#"+SECCION+"-idPeople").data("pkEmployeeId",item.pkEmployeeId);
			$('#'+SECCION+'-imgCloseModal').off();
			$('.imgCloseModal').on('click', function() {  hideModal(); });
			$('body, html').animate({
				scrollTop: '0px'
			}, 0);
			dialogUser.dialog( 'open' )
			showLoading('#'+SECCION+'-section-table-people',false);
		},
		error: function(error){
			showLoading('#'+SECCION+'-section-table-people',false);
			alertify.error('Error inserting data, try again later.');
			//showAlert(true,"Error in the search, try again later",'button',showAlert);
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
	$('#'+SECCION+'-tabsModalPeople .tabs .tabs-title').removeClass('active');
	$('#'+SECCION+'-tabsModalPeople .tabs li[attr-screen=' + screen + ']').addClass('active');
	//muestra la pantalla selecionada
	$('#'+SECCION+'-contentModalPeople .tab-modal').hide();
	$('#'+SECCION+'-' + screen).show();
	if($("#"+SECCION+"-idPeople").data("pkPeopleId") != undefined ){
		if(screen == SECCION+"-tab-PReservaciones"){
			getInfoTabsPeople(screen, "people/getReservationsByPeople");
		}else if(screen == SECCION+"-tab-PContratos"){
			getInfoTabsPeople(screen, "people/getContractByPeople");
		}else if(screen == SECCION+"-tab-PEmpleados"){
			//getInfoTabsPeople(screen, "people/getEmployeeByPeople");
		}
	}
}

/**
* Obtiene las reservaciones de una persona
* @param screen pantalla en la cual se buscara la info
* @param url direccion de la consulta
*/
function getInfoTabsPeople(screen, url){
	
	var search = "";
	if(screen == SECCION+"-tab-PReservaciones"){
		deleteTableInv("tableReservationsPeople");
		showLoading('#'+SECCION+'-tab-PReservaciones',true);
		$('#'+SECCION+'-tableReservationsPeople tbody').empty();
		//noResults('#'+SECCION+'-' + screen,false);
	}else{
		deleteTableInv(SECCION+"-tableContractPeople");
		showLoading('#'+SECCION+'-tab-PContratos',true);
		$('#'+SECCION+'-tableContractPeople tbody').empty();
		search = $('#'+SECCION+'-textSearchContractPeople').val();
		//noResults('#'+SECCION+'-' + screen,false);
	}
	$.ajax({
   		type: "POST",
       	url: url,
		dataType:'json',
		data: {
			id:$("#"+SECCION+"-idPeople").data("pkPeopleId"),
			search:search
		},
		success: function(data){
			if(screen == SECCION+"-tab-PReservaciones"){
				if(data.items.length > 0){
					drawTable2(data.items,"tableReservationsPeople",false,"tabla");
				}else{
					//$('#'+SECCION+'-tableReservationsPeople tbody').empty();
					noResultsPeople(SECCION+"-tab-PReservaciones", "tableReservationsPeople", "No results found");
				}
				
			}else if(screen == SECCION+"-tab-PContratos"){
				if(data.items.length > 0){
					drawTable2(data.items,SECCION+"-tableContractPeople",false,"tabla");
				}else{
					noResultsPeople(SECCION+"-divTableContractPeople", SECCION+"-tableContractPeople", "No results found");
				}
			}else if(screen == SECCION+"-tab-PEmpleados"){
				$('#'+SECCION+'-textTypeSeller').empty();
				$('#'+SECCION+'-textTypeSeller').append('<option value="0" code="0">Select a type of seller</option>');
				for(i=0;i<data.items.length;i++){
					var item = data.items[i];
					$('#'+SECCION+'-textTypeSeller').append('<option value="' + item.pkPeopleTypeId + '" code="' + item.PeopleTypeCode + '">' + item.PeopleTypeDesc + '</option>');
				}
			}
			if(screen == SECCION+"-tab-PReservaciones"){
				showLoading('#'+SECCION+'-tab-PReservaciones',false);
			}else{
				showLoading('#'+SECCION+'-tab-PContratos',false);
			}
		},
		error: function(error){
			if(screen == "tab-PReservaciones"){
				showLoading('#'+SECCION+'-tab-PReservaciones',false);
				noResultsPeople(SECCION+"-tab-PReservaciones", "tableReservationsPeople", "Try again");
			}else{
				showLoading('#'+SECCION+'-tab-PContratos',false);
				noResultsPeople(SECCION+"-divTableContractPeople", "tableReservationsPeople", "Try again");
			}
			//showAlert(true,"Error in the search, try again later.",'button',showAlert);
		}
	});
}

/**
 * limpia el campo de busqueda de contactos-persona
 */
function CleandFieldSearchPContract(){
	$('#'+SECCION+'-textSearchContractPeople').val("");
}

/**
 * Clona los datos del usuario selecionado
 */
function clonePeople(){
	$("#"+SECCION+"-idPeople").removeData("pkPeopleId");
	$("#"+SECCION+"-idPeople").removeData("pkEmployeeId");
	$('#'+SECCION+'-textName').val("");
	//$('#'+SECCION+'-textLastName').val("");
	$('#'+SECCION+'-textMiddleName').val("");
	$('#'+SECCION+'-TextSecondLastName').val("");
	$('#'+SECCION+'-textNationality').val(0);
	$('#'+SECCION+'-textQualification').val(0);
	$('.RadioGender').prop('checked', false)
	$('#'+SECCION+'-textBirthdate').val("");
	$('#'+SECCION+'-textWeddingAnniversary').val("");
	
	$('#'+SECCION+'-textEmail1').val("");
	$('#'+SECCION+'-textEmail2').val("");
	
	$('#'+SECCION+'-textCodeCollaborator').val("");
	$('#'+SECCION+'-textInitials').val("");
	$('#'+SECCION+'-textCodeNumber').val("");
	$('#'+SECCION+'-textTypeSeller').val(0);
	$('#'+SECCION+'-textRoster').val(0);
	$('#'+SECCION+'-checkPeopleEmployee').prop( "checked", false );
	
	$('#'+SECCION+'-tableReservationsPeople tbody').empty();
	$('#'+SECCION+'-tableContractPeople tbody').empty();
	
	$('#'+SECCION+'-textSearchContractPeople').val("");
	
	changeTabsModalPeople(SECCION+"-tab-PGeneral")
	
	validateUserFields();
	
}

/**
* Cambia el cotenido del select estado dependiendo de lo selecionado en country
* @param idCountry identificador del pais
*/
function changeState(selector){
	var idCountry = $(selector).val();
	$('#'+SECCION+'-textState').empty();
	$('#'+SECCION+'-textState').append('<option value="0" code="0">Select your state</option>');
	$('#'+SECCION+'-textState').attr('disabled',true);
	$.ajax({
   		type: "POST",
       	url: "people/getStateByCountry",
		dataType:'json',
		data: {
			idCountry:idCountry
		},
		success: function(data){
			if(data.success == true){
				for(i=0;i<data.items.length;i++){
					var item = data.items[i];
					$('#'+SECCION+'-textState').append('<option value="' + item.pkStateId + '" code="' + item.StateCode + '">' + item.StateDesc + '</option>');
				}
			}else{
				$('#'+SECCION+'-textState').empty();
				$('#'+SECCION+'-textState').append('<option value="0" code="0">' + data.message + '</option>');
			}
			$('#'+SECCION+'-textState').attr('disabled',false);
		},
		error: function(error){
			$('#'+SECCION+'-textState').empty();
			$('#'+SECCION+'-textState').append('<option value="0" code="0">Select your state</option>');
			$('#'+SECCION+'-textState').attr('false',false);
			alertify.error('Error inserting data, try again later.');
			//showAlert(true,"Error in the search, try again later.",'button',showAlert);
		}
	});
}

function noResultsPeople(section, table, message){
	alertify.error(message);
	//noResults('#'+SECCION+'-' + section,true);
	deleteTableInv(table);
}

function deleteTableInv(table){
	if ( $.fn.dataTable.isDataTable( '#'+SECCION+'-' + table ) ){
		var tabla = $( '#'+SECCION+'-' + table ).DataTable();
		tabla.destroy();
	}
	$('#'+SECCION+'-' + table).hide();
}

function tesCreatePeople(){
	$("#"+SECCION+"-textName").val(randomNames());
	$("#"+SECCION+"-textMiddleName").val(randomNames());
	$("#"+SECCION+"-textLastName").val(ramdomLastName());
	$("#"+SECCION+"-TextSecondLastName").val(ramdomLastName());
	setRandomGender();
	$("#"+SECCION+"-textWeddingAnniversary").val(randomDate);
	$("#"+SECCION+"-textBirthdate").val(randomDate);
	$("#"+SECCION+"-textNationality").val("Mexican");
	$("#"+SECCION+"-textQualification").val(getRandomInt(1,4));
	$("#"+SECCION+"-textStreet").val(makeRandonNames(7));
	$("#"+SECCION+"-textColony").val(makeRandonNames(7))
	$("#"+SECCION+"-textCountry").val(41);
	$("#"+SECCION+"-textState").val(957);
	$("#"+SECCION+"-textCity").val("Cancun");
	$("#"+SECCION+"-textPostalCode").val(getRandomNumber(5));
	$("#"+SECCION+"-textPhone1").val(getRandomNumber(10));
	$("#"+SECCION+"-textPhone1").val(getRandomNumber(10));
	$("#"+SECCION+"-textPhone2").val(getRandomNumber(10));
	$("#"+SECCION+"-textEmail1").val(getRandomEmail());
}

function randomNames(){
	var posicionRandom = getRandomInt(0,14);
	var Gender = getRandomInt(0,1);
	var mensNames = ["Santiago", "Sebastián", "Diego", "Nicolás", "Samuel", "Alejandro", "Daniel", "Mateos", "Ángel", "Matias", "Gabriel", "David", "Fernando", "Eduardo", "Javier"];
	var womensNames = ["Agatha", "Agustina", "Belisa", "Bella", "Carine", "Cloé", "Damaris", "Eleana", "Eunice", "Galilea", "Helena", "Imelda", "Jenny", "Joselin", "Keyla", "Leonor"];
	if (Gender) {
		return mensNames[posicionRandom];
	}else{
		return womensNames[posicionRandom];
	}
	
}

function ramdomLastName(){
	var posicionRandom = getRandomInt(0,14);
	var lastNames = ["GUERRERO","LEON", "BLANCO", "MARIN", "NUÑEZ", "PRIETO", "FLORES", "REYES", "DURAN", "CARMONA", "ROMAN", "SOTO", "VELASCO", "BRAVO", "ROJAS", "GALLARDO", "SAEZ"];
	return lastNames[posicionRandom];
}

function setRandomGender(){
	var posicion = getRandomInt(0,1);
	console.log(posicion);
	if (posicion == 0) {
		$("#"+SECCION+"-RadioFemale").prop( "checked", true );
	}else{
		$("#"+SECCION+"-RadioMale").prop( "checked", true );
	}
}

function randomDate(){
	var days = getRandomInt(1,29);
	var months = getRandomInt(1,12);
	var years = getRandomInt(1950, 1996);
	return fecha = months + "/" + days + "/" + years;
}

function getRandomEmail(){
	var name = makeRandonNames(7);
	return  name + "@" + "gmail.com";
}