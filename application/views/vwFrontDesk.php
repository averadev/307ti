
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
			</div>
			<!-- body search-->
			<div class="box-body box-filter" style="display: block;">
				<!--filter-->
				<div class="row">
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
								<div class="small-12 large-3 columns" style="padding-top:35px;">
									<a id="btnSearchFrontDesk" class="btn btn-primary btn-Search">
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
					<div id="divTableFrontDesk">
					
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

<script type="text/javascript" src="<?php echo base_url().JS; ?>frontDesk.js"></script>
