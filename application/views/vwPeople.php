
<div class="row fiter-section" id="section-people">
	
    <div class="section-bar">Consultas<div class="collapseFilter"></div></div>
	<div class="section-bar" id="newUser">Nuevo</div>
    <div class="medium-12 columns">
        <div class="row filter-fields">
			<div class="large-12 columns">
				<div class="rdoField">
				<input type="checkbox" id="checkFilter1" class="checkFilter" value="peopleId">
					<label for="checkFilter1">Persona Id</label>
				</div>
				<div class="rdoField">
				<input type="checkbox" id="checkFilter2" class="checkFilter" value="lastName" checked>
					<label for="checkFilter2">Apellido</label>
				</div>
				<div class="rdoField">
				<input type="checkbox" id="checkFilter3" class="checkFilter" value="Name" checked>
					<label for="checkFilter3">Nombre</label>
				</div>
			</div>
			<div class="small-12 medium-10 large-7 columns end">
				<fieldset class="fieldset fieldsetFilter-advanced-hide" id="fieldsetFilterAdvanced">
					<legend><input type="checkbox" id="checkFilterAdvance" class="checkFilter">&nbsp;&nbsp;Busqueda Avanzada</legend>
					<div class="row" id="containerFilterAdv" style="display:none;">
						<div class="large-6 columns">
							<input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="initials" id="RadioInitials" checked><label for="RadioInitials">Iniciales / Codigo Empleado</label>
						</div>
						<div class="large-6 columns">
							<input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="EmailDesc" id="RadioEmail"><label for="RadioEmail">Direccion Email</label>
						</div>
						<div class="large-6 columns">
							<input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="Folio" id="RadioFolio"><label for="RadioFolio">Folio</label>
						</div>
						<div class="large-6 columns">
							<input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="ResCode" id="RadioCode"><label for="RadioCode">Contrato ID</label>
						</div>
						<div class="large-12 columns">
							<input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="FloorPlanDesc" id="RadioFloorPlan"><label for="RadioFloorPlan">Unidad</label>
						</div>
					</div>
				</fieldset>
			</div>
        </div>
        <div class="row">
            <div class="large-12 columns rowSearch">
              <input type="text" id="txtSearch" class="txtSearch" placeholder="Ingresa un parámetro de búsqueda" />
            </div>
			<div class="large-6 columns end rowBtnSearch">
				<div class="small button-group radius groupBtnSearch">
					<a id="btnSearch" class="button btnSearch">Buscar</a>
					<a id="btnCleanSearch" class="button btnSearch">Limpiar</a>
				</div>
			</div>
        </div>
    </div>
    <div class="medium-2 columns">&nbsp;</div>
</div>

<div class="row pagination-section">
    <div class="medium-2 columns section-bar"><span>Resultados</span></div>
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

<div class="row table-section" id="divTablePeople">
	<table id="tablePeople" width="100%">
	<thead>
		<tr>
			<th class="cellEdit" ></th>
			<th class="cellEdit" >id</th>
			<th class="cellGeneral" >Nombre</th>
			<th class="cellGeneral">Apellidos</th>
			<th class="cellGeneral">Genero</th>
			<th class="cellDate" >Fecha Nacimiento</th>
			<th class="cellAddress" >Calle, Numero, colonia</th>
			<th class="cellGeneral" >Ciudad</th>
			<th class="cellGeneral" >Estado</th>
			<th class="cellGeneral" >Pais</th>
			<th class="cellGeneral" >CP</th>
			<th class="cellPhone" >Telefono 1</th>
			<th class="cellPhone" >Telefono 2</th>
			<th class="cellPhone" >Telefono 3</th>
			<th class="cellEmail" >Email</th>
			<th class="cellEmail" >Email 2</th>
		</tr>
	</thead>
	<tbody>
		
	</tbody>
	</table>
	<!--<button id="downloadButton">Start Download</button>-->
</div>

<div id="dialog-User" title="Alta de usuarios">
	<div class="tabsModal" id="tabsModalPeople">
		<ul class="tabs" data-tabs>
			<li class="tabs-title active" attr-screen="tab-PGeneral">
				<a>General</a>
			</li>
			<li class="tabs-title" attr-screen="tab-PReservaciones">
				<a>Reservaciones</a>
			</li>
			<li class="tabs-title" attr-screen="tab-PContratos">
				<a>Contratos</a>
			</li>
			<li class="tabs-title" attr-screen="tab-PEmpleados">
				<a>Empleados</a>
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
						Por favor rellene los campos Obligatorios(rojo)
					</div>
				</div>
			</div>
	
			<fieldset class="fieldset">
				<legend>Datos personales</legend>
				<!-- nombre-->
				<div class="row">
				
					<div class="small-3 columns">
						
						<label id="alertName" for="right-label" class="text-left">
							Nombre
						</label>
						
					</div>
					<div class="small-9 columns">
						
						<input type="text" id="textName" class="round general">
					</div>
				</div>
				<!-- segundo nombre-->
				<div class="row">
					<div class="small-3 columns">
						<label id="alertMiddleName" for="right-label" class="text-left">segundo Nombre</label>
					</div>
					<div class="small-9 columns">
						<input type="text" id="textMiddleName" class="round general">
					</div>
				</div>
				<!-- apellido paterno-->
				<div class="row">
					<div class="small-3 columns">
						<label id="alertLastName" for="right-label" class="text-left">Apellido paterno</label>
					</div>
					<div class="small-9 columns">
						<input type="text" id="textLastName" class="round general">
					</div>
				</div>
				<!-- apellido materno-->
				<div class="row">
					<div class="small-3 columns">
						<label for="right-label" class="text-left">Apellido materno</label>
					</div>
					<div class="small-9 columns">
						<input type="text" id="TextSecondLastName" class="round general">
					</div>
				</div>
				<!-- genero -->
				<div class="row">
					<div class="small-3 columns">
						<label id="alertGender" for="right-label" class="text-left">Genero</label>
					</div>
					<div class="small-9 columns">
						<input type="radio" name="RadioGender" class="RadioGender" value="M" id="RadioMale" required><label for="RadioMale">Hombre</label>
						<input type="radio" name="RadioGender" class="RadioGender" value="F" id="RadioFemale"><label for="RadioFemale">Mujer</label>
					</div>
				</div>
		
				<div class="row">
					<!-- fecha de nacimiento-->
					<div class="small-12 large-6 columns" for="alertBirthdate" style="float:right">
						<label id="alertBirthdate" for="alertBirthdate" class="text-left">Fecha de nacimiento
							<input type="text" id="textBirthdate" class="round general" >
						</label>
					</div>
					<!-- aniversario boda-->
					<div class="small-12 large-6 columns">
						<label id="alertWeddingAnniversary" for="textWeddingAnniversary" class="text-left">Aniversario boda
							<input type="text" id="textWeddingAnniversary" class="round general">
						</label>
					</div>
				</div>

				<div class="row">
					<!-- Nacionalidad-->
					<div class="small-12 large-6 columns">
						<label id="alertNationality" for="textNationality" class="text-left">Nacionalidad
							<select id="textNationality" class="round">
								<option value="husker">Mexicano</option>
							</select>
						</label>
					</div>
					<!-- Calificacion-->
					<div class="small-12 large-6 columns">
						<label for="textQualification" class="text-left">Calificación
							<input type="number" id="textQualification" class="round general">
						</label>
					</div>
				</div>		
			</fieldset>
			<!-- Datos del domicilio -->
			<div class="row" id="alertValPeopleAddress" style="display:none;">
				<div class="small-12 columns">
					<div class="callout alert">
						Por favor rellene los campos Obligatorios(rojo)
					</div>
				</div>
			</div>
			<fieldset class="fieldset">
				<legend class="btnAddressData"><img id="imgCoppapseAddress" class="imgCollapseFieldset down" src="<?php echo base_url().IMG; ?>common/iconCollapseDown.png"/>Datos del domicilio</legend>
				<div id="containerAddress" style="display:none;">
					<!-- calle, numero-->
					<div class="row">
						<div class="small-3 columns">
							<label id="alertStreet" for="textStreet" class="text-left">Calle, numero</label>
						</div>
						<div class="small-9 columns">
							<input id="textStreet" type="text" class="round general">
						</div>
					</div>
					<!-- Colonia -->
					<div class="row">
						<div class="small-3 columns">
							<label id="alertColony" for="textColony" class="text-left">Colonia</label>
						</div>
						<div class="small-9 columns">
							<input id="textColony" type="text" class="round general">
						</div>
					</div>
			
					<div class="row">
						<!-- Pais -->
						<div class="small-12 large-6 columns">
							<label id="alertCountry" for="textCountry" class="text-left">Pais
								<select id="textCountry" class="round">
									<option value="0" code="0">Seleccione su pais</option>
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
							<label id="alertState" for="textState" class="text-left">Estado
								<select id="textState" class="round">
									<option value="0" code="0">Seleccione su estado</option>
									<?php
									foreach($state as $item){
									?>
										<option value="<?php echo $item->pkStateId ?>" code="<?php echo $item->StateCode; ?>"><?php echo $item->StateDesc ?></option>
									<?php
									}
									?>
								</select>
							</label>
						</div>
					</div>
			
					<div class="row">
						<!-- Ciudad -->
						<div class="small-12 large-6 columns">
							<label id="alertCity" for="textCity" class="text-left">Ciudad
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
						Por favor rellene los campos Obligatorios(rojo)
					</div>
				</div>
			</div>
			<fieldset class="fieldset">
				<legend class="btnContactData"><img id="imgCoppapseContact" class="imgCollapseFieldset down" src="<?php echo base_url().IMG; ?>common/iconCollapseDown.png"/>Información del contacto</legend>
				<div id="containerContact" style="display:none">
					<!-- Telefono 1-->
					<div class="row">
						<div class="small-3 columns">
							<label id="alertPhone1" for="textPhone1" class="text-left">Telefono 1</label>
						</div>
						<div class="small-9 columns">
							<input type="tel" class="phonePeople round general" id="textPhone1" maxlength="7" placeholder="xxx-xxx-xxxx">
						</div>
					</div>
					<!-- Telefono 2 -->
					<div class="row">
						<div class="small-3 columns">
							<label id="alertPhone2" for="textPhone2" class="text-left">Telefono 2</label>
						</div>
						<div class="small-9 columns">
							<input type="tel" class="phonePeople round general" id="textPhone2" maxlength="7" placeholder="xxx-xxx-xxxx">
						</div>
					</div>
					<!-- Telefono 3 -->
					<div class="row">
						<div class="small-3 columns">
							<label id="alertPhone3" for="textPhone3" class="text-left">Telefono 3</label>
						</div>
						<div class="small-9 columns">
							<input type="tel" class="phonePeople round general" id="textPhone3" maxlength="7" placeholder="xxx-xxx-xxxx">
						</div>
					</div>
					<!-- Email 1 -->
					<div class="row">
						<div class="small-3 columns">
							<label id="alertEmail1" for="textEmail1" class="text-left">Email 1</label>
						</div>
						<div class="small-9 columns">
							<input type="email" class="emailPeople round general" id="textEmail1">
						</div>
					</div>
					<!-- Email 2 -->
					<div class="row">
						<div class="small-3 columns">
							<label id="alertEmail2" for="textEmail2" class="text-left">Email 2</label>
						</div>
						<div class="small-9 columns">
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
								<th class="cellGeneral" >Res. codigo</th>
								<th class="cellSmall" >ResId</th>
								<th class="cellMedium">Res. tipo</th>
								<th class="cellGeneral">Año</th>
								<th class="cellGeneral" >Noches</th>
								<th class="cellBig" >Tipo de unidad</th>
								<th class="cellMedium" >Temporada</th>
								<th class="cellMedium" >Occ Type</th>
								<th class="cellBig" >Fecha</th>
								<th class="cellSmall" >Intervalos</th>
								<th class="cellSmall" >Unidad Asignada</th>
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
					<input type="text" id="textSearchContractPeople" class="fieldSearch" placeholder="Id del folio" />
				</div>
				<div class="large-12 columns end rowBtnSearch">
					<div class="button-group radius groupBtnSearch">
						<a id="btnSearchContractPeople" class="button btnSearch">Buscar</a>
						<a id="btnCleanSearchContractPeople" class="button btnSearch">Limpiar</a>
					</div>
				</div>
			</div>
		
			<div class="row" id="divTableContractPeople">
				<div class="large-12 columns table-section2">
					<table id="tableContractPeople">
						<thead>
							<tr>
								<th> </th>
								<th class="cellGeneral" >No. Contrato</th>
								<th class="cellSmall" >ContratoId</th>
								<th class="cellMedium">Primer año de ocupacion</th>
								<th class="cellMedium">Tipo de unidad</th>
								<th class="cellMedium" >Temporada</th>
								<th class="cellMedium" >Frecuencia</th>
								<th class="cellBig" >Fecha de venta</th>
								<th class="cellSmall" >Intervalos</th>
								<th class="cellGeneral" >Unidad</th>
								<th class="cellMedium" >Balance CSF</th>
								<th class="cellMedium" >Préstamo Bal</th>
								<th class="cellMedium" >Status</th>
							</tr>
						</thead>
						<tbody>
		
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div id="tab-PEmpleados" class="tab-modal">
			<!-- Datos del contacto -->
			<div class="row" id="alertValPeopleEmployee" style="display:none;">
				<div class="small-12 columns">
					<div class="callout alert">
						Por favor rellene los campos Obligatorios(rojo)
					</div>
				</div>
			</div>
				<legend><input type="checkbox" id="checkPeopleEmployee" class="checkModalPeople">&nbsp;&nbsp;Asignar como empleado</legend>
				<div id="containerPeopleEmployee">
					<!-- Código del colaborador:-->
					<div class="row">
						<div class="small-3 columns">
							<label id="alertCodeCollaborator" for="textCodeCollaborator" class="text-left">Código del colaborador</label>
						</div>
						<div class="small-9 columns">
							<input type="text" class="round general" id="textCodeCollaborator">
						</div>
					</div>
					<div class="row">
						<!-- Iniciales-->
						<div class="small-12 large-6 columns" style="float:right">
							<label id="alertInitials" for="textInitials" class="text-left">Iniciales</label>
								<input type="text" id="textInitials" class="round general" >
							
						</div>
						<!-- Código numérico -->
						<div class="small-12 large-6 columns">
							<label for="textCodeNumber" id="alertCodeNumber" class="text-left">Código numérico</label>
								<input type="number" id="textCodeNumber" class="round general">
							
						</div>
					</div>
					<!-- tipo de vendedor -->
					<div class="row">
						<div class="small-3 columns">
							<label id="alertTypeSeller" for="textTypeSeller" class="text-left">Tipo de vendedor</label>
						</div>
						<div class="small-9 columns">
							<select id="textTypeSeller" class="round">
								<option value="0" code="0">Seleccione un tipo de vendedor</option>
							</select>
						</div>
					</div>
					<!-- Nómina-->
					<div class="row">
						<div class="small-3 columns">
							<label id="alertRoster" for="textRoster" class="text-left">Nómina</label>
						</div>
						<div class="small-9 columns">
							<select id="textRoster" class="round">
								<option value="0" code="0">Seleccione la nómina</option>
								<option value="1" code="0">Ventas</option>
								<option value="2" code="0">Administrador</option>
							</select>
						</div>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
	<input type="hidden" value="0" id="idPeople" />
</div>

<script type="text/javascript" src="<?php echo base_url().JS; ?>people.js"></script>
