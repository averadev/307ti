
<div class="row fiter-section" id="section-inventory">
    <div class="section-bar">Search Options<div class="collapseFilter"></div></div>
	<!--<div class="section-bar" id="newUser">New person</div>-->
    <div class="medium-12 columns">
        <div class="row filter-fields">
			<!-- primera columna -->
			<div class="large-12 columns">
				<div class="row">
					<!-- fecha -->
					<div class="small-12 large-3 columns">
						<label id="alertInvStartDate" for="textInvStartDate" class="text-left">Start Date
							<input type="text" id="textInvStartDate" class="round general" >
						</label>
					</div>
					<!-- Tipo de Habitación -->
					<div class="small-12 large-3 columns">
						<label id="alertInvFloorPlan" for="textInvFloorPlan" class="text-left">Floor Plan
							<select id="textInvFloorPlan" class="round comboBoxInvDetailed">
								<option value="0">select a Floor Plan</option>
								<?php
								foreach($floorPlan as $item){
								?>
									<option value="<?php echo $item->pkFloorPlanID; ?>" code="<?php echo $item->FloorPlanCode; ?>"><?php echo $item->FloorPlanDesc; ?></option>
								<?php
								}
								?>
							</select>
						</label>
					</div>
					<!-- Propiedad -->
					<div class="small-12 large-3 columns">
						<label id="alertInvProperty" for="textInvProperty" class="text-left">Property 
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
						</label>
					</div>
					<div class="small-12 large-3 columns">
						&nbsp;
					</div>
				</div>
			</div>
			<!-- primera columna -->
			<div class="large-3 columns">
				<div class="row">
					<!-- Type of Availability -->
					<div class="large-12 columns">
						<input type="radio" name="InvTypeAvailability" class="RadioSearchInv" value="Availability" id="RadioInvAvailability" checked ><label for="RadioInvAvailability" >Availability </label>
					</div>
					<!-- Type of Availability -->
					<div class="large-12 columns">
						<input type="radio" name="InvTypeAvailability" class="RadioSearchInv" value="Occupancy" id="RadioInvOccupancy"><label for="RadioInvOccupancy">Occupancy </label>
					</div>
					
				</div>
			</div>
			<!-- primera columna -->
			<div class="large-3 columns">
				<div class="row">
					<!-- Include Non Deducted -->
					<div class="large-12 columns">
						<input type="checkbox" id="CheckInvNonDeducted" class="CheckSearchInv" value="Non Deducted">
						<label for="CheckInvNonDeducted">Include Non Deducted</label>
					</div>
					<!-- Include Overbooking -->
					<div class="large-12 columns">
						<input type="checkbox" id="CheckInvOverbooking" class="CheckSearchInv" value="Overbooking">
						<label for="CheckInvOverbooking">Include Overbooking</label>
					</div>
				</div>
			</div>
			<!-- primera columna -->
			<div class="large-3 columns">
				<div class="row">
					<!-- Include OOO  -->
					<div class="large-12 columns">
						<input type="checkbox" id="CheckInvOOO" class="CheckSearchInv" value="OOO">
						<label for="CheckInvOOO">Include OOO</label>
					</div>
				</div>
			</div>
			<!-- primera columna -->
			<div class="large-3 columns">
				<div class="row">
					<div class="large-12 columns end rowBtnSearch">
						<div class="small button-group radius rdoField">
							<a id="btnInvSearch" class="button btnSearch">Search</a>
							<a id="btnInvCleanSearch" class="button btnSearch">Clean</a>
						</div>
					</div>
				</div>
			</div>
        </div>
        <!--<div class="row">
            <div class="large-12 columns rowSearch">
              <input type="text" id="txtSearch" class="txtSearch" placeholder="Enter a search parameter" />
            </div>
			<div class="large-6 columns end rowBtnSearch">
				<div class="small button-group radius groupBtnSearch">
					<a id="btnSearch" class="button btnSearch">Search</a>
					<a id="btnCleanSearch" class="button btnSearch">Clean</a>
				</div>
			</div>
        </div>-->
    </div>
    <div class="medium-2 columns">&nbsp;</div>
</div>

<div class="row pagination-section">
    <div class="medium-2 columns section-bar"><span>Results</span></div>
    <div class="pages">
		<div class="pagination" id="paginationInv">
			<a href="#" class="first" data-action="first">&laquo;</a>
			<a href="#" class="previous" data-action="previous">&lsaquo;</a>
			<input type="text" readonly="readonly" />
			<a href="#" class="next" data-action="next">&rsaquo;</a>
			<a href="#" class="last" data-action="last">&raquo;</a>
		</div>
		<input type="hidden" id="paginationPeople" value="true" />
    </div>
	
</div>

<div class="row table-section" >
	<div class="large-12 columns table" >
		<div id="divTableInvDetailed">
			<table id="tableInvDetailed" class="display" cellspacing="0" width="100%">
				<thead id="tableHeadnventario">
					<!--<tr>
						<th class="" >Date</th>
						<th class="" >Total</th>
						<th class="" >RVK</th>
						<th class="" >RVD</th>
						<th class="" >JRK</th>
						<th class="" >GVD</th>
						<th class="" >GVK</th>
						<th class="" >OVK</th>
						<th class="" >OVD</th>
						<th class="" >CNK</th>
						<th class="" >F1K</th>
						<th class="" >F2D</th>
					</tr>-->
				</thead>
				<tbody id="tableBodynventario">
		
				</tbody>
			</table>
		</div>
	</div>
	<!--<button id="downloadButton">Start Download</button>-->
</div>

<script type="text/javascript" src="<?php echo base_url().JS; ?>inventory.js"></script>
