
<div class="row section" id="section-InvDetailed">
	<div class="large-12 columns fiter-section">
		<div class="box" id="boxInvDetailedSearch" >
			<!-- header search -->
			<div class="box-header blue_divina">
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
			<div class="box-body" style="display: block;">
				<!--filter-->
				<div class="row">
					<!-- text Field date and select -->
					<div class="small-12 medium-12 large-12 columns">
						<fieldset class="large-12 columns">
							<legend>Choose the type search</legend>
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
						<fieldset class="large-12 columns" id="alertInventaryUnit" style="display:none">
							<div class="callout small alert">
								<p>Select a unit, please.</p>
							</div>
						</fieldset>
						<fieldset class="large-12 columns">
							<legend>Choose the date and unit</legend>
							<div class="small-12 large-5 columns">
								<div class="row collapse">
									<div class="small-10 large-10 columns">
											<input type="text" id="textInvStartDate" class="txtSearch" placeholder="Enter a date" >
									</div>
									<div class="small-1 large-1 columns">
										<a  id="btnInvSearch" class="button postfix"><i class="fa fa-search"></i></a>
									</div>
									<div class="small-1 large-1 columns">
										<a id="btnInvCleanSearch" class="button postfix"><i class="fa fa-trash"></i></a>
									</div>
								</div>
							</div>
							
							<!-- Tipo de Habitación -->
							
							
							<div class="small-12 large-3 columns filterDetailedAvailability">
									<select id="textInvFloorPlan" class="round comboBoxInvDetailed">
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
							<!-- Propiedad -->
							<div class="small-12 large-3 columns">
								<select id="textInvProperty" class="round comboBoxInvDetailed">
									<option value="0">select a Property</option>
									<?php
									foreach($property as $item){
									?>
										<option value="<?php echo $item->pkPropertyId; ?>" code="<?php echo $item->PropertyCode; ?>"><?php echo $item->PropertyName; ?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class="small-12 large-1 columns">&nbsp;</div>
						</fieldset>
					</div>
					<div class="small-12 medium-12 large-12 columns">
						<fieldset class="large-12 columns filterDetailedAvailability">
							<legend>Choose the availability</legend>
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
						<fieldset class=" small-12 large-12 columns filterDetailedAvailability">
							<legend>Choose the filters</legend>
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
				</div>
			</div>
		</div>
	</div>
	
	<div class="large-12 columns">
		<div class="box">
			<div class="box-header blue_divina">
				<div class="pull-right box-tools">
				</div>
				<h3 class="box-title">
					<span>Results</span>
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
