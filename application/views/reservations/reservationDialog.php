<div class="row contentModal" id="contentModalReservation">
    <div id="tabs-1">
        <!-- Error Message -->
        <div class="row" id="alertValidateContrato" style="display:none;">
            <div class="small-12 columns">
                <div data-alert class="alert-box alert " >
                    Please fill required fields(red)
                </div>
            </div>
        </div>
        <form id="saveDataReservation" data-abide>
            <div class="fieldset large-12 columns">
                <legend>
                    Language
                </legend>
                <!-- Language-->
                <div class="row">
                    <div class="small-3 columns">
                        <label  for="selectLanguageRes" class="text-left">Language</label>
                    </div>
                    <div class="small-9 columns">
						<div class="caja" >
							<select required class="input-group-field round" id="selectLanguageRes" form="saveDataReservation">
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
			</div>
			<div class="fieldset large-12 columns">
                <legend>
                    People
                </legend>
                <div class="containerPeople">
                    <div class="row">
                        <div class="small-12 columns">
                            <!--<a id="btnAddPeople" href="#" class="button tiny"><i class="fa fa-user-plus"></i></a>-->
							<a id="btnAddPeopleRes" class="btn btn-primary spanSelect">
								<div class="label">Add</div>
								<img src="<?php echo base_url().IMG; ?>common/more.png"/>
							</a>
                        </div>
                        <div class="small-12 columns">
                            <table id="tablePeopleResSelected" width="100%">
                                <thead>
									<tr>
										<th class="cellEdit" >ID</th>
										<th class="cellGeneral">Name</th>
										<th class="cellGeneral">Last Name</th>
										<th class="cellGeneral" >Address</th>
										<th class="cellGeneral" >Main</th>
										<th class="cellGeneral" >Secondary</th>
										<th class="cellGeneral" >Beneficiary</th>
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
                <legend class="btnAddressData">Unities</legend>
                <div class="containerPeople">
                    <div class="row">
                        <div class="small-12 columns">
                            <!--<a id="btnAddUnidades" href="#" class="button tiny"><i class="fa fa-home"></i></a>-->
							<a id="btnAddUnidadesRes" class="btn btn-primary spanSelect">
								<div class="label">Add</div>
								<img src="<?php echo base_url().IMG; ?>common/more.png"/>
							</a>
                        </div>
                        <div class="small-12 columns table-section2">
                            <table id="tableUnidadesResSelected" width="100%">
                                <thead>
                                    <tr>
                                        <th class="cellEdit" >Id</th>
                                        <th class="cellGeneral">Description</th>
                                        <th class="cellGeneral">View</th>
                                        <th class="cellGeneral">Frequency</th>
                                        <th class="cellGeneral">floor</th>
										<th class="cellGeneral">Season</th>
										<th class="cellGeneral"># Week</th>
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
                <legend>Sale Terms</legend>
                <div class="row">
                    <div class="small-4 columns">
						<label  class="text-left">Occupancy Type</label>
						<div class="caja" >
							<select id="occupancySalesRes" class="input-group-field round">
							<?php
								foreach($OccupancyTypes as $item){
									?>
									<option value="<?php echo $item->ID; ?>"><?php echo $item->OccTypeDesc; ?></option>
									<?php
								}
							?>
							</select>
						</div>
                    </div>
					<div class="small-4 columns">
						<label for="RateRes" class="text-left">Rate</label>
						<div class="caja" >
							<select id="RateRes" class="input-group-field round">
							</select>
						</div>
                    </div>
                    <div class="small-4 columns">
						<div class="row collapse">
							<label id="alertLastName" for="contractR" class="text-left">Reservation Related</label>
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
						<label>Price</label>
					</div>
                    <div class="large-5 columns end">
                        <input readonly type="text" id="precioUnidadRes" name="precioUnidadRes" class="round general" required>
                    </div>
				</div>
				<div class="row">
					<div class="small-3 columns">
						<label>Extras</label>
					</div>
                    <div class="large-5 columns end">
						<input class="round general" readonly name="packReferenceRes" id="packReferenceRes" type="text" value="0">
                    </div>
					<div class="large-4 columns end">
						<a id="btnPackReferenceRes" href="#" class="button postfix">Capture</a>
					</div>
				</div>
				<div class="row border-bottom">
					<div class="small-3 columns">
						<label>Sell Price</label>
					</div>
                    <div class="large-5 columns end">
						<input class="round general" readonly required type="text" id="precioVentaRes" name="precioVentaRes" placeholder="$0.00" />
                    </div>
                </div>
				<!--Montos a Descontar-->
                <div class="row">
                    <div class="large-3 columns">
                        <label>Special Discount</label>
                    </div>
                    <div class="large-2 columns end">
                        <input class="round general" id="descuentoEspecialRes" type="text" placeholder="$0.00"/>
                    </div>
                    <div class="large-4 columns end">
                        <input type="radio" name="especialDiscountRes" value="porcentaje" id="porcentajeDE"><label for="porcentaje">Percentage</label>
                        <input checked type="radio" name="especialDiscountRes" value="cantidad" id="cantidadDE"><label for="cantidad">Amount</label>
                    </div>
                    <div class="large-1 columns">
                        <label>Amount</label>
                    </div>
                    <div class="large-2 columns end">
                        <input id="montoTotalDERes" class="round general" type="text" placeholder="amount applied" />
                    </div>
                </div>
                <div class="row">
                    <div class="large-3 columns">
                        <label>Downpayment</label>
					</div>
					<div class="large-2 columns end">
						<input class="round general" id="downpaymentRes" required type="text" placeholder="$0.00"/>
                    </div>
                    <div class="large-4 columns end">
                        <input type="radio" name="engancheRRes" value="porcentaje" id="porcentaje"><label for="porcentaje">Percentage</label>
                        <input checked type="radio" name="engancheRRes" value="cantidad" id="cantidad"><label for="cantidad">Amount</label>
                    </div>
                    <div class="large-1 columns">
                        <label>Amount</label>
                    </div>
                    <div class="large-2 columns end">
                        <input id="montoTotalRes" class="round general" type="text" placeholder="%" />
                    </div>
				</div>
                <div class="row">
                    <div class="small-3 columns">
                        <label for="depositoEngancheRes" class="text-left">Deposit</label>
                    </div>
                    <div class="large-5 columns">
                        <input readonly type="text" id="depositoEngancheRes" name="depositoEngancheRes" class="round general" required>
                    </div>
					<div class="small-4 columns">
						<a id="btnDownpaymentRes" href="#" class="button postfix">Capture</a>
					</div>
                </div>
                <!--Pagos programados-->
                <div class="row border-bottom">
                    <div class="small-3 columns">
                        <label id="alertLastName" for="right-label" class="text-left">Scheduled Payments</label>
                    </div>
					<div class="small-5 columns">
						<input class="round general" id="scheduledPaymentsRes" type="text" placeholder="$0.00">
					</div>
					<div class="small-4 columns">
						<a id="btnScheduledPaymentsRes" href="#" class="button postfix">Capture</a>
					</div>
                </div>
                <!--Montos a Descontar-->
                <div class="row">
                    <div class="small-3 columns">
                        <label id="alertLastName" for="right-label" class="text-left">Discount Amount</label>
                    </div>
					<div class="large-5 columns">
						<input class="round general" id="totalDiscountPacksRes" type="text" placeholder="$0.00">
					</div>
					<div class="large-4 columns">
						<a id="btnDiscountAmountRes" href="#" class="button postfix">Capture</a>
					</div>
                </div>
                <div class="row">
					<div class="small-12 columns">
						<p>Extras</p>
						<table id="tableDescuentosRes" class="large-12 columns">
							<thead class="colorCrema">
								<tr>
									<th class="cellGeneral">Gift Type</th>
									<th class="cellGeneral">Amount</th>
									<th class="cellGeneral">Delete</th>
								</tr>
							</thead>
							<tbody id="packSeleccionadosRes">
								<tr><td colspan="10" ></td></tr>
							</tbody>
						</table>
					</div>
				</div>
                <div class="row">
                    <div class="small-6 columns">
                        <label>Amount Transferred</label>
                        <input id="amountTransferRes" class="round general" type="text" placeholder="$0.00">
                    </div>
                    <div class="small-6 columns">
                        <label>Balance financed</label>
                        <input id="financeBalanceRes" class="round general" type="text" placeholder="$0.00">
                    </div>
                </div>
            </div>
            <!-- <div data-abide-error class="alert callout" style="display: none;">
                <p><i class="fi-alert"></i> please fill required fields (red).</p>
            </div> -->
        </form>
    </div>
</div>