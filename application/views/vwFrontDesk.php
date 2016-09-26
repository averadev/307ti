
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
					<span>FrontDesk</span>
				</h3>
				<a data-widget="newContrat" id="newExchangeRate" class="btn btn-new" style="display:none;">
					<div class="label">New</div>
					<img src="<?php echo base_url().IMG; ?>common/more.png"/>
				</a>
			</div>
			<!-- body search-->
			<div class="box-body box-filter" style="display: block;">
				<!-- module -->
				<div class="row">
					<div class="small-12 medium-12 large-3 columns">
						<fieldset class="large-12 columns fieldsetFilter" Id="sectionFilter" >

							<legend class="legendSearch">Choose Search Type</legend>

							<!-- Type of Availability -->
							<select id="typeSearchFrontDesk" class="txtSearch input-group-field round">
								<option value="section1">Front Desk Look Up</option>
<!-- 								<option value="section2">Housekeeping Job Config</option> -->
								<option value="section3">Housekeeping Configuration</option>
								<option value="section4">Housekeeping Lookup</option>
								<option value="section6">Exchange Rate</option>
								<option value="section5">Report</option>
								<option value="section7">Audit Units</option>
								<option value="section8">Audit Transactions</option>
							</select>
						</fieldset>
					</div>
				</div>
				<!--filter-->
				<div class="row sectionFrontDesk section1">
					<!--<div class="small-12 medium-8 large-12 columns"> 
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
								<?php
								}
							?>
						</fieldset>
					</div>-->
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
											<input type="text" id="dateYearFront" box="textIntervalFront" class="txtSearch input-group-field roundRight" readonly/>
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
										<div class="label">Search</div>
										<img src="<?php echo base_url().IMG; ?>common/BUSCAR.png"/>
									</a>
									<a id="btnCleanFrontDesk" class="btn btn-primary spanSelect">
										<div class="label">Clean</div>
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
				<div class="row sectionFrontDesk section3" style="display:none;">
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
									<label id="alertIntervalFront" class="text-left">Service type
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
									<a id="btnHKLUREPORT" class="btn btn-primary btn-Search">
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
								<!--<div class="small-12 large-3 columns">
									<label id="" class="text-left">Date Departure
										<div class="input-group date" id="frontArrivalDate" >
											<span  class="input-group-label prefix"><i class="fa fa-calendar"></i></span>
											<input type="text" id="dateDepartureReport" class="txtSearch input-group-field roundRight" placeholder="Enter a date" readonly />
										</div>
									</label>
								</div>-->
								<div class="small-12 large-6 columns" style="padding-top:30px;">
									<input name="checkReport" type="checkbox" id="checkReport" class="checkReport">
									<label for="checkReport">Balances</label>
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
										<div class="label">Export</div>
										<img src="<?php echo base_url().IMG; ?>common/report.png"/>
									</a>
								</div>
								<div class="small-12 large-3 columns">&nbsp;</div>
							</div>
						</fieldset>
					</div>
				</div>
				
				<div class="row sectionFrontDesk section6" style="display:none;">
					<div class="small-12 medium-12 large-12 columns">
						<!-- text Field dates -->
						<fieldset class="large-12 columns fieldsetFilter">
							<div class="row">
								<!-- Arrival Date -->
								<div class="small-12 large-3 columns">
									<label id="alertArrivalFront" class="text-left"> Initial Date
										<div class="input-group date" id="frontArrivalDate" >
											<span  class="input-group-label prefix"><i class="fa fa-calendar"></i></span>
											<input type="text" id="dateArrivalExchange" class="txtSearch input-group-field roundRight" readonly/>
										</div>
									</label>
								</div>
								<!-- Departure Date -->
								<div class="small-12 large-3 columns">
									<label id="alertDepartureFront" class="text-left">End Date
										<div class="input-group date" >
											<span  class="input-group-label prefix"><i class="fa fa-calendar"></i></span>
											<input type="text" id="dateDepartureExchange" class="txtSearch input-group-field roundRight" readonly/>
										</div>
									</label>
								</div>
								<!-- Year -->
								<div class="small-12 large-3 columns">
									<label id="alertYearFront" class="text-left">Year
										<div class="input-group date" id="" >
											<span  class="input-group-label prefix"><i class="fa fa-calendar"></i></span>
											<input type="text" id="dateYearExchange" box="textIntervalExchange" class="txtSearch input-group-field roundRight" readonly/>
										</div>
									</label>
								</div>
								<!-- Interval -->
								<div class="small-12 large-3 columns">
									<label id="alertIntervalFront" class="text-left">Interval
										<div class="caja" >
											<select id="textIntervalExchange" class="txtSearch input-group-field round">
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
								<div class="small-12 large-6 columns end" style="padding-top:25px;">
									<a id="btnSearchFrontExchange" class="btn btn-primary btn-Search searchFD">
										<div class="label">Search</div>
										<img src="<?php echo base_url().IMG; ?>common/BUSCAR.png"/>
									</a>
									<a id="btnCleanFrontExchange" class="btn btn-primary spanSelect">
										<div class="label">Clean</div>
										<img src="<?php echo base_url().IMG; ?>common/BORRAR2.png"/>
									</a>
									<a id="btnNewFrontExchange" class="btn btn-primary spanSelect">
										<div class="label">New</div>
										<img src="<?php echo base_url().IMG; ?>common/more.png"/>
									</a>
								</div>
							</div>
						</fieldset>
					</div>
					
				</div>
				<div class="row sectionFrontDesk section7" style="display:none;">
					<div class="small-12 medium-12 large-12 columns">
						<!-- text Field dates -->
						<fieldset class="large-12 columns fieldsetFilter">
							<div class="row">
								<!-- Arrival Date -->
								<div class="small-12 large-3 columns">
									<label id="dateAuditLabel" class="text-left">Date
										<div class="input-group date">
											<span  class="input-group-label prefix"><i class="fa fa-calendar"></i></span>
											<input type="text" id="dateAudit" class="txtSearch input-group-field roundRight" readonly/>
										</div>
									</label>
								</div>
								<!-- Departure Date -->
								<div class="small-12 large-3 columns">
									<label id="unitAuditLabel" class="text-left">Unit
										<div class="input-group date" >
											<span  class="input-group-label prefix"><i class="fa fa-home"></i></span>
											<input type="text" id="unitAudit" class="txtSearch input-group-field roundRight"/>
										</div>
									</label>
								</div>
								<!-- Year -->
								<div class="small-12 large-3 columns">
									<label id="statusAuditLabel" class="text-left">Status
											<select  id="statusAudit"  class="input-group-field round"  multiple="multiple">
												<?php
												foreach($statusRes as $item){
													?>
													<option value="<?php echo $item->ID; ?>"><?php echo $item->StatusDesc; ?></option>
													<?php
												}
												?>
											</select>
									</label>
								</div>
								<!-- Interval -->
								<div class="small-12 large-3 columns">
									<label id="occTypeLabel" class="text-left">Occupancy Type Group
											<select id="occTypeAudit" class="input-group-field round"  multiple="multiple">
												<?php
												foreach($OccType as $item){
													?>
													<option value="<?php echo $item->ID; ?>"><?php echo $item->Description; ?></option>
													<?php
												}
												?>
											</select>
									</label>
								</div>
							</div>
						</fieldset>
					</div>
					
					<div class="small-12 medium-12 large-12 columns">
						<fieldset class="large-12 columns fieldsetFilter">
							<div class="row">
								<div class="small-12 large-12 columns end" style="padding-top:25px;">
									<a id="btnSearchAuditUnit" class="btn btn-primary btn-Search searchFD">
										<div class="label">Search</div>
										<img src="<?php echo base_url().IMG; ?>common/BUSCAR.png"/>
									</a>
									<a id="btnCleanAuditUnit" class="btn btn-primary spanSelect">
										<div class="label">Clean</div>
										<img src="<?php echo base_url().IMG; ?>common/BORRAR2.png"/>
									</a>
									<a id="btnAddTrxAuditUnit" class="btn btn-primary spanSelect">
										<div class="label">Add Transactions</div>
										<img src="<?php echo base_url().IMG; ?>common/more.png"/>
									</a>
									<a id="btnReporAuditUnit" class="btn btn-primary btn-Search">
										<div class="label">Export</div>
										<img src="<?php echo base_url().IMG; ?>common/report.png"/>
									</a>
								</div>
							</div>
						</fieldset>
					</div>
					
				</div>
				<div class="row sectionFrontDesk section8" style="display:none;">
					<div class="small-12 medium-12 large-12 columns">
						<!-- text Field dates -->
						<fieldset class="large-12 columns fieldsetFilter">
							<div class="row">
								<!-- Arrival Date -->
								<div class="small-12 large-3 columns">
									<label class="text-left">Date
										<div class="input-group date">
											<span  class="input-group-label prefix"><i class="fa fa-calendar"></i></span>
											<input type="text" id="dateAuditTRX" class="txtSearch input-group-field roundRight" readonly/>
										</div>
									</label>
								</div>
								<!-- Arrival Date -->
								<div class="small-12 large-3 columns">
									<label id="userTrxLabel" class="text-left">User
										<div class="input-group date" >
											<span  class="input-group-label prefix"><i class="fa fa-user"></i></span>
											<input type="text" id="userTrxAudit" class="txtSearch input-group-field roundRight"/>
										</div>
									</label>
								</div>
								<!-- Departure Date -->
								<div class="small-12 large-3 columns">
									<label id="trxAuditLabel" class="text-left">Trx Description
										<div class="input-group date" >
											<span  class="input-group-label prefix"><i class="fa fa-calendar"></i></span>
											<select  id="Transaction" class="txtSearch input-group-field roundRight">
											<option value="">Choose an option</option>
												<?php
												foreach($TrxTypes as $item){
													?>
													<option value="<?php echo $item->ID; ?>"><?php echo $item->TrxTypeDesc; ?></option>
													<?php
												}
												?>
											</select>
										</div>
									</label>
								</div>
								<!-- Year -->
								<div class="small-12 large-3 columns">
									<label id="alertYearFront" class="text-left">YnAudit
										<div class="input-group date" >
											<span  class="input-group-label prefix"><i class="fa fa-check-circle-o"></i></span>
											<select id="isAudited" class="txtSearch input-group-field round">
											<option value="">Choose an option</option>
											<option value="1">All</option>
											<option value="2">Audit</option>
											<option value="3">no Audit</option>
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
								<div class="small-12 large-6 columns end" style="padding-top:25px;">
									<a id="btnSearchAuditTransactions" class="btn btn-primary btn-Search searchFD">
										<div class="label">Search</div>
										<img src="<?php echo base_url().IMG; ?>common/BUSCAR.png"/>
									</a>
									<a id="btnCleanAuditTransactions" class="btn btn-primary spanSelect">
										<div class="label">Clean</div>
										<img src="<?php echo base_url().IMG; ?>common/BORRAR2.png"/>
									</a>
									<a id="btncloseDayAuditTransactions" class="btn btn-primary spanSelect">
										<div class="label">Close Day</div>
										<i class="fa fa-check-square"></i>
									</a>
									<a id="btnReporAuditTrx" class="btn btn-primary btn-Search">
										<div class="label">Export</div>
										<img src="<?php echo base_url().IMG; ?>common/report.png"/>
									</a>
								</div>
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
				<div class="table" id="FrontDeskRes">
					<div id="divTableFrontDesk" class="section1 tableSection">
						<table id="tableFrontDesk" class="ganttTable">
							<thead>
								<!--<tr class="gHeaderYear">
									<th colspan="4" class="panelLeftHead last"></th>
								</tr>-->
								<tr class="gHeaderMonth">
									<th colspan="4" class="panelLeftHead last"></th>
								</tr>
								<tr class="gHeaderDay" id="day">
									<th class="panelLeftHead typeFd">
										Type
										<div class="orderField" attr-field="fpi.FloorPlanDesc">
											<span class="orderRow" attr-order="asc" ><i class="fa fa-caret-up"></i></span>
											<span class="orderRow" attr-order="desc"><i class="fa fa-caret-down"></i></span>
										</div>
									</th>
									<th class="panelLeftHead NumFd">
										Num
										<div class="orderField" attr-field="u.UnitCode">
											<span class="orderRow" attr-order="asc" ><i class="fa fa-caret-up"></i></span>
											<span class="orderRow" attr-order="desc"><i class="fa fa-caret-down"></i></span>
										</div>
									</th>
									<th class="panelLeftHead StatusFd">
										status
										<div class="orderField" attr-field="hks.HKStatusDesc">
											<span class="orderRow" attr-order="asc" ><i class="fa fa-caret-up"></i></span>
											<span class="orderRow" attr-order="desc"><i class="fa fa-caret-down"></i></span>
										</div>
									</th>
									<th class="panelLeftHead last Tooltips ViewFd">
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
						<!--<table id="tableFrontDesk1" class="" style="">
							<thead>
								<tr>
									<td class="">a</td>
									<td class="">b</td>
									<td class="">c</td>
								</tr>
							</thead>
							<tbody id="tablePrueba">
								<?php
								for($i = 0;$i<100;$i++){
									?>
									<tr>
										<td class="">a</td>
										<td class="">b</td>
										<td class="">c</td>
									</tr>
									<?php
								}
								?>
							</tbody>
						</table>-->
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
					
					<div class="section6 tableSection" style="display:none;">
						<table id="tableExchangeRateFront" style="width:100%">
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
				<div class="section7 tableSection" style="display:none;">
						<table id="tablaAuditUnits" style="width:100%">
							<thead>
								<tr>
									<th>unitCode</th>
									<th>Date</th>
									<th>FloorPlan</th>
									<th>OccTypeDesc</th>
									<th>Resconf</th>
									<th>LName</th>
									<th>Name</th>
									
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<div class="section8 tableSection" style="display:none;">
						<table id="tablaAuditTrx" style="width:100%">
							<thead>
								<tr>
									<th>Unit</th>
									<th>CrDate</th>
									<th>User</th>
									<th>Trx Description</th>
									<th>Sign</th>
									<th>TrxAmount</th>
									<th>Credit</th>
									<th>Debit</th>
									<th>Audit Date</th>
									<th>Audit by user</th>
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

<div id="dialog-Reservations"  title="Reservation > Create Reservation" style="display: none;"></div>
<div id="dialog-Edit-Reservation" title="Reservation > Edit Reservation" style="display: none;"></div>
<div id="dialog-tourID" title="Tour ID" style="display: none;"></div>
<div id="dialog-PeopleRes" title="Reservation > Create Reservation > Add People" style="display: none;"></div>
<div id="dialog-UnidadesRes" title="Reservation > Create Reservation > Add Unidades" style="display: none;"></div>
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
<div id="dialog-HKConfig" title="HouseKeeping Configuration " style="display: none;"></div>
<div id="dialog-people-hkConfig" title="People " style="display: none;"></div>
<div id="dialog-unit-hkConfig" title="Unit " style="display: none;"></div>
<div id="dialog-edit-HKStatus" title="HK status" style="display: none;"></div>
<div id="dialog-CreditLimit"  title="Credit Limit" style="display: none;"></div>
<div id="dialog-ExchangeRate"  title="FrontDesk > New Exchange Rate" style="display: none;"></div>
<div id="dialog-StatusRes"  title="Status" style="display: none;"></div>
<div id="dialog-NewOccRes"  title="New Night" style="display: none;"></div>
<div id="dialog-ChangeUnitRes"  title="Change Unit" style="display: none;"></div>
<div id="dialog-addTransactionsAudit"  title="Add Transaccions" style="display: none;"></div>
<script type="text/javascript" src="<?php echo base_url().JS; ?>reservation.js"></script>
<script type="text/javascript" src="<?php echo base_url().JS; ?>frontDesk.js"></script>
