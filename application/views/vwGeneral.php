
<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>307TI</title>
        <link href='https://fonts.googleapis.com/css?family=Arimo' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="<?php echo base_url().CSS; ?>foundation.css" />
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<!--<link rel='stylesheet prefetch' href='https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css'>-->
		<link rel="stylesheet" href="<?php echo base_url().CSS; ?>paginacion/jqpagination.css" />
        <link rel="stylesheet" href="<?php echo base_url().CSS; ?>alertify/alertify.core.css" />
        <link rel="stylesheet" href="<?php echo base_url().CSS; ?>alertify/alertify.default.css" />
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" />
		<!-- MultiSelect-->
		<link rel="stylesheet" href="<?php echo base_url().CSS; ?>multiselect/multiple-select.css" />
		<!-- General --->
		<link rel="stylesheet" href="<?php echo base_url().CSS; ?>general.css" />
		<link rel="stylesheet" href="<?php echo base_url().CSS; ?>inventary.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		
		<!-- Zebra_Datepicker -->
		<link rel="stylesheet" href="<?php echo base_url().CSS; ?>zebra/bootstrap.css" />
		<!-- gantt -->
		<link rel="stylesheet" href="<?php echo base_url().CSS; ?>gantt/gantt.css" />
		<!-- Tooltip-->
		<link rel="stylesheet" href="<?php echo base_url().CSS; ?>tooltip/tooltip.css" />
		
		
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script type="text/javascript" src="<?php echo base_url().JS; ?>foundation.min.js"></script>
		
        <script type="text/javascript" src="<?php echo base_url().JS; ?>general.js"></script>
        <script type="text/javascript" src="<?php echo base_url().JS; ?>/alertify/alertify.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url().JS; ?>paginacion/jquery.jqpagination.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url().JS; ?>validateDate.js"></script>
        
		<!-- Zebra_Datepicker -->
		<script type="text/javascript" src="<?php echo base_url().JS; ?>zebra/zebra_datepicker.js"></script>
		<!-- MultiSelect -->
		<script type="text/javascript" src="<?php echo base_url().JS; ?>multiselect/multiple-select.js"></script>
    </head>
    <body>
		
        <nav class="top-bar top-menu" data-topbar>
            <div class="menu-opt">
                <div href="#" class="btn-menu pr-color"></div>
            </div>
            <div class="menu-opt logo"><img src="<?php echo base_url().IMG; ?>logo/logo.jpg"/></div>
			<div class="menu-config">
				<img src="<?php echo base_url().IMG; ?>common/5.png" />
				<p><?php echo $this->nativesessions->get('username'); ?></p>
				<span id="btnDropdownMenu">
					<i class="fa fa-sort-desc"></i>
				</span>
				
			</div>
			<div class="menu-config-dropdown">
				<ul>
					<a  href="<?php echo base_url(); ?>login/logout"><li>logout</li></a>
				</ul>
				
			</div>
        </nav>
        
        <nav class="top-title" data-topbar>
            <!--<ul class="tabs" data-tabs role="tablist"></ul>-->
			<ul class="tabs espacio" data-tabs id="tab-general">
			</ul>
        </nav>
		
      <div class="menu-section">
            <div class="menu-content">
                <div class="menu-sel" attr-screen="people">
					<span class="icon-menu-sel"><img src="<?php echo base_url().IMG; ?>common/3.png"/></span>
					<div class="label-menu-sel">People</div>
				</div>
                <div class="menu-sel" attr-screen="contract">
					<span class="icon-menu-sel"><img src="<?php echo base_url().IMG; ?>common/4.png"/></span>
					<div class="label-menu-sel">Contract</div>
				</div>
				<div class="menu-sel" attr-screen="tours">
					<span class="icon-menu-sel"><img src="<?php echo base_url().IMG; ?>common/4.png"/></span>
					<div class="label-menu-sel">Tour</div>
				</div>
                <div class="menu-sel" attr-screen="inventory">
					<span class="icon-menu-sel"><img src="<?php echo base_url().IMG; ?>common/2.png"/></span>
					<div class="label-menu-sel">Inventary</div>
				</div>
				<div class="menu-sel" attr-screen="frontDesk">
					<span class="icon-menu-sel"><img src="<?php echo base_url().IMG; ?>common/1.png"/></span>
					<div class="label-menu-sel">FrontDesk</div>
				</div>
                <div class="menu-fix">&nbsp;</div>
            </div>
        </div>
        <div class="general-section">
        </div>
       
	<!--- meesssage alert -->
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
	
	</body>
</html>
<?php if(!isset($screen)){ ?>
    <script> 
        var BASE_URL = '<?php echo base_url(); ?>';
        showMenu();
    </script>
<?php } ?>

<script>
//muestra o esconde el menu de configuraciones
//$(document).on('click', '#btnDropdownMenu', function(e) {
$('#btnDropdownMenu').on('click', function(e) {
	if ($('.menu-config-dropdown').is(':hidden')){	
		$('.menu-config-dropdown').show();
	}else{
		$('.menu-config-dropdown').hide();
	}
	e.stopPropagation();
});

$('html').on('click', function() {
	$('.menu-config-dropdown').hide();
});
</script>
