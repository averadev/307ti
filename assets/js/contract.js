$('#newContract').click(function(){ showModalContracto(0); });
$('#btnTourID').click(function(){ dialogTourID.dialog('open'); });
$('#btnAddPeople').click(function(){showModals('dialog-Personas', cleanAddPeople);});
$('#btnAddUnidades').click(function(){showModals('dialog-Unidades', cleanAddUnidades);});

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

	dialogTourID = $( "#dialog-tourID" ).dialog({
		autoOpen: false,
		height: maxHeight,
		width: "40%",
		modal: true,
		dialogClass: 'dialogModal',
		buttons: [
			{
				text: "Cancelar",
				"class": 'dialogModalButtonCancel',
				click: function() {
					dialogTourID.dialog('close');
				}
			},
			{
				text: "Guardar y cerrar",
				"class": 'dialogModalButtonAccept',
				click: function() {
					
				}
			},
			{
				text: "Guardar",
				"class": 'dialogModalButtonAccept',
				click: function() {
					
				}
			},
		],
		close: function() {
			//cleanContractFields("contract");
		}
	});	
});


function showModals(div, funcion){

	maxHeight = screen.height * .75;

	dialog = $( "#"+div ).dialog({
      autoOpen: false,
      height: maxHeight,
      width: "50%",
      modal: true,
      dialogClass: 'dialogModal',
      buttons: {
        Cancel: function() {
          dialog.dialog( "close" );
        }
      },
      close: function() {
      	funcion();
      }
    });

    dialog.dialog('open');
}

function cleanAddPeople(){
	console.log("clean form Add people");
}

function cleanAddUnidades(){
	console.log("clean form Add people");
}


function goodBye(){
	console.log("BYE");
}

function cleanContractFields(id){
	// var formData = document.getElementById(id);
 //    formData.reset();
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

function EnviaFormularioCliente(id){
	//var formData = new FormData(document.getElementById("contract"));
    //formData.append("peticion", "agregarServicio");
	$.ajax({
   		type: "POST",
       	url: "contract/saveContract",
		dataType:'json',
		data: { 
			id:id,
			nombreLegal: "cancun",
			idioma: "ingles",
			"tourID": "123456"
		},
		success: function(data){
			console.log("dta"+data);
		},
		error: function(){

		}
	});	
}

