<div class="row section" id="section-contract">
	<div class="large-12 columns">
		<div class="box" relation-attr="box-contract-relation">
			<div class="box-header pr-color">
				<div class="pull-right box-tools">
					<span class="box-btn" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</span>
				</div>
				<h3 class="box-title">
               		<span>Contract Search</span>
               	</h3>
				<a data-widget="newContrat" id="newContract" class="btn btn-new">
					<div class="label">New</div>
					<img src="<?php echo base_url().IMG; ?>common/more.png"/>
				</a>
			</div>
			<div class="box-body box-filter">
				<div class="row">
					<div class="small-12 medium-12 large-12 columns">
						<fieldset class="large-12 columns fieldsetFilter">
							<legend class="legendSearch">Choose a filter</legend>
							<div class="rdoField">
								<input checked type="radio" name="filtro_contrato" value="contrato" id="contrato">
								<label for="contrato">Contract ID</label>
							</div>
							<div class="rdoField">
								<input  type="radio" name="filtro_contrato" value="nombre" id="nombre">
								<label for="nombre">Name</label>
							</div>
							<div class="rdoField">
								<input type="radio" name="filtro_contrato" value="apellido" id="apellido">
								<label for="apellido">Last name</label>
							</div>
<!-- 							<div class="rdoField">
								<input type="radio" name="filtro_contrato" value="reservacionId" id="reservacionId">
								<label for="reservacionId">Reservation ID</label>
							</div> -->
							<div class="rdoField">
									<input type="radio" name="filtro_contrato" value="folio" id="folio">
									<label for="folio">Folio</label>
								</div>
						</fieldset>
					</div>
					
					<div class="small-12 medium-12 large-12 columns">
						<fieldset class="large-12 columns fieldsetFilter">
							<div class="rdoField">
								<input type="checkbox" id="busquedaAvanazada" class="checkFilter">
								<label for="busquedaAvanazada">Advanced search</label>
							</div>
							<div class="filtersAdvanced" id="avanzada" style="display:none;">
								<div class="rdoField">
									<input type="radio" name="filtro_contrato" value="codEmpleado" id="codEmpleado" required>
									<label for="codEmpleado">Employee code</label>
								</div>
								<div class="rdoField">
									<input type="radio" name="filtro_contrato" value="unidad" id="unidad">
									<label for="unidad">Unit ID</label>
								</div>
								<div class="rdoField">
									<input type="radio" name="filtro_contrato" value="email" id="email" />
									<label for="email">Email</label>
								</div>
								<div class="rdoField">
									<input type="radio" name="filtro_contrato" value="personaId" id="personaId" required>
									<label for="personaId">People ID</label>
								</div>
							</div>
						</fieldset>
					</div>
					
					<div class="small-12 medium-12 large-12 columns">
						<fieldset class="large-12 columns fieldsetFilter">
							<legend class="legendSearch" >Select Period</legend>
							<div class="row">
								<div class="medium-3 columns">
									<input id="startDateContract" class="round" type="text" placeholder="Start Date">
								</div>
								<div class="medium-3 columns">
									<input id="endDateContract" class="round" type="text"  placeholder="Finish Date">
								</div>
								<div class="medium-3 columns">
									<input id="stringContrat" type="text" class="round" placeholder="Search Field" name="search"  required>
								</div>
								<div class="medium-3 columns ">
									<a id="btnfind" class="btn btn-primary btn-Search">
										<div class="label">Search</div>
										<img src="<?php echo base_url().IMG; ?>common/BUSCAR.png"/>
									</a>
									<a id="btnCleanWord" class="btn btn-primary spanSelect">
										<div class="label">Clean</div>
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



	<div class="large-12 columns" id="box-contract-relation">
		<div class="box">
			<div class="box-header pr-color">
				<div class="pull-right box-tools">
               </div>
               <h3 class="box-title">
               	<span>Contracts</span>
               </h3>
			</div>
			<div class="box-body"  style="display: block;">
				<div class="table" >
					<table id="contracts" style="width:100%;">
						<thead id="contractsthead">
						</thead>
						<tbody id="contractstbody"></tbody>
					</table>
				</div>
				<div class="pagina" >
				<div class="pages">
					<span id="NC">Total:</span>
				</div>
				</div>
			</div>
		</div>
	</div>
	
</div>


<div id="dialog-Contract"  title="Contract > Create Contract" style="display: none;"></div>
<div id="dialog-Edit-Contract" title="Edit Contract" style="display: none;"></div>
<div id="dialog-tourID" title="Tour ID" style="display: none;"></div>
<div id="dialog-People" title="Contract > Create Contract > Add People" style="display: none;"></div>
<div id="dialog-Unidades" title="Contract > Create Contract > Add Units" style="display: none;"></div>
<div id="dialog-Weeks" title="Weeks" style="display: none;"></div>
<div id="dialog-Pack" title="Extras" style="display: none;"></div>
<div id="dialog-Downpayment" title="Downpayment" style="display: none;"></div>
<div id="dialog-ScheduledPayments" title="Scheduled Payments" style="display: none;"></div>
<div id="dialog-DiscountAmount" title="Discount Amount" style="display: none;"></div>
<div id="dialog-Financiamiento" title="Financing Terms" style="display: none;"></div>
<div id="dialog-Sellers" title="Set Sellers" style="display: none;"></div>
<div id="dialog-Provisiones" title="Add Provisions" style="display: none;"></div>
<div id="dialog-Notas" title="All Notes" style="display: none;"></div>
<div id="dialog-accounts"  title="Accounts" style="display: none;"></div>
<div id="dialog-newFile"  title="New File" style="display: none;"></div>
<div id="dialog-DetailWeek"  title="Detail Week" style="display: none;"></div>
<div id="dialog-CreditCardAS"  title="Card Associated" style="display: none;"></div>
<div id="dialog-Status"  title="Status" style="display: none;"></div>
<script type="text/javascript" src="<?php echo base_url().JS; ?>contract.js"></script>
<script type="text/javascript" src="<?php echo base_url().JS; ?>creditCardValidator/CardValidator.js"></script>
