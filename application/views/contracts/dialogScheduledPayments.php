<fieldset class="fieldset">
<form>
  <div class="row">
    <div class="small-3 columns">
      <label for="downpaymentProgramado" class="text-left">Scheduled payment</label>
    </div>
    <div class="small-9 columns">
       <input readonly id="downpaymentProgramado" type="number" name="downpaymentProgramado" min="1" max="480">
    </div>
  </div>
  <div class="row">
    <div class="small-3 columns">
      <label for="legalName" class="text-left">payment type</label>
    </div>
    <div class="small-9 columns">
       <select id="tiposPagoProgramados">
        <option value="1">Contado</option>
        <option value="2">Tarjeta de Credito</option>
        <option value="3">Facturación</option>
        <option value="4">Transferido</option>
      </select>
    </div>
  </div>
   <fieldset id="datosTarjetaProgramados" class="fieldset" style="display: none;">
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
      <label for="datePaymentPrg" class="text-left">payment date</label>
    </div>
    <div class="small-9 columns">
       <input id="datePaymentPrg" type="date" name="datePaymentPrg" min="2016" max="2099">
    </div>
  </div>
   <div class="row">
    <div class="small-3 columns">
      <label for="montoDownpaymentPrg" class="text-left">monto</label>
    </div>
    <div class="small-9 columns">
       <input id="montoDownpaymentPrg" type="number" name="montoDownpaymentPrg" min="0" max="999999">
    </div>
  </div>
   <div class="row">
    <div class="small-3 columns">
      <label for="legalName" class="text-left"></label>
    </div>
    <div class="small-9 columns">
    <a id="btnAddmontoDownpaymentPrg" href="#" class="button postfix">Add</a>
     <a id="btnCleanmontoDownpaymentPrg" href="#" class="button postfix">clean</a>
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
                        <th class="cellGeneral">payment type</th>
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
      <label for="totalProgramado" class="text-left">total</label>
    </div>
    <div class="small-9 columns">
       <input id="totalProgramado" type="number" name="totalProgramado" min="2016" max="2099">
    </div>
  </div>
    <div class="row">
    <div class="small-3 columns">
      <label for="pendiente" class="text-left">due</label>
    </div>
    <div class="small-9 columns">
       <input id="pendiente" type="text" name="pendiente" min="2016" max="2099">
    </div>
  </div>
  </fieldset>