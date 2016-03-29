
<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>307TI</title>
        <link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo base_url().CSS; ?>foundation.css" />
        <link rel="stylesheet" href="<?php echo base_url().CSS; ?>login.css" />
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url().JS; ?>foundation.min.js"></script>
    </head>
    <body>
		<div class="row">
            <div class="medium-2 columns">&nbsp;</div>
            <div class="formLogin medium-8 columns">
                <div class="row">
                    <div class="imgLogo"><img src="<?php echo base_url().IMG; ?>logo/demo.png"/></div>
                </div>
                
                <!--<form>-->
				<?php //echo validation_errors(); ?>

				<?php //echo form_open('login/guardar_post'); ?>
                    <div class="row">
                        <div class="medium-2 columns">&nbsp;</div>
                        <div class="medium-8 columns">
                            <div class="large-12 columns">
                                <label>Usuario
                                <input type="text" id="txtUser" name="txtUser" />
                                </label>
                            </div>
                            
                            <div class="large-12 columns">
                                <label>Contraseña
                                <input type="password" id="txtPassword" name="txtPassword" />
                                </label>
                            </div>
                            
                            <div class="large-12 columns">
                                <button class="button btnAction" id="btnLogin">
									<div class="ripple-container">
										<span class="ripple-effect"></span>
									</div>
									LOGIN
								</button>
                            </div>
                        </div>
                        <div class="medium-2 columns">&nbsp;</div>
                    </div>
                <!--</form>-->
            </div>
            <div class="medium-2 columns">&nbsp;</div>
            
        </div>
	</body>
	
	<script>
		var URL_BASE = '<?php echo base_url(); ?>';
    </script>
	<script type="text/javascript" src="<?php echo base_url().JS; ?>login.js"></script>
    
</html>