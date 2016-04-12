
<div class="row fiter-section" id="section-people">
	
    <div class="section-bar">Search<div class="collapseFilter"></div></div>
	<div class="section-bar" id="newUser">New person</div>
    <div class="medium-12 columns">
        <div class="row filter-fields">
			<div class="large-12 columns">
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
			</div>
			<div class="small-12 medium-10 large-7 columns end">
				<fieldset class="fieldset fieldsetFilter-advanced-hide" id="fieldsetFilterAdvanced">
					<legend><input type="checkbox" id="checkFilterAdvance" class="checkFilter">&nbsp;&nbsp;Advanced search</legend>
					<div class="row" id="containerFilterAdv" style="display:none;">
						<div class="large-6 columns">
							<input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="initials" id="RadioInitials" checked><label for="RadioInitials">initials / Employee code</label>
						</div>
						<div class="large-6 columns">
							<input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="EmailDesc" id="RadioEmail"><label for="RadioEmail">Email</label>
						</div>
						<div class="large-6 columns">
							<input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="Folio" id="RadioFolio"><label for="RadioFolio">Folio</label>
						</div>
						<div class="large-6 columns">
							<input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="ResCode" id="RadioCode"><label for="RadioCode">Contract Id</label>
						</div>
						<div class="large-12 columns">
							<input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="FloorPlanDesc" id="RadioFloorPlan"><label for="RadioFloorPlan">Foor Plan</label>
						</div>
					</div>
				</fieldset>
			</div>
        </div>
        <div class="row">
            <div class="large-12 columns rowSearch">
              <input type="text" id="txtSearch" class="txtSearch" placeholder="Enter a search parameter" />
            </div>
			<div class="large-6 columns end rowBtnSearch">
				<div class="small button-group radius groupBtnSearch">
					<a id="btnSearch" class="button btnSearch">Search</a>
					<a id="btnCleanSearch" class="button btnSearch">Clean</a>
				</div>
			</div>
        </div>
    </div>
    <div class="medium-2 columns">&nbsp;</div>
</div>

<div class="row pagination-section">
    <div class="medium-2 columns section-bar"><span>Results</span></div>
    <div class="pages">
        <!--<div>Pagina</div>
        <div class="number">1</div>
        <div class="selected">2</div>
        <div class="number">3</div>
        <div class="number">4</div>
        <div class="number">5</div>
        <div class="number">6</div>
        <div class="number">7</div>
        <div class="arrow-pag">&rsaquo;</div>-->
		<div class="pagination" id="paginationPeople">
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
		<div id="divTablePeople">
			<table id="tablePeople">
				<thead>
					<tr>
						<th class="cellEdit" >Edit</th>
						<th class="cellEdit" >Id</th>
						<th class="cellGeneral" >Name</th>
						<th class="cellGeneral">Last name</th>
						<th class="cellGeneral">Gender</th>
						<th class="cellDate" >Birth date</th>
						<th class="cellAddress" >Street, number, colonia</th>
						<th class="cellGeneral" >City</th>
						<th class="cellGeneral" >State</th>
						<th class="cellGeneral" >Country</th>
						<th class="cellGeneral" >Zip code</th>
						<th class="cellPhone" >Phone number 1</th>
						<th class="cellPhone" >Phone number 2</th>
						<th class="cellPhone" >Phone number 3</th>
						<th class="cellEmail" >Email</th>
						<th class="cellEmail" >Email 2</th>
					</tr>
				</thead>
				<tbody>
		
				</tbody>
			</table>
		</div>
	</div>
	<!--<button id="downloadButton">Start Download</button>-->
</div>

<div id="dialog-User" title="People">
	<div class="tabsModal" id="tabsModalPeople">
		<ul class="tabs" data-tabs>
			<li class="tabs-title active" attr-screen="tab-PGeneral">
				<a>General</a>
			</li>
			<li class="tabs-title" attr-screen="tab-PReservaciones">
				<a>Reservations</a>
			</li>
			<li class="tabs-title" attr-screen="tab-PContratos">
				<a>Contract</a>
			</li>
			<li class="tabs-title" attr-screen="tab-PEmpleados">
				<a>Employee</a>
			</li>
		</ul>
	</div>
	<div class="row contentModal" id="contentModalPeople">
	
		<div id="tab-PGeneral" class="large-12 columns tab-modal" style="display:inline;">
			<!-- Datos personales -->
			<div class="row" id="alertValPeopleGeneral" style="display:inline;">
				<div class="small-12 columns">
					<!--<div data-alert class="alert-box alert" >-->
					<div class="callout alert">
						Please complete fields in red
					</div>
				</div>
			</div>
	
			<fieldset class="fieldset">
				<legend>Personal information</legend>
				<!-- nombre-->
				<div class="row">
				
					<div class="small-12 large-3 columns">
						
						<label id="alertName" for="right-label" class="text-left">Name</label>
						
					</div>
					<div class="small-12 large-9 columns">
						
						<input type="text" id="textName" class="round general">
					</div>
				</div>
				<!-- segundo nombre-->
				<div class="row">
					<div class="small-12 large-3 columns">
						<label id="alertMiddleName" for="right-label" class="text-left">Middle name</label>
					</div>
					<div class="small-12 large-9 columns">
						<input type="text" id="textMiddleName" class="round general">
					</div>
				</div>
				<!-- apellido paterno-->
				<div class="row">
					<div class="small-12 large-3 columns">
						<label id="alertLastName" for="right-label" class="text-left">Last name</label>
					</div>
					<div class="small-12 large-9 columns">
						<input type="text" id="textLastName" class="round general">
					</div>
				</div>
				<!-- apellido materno-->
				<div class="row">
					<div class="small-12 large-3 columns">
						<label for="right-label" class="text-left">Second last name</label>
					</div>
					<div class="small-12 large-9 columns">
						<input type="text" id="TextSecondLastName" class="round general">
					</div>
				</div>
				<!-- genero -->
				<div class="row">
					<div class="small-12 large-3 columns">
						<label id="alertGender" for="right-label" class="text-left">Gender</label>
					</div>
					<div class="small-12 large-9 columns">
						<input type="radio" name="RadioGender" class="RadioGender" value="M" id="RadioMale" required><label for="RadioMale">Male</label>
						<input type="radio" name="RadioGender" class="RadioGender" value="F" id="RadioFemale"><label for="RadioFemale">Female</label>
					</div>
				</div>
		
				<div class="row">
					<!-- fecha de nacimiento-->
					<div class="small-12 large-6 columns" for="alertBirthdate" style="float:right">
						<label id="alertBirthdate" for="alertBirthdate" class="text-left">Birth date
							<input type="text" id="textBirthdate" class="round general" >
						</label>
					</div>
					<!-- aniversario boda-->
					<div class="small-12 large-6 columns">
						<label id="alertWeddingAnniversary" for="textWeddingAnniversary" class="text-left">Wedding anniversary
							<input type="text" id="textWeddingAnniversary" class="round general">
						</label>
					</div>
				</div>

				<div class="row">
					<!-- Nacionalidad-->
					<div class="small-12 large-6 columns">
						<label id="alertNationality" for="textNationality" class="text-left">Nationality
							<select id="textNationality" class="round">
								<option value="husker">Mexican</option>
							</select>
						</label>
					</div>
					<!-- Calificacion-->
					<div class="small-12 large-6 columns">
						<label for="textQualification" class="text-left">Qualification
							<input type="number" id="textQualification" class="round general">
						</label>
					</div>
				</div>		
			</fieldset>
			<!-- Datos del domicilio -->
			<div class="row" id="alertValPeopleAddress" style="display:none;">
				<div class="small-12 columns">
					<div class="callout alert">
						Please complete fields in red
					</div>
				</div>
			</div>
			<fieldset class="fieldset">
				<legend class="btnAddressData"><img id="imgCoppapseAddress" class="imgCollapseFieldset down" src="<?php echo base_url().IMG; ?>common/iconCollapseDown.png"/>Address data</legend>
				<div id="containerAddress" style="display:none;">
					<!-- calle, numero-->
					<div class="row">
						<div class="small-12 large-3 columns">
							<label id="alertStreet" for="textStreet" class="text-left">Street number</label>
						</div>
						<div class="small-12 large-9 columns">
							<input id="textStreet" type="text" class="round general">
						</div>
					</div>
					<!-- Colonia -->
					<div class="row">
						<div class="small-12 large-3 columns">
							<label id="alertColony" for="textColony" class="text-left">Colony</label>
						</div>
						<div class="small-12 large-9 columns">
							<input id="textColony" type="text" class="round general">
						</div>
					</div>
			
					<div class="row">
						<!-- Pais -->
						<div class="small-12 large-6 columns">
							<label id="alertCountry" for="textCountry" class="text-left">Country
								<select id="textCountry" class="round">
									<option value="0" code="0">Select your country</option>
									<?php
									foreach($country as $item){
								
									?>
									<option value="<?php echo $item->pkCountryId; ?>" code="<?php echo $item->CountryCode; ?>"><?php echo $item->CountryDesc; ?></option>
									<?php
									}
									?>
								</select>
							</label>
						</div>
						<!-- Estado-->
						<div class="small-12 large-6 columns">
							<label id="alertState" for="textState" class="text-left">State
								<select id="textState" class="round">
									<option value="0" code="0">Select your state</option>
								</select>
							</label>
						</div>
					</div>
			
					<div class="row">
						<!-- Ciudad -->
						<div class="small-12 large-6 columns">
							<label id="alertCity" for="textCity" class="text-left">City
								<input id="textCity" type="text" class="round general">
							</label>
						</div>
						<!-- Zip Code -->
						<div class="small-12 large-6 columns">
							<label id="alertPostalCode" for="textPostalCode" class="text-left">Zip Code
								<input id="textPostalCode" type="text" class="round general">
							</label>
						</div>
					</div>
			
				</div>
			</fieldset>
			<!-- Datos del contacto -->
			<div class="row" id="alertValPeopleContact" style="display:none;">
				<div class="small-12 columns">
					<div class="callout alert">
						Please complete fields in red
					</div>
				</div>
			</div>
			<fieldset class="fieldset">
				<legend class="btnContactData"><img id="imgCoppapseContact" class="imgCollapseFieldset down" src="<?php echo base_url().IMG; ?>common/iconCollapseDown.png"/>Contact information</legend>
				<div id="containerContact" style="display:none">
					<!-- Telefono 1-->
					<div class="row">
						<div class="small-12 large-3 columns">
							<label id="alertPhone1" for="textPhone1" class="text-left">Phone number 1</label>
						</div>
						<div class="small-12 large-9 columns">
							<input type="tel" class="phonePeople round general" id="textPhone1" maxlength="7" placeholder="xxx-xxxx">
						</div>
					</div>
					<!-- Telefono 2 -->
					<div class="row">
						<div class="small-12 large-3 columns">
							<label id="alertPhone2" for="textPhone2" class="text-left">Phone number 2</label>
						</div>
						<div class="small-12 large-9 columns">
							<input type="tel" class="phonePeople round general" id="textPhone2" maxlength="7" placeholder="xxx-xxxx">
						</div>
					</div>
					<!-- Telefono 3 -->
					<div class="row">
						<div class="small-12 large-3 columns">
							<label id="alertPhone3" for="textPhone3" class="text-left">Phone number 3</label>
						</div>
						<div class="small-12 large-9 columns">
							<input type="tel" class="phonePeople round general" id="textPhone3" maxlength="7" placeholder="xxx-xxxx">
						</div>
					</div>
					<!-- Email 1 -->
					<div class="row">
						<div class="small-12 large-3 columns">
							<label id="alertEmail1" for="textEmail1" class="text-left">Email 1</label>
						</div>
						<div class="small-12 large-9 columns">
							<input type="email" class="emailPeople round general" id="textEmail1">
						</div>
					</div>
					<!-- Email 2 -->
					<div class="row">
						<div class="small-12 large-3 columns">
							<label id="alertEmail2" for="textEmail2" class="text-left">Email 2</label>
						</div>
						<div class="small-12 large-9 columns">
							<input type="email" class="emailPeople round general" id="textEmail2">
						</div>
					</div>
				</div>
			</fieldset>
		</div>
		<div id="tab-PReservaciones" class="large-12 columns tab-modal">
			<div class="row" id="divTableReservationsPeople">
				<div class="large-12 columns table-section2">
					<table id="tableReservationsPeople">
						<thead>
							<tr>
								<th class="cellGeneral" >Res. code</th>
								<th class="cellSmall" >ResId</th>
								<th class="cellMedium">Res Type</th>
								<th class="cellGeneral">Year</th>
								<th class="cellGeneral" >Night num</th>
								<th class="cellBig" >Floor plan</th>
								<th class="cellMedium" >Season</th>
								<th class="cellMedium" >Occupancy type</th>
								<th class="cellBig" >Date</th>
								<th class="cellSmall" >Interval</th>
								<th class="cellSmall" >Unit</th>
							</tr>
						</thead>
						<tbody>
			
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div id="tab-PContratos" class="large-12 columns tab-modal">
			
			<div class="row search-section">
				<div class="large-12 columns search">
					<input type="text" id="textSearchContractPeople" class="fieldSearch" placeholder="Id folio" />
				</div>
				<div class="large-12 columns end rowBtnSearch">
					<div class="button-group radius groupBtnSearch">
						<a id="btnSearchContractPeople" class="button btnSearch">Search</a>
						<a id="btnCleanSearchContractPeople" class="button btnSearch">Clean</a>
					</div>
				</div>
			</div>
		
			<div class="row" id="divTableContractPeople">
				<div class="large-12 columns table-section2">
					<table id="tableContractPeople">
						<thead>
							<tr>
								<th> </th>
								<th class="cellGeneral" >Contract No.</th>
								<th class="cellSmall" >Contract Id</th>
								<th class="cellMedium">First occ year</th>
								<th class="cellMedium">Floor plan</th>
								<th class="cellMedium" >Season</th>
								<th class="cellMedium" >Frequency</th>
								<th class="cellBig" >Sale date</th>
								<th class="cellSmall" >Intv</th>
								<th class="cellGeneral" >Unit</th>
								<th class="cellMedium" >CSF balance</th>
								<th class="cellMedium" >Loan bal</th>
								<th class="cellMedium" >Status</th>
							</tr>
						</thead>
						<tbody>
		
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div id="tab-PEmpleados" class="large-12 columns tab-modal">
			<!-- Datos del contacto -->
			<div class="row" id="alertValPeopleEmployee" style="display:none;">
				<div class="small-12 columns">
					<div class="callout alert">
						Please complete fields in red
					</div>
				</div>
			</div>
			<fieldset class="fieldset">
				<legend><input type="checkbox" id="checkPeopleEmployee" class="checkModalPeople">&nbsp;&nbsp;Assign employee</legend>
				<div class="row" id="containerPeopleEmployee">
					<div class="small-12 large-12 columns">
					<!-- Código del colaborador:-->
					<div class="row">
						<div class="small-3 columns">
							<label id="alertCodeCollaborator" for="textCodeCollaborator" class="text-left">Employee code</label>
						</div>
						<div class="small-9 columns">
							<input type="text" class="round general" id="textCodeCollaborator">
						</div>
					</div>
					<div class="row">
						<!-- Iniciales-->
						<div class="small-12 large-6 columns" style="float:right">
							<label id="alertInitials" for="textInitials" class="text-left">Initials</label>
								<input type="text" id="textInitials" class="round general" >
							
						</div>
						<!-- Código numérico -->
						<div class="small-12 large-6 columns">
							<label for="textCodeNumber" id="alertCodeNumber" class="text-left">Numeric code</label>
								<input type="number" id="textCodeNumber" class="round general">
							
						</div>
					</div>
					<!-- tipo de vendedor -->
					<div class="row">
						<div class="small-3 columns">
							<label id="alertTypeSeller" for="textTypeSeller" class="text-left">Payroll account</label>
						</div>
						<div class="small-9 columns">
							<select id="textTypeSeller" class="round">
								<option value="0" code="0">Select a type of seller</option>
							</select>
						</div>
					</div>
					<!-- Nómina-->
					<div class="row">
						<div class="small-3 columns">
							<label id="alertRoster" for="textRoster" class="text-left">Payroll type</label>
						</div>
						<div class="small-9 columns">
							<select id="textRoster" class="round">
								<option value="0" code="0">Select the payroll</option>
								<option value="1" code="0">Sales</option>
								<option value="2" code="0">Administrator</option>
							</select>
						</div>
					</div>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
	<input type="hidden" value="0" id="idPeople" />
</div>

<script type="text/javascript" src="<?php echo base_url().JS; ?>people.js"></script>
