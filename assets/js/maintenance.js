var msgMan = null;
var maxHeight = screen.height * .20;
maxHeight = screen.height - maxHeight;

$(document).ready(function(){

	FloorPlanMA =  $('#MFloorPlan').multipleSelect({
		width: '100%',
		placeholder: "Choose an option",
		selectAll: false,
		onClick: function(view) {
		}
	});
	FloorPlanDetail = null;

	$(document).off( 'click', '#btnManCleanSearch');
	$(document).on( 'click', '#btnManCleanSearch', function () {
		$("#MSearch").val('');
	});
	$(document).off( 'click', '#printReportMaintenance');
	$(document).on( 'click', '#printReportMaintenance', function () {
		ID = $("#cventaPrice").text().trim();
		reportMaintenance(ID);
	});

	$(document).off( 'click', '#btnManSearch');
	$(document).on( 'click', '#btnManSearch', function () {
    	searchBatchs();
	});

	$(document).off( 'click', '#newBatch');
	$(document).on( 'click', '#newBatch', function(){
		newBacth();
	});
	$(document).off( 'click', '#btnSearchContracts');
	$(document).on( 'click', '#btnSearchContracts', function(){
		searchMaintenanceContracts();
	});

	$(document).off( 'click', '#postBatch');
	$(document).on( 'click', '#postBatch', function(){
		postBatch();
	});
	$(document).off( 'click', '#cancelBatch');
	$(document).on( 'click', '#cancelBatch', function(){
		var IDStatus = 6;
		var IDBatch = $("#cventaPrice").text().trim();
		updateStatusBatch(IDStatus, IDBatch);
	});
});

function newBacth(){
	var ajaxData =  {
		url: "Maintenance/modalNewbatch",
		tipo: "html",
		datos: {},
		funcionExito : addHTMLGeneral,
		funcionError: mensajeAlertify
	};
	var modalPropiedades = {
		div: "dialog-NewBatch",
		altura: maxHeight,
		width: "70%",
		onOpen: ajaxDATAG,
		onSave: createNewBatch,
		botones :[{
			text: "Close",
		    "class": 'dialogModalButtonCancel',
		    click: function() {
		    	$(this).dialog('close');
		    }
		   	},{
	       		text: "Save",
	       		"class": 'dialogModalButtonAccept',
	       		click: function() {
	       			var rowCount = $('#tablaSearcBatchsBody tr').length;
	       			if (rowCount > 0) {
	       				createNewBatch();
	       				$(this).dialog('close');
	       			}else{
	       				alertify.error("Search Contracts");
	       			}
	       		}
	     	}]
		};

	if (modalCreditLimit!=null) {
		modalCreditLimit.dialog( "destroy" );
	}
	modalCreditLimit = modalGeneralG(modalPropiedades, ajaxData);
	modalCreditLimit.dialog( "open" );
}

function createNewBatch(){
	msgMan = alertify.success('Saving changes, please wait ....', 0);
	var Description = getDetailBatch();
	var Contracts = getArrayValuesColumnTable("tablaSearcBatchs", 1);
	var Precios = getArrayValuesColumnTableInt("tablaSearcBatchs", 11);
	var total = Precios.reduce((x, y) => x + y);
	var ajaxDatos =  {
		url: "Maintenance/newBatch",
		tipo: "json",
		datos: {
			Property: $("#NProperty").val(),
			Year: $("#NYears").val(),
			SaleType: $("#NSaleType").val(),
			FloorPlan: $("#NFloorPlan").val(),
			Frequency: $("#NFrequency").val(),
			Season: $("#NSeason").val(),
			Total: total,
			BatchDesc : Description.substring(0,50),
			Contracts : Contracts,
			Precios: Precios
		},
		funcionExito : mensajeSaveBatch,
		funcionError: mensajeAlertify
	};
	ajaxDATA(ajaxDatos);
}

function mensajeSaveBatch(data){
	msgMan.dismiss();
	if (data['success'] == 1) {
		alertify.success(data["mensaje"]);
		searchBatchs();
	}
	if (data['success'] == 0) {
		alertify.error(data["mensaje"]);
	}
}

function searchBatchs(){
	var floorPlans = FloorPlanMA.multipleSelect('getSelects');
	var arrayWords = ["MProperty", "MYear", "MSaleType", "MFrequency", "MSearch"];
    var words = getWords(arrayWords);
    words.floorPlans = floorPlans;
	showLoading('#tableMaintenance',true);
	var ajaxDatos =  {
		url: "Maintenance/getBatchs",
		tipo: "json",
		datos: {
			filters: words
		},
		funcionExito : drawBatchs,
		funcionError: mensajeAlertify
	};
	ajaxDATA(ajaxDatos);

}

function drawBatchs(datos){
	showLoading('#tableMaintenance',false);
	if (datos) {
		drawTable2(datos, "tableMaintenance" ,"datailBatch", "Detail");
	}else{
		$("#bodyMaintenance").empty();
		alertify.error('No results found');
	}
	
}

function datailBatch(id){

	var ajaxData =  {
		url: "Maintenance/dialogDetailBatch",
		tipo: "html",
		datos: {
			ID: id
		},
		funcionExito : addHTMLGeneral,
		funcionError: mensajeAlertify
	};
	var modalPropiedades = {
		div: "dialog-DetailBatch",
		altura: maxHeight,
		width: "70%",
		onOpen: ajaxDATAG,
		onSave: createNewBatch,
		botones :[{
			text: "Close",
		    "class": 'dialogModalButtonCancel',
		    click: function() {
		    	$(this).dialog('close');
		    }
		   	}
		   ]
		};

	if (modalCreditLimit!=null) {
		modalCreditLimit.dialog( "destroy" );
	}
	modalCreditLimit = modalGeneralG(modalPropiedades, ajaxData);
	modalCreditLimit.dialog( "open" );
}

function addHTMLDetailBatch(data, div){
	addHTMLGeneral(data, div);

	$('#tabsDetailBatch .tabs-title').on('click', function() { 
		changeTabsModalBatch($(this).attr('attr-screen'));
	});
	FloorPlanDetail =  $('#MFloorPlanDetail').multipleSelect({
		width: '100%',
		placeholder: "Choose an option",
		selectAll: false,
		onClick: function(view) {
		}
	});
}

function getDetailBatch(){
	var Description = $("#NProperty option:selected").text().trim();
	Description += '_'+$("#NYears option:selected").text().trim();
	Description += '_'+$("#NSaleType option:selected").text().trim();
	Description += '_'+$("#NFloorPlan option:selected").text().trim();
	Description += '_'+$("#NSeason option:selected").text().trim();
	return Description;
}

function changeTabsModalBatch(screen){
	$('#tabsDetailBatch .tabs-title').removeClass('active');
	$('#tabsDetailBatch li[attr-screen=' + screen + ']').addClass('active');
	$('#tabsDetailBatch .tab-modal').hide();
	$('#' + screen).show();
	switch(screen){
		case "tab-DetailBatch":
			break;
		case "tab-Maintenance":
			break;
	}
}


function searchMaintenanceContracts(){
	showLoading('#tablaSearcBatchs',true);

	var ajaxDatos =  {
		url: "Maintenance/getContrats",
		tipo: "json",
		datos: {
				Property: $("#NProperty").val(),
				Year: $("#NYears").val(),
				SaleType: $("#NSaleType").val(),
				FloorPlan: $("#NFloorPlan").val(),
				Frequency: $("#NFrequency").val(),
				Season: $("#NSeason").val(),
				Folio: $("#MFolio").val().replace("1-", "")
		},
		funcionExito : drawTableM,
		funcionError: mensajeAlertify
	};
	ajaxDATAG(ajaxDatos);
}

function drawTableM(data, div){

	showLoading('#tablaSearcBatchs',false);
	if (data) {
		var table = "tablaSearcBatchsBody";
		var bodyHTML = '';
	    for (var i = 0; i < data.length; i++) {
	        bodyHTML += "<tr>";
	        for (var j in data[i]) {
	            bodyHTML+="<td>" + data[i][j] + "</td>";
	        };
	        bodyHTML += "<td><button type='button' class='alert button'><i class='fa fa-minus-circle fa-lg' aria-hidden='true'></i></button></td>";
	        bodyHTML+="</tr>";
	    }
	    $('#' + table).html(bodyHTML);
	    deleteElementTableGeneral(table);
	}else{
		$('#tablaSearcBatchsBody').empty();
		alertify.error("No Data Found");
	}
	
}

function postBatch(){
	msgMaintenance = alertify.success('Saving changes, please wait ....', 0);
	var ajaxDatos =  {
		url: "Maintenance/postBatch",
		tipo: "json",
		datos: {
				ID: $("#cventaPrice").text().trim()
		},
		funcionExito : postBatchMsj,
		funcionError: mensajeAlertify
	};
	ajaxDATAG(ajaxDatos);
}

function postBatchMsj(data){
	msgMaintenance.dismiss();
	alertify.success(data["mensaje"]);
	$("#botonesBatch").empty();
}

function reportMaintenance(id){

	var url = "Pdfs/reportMaintanance?id=" + id;
	window.open(url);
}

function updateStatusBatch(ID, IDBatch){
	msgMaintenanceStatus = alertify.success('Saving changes, please wait ....', 0);
	var ajaxDatos =  {
		url: "Maintenance/updateStatus",
		tipo: "json",
		datos: {
				IDStatus: ID,
				IDBatch: IDBatch
		},
		funcionExito : updateStatusBatchMsj,
		funcionError: mensajeAlertify
	};
	ajaxDATAG(ajaxDatos);
}

function updateStatusBatchMsj(data){
	msgMaintenanceStatus.dismiss();
	alertify.success(data["mensaje"]);
	$("#botonesBatch").empty();
}