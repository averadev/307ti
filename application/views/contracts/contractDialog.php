<div class="row contentModal" id="contentModalContract">
    <div id="tabs-1">
        <!-- Error Message -->
        <div class="row" id="alertValidateContrato" style="display:none;">
            <div class="small-12 columns">
                <div data-alert class="alert-box alert " >
                    Please fill required fields(red)
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

                        <div class="caja">
                            <select required class="input-group-field round" id="selectLanguage" form="saveDataContract">
                                  <?php
                                      foreach($languages as $item){?>
                                          <option value="<?php echo $item->ID; ?>"><?php echo $item->LanguageDesc; ?></option>
                                          <?php
                                      }
                                  ?>
                            </select>
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
									<div class="label">Add</div>
									<img src="<?php echo base_url().IMG; ?>common/more.png"/>
								</a>
								<a id="btnDeleteTourID" class="btn btn-primary spanSelect">
									<div class="label">Clean</div>
									<img src="<?php echo base_url().IMG; ?>common/BORRAR2.png"/>
								</a>
							</div>
						</div>
					</div>
                </div>
            </div>
             <div class="fieldset large-12 columns">
              <legend class="btnAddressData">People</legend>
                <div class="containerPeople">
                    <div class="row">
                        <div class="small-12 columns">
                            <a id="btnAddPeople" attr_table="tablePeopleSelected" class="btn btn-primary spanSelect">
                                <div class="label">Add</div>
                                <img src="<?php echo base_url().IMG; ?>common/more.png"/>
                            </a>
                        </div>
                        <div class="small-12 columns">
                            <table id="tablePeopleSelected" width="100%">
                                <thead class="colorCrema">
                                    <tr>
                                        <th class="cellEdit" >ID</th>
                                        <th class="cellGeneral">Name</th>
                                        <th class="cellGeneral">Last Name</th>
                                        <th class="cellGeneral" >Address</th>
                                        <th class="cellGeneral" >Primary</th>
                                        <th class="cellGeneral" >Beneficiary</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td colspan="10"></td></tr>
                                </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Unidades -->
            <div class="fieldset large-12 columns">
                <legend class="btnAddressData">Units</legend>
                <div class="containerPeople">
                    <div class="row">
                        <div class="small-12 columns">
							<a id="btnAddUnidades" class="btn btn-primary spanSelect">
								<div class="label">Add</div>
								<img src="<?php echo base_url().IMG; ?>common/more.png"/>
							</a>
                        </div>
                        <div class="small-12 columns">
                            <table id="tableUnidadesSelected" width="100%">
                                <thead class="colorCrema">
                                    <tr>
                                        <th class="cellEdit" >Id</th>
                                        <th class="cellGeneral">Code</th>
                                        <th class="cellGeneral">Description</th>
                                        <th class="cellGeneral">Price</th>
                                        <th class="cellGeneral">Frequency</th>
                                        <th class="cellGeneral">Season</th>
                                        <th class="cellGeneral"># Week</th>
                                        <th class="cellGeneral">First Year OCC</th>
                                        <th class="cellGeneral">Last Year OCC</th>
                                        <th></th>
                                    </tr>
                                </thead>
								<tbody>
									<tr><td colspan="12" ></td></tr>
								</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Condiciones de financiamiento -->
             <div class="fieldset large-12 columns">
                <legend>Sale Terms</legend>
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
<!-- 							<div class="small-2 columns">
								<a class="button postfix img"><img src="<?php echo base_url().IMG; ?>common/BUSCAR.png"/></a>
							</div> -->
						</div>
					</div>
                </div>
                <div class="small-12 columns">
                    <table id="tableFinanciamiento" class="small-12 columns">
                        <thead class="colorCrema">
                        <tr>
                            <th class="cellEdit" >Folio</th>
                            <th class="cellGeneral">Legal Name</th>
                            <th class="cellGeneral">Unit Type</th>
                            <th class="cellDate" >Date</th>
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
						<label>Extras</label>
					</div>
                    <div class="small-5 columns end">
						<input class="round general" readonly name="packReference" id="packReference" type="text" value="0">
                    </div>
					<div class="small-4 columns end">
						<a id="btnPackReference" href="#" class="button postfix">Capture</a>
					</div>
				</div>
				<div class="row">
					<div class="small-3 columns">
						<label>Sale Price</label>
					</div>
                    <div class="large-5 columns end">
						<input class="round general" readonly required type="text" id="precioVenta" name="precioVENTA" placeholder="$0.00" />
                    </div>
                </div>
                <div class="row border-bottom">
                    <div class="small-3 columns">
                        <label>Closing Cost</label>
                    </div>
                    <div class="large-5 columns end">
                        <input class="round general" readonly required type="text" id="closingCostLabel" name="closingCostLabel" placeholder="$0.00" />
                    </div>
                </div>
                <!--Montos a Descontar-->
                <div class="row">
                    <div class="large-3 columns">
                        <label>Special Discount</label>
                    </div>
                    <div class="large-2 columns end">
                        <input class="round general" id="descuentoEspecial" type="text" placeholder="$0.00"/>
                    </div>
                    <div class="large-4 columns end">
                        <input type="radio" name="especialDiscount" value="porcentaje" id="porcentajeDE"><label for="porcentaje">Percentage</label>
                        <input checked type="radio" name="especialDiscount" value="cantidad" id="cantidadDE"><label for="cantidad">Amount</label>
                    </div>
                    <div class="large-1 columns">
                        <label>Amount</label>
                    </div>
                    <div class="large-2 columns end">
                        <input id="montoTotalDE" readonly class="round general" type="text" placeholder="amount applied" />
                    </div>
                </div>
                <div class="row">
                    <div class="large-3 columns">
                        <label>Downpayment</label>
					</div>
					<div class="large-2 columns end">
						<input class="round general" id="downpayment" required type="text" placeholder="$0.00"/>
                    </div>
                    <div class="large-4 columns end">
                        <input type="radio" name="engancheR" value="porcentaje" id="porcentaje"><label for="porcentaje">Percentage</label>
                        <input checked type="radio" name="engancheR" value="cantidad" id="cantidad"><label for="cantidad">Amount</label>
                    </div>
                    <div class="large-1 columns">
                        <label>Amount</label>
                    </div>
                    <div class="large-2 columns end">
                        <input id="montoTotal" readonly class="round general" type="text" placeholder="amount applied" />
                    </div>
				</div>
                <div class="row">
                    <div class="small-3 columns">
                        <label for="depositoEnganche" class="text-left">Deposit</label>
                    </div>
                    <div class="small-5 columns">
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
						<input class="round general" readonly id="scheduledPayments" type="text" placeholder="$0.00">
					</div>
					<div class="small-4 columns">
						<a id="btnScheduledPayments" href="#" class="button postfix">Capture</a>
					</div>
                </div>
                <!--Montos a Descontar-->
                <div class="row">
                    <div class="small-3 columns">
                        <label id="alertLastName" for="right-label" class="text-left">Cash Discount</label>
                    </div>
					<div class="small-5 columns">
						<input class="round general" id="totalDiscountPacks" type="text" placeholder="$0.00">
					</div>
					<div class="small-4 columns">
						<a id="btnDiscountAmount" href="#" class="button postfix">Capture</a>
					</div>
                </div>
                <div class="row">
					<div class="small-12 columns">
						<table id="tableDescuentos" class="large-12 columns">
							<thead class="colorCrema">
								<tr>
									<th class="cellGeneral">Gift Type</th>
									<th class="cellGeneral">Amount</th>
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
                        <label>Transfer Amount</label>
                        <input id="amountTransfer" class="round general" type="text" placeholder="$0.00">
                    </div>
                    <div class="small-6 columns">
                        <label>Balance to be Financed</label>
                        <input readonly id="financeBalance" class="round general" type="text" placeholder="$0.00">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>