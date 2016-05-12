<div class="contentModal">
    <div id="tabs-1">
        <!-- Error Message -->
        <div class="row" id="alertValidateContrato" style="display:none;">
            <div class="small-12 columns">
                <div data-alert class="alert-box alert " >
                    Por favor rellene los campos Obligatorios(rojo)
                </div>
            </div>
        </div>
        <form id="saveDataContract">
            <fieldset class="fieldset">
                <legend>
                    Contract Data
                </legend>
                <!-- Legal name-->
                <div class="row">
                    <div class="small-3 columns">
                        <label for="legalName" class="text-left">Legal Name</label>
                    </div>
                    <div class="small-9 columns">
                        <input type="text" id="legalName" name="legalName" class="general" required>
                    </div>
                </div>
                <!-- Language-->
                <div class="row">
                    <div class="small-3 columns">
                        <label id="alertLastName" for="right-label" class="text-left">Language</label>
                    </div>
                    <div class="small-9 columns">
                        <select id="selectLanguage" form="saveDataContract" required></select>
                    </div>
                </div>
                <!-- Tour ID-->
                <div class="row">
                    <div class="small-3 columns">
                        <label  for="TourID" class="text-left">Tour ID</label>
                    </div>
                            <div class="large-9 columns">
                                <div class="row collapse">
                                    <div class="small-10 columns">
                                        <input value="0" readonly type="text" placeholder="ID" name="TourID" id="TourID" required>
                                    </div>
                                    <div class="small-2 columns">
                                        <a id="btnAddTourID" href="#" class="button postfix"><i class="fa fa-plus"></i></a>
                                        <a id="btnDeleteTourID" href="#" class="button postfix"><i class="fa fa-trash-o"></i></a>
                                    </div>
                                </div>
                            </div>
                   <!--  <div class="large-9 columns">
                        <div class="row collapse">
                            <div class="small-10 columns">
                                <input value="0" readonly type="text" placeholder="ID" name="TourID" id="TourID" required>
                            </div>
                            <div class="small-2 columns">
                                <a id="btnAddTourID" href="#" class="button postfix">Add</a>
                            </div>
                        </div>
                    </div> -->
                </div>

                <div class="containerPeople">
                    <div class="row">
                        <div class="small-12 columns">
                            <a id="btnAddPeople" href="#" class="button tiny"><i class="fa fa-user-plus"></i></a>
                        </div>
                        <div class="small-12 columns">
                            <table id="tablePeopleSelected" width="100%">
                                <thead>
                                <tr>
                                    <th class="cellEdit" >ID</th>
                                    <th class="cellGeneral">Nombre</th>
                                    <th class="cellGeneral">Apellidos</th>
                                    <th class="cellGeneral" >Dirección</th>
                                    <th class="cellGeneral" >Persona Principal</th>
                                    <th class="cellGeneral" >Persona Secundaria</th>
                                    <th class="cellGeneral" >Beneficiario</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </fieldset>
            <!-- Unidades -->
            <fieldset class="fieldset">
                <legend class="btnAddressData">Unidades</legend>
                <div class="containerPeople">
                    <div class="row">
                        <div class="small-12 columns">
                            <a id="btnAddUnidades" href="#" class="button tiny"><i class="fa fa-home"></i></a>
                        </div>
                        <div class="small-12 columns">
                            <table id="tableUnidadesSelected" width="100%">
                                <thead>
                                    <tr>
                                        <th class="cellEdit" >Code</th>
                                        <th class="cellGeneral">Description</th>
                                        <th class="cellGeneral">Price</th>
                                        <th class="cellGeneral">Frequency</th>
                                        <th class="cellGeneral">Season</th>
                                        <th class="cellGeneral"># de Semana</th>
                                        <th class="cellGeneral">First Year OCC</th>
                                        <th class="cellGeneral">Last Year OCC</th>
                                        <th class="cellGeneral"></th>
                                    </tr>
                                </thead>
                            <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </fieldset>
            <!-- Condiciones de financiamiento -->
            <fieldset class="fieldset">
                <legend>Sales Condition</legend>
                <div class="row">
                    <div class="small-6 columns">
                        <div class="row">
                            <div class="small-3 columns">
                                <label  class="text-left">Sell Type</label>
                            </div>
                            <div class="small-9 columns">
                                <select id="typeSales">

                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="small-6 columns">
                        <div class="row">
                            <div class="small-3 columns">
                                <label id="alertLastName" for="contractR" class="text-left">Contract Related</label>
                            </div>
                            <div class="large-9 columns">
                                <div class="row collapse">
                                    <div class="small-10 columns">
                                        <input id="contractR" name="contractR" type="text" placeholder="Folio">
                                    </div>
                                    <div class="small-2 columns">
                                        <a href="#" class="button postfix"><i class="fa fa-search"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="small-12 columns">
                    <table id="tableFinanciamiento" class="small-12 columns">
                        <thead>
                        <tr>
                            <th class="cellEdit" >Folio</th>
                            <th class="cellGeneral">Nombre Legal</th>
                            <th class="cellGeneral">Tipo de unidad</th>
                            <th class="cellDate" >Fecha</th>
                            <th class="cellGeneral" >Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="large-4 columns">
                        <label>Unit Price
                            <input readonly required type="text" id="precioUnidad" name="precioUNIDAD" placeholder="$0.00"/>
                        </label>
                    </div>
                    <div class="large-4 columns">
                        <label>Pack Reference
                            <div class="row collapse">
                                <div class="small-8 columns">
                                    <input required name="depositoEnganche" id="deposito" type="text" placeholder="$0.00">
                                </div>
                                <div class="small-4 columns">
                                    <a id="btnPackReference" href="#" class="button postfix">Capture</a>
                                </div>
                            </div>
                    </div>
                    <div class="large-4 columns">
                        <label>Sell Price
                            <input readonly required type="text" id="precioVenta" name="precioVENTA" placeholder="$0.00" />
                        </label>
                    </div>
                </div>


                <div class="row">
                    <div class="large-4 columns">
                        <label>Downpayment
                            <input id="downpayment" required type="text" placeholder="$0.00"/>
                        </label>
                    </div>
                    <div class="large-4 columns">
                        <label>Choose</label>
                        <input type="radio" name="engancheR" value="porcentaje" id="porcentaje"><label for="porcentaje">Porcentaje</label>
                        <input checked type="radio" name="engancheR" value="cantidad" id="cantidad"><label for="cantidad">Cantidad</label>
                    </div>
                    <div class="large-4 columns">
                        <label>Amount
                            <input type="text" placeholder="%" />
                        </label>
                    </div>
                </div>
                <!--Enganche-->
                <div class="row">
                    <div class="small-3 columns">
                        <label for="depositoEnganche" class="text-left">Deposit Downpayment</label>
                    </div>
                    <div class="large-9 columns">
                        <div class="row collapse">
                            <div class="small-10 columns">
                                <input required name="depositoEnganche" id="deposito" type="text" placeholder="$0.00">
                            </div>
                            <div class="small-2 columns">
                                <a id="btnDownpayment" href="#" class="button postfix">Capture</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Pagos programados-->
                <div class="row">
                    <div class="small-3 columns">
                        <label id="alertLastName" for="right-label" class="text-left">Scheduled Payments</label>
                    </div>
                    <div class="large-9 columns">
                        <div class="row collapse">
                            <div class="small-10 columns">
                                <input type="text" placeholder="$0.00">
                            </div>
                            <div class="small-2 columns">
                                <a id="btnScheduledPayments" href="#" class="button postfix">Capture</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Montos a Descontar-->
                <div class="row">
                    <div class="small-3 columns">
                        <label id="alertLastName" for="right-label" class="text-left">Discount Amount</label>
                    </div>
                    <div class="small-9 columns">
                        <div class="row collapse">
                            <div class="large-10 columns">
                                <input type="text" placeholder="$0.00">
                            </div>
                            <div class="large-2 columns">
                                <a id="btnDiscountAmount" href="#" class="button postfix">Capture</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="small-12 columns">
                            <p>Added Packs</p>
                            <table id="tableDescuentos" class="large-12 columns">
                                <thead>
                                <tr>
                                    <th class="cellGeneral" >Pack Type</th>
                                    <th class="cellGeneral">Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <div class="row">
                    <div class="small-6 columns">
                        <label>Amount Transferred</label>
                        <input type="text" placeholder="$0.00">
                    </div>
                    <div class="small-6 columns">
                        <label>Balance financed</label>
                        <input type="text" placeholder="$0.00">
                    </div>
                </div>
            </fieldset>
            <div data-abide-error class="alert callout" style="display: none;">
                <p><i class="fi-alert"></i> please fill required fields (red).</p>
            </div>
        </form>
    </div>
</div>