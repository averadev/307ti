<div class="row section" id="section-seller">
	<div class="large-12 columns fiter-section">
		<div class="box" id="boxSellerSearch" relation-attr="box-people-relation" >
			<div class="box-header pr-color">
				<div class="pull-right box-tools">
					<span id="minusSeller" class="box-btn" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</span>
				</div>
				<h3 class="box-title">
					<span>Search</span>
				</h3>
				<a data-widget="newContrat" id="newUser" class="btn btn-new">
					<div class="label">Nuevo</div>
					<img src="<?php echo base_url().IMG; ?>common/more.png"/>
				</a>
			</div>
			<div class="box-body box-filter" style="">
				<div class="row">
					<div class="small-12 medium-12 large-12 columns">
						<fieldset class="large-12 columns fieldsetFilter">
							<legend class="legendSearch">Choose a filter</legend>
							<div class="rdoField">
								<input type="checkbox" id="checkFilter1" class="checkFilter" value="peopleId">
								<label for="checkFilter1">People Id</label>
							</div>
							<div class="rdoField">
								<input type="checkbox" id="checkFilter2" class="checkFilter" value="lastName" checked>
								<label for="checkFilter2">Last name</label>
							</div>
							<div class="rdoField">
								<input type="checkbox" id="checkFilter3" class="checkFilter" value="Name" checked>
								<label for="checkFilter3">Name</label>
							</div>
						</fieldset>
					</div>
					<div class="small-12 medium-12 large-12 columns">
						<fieldset class="large-12 columns fieldsetFilter">
							<div class="rdoField">
								<input type="checkbox" id="checkFilterAdvance" class="checkFilter">
								<label for="checkFilterAdvance">Advanced search</label>
							</div>
							<div class="filtersAdvanced" id="containerFilterAdv" style="display:none;">
								<div class="rdoField">
									<input type="radio" class="RadioSearchPeople" value="initials" id="RadioInitials" checked>
									<label for="RadioInitials">initials / Employee code</label>
								</div>
								<div class="rdoField">
									<input type="radio" class="RadioSearchPeople" value="EmailDesc" id="RadioEmail">
									<label for="RadioEmail">Email</label>
								</div>
								<div class="rdoField">
									<input type="radio" class="RadioSearchPeople" value="Folio" id="RadioFolio">
									<label for="RadioFolio">Folio</label>
								</div>
								<div class="rdoField">
									<input type="radio" class="RadioSearchPeople" value="ResCode" id="RadioCode">
									<label for="RadioCode">Contract Id</label>
								</div>
								<div class="rdoField">
									<input type="radio" class="RadioSearchPeople" value="FloorPlanDesc" id="RadioFloorPlan">
									<label for="RadioFloorPlan">Foor Plan</label>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="small-12 medium-12 large-12 columns">
						<fieldset class="large-12 columns fieldsetFilter">
							<legend class="legendSearch">Enter the filter</legend>
							<div class="row">
								<div class="large-6 columns">
									<input type="text" id="txtSearchSeller" class="txtSearch" placeholder="Enter a search parameter" />
								</div>
								<div class="small-12 large-6 columns" style="padding-left: 0;">
									<a id="btnSearchSeller" class="btn btn-primary btn-Search" attr_people="">
										<div class="label">Buscar</div>
										<img src="<?php echo base_url().IMG; ?>common/BUSCAR.png"/>
									</a>
									<a id="btnCleanSearchSeller" class="btn btn-primary spanSelect">
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
	
	<div class="large-12 columns" >
		<div class="box" id="box-seller-relation">
			<div class="box-header pr-color">
				<div class="pull-right box-tools">
               </div>
               <h3 class="box-title"><span>Sellers</span></h3>
			</div>
			<div class="box-body" id="section-table-seller">
				<div class="table" id="tb" >
					<div class="" id="divTableSeller">
						<table id="tableSeller" class="display hover" cellspacing="0"  width="100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>Codigo</th>
									<th>Nombre completo</th>
									<!--<th>Rol</th>-->
								</tr>
							</thead>
							<tbody id="tableSellerbody">
								<tr></tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>