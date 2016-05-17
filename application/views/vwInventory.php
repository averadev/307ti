
<div class="row section" id="section-InvDetailed">
	<div class="large-12 columns fiter-section">
		<div class="box" id="boxInvDetailedSearch" >
			<!-- header search -->
			<div class="box-header pr-color">
				<div class="pull-right box-tools">
					<span id="minusPeople" class="box-btn" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</span>
				</div>
				<h3 class="box-title">
					<span>Inventary Search</span>
				</h3>
			</div>
			<!-- body search-->
			<div class="box-body box-filter" style="display: block;">
				<!--filter-->
				<div class="row">
					<fieldset class="large-12 columns" id="alertInventaryUnit" style="display:none">
							<div class="callout small alert">
								<p>Select a unit, please.</p>
							</div>
					</fieldset>
					<!-- text Field date and select -->
					<div class="small-12 medium-12 large-12 columns">
						<fieldset class="large-12 columns fieldsetFilter">
							<legend class="legendSearch">Choose the type search</legend>
							<!-- Type of Availability -->
							<div class="rdoField">
								<input type="radio" name="SearchInventary" class="RadioSearchInventary" value="detailedAvailability" id="RadioDetailedAvailability" checked >
								<label for="RadioDetailedAvailability" >Detailed Availability</label>
							</div>
							<!-- Type of Availability -->
							<div class="rdoField">
								<input type="radio" name="SearchInventary" class="RadioSearchInventary" value="roomsControl" id="RadioRoomsControl">
								<label for="RadioRoomsControl">Rooms Control</label>
							</div>
						</fieldset>
					</div>
					<div class="small-12 medium-12 large-12 columns">
						<fieldset class="small-12 medium-12 large-12 columns fieldsetFilter filterDetailedAvailability">
							<legend class="legendSearch">Choose the availability</legend>
							<!-- Type of Availability -->
							<div class="rdoField">
								<input type="radio" name="InvTypeAvailability" class="RadioSearchInv" value="Availability" id="RadioInvAvailability" checked >
								<label for="RadioInvAvailability" >Availability </label>
							</div>
							<!-- Type of Availability -->
							<div class="rdoField">
								<input type="radio" name="InvTypeAvailability" class="RadioSearchInv" value="Occupancy" id="RadioInvOccupancy">
								<label for="RadioInvOccupancy">Occupancy </label>
							</div>
						</fieldset>
					</div>
					<div class="small-12 medium-12 large-12 columns">
						<fieldset class="small-12 medium-12 large-12 columns fieldsetFilter filterDetailedAvailability">
							<legend class="legendSearch">Choose the filters</legend>
							<!-- Include Non Deducted -->
							<div class="rdoField">
								<input type="checkbox" id="CheckInvNonDeducted" class="CheckSearchInv" value="Non Deducted">
								<label for="CheckInvNonDeducted">Include Non Deducted</label>
							</div>
							<!-- Include Overbooking -->
							<div class="rdoField">
								<input type="checkbox" id="CheckInvOverbooking" class="CheckSearchInv" value="Overbooking">
								<label for="CheckInvOverbooking">Include Overbooking</label>
							</div>
							<!-- Include OOO  -->
							<div class="rdoField">
								<input type="checkbox" id="CheckInvOOO" class="CheckSearchInv" value="OOO">
								<label for="CheckInvOOO">Include OOO</label>
							</div>
						</fieldset>
					</div>
					<div class="small-12 medium-12 large-12 columns">
						<fieldset class="large-12 columns fieldsetFilter">
							<legend class="legendSearch">Enter the filter</legend>
							<div class="row">
								<div class="small-10 large-3 columns">
									<input type="text" id="textInvStartDate" class="txtSearch" placeholder="Enter a date" >
								</div>
								<!-- Tipo de Habitación -->
								<div class="small-12 large-3 columns filterDetailedAvailability">
									<div class="caja" >
										<select id="textInvFloorPlan" class="comboBoxInvDetailed selectSearch input-group-field round">
											<option value="0">select a Floor Plan</option>
											<?php
											foreach($floorPlan as $item){
											?>
												<option value="<?php echo $item->pkFloorPlanID; ?>" code="<?php echo $item->FloorPlanCode; ?>"><?php echo $item->		FloorPlanDesc; ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								<!-- Propiedad -->
								<div class="small-12 large-3 columns">
									<div class="caja" >
										<select id="textInvProperty" class="comboBoxInvDetailed selectSearch input-group-field round">
											<option value="0">select a Property</option>
											<?php
											foreach($property as $item){
											?>
												<option value="<?php //echo $item->pkPropertyId; ?>" code="<?php echo $item->PropertyCode; ?>"><?php echo $item->PropertyName; ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								<div class="small-12 large-3 columns">
									<a id="btnInvSearch" class="btn btn-primary btn-Search">
										<div class="label">Buscar</div>
										<img src="<?php echo base_url().IMG; ?>common/BUSCAR.png"/>
									</a>
									<a id="btnInvCleanSearch" class="btn btn-primary spanSelect">
										<div class="label">Limpiar</div>
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
	
	<div class="large-12 columns">
		<div class="box">
			<div class="box-header pr-color">
				<div class="pull-right box-tools">
				</div>
				<h3 class="box-title">
					<span>Inventory found</span>
				</h3>
			</div>
			<div class="box-body" id="section-table-InvDetailed" style="display: block;">
				<div class="table" >
					<div class="" id="divTableInvDetailed">
						<table id="tableInvDetailed" style="width:100%;">
							<thead id="headInvDetailed">
							</thead>
							<tbody id="bodyInvDetailed">
		
							</tbody>
						</table>
					</div>
				</div>
				<div class="pagina" >
					<!--<div class="pages">
						<div class="pagination" id="paginationInv">
							<a href="#" class="first" data-action="first">&laquo;</a>
							<a href="#" class="previous" data-action="previous">&lsaquo;</a>
							<input type="text" class="general" readonly="readonly" />
							<a href="#" class="next" data-action="next">&rsaquo;</a>
							<a href="#" class="last" data-action="last">&raquo;</a>
						</div>
						<input type="hidden" id="paginationPeople" value="true" />
					</div>-->
				</div>
			</div>
		</div>
	</div>

</div>

<script type="text/javascript" src="<?php echo base_url().JS; ?>inventory.js"></script>
