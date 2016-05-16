<fieldset class="fieldset">
<form>
  <div class="row">
    <div class="small-3 columns">
      <label for="legalName" class="text-left">Pack type</label>
    </div>
    <div class="small-9 columns">
       <select id="tiposPakc">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
      </select>
    </div>
  </div>
   <div class="row">
    <div class="small-3 columns">
      <label for="montoPack" class="text-left">monto</label>
    </div>
    <div class="small-9 columns">
       <input id="montoPack" type="number" name="montoPack" min="0" max="999999">
    </div>
  </div>
   <div class="row">
    <div class="small-3 columns">
      <label for="legalName" class="text-left"></label>
    </div>
    <div class="small-9 columns">
    <a id="btnAddmontoPack" href="#" class="button postfix">Add</a>
     <a id="btnCleanmontoPack" href="#" class="button postfix">clean</a>
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
                        <th class="cellGeneral">pack type</th>
                        <th class="cellGeneral">amount</th>
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
      <label for="totalDescPack" class="text-left">total</label>
    </div>
    <div class="small-9 columns">
       <input id="totalDescPack" type="number" name="totalDescPack" min="2016" max="2099">
    </div>
  </div>
</fieldset>