<fieldset class="fieldset">
<form>
  <div class="row">
    <div class="small-3 columns">
      <label for="totalContracF" class="text-left">Total Contract</label>
    </div>
    <div id="totalContracF" class="small-9 columns">
       <span >$ <?php echo number_format((float)$precio[0]->totalFinanceAmt, 2, '.', ','); ?></span>
    </div>
  </div>
  <div class="row">
    <div class="small-3 columns">
      <label for="balanceFinanciarF" class="text-left">Balance to be Financed</label>
    </div>
    <div id="balanceFinanciarF" class="small-9 columns">
       </span>$ <?php echo number_format((float)$precio[0]->financeBalance, 2, '.', ','); ?></span>
    </div>
  </div>
  <div class="row">
    <div class="small-3 columns">
      <label for="fechaPrimerPagoF" class="text-left">Payment Date</label>
    </div>
    <div class="small-9 columns">
       <input class="round general" id="fechaPrimerPagoF" type="text" name="fechaPrimerPagoF">
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
       <span id="numeroMesesF">0 Months</span>
    </div>
  </div>
   <div class="row">
    <div class="small-3 columns">
      <label for="tasaInteresF" class="text-left">Interest Rate</label>
    </div>
    <div class="small-9 columns">
       <span id="tasaInteresF">0%</span>
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
            <table id="tablePagosSelectedFin" width="100%">
                <thead>
                    <tr>
                        <th class="cellEdit" >Payment</th>
                        <th class="cellGeneral">Collection Fee Amount</th>
                        <th class="cellGeneral">Total to Pay</th>
                   </tr>
                </thead>
                <tbody id="tbodyPagosSelectedFin">
                <tr>
                    <td id="pagoMF">0.00</td>
                    <td id="CargoCF"><?php echo number_format((float)$CostCollection, 2, '.', ',');?></td>
                    <td id="totalPagarF">0.00</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</fieldset>
</fieldset>