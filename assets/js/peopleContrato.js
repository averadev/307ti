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
$('#Contrato-newUser').off();
$('#Contrato-newUser').on('click', function() {  showModal(0); });
$('#Contrato-btnSearch').off();
$('#Contrato-btnSearch').on('click', function() {  searchPeople(0); });
$('#Contrato-txtSearch').keyup(function(e){
    if(e.keyCode ==13){
		searchPeople(0);	
    }
});
//limpia el campo busqueda
$('#Contrato-btnCleanSearch').off();
$('#Contrato-btnCleanSearch').on('click', function() {  CleandFieldSearch(); });
//muestra u oculta la busqueda avanzada
$('#Contrato-checkFilterAdvance').off();
$('#Contrato-checkFilterAdvance').on('click', function() {  searchAdvanced(); });

//editar persomas

$('#Contrato-textSearchContractPeople').keyup(function(e){
    if(e.keyCode ==13){
		getInfoTabsPeople( "tab-PContratos", "people/getContractByPeople" ); 	
    }
});

//borra la busqueda
$('#Contrato-btnCleanSearchContractPeople').off();
$('#Contrato-btnCleanSearchContractPeople').on('click', function() {  CleandFieldSearchPContract(); });



/************Funciones**************/

/**
* Carga el modal
*/
$(document).ready(function(){
	maxHeight = screen.height * .10;
	maxHeight = screen.height - maxHeight;
	
	dialogUser = createModalDialog();
	
	$('#Contrato-paginationPeople').jqPagination({
		max_page: 1,
		paged: function(page) {
			if($('#Contrato-paginationPeople').val() == true){
				$('#Contrato-paginationPeople').val(false);
			}else{
				searchPeople(page);
			}
		}
	});
	
	expandBox("section-people","box-people-relation")
});

function createModalDialog(id){
	
	var div = "#Contrato-dialog-User";
	dialog = $( "#Contrato-dialog-User" ).dialog({
		open : function (event){
				showLoading(div,true);
				$(this).load("people/modalPeople2" , function(){
		    		showLoading(div,false);
					$("#Contrato-textPhone1").mask("(999) 999-9999");
					$("#Contrato-textPhone2").mask("(999) 999-9999");
					$("#Contrato-textPhone3").mask("(999) 999-9999");
					$( "#Contrato-textBirthdate" ).Zebra_DatePicker({
						format: 'm/d/Y',
						show_icon: false,
					});
					
					$( "#Contrato-textWeddingAnniversary" ).Zebra_DatePicker({
						format: 'm/d/Y',
						show_icon: false,
					});
					cleanUserFields();
					$('#Contrato-contentModalPeople .tab-modal').hide();
					$('#Contrato-contentModalPeople #tab-PGeneral').show();
					
					//muestra o oculta los datos del domicilio
					$('.btnAddressData').off();
					$('.btnAddressData').on('click', function(){ showDivModal('address'); });
					//muestra o oculta la informacion de contacto
					$('.btnContactData').off();
					$('.btnContactData').on('click', function(){ showDivModal('contact'); });
					
					if(id == 0){
						$('.dialogModalButtonSecondary').hide();
						$("#Contrato-tabsModalPeople").hide();
						
						$('#Contrato-imgCloseModal').off();
						$('.imgCloseModal').on('click', function() {  hideModal(); });
					}else{
						//$( "#Contrato-dialog-User" ).dialog( "option", "title", "People > Edit person" );
						$('.dialogModalButtonSecondary').show();
						$("#Contrato-tabsModalPeople").show();
						$('#Contrato-dialog-User .contentModal').css('height', "90%" );
						getInfoPeople(id);
					}
					
					//activa los tap del modal
					$('#Contrato-tabsModalPeople .tabs .tabs-title').off();
					$('#Contrato-tabsModalPeople .tabs .tabs-title').on('click', function() { changeTabsModalPeople($(this).attr('attr-screen')) });

					//busqueda de contrado por folio
					$('#Contrato-btnSearchContractPeople').off();
					$('#Contrato-btnSearchContractPeople').on('click', function() { getInfoTabsPeople( "tab-PContratos", "people/getContractByPeople" );  });
					
					//detecta cuando se cambia el valor del select de pais(country)
					$(document).off('change', "#Contrato-textCountry");
					$(document).on('change', "#Contrato-textCountry", function () {
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
					$("#Contrato-idPeople").removeData("pkPeopleId");
					$("#Contrato-idPeople").removeData("pkEmployeeId");
				}
			},
			{
				text: "Save and close",
				"class": 'dialogModalButtonAccept',
				click: function() {
					if($("#Contrato-idPeople").data("pkPeopleId") == undefined ){
						CreateNewUser(false)
					}else{
						EditUser(false, $("#Contrato-idPeople").data("pkPeopleId") )
					}
				}
			},
			{
				text: "Save",
				"class": 'dialogModalButtonAccept',
				click: function() {
					if($("#Contrato-idPeople").data("pkPeopleId") == undefined){
						CreateNewUser(true)
					}else{
						EditUser(true, $("#Contrato-idPeople").data("pkPeopleId") )
					}
					
				}
			},
		],
		close: function() {
			$("#Contrato-idPeople").removeData("pkPeopleId");
			$("#Contrato-idPeople").removeData("pkEmployeeId");
			cleanUserFields();
			$('#Contrato-dialog-Unidades').empty();
		}
	});
	return dialog;
	
}
function showModal(id){
	
	$("#Contrato-idPeople").removeData("pkPeopleId");
	$("#Contrato-idPeople").removeData("pkEmployeeId");
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
		$('#Contrato-containerAddress').toggle(1000);
		if($("#Contrato-imgCoppapseAddress").attr('class') == "imgCollapseFieldset down"){
			$("#Contrato-imgCoppapseAddress").removeClass('down');
			$("#Contrato-imgCoppapseAddress").addClass('up');
			$("#Contrato-imgCoppapseAddress").attr( 'src', BASE_URL+'assets/img/common/iconCollapseUp.png' );
			gotoDiv('contentModalPeople','textPostalCode');
		}else{
			$("#Contrato-imgCoppapseAddress").removeClass('up');
			$("#Contrato-imgCoppapseAddress").addClass('down');
			$("#Contrato-imgCoppapseAddress").attr( 'src', BASE_URL+'assets/img/common/iconCollapseDown.png' )
		}
	}else if(div == "contact"){
		$('#Contrato-containerContact').toggle(1000);
		if($("#Contrato-imgCoppapseContact").attr('class') == "imgCollapseFieldset down"){
			$("#Contrato-imgCoppapseContact").removeClass('down');
			$("#Contrato-imgCoppapseContact").addClass('up');
			$("#Contrato-imgCoppapseContact").attr( 'src', BASE_URL+'assets/img/common/iconCollapseUp.png' );
			gotoDiv('contentModalPeople','textEmail2');
		}else{
			$("#Contrato-imgCoppapseContact").removeClass('up');
			$("#Contrato-imgCoppapseContact").addClass('down');
			$("#Contrato-imgCoppapseContact").attr( 'src', BASE_URL+'assets/img/common/iconCollapseDown.png' )
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
	if($("#Contrato-RadioMale").is(':checked')) {
		gender = "2";
	}else{
		gender = "1";
	}
	
	var employee = 0;
	var pkEmployeeId = 0;
	//si se estan editando los datos
	if( id > 0 ){
		//si esta activado la opcion de empleado
		if($("#Contrato-checkPeopleEmployee").is(':checked')) {
			employee = 1;
			pkEmployeeId = $('#Contrato-idPeople').data("pkEmployeeId");
		}
	}
	
	$.ajax({
   		type: "POST",
       	url: "people/savePeople",
		dataType:'json',
		data: { 
			id:id,
			name:$('#Contrato-textName').val().trim().toUpperCase(),
			SecondName:$('#Contrato-textMiddleName').val().trim().toUpperCase(),
			lName:$('#Contrato-textLastName').val().trim().toUpperCase(),
			lName2:$('#Contrato-TextSecondLastName').val().trim().toUpperCase(),
			birthDate:$('#Contrato-textBirthdate').val().trim(),
			gender:gender,
			WeddingAnniversary:$('#Contrato-textWeddingAnniversary').val().trim(),
			nationality:$('#Contrato-textNationality').val(),
			qualification:$('#Contrato-textQualification').val(),
			street:$('#Contrato-textStreet').val().trim(),
			colony:$('#Contrato-textColony').val().trim(),
			city:$('#Contrato-textCity').val().trim(),
			state:$('#Contrato-textState').val(),
			country:$('#Contrato-textCountry').val(),
			postalCode:$('#Contrato-textPostalCode').val().trim(),
			stateCode:$('#Contrato-textState option:selected').attr('code'),
			countryCode:$('#Contrato-textCountry option:selected').attr('code'),
			phone:jsonPhone,
			email:jsonEmail,
			pkEmployeeId:pkEmployeeId,
			employee:employee,
			codeCollaborator:$('#Contrato-textCodeCollaborator').val().trim(),
			initials:$('#Contrato-textInitials').val().trim(),
			codeNumber:$('#Contrato-textCodeNumber').val().trim(),
			typeSeller:$('#Contrato-textTypeSeller').val(),
			roster:$('#Contrato-textRoster').val(),
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
					$("#Contrato-idPeople").removeData("pkPeopleId");
					$("#Contrato-idPeople").removeData("pkEmployeeId");
				}else{
					$("#Contrato-idPeople").data("pkPeopleId",data.pkPeopleId);
					$('.dialogModalButtonSecondary').show();
				}
				if($('#Contrato-tablePeople >tbody >tr').length != 0){
					var currentPage = $('#Contrato-paginationPeople').jqPagination('option', 'current_page');
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
			$("#Contrato-idPeople").removeData("pkPeopleId");
			$("#Contrato-idPeople").removeData("pkEmployeeId");
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
	
//	alert($("#Contrato-checkPeopleEmployee").is(':checked'))
	
	if($("#Contrato-checkPeopleEmployee").is(':checked')){
		
		if($('#Contrato-textCodeCollaborator').val().trim().length == 0 ){
			$('#Contrato-alertCodeCollaborator').addClass('error');
			$('#Contrato-textCodeCollaborator').focus();
			errorText = "Código del colaborador<br>" + errorText;
			infoEmployee = false;
		}
		
		if($('#Contrato-textInitials').val().trim().length == 0 ){
			$('#Contrato-alertInitials').addClass('error');
			$('#Contrato-textInitials').focus();
			errorText = "Iniciales<br>" + errorText;
			infoEmployee = false;
		}
		
		if($('#Contrato-textCodeNumber').val().trim().length == 0 ){
			$('#Contrato-alertCodeNumber').addClass('error');
			$('#Contrato-textCodeNumber').focus();
			errorText = "Código numérico<br>" + errorText;
			infoEmployee = false;
		}
		
		if($('#Contrato-textTypeSeller').val() == null || $('#Contrato-textTypeSeller').val() == 0){
			$('#Contrato-alertTypeSeller').addClass('error');
			$('#Contrato-textTypeSeller').focus();
			errorText = "Tipo de vendedor<br>" + errorText;
			infoEmployee = false;
		}
		
		if(infoEmployee == false){
			$('#Contrato-alertValPeopleEmployee .alert-box').html("<label>Please complete fields in red</label>" );
			$('#Contrato-alertValPeopleEmployee').show(100);
			result = false;
		}
	}
	
	var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
	//email 2
	if($('#Contrato-textEmail2').val().trim().length > 0){
		if(!regex.test($('#Contrato-textEmail2').val().trim())){
			$('#Contrato-alertEmail2').addClass('error');
			$('#Contrato-textEmail2').focus();
			errorText = "El correo 2 debe ser valido<br>"  + errorText;
			infoContact = false;
		}
	}
	if($('#Contrato-textEmail1').val().trim().length > 0){
		if(!regex.test($('#Contrato-textEmail1').val().trim())){
			$('#Contrato-alertEmail1').addClass('error');
			$('#Contrato-textEmail1').focus();
			errorText = "EL correo debe ser valido</br>"  + errorText;
			infoContact = false;
		}
	}
	
	//Telefono 3
	if($('#Contrato-textPhone3').val().trim().length > 0 && $('#Contrato-textPhone3').val().trim().length > 14 ){
		$('#Contrato-alertPhone3').addClass('error');
		$('#Contrato-textPhone3').focus();
		errorText = "El telefono 3 debe tener maximo 11 caracteres<br>"  + errorText;
		infoContact = false;
	}
	
	//Telefono 2
	if($('#Contrato-textPhone2').val().trim().length > 0 && $('#Contrato-textPhone2').val().trim().length > 14 ){
		$('#Contrato-alertPhone2').addClass('error');
		$('#Contrato-textPhone2').focus();
		errorText = "El telefono 2 debe tener maximo 11 caracteres<br>"  + errorText;
		infoContact = false;
	}
	
	//Telefono 2
	if($('#Contrato-textPhone1').val().trim().length > 0 && $('#Contrato-textPhone1').val().trim().length > 14 ){
		$('#Contrato-alertPhone1').addClass('error');
		$('#Contrato-textPhone1').focus();
		errorText = "El telefono 1 debe tener maximo 11 caracteres<br>"  + errorText;
		infoContact = false;
	}
	
	if(infoContact == false){
		result = false;
		$('#Contrato-alertValPeopleContact .alert-box').html("<label>Please complete fields in red</label>" + errorText );
		$('#Contrato-alertValPeopleContact').show(100);
		$('#Contrato-containerContact').show();
	}
	
	errorText = "";
	
	//fecha de nacimiento
	if($('#Contrato-textPostalCode').val().trim().length == 0){
		$('#Contrato-alertPostalCode').addClass('error');
		$('#Contrato-textPostalCode').focus();
		errorText = "Codigo postal<br>"  + errorText;
		infoAddress = false;
	}
	
	//Ciudad
	if($('#Contrato-textCity').val().trim().length == 0){
		$('#Contrato-alertCity').addClass('error');
		$('#Contrato-textCity').focus();
		errorText = "Ciudad<br>"  + errorText;
		infoAddress = false;
	}
	
	//country
	if($('#Contrato-textCountry').val() == 0){
		$('#Contrato-alertCountry').addClass('error');
		$('#Contrato-textCountry').focus();
		errorText = "Pais<br>"  + errorText;
		infoAddress = false;
	}
	
	//estado
	if($('#Contrato-textState').val() == 0){
		$('#Contrato-alertState').addClass('error');
		$('#Contrato-textState').focus();
		errorText = "Estado<br>"  + errorText;
		infoAddress = false;
	}
	
	//calle
	if($('#Contrato-textStreet').val().trim().length == 0){
		$('#Contrato-alertStreet').addClass('error');
		$('#Contrato-textStreet').focus();
		errorText = "Calle<br>"  + errorText;
		infoAddress = false;
	}
	if(infoAddress == false){
		result = false;
		$('#Contrato-alertValPeopleAddress .alert-box').html("<label>Please complete fields in red</label>" + errorText );
		$('#Contrato-alertValPeopleAddress').show(100);
		$('#Contrato-containerAddress').show();
	}
	
	errorText = "";
	
	//validate fecha
	
	//aniversario
	if($('#Contrato-textWeddingAnniversary').val().trim().length > 0){
			if(!isDate($('#Contrato-textWeddingAnniversary').val())){
			$('#Contrato-alertWeddingAnniversary').addClass('error');
			//$('#Contrato-textWeddingAnniversary').focus();
			errorText = "Selecione una fecha de aniversario correcta>"  + errorText;
			infoPeople = false;
		}
	}
	//alert(regex2.test($('#Contrato-textBirthdate').val())
	//fecha
	if($('#Contrato-textBirthdate').val().trim().length > 0){
		if(!isDate($('#Contrato-textBirthdate').val())){
			$('#Contrato-alertBirthdate').addClass('error');
			//$('#Contrato-textBirthdate').focus();
			errorText = "Selecione una fecha correctabr>"  + errorText;
			infoPeople = false;
		}
	}
	
	//fecha de nacimiento
	if($('#Contrato-textBirthdate').val().trim().length == 0){
		$('#Contrato-alertBirthdate').addClass('error');
		//$('#Contrato-textBirthdate').focus();
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
		$('#Contrato-alertGender').addClass('error');
		errorText = "Genero<br>"  + errorText;
		infoPeople = false;
	}
	
	//apellido paterno
	if($('#Contrato-textLastName').val().trim().length == 0){
		$('#Contrato-alertLastName').addClass('error');
		$('#Contrato-textLastName').focus();
		errorText = "Apellido paterno<br>"  + errorText;
		infoPeople = false;
	}
	//nombre
	if($('#Contrato-textName').val().trim().length == 0){
		$('#Contrato-alertName').addClass('error');
		$('#Contrato-textName').focus();
		errorText =  "Nombre<br>" + errorText;
		infoPeople = false;
	}
	
	if(infoPeople == false){
		$('#Contrato-alertValPeopleGeneral .alert-box').html("<label>Please complete fields in red</label>" + errorText );
		$('#Contrato-alertValPeopleGeneral').show(100);
		result = false;
	}
	
	return result;
}

/**
* esconde las alertas de validacion
*/
function hideAlertUserFields(){
	$('#Contrato-alertValPeopleGeneral').hide();
	$('#Contrato-alertValPeopleAddress').hide();
	$('#Contrato-alertValPeopleContact').hide();
	$('#Contrato-alertValPeopleEmployee').hide();
	
	$('#Contrato-alertName').removeClass('error');
	$('#Contrato-alertLastName').removeClass('error');
	$('#Contrato-alertBirthdate').removeClass('error');
	$('#Contrato-alertGender').removeClass('error');
	$('#Contrato-alertWeddingAnniversary').removeClass('error');
	
	$('#Contrato-alertStreet').removeClass('error');
	$('#Contrato-alertColony').removeClass('error');
	$('#Contrato-alertCity').removeClass('error');
	$('#Contrato-alertState').removeClass('error');
	$('#Contrato-alertCountry').removeClass('error');
	$('#Contrato-alertPostalCode').removeClass('error');
	
	$('#Contrato-alertPhone1').removeClass('error');
	$('#Contrato-alertPhone2').removeClass('error');
	$('#Contrato-alertPhone3').removeClass('error');
	$('#Contrato-alertEmail1').removeClass('error');
	$('#Contrato-alertEmail2').removeClass('error');
	
	$('#Contrato-alertCodeCollaborator').removeClass('error');
	$('#Contrato-alertInitials').removeClass('error');
	$('#Contrato-alertCodeNumber').removeClass('error');
	$('#Contrato-alertTypeSeller').removeClass('error');
	$('#Contrato-alertRoster').removeClass('error');
}

/**
* limpia los campos de people
*/
function cleanUserFields(){
	hideAlertUserFields();
	$('#Contrato-textName').val("");
	$('#Contrato-textLastName').val("");
	$('#Contrato-TextSecondLastName').val("");
	$('#Contrato-textBirthdate').val("");
	$('#Contrato-textWeddingAnniversary').val("");
	//$('#Contrato-textNationality').val("");
	//$('#Contrato-textQualification').val("");
	$('#Contrato-RadioMale').prop( "checked", false );
	$("#Contrato-RadioFemale").prop( "checked", false );
	
	$('#Contrato-textStreet').val("");
	$('#Contrato-textColony').val("");
	$('#Contrato-textCity').val("");
	$('#Contrato-textCountry').val(0);
	$('#Contrato-textState').val(0);
	$("select#textCountry").val("0");
	$("select#textState").val("0");
	$('#Contrato-textPostalCode').val("");
	
	$('#Contrato-textPhone1').val("");
	$('#Contrato-textPhone2').val("");
	$('#Contrato-textPhone3').val("");
	$('#Contrato-textEmail1').val("");
	$('#Contrato-textEmail2').val("");
	
	$('#Contrato-textCodeCollaborator').val("");
	$('#Contrato-textInitials').val("");
	$('#Contrato-textCodeNumber').val("");
	$('#Contrato-textTypeSeller').val(0);
	$('#Contrato-textRoster').val(0);
	$('#Contrato-checkPeopleEmployee').prop( "checked", false );
	
	$('#Contrato-containerAddress').hide();
	$('#Contrato-containerContact').hide();
	
	$("#Contrato-idPeople").removeData("pkPeopleId");
	$("#Contrato-idPeople").removeData("pkEmployeeId");
	
	$('#Contrato-tableReservationsPeople tbody').empty();
	$('#Contrato-tableContractPeople tbody').empty();
	
	$('#Contrato-textSearchContractPeople').val("");
	
	changeTabsModalPeople("tab-PGeneral");
}

function searchPeople(page){
	
	$('#Contrato-tablePeople tbody').empty();
	showLoading('#Contrato-section-table-people',true);
	
	var typePeople = $('#Contrato-btnSearch').attr('attr_people');
	
	//noResults('#Contrato-section-table-people',false);
	opcionAdvanced = "";
	if($('#Contrato-checkFilterAdvance').is(':checked')){
		opcionAdvanced = $('.RadioSearchPeople:checked').val();
	}
	$.ajax({
   		type: "POST",
       	url: "people/getPeopleBySearch",
		dataType:'json',
		data: {
			search:$("#Contrato-txtSearch").val().trim(),
			peopleId:$("#Contrato-checkFilter1").is(':checked'),
			lastName:$("#Contrato-checkFilter2").is(':checked'),
			name:$("#Contrato-checkFilter3").is(':checked'),
			advanced:opcionAdvanced,
			typePeople:typePeople,
			page:page,
		},
		success: function(data){
			if(data.items.length > 0){
				alertify.success("Found "+ 25 + " People");
				$('#Contrato-paginationPeople').val(true);
				drawTable2(data.items,"tablePeople","showModal","Edit");
				
				if( jQuery.isFunction( "markRowTableFrontDesk" ) ){
					var typePeople = $("#Contrato-dialog-people-hkConfig").find('#Contrato-btnSearch').attr('attr_people');
					if(typePeople == "maid"){
						markRowTableFrontDesk( "tablePeople", "tablePeopleMaidSelectedHKC" );
					}else if(typePeople == "superior"){
						markRowTableFrontDesk( "tablePeople", "tablePeopleSupeSelectedHKC" );
					}
				}
			}else{
				noResultsPeople("section-table-people", "tablePeople", "No results found");
			}
			showLoading('#Contrato-section-table-people',false);
		},
		error: function(error){
			noResultsPeople("section-table-people", "tablePeople", "Try again");
			showLoading('#Contrato-section-table-people',false);
		}
	});
}

/**
* Limpia el campo de busqueda de personas
*/
function CleandFieldSearch(){
	$("#Contrato-txtSearch").val("");
}

/**
* muestra las busquedas avanzadas
*/
function searchAdvanced(){
	$('#Contrato-containerFilterAdv').toggle(1000);
	if($("#Contrato-checkFilterAdvance").is(':checked')) {
		$('#Contrato-fieldsetFilterAdvanced').removeClass('fieldsetFilter-advanced-hide');
		$('#Contrato-fieldsetFilterAdvanced').addClass('fieldsetFilter-advanced-show');
	}else{
		$('#Contrato-fieldsetFilterAdvanced').addClass('fieldsetFilter-advanced-hide');
		$('#Contrato-fieldsetFilterAdvanced').removeClass('fieldsetFilter-advanced-show');
	}
}

/**
 * Carga el paginador
 */
function loadPaginatorPeople(maxPage){
	$('#Contrato-paginationPeople').jqPagination('option', 'max_page', maxPage);
}

function getInfoPeople(id){
	showLoading('#Contrato-section-table-people',true);
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
			$('#Contrato-textName').val(item.Name.toUpperCase());
			$('#Contrato-textMiddleName').val(item.SecondName);
			$('#Contrato-textLastName').val(item.LName);
			$('#Contrato-TextSecondLastName').val(item.LName2);
			
			if(item.fkGenderId == "2"){
				$('#Contrato-RadioMale').prop("checked", true);
			}else if(item.fkGenderId == "1"){
				$("#Contrato-RadioFemale").prop("checked", true);
			}
			$('#Contrato-textBirthdate').val(item.birthdate);
			$('#Contrato-textWeddingAnniversary').val(item.Anniversary);
			$('#Contrato-textNationality').val(item.Nationality.trim())
			$('#Contrato-textQualification').val(item.Qualification.trim());
			$('#Contrato-textStreet').val(item.Street1.trim());
			$('#Contrato-textColony').val(item.Street2.trim());
			$('#Contrato-textCity').val(item.City.trim());
			$('#Contrato-textPostalCode').val(item.ZipCode.trim());
			if(item.pkCountryId != null || item.pkCountryId == ""){
				$("select#textCountry").val(item.pkCountryId);
			}else{
				$("select#textCountry").val(0);
			}
			$('#Contrato-textState').empty();
			$('#Contrato-textState').append('<option value="0" code="0">Select your state</option>');
			if(data.states.length > 0){
				for(i=0;i<data.states.length;i++){
					var state = data.states[i];
					$('#Contrato-textState').append('<option value="' + state.pkStateId + '" code="' + state.StateCode + '">' + state.StateDesc + '</option>');
				}
			}
			if(item.pkStateId != null || item.pkStateId == ""){
				$("select#textState").val(item.pkStateId);
			}else{
				$("select#textState").val(0);
			}
			
			$('#Contrato-textPhone1').val(item.phone1.trim());
			$('#Contrato-textPhone2').val(item.phone2.trim());
			$('#Contrato-textPhone3').val(item.phone3.trim());
			$('#Contrato-textEmail1').val(item.email1.trim());
			$('#Contrato-textEmail2').val(item.email2.trim());
			$("#Contrato-textPhone1").mask("(999) 999-9999");
			$("#Contrato-textPhone2").mask("(999) 999-9999");
			$("#Contrato-textPhone3").mask("(999) 999-9999");
			$('#Contrato-textTypeSeller').empty();
			$('#Contrato-textTypeSeller').append('<option value="0" code="0">Select a type of seller</option>');
			for(i=0;i<data.peopleType.length;i++){
				var peopleType = data.peopleType[i];
				$('#Contrato-textTypeSeller').append('<option value="' + peopleType.pkPeopleTypeId + '" code="' + peopleType.PeopleTypeCode + '">' + peopleType.PeopleTypeDesc + '</option>');
			}
			
			if(item.pkEmployeeId > 0){
				$("#Contrato-checkPeopleEmployee").prop( "checked", true );
				$('#Contrato-textCodeCollaborator').val(item.EmployeeCode.trim());
				$('#Contrato-textInitials').val(item.InitialsEmplo.trim());
				$('#Contrato-textCodeNumber').val(item.NumericCode);
				$('#Contrato-textTypeSeller').val(item.fkPeopleTypeId);
				$('#Contrato-textRoster').val(0);
				$('#Contrato-textTypeSeller').val(item.fkPeopleTypeId);
				$('#Contrato-textRoster').val(item.fkVendorTypeId);
			}
			
			$("#Contrato-idPeople").data("pkPeopleId",item.pkPeopleId);
			$("#Contrato-idPeople").data("pkEmployeeId",item.pkEmployeeId);
			$('#Contrato-imgCloseModal').off();
			$('.imgCloseModal').on('click', function() {  hideModal(); });
			$('body, html').animate({
				scrollTop: '0px'
			}, 0);
			dialogUser.dialog( 'open' )
			showLoading('#Contrato-section-table-people',false);
		},
		error: function(error){
			showLoading('#Contrato-section-table-people',false);
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
	$('#Contrato-tabsModalPeople .tabs .tabs-title').removeClass('active');
	$('#Contrato-tabsModalPeople .tabs li[attr-screen=' + screen + ']').addClass('active');
	//muestra la pantalla selecionada
	$('#Contrato-contentModalPeople .tab-modal').hide();
	$('#Contrato-' + screen).show();
	if($("#Contrato-idPeople").data("pkPeopleId") != undefined ){
		if(screen == "tab-PReservaciones"){
			getInfoTabsPeople(screen, "people/getReservationsByPeople");
		}else if(screen == "tab-PContratos"){
			getInfoTabsPeople(screen, "people/getContractByPeople");
		}else if(screen == "tab-PEmpleados"){
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
	if(screen == "tab-PReservaciones"){
		deleteTableInv("tableReservationsPeople");
		showLoading('#Contrato-tab-PReservaciones',true);
		$('#Contrato-tableReservationsPeople tbody').empty();
		//noResults('#Contrato-' + screen,false);
	}else{
		deleteTableInv("tableContractPeople");
		showLoading('#Contrato-tab-PContratos',true);
		$('#Contrato-tableContractPeople tbody').empty();
		search = $('#Contrato-textSearchContractPeople').val();
		//noResults('#Contrato-' + screen,false);
	}
	$.ajax({
   		type: "POST",
       	url: url,
		dataType:'json',
		data: {
			id:$("#Contrato-idPeople").data("pkPeopleId"),
			search:search
		},
		success: function(data){
			if(screen == "tab-PReservaciones"){
				if(data.items.length > 0){
					drawTable2(data.items,"tableReservationsPeople",false,"tabla");
				}else{
					//$('#Contrato-tableReservationsPeople tbody').empty();
					noResultsPeople("tab-PReservaciones", "tableReservationsPeople", "No results found");
				}
				
			}else if(screen == "tab-PContratos"){
				if(data.items.length > 0){
					drawTable2(data.items,"tableContractPeople",false,"tabla");
				}else{
					noResultsPeople("divTableContractPeople", "tableContractPeople", "No results found");
				}
			}else if(screen == "tab-PEmpleados"){
				$('#Contrato-textTypeSeller').empty();
				$('#Contrato-textTypeSeller').append('<option value="0" code="0">Select a type of seller</option>');
				for(i=0;i<data.items.length;i++){
					var item = data.items[i];
					$('#Contrato-textTypeSeller').append('<option value="' + item.pkPeopleTypeId + '" code="' + item.PeopleTypeCode + '">' + item.PeopleTypeDesc + '</option>');
				}
			}
			if(screen == "tab-PReservaciones"){
				showLoading('#Contrato-tab-PReservaciones',false);
			}else{
				showLoading('#Contrato-tab-PContratos',false);
			}
		},
		error: function(error){
			if(screen == "tab-PReservaciones"){
				showLoading('#Contrato-tab-PReservaciones',false);
				noResultsPeople("tab-PReservaciones", "tableReservationsPeople", "Try again");
			}else{
				showLoading('#Contrato-tab-PContratos',false);
				noResultsPeople("divTableContractPeople", "tableReservationsPeople", "Try again");
			}
			//showAlert(true,"Error in the search, try again later.",'button',showAlert);
		}
	});
}

/**
 * limpia el campo de busqueda de contactos-persona
 */
function CleandFieldSearchPContract(){
	$('#Contrato-textSearchContractPeople').val("");
}

/**
 * Clona los datos del usuario selecionado
 */
function clonePeople(){
	$("#Contrato-idPeople").removeData("pkPeopleId");
	$("#Contrato-idPeople").removeData("pkEmployeeId");
	$('#Contrato-textName').val("");
	//$('#Contrato-textLastName').val("");
	$('#Contrato-textMiddleName').val("");
	$('#Contrato-TextSecondLastName').val("");
	$('#Contrato-textNationality').val(0);
	$('#Contrato-textQualification').val(0);
	$('.RadioGender').prop('checked', false)
	$('#Contrato-textBirthdate').val("");
	$('#Contrato-textWeddingAnniversary').val("");
	
	$('#Contrato-textEmail1').val("");
	$('#Contrato-textEmail2').val("");
	
	$('#Contrato-textCodeCollaborator').val("");
	$('#Contrato-textInitials').val("");
	$('#Contrato-textCodeNumber').val("");
	$('#Contrato-textTypeSeller').val(0);
	$('#Contrato-textRoster').val(0);
	$('#Contrato-checkPeopleEmployee').prop( "checked", false );
	
	$('#Contrato-tableReservationsPeople tbody').empty();
	$('#Contrato-tableContractPeople tbody').empty();
	
	$('#Contrato-textSearchContractPeople').val("");
	
	changeTabsModalPeople("tab-PGeneral")
	
	validateUserFields();
	
}

/**
* Cambia el cotenido del select estado dependiendo de lo selecionado en country
* @param idCountry identificador del pais
*/
function changeState(selector){
	var idCountry = $(selector).val();
	$('#Contrato-textState').empty();
	$('#Contrato-textState').append('<option value="0" code="0">Select your state</option>');
	$('#Contrato-textState').attr('disabled',true);
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
					$('#Contrato-textState').append('<option value="' + item.pkStateId + '" code="' + item.StateCode + '">' + item.StateDesc + '</option>');
				}
			}else{
				$('#Contrato-textState').empty();
				$('#Contrato-textState').append('<option value="0" code="0">' + data.message + '</option>');
			}
			$('#Contrato-textState').attr('disabled',false);
		},
		error: function(error){
			$('#Contrato-textState').empty();
			$('#Contrato-textState').append('<option value="0" code="0">Select your state</option>');
			$('#Contrato-textState').attr('false',false);
			alertify.error('Error inserting data, try again later.');
			//showAlert(true,"Error in the search, try again later.",'button',showAlert);
		}
	});
}

function noResultsPeople(section, table, message){
	alertify.error(message);
	//noResults('#Contrato-' + section,true);
	deleteTableInv(table);
}

function deleteTableInv(table){
	if ( $.fn.dataTable.isDataTable( '#Contrato-' + table ) ){
		var tabla = $( '#Contrato-' + table ).DataTable();
		tabla.destroy();
	}
	$('#Contrato-' + table).hide();
}

function tesCreatePeople(){
	$("#Contrato-textName").val(randomNames());
	$("#Contrato-textMiddleName").val(randomNames());
	$("#Contrato-textLastName").val(ramdomLastName());
	$("#Contrato-TextSecondLastName").val(ramdomLastName());
	setRandomGender();
	$("#Contrato-textWeddingAnniversary").val(randomDate);
	$("#Contrato-textBirthdate").val(randomDate);
	$("#Contrato-textNationality").val("Mexican");
	$("#Contrato-textQualification").val(getRandomInt(1,4));
	$("#Contrato-textStreet").val(makeRandonNames(7));
	$("#Contrato-textColony").val(makeRandonNames(7))
	$("#Contrato-textCountry").val(41);
	$("#Contrato-textState").val(957);
	$("#Contrato-textCity").val("Cancun");
	$("#Contrato-textPostalCode").val(getRandomNumber(5));
	$("#Contrato-textPhone1").val(getRandomNumber(10));
	$("#Contrato-textPhone1").val(getRandomNumber(10));
	$("#Contrato-textPhone2").val(getRandomNumber(10));
	$("#Contrato-textEmail1").val(getRandomEmail());
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
		$("#Contrato-RadioFemale").prop( "checked", true );
	}else{
		$("#Contrato-RadioMale").prop( "checked", true );
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