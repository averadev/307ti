$(document).ready(function(){


	$(document).off('change', '#catalogos');
	$(document).on( 'change', '#catalogos', function () {
		console.log(this.value);
		changeCatalag(this.value);
	});
});


function changeCatalag(id){
	switch(id) {
		case "1":
			document.getElementById('frameCatalagos').src = "http://pms.thetowersatmulletbay.com/cat_training/mtblTrxType/grid_dbo_TblTrxType/";
		break;
		case "2":
			document.getElementById('frameCatalagos').src = "http://pms.thetowersatmulletbay.com/cat_training/mtblCountry/grid_dbo_tblCountry/";
		break;
		default:
			console.log("no hay ese catalago");
	}
}


