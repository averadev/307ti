<div class="row contentModal" id="contentModalContract">
    <div id="tabs-1">
        <!-- Error Message -->
        <div class="row" id="alertValidateContrato" style="display:none;">
            <div class="small-12 columns">
                <div data-alert class="alert-box alert " >
                    Por favor rellene los campos Obligatorios(rojo)
                </div>
            </div>
        </div>
        <form id="saveDataContract" data-abide>
            <div class="fieldset large-12 columns">
                <legend>
                    Contract Data
                </legend>
                <!-- Legal name-->
                <div class="row">
                    <div class="small-3 columns">
                        <label for="legalName" class="text-left">Legal Name</label>
                    </div>
                    <div class="small-9 columns">
                        <input type="text" id="legalName" name="legalName" class="round general" required>
                    </div>
                </div>
                <!-- Language-->
                <div class="row">
                    <div class="small-3 columns">
                        <label  for="selectLanguage" class="text-left">Language</label>
                    </div>
                    <div class="small-9 columns">
						<div class="caja" >
							<select required class="input-group-field round" id="selectLanguage" form="saveDataContract"></select>
						</div>
                    </div>
                </div>
                <!-- Tour ID-->
                <div class="row">
                    <div class="small-3 columns">
                        <label  for="TourID" class="text-left">Tour ID</label>
                    </div>
					<div class="large-9 columns">
						<div class="row">
							<div class="small-4 large-6 columns">
								<input value="0" readonly type="text" class="round general" placeholder="ID" name="TourID" id="TourID" required>
							</div>
							<div class="small-8 large-6 columns">
								<a id="btnAddTourID" class="btn btn-primary spanSelect">
									<div class="label">Agregar</div>
									<img src="<?php echo base_url().IMG; ?>common/more.png"/>
								</a>
								<a id="btnDeleteTourID" class="btn btn-primary spanSelect">
									<div class="label">Limpiar</div>
									<img src="<?php echo base_url().IMG; ?>common/BORRAR2.png"/>
								</a>
							</div>
						</div>
					</div>
                </div>

                <div class="containerPeople">
                    <div class="row">
                        <div class="small-12 columns">
                            <!--<a id="btnAddPeople" href="#" class="button tiny"><i class="fa fa-user-plus"></i></a>-->
							<a id="btnAddPeople" class="btn btn-primary spanSelect">
								<div class="label">Agregar</div>
								<img src="<?php echo base_url().IMG; ?>common/more.png"/>
							</a>
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
                                <tbody>
									<tr><td colspan="10" ></td></tr>
								</tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Unidades -->
            <div class="fieldset large-12 columns">
                <legend class="btnAddressData">Unidades</legend>
                <div class="containerPeople">
                    <div class="row">
                        <div class="small-12 columns">
                            <!--<a id="btnAddUnidades" href="#" class="button tiny"><i class="fa fa-home"></i></a>-->
							<a id="btnAddUnidades" class="btn btn-primary spanSelect">
								<div class="label">Add</div>
								<img src="<?php echo base_url().IMG; ?>common/more.png"/>
							</a>
                        </div>
                        <div class="small-12 columns table-section2">
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
								<tbody>
									<tr><td colspan="10" ></td></tr>
								</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Condiciones de financiamiento -->
             <div class="fieldset large-12 columns">
                <legend>Sales Condition</legend>
                <div class="row">
                    <div class="small-6 columns">
						<label  class="text-left">Sell Type</label>
						<div class="caja" >
							<select id="typeSales" class="input-group-field round">
							</select>
						</div>
                    </div>
                    <div class="small-6 columns">
						<div class="row collapse">
							<label id="alertLastName" for="contractR" class="text-left">Contract Related</label>
							<div class="small-10 columns">
								<input class="round general" id="contractR" name="contractR" type="text" placeholder="Folio" value="0">
							</div>
							<div class="small-2 columns">
								<a class="button postfix img"><img src="<?php echo base_url().IMG; ?>common/BUSCAR.png"/></a>
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
							<tr><td colspan="10" ></td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
					<div class="small-3 columns">
						<label>Unit Price</label>
					</div>
                    <div class="large-5 columns end">
                        <input readonly type="text" id="precioUnidad" name="precioUnidad" class="round general" required>
                    </div>
				</div>
				<div class="row">
					<div class="small-3 columns">
						<label>Pack Reference</label>
					</div>
                    <div class="large-5 columns end">
						<input class="round general" readonly name="packReference" id="packReference" type="text" value="0">
                    </div>
					<div class="large-4 columns end">
						<a id="btnPackReference" href="#" class="button postfix">Capture</a>
					</div>
				</div>
				<div class="row border-bottom">
					<div class="small-3 columns">
						<label>Sell Price</label>
					</div>
                    <div class="large-5 columns end">
						<input class="round general" readonly required type="text" id="precioVenta" name="precioVENTA" placeholder="$0.00" />
                    </div>
                </div>

                <div class="row">
                    <div class="large-3 columns">
                        <label>Downpayment</label>
					</div>
					<div class="large-5 columns end">
						<input class="round general" id="downpayment" required type="text" placeholder="$0.00"/>
                    </div>
					
                    <!---->
				</div>
				<div class="row" style="margin-bottom:10px;">
					<div class="large-3 columns">
						 <label>Choose</label>
					</div>
					<div class="large-6 columns end">
                        <input type="radio" name="engancheR" value="porcentaje" id="porcentaje"><label for="porcentaje">Porcentaje</label>
                        <input checked type="radio" name="engancheR" value="cantidad" id="cantidad"><label for="cantidad">Cantidad</label>
                    </div>
				</div>
				<div class="row">
					<div class="large-3 columns">
						<label>Amount</label>
					</div>
					<div class="large-5 columns end">
						<input class="round general" type="text" placeholder="%" />
                    </div>
				</div>
                <!--Enganche-->
                <div class="row">
                    <div class="small-3 columns">
                        <label for="depositoEnganche" class="text-left">Deposit Downpayment</label>
                    </div>
                    <div class="large-5 columns">
                        <input readonly type="text" id="depositoEnganche" name="depositoEnganche" class="round general" required>
                    </div>
					<div class="small-4 columns">
						<a id="btnDownpayment" href="#" class="button postfix">Capture</a>
					</div>
                </div>
                <!--Pagos programados-->
                <div class="row border-bottom">
                    <div class="small-3 columns">
                        <label id="alertLastName" for="right-label" class="text-left">Scheduled Payments</label>
                    </div>
					<div class="small-5 columns">
						<input class="round general" id="scheduledPayments" type="text" placeholder="$0.00">
					</div>
					<div class="small-4 columns">
						<a id="btnScheduledPayments" href="#" class="button postfix">Capture</a>
					</div>
                </div>
                <!--Montos a Descontar-->
                <div class="row">
                    <div class="small-3 columns">
                        <label id="alertLastName" for="right-label" class="text-left">Discount Amount</label>
                    </div>
					<div class="large-5 columns">
						<input class="round general" id="totalDiscountPacks" type="text" placeholder="$0.00">
					</div>
					<div class="large-4 columns">
						<a id="btnDiscountAmount" href="#" class="button postfix">Capture</a>
					</div>
                </div>
                <div class="row">
					<div class="small-12 columns">
						<p>Added Packs</p>
						<table id="tableDescuentos" class="large-12 columns">
							<thead>
								<tr>
									<th class="cellGeneral">pack type</th>
									<th class="cellGeneral">amount</th>
									<th class="cellGeneral">Delete</th>
								</tr>
							</thead>
							<tbody id="packSeleccionados">
								<tr><td colspan="10" ></td></tr>
							</tbody>
						</table>
					</div>
				</div>
                <div class="row">
                    <div class="small-6 columns">
                        <label>Amount Transferred</label>
                        <input id="amountTransfer" class="round general" type="text" placeholder="$0.00">
                    </div>
                    <div class="small-6 columns">
                        <label>Balance financed</label>
                        <input id="financeBalance" class="round general" type="text" placeholder="$0.00">
                    </div>
                </div>
            </div>
            <!-- <div data-abide-error class="alert callout" style="display: none;">
                <p><i class="fi-alert"></i> please fill required fields (red).</p>
            </div> -->
        </form>
    </div>
</div>