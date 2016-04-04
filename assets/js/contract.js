$('#newContract').click(function(){ showModalContracto(0); });


function showModalContracto(){
	dialogContract.dialog('open');
}

$(function(){
	maxHeight = screen.height * .25;
	maxHeight = screen.height - maxHeight;

	dialogContract = $( "#dialog-Contract" ).dialog({
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
					dialogContract.dialog('close');
					cleanContractFields("contract");
				}
			},
			{
				text: "Guardar y cerrar",
				"class": 'dialogModalButtonAccept',
				click: function() {
					createNewContract("contract",false)
				}
			},
			{
				text: "Guardar",
				"class": 'dialogModalButtonAccept',
				click: function() {
					createNewContract("contract", true)
				}
			},
		],
		close: function() {
			cleanContractFields("contract");
		}
	});	
});

function cleanContractFields(id){
	var formData = document.getElementById(id);
    formData.reset();
}


function createNewContract(id){

	var formData = new FormData(document.getElementById(id));
    formData.append("peticion", "agregarServicio");

    $.ajax({
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        type: "POST",
        dataType: "JSON",
        url: ""
    })
        .done(function( data, textStatus, jqXHR ) {
            //alertify.success(data.message);
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            //alertify.error("Ocurrio un error vuelve a intentarlo");
        });
}