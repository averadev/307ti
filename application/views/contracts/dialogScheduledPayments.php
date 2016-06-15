<fieldset class="fieldset">
<form>
  <div class="row">
    <div class="small-3 columns">
      <label for="downpaymentProgramado" class="text-left">Scheduled payment</label>
    </div>
    <div class="small-9 columns">
       <input class="round general" readonly id="downpaymentProgramado" type="number" name="downpaymentProgramado" min="1" max="480">
    </div>
  </div>
  <div class="row">
    <div class="small-3 columns">
      <label  class="text-left">Payment Type</label>
    </div>
    <div class="small-9 columns">
		<div class="caja">
			<select id="tiposPagoProgramados" class="input-group-field round">
			 <?php
                foreach($paymentTypes as $item){?>
                    <option value="<?php echo $item->ID; ?>"><?php echo $item->Type; ?></option>
                    <?php
                }
            ?>
			</select>
		</div>
    </div>
  </div>
  <fieldset id="datosTarjetaProgramados" class="fieldset" style="display: none;">
                <legend>
                   Card Data
                </legend>
                <!-- Numero de tarjeta-->
                <div class="row">
                    <div class="small-3 columns">
                        <label for="numeroTarjeta" class="text-left">Card Number</label>
                    </div>
                    <div class="small-9 columns">
                        <input class="round general" type="text" id="numeroTarjetaProgramados" name="numeroTarjeta" class="general" required>
                    </div>
                </div>
                <!-- fecha de expiracion-->
                <div class="row">
                    <div class="small-3 columns">
                        <label  for="dateExpiracion" class="text-left">Expiration Date</label>
                    </div>
                    <div class="small-9 columns">
                        <input class="round general" type="text" id="dateExpiracionProgramados" name="dateExpiracion" class="general" required>
                    </div>
                </div>
                 <!-- Codigo Postal-->
                <div class="row">
                    <div class="small-3 columns">
                        <label  for="codigoPostal" class="text-left">PostCode</label>
                    </div>
                    <div class="small-9 columns">
                        <input class="round general" type="text" id="codigoPostalProgramados" name="codigoPostal" class="general" required>
                    </div>
                </div>
                <!-- Codigo tarjeta-->
                <div class="row">
                    <div class="small-3 columns">
                        <label  for="codigoTarjeta" class="text-left">CVC</label>
                    </div>
                   <div class="small-9 columns">
                        <input class="round general" type="text" id="codigoTarjetaProgramados" name="codigoTarjeta" class="general" required>
                    </div>
                </div>
    </fieldset>
  <div class="row">
    <div class="small-3 columns">
      <label for="datePaymentPrg" class="text-left">Payment Date</label>
    </div>
    <div class="small-9 columns">
       <input class="round general" id="datePaymentPrg" type="date" name="datePaymentPrg" min="2016" max="2099">
    </div>
  </div>
   <div class="row">
    <div class="small-3 columns">
      <label for="montoDownpaymentPrg" class="text-left">Amount</label>
    </div>
    <div class="small-9 columns">
       <input class="round general" id="montoDownpaymentPrg" type="number" name="montoDownpaymentPrg" min="0" max="999999">
    </div>
  </div>
   <div class="row">
    <div class="small-3 columns">
      <label for="legalName" class="text-left"></label>
    </div>
    <div class="small-9 columns">
		<!--<a id="btnAddmontoDownpaymentPrg" href="#" class="button postfix">Add</a>
		<a id="btnCleanmontoDownpaymentPrg" href="#" class="button postfix">clean</a>-->
		<a id="btnAddmontoDownpaymentPrg" class="btn btn-primary btn-Search">
			<div class="label">Add</div>
			<img src="<?php echo base_url().IMG; ?>common/more.png"/>
		</a>
		<a id="btnCleanmontoDownpaymentPrg" class="btn btn-primary spanSelect">
			<div class="label">Clean</div>
			<img src="<?php echo base_url().IMG; ?>common/BORRAR2.png"/>
		</a>
    </div>
  </div>
</form>
<fieldset class="fieldset">
    <legend class="btnAddressData">Pagos programados</legend>
    <div class="containerPeople">
        <div class="row">
            <table id="tablePagosPrgSelected" width="100%">
                <thead>
                    <tr>
                        <th class="cellEdit" >Date</th>
                        <th class="cellGeneral">Payment Type</th>
                        <th class="cellGeneral">amount</th>
                        <th class="cellGeneral">Delete</th>
                   </tr>
                </thead>
                <tbody id="tbodyPagosPrgSelected">
                </tbody>
            </table>
        </div>
    </div>
</fieldset>
  <div class="row">
    <div class="small-3 columns">
      <label for="totalProgramado" class="text-left">Total</label>
    </div>
    <div class="small-9 columns">
       <input class="round general" id="totalProgramado" type="number" name="totalProgramado" min="2016" max="2099">
    </div>
  </div>
    <div class="row">
    <div class="small-3 columns">
      <label for="pendiente" class="text-left">Due</label>
    </div>
    <div class="small-9 columns">
       <input class="round general" id="pendiente" type="text" name="pendiente" min="2016" max="2099">
    </div>
  </div>
  </fieldset>