 <?php if ($tarjetaAsociada[0]) {
 	$CCNumber = $tarjetaAsociada[0]->CCNumber;
 	$ExpDate = $tarjetaAsociada[0]->ExpDate;
 	$ZIP = $tarjetaAsociada[0]->ZIP;
 	$Code = $tarjetaAsociada[0]->Code;
 	$TypeID = $tarjetaAsociada[0]->fkCcTypeId;
 }else{
	$CCNumber = '""';
	$ExpDate = '""';
	$ZIP = '""';
	$Code = '""';
	$TypeID = '""';
 	} ?>
 <fieldset id="CCAS" class="fieldset">
 	<legend>Card Data</legend>
	<!-- Numero de tarjeta-->
    <div class="row">
    	<div class="small-3 columns">
        	<label for="numeroTarjetaAS" class="text-left">Card Number</label>
       	</div>
        <div class="small-9 columns">
        	<input class="round general" type="text" id="numeroTarjetaAS" name="numeroTarjetaAS" value=<?php echo $CCNumber;?> class="general" required>
        </div>
    </div>
                <!-- Numero de tarjeta-->
                <div class="row" >
                    <div class="small-3 columns">
                        <label for="cardTypesAS" class="text-left">Card Type</label>
                    </div>
                    <div class="small-9 columns">
                          <div class="caja">
                            <select id="cardTypesAS" class="input-group-field round">
						<?php
						$html = "";
                            foreach($creditCardType as $item){
                            	if ($TypeID == $item->ID) {
									$html .= '<option selected value= '.$item->ID.' >'.$item->CcTypeDesc. '</option>';
                            	 } else{
                            	 	$html .= '<option value= '.$item->ID.' >'.$item->CcTypeDesc.' </option>';
                            	 	}
                                  }echo ($html) ; ?>
                            </select>
      
                          </div>
                    </div>
                </div>
                <!-- fecha de expiracion-->
                <div class="row">
                    <div class="small-3 columns">
                        <label  for="dateExpiracionAS" class="text-left">Expiration Date</label>
                    </div>
                    <div class="small-9 columns">
                        <input class="round general" value=<?php echo $ExpDate; ?> type="text" id="dateExpiracionAS" name="dateExpiracionAS" class="general" required>
                    </div>
                </div>
                 <!-- Codigo Postal-->
                <div class="row">
                    <div class="small-3 columns">
                        <label  for="codigoPostalAS" class="text-left">Postcode</label>
                    </div>
                    <div class="small-9 columns">
                        <input class="round general" value=<?php echo $ZIP; ?> type="text" id="codigoPostalAS" name="codigoPostalAS" class="general" required>
                    </div>
                </div>
                <!-- Codigo tarjeta-->
                <div class="row">
                    <div class="small-3 columns">
                        <label  for="codigoTarjetaAS" class="text-left">CVC</label>
                    </div>
                   <div class="small-9 columns">
                        <input class="round general" value=<?php echo $Code; ?> type="text" id="codigoTarjetaAS" name="codigoTarjetaAS" class="general" required>
                    </div>
                </div>
    </fieldset>