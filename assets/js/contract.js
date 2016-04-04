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
					cleanContractFields();
				}
			},
			{
				text: "Guardar y cerrar",
				"class": 'dialogModalButtonAccept',
				click: function() {
					CreateNewUser(false)
				}
			},
			{
				text: "Guardar",
				"class": 'dialogModalButtonAccept',
				click: function() {
					CreateNewUser(true)
				}
			},
		],
		close: function() {
			cleanContractFields();
		}
	});	
});

function cleanContractFields(){
	console.log("clean all contract fields");
}