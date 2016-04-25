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
        <form id="saveDataContract" data-abide='ajax'>
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
                                <a id="btnAddTourID" href="#" class="button postfix">Add</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="containerPeople">
                    <div class="row">
                        <div class="small-12 columns">
                            <a id="btnAddPeople" href="#" class="button tiny"><i class="fa fa-user-plus"></i></a>
                        </div>
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
                            <tbody>
                            <tr>
                                <td>23</td>
                                <td>Faustino</td>
                                <td>Loeza</td>
                                <td>Cancun</td>
                                <td><input type="radio" name="peopleContract" value="1"></td>
                                <td><input type="radio" name="peopleContract" value="2"></td>
                                <td><input type="radio" name="peopleContract" value="3"></td>
                                <td><button type="button" class="alert button"><i class="fa fa-minus-circle fa-lg" aria-hidden="true"></i></button></td>
                            </tr>
                            </tbody>
                        </table>
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
                        <table id="tableUnidades" width="100%">
                            <thead>
                            <tr>
                                <th class="cellEdit" >Code</th>
                                <th class="cellGeneral">Description</th>
                                <th class="cellGeneral">Precio</th>
                                <th class="cellGeneral" ># de Semana</th>
                                <th class="cellGeneral" >Primer año OCC</th>
                                <th class="cellGeneral" >Ultimo año OCC</th>
                                <th class="cellGeneral" >Frecuencia</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>sds5d5</td>
                                <td>PArgo 1 3Rec</td>
                                <td>$38,000.00</td>
                                <td>#1</td>
                                <td>2016</td>
                                <td>2017</td>
                                <td><input type="radio" name="people" value="3"></td>
                                <td><button type="button" class="alert button"><i class="fa fa-minus-circle fa-lg" aria-hidden="true"></i></button></td>
                            </tr>
                            </tbody>
                        </table>
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
                                        <input required id="contractR" name="contractR" type="text" placeholder="Folio">
                                    </div>
                                    <div class="small-2 columns">
                                        <a href="#" class="button postfix"><i class="fa fa-search"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
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
                            <input readonly required id="precioUnidad" name="precioUNIDAD" type="text" placeholder="$0.00" />
                        </label>
                    </div>
                    <div class="large-4 columns">
                        <label>Pack Reference
                            <input type="text" name="referenciaPACK" placeholder="$0.00" />
                        </label>
                    </div>
                    <div class="large-4 columns">
                        <label>Sell Price
                            <input required type="text" name="precioVENTA" placeholder="$0.00" />
                        </label>
                    </div>
                </div>


                <div class="row">
                    <div class="large-4 columns">
                        <label>Downpayment
                            <input required type="text" placeholder="$0.00" />
                        </label>
                    </div>
                    <div class="large-4 columns">
                        <label>Choose</label>
                        <input type="radio" name="engancheR" value="porcentaje" id="porcentaje"><label for="porcentaje">Porcentaje</label>
                        <input type="radio" name="engancheR" value="cantidad" id="cantidad"><label for="cantidad">Cantidad</label>
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
                                <input required name="depositoEnganche" type="text" placeholder="$0.00">
                            </div>
                            <div class="small-2 columns">
                                <a href="#" class="button postfix">Capture</a>
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
                                <a href="#" class="button postfix">Capture</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Montos a Descontar-->
                <div class="row">
                    <div class="small-3 columns">
                        <label id="alertLastName" for="right-label" class="text-left">Discount Amount</label>
                    </div>
                    <div class="large-9 columns">
                        <div class="row collapse">
                            <div class="small-10 columns">
                                <input type="text" placeholder="$0.00">
                            </div>
                            <div class="small-2 columns">
                                <a href="#" class="button postfix">Capture</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <fieldset>
                        <legend>
                            <i class="fa fa-money"></i>
                        </legend>
                        <div class="row">
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
                    </fieldset>
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
<script>
    $('#btnAddTourID').click(function(){
        ajaxHTML('dialog-tourID', 'tours/modal');
        showModals('dialog-tourID', cleanAddPeople);
    });
    $('#btnAddPeople').click(function(){
        $('#dialog-People').empty();
        ajaxHTML('dialog-People', 'people/');
        showModals('dialog-People', cleanAddPeople);
    });
    $('#btnAddUnidades').click(function(){
        ajaxHTML('dialog-Unidades', 'contract/modalUnidades');
        showModals('dialog-Unidades', cleanAddUnidades);
    });

</script>