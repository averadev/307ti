<fieldset class="fieldset">
<form>
  <div class="row">
    <div class="small-3 columns">
      <label for="tiposPago" class="text-left">Pack type</label>
    </div>
    <div class="small-9 columns">
		<div class="caja">
			<select id="tiposPacksD" class="input-group-field round">
            <?php
            foreach($typesGift as $item){?>
                <option value="<?php echo $item->ID; ?>"><?php echo $item->GiftDesc; ?></option>
            <?php
            }
            ?>   
      </select>
		</div>
    </div>
  </div>
   <div class="row">
    <div class="small-3 columns">
      <label for="montoProvisiones" class="text-left">Amount</label>
    </div>
    <div class="small-9 columns">
       <input class="round general" id="montoProvisiones" type="number" name="montoProvisiones" min="0" max="999999">
    </div>
  </div>
   <div class="row">
    <div class="small-3 columns">
      <label for="btnAddmontoDownpayment" class="text-left"></label>
    </div>
    <div class="small-9 columns">
		<a id="btnAddPovisionesDI" class="btn btn-primary btn-Search">
			<div class="label">Add</div>
			<img src="<?php echo base_url().IMG; ?>common/more.png"/>
		</a>
		<a id="btnCleanAmountProvisiones" class="btn btn-primary spanSelect">
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
            <table id="tableProvisionesDI" width="100%">
                <thead>
                    <tr>
                        <th class="cellGeneral">Pack type</th>
                        <th class="cellGeneral">Amount</th>
                        <th class="cellGeneral">Delete</th>
                   </tr>
                </thead>
                <tbody id="tbodytableProvisionesDI">
                </tbody>
            </table>
        </div>
    </div>
</fieldset>
  </fieldset>