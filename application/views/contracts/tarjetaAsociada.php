 <fieldset id="CCAS" class="fieldset">
 	<legend>Card Data</legend>
	<!-- Numero de tarjeta-->
    <div class="row">
    	<div class="small-3 columns">
        	<label for="numeroTarjeta" class="text-left">Card Number</label>
       	</div>
        <div class="small-9 columns">
        	<input class="round general" type="text" id="numeroTarjeta" name="numeroTarjeta" value=<?php echo $tarjetaAsociada[0]->CCNumber;?> class="general" required>
        </div>
    </div>
                <!-- Numero de tarjeta-->
                <div class="row" >
                    <div class="small-3 columns">
                        <label for="cardType" class="text-left">Card Type</label>
                    </div>
                    <div class="small-9 columns">
                          <div class="caja">
                            <select id="cardTypes" class="input-group-field round">
                            <?php
                            	foreach($creditCardType as $item){?>
                                	<option value="<?php echo $item->ID; ?>"><?php echo $item->CcTypeDesc; ?></option>
                               		<?php
                             		}
                                  ?>
                            </select>
                          </div>
                    </div>
                </div>
                <!-- fecha de expiracion-->
                <div class="row">
                    <div class="small-3 columns">
                        <label  for="dateExpiracion" class="text-left">Expiration Date</label>
                    </div>
                    <div class="small-9 columns">
                        <input class="round general" value=<?php echo $tarjetaAsociada[0]->ExpDate; ?> type="text" id="dateExpiracion" name="dateExpiracion" class="general" required>
                    </div>
                </div>
                 <!-- Codigo Postal-->
                <div class="row">
                    <div class="small-3 columns">
                        <label  for="codigoPostal" class="text-left">Postcode</label>
                    </div>
                    <div class="small-9 columns">
                        <input class="round general" value=<?php echo $tarjetaAsociada[0]->ZIP; ?> type="text" id="codigoPostal" name="codigoPostal" class="general" required>
                    </div>
                </div>
                <!-- Codigo tarjeta-->
                <div class="row">
                    <div class="small-3 columns">
                        <label  for="codigoTarjeta" class="text-left">CVC</label>
                    </div>
                   <div class="small-9 columns">
                        <input class="round general" value=<?php echo $tarjetaAsociada[0]->Code; ?> type="text" id="codigoTarjeta" name="codigoTarjeta" class="general" required>
                    </div>
                </div>
    </fieldset>