
<div class="row section" id="section-frontDesk">
	<div class="large-12 columns fiter-section">
		<div class="box" id="boxInvDetailedSearch" relation-attr="box-frontDesk-relation" >
			<!-- header search -->
			<div class="box-header pr-color">
				<div class="pull-right box-tools">
					<span id="minusPeople" class="box-btn" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</span>
				</div>
				<h3 class="box-title">
					<span>FrontDesk Search</span>
				</h3>
				<a data-widget="newFontDesk" id="newFontDesk" class="btn btn-new">
					<div class="label">Nuevo</div>
					<img src="<?php echo base_url().IMG; ?>common/more.png"/>
				</a>
			</div>
			<!-- body search-->
			<div class="box-body box-filter" style="display: block;">
				<!-- module -->
				<div class="row">
					<div class="small-12 medium-12 large-12 columns">
						<fieldset class="large-12 columns fieldsetFilter" Id="sectionFilter" >
							<legend class="legendSearch">Choose the type search</legend>
							<!-- Type of Availability -->
							<div class="rdoField">
								<input type="radio" name="SearchFrontDesk" class="SectionFrontDesk" value="section1" id="FrontDeskLookUp" checked >
								<label for="FrontDeskLookUp" >Front Desk Look Up</label>
							</div>
							<!-- Type of Availability -->
							<div class="rdoField">
								<input type="radio" name="SearchFrontDesk" class="SectionFrontDesk" value="section2" id="HousekeepingJobConfig">
								<label for="HousekeepingJobConfig">Housekeeping Job Config</label>
							</div>
							<div class="rdoField">
								<input type="radio" name="SearchFrontDesk" class="SectionFrontDesk" value="section3" id="HousekeepingConfiguration">
								<label for="HousekeepingConfiguration">Housekeeping Configuration</label>
							</div>
							<div class="rdoField">
								<input type="radio" name="SearchFrontDesk" class="SectionFrontDesk" value="section4" id="HousekeepingLookup">
								<label for="HousekeepingLookup">Housekeeping Lookup</label>
							</div>
							<div class="rdoField">
								<input type="radio" name="SearchFrontDesk" class="SectionFrontDesk" value="section5" id="FrontDeskReport">
								<label for="FrontDeskReport">Report</label>
							</div>
						</fieldset>
					</div>
				</div>
				<!--filter-->
				<div class="row sectionFrontDesk section1" style="display:none;">
					<div class="small-12 medium-8 large-12 columns"> 
						<fieldset class="large-12 columns fieldsetFilter">
							<legend class="legendSearch">Choose the filters</legend>
							<label>Status</label>
							<?php
							foreach($status as $item){
								?>
								<div class="rdoField">
									<input name="FilterFrontDesk" type="checkbox" id="<?php echo "check" . $item->StatusCode; ?>" class="checkFilterFrontDesk" value="<?php echo $item->pkStatusId; ?>">
									<label for="<?php echo "check" . $item->StatusCode; ?>"><?php echo $item->StatusDesc; ?></label>
								</div>
								<!--<option value="<?php echo $item->pkStatusId; ?>"><?php echo $item->StatusDesc; ?></option>-->
								<?php
								}
							?>
						</fieldset>
					</div>
					<div class="small-12 medium-12 large-12 columns">
						<!-- text Field dates -->
						<fieldset class="large-12 columns fieldsetFilter">
							
							<div class="row">
								<!-- Arrival Date -->
								<div class="small-12 large-3 columns">
									<label id="alertArrivalFront" class="text-left">Arrival Date
										<div class="input-group date" id="frontArrivalDate" >
											<span  class="input-group-label prefix"><i class="fa fa-calendar"></i></span>
											<input type="text" id="dateArrivalFront" class="txtSearch input-group-field roundRight" readonly/>
										</div>
									</label>
								</div>
								<!-- Departure Date -->
								<div class="small-12 large-3 columns">
									<label id="alertDepartureFront" class="text-left">Departure Date
										<div class="input-group date" >
											<span  class="input-group-label prefix"><i class="fa fa-calendar"></i></span>
											<input type="text" id="dateDepartureFront" class="txtSearch input-group-field roundRight" readonly/>
										</div>
									</label>
								</div>
								<!-- Year -->
								<div class="small-12 large-3 columns">
									<label id="alertYearFront" class="text-left">Year
										<div class="input-group date" id="" >
											<span  class="input-group-label prefix"><i class="fa fa-calendar"></i></span>
											<input type="text" id="dateYearFront" class="txtSearch input-group-field roundRight" readonly/>
										</div>
									</label>
								</div>
								<!-- Interval -->
								<div class="small-12 large-3 columns">
									<label id="alertIntervalFront" class="text-left">Interval
										<div class="caja" >
											<select id="textIntervalFront" class="txtSearch input-group-field round">
												<option value="">Select a interval</option>
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
								<div class="small-12 large-3 columns">
									<label id="alertUnitCodeFront" class="text-left">Unit Code 
										<input id="textUnitCodeFront" type="text" class="txtSearch round general">
									</label>
								</div>
								<div class="small-12 large-3 columns">
									<label id="alertConfirmationFront" class="text-left">Confirmation Code 
										<input id="textConfirmationFront" type="text" class="txtSearch round general">
									</label>
								</div>
								<div class="small-12 large-3 columns">
									<label id="alertViewFront" class="text-left">View 
										<div class="caja" >
											<select id="textViewFront" class="input-group-field round">
												<option value="">Select a view</option>
												<?php
												foreach($view as $item){
													?>
													<option value="<?php echo $item->pkViewId; ?>"><?php echo $item->ViewDesc; ?></option>
													<?php
												}
												?>
											</select>
										</div>
									</label>
								</div>
								<div class="small-12 large-3 columns" style="padding-top:25px;">
									<a id="btnSearchFrontDesk" class="btn btn-primary btn-Search searchFD">
										<div class="label">Buscar</div>
										<img src="<?php echo base_url().IMG; ?>common/BUSCAR.png"/>
									</a>
									<a id="btnCleanFrontDesk" class="btn btn-primary spanSelect">
										<div class="label">Limpiar</div>
										<img src="<?php echo base_url().IMG; ?>common/BORRAR2.png"/>
									</a>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
				<!-- Housekeeping Job Config -->
				<div class="row sectionFrontDesk section2" style="display:none;">
				</div>
				
				<!-- Housekeeping Configuration -->
				<div class="row sectionFrontDesk section3">
					<div class="small-12 medium-8 large-12 columns"> 
						<fieldset class="large-12 columns fieldsetFilter">
							<label>Status</label>
							<?php
							foreach($HKStatus as $item){
								?>
								<div class="rdoField">
									<input name="FilterHKConfiguration" type="checkbox" id="<?php echo "hk" . $item->HKStatusCode; ?>" class="checkFilterFrontDesk" value="<?php echo $item->pkHKStatusId; ?>">
									<label for="<?php echo "hk" . $item->HKStatusCode; ?>"><?php echo $item->HKStatusDesc; ?></label>
								</div>
								<?php
								}
							?>
						</fieldset>
					</div>
					<div class="small-12 medium-12 large-12 columns">
						<!-- text Field dates -->
						<fieldset class="large-12 columns fieldsetFilter">
							<div class="row">
								<!-- Unit -->
								<div class="small-12 large-3 columns">
									<label id="alertUnitHKConfig" class="text-left">Unit Code 
										<input id="textUnitHKConfig" type="text" class="txtSearch round general">
									</label>
								</div>
								<div class="small-12 large-3 columns">
									<label id="alertFloorPlanHKConfig" class="text-left">Floor plan 
										<!--<div class="caja" >-->
										<!--class="input-group-field round"-->
											<select id="textFloorPlanHKConfig" class="input-group-field round"  multiple="multiple">
												<!--<option value="">Select a view</option>-->
												<?php
												foreach($floorPlan as $item){
													?>
													<option value="<?php echo $item->pkFloorPlanID; ?>"><?php echo $item->FloorPlanDesc; ?></option>
													<?php
												}
												?>
											</select>
										<!--</div>-->
									</label>
								</div>
								<!-- Date -->
								<div class="small-12 large-3 columns">
									<label id="alertDateHKConfig" class="text-left">Date
										<div class="input-group date" >
											<span  class="input-group-label prefix"><i class="fa fa-calendar"></i></span>
											<input type="text" id="dateHKConfig" class="txtSearch input-group-field roundRight" readonly/>
										</div>
									</label>
								</div>
								<div class="small-12 large-3 columns">
									<label id="alertSectionHKConfig" class="text-left">Section 
										<input id="textSectionHKConfig" type="text" class="txtSearch round general">
									</label>
								</div>
							</div>
						</fieldset>
						<fieldset class="large-12 columns fieldsetFilter">
							<div class="row">
								<div class="small-12 large-3 columns">
									<label id="alertMaidHKConfig" class="text-left">Maid 
										<input id="textMaidHKConfig" type="text" class="txtSearch round general">
									</label>
								</div>
								<div class="small-12 large-3 columns">
									<label id="alertSupervisorHKConfig" class="text-left">Supervisor 
										<input id="textSupervisorHKConfig" type="text" class="txtSearch round general">
									</label>
								</div>
								<div class="small-12 large-3 columns" style="padding-top:25px;">
									<a id="btnSearchHKConfig" class="btn btn-primary btn-Search searchFD">
										<div class="label">Search</div>
										<img src="<?php echo base_url().IMG; ?>common/BUSCAR.png"/>
									</a>
									<a id="btnCleanHKConfig" class="btn btn-primary spanSelect">
										<div class="label">Clean</div>
										<img src="<?php echo base_url().IMG; ?>common/BORRAR2.png"/>
									</a>
								</div>
								<div class="small-12 large-3 columns">&nbsp;</div>
							</div>
							
						</fieldset>
					</div>
					
				</div>
				<!-- House Keeping Look Up -->
				<div class="row sectionFrontDesk section4" style="display:none;">
					<div class="small-12 medium-8 large-12 columns"> 
						<fieldset class="large-12 columns fieldsetFilter">
							<label>Status</label>
							<?php
							foreach($HKStatus as $item){
								?>
								<div class="rdoField">
									<input name="statusHKLookUp" type="checkbox" id="<?php echo "hklu" . $item->HKStatusCode; ?>" class="checkFilterFrontDesk" value="<?php echo $item->pkHKStatusId; ?>">
									<label for="<?php echo "hklu" . $item->HKStatusCode; ?>"><?php echo $item->HKStatusDesc; ?></label>
								</div>
								<?php
							}
							foreach($HKStatus as $item){
								?>
								<!---<div class="rdoField">
									<input name="FilterHKConfiguration" type="checkbox" id="<?php echo "hk" . $item->HKStatusCode; ?>" class="checkFilterFrontDesk" value="<?php echo $item->pkHKStatusId; ?>">
									<label for="<?php echo "hk" . $item->HKStatusCode; ?>"><?php echo $item->HKStatusCode; ?></label>
								</div>-->
								<?php
							}
							?>
						</fieldset>
					</div>
					<div class="small-12 medium-12 large-12 columns">
						<!-- text Field dates -->
						<fieldset class="large-12 columns fieldsetFilter">
							<div class="row">
								<!-- Unit -->
								<div class="small-12 large-3 columns">
									<label id="alertDateHKLookUp" class="text-left">Date
										<input type="text" id="dateHKLookUp" class="txtSearch" placeholder="Enter a date" >
									</label>
								</div>
								<div class="small-12 large-3 columns">
									<label id="alertIntervalFront" class="text-left">Interval
										<div class="caja" >
											<select id="ServiceTypeLookUp" class="txtSearch input-group-field round">
												<option value="0">Select a Service Type</option>
												<?php
												foreach($serviceType as $item){
													?>
													<option value="<?php echo $item->pkHkServiceTypeId; ?>"><?php echo $item->HkServiceTypeDesc; ?></option>
													<?php
												}
												?>
											</select>
										</div>
									</label>
								</div>
								<div class="small-12 large-6 columns" style="padding-top:25px;">
									<a id="btnHKREPORT" class="btn btn-primary btn-Search">
										<div class="label">HK REPORT</div>
										<img src="<?php echo base_url().IMG; ?>common/report.png"/>
									</a>
									<a id="btnChgStatus" class="btn btn-primary spanSelect">
										<div class="label">Chg Status</div>
										<img src="<?php echo base_url().IMG; ?>common/check.png"/>
									</a>
								</div>
								<!--<div class="small-12 large-3 columns">
									<label id="alertFloorPlanHKConfig" class="text-left">Floor plan 
											<select id="textFloorPlanHKConfig" class="input-group-field round"  multiple="multiple">
												<?php
												foreach($floorPlan as $item){
													?>
													<option value="<?php echo $item->pkFloorPlanID; ?>"><?php echo $item->FloorPlanDesc; ?></option>
													<?php
												}
												?>
											</select>
									</label>
								</div>-->
							</div>
						</fieldset>
						<fieldset class="large-12 columns fieldsetFilter">
							<div class="row" style="margin-bottom:0; padding-bottom:0;">
								<div class="small-12 large-6 columns" style="padding-top:5px;">
									<a id="btnSearchHKLookUp" class="btn btn-primary btn-Search searchFD">
										<div class="label">Search</div>
										<img src="<?php echo base_url().IMG; ?>common/BUSCAR.png"/>
									</a>
									<a id="btnCleanHKLookUp" class="btn btn-primary spanSelect">
										<div class="label">Clean</div>
										<img src="<?php echo base_url().IMG; ?>common/BORRAR2.png"/>
									</a>
								</div>
								<div class="small-12 large-3 columns">&nbsp;</div>
							</div>
						</fieldset>
					</div>
				</div>
				<!-- House Keeping Look Up -->
				<div class="row sectionFrontDesk section5" style="display:none;">
					<div class="small-12 medium-8 large-12 columns"> 
						<fieldset class="large-12 columns fieldsetFilter">
								
						</fieldset>
					</div>
					<div class="small-12 medium-12 large-12 columns">
						<!-- text Field dates -->
						<fieldset class="large-12 columns fieldsetFilter">
							<div class="row">
								<!-- Unit -->
								<div class="small-12 large-3 columns">
									<label id="" class="text-left">Date Arrival
										<div class="input-group date" id="frontArrivalDate" >
											<span  class="input-group-label prefix"><i class="fa fa-calendar"></i></span>
											<input type="text" id="dateArrivalReport" class="txtSearch input-group-field roundRight" placeholder="Enter a date" readonly />
										</div>
									</label>
								</div>
								<div class="small-12 large-3 columns">
									<label id="" class="text-left">Date Departure
										<div class="input-group date" id="frontArrivalDate" >
											<span  class="input-group-label prefix"><i class="fa fa-calendar"></i></span>
											<input type="text" id="dateDepartureReport" class="txtSearch input-group-field roundRight" placeholder="Enter a date" readonly />
										</div>
									</label>
								</div>
								<div class="small-12 large-6 columns" style="padding-top:30px;">
									<input name="checkReport" type="checkbox" id="reportBalance" class="checkReport">
									<label for="reportBalance">Balances</label>
								</div>
							</div>
						</fieldset>
						<fieldset class="large-12 columns fieldsetFilter">
							<div class="row" style="margin-bottom:0; padding-bottom:0;">
								<div class="small-12 large-6 columns" style="padding-top:5px;">
									<a id="btnSearchHKLookUp" class="btn btn-primary btn-Search searchFD">
										<div class="label">Search</div>
										<img src="<?php echo base_url().IMG; ?>common/BUSCAR.png"/>
									</a>
									<a id="btnCleanHKLookUp" class="btn btn-primary spanSelect">
										<div class="label">Clean</div>
										<img src="<?php echo base_url().IMG; ?>common/BORRAR2.png"/>
									</a>
									<a id="btnHKREPORT" class="btn btn-primary btn-Search">
										<div class="label">HK REPORT</div>
										<img src="<?php echo base_url().IMG; ?>common/report.png"/>
									</a>
								</div>
								<div class="small-12 large-3 columns">&nbsp;</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="large-12 columns" id="box-frontDesk-relation">
		<div class="box">
			<div class="box-header pr-color">
				<div class="pull-right box-tools">
				</div>
				<h3 class="box-title">
					<span>Reservations Relation</span>
				</h3>
			</div>
			<div class="box-body" id="table-frontDesk" style="display: block;">
				<div class="table">
					<div id="divTableFrontDesk" class="section1 tableSection">
						<table id="tableFrontDesk" class="ganttTable" style="width:100%; float:left;">
							<thead>
								<tr class="gHeaderYear">
									<th colspan="4" class="panelLeftHead last"></th>
								</tr>
								<tr class="gHeaderMonth">
									<th colspan="4" class="panelLeftHead last"></th>
								</tr>
								<tr class="gHeaderDay" id="day">
									<th class="panelLeftHead">
										Type
										<div class="orderField" attr-field="fpi.FloorPlanDesc">
											<span class="orderRow" attr-order="asc" ><i class="fa fa-caret-up"></i></span>
											<span class="orderRow" attr-order="desc"><i class="fa fa-caret-down"></i></span>
										</div>
									</th>
									<th class="panelLeftHead">
										Num
										<div class="orderField" attr-field="u.UnitCode">
											<span class="orderRow" attr-order="asc" ><i class="fa fa-caret-up"></i></span>
											<span class="orderRow" attr-order="desc"><i class="fa fa-caret-down"></i></span>
										</div>
									</th>
									<th class="panelLeftHead">
										status
										<div class="orderField" attr-field="hks.HKStatusDesc">
											<span class="orderRow" attr-order="asc" ><i class="fa fa-caret-up"></i></span>
											<span class="orderRow" attr-order="desc"><i class="fa fa-caret-down"></i></span>
										</div>
									</th>
									<th class="panelLeftHead last Tooltips">
										View
										<div class="orderField" attr-field="v.ViewDesc">
											<span class="orderRow" attr-order="asc" ><i class="fa fa-caret-up"></i></span>
											<span class="orderRow" attr-order="desc"><i class="fa fa-caret-down"></i></span>
										</div>
									</th>
								</tr>
							</thead>
							<tbody>
							
							</tbody>
						</table>
					</div>
					
					<div class="section3 tableSection" style="display:none;">
						<table id="tableHKConfiguration" style="width:100%">
							<thead>
								<tr>
									<th>pk</th>
									<th>unitCode</th>
									<th>FloorPlan</th>
									<th>MaidName</th>
									<th>MaidLName</th>
									<th>EmployeeCode</th>
									<th>SuperName</th>
									<th>SuperLName</th>
									<th>EmployeeCode</th>
									<th>Section</th>
									<th>Floor</th>
									<th>Building</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					
					<div class="section4 tableSection" style="display:none;">
						<table id="tableHKLookUp" style="width:100%">
							<thead>
								<tr>
									<th>pk</th>
									<th>unitCode</th>
									<th>FloorPlan</th>
									<th>MaidName</th>
									<th>MaidLName</th>
									<th>EmployeeCode</th>
									<th>SuperName</th>
									<th>SuperLName</th>
									<th>EmployeeCode</th>
									<th>Section</th>
									<th>Floor</th>
									<th>Building</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					
					<div class="section5 tableSection" style="display:none;">
						<table id="tableHKReport" style="width:100%">
							<thead>
								<tr>
									<th>pk</th>
									<th>unitCode</th>
									<th>FloorPlan</th>
									<th>MaidName</th>
									<th>MaidLName</th>
									<th>EmployeeCode</th>
									<th>SuperName</th>
									<th>SuperLName</th>
									<th>EmployeeCode</th>
									<th>Section</th>
									<th>Floor</th>
									<th>Building</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					
				</div>
				<div class="pagina" id="generalPage" style="display:none;" >
					<div class="pages">
						<div class="pagination" id="paginationHKConfig" >
							<a href="#" class="first" data-action="first">&laquo;</a>
							<a href="#" class="previous" data-action="previous">&lsaquo;</a>
							<input type="text" class="general" readonly="readonly" />
							<a href="#" class="next" data-action="next">&rsaquo;</a>
							<a href="#" class="last" data-action="last">&raquo;</a>
						</div>
						<div class="pagination" id="paginationHKLookUp" >
							<a href="#" class="first" data-action="first">&laquo;</a>
							<a href="#" class="previous" data-action="previous">&lsaquo;</a>
							<input type="text" class="general" readonly="readonly" />
							<a href="#" class="next" data-action="next">&rsaquo;</a>
							<a href="#" class="last" data-action="last">&raquo;</a>
						</div>
						<input type="hidden" id="paginationPeople" value="true" />
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>

<div id="dialog-Edit-Reservations" title="Summary Reservation" style="display: none;"></div>
<div id="dialog-HKConfig" title="HouseKeepingConfiguration " style="display: none;"></div>
<div id="dialog-people-hkConfig" title="people " style="display: none;"></div>
<div id="dialog-unit-hkConfig" title="unit " style="display: none;"></div>
<div id="dialog-edit-HKStatus" title="hk status" style="display: none;"></div>


<script type="text/javascript" src="<?php echo base_url().JS; ?>frontDesk.js"></script>
