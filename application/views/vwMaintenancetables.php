
<div class="row section" id="section-InvDetailed">
	<div class="large-12 columns fiter-section">
		<div class="box" id="boxInvDetailedSearch" relation-attr="box-inventary-relation" >
			<!-- header search -->
			<div class="box-header pr-color">
				<div class="pull-right box-tools">
					<span id="minusPeople" class="box-btn" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</span>
				</div>
				<h3 class="box-title">
					<span>Inventory Search</span>
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
							<div class="small-12 large-3 columns">
									<div class="caja" >
										<select id="catalogos" class="input-group-field round">
											<option value="0">Transaction Type Lookup</option>
											<option value="0">Country Lookup</option>
										</select>
									</div>
								</div>
						</fieldset>
					</div>


				</div>
			</div>
		</div>
	</div>
	
	<div class="large-12 columns" id="box-inventary-relation">
		<div class="box">
			<div class="box-header pr-color">
				<div class="pull-right box-tools">
				</div>
				<h3 class="box-title">
					<span>Inventory Relation</span>
				</h3>
			</div>
			<div class="box-body" id="section-table-InvDetailed" style="display: block;">
				<div class="table" >
					<iframe src="http://pms.thetowersatmulletbay.com/cat_training/mtblTrxType/grid_dbo_TblTrxType/" width="100%" height="600">
						<p>Your browser does not support iframes.</p>
					</iframe>
				</div>

			</div>
		</div>
	</div>

</div>

