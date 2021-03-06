
<div class="row section" id="section-Collection">
	<div class="large-12 columns fiter-section">
		<div class="box" id="boxCollectionSearch" relation-attr="box-collection-relation" >
			<!-- header search -->
			<div class="box-header pr-color">
				<div class="pull-right box-tools">
					<span id="minusPeople" class="box-btn" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</span>
				</div>
				<h3 class="box-title">
					<span>Admin Search</span>
				</h3>
			</div>
			<!-- body search-->
			<div class="box-body box-filter" style="display: block;">
				<!--filter-->
				<div class="row">
					<div class="small-12 medium-12 large-12 columns">
						<div class="row">
							<!-- trx id -->
							<div class="small-12 large-2 columns">
								<label id="alertTrxIdColl" for="TrxIdColl" class="text-left">TrxId
									<input type="number" id="TrxIdColl" class="txtSearch"/>
								</label>
							</div>
							<!-- folio -->
							<div class="small-12 large-2 columns">
								<label id="alertFolioColl" for="FolioColl" class="text-left">Folio
									<input type="number" id="FolioColl" class="txtSearch"/>
								</label>
							</div>
							
							<!-- trx type -->
							<div class="small-12 large-2 columns">
								<label id="alertTrxTypeColl" for="TrxTypeColl" class="text-left">Trx Type
									<div class="caja" >
										<select id="TrxTypeColl" class="txtSearch input-group-field round">
											<option value="">choose an option</option>
											<?php
											foreach($trxType as $item){
												?>
												<option value="<?php echo $item->ID; ?>"><?php echo $item->TrxTypeDesc; ?></option>
												<?php
											}
											?>
										</select>
									</div>
								</label>
							</div>
							<!-- trx type -->
							<div class="small-12 large-3 columns">
								<label id="alertAccTypeColl" for="AccTypeColl" class="text-left">Acc Type
									<div class="caja" >
										<select id="AccTypeColl" class="txtSearch input-group-field round">
											<option value="">choose an option</option>
											<?php
											foreach($accType as $item){
												?>
												<option value="<?php echo $item->ID; ?>"><?php echo $item->AccTypeDesc; ?></option>
												<?php
											}
											?>
										</select>
									</div>
								</label>
							</div>
							<div class="small-12 large-3 columns">
							<label id="alertFolioColl" for="FolioColl" class="text-left">Report
								
								</label>
								<a id="btnCollReportCA" class="btn btn-primary spanSelect">
									<div class="label"> Agreements Report</div>
									<i class="fa fa-print" aria-hidden="true"></i>
								</a>
							</div>
						</div>
					</div>

					<div class="small-12 medium-12 large-12 columns">
						<div class="row">
							<!-- Due Date -->
							<div class="small-12 large-3 columns">
								<label id="alertDueDateColl" for="DueDateColl" class="text-left">Due Date
									<div class="input-group date" >
										<span  class="input-group-label prefix"><i class="fa fa-calendar"></i></span>
										<input type="text" id="DueDateColl" class="txtSearch input-group-field roundRight" readonly/>
									</div>
								</label>
							</div>
							<!-- Past Due Days -->
							<div class="small-12 large-3 columns">
								<label id="alertPastDueDateColl" for="PastDueDateColl" class="text-left">Past Due Days
									<input type="number" id="PastDueDateColl" class="txtSearch"/>
								</label>
							</div>
							<!-- trx Amt -->
							<div class="small-12 large-3 columns float-left">
								<label id="alertTrxAmtColl" for="TrxAmtColl" class="text-left">Amt
									<input type="text" id="TrxAmtColl" class="txtSearch"/>
								</label>
							</div>
							<!-- cr Date -->
							<div class="small-12 large-3 columns">
								<label id="alertCrDateColl" for="CrDateColl" class="text-left">Create Date
									<div class="input-group date" >
										<span  class="input-group-label prefix"><i class="fa fa-calendar"></i></span>
										<input type="text" id="CrDateColl" class="txtSearch input-group-field roundRight" readonly/>
									</div>
								</label>
							</div>
						</div>
					</div>
					<div class="small-12 medium-12 large-12 columns">
						<div class="row">
							<!-- Occ type Group -->
							<div class="small-12 large-2 columns">
								<label id="alertTypeGroupColl" for="OccTypeGroupColl" class="text-left">Occ Type Group
									<div class="caja" >
										<select id="OccTypeGroupColl" class="txtSearch input-group-field round">
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
							<div class="small-12 large-2 columns">
								<label id="alertOccTypeColl" for="OccTypeColl" class="text-left">Occ type
									<div class="caja" >
										<select id="OccTypeColl" class="txtSearch input-group-field round">
											<option value="">choose an option</option>
										</select>
									</div>
								</label>
							</div>
							<!-- login user -->
							<div class="small-12 large-2 columns float-left">
								<label id="alertLoginUserColl" for="LoginUserColl" class="text-left">User
									<input type="text" id="LoginUserColl" class="txtSearch"/>
								</label>
							</div>
							<fieldset class="large-3 columns fieldsetFilter">
							<div class="rdoField">
								<input type="checkbox" id="Outstanding" class="checkFilter">
								<label for="Outstanding">Outstanding Balances</label>
							</div>
							</fieldset>
							<!-- btn -->
							<div class="small-12 large-3 columns" style="padding-top:25px;">
								<a id="btnCollSearch" class="btn btn-primary btn-Search">
									<div class="label">Search</div>
									<img src="<?php echo base_url().IMG; ?>common/BUSCAR.png"/>
								</a>
								<a id="btnCollCleanSearch" class="btn btn-primary spanSelect">
									<div class="label">Clean</div>
									<img src="<?php echo base_url().IMG; ?>common/BORRAR2.png"/>
								</a>
								<a id="btnCollReport" class="btn btn-primary spanSelect">
									<div class="label">Export</div>
									<i class="fa fa-print" aria-hidden="true"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="large-12 columns" id="box-collection-relation">
		<div class="box">
			<div class="box-header pr-color">
				<div class="pull-right box-tools">
				</div>
				<h3 class="box-title">
					<span>Admin Relation</span>
				</h3>
			</div>
			<div class="box-body" id="section-Colletion" style="display: block;">
				<div class="table">
					<div class="" id="divTableColletion">
						<table id="tableColletion" style="width:100%;">
							<thead id="headInvDetailed">
							</thead>
							<tbody id="bodyInvDetailed">
		
							</tbody>
						</table>
					</div>
				</div>
				<div class="pages">
					<span id="NCO"></span>
				</div>
			</div>
		</div>
	</div>

</div>

<div id="dialog-Edit-colletion" title="Collection" style="display: none;"></div>
<div id="dialog-accountsColl" title="Colletion accounts" style="display: none;"></div>
<div id="dialog-AdminReport" title="Report" style="display: none;"></div>


<script type="text/javascript" src="<?php echo base_url().JS; ?>collection.js"></script>
