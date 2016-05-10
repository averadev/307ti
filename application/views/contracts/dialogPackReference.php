<form>
  <div class="row">
    <div class="small-3 columns">
      <label for="legalName" class="text-left">Unit Price</label>
    </div>
    <div class="small-9 columns">
       <input readonly id="unitPricePack" type="number" >
    </div>
  </div>
  <div class="row">
    <div class="small-3 columns">
      <label for="legalName" class="text-left">%</label>
    </div>
    <div class="small-9 columns">
       <input id="porcentajePack" type="number" min="0" max="500000">
    </div>
  </div>
  <div class="row">
    <div class="small-3 columns">
      <label for="legalName" class="text-left">Quantity</label>
    </div>
    <div class="small-9 columns">
       <input id="quantityPack" type="number" min="0" max="500000">
    </div>
  </div>
  <div class="row">
    <div class="small-3 columns">
      <label for="legalName" class="text-left">Final Price</label>
    </div>
    <div class="small-9 columns">
       <input readonly id="finalPricePack" type="number" >
    </div>
  </div>
</form>