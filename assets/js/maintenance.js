var msgMan = null;
$(document).ready(function(){

	FloorPlanMA =  $('#MFloorPlan').multipleSelect({
		width: '100%',
		placeholder: "Choose an option",
		selectAll: false,
		onClick: function(view) {
		}
	});

	$(document).off( 'click', '#btnManCleanSearch');
	$(document).on( 'click', '#btnManCleanSearch', function () {
		$("#MSearch").val('');
	});

	$(document).off( 'click', '#btnManSearch');
	$(document).on( 'click', '#btnManSearch', function () {
    	searchBatchs();
	});

	$(document).off( 'click', '#newBatch');
	$(document).on( 'click', '#newBatch', function(){
		newBacth();
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
		altura: 500,
		width: 600,
		onOpen: ajaxDATAG,
		onSave: createNewBatch,
		botones :[{
			text: "Cancel",
		    "class": 'dialogModalButtonCancel',
		    click: function() {
		    	$(this).dialog('close');
		    }
		   	},{
	       		text: "Save",
	       		"class": 'dialogModalButtonAccept',
	       		click: function() {
	       			createNewBatch();
	       			$(this).dialog('close');
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
	var Description = $("#NProperty option:selected").text().trim() + '_'+$("#NYears option:selected").text().trim();
	Description += '_'+$("#NSaleType option:selected").text().trim();
	Description += '_'+$("#NFloorPlan option:selected").text().trim();
	Description += '_'+$("#NSeason option:selected").text().trim();
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
			BatchDesc : Description
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
	console.log(id)
}