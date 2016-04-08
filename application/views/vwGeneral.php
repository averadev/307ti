
<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>307TI</title>
        <link href='https://fonts.googleapis.com/css?family=Arimo' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo base_url().CSS; ?>foundation.css" />
		<link rel="stylesheet" href="<?php echo base_url().CSS; ?>paginacion/jqpagination.css" />
		<link rel="stylesheet" href="<?php echo base_url().CSS; ?>general.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script type="text/javascript" src="<?php echo base_url().JS; ?>foundation.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url().JS; ?>responsive-tables.js"></script>
        <script type="text/javascript" src="<?php echo base_url().JS; ?>general.js"></script>
		<script type="text/javascript" src="<?php echo base_url().JS; ?>paginacion/jquery.jqpagination.js"></script>
    </head>
    <body>
        <nav class="top-bar top-menu" data-topbar>
            <div class="menu-opt">
                <div href="#" class="btn-menu btn-menu-sel"></div>
            </div>
            <div class="menu-opt logo"><img src="<?php echo base_url().IMG; ?>logo/demo.png"/></div>
        </nav>
        
        <nav class="top-title" data-topbar>
            <!--<ul class="tabs" data-tabs role="tablist">
                
            </ul>-->
			<ul class="tabs" data-tabs>
			</ul>
        </nav>
        
        <div class="menu-section">
            <div class="menu-content">
                <div class="menu-sel" attr-screen="people">Persona</div>
                <div class="menu-sel" attr-screen="contract">Contrato</div>
                <div class="menu-sel" attr-screen="catalog">Catalogo</div>
                <div class="menu-fix">&nbsp;</div>
            </div>
        </div>
        <div class="general-section">
        </div>
       
	<!--- meesssage alert ---->
	<div class="alertScreen" id="alertPeople">
		<div class="bgAlertScreen" ></div>
		<div class="alertMessage" >
			<div class="headerAlertMessage">
				<p>307TI</p>
			</div>
			<div class="bodyAlertMessage">
				<label>Datos guardados</label>
				<div id="progressbarAlert"></div>
				<button class="tiny button radius btnAlertMessage cancel" id="btnCancelAlertPeople">Cancelar</button>
				<button class="tiny button radius btnAlertMessage success" id="btnSuccessAlertPeople">Aceptar</button>
			</div>
		</div>
	</div>
	
	<!--<div class="divLoadingTable">
		<div class="bgLoadingTable" ></div>
		<div class="loadingTable" >
			<div class="subLoadingTable">
				<label>Cargando..</label>
				<div id="progressbar"></div>
			</div>
		</div>
	</div>-->
		
	</body>
</html>
<?php if(!isset($screen)){ ?>
    <script> 
        var BASE_URL = '<?php echo base_url(); ?>';
        showMenu();
    </script>
<?php } ?>

<script>
/*function getScript(src){
	var val, src;
	$('script').each(function() {
		console.log($(this).attr('src'));
		
	});
}

getScript('people.js')
//test: 
function loa(){ 
   // alert('algo.js está cargado:'+getScript('people.js')); 
    //alert('test.js está cargado:'+getScript('test.js')); 
} 

$( document ).ready(function() { 
	getScript('people.js')
});*/
</script>