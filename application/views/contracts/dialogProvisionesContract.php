<fieldset class="fieldset">
<form>
  <div class="row">
    <div class="small-3 columns">
      <label for="tiposPago" class="text-left">Pack type</label>
    </div>
    <div class="small-9 columns">
		<div class="caja">
			<select id="tiposPago" class="input-group-field round">
				<option value="1">Contado</option>
				<option value="2">Tarjeta de Credito</option>
				<option value="3">Facturación</option>
				<option value="4">Transferido</option>
			</select>
		</div>
    </div>
  </div>
   <div class="row">
    <div class="small-3 columns">
      <label for="montoDownpayment" class="text-left">monto</label>
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
    <legend class="btnAddressData">Added Packs</legend>
    <div class="containerPeople">
        <div class="row">
            <table id="tablePagosSelected" width="100%">
                <thead>
                    <tr>
                        <th class="cellGeneral">Pack type</th>
                        <th class="cellGeneral">amount</th>
                        <th class="cellGeneral">Delete</th>
                   </tr>
                </thead>
                <tbody id="tbodyPagosSelected">
                </tbody>
            </table>
        </div>
    </div>
</fieldset>
  </fieldset>