<fieldset class="fieldset">
<form>
  <div class="row">
    <div class="small-3 columns">
      <label for="downpaymentPrice" class="text-left">Down payment</label>
    </div>
    <div class="small-9 columns">
       <input class="round general" readonly id="downpaymentPrice" type="number" name="downpaymentPrice" min="1" max="480">
    </div>
  </div>
  <div class="row">
    <div class="small-3 columns">
      <label for="downpaymentGastos" class="text-left">contract expenditure</label>
    </div>
    <div class="small-9 columns">
       <input class="round general" id="downpaymentGastos" type="number" name="downpaymentGastos" min="0" value="999">
    </div>
  </div>
  <div class="row">
    <div class="small-3 columns">
      <label for="downpaymentTotal" class="text-left">Total to pay</label>
    </div>
    <div class="small-9 columns">
       <input class="round general" readonly id="downpaymentTotal" type="number" name="downpaymentTotal">
    </div>
  </div>
  <div class="row">
    <div class="small-3 columns">
      <label for="tiposPago" class="text-left">payment type</label>
    </div>
    <div class="small-9 columns">
		<div class="caja">
			<select id="tiposPago" class="input-group-field round">
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
    <fieldset id="datosTarjeta" class="fieldset" style="display: none;">
    <legend>Card Data</legend>
                <!-- Numero de tarjeta-->
                <div class="row">
                    <div class="small-3 columns">
                        <label for="numeroTarjeta" class="text-left">Card Number</label>
                    </div>
                    <div class="small-9 columns">
                        <input class="round general" type="text" id="numeroTarjeta" name="numeroTarjeta" class="general" required>
                    </div>
                </div>
                <!-- fecha de expiracion-->
                <div class="row">
                    <div class="small-3 columns">
                        <label  for="dateExpiracion" class="text-left">Expiration Date</label>
                    </div>
                    <div class="small-9 columns">
                        <input class="round general" type="text" id="dateExpiracion" name="dateExpiracion" class="general" required>
                    </div>
                </div>
                 <!-- Codigo Postal-->
                <div class="row">
                    <div class="small-3 columns">
                        <label  for="codigoPostal" class="text-left">Postcode</label>
                    </div>
                    <div class="small-9 columns">
                        <input class="round general" type="text" id="codigoPostal" name="codigoPostal" class="general" required>
                    </div>
                </div>
                <!-- Codigo tarjeta-->
                <div class="row">
                    <div class="small-3 columns">
                        <label  for="codigoTarjeta" class="text-left">CVC</label>
                    </div>
                   <div class="small-9 columns">
                        <input class="round general" type="text" id="codigoTarjeta" name="codigoTarjeta" class="general" required>
                    </div>
                </div>
    </fieldset>

  <div class="row">
    <div class="small-3 columns">
      <label for="datePayDawnpayment" class="text-left">Payment Date</label>
    </div>
    <div class="small-9 columns">
       <input class="round general" id="datePayDawnpayment" type="date" name="datePayDawnpayment" min="2016" max="2099">
    </div>
  </div>
   <div class="row">
    <div class="small-3 columns">
      <label for="montoDownpayment" class="text-left">Amount</label>
    </div>
    <div class="small-9 columns">
       <input class="round general" id="montoDownpayment" type="number" name="montoDownpayment" min="0" max="999999">
    </div>
  </div>
   <div class="row">
    <div class="small-3 columns">
      <label for="btnAddmontoDownpayment" class="text-left"></label>
    </div>
    <div class="small-9 columns">
		<a id="btnAddmontoDownpayment" class="btn btn-primary btn-Search">
			<div class="label">Add</div>
			<img src="<?php echo base_url().IMG; ?>common/more.png"/>
		</a>
		<a id="btnCleanmontoDownpayment" class="btn btn-primary spanSelect">
			<div class="label">Clean</div>
			<img src="<?php echo base_url().IMG; ?>common/BORRAR2.png"/>
		</a>
    </div>
  </div>
</form>
<fieldset class="fieldset">
    <legend class="btnAddressData">Added Payments</legend>
    <div class="containerPeople">
        <div class="row">
            <table id="tablePagosSelected" width="100%">
                <thead>
                    <tr>
                        <th class="cellEdit" >Date</th>
                        <th class="cellGeneral">Payment type</th>
                        <th class="cellGeneral">Amount</th>
                        <th class="cellGeneral">Delete</th>
                   </tr>
                </thead>
                <tbody id="tbodyPagosSelected">
                </tbody>
            </table>
        </div>
    </div>
</fieldset>
  <div class="row">
    <div class="small-3 columns">
      <label for="finalPriceDownpayment" class="text-left">Total</label>
    </div>
    <div class="small-9 columns">
       <input class="round general" id="finalPriceDownpayment" type="number" name="finalPriceDownpayment" min="2016" max="2099">
    </div>
  </div>
    <div class="row">
    <div class="small-3 columns">
      <label for="referenceDownpayment" class="text-left">Reference</label>
    </div>
    <div class="small-9 columns">
       <input class="round general" id="referenceDownpayment" type="text" name="referenceDownpayment" min="2016" max="2099">
    </div>
  </div>
  </fieldset>