<fieldset class="fieldset">
<form>
  <div class="row">
    <div class="small-3 columns">
      <label for="totalContracF" class="text-left">Total Contract</label>
    </div>
    <div class="small-9 columns">
       <p id="totalContracF"><?php echo $precio[0]->totalFinanceAmt; ?></p>
    </div>
  </div>
  <div class="row">
    <div class="small-3 columns">
      <label for="balanceFinanciarF" class="text-left">Balance a financiar</label>
    </div>
    <div class="small-9 columns">
       <p id="balanceFinanciarF"><?php echo $precio[0]->financeBalance; ?></p>
    </div>
  </div>
  <div class="row">
    <div class="small-3 columns">
      <label for="fechaPrimerPagoF" class="text-left">Payment Date</label>
    </div>
    <div class="small-9 columns">
       <input class="round general" id="fechaPrimerPagoF" type="date" name="fechaPrimerPagoF">
    </div>
  </div>
  <div class="row">
    <div class="small-3 columns">
      <label for="terminosFinanciamientoF" class="text-left">Financing Terms</label>
    </div>
    <div class="small-9 columns">
		<div class="caja">
			<select id="terminosFinanciamientoF" class="input-group-field round">
            <?php
                foreach($factores as $item){
                    ?>
                        <option value="<?php echo $item->ID; ?>" code="<?php echo floatval($item->Factorfin); ?>"><?php echo $item->FactorDesc; ?></option>
                    <?php
                    }
            ?>
			</select>
		</div>
    </div>
  </div>
  <div class="row">
    <div class="small-3 columns">
      <label for="numeroMesesF" class="text-left"># Months</label>
    </div>
    <div class="small-9 columns">
       <p id="numeroMesesF">0 Months</p>
    </div>
  </div>
   <div class="row">
    <div class="small-3 columns">
      <label for="tasaInteresF" class="text-left">Interest Rate</label>
    </div>
    <div class="small-9 columns">
       <p id="tasaInteresF">0%</p>
    </div>
  </div>
   <div class="row">
    <div class="small-3 columns">
      <label class="text-left"></label>
    </div>
    <div class="small-9 columns">
		<a id="btnCalcularF" class="btn btn-primary spanSelect">
			<div class="label">Calculate</div>
			<i class="fa fa-calculator" aria-hidden="true"></i>
		</a>
    </div>
  </div>
</form>
<fieldset class="fieldset">
    <legend class="btnAddressData">Monthly Payment</legend>
    <div class="containerPeople">
        <div class="row">
            <table id="tablePagosSelected" width="100%">
                <thead>
                    <tr>
                        <th class="cellEdit" >Payment</th>
                        <th class="cellGeneral">Collection Fee Amount</th>
                        <th class="cellGeneral">Total to Pay</th>
                   </tr>
                </thead>
                <tbody id="tbodyPagosSelected">
                <tr>
                    <td id="pagoMF">0.00</td>
                    <td id="CargoCF"><?php echo floatval($CostCollection);?></td>
                    <td id="totalPagarF">0.00</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</fieldset>
</fieldset>