
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
        
        <nav class="top-bar top-title" data-topbar>
            <ul class="tabs" data-tab role="tablist">
                
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
        
	</body>
</html>
<?php if(!isset($screen)){ ?>
    <script> 
        var BASE_URL = '<?php echo base_url(); ?>';
        showMenu();
    </script>
<?php } ?>