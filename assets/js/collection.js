/**
* @fileoverview Funciones del screen inventory (alta/editar/busqueda)
*
* @author Alfredo Chi
* @version 0.1
*/

var maxHeight = 400;
var xhrInventary = null;

/**************Index****************/

//busqueda Detailed Availability
$('#btnCollSearch').off();
$('#btnCollSearch').on('click', function() {  getCollection(0); });

/************Funciones**************/

/**
* Carga las opciones que se inicializan cuando entran a la pagina
*/
$(document).ready(function() {
	
	maxHeight = screen.height * .25;
	maxHeight = screen.height - maxHeight;
	
	var editColletionDialog = modalEditColletion(0);
	
	//alertify.success("Found "+ 50);
	$( "#DueDateColl" ).Zebra_DatePicker({
		format: 'm/d/Y',
		show_icon: false,
	});
	
	$(document).on( 'click', '#btNewTransAccColl, #btAddPayAccColl', function () {
		var dialogAccount = opcionAccountColl($(this).attr('attr_type'));
		dialogAccount.dialog("open");
	});
	
	//$('#textInvStartDate').val(getCurrentDate())
});

function modalEditColletion(id){
	
	showLoading('#dialog-Edit-colletion',true);
	dialogo = $("#dialog-Edit-colletion").dialog ({
  		open : function (event){
			$(this).load("collection/modalEdit?id="+id , function(){
				getInfoColl(id);
				/*$('#tabsCollection .tabs-title').off();
				$('#tabsCollection .tabs-title').on('click', function() { 
					changeTabsModalCollection($(this).attr('attr-screen'), id);
				});
				getGeneralInfoColl(id);*/
			});
	    	/*$(this).load("reservation/modalEdit?id="+id , function(){
	 			showLoading('#dialog-Edit-Reservation',false);
	 			getDatosReservation(id); 
	 			setEventosEditarReservation(id);
	    	});*/
		},
		autoOpen: false,
     	height: maxHeight,
     	width: "50%",
     	modal: true,
     	buttons: [
     // 	{
	    //    	text: "Cancel",
	    //    	"class": 'dialogModalButtonCancel',
	    //    	click: function() {
	    //      	$(this).dialog('close');
	    //    }
	   	// },
	   	{
       		text: "Close",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
       			$(this).dialog('close');
       		}
     	}],
     close: function() {
    	$('#dialog-Edit-colletion').empty();
     }
	});
	return dialogo;
	
}

function getCollection(){
	noResults('#section-Colletion',false);
	showLoading('#section-Colletion',true);
    var arrayDate = ["DueDateColl"];
    var dates = getDates(arrayDate);
    var arrayWords = ["TrxIdColl", "FolioColl", "TrxAmtColl", "PastDueDateColl"];
    var words = getWords(arrayWords);
	var arrayOption = ["TrxTypeColl", "AccTypeColl"];
    var options = getWords(arrayOption);
	$.ajax({
		data:{
			dates: dates,
			words: words,
			options: options
		},
   		type: "POST",
       	url: "collection/getCollection",
		dataType:'json',
		success: function(data){
			if( data.items.length > 0 ){
				alertify.success("Found "+ data.items.length);
				drawTable2(data.items,"tableColletion","getColletionById","editColletion");
			}else{
				noResultsTable("section-Colletion", "tableColletion", "no results found");
			}
			showLoading('#section-Colletion',false);
		},
		error: function(){
			noResultsTable("section-Colletion", "tableColletion", "Try again");
			showLoading('#section-Colletion',false);
		}
    });
}

function getColletionById(id){
	var editColletionDialog = modalEditColletion(id);
	editColletionDialog.dialog("open");
}


function getInfoColl(id){
	showLoading('#dialog-Edit-colletion',true);
	$.ajax({
		data:{
			id: id
		},
   		type: "POST",
       	url: "collection/getInfoColl",
		dataType:'json',
		success: function(data){
			//console.log(data)
			if(data.items.length > 0){
				var item = data.items[0];
				$('#dialog-Edit-colletion').data('accId', item.fkAccId);
				$('#dialog-Edit-colletion').data('peopleId', item.fkPeopleId);
				$('#dialog-Edit-colletion').data('resId', item.fkResId);
				$('#dialog-Edit-colletion').data('accTrxId', item.pkAccTrxId);
				$('#dialog-Edit-colletion').data('accType', item.AccTypeCode);
				showLoading('#dialog-Edit-colletion',false);
				$('#tabsCollection .tabs-title').off();
				$('#tabsCollection .tabs-title').on('click', function() { 
					changeTabsModalCollection($(this).attr('attr-screen'), id);
				});
				getGeneralInfoColl(id);
			}else{
				alertify.error("no results found");
				$("#dialog-Edit-colletion").dialog('close');
				showLoading('#dialog-Edit-colletion',false);
			}
			showLoading('#dialog-Edit-colletion',false);
			//console.log(data);
		},
		error: function(){
			alertify.error("try again");
			$("#dialog-Edit-colletion").dialog('close');
			showLoading('#dialog-Edit-colletion',false);
		}
    });
}

function getGeneralInfoColl(id){
	$.ajax({
		data:{
			id: id
		},
   		type: "POST",
       	url: "collection/getGeneralInfo",
		dataType:'json',
		success: function(data){
			if(data.people.length > 0){
				var people = data.people[0];
				$('#idPeopleColl p').html(people.pkPeopleId);
				$('#namePeopleColl p').html(people.Name);
				$('#lastNPeopleColl p').html(people.LName + people.LName2);
				$('#genderPeopleColl p').html(people.GenderDesc);
				$('#birthdatePeopleColl p').html(people.BirthDayMonth + "-" + people.BirthDayDay + "-" + people.BirthDayYear);
				$('#anniversaryPeopleColl p').html(people.Anniversary);
				$('#nationalityPeopleColl p').html(people.Nationality);
				$('#qualificationPeopleColl p').html(people.Qualification);
				$('#initialsPeopleColl p').html(people.Initials);
				//address
				$('#StreeteopleColl p').html(people.Street1);
				$('#Street2PeopleColl p').html(people.Street2);
				$('#ZipCodePeopleColl p').html(people.ZipCode);
				$('#CityPeopleColl p').html(people.City);
				$('#StatePeopleColl p').html(people.StateDesc);
				$('#CountryPeopleColl p').html(people.CountryDesc);
				var emailHtml = "";
				for(i=0;i<data.email.length;i++){
					var email = data.email[i];
					emailHtml += '<div class="small-12 medium-6 large-6 columns"><label class="text-left">Email:';
					emailHtml += '<p>' + email.EmailDesc + '</p></label></div>';
					emailHtml += '<div class="small-12 medium-6 large-6 columns"><label class="text-left">Type email:';
					emailHtml += '<p>' + email.EmailTypeDesc + '</p></label></div>';
				}
				if(emailHtml != ""){
					$('#emailPeopleColl').html(emailHtml);
				}
				var phoneHtml = "";
				for(i=0;i<data.phone.length;i++){
					var phone = data.phone[i];
					phoneHtml += '<div class="small-12 medium-6 large-6 columns"><label class="text-left">Phone:';
					phoneHtml += '<p>' + phone.AreaCode + ' ' + phone.PhoneDesc + '</p></label></div>';
					phoneHtml += '<div class="small-12 medium-6 large-6 columns"><label class="text-left">Type phone:';
					phoneHtml += '<p>' + phone.PhoneTypeDesc + '</p></label></div>';
				}
				if(phoneHtml != ""){
					$('#phonePeopleColl').html(phoneHtml);
				}
			}
			if(data.res.length > 0){
				var res = data.res[0];
				$('#idResColl p').html(res.pkResId);
				$('#FolioResColl p').html(res.Folio);
				$('#typeResColl p').html(res.ResTypeDesc);
				$('#legalNameResColl p').html(res.LegalName);
				$('#firstOccColl p').html(res.FirstOccYear);
				$('#lastOccColl p').html(res.LastOccYear);
			}
			//console.log(data)
			//showLoading('#section-Colletion',false);
		},
		error: function(){
			noResultsTable("section-Colletion", "tableColletion", "Try again");
			showLoading('#section-Colletion',false);
		}
    });
}

/**
 * cambia los pantallas del modal con los tabs
 */
function changeTabsModalCollection(screen, id){
	/*//console.log("Este es el ID "+ id);
	$('#tabsContrats .tabs-title').removeClass('active');
	$('#tabsContrats li[attr-screen=' + screen + ']').addClass('active');
	//muestra la pantalla selecionada
	$('#tabsContrats .tab-modal').hide();
	$('#' + screen).show();*/
	switch(screen){
		case "tab-CollGeneral":
			break;
		case "tab-CollAccounts":
			var typeAcc = $('#dialog-Edit-colletion').data('accType');
			$("#tab-CollAccounts").load("collection/modalAcc?typeAcc="+typeAcc , function(){
				//getAccounts("",);
				getAccountsColl( "account" );
			});
			//getDatosContractAccounts(id);
			//getAccounts( id, "account", "sale" );
			//getAccounts( id, "account", "maintenance" );
			//getAccounts( id, "account", "loan" );
			break;
	}
}

function getAccountsColl(typeInfo){
	$.ajax({
	    data:{
	        idReservation: $('#dialog-Edit-colletion').data('resId'),
			typeInfo:typeInfo,
			typeAcc: $('#dialog-Edit-colletion').data('accType').trim()
	    },
	    type: "POST",
	    url: "collection/getAccountsById",
	    dataType:'json',
	    success: function(data){
			console.log(data);
			if(typeInfo == "account"){
				var typeAcc = $('#dialog-Edit-colletion').data('accType').trim();
				if( typeAcc == "SAL" || typeAcc == "LOA" || typeAcc == "FEE"){
					var sale = data.items["sale"];
					var maintenance = data.items["maintenance"];
					var loan = data.items["loan"];
					drawTable2(sale, "tableAccountSeller", false, "");
					drawTable2(maintenance, "tableAccountMaintenance", false, "");
					drawTable2(loan, "tableAccountLoan", false, "");
					setTableAccountColl(sale, "tableSaleAccColl");
					setTableAccountColl(maintenance, "tableMainteAccColl");
					setTableAccountColl(loan, "tableLoanAccColl");
				}else if( typeAcc == "FDK" || typeAcc == "RES"){
					var reservation = data.items["reservation"];
					var frontDesk = data.items["frontDesk"];
					drawTable2(reservation, "tableAccountSeller", false, "");
					drawTable2(frontDesk, "tableAccountLoan", false, "");
					setTableAccountColl(reservation, "");
					setTableAccountColl(frontDesk, "");
				}
				var acc = data.items["acc"];
				
				//drawTable2(reservation, "tableAccountSeller", false, "");
				//drawTable2(frontDesk, "tableAccountLoan", false, "");
			}else{
				var acc = data.items["acc"];
				if(acc.length > 0){
					drawTable2(acc, "tabletPaymentAccoun", false, "");
					$(".checkPayAcc").off( 'change' );
					$(".checkPayAcc").on('change', function (){
						var amoutCur = 0;
						$("input[name='checkPayAcc[]']:checked").each(function(){
							amoutCur = amoutCur + parseFloat($(this).val());
						});
						$('#amountSettledAcc').text( '$ ' + amoutCur.toFixed(4) );
					});
				}
			}
			
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function setTableAccountColl(items, table){
	//console.log(items)
	var balance = 0, balanceDeposits = 0, balanceSales = 0, defeatedDeposits = 0, defeatedSales = 0;
	for(i=0;i<items.length;i++){
		var item = items[i];
		//console.log(item.Sign_transaction)
		var tempTotal = 0, tempTotal2 = 0;
		//console.log(item.Transaccion_Signo);
		if( item.Sign_transaction == 1 ){
			tempTotal = parseFloat(item.AbsAmount);
			tempTotal2 = parseFloat(item.Overdue_Amount);
		}
		if( item.Concept_Trxid.trim() == "Sale" ){
			if(tempTotal2 != 0){
				defeatedSales += tempTotal;
			}else{
				balanceSales += tempTotal;
			}
		}else{
			if(tempTotal2 != 0){
				defeatedDeposits += tempTotal;
			}else{
				balanceDeposits += tempTotal;
			}
		}
	}
	balance = balanceDeposits + balanceSales;
	//console.log(balance)
	$('#' + table +  ' tbody tr td.balanceAccount').text('$ ' + balance.toFixed(2));
	$('#' + table +  ' tbody tr td.balanceDepAccount').text('$ ' + balanceDeposits.toFixed(2));
	$('#' + table +  ' tbody tr td.balanceSaleAccount').text('$ ' + balanceSales.toFixed(2));
	$('#' + table +  ' tbody tr td.defeatedDepAccount').text('$ ' + defeatedDeposits.toFixed(2));
	$('#' + table +  ' tbody tr td.defeatedSaleAccount').text('$ ' + defeatedSales.toFixed(2));
}

function opcionAccountColl(attrType){
	var div = "#dialog-accountsColl";
	dialogo = $(div).dialog ({
  		open : function (event){
			
			if ($(div).is(':empty')) {
  				showLoading(div, true);
				$(this).load ("contract/modalAccount" , function(){
					showLoading(div, false);
					$( "#dueDateAcc" ).Zebra_DatePicker({
						format: 'm/d/Y',
						show_icon: false,
					});
					$("#slcTransTypeAcc").attr('disabled', true);
					setDataOpcionAccountColl(attrType);
					getTrxTypeColl('collection/getTrxType', attrType, 'try again', generalSelects, 'slcTransTypeAcc');
					ajaxSelectsColl('collection/getTrxClass', 'try again', generalSelects, 'slcTrxClassAcc');
				});
			}else{
				showLoading(div, true);
				$("#slcTransTypeAcc").attr('disabled', true);
				getTrxTypeColl('collection/getTrxType', attrType, 'try again', generalSelects, 'slcTransTypeAcc');
				setDataOpcionAccountColl(attrType);
				showLoading(div, false);
			}
		},
		autoOpen: false,
     	height: maxHeight,
     	width: "50%",
     	modal: true,
     	buttons: [{
	       	text: "Cancel",
	       	"class": 'dialogModalButtonCancel',
	       	click: function() {
	         	$(this).dialog('close');
	       }
	   	},{
       		text: "Save",
       		"class": 'dialogModalButtonAccept',
       		click: function() {
				var id = "saveAccCont";
				var form = $("#"+id);
				var elem = new Foundation.Abide(form, {});
				var arrayInput = ["AmountAcc", "dueDateAcc"];
				var arraySelect = ["slcTransTypeAcc", "slcTrxClassAcc"];
				if(attrType == "addPayAcc"){
					arraySelect = ["slcTransTypeAcc"];
				}
				if(!verifyAccountColl(arrayInput, arraySelect )){
					$('#'+id).foundation('validateForm');
					alertify.success("Please fill required fields (red)");
				}else{
					var amoutCur = 0;
					$("input[name='checkPayAcc[]']:checked").each(function(){
						amoutCur = amoutCur + parseFloat($(this).val());
					});
					if( amoutCur.toFixed(4) > parseFloat($('#AmountAcc').val().trim()).toFixed(4)){
						var msg = "The stated amount does not cover all of the selected concepts.</br>A partial payment was stored.";
						alertify.confirm(msg, function (e){
							if(e){
								saveAccContRes(attrType);
							}
						});
					}else{
						saveAccContRes(attrType);
					}
				}
       		}
     	}],
     close: function() {
    	//$('#dialog-ScheduledPayments').empty();
     }
	});
	return dialogo;
}

function initEventosSellersColl(){
	$("#btnSearchSeller").click(function(){
		getSellersColl();
	});
	$("#btnCleanSearchSeller").click(function(){
		$("#txtSearchSeller").val("");
	});
}

function getSellersColl(){
	var div = "#section-table-seller";
	showLoading(div, true);
	$.ajax({
	    data:{
	        idContrato: 186
	    },
	    type: "POST",
	    url: "contract/getSellers",
	    dataType:'json',
	    success: function(data){
	    	showLoading(div, false);
	    	drawTableId(data,"tableSellerbody");
	    	selectTable("tableSellerbody");
	    },
	    error: function(){
	        alertify.error("Try again");
	    }
	});
}

function setDataOpcionAccountColl(attrType){
	if(attrType == "newTransAcc"){
		$('#grpTrxClassAcc').show();
		$('#grpTablePayAcc').hide();
	}else{
		var trxType = $('#tab-CollAccounts .tabsModal .tabs .active').attr('attr-accType');
		getAccountsColl( $('#dialog-Edit-colletion').data('resId'), "payment", trxType );
		$('#grpTrxClassAcc').hide();
		$('#grpTablePayAcc').show();
	}
	$('#accountIdAcc').text( $('#dialog-Edit-colletion').data('accId') );
	$('#dueDateAcc').val(getCurrentDate());
	$('#legalNameAcc').text($('#editContractTitle').text());
	$('#balanceAcc').text($('.balanceAccount').text());
}

function getTrxTypeColl(url, attrType, errorMsj, funcion, divSelect){
	var trxType = $('#tab-CollAccounts .tabsModal .tabs .active').attr('attr-accType');
	$.ajax({
		type: "POST",
		data: {
			attrType:attrType,
			trxType:trxType
			
		},
		url: url,
		dataType:'json',
		success: function(data){
			funcion(data, divSelect);
			$("#slcTransTypeAcc").attr('disabled', false);
		},
		error: function(){
			$("#slcTransTypeAcc").attr('disabled', false);
			alertify.error(errorMsj);
		}
	});
}

function ajaxSelectsColl(url,errorMsj, funcion, divSelect) {
	$.ajax({
		type: "POST",
		url: url,
		dataType:'json',
		success: function(data){
			funcion(data, divSelect);
		},
		error: function(){
			alertify.error(errorMsj);
		}
	});
}

function verifyAccountColl( inputArray, selectArray ){
	var v = true;
	for (var i = 0; i < inputArray.length; i++){
		 if($('#'+inputArray[i]).val().trim().length <= 0){
		 	v = false;
		 }
	}
	
	for (var i = 0; i < selectArray.length; i++){
		if($('#'+selectArray[i]).val() == 0){
		 	v = false;
		}
	}
	
	//AmountAcc
	if( $('#grpTablePayAcc').is(":visible") ){
		if( $("input[name='checkPayAcc[]']:checked").length == 0){
			v = false;
		}else{
			var amoutCur = $('#amountSettledAcc').text();
			amoutCur = amoutCur.replace("$", "");
			amoutCur = parseFloat(amoutCur.trim());
			if($('#AmountAcc').val().trim() > amoutCur){
				v = false;
				alertify.error("The amount of selected positions is less than the payment amount captured.");
			}
		}
	}
	
	return v;
}

function saveAccContRes(attrType){
	var idTrans = new Array();
	var valTrans = new Array();
	var trxClass = new Array();
	if( attrType == "addPayAcc" ){
		$('.checkPayAcc:checked').each( function() {
			idTrans.push($(this).attr('id'));
			valTrans.push($(this).val());
			trxClass.push($(this).attr('trxclass'));
		});
	}
	
	//console.log($('#btNewTransAccRes').data( 'idRes' ));
	showAlert(true,"Saving changes, please wait ....",'progressbar');
	$.ajax({
		data: {
			attrType:attrType,
			accId:$('#dialog-Edit-colletion').data( 'accId' ),
			trxTypeId:$('#slcTransTypeAcc').val(),
			trxClassID:$('#slcTrxClassAcc').val(),
			amount:$('#AmountAcc').val(),
			dueDt:$('#dueDateAcc').val(),
			doc:$('#documentAcc').val(),
			remark:$('#referenceAcc').val(),
			idTrans:idTrans,
			valTrans:valTrans,
			trxClass:trxClass,
		},type: "POST",
		dataType:'json',
		url: 'collection/saveTransactionAcc'
	}).done(function( data, textStatus, jqXHR ) {
		console.log(data);
		if( data.success ){
			//getDatailByID("contractstbody");
			getAccountsColl( "account" );
			$("#dialog-accountsColl").dialog('close');
			showAlert(false,"Saving changes, please wait ....",'progressbar');
		}else{
			$("#dialog-accountsRes").dialog('close');
			showAlert(false,"Saving changes, please wait ....",'progressbar');
			//alert("no transacenshion");
		}
	}).fail(function( jqXHR, textStatus, errorThrown ) {
		$("#dialog-accountsRes").dialog('close');
		showAlert(false,"Saving changes, please wait ....",'progressbar');
		alertify.error("Try Again");
	});
}