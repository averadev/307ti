<div class="row section" id="section-reservations">
	<div class="large-12 columns">
		<div class="box" relation-attr="box-reservations-relation">
			<div class="box-header pr-color">
				<div class="pull-right box-tools">
					<span class="box-btn" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</span>
				</div>
				<h3 class="box-title">
               		<span>Reservations Search</span>
               	</h3>
				<a data-widget="newReservation" id="newReservation" class="btn btn-new">
					<div class="label">New</div>
					<img src="<?php echo base_url().IMG; ?>common/more.png"/>
				</a>
			</div>
			<div class="box-body box-filter">
				<div class="row">
					<div class="small-12 medium-12 large-12 columns">
						<fieldset class="large-12 columns fieldsetFilter">
							<legend class="legendSearch">Choose a filter</legend>
							<div class="rdoField">
								<input type="radio" name="filtro_reservations" value="personaIdRes" id="personaIdRes" required>
								<label for="personaIdRes">People ID</label>
							</div>
							<div class="rdoField">
								<input checked type="radio" name="filtro_reservations" value="nombreRes" id="nombreRes">
								<label for="nombreRes">Name</label>
							</div>
							<div class="rdoField">
								<input type="radio" name="filtro_reservations" value="apellidoRes" id="apellidoRes">
								<label for="apellidoRes">Last name</label>
							</div>
							<div class="rdoField">
								<input type="radio" name="filtro_reservations" value="confirCodeRes" id="confirCodeRes">
								<label for="confirCodeRes">Confirmation Code</label>
							</div>
							<div class="rdoField">
								<input type="radio" name="filtro_reservations" value="folioRes" id="folioRes">
								<label for="folioRes">Folio</label>
							</div>
						</fieldset>
					</div>
					
					<!--<div class="small-12 medium-12 large-12 columns">
						<fieldset class="large-12 columns fieldsetFilter">
						
							<div class="rdoField">
								<input type="checkbox" id="advancedSearchRes" class="checkFilter">
								<label for="advancedSearchRes">Advanced search</label>
							</div>
							<div class="filtersAdvanced" id="advancedRes" style="display:none;">
								<div class="rdoField">
									<input type="radio" name="filtro_reservations" value="codEmpleadoRes" id="codEmpleadoRes" required>
									<label for="codEmpleadoRes">Employee code</label>
								</div>
								<div class="rdoField">
									<input type="radio" name="filtro_reservations" value="unidadRes" id="unidadRes">
									<label for="unidadRes">Unit ID</label>
								</div>
								<div class="rdoField">
									<input type="radio" name="filtro_reservations" value="emailRes" id="emailRes" />
									<label for="emailRes">Email</label>
								</div>
								
							</div>
						</fieldset>
					</div>-->
					
					<div class="small-12 medium-12 large-12 columns">
						<fieldset class="large-12 columns fieldsetFilter">
							<div class="row">
								<div class="medium-3 columns">
									<label id="alertDepartureFront" class="text-left">Arrivate Date
										<div class="input-group date" >
											<span  class="input-group-label prefix"><i class="fa fa-calendar"></i></span>
											<input type="text" id="startDateRes" class="txtSearch input-group-field roundRight" readonly />
										</div>
									</label>
								</div>
								<div class="medium-3 columns">
									<label id="alertDepartureFront" class="text-left">Depature Date
										<div class="input-group date" >
											<span  class="input-group-label prefix"><i class="fa fa-calendar"></i></span>
											<input type="text" id="endDateRes" class="txtSearch input-group-field roundRight" readonly />
										</div>
									</label>
								</div>
								
								<!-- Occ type Group -->
								<div class="small-12 large-3 columns">
									<label id="alertTypeGroupRes" for="OccTypeGroupRes" class="text-left">Occ Type Group
										<div class="caja" >
											<select id="OccTypeGroupRes" class="txtSearch input-group-field round">
												<option value="">choose an option</option>
												<?php
												foreach($occTypeGroup as $item){
													?>
													<option value="<?php echo $item->ID; ?>"><?php echo $item->OccTypeGroupDesc; ?></option>
													<?php
												}
												?>
											</select>
										</div>
									</label>
								</div>
								<!-- Past Due Days -->
								<div class="small-12 large-3 columns">
									<label id="alertOccTypeRes" for="OccTypeRes" class="text-left">Occ type
										<div class="caja" >
											<select id="OccTypeRes" class="txtSearch input-group-field round">
												<option value="">choose an option</option>
											</select>
										</div>
									</label>
								</div>
								
							</div>
						</fieldset>
					</div>
					
					<div class="small-12 medium-12 large-12 columns">
						<fieldset class="large-12 columns fieldsetFilter">
							<div class="row">
								<!-- Status -->
								<div class="small-12 large-3 columns">
									<label id="alertStatusRes" for="statusRes" class="text-left">Status
										<div class="caja" >
											<select id="statusRes" class="txtSearch input-group-field round">
												<option value="">choose an option</option>
												<?php
												foreach($status as $item){
													?>
													<option value="<?php echo $item->ID; ?>"><?php echo $item->StatusDesc; ?></option>
													<?php
												}
												?>
											</select>
										</div>
									</label>
								</div>
								<!-- CrBy -->
								<div class="small-12 large-3 columns">
									<label id="alertCreateByRes" for="createByRes" class="text-left">Creation by
										<input id="createByRes" type="text" class="round" placeholder="Creation by" name="search"  required>
									</label>
								</div>
								<!-- CrDt  -->
								<div class="medium-3 columns">
									<label id="alertCreateDtRes" class="text-left">Creation date
										<div class="input-group date" >
											<span  class="input-group-label prefix"><i class="fa fa-calendar"></i></span>
											<input type="text" id="createDtRes" class="txtSearch input-group-field roundRight" readonly />
										</div>
									</label>
								</div>
								<div class="medium-3 columns">
									<label id="alertDepartureFront" class="text-left">Enter the filter
									<input id="stringRes" type="text" class="round" placeholder="Search Field" name="search"  required>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="small-12 medium-12 large-12 columns">
						<fieldset class="large-12 columns fieldsetFilter">
							<div class="row">
								<div class="medium-12 columns">
									<a id="btnfindRes" class="btn btn-primary btn-Search">
										<div class="label">Search</div>
										<img src="<?php echo base_url().IMG; ?>common/BUSCAR.png"/>
									</a>
									<a id="btnCleanWordRes" class="btn btn-primary spanSelect">
										<div class="label">Clean</div>
										<img src="<?php echo base_url().IMG; ?>common/BORRAR2.png"/>
									</a>
								</div>
							</div>
						</fieldset>
					</div>
				</div>	
			</div>
		</div>
	</div>



	<div class="large-12 columns" id="box-reservations-relation">
		<div class="box">
			<div class="box-header pr-color">
				<div class="pull-right box-tools">
               </div>
               <h3 class="box-title">
               	<span>Reservations</span>
               </h3>
			</div>
			<div class="box-body" id="table-reservations" style="display: block;">
				<div class="table" >
					<table id="reservationsTable" class="cell-border" style="width:100%;">
						<!--<thead>
						</thead>
						<tbody>
						</tbody>-->
						<thead id="reservationsthead">
						</thead>
						<tbody id="reservationstbody"></tbody>
					</table>
				</div>
				<div class="pagina" >
					<div class="pages">
					<span id="NR"></span>
						<div class="pagination" id="paginationReservation">
							<a href="#" class="first" data-action="first">&laquo;</a>
							<a href="#" class="previous" data-action="previous">&lsaquo;</a>
							<input type="text" class="general" readonly="readonly" />
							<a href="#" class="next" data-action="next">&rsaquo;</a>
							<a href="#" class="last" data-action="last">&raquo;</a>
						</div>
						<input type="hidden" id="paginationReservation2" value="true" />
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>


<div id="dialog-Reservations"  title="Reservation > Create Reservation" style="display: none;"></div>
<div id="dialog-Edit-Reservation" title="Reservation > Edit Reservation" style="display: none;"></div>
<div id="dialog-tourID" title="Tour ID" style="display: none;"></div>
<div id="dialog-PeopleRes" title="Reservation > Create Reservation > Add People" style="display: none;"></div>
<div id="dialog-UnidadesRes" title="Reservation > Create Reservation > Add Units" style="display: none;"></div>
<div id="dialog-WeeksRes" title="Weeks" style="display: none;"></div>
<div id="dialog-Pack" title="Pack Reference" style="display: none;"></div>
<div id="dialog-DownpaymentRes" title="Downpayment" style="display: none;"></div>
<div id="dialog-ScheduledPayments" title="Scheduled Payments" style="display: none;"></div>
<div id="dialog-DiscountAmount" title="Discount Amount" style="display: none;"></div>
<div id="dialog-FinanciamientoRes" title="Financing Terms" style="display: none;"></div>
<div id="dialog-SellersRes" title="Set Sellers" style="display: none;"></div>
<div id="dialog-ProvisionesRes" title="Add Provisions" style="display: none;"></div>
<div id="dialog-NotasRes" title="Add Notes" style="display: none;"></div>
<div id="dialog-accountsRes"  title="Accounts" style="display: none;"></div>
<div id="dialog-newFileRes"  title="New File" style="display: none;"></div>
<div id="dialog-CreditLimit"  title="Credit Limit" style="display: none;"></div>
<div id="dialog-LinkAcc"  title="Link Account" style="display: none;"></div>
<div id="dialog-CreditCardASR"  title="Card Associated" style="display: none;"></div>
<div id="dialog-StatusRes"  title="Status" style="display: none;"></div>
<div id="dialog-NewOccRes"  title="New Night" style="display: none;"></div>
<div id="dialog-ChangeUnitRes"  title="Change Unit" style="display: none;"></div>
<script type="text/javascript" src="<?php echo base_url().JS; ?>reservation.js"></script>