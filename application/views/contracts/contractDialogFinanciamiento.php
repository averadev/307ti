<fieldset class="fieldset">
<form>
  <div class="row">
    <div class="small-3 columns">
      <label for="totalContracF" class="text-left">Total contract</label>
    </div>
    <div class="small-9 columns">
       <p id="totalContracF">$00.00</p>
    </div>
  </div>
  <div class="row">
    <div class="small-3 columns">
      <label for="balanceFinanciarF" class="text-left">Balance a financiar</label>
    </div>
    <div class="small-9 columns">
       <p id="balanceFinanciarF">$00.00</p>
    </div>
  </div>
  <div class="row">
    <div class="small-3 columns">
      <label for="fechaPrimerPagoF" class="text-left">Fecha primer pago</label>
    </div>
    <div class="small-9 columns">
       <input class="round general" id="fechaPrimerPagoF" type="date" name="fechaPrimerPagoF">
    </div>
  </div>
  <div class="row">
    <div class="small-3 columns">
      <label for="terminosFinanciamientoF" class="text-left">Terminos de financiamiento</label>
    </div>
    <div class="small-9 columns">
		<div class="caja">
			<select id="terminosFinanciamientoF" class="input-group-field round">
            <?php
                foreach($factores as $item){
                    ?>
                        <option value="<?php echo $item->ID; ?>" code="<?php echo $item->FactorCode; ?>"><?php echo $item->FactorDesc; ?></option>
                    <?php
                    }
            ?>
<!-- 				<option value="1">Contado</option>
				<option value="2">Tarjeta de Credito</option>
				<option value="3">Facturación</option>
				<option value="4">Transferido</option> -->
			</select>
		</div>
    </div>
  </div>
  <div class="row">
    <div class="small-3 columns">
      <label for="numeroMesesF" class="text-left"># Meses</label>
    </div>
    <div class="small-9 columns">
       <p id="numeroMesesF">0 Meses</p>
    </div>
  </div>
   <div class="row">
    <div class="small-3 columns">
      <label for="tasaInteresF" class="text-left">Tase de interes</label>
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
			<div class="label">Calcular</div>
			<i class="fa fa-calculator" aria-hidden="true"></i>
		</a>
    </div>
  </div>
</form>
<fieldset class="fieldset">
    <legend class="btnAddressData">Pago Mensual</legend>
    <div class="containerPeople">
        <div class="row">
            <table id="tablePagosSelected" width="100%">
                <thead>
                    <tr>
                        <th class="cellEdit" >Pago</th>
                        <th class="cellGeneral">Cargo Cobranza</th>
                        <th class="cellGeneral">Total a pagar</th>
                   </tr>
                </thead>
                <tbody id="tbodyPagosSelected">
                <tr>
                    <td>$0.00</td>
                    <td>$0.00</td>
                    <td>$0.00</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</fieldset>
</fieldset>