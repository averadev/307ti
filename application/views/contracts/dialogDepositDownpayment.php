<form>
  <div class="row">
    <div class="small-3 columns">
      <label for="legalName" class="text-left">Down payment</label>
    </div>
    <div class="small-9 columns">
       <input readonly id="downpaymentPrice" type="number" name="quantity" min="1" max="480">
    </div>
  </div>
  <div class="row">
    <div class="small-3 columns">
      <label for="legalName" class="text-left">contract expenditure</label>
    </div>
    <div class="small-9 columns">
       <input id="downpaymentGastos" type="number" name="quantity" min="0" value="999">
    </div>
  </div>
  <div class="row">
    <div class="small-3 columns">
      <label for="legalName" class="text-left">Total to pay</label>
    </div>
    <div class="small-9 columns">
       <input readonly id="downpaymentTotal" type="number" name="quantity">
    </div>
  </div>
  <div class="row">
    <div class="small-3 columns">
      <label for="legalName" class="text-left">payment type</label>
    </div>
    <div class="small-9 columns">
       <select>
        <option value="1">contado</option>
        <option value="2">tarjeta de credito</option>
        <option value="3">facturación</option>
        <option value="4">transferido</option>
      </select>
    </div>
  </div>
  <div class="row">
    <div class="small-3 columns">
      <label for="legalName" class="text-left">payment date</label>
    </div>
    <div class="small-9 columns">
       <input id="finalPricePack" type="date" name="quantity" min="2016" max="2099">
    </div>
  </div>
   <div class="row">
    <div class="small-3 columns">
      <label for="legalName" class="text-left">monto</label>
    </div>
    <div class="small-9 columns">
       <input id="finalPricePack" type="number" name="quantity" min="1" max="999999">
    </div>
  </div>
</form>
<div class="row small-12">
   <div class="small-6 columns">
        <a id="btnAddTourID" href="#" class="button postfix">Add</a>
   </div>
    <div class="small-6 columns">
        <a id="btnAddTourID" href="#" class="button postfix">clean</a>
   </div>
</div>
            <fieldset class="fieldset">
                <legend class="btnAddressData">Pagos agregados</legend>
                <div class="containerPeople">
                    <div class="row">
                        <div class="small-12 columns">
                            <a id="btnAddUnidades" href="#" class="button tiny"><i class="fa fa-home"></i></a>
                        </div>
                        <table id="tableUnidadesSelected" width="100%">
                            <thead>
                            <tr>
                                <th class="cellEdit" >Date</th>
                                <th class="cellGeneral">payment type</th>
                                <th class="cellGeneral">amount</th>
                                <th class="cellGeneral"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- <tr>
                                <td>sds5d5</td>
                                <td>PArgo 1 3Rec</td>
                                <td>$38,000.00</td>
                                <td>#1</td>
                                <td>2016</td>
                                <td>2017</td>
                                <td>Odd years</td>
                                <td><button type="button" class="alert button"><i class="fa fa-minus-circle fa-lg" aria-hidden="true"></i></button></td>
                            </tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </fieldset>
  <div class="row">
    <div class="small-3 columns">
      <label for="legalName" class="text-left">total</label>
    </div>
    <div class="small-9 columns">
       <input id="finalPricePack" type="date" name="quantity" min="2016" max="2099">
    </div>
  </div>
    <div class="row">
    <div class="small-3 columns">
      <label for="legalName" class="text-left">reference</label>
    </div>
    <div class="small-9 columns">
       <input id="finalPricePack" type="date" name="quantity" min="2016" max="2099">
    </div>
  </div>