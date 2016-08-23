 <?php if (isset($tarjetaAsociada[0])) {
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
 <legend>New Exchange Rate</legend>

                <!-- Numero de tarjeta-->
                <div class="row" >
                    <div class="small-3 columns">
                        <label for="fromCurrency" class="text-left">From Currency</label>
                    </div>
                    <div class="small-9 columns">
                          <div class="caja">
                            <select id="fromCurrency" class="input-group-field round">
						<?php
						$html = "";
                            foreach($creditCardType as $item){
                            	if ($TypeID == $item->ID) {
									$html .= '<option selected value= '.$item->ID.' >'.$item->CurrencyDesc. '</option>';
                            	 } else{
                            	 	$html .= '<option value= '.$item->ID.' >'.$item->CurrencyDesc.' </option>';
                            	 	}
                                  }echo ($html) ; ?>
                            </select>
      
                          </div>
                    </div>
                </div>
                     <!-- Numero de tarjeta-->
    <div class="row">
        <div class="small-3 columns">
            <label for="fromAmount" class="text-left">From Amount</label>
        </div>
        <div class="small-9 columns">
            <input class="round general" type="number" id="fromAmount" name="fromAmount" class="general" required>
        </div>
    </div>
                <!-- Numero de tarjeta-->
                <div class="row" >
                    <div class="small-3 columns">
                        <label for="toCurrency" class="text-left">To Currency</label>
                    </div>
                    <div class="small-9 columns">
                          <div class="caja">
                            <select id="toCurrency" class="input-group-field round">
                        <?php
                        $html = "";
                            foreach($creditCardType as $item){
                                if ($TypeID == $item->ID) {
                                    $html .= '<option selected value= '.$item->ID.' >'.$item->CurrencyDesc. '</option>';
                                 } else{
                                    $html .= '<option value= '.$item->ID.' >'.$item->CurrencyDesc.' </option>';
                                    }
                                  }echo ($html) ; ?>
                            </select>
      
                          </div>
                    </div>
                </div>
                   

        <!-- Numero de tarjeta-->
    <div class="row">
        <div class="small-3 columns">
            <label for="toAmount" class="text-left">To Amount</label>
        </div>
        <div class="small-9 columns">
            <input class="round general" type="number" id="toAmount" name="toAmount" class="general" required>
        </div>
    </div>
                <!-- fecha de expiracion-->
                <div class="row">
                    <div class="small-3 columns">
                        <label  for="validFromEx" class="text-left">Valid From</label>
                    </div>
                    <div class="small-9 columns">
                        <input class="round general" value=<?php echo $ExpDate; ?> type="text" id="validFromEx" name="validFromEx" class="general" required>
                    </div>
                </div>
    </fieldset>