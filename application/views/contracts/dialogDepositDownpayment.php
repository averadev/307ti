<fieldset class="fieldset">
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
       <select id="tiposPago">
        <option value="1">Contado</option>
        <option value="2">Tarjeta de Credito</option>
        <option value="3">Facturación</option>
        <option value="4">Transferido</option>
      </select>
    </div>
  </div>
   <fieldset id="datosTarjeta" class="fieldset" style="display: none;">
                <legend>
                    Datos de la tarjeta
                </legend>
                <!-- Legal name-->
                <div class="row">
                    <div class="small-3 columns">
                        <label for="legalName" class="text-left">Numero de Tarjeta</label>
                    </div>
                    <div class="small-9 columns">
                        <input type="text" id="legalName" name="legalName" class="general" required>
                    </div>
                </div>
                <!-- Language-->
                <div class="row">
                    <div class="small-3 columns">
                        <label id="alertLastName" for="right-label" class="text-left">Fecha de Expiración</label>
                    </div>
                    <div class="small-9 columns">
                        <select id="selectLanguage" form="saveDataContract" required></select>
                    </div>
                </div>
                <!-- Codigo-->
                <div class="row">
                    <div class="small-3 columns">
                        <label id="alertLastName" for="right-label" class="text-left">Código</label>
                    </div>
                    <div class="small-9 columns">
                        <select id="selectLanguage" form="saveDataContract" required></select>
                    </div>
                </div>
    </fieldset>

  <div class="row">
    <div class="small-3 columns">
      <label for="datePayment" class="text-left">payment date</label>
    </div>
    <div class="small-9 columns">
       <input id="datePayment" type="date" name="datePayment" min="2016" max="2099">
    </div>
  </div>
   <div class="row">
    <div class="small-3 columns">
      <label for="montoDownpayment" class="text-left">monto</label>
    </div>
    <div class="small-9 columns">
       <input id="montoDownpayment" type="number" name="montoDownpayment" min="0" max="999999">
    </div>
  </div>
   <div class="row">
    <div class="small-3 columns">
      <label for="legalName" class="text-left"></label>
    </div>
    <div class="small-9 columns">
    <a id="btnAddmontoDownpayment" href="#" class="button postfix">Add</a>
     <a id="btnCleanmontoDownpayment" href="#" class="button postfix">clean</a>
    </div>
  </div>
</form>
<fieldset class="fieldset">
    <legend class="btnAddressData">Pagos agregados</legend>
    <div class="containerPeople">
        <div class="row">
            <table id="tablePagosSelected" width="100%">
                <thead>
                    <tr>
                        <th class="cellEdit" >Date</th>
                        <th class="cellGeneral">payment type</th>
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
  <div class="row">
    <div class="small-3 columns">
      <label for="legalName" class="text-left">total</label>
    </div>
    <div class="small-9 columns">
       <input id="finalPricePack" type="number" name="quantity" min="2016" max="2099">
    </div>
  </div>
    <div class="row">
    <div class="small-3 columns">
      <label for="legalName" class="text-left">reference</label>
    </div>
    <div class="small-9 columns">
       <input id="finalPricePack" type="text" name="quantity" min="2016" max="2099">
    </div>
  </div>
  </fieldset>