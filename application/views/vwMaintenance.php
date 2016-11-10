<div class="row section" id="section-Maintenance">
	<div class="large-12 columns fiter-section">
		<div class="box" id="boxMaintenanceSearch" relation-attr="box-Maintenance-relation" >
			<!-- header search -->
			<div class="box-header pr-color">
				<div class="pull-right box-tools">
					<span id="minusPeople" class="box-btn" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</span>
				</div>
				<h3 class="box-title">
					<span>Maintenance Search</span>
				</h3>
				<a data-widget="newBatch" id="newBatch" class="btn btn-new">
					<div class="label">New</div>
					<img src="<?php echo base_url().IMG; ?>common/more.png"/>
				</a>
			</div>
			<!-- body search-->
			<div class="box-body box-filter" style="display: block;">
				<!--filter-->
				<div class="row">
					<div class="small-12 medium-12 large-12 columns">
						<div class="row">
							<div class="small-12 large-3 columns">
								<label id="alertTypeGroupColl" for="MProperty" class="text-left">Property
									<div class="caja" >
										<select id="MProperty" class="txtSearch input-group-field round">
											<option value="">choose an option</option>
											<?php
											foreach($MProperty as $item){
												?>
												<option value="<?php echo $item->ID; ?>"><?php echo $item->Description; ?></option>
												<?php
											}
											?>
										</select>
									</div>
								</label>
							</div>
							<div class="small-12 large-3 columns">
								<label id="alertTypeGroupColl" for="MProperty" class="text-left">Maintenance Year
									<div class="caja" >
										<select id="MYear" class="txtSearch input-group-field round">
											<option value="">choose an option</option>
											<?php
											foreach($Years as $item){
												?>
												<option value="<?php echo $item->Year; ?>"><?php echo $item->Year; ?></option>
												<?php
											}
											?>
										</select>
									</div>
								</label>
							</div>
							<div class="small-12 large-3 columns">
								<label id="alertTypeGroupColl" for="MSaleType" class="text-left">Sale Type
									<div class="caja" >
										<select id="MSaleType" class="txtSearch input-group-field round">
											<option value="">choose an option</option>
											<?php
											foreach($MSaleType as $item){
												?>
												<option value="<?php echo $item->ID; ?>"><?php echo $item->Description; ?></option>
												<?php
											}
											?>
										</select>
									</div>
								</label>
							</div>
							<div class="small-12 large-3 columns">
									<label id="MLabelfloorPlan" for="MFloorPlan" class="text-left">FloorPlan
											<select id="MFloorPlan" class="input-group-field round"  multiple="multiple">
												<?php
												foreach($MFloorPlan as $item){
													?>
													<option value="<?php echo $item->ID; ?>"><?php echo $item->Description; ?></option>
													<?php
												}
												?>
											</select>
									</label>
								</div>
						</div>
					</div>
					<div class="small-12 medium-12 large-12 columns">
						<div class="row">
							<!-- Occ type Group -->
							<div class="small-12 large-3 columns">
								<label id="alertTypeGroupColl" for="MFrequency" class="text-left">Frequency
									<div class="caja" >
										<select id="MFrequency" class="txtSearch input-group-field round">
											<option value="">choose an option</option>
											<?php
											foreach($MFrequency as $item){
												?>
												<option value="<?php echo $item->ID; ?>"><?php echo $item->Description; ?></option>
												<?php
											}
											?>
										</select>
									</div>
								</label>
							</div>
							<!-- Past Due Days -->
							<div class="small-12 large-3 columns">
								<div >
									<label id="MSearchLabel" for="createByRes" class="text-left">Detail
										<input id="MSearch" type="text" class="round" placeholder="Folio" name="search">
									</label>
								</div>
							</div>
							<!-- btn -->
							<div class="small-12 large-6 columns" style="padding-top:25px;">
								<a id="btnManSearch" class="btn btn-primary btn-Search">
									<div class="label">Search</div>
									<img src="<?php echo base_url().IMG; ?>common/BUSCAR.png"/>
								</a>
								<a id="btnManCleanSearch" class="btn btn-primary spanSelect">
									<div class="label">Clean</div>
									<img src="<?php echo base_url().IMG; ?>common/BORRAR2.png"/>
								</a>
<!-- 								<a id="printBatch" class="btn btn-primary">
									<div class="label">Print</div>
									<i class="fa fa-print" aria-hidden="true"></i>
								</a> -->
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="large-12 columns" id="box-Maintenance-relation">
		<div class="box">
			<div class="box-header pr-color">
				<div class="pull-right box-tools">
				</div>
				<h3 class="box-title">
					<span>Maintenance Relation</span>
				</h3>
			</div>
			<div class="box-body" id="section-Maintenance" style="display: block;">
				<div class="table">
					<div class="" id="divTableMaintenance">
						<table id="tableMaintenance" style="width:100%;">
							<thead id="headMaintenance">
							</thead>
							<tbody id="bodyMaintenance">
		
							</tbody>
						</table>
					</div>
				</div>
				<div class="pages">
					<span id="NCMA"></span>
				</div>
			</div>
		</div>
	</div>

</div>

<div id="dialog-NewBatch" title="Maintenance" style="display: none;"></div>
<div id="dialog-DetailBatch" title="Detail" style="display: none;"></div>

<script type="text/javascript" src="<?php echo base_url().JS; ?>maintenance.js"></script>