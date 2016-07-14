<fieldset class="fieldset">
<form>
  <div class="row">
    <div class="small-3 columns">
      <label for="legalName" class="text-left">Pack type</label>
    </div>
    <div class="small-9 columns">
		<div class="caja">
			<select id="tiposPakc" class="input-group-field round"></select>
		</div>
    </div>
  </div>
   <div class="row">
    <div class="small-3 columns">
      <label for="montoPack" class="text-left">Amount</label>
    </div>
    <div class="small-9 columns">
       <input class="round general" id="montoPack" type="number" name="montoPack" min="0" max="999999">
    </div>
  </div>
   <div class="row">
    <div class="small-3 columns">
      <label for="legalName" class="text-left"></label>
    </div>
    <div class="small-9 columns">
    <!--<a id="btnAddmontoPack" href="#" class="button postfix">Add</a>
     <a id="btnCleanmontoPack" href="#" class="button postfix">clean</a>-->
	 <a id="btnAddmontoPack" class="btn btn-primary btn-Search">
			<div class="label">Add</div>
			<img src="<?php echo base_url().IMG; ?>common/more.png"/>
		</a>
		<a id="btnCleanmontoPack" class="btn btn-primary spanSelect">
			<div class="label">Clean</div>
			<img src="<?php echo base_url().IMG; ?>common/BORRAR2.png"/>
		</a>
    </div>
  </div>
</form>
<fieldset class="fieldset">
    <legend class="btnAddressData">Pack addends</legend>
    <div class="containerPeople">
        <div class="row">
            <table id="tablePackgSelected" width="100%">
                <thead>
                    <tr>
                        <th class="cellGeneral">pack Type</th>
                        <th class="cellGeneral">Amount</th>
                        <th class="cellGeneral">Delete</th>
                   </tr>
                </thead>
                <tbody id="tbodytablePackgSelected">
                </tbody>
            </table>
        </div>
    </div>
</fieldset>
  <div class="row">
    <div class="small-3 columns">
      <label for="totalDescPack" class="text-left">Total</label>
    </div>
    <div class="small-9 columns">
       <input class="round general" id="totalDescPack" type="number" name="totalDescPack" min="2016" max="2099">
    </div>
  </div>
</fieldset>