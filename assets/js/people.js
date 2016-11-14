/**
* @fileoverview Funciones del screen people (alta/busqueda)
*
* @author Alfredo Chi
* @version 0.1
*/

var dataTablePeople = null;
var dataTableReservationsPeople = null
var dialogReservationPeople = modalEditReservationFromPeople();
var maxHeight = 400;
isSearch = true;
var xhrPeople;
var idPeople = 0;
var msgPeople = null;

/**************Index****************/

//muestra el modal de usuarios
$('#newUser').off();
$('#newUser').on('click', function() {  showModal(0); });
//esconde el modal de usuarios
//$(document).on('click','.imgCloseModal', function(){ hideModal(); });

//$('#minusPeople').click(function(){ $(".fiter-section .box").toggle(); });


//busqueda de usuarios
$('#btnSearch').off();
$('#btnSearch').on('click', function() {  searchPeople(0); });
//busqueda de usuarios mediante enter
$('#txtSearch').keyup(function(e){
    if(e.keyCode ==13){
		searchPeople(0);	
    }
});
//limpia el campo busqueda
$('#btnCleanSearch').off();
$('#btnCleanSearch').on('click', function() {  CleandFieldSearch(); });
//muestra u oculta la busqueda avanzada
$('#checkFilterAdvance').off();
$('#checkFilterAdvance').on('click', function() {  searchAdvanced(); });

//editar persomas

$('#textSearchContractPeople').keyup(function(e){
    if(e.keyCode ==13){
		getInfoTabsPeople( "tab-PContratos", "people/getContractByPeople" ); 	
    }
});

//borra la busqueda
$('#btnCleanSearchContractPeople').off();
$('#btnCleanSearchContractPeople').on('click', function() {  CleandFieldSearchPContract(); });



/************Funciones**************/

/**
* Carga el modal
*/
$(document).ready(function(){

	/*maxHeight = screen.height * .10;
	maxHeight = screen.height - maxHeight;*/
	getSizeModal();
	dialogUser = createModalDialog();
	activarPAG();
	
	expandBox("section-people","box-people-relation")
});

function activarPAG(){

		$('#paginationPeople').jqPagination({
		max_page: 1,
		paged: function(page) {
			var PI = $('#paginationPeopleInput').val();

			if(PI == "true"){
				$('#paginationPeopleInput').val(false);
			}
			else if (PI == "false") {
				searchPeople(page);
				$('#paginationPeopleInput').val(true);
			}
		}
	});
}

function createModalDialog(id){
	var div = "#dialog-User";
	dialog = $( "#dialog-User" ).dialog({
		open : function (event){
				showLoading(div,true);
				$(this).load("people/modalPeople2" , function(){
		    		showLoading(div,false);
					$("#textPhone1").mask("(999) 999-9999");
					$("#textPhone2").mask("(999) 999-9999");
					$("#textPhone3").mask("(999) 999-9999");
					$( "#textBirthdate" ).Zebra_DatePicker({
						format: 'm/d/Y',
						show_icon: false,
					});
					
					$( "#textWeddingAnniversary" ).Zebra_DatePicker({
						format: 'm/d/Y',
						show_icon: false,
					});
					cleanUserFields();
					$('#contentModalPeople .tab-modal').hide();
					$('#contentModalPeople #tab-PGeneral').show();
					
					//muestra o oculta los datos del domicilio
					$('.btnAddressData').off();
					$('.btnAddressData').on('click', function(){ showDivModal('address'); });
					//muestra o oculta la informacion de contacto
					$('.btnContactData').off();
					$('.btnContactData').on('click', function(){ showDivModal('contact'); });
					
					if(id == 0){
						$('.dialogModalButtonSecondary').hide();
						$("#tabsModalPeople").hide();
						
						$('#imgCloseModal').off();
						$('.imgCloseModal').on('click', function() {  hideModal(); });
					}else{
						//$( "#dialog-User" ).dialog( "option", "title", "People > Edit person" );
						$('.dialogModalButtonSecondary').show();
						$("#tabsModalPeople").show();
						$('#dialog-User .contentModal').css('height', "90%" );
						getInfoPeople(id);
					}
					
					//activa los tap del modal
					$('#tabsModalPeople .tabs .tabs-title').off();
					$('#tabsModalPeople .tabs .tabs-title').on('click', function() { changeTabsModalPeople($(this).attr('attr-screen')) });

					//busqueda de contrado por folio
					$('#btnSearchContractPeople').off();
					$('#btnSearchContractPeople').on('click', function() { getInfoTabsPeople( "tab-PContratos", "people/getContractByPeople" );  });
					
					//detecta cuando se cambia el valor del select de pais(country)
					$(document).off('change', "#textCountry");
					$(document).on('change', "#textCountry", function () {
						changeState(this);
					});
					
					dialogUser.css('overflow', 'hidden');
	    		});
		},
		autoOpen: false,
		height: maxHeight,
		width: maxWidth,
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
					$("#idPeople").removeData("pkPeopleId");
					$("#idPeople").removeData("pkEmployeeId");
				}
			},
			{
				text: "Save and close",
				"class": 'dialogModalButtonAccept',
				click: function() {
					if($("#idPeople").data("pkPeopleId") == undefined ){
						CreateNewUser(false)
					}else{
						EditUser(false, $("#idPeople").data("pkPeopleId") )
					}
				}
			},
			{
				text: "Save",
				"class": 'dialogModalButtonAccept',
				click: function() {
					if($("#idPeople").data("pkPeopleId") == undefined){
						CreateNewUser(true)
					}else{
						EditUser(true, $("#idPeople").data("pkPeopleId") )
					}
					
				}
			},
		],
		close: function() {
			$("#idPeople").removeData("pkPeopleId");
			$("#idPeople").removeData("pkEmployeeId");
			cleanUserFields();
			$('#dialog-Unidades').empty();
		}
	});
	return dialog;
	
}

function getSizeModal(){
	maxHeight = screen.height;
	if (screen.width < 760) {
		maxWidth = "100%";
	}else{
		maxWidth = "55%";
		maxHeight = screen.height - parseInt(screen.height * .10);
	}
}


/**
* muestra el modal de personas
* @param id id de la persona
*/
function showModal(id){
	
	//dialogUser.dialog('option', 'position', { my: "center", at: "center", of: window });
	$("#idPeople").removeData("pkPeopleId");
	$("#idPeople").removeData("pkEmployeeId");
	//cleanUserFields();
	//$('.tab-modal').hide();
	//$('#tab-PGeneral').show();
	/*
		if (typeof unidadResDialog !== 'undefined') {
		if (unidadResDialog!=null) {
			unidadResDialog.dialog( "destroy" );
		}
	}
	if (typeof peopleDialog !== 'undefined') {
		if (peopleDialog != null) {
			peopleDialog.dialog( "destroy" );
		}
	}
	if (typeof dialogUser !== 'undefined') {
		if (dialogUser!=null) {
		dialogUser.dialog( "destroy" );
	}
	}
	*/
	if (dialogUser!=null) {
		dialogUser.dialog( "destroy" );
	}
	
	dialogUser = createModalDialog(id);
	dialogUser.dialog('open');
	if(id == 0){
		//$('.dialogModalButtonSecondary').hide();
		//$("#tabsModalPeople").hide();
		
		dialogUser.dialog( "option", "title", "People > Create person" );
		//$('#imgCloseModal').off();
		//$('.imgCloseModal').on('click', function() {  hideModal(); });
	}else{
		dialogUser.dialog( "option", "title", "People > Edit person" );
		/*$('.dialogModalButtonSecondary').show();
		$("#tabsModalPeople").show();
		$('#dialog-User .contentModal').css('height', "90%" );
		getInfoPeople(id);*/	
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
		$('#containerAddress').toggle(1000);
		if($("#imgCoppapseAddress").attr('class') == "imgCollapseFieldset down"){
			$("#imgCoppapseAddress").removeClass('down');
			$("#imgCoppapseAddress").addClass('up');
			$("#imgCoppapseAddress").attr( 'src', BASE_URL+'assets/img/common/iconCollapseUp.png' );
			gotoDiv('contentModalPeople','textPostalCode');
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
			$("#imgCoppapseContact").attr( 'src', BASE_URL+'assets/img/common/iconCollapseUp.png' );
			gotoDiv('contentModalPeople','textEmail2');
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
	
	//showAlert(true,"Saving changes, please wait ....",'progressbar');
	
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
	if($("#RadioMale").is(':checked')) {
		gender = "2";
	}else{
		gender = "1";
	}
	
	var employee = 0;
	var pkEmployeeId = 0;
	//si se estan editando los datos
	if( id > 0 ){
		//si esta activado la opcion de empleado
		if($("#checkPeopleEmployee").is(':checked')) {
			employee = 1;
			pkEmployeeId = $('#idPeople').data("pkEmployeeId");
		}
	}
	
	$.ajax({
   		type: "POST",
       	url: "people/savePeople",
		dataType:'json',
		data: { 
			id:id,
			name:$('#textName').val().trim().toUpperCase(),
			SecondName:$('#textMiddleName').val().trim().toUpperCase(),
			lName:$('#textLastName').val().trim().toUpperCase(),
			lName2:$('#TextSecondLastName').val().trim().toUpperCase(),
			birthDate:$('#textBirthdate').val().trim(),
			gender:gender,
			WeddingAnniversary:$('#textWeddingAnniversary').val().trim(),
			nationality:$('#textNationality').val(),
			qualification:$('#textQualification').val(),
			street:$('#textStreet').val().trim(),
			colony:$('#textColony').val().trim(),
			city:$('#textCity').val().trim(),
			state:$('#textState').val(),
			country:$('#textCountry').val(),
			postalCode:$('#textPostalCode').val().trim(),
			stateCode:$('#textState option:selected').attr('code'),
			countryCode:$('#textCountry option:selected').attr('code'),
			phone:jsonPhone,
			email:jsonEmail,
			pkEmployeeId:pkEmployeeId,
			employee:employee,
			codeCollaborator:$('#textCodeCollaborator').val().trim(),
			initials:$('#textInitials').val().trim(),
			codeNumber:$('#textCodeNumber').val().trim(),
			typeSeller:$('#textTypeSeller').val(),
			roster:$('#textRoster').val(),
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
					$("#idPeople").removeData("pkPeopleId");
					$("#idPeople").removeData("pkEmployeeId");
				}else{
					$("#idPeople").data("pkPeopleId",data.pkPeopleId);
					$('.dialogModalButtonSecondary').show();
				}
				if($('#tablePeople >tbody >tr').length != 0){
					var currentPage = $('#paginationPeople').jqPagination('option', 'current_page');
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
			$("#idPeople").removeData("pkPeopleId");
			$("#idPeople").removeData("pkEmployeeId");
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
	
//	alert($("#checkPeopleEmployee").is(':checked'))
	
	if($("#checkPeopleEmployee").is(':checked')){
		
		if($('#textCodeCollaborator').val().trim().length == 0 ){
			$('#alertCodeCollaborator').addClass('error');
			$('#textCodeCollaborator').focus();
			errorText = "Código del colaborador<br>" + errorText;
			infoEmployee = false;
		}
		
		if($('#textInitials').val().trim().length == 0 ){
			$('#alertInitials').addClass('error');
			$('#textInitials').focus();
			errorText = "Iniciales<br>" + errorText;
			infoEmployee = false;
		}
		
		if($('#textCodeNumber').val().trim().length == 0 ){
			$('#alertCodeNumber').addClass('error');
			$('#textCodeNumber').focus();
			errorText = "Código numérico<br>" + errorText;
			infoEmployee = false;
		}
		
		if($('#textTypeSeller').val() == null || $('#textTypeSeller').val() == 0){
			$('#alertTypeSeller').addClass('error');
			$('#textTypeSeller').focus();
			errorText = "Tipo de vendedor<br>" + errorText;
			infoEmployee = false;
		}
		
		
		
		if(infoEmployee == false){
			$('#alertValPeopleEmployee .alert-box').html("<label>Please complete fields in red</label>" );
			$('#alertValPeopleEmployee').show(100);
			result = false;
		}
	}
	
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
	
	
	if($('#textEmail1').val().trim().length > 0){
		if(!regex.test($('#textEmail1').val().trim())){
			$('#alertEmail1').addClass('error');
			$('#textEmail1').focus();
			errorText = "EL correo debe ser valido</br>"  + errorText;
			infoContact = false;
		}
	}
	
	//Telefono 3
	if($('#textPhone3').val().trim().length > 0 && $('#textPhone3').val().trim().length > 14 ){
		$('#alertPhone3').addClass('error');
		$('#textPhone3').focus();
		errorText = "El telefono 3 debe tener maximo 11 caracteres<br>"  + errorText;
		infoContact = false;
	}
	
	//Telefono 2
	if($('#textPhone2').val().trim().length > 0 && $('#textPhone2').val().trim().length > 14 ){
		$('#alertPhone2').addClass('error');
		$('#textPhone2').focus();
		errorText = "El telefono 2 debe tener maximo 11 caracteres<br>"  + errorText;
		infoContact = false;
	}
	
	//Telefono 2
	if($('#textPhone1').val().trim().length > 0 && $('#textPhone1').val().trim().length > 14 ){
		$('#alertPhone1').addClass('error');
		$('#textPhone1').focus();
		errorText = "El telefono 1 debe tener maximo 11 caracteres<br>"  + errorText;
		infoContact = false;
	}
	
	if(infoContact == false){
		result = false;
		$('#alertValPeopleContact .alert-box').html("<label>Please complete fields in red</label>" + errorText );
		$('#alertValPeopleContact').show(100);
		$('#containerContact').show();
	}
	
	errorText = "";
	
	errorText = "";
	
	//validate fecha
	
	//aniversario
	if($('#textWeddingAnniversary').val().trim().length > 0){
			if(!isDate($('#textWeddingAnniversary').val())){
			$('#alertWeddingAnniversary').addClass('error');
			//$('#textWeddingAnniversary').focus();
			errorText = "Selecione una fecha de aniversario correcta>"  + errorText;
			infoPeople = false;
		}
	}
	//alert(regex2.test($('#textBirthdate').val())
	//fecha
	if($('#textBirthdate').val().trim().length > 0){
		if(!isDate($('#textBirthdate').val())){
			$('#alertBirthdate').addClass('error');
			//$('#textBirthdate').focus();
			errorText = "Selecione una fecha correctabr>"  + errorText;
			infoPeople = false;
		}
	}
	
	//genero
	var gender = 0;
	$(".RadioGender").each(function (index){
		if(!$(this).is(':checked')) {
			gender = gender + 1;
        } 
	});
	
	if(gender != 1){
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
		$('#alertValPeopleGeneral .alert-box').html("<label>Please complete fields in red</label>" + errorText );
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
	$('#alertValPeopleEmployee').hide();
	
	$('#alertName').removeClass('error');
	$('#alertLastName').removeClass('error');
	$('#alertBirthdate').removeClass('error');
	$('#alertGender').removeClass('error');
	$('#alertWeddingAnniversary').removeClass('error');
	
	$('#alertStreet').removeClass('error');
	$('#alertColony').removeClass('error');
	$('#alertCity').removeClass('error');
	$('#alertState').removeClass('error');
	$('#alertCountry').removeClass('error');
	$('#alertPostalCode').removeClass('error');
	
	$('#alertPhone1').removeClass('error');
	$('#alertPhone2').removeClass('error');
	$('#alertPhone3').removeClass('error');
	$('#alertEmail1').removeClass('error');
	$('#alertEmail2').removeClass('error');
	
	$('#alertCodeCollaborator').removeClass('error');
	$('#alertInitials').removeClass('error');
	$('#alertCodeNumber').removeClass('error');
	$('#alertTypeSeller').removeClass('error');
	$('#alertRoster').removeClass('error');
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
	//$('#textQualification').val("");
	$('#RadioMale').prop( "checked", false );
	$("#RadioFemale").prop( "checked", false );
	
	$('#textStreet').val("");
	$('#textColony').val("");
	$('#textCity').val("");
	$('#textCountry').val(0);
	$('#textState').val(0);
	$("select#textCountry").val("0");
	$("select#textState").val("0");
	$('#textPostalCode').val("");
	
	$('#textPhone1').val("");
	$('#textPhone2').val("");
	$('#textPhone3').val("");
	$('#textEmail1').val("");
	$('#textEmail2').val("");
	
	$('#textCodeCollaborator').val("");
	$('#textInitials').val("");
	$('#textCodeNumber').val("");
	$('#textTypeSeller').val(0);
	$('#textRoster').val(0);
	$('#checkPeopleEmployee').prop( "checked", false );
	
	$('#containerAddress').hide();
	$('#containerContact').hide();
	
	$("#idPeople").removeData("pkPeopleId");
	$("#idPeople").removeData("pkEmployeeId");
	
	$('#tableReservationsPeople tbody').empty();
	$('#tableContractPeople tbody').empty();
	
	$('#textSearchContractPeople').val("");
	
	changeTabsModalPeople("tab-PGeneral");
}

//////
/**
* genera una busqueda de usuarios filtrado
* @param page nueva pagina a buscar/ si es 0 es una busqueda nueva
*/
function searchPeople(page){
	//activarPAG();
	
	//var msg = alertify.message('Default message');
	//msg.delay(3).setContent('Wait time updated to 3 Seconds');
	
	$('#tablePeople tbody').empty();
	showLoading('#section-table-people',true);
	
	var typePeople = $('#btnSearch').attr('attr_people');
	
	//noResults('#section-table-people',false);
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
			typePeople:typePeople,
			page:page,
		},
		success: function(data){
			if(data.items.length > 0){
				$("#NP").text("Total: "+ data.items.length);
				var total = data.total;
				alertify.success("Found "+ data.items.length  + " People");
				if( parseInt(total) == 0 ){ total = 1; }
				total = parseInt( total/25 );
				if(data.total%25 == 0){
					total = total - 1;		
				}
				total = total + 1
				// if(page == 0){
				// 	$('#paginationPeopleInput').val(true);
				// 	loadPaginatorPeople(total);
				// }
				$('#paginationPeopleInput').val(true);
				loadPaginatorPeople(total);
				drawTable2(data.items,"tablePeople","showModal","Edit");
				
				if( jQuery.isFunction( "markRowTableFrontDesk" ) ){
					var typePeople = $("#dialog-people-hkConfig").find('#btnSearch').attr('attr_people');
					if(typePeople == "maid"){
						markRowTableFrontDesk( "tablePeople", "tablePeopleMaidSelectedHKC" );
					}else if(typePeople == "superior"){
						markRowTableFrontDesk( "tablePeople", "tablePeopleSupeSelectedHKC" );
					}
				}
			}else{
				noResultsPeople("section-table-people", "tablePeople", "No results found");
			}
			showLoading('#section-table-people',false);
		},
		error: function(error){
			noResultsPeople("section-table-people", "tablePeople", "Try again");
			showLoading('#section-table-people',false);
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
	// var paginador = $('#paginationPeople').jqPagination({
	// 	max_page: maxPage,
	// 	paged: function(page) {
	// 		searchPeople(page);
	// 	}
	// });
}

/**
 * CObtiene la informacion de una persona por identificador
 * @param id identificador de persona a buscar
 */
function getInfoPeople(id){
	showLoading('#section-table-people',true);
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
			$('#textName').val(item.Name.toUpperCase());
			$('#textMiddleName').val(item.SecondName);
			$('#textLastName').val(item.LName);
			$('#TextSecondLastName').val(item.LName2);
			
			if(item.fkGenderId == "2"){
				$('#RadioMale').prop("checked", true);
			}else if(item.fkGenderId == "1"){
				$("#RadioFemale").prop("checked", true);
			}
			$('#textBirthdate').val(item.birthdate);
			$('#textWeddingAnniversary').val(item.Anniversary);
			$('#textNationality').val(item.Nationality.trim())
			$('#textQualification').val(item.Qualification.trim());
			$('#textStreet').val(item.Street1.trim());
			$('#textColony').val(item.Street2.trim());
			$('#textCity').val(item.City.trim());
			$('#textPostalCode').val(item.ZipCode.trim());
			if(item.pkCountryId != null || item.pkCountryId == ""){
				$("select#textCountry").val(item.pkCountryId);
			}else{
				$("select#textCountry").val(0);
			}
			$('#textState').empty();
			$('#textState').append('<option value="0" code="0">Select your state</option>');
			if(data.states.length > 0){
				for(i=0;i<data.states.length;i++){
					var state = data.states[i];
					$('#textState').append('<option value="' + state.pkStateId + '" code="' + state.StateCode + '">' + state.StateDesc + '</option>');
				}
			}
			if(item.pkStateId != null || item.pkStateId == ""){
				$("select#textState").val(item.pkStateId);
			}else{
				$("select#textState").val(0);
			}
			
			$('#textPhone1').val(item.phone1.trim());
			$('#textPhone2').val(item.phone2.trim());
			$('#textPhone3').val(item.phone3.trim());
			$('#textEmail1').val(item.email1.trim());
			$('#textEmail2').val(item.email2.trim());
			$("#textPhone1").mask("(999) 999-9999");
			$("#textPhone2").mask("(999) 999-9999");
			$("#textPhone3").mask("(999) 999-9999");
			$('#textTypeSeller').empty();
			$('#textTypeSeller').append('<option value="0" code="0">Select a type of seller</option>');
			for(i=0;i<data.peopleType.length;i++){
				var peopleType = data.peopleType[i];
				$('#textTypeSeller').append('<option value="' + peopleType.pkPeopleTypeId + '" code="' + peopleType.PeopleTypeCode + '">' + peopleType.PeopleTypeDesc + '</option>');
			}
			
			if(item.pkEmployeeId > 0){
				$("#checkPeopleEmployee").prop( "checked", true );
				$('#textCodeCollaborator').val(item.EmployeeCode.trim());
				$('#textInitials').val(item.InitialsEmplo.trim());
				$('#textCodeNumber').val(item.NumericCode);
				$('#textTypeSeller').val(item.fkPeopleTypeId);
				$('#textRoster').val(0);
				$('#textTypeSeller').val(item.fkPeopleTypeId);
				$('#textRoster').val(item.fkVendorTypeId);
			}
			
			$("#idPeople").data("pkPeopleId",item.pkPeopleId);
			$("#idPeople").data("pkEmployeeId",item.pkEmployeeId);
			$('#imgCloseModal').off();
			$('.imgCloseModal').on('click', function() {  hideModal(); });
			$('body, html').animate({
				scrollTop: '0px'
			}, 0);
			dialogUser.dialog( 'open' )
			showLoading('#section-table-people',false);
		},
		error: function(error){
			showLoading('#section-table-people',false);
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
	$('#tabsModalPeople .tabs .tabs-title').removeClass('active');
	$('#tabsModalPeople .tabs li[attr-screen=' + screen + ']').addClass('active');
	//muestra la pantalla selecionada
	$('#contentModalPeople .tab-modal').hide();
	$('#' + screen).show();
	if($("#idPeople").data("pkPeopleId") != undefined ){
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
		showLoading('#tab-PReservaciones',true);
		$('#tableReservationsPeople tbody').empty();
		//noResults('#' + screen,false);
	}else{
		deleteTableInv("tableContractPeople");
		showLoading('#tab-PContratos',true);
		$('#tableContractPeople tbody').empty();
		search = $('#textSearchContractPeople').val();
		//noResults('#' + screen,false);
	}
	$.ajax({
   		type: "POST",
       	url: url,
		dataType:'json',
		data: {
			id:$("#idPeople").data("pkPeopleId"),
			search:search
		},
		success: function(data){
			if(screen == "tab-PReservaciones"){
				if(data.items.length > 0){
					drawTable2(data.items,"tableReservationsPeople","showReservationPeople","Detail");
				}else{
					//$('#tableReservationsPeople tbody').empty();
					noResultsPeople("tab-PReservaciones", "tableReservationsPeople", "No results found");
				}
				
			}else if(screen == "tab-PContratos"){
				if(data.items.length > 0){
					drawTable2(data.items,"tableContractPeople",false,"tabla");
				}else{
					noResultsPeople("divTableContractPeople", "tableContractPeople", "No results found");
				}
			}else if(screen == "tab-PEmpleados"){
				$('#textTypeSeller').empty();
				$('#textTypeSeller').append('<option value="0" code="0">Select a type of seller</option>');
				for(i=0;i<data.items.length;i++){
					var item = data.items[i];
					$('#textTypeSeller').append('<option value="' + item.pkPeopleTypeId + '" code="' + item.PeopleTypeCode + '">' + item.PeopleTypeDesc + '</option>');
				}
			}
			if(screen == "tab-PReservaciones"){
				showLoading('#tab-PReservaciones',false);
			}else{
				showLoading('#tab-PContratos',false);
			}
		},
		error: function(error){
			if(screen == "tab-PReservaciones"){
				showLoading('#tab-PReservaciones',false);
				noResultsPeople("tab-PReservaciones", "tableReservationsPeople", "Try again");
			}else{
				showLoading('#tab-PContratos',false);
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
	$('#textSearchContractPeople').val("");
}

/**
 * Clona los datos del usuario selecionado
 */
function clonePeople(){
	$("#idPeople").removeData("pkPeopleId");
	$("#idPeople").removeData("pkEmployeeId");
	$('#textName').val("");
	//$('#textLastName').val("");
	$('#textMiddleName').val("");
	$('#TextSecondLastName').val("");
	$('#textNationality').val(0);
	$('#textQualification').val(0);
	$('.RadioGender').prop('checked', false)
	$('#textBirthdate').val("");
	$('#textWeddingAnniversary').val("");
	
	$('#textEmail1').val("");
	$('#textEmail2').val("");
	
	$('#textCodeCollaborator').val("");
	$('#textInitials').val("");
	$('#textCodeNumber').val("");
	$('#textTypeSeller').val(0);
	$('#textRoster').val(0);
	$('#checkPeopleEmployee').prop( "checked", false );
	
	$('#tableReservationsPeople tbody').empty();
	$('#tableContractPeople tbody').empty();
	
	$('#textSearchContractPeople').val("");
	
	changeTabsModalPeople("tab-PGeneral")
	
	validateUserFields();
	
}

/**
* Cambia el cotenido del select estado dependiendo de lo selecionado en country
* @param idCountry identificador del pais
*/
function changeState(selector){
	var idCountry = $(selector).val();
	$('#textState').empty();
	$('#textState').append('<option value="0" code="0">Select your state</option>');
	$('#textState').attr('disabled',true);
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
					$('#textState').append('<option value="' + item.pkStateId + '" code="' + item.StateCode + '">' + item.StateDesc + '</option>');
				}
			}else{
				$('#textState').empty();
				$('#textState').append('<option value="0" code="0">' + data.message + '</option>');
			}
			$('#textState').attr('disabled',false);
		},
		error: function(error){
			$('#textState').empty();
			$('#textState').append('<option value="0" code="0">Select your state</option>');
			$('#textState').attr('false',false);
			alertify.error('Error inserting data, try again later.');
			//showAlert(true,"Error in the search, try again later.",'button',showAlert);
		}
	});
}

function noResultsPeople(section, table, message){
	alertify.error(message);
	//noResults('#' + section,true);
	deleteTableInv(table);
}

function deleteTableInv(table){
	if ( $.fn.dataTable.isDataTable( '#' + table ) ){
		var tabla = $( '#' + table ).DataTable();
		tabla.destroy();
	}
	$('#' + table).hide();
}

function tesCreatePeople(){
	$("#textName").val(randomNames());
	$("#textMiddleName").val(randomNames());
	$("#textLastName").val(ramdomLastName());
	$("#TextSecondLastName").val(ramdomLastName());
	setRandomGender();
	$("#textWeddingAnniversary").val(randomDate);
	$("#textBirthdate").val(randomDate);
	$("#textNationality").val("Mexican");
	$("#textQualification").val(getRandomInt(1,4));
	$("#textStreet").val(makeRandonNames(7));
	$("#textColony").val(makeRandonNames(7))
	$("#textCountry").val(41);
	$("#textState").val(957);
	$("#textCity").val("Cancun");
	$("#textPostalCode").val(getRandomNumber(5));
	$("#textPhone1").val(getRandomNumber(10));
	$("#textPhone1").val(getRandomNumber(10));
	$("#textPhone2").val(getRandomNumber(10));
	$("#textEmail1").val(getRandomEmail());
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
		$("#RadioFemale").prop( "checked", true );
	}else{
		$("#RadioMale").prop( "checked", true );
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


function modalEditReservationFromPeople(id){
	showLoading('#dialog-Edit-ReservationPeople',true);
	dialogo = $("#dialog-Edit-ReservationPeople").dialog ({
  		open : function (event){
	    	$(this).load("reservation/modalEdit?id="+id , function(){
				//$('#tab-general .tabs-title.active').attr('attr-screen'));
				var screen = $('#tab-general .tabs-title.active').attr('attr-screen');
				if( screen == "frontDesk" ){
					$('#tab-general .tabs-title.active').data('idRes', id);
				}
	 			showLoading('#dialog-Edit-ReservationPeople',false);
				if ($('#editReservationStatus').text() == "Status: Out") {
					$(document).off( 'click', '#btNewTransAccRes'); 
				}else{
					$(document).off( 'click', '#btNewTransAccRes, #btAddPayAccRes'); 
					$(document).on( 'click', '#btNewTransAccRes, #btAddPayAccRes', function ( ) {
						eventTransAccRes(this);
					});
				}
	 			getDatosReservation(id);
	 			setEventosEditarReservation(id);
				selectTableUnicoRes("tableCDocumentsSelected");
				
	    	});
		},
		autoOpen: false,
     	height: maxHeight,
     	modal: true,
     	buttons: [
	   	{
       		text: "Close",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			$(this).dialog('close');
       		}
     	}],
     close: function() {
    	$('#dialog-Edit-ReservationPeople').empty();
     }
	});
	return dialogo;
}

function showReservationPeople(id){
	//dialogEditContract.dialog('open');
	var idRes = id;
	var dialogReservationPeople = modalEditReservationFromPeople(idRes);
	dialogReservationPeople.dialog("open");
}