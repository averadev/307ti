            
<div class="row fiter-section">
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
							<input id="checkbox1" type="checkbox"><label for="checkbox1">Iniciales / Codigo Empleado</label>
						</div>
						<div class="large-6 columns">
							<input id="checkbox2" type="checkbox"><label for="checkbox2">Direccion Email</label>
						</div>
						<div class="large-6 columns">
							<input id="checkbox1" type="checkbox"><label for="checkbox1">Folio</label>
						</div>
						<div class="large-6 columns">
							<input id="checkbox2" type="checkbox"><label for="checkbox2">Contrato ID</label>
						</div>
						<div class="large-12 columns">
							<input id="checkbox1" type="checkbox"><label for="checkbox1">Unidad</label>
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
				<ul class="button-group radius groupBtnSearch">
					<li><a id="btnSearch" class="tiny button btnSearch">Buscar</a></li>
					<li><a id="btnCleanSearch" class="tiny button btnSearch">Limpiar</a></li>
				</ul>
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

<div class="row table-section">
	<div class="divLoadingTable">
		<div class="bgLoadingTable" ></div>
		<div class="loadingTable" >
			<div class="subLoadingTable">
				<label>Cargando..</label>
				<div id="progressbar"></div>
			</div>
		</div>
	</div>
	<table id="tablePeople" width="100%">
	<thead>
		<tr>
			<th></th>
			<th>id</th>
			<th>Nombre</th>
			<th>Apellidos</th>
			<th>Genero</th>
			<th>Fecha Nacimiento</th>
			<th>Calle, Numero, colonia</th>
			<th>Ciudad</th>
			<th>Estado</th>
			<th>Pais</th>
			<th>CP</th>
			<th>Telefono 1</th>
			<th>Telefono 2</th>
			<th>Telefono 3</th>
			<th>Email</th>
			<th>Email 2</th>
		</tr>
	</thead>
	<tbody>
		
	</tbody>
	</table>
	<!--<button id="downloadButton">Start Download</button>-->
</div>

<div id="dialog-User" title="Alta de usuarios">
	<!-- Datos personales -->
	<div class="row" id="alertValidateUSer" style="display:none;">
		<div class="small-12 columns">
			<div data-alert class="alert-box alert " >
				Por favor rellene los campos Obligatorios(rojo)
			</div>
		</div>
	</div>
	
	<fieldset class="fieldset">
		<legend>Datos personales</legend>
		<!-- nombre-->
		<div class="row">
			<div class="small-3 columns">
				<label id="alertName" for="right-label" class="text-right">Nombre</label>
			</div>
			<div class="small-9 columns">
				<input type="text" id="textName">
			</div>
		</div>
		<!-- apellido paterno-->
		<div class="row">
			<div class="small-3 columns">
				<label id="alertLastName" for="right-label" class="">Apellido paterno</label>
			</div>
			<div class="small-9 columns">
				<input type="text" id="textLastName">
			</div>
		</div>
		<!-- apellido materno-->
		<div class="row">
			<div class="small-3 columns">
				<label for="right-label" class="text-right">Apellido materno</label>
			</div>
			<div class="small-9 columns">
				<input type="text" id="TextSecondLastName">
			</div>
		</div>
		<!-- genero -->
		<div class="row">
			<div class="small-3 columns">
				<label id="alertGender" for="right-label" class="text-right">Genero</label>
			</div>
			<div class="small-9 columns">
				<input type="radio" name="hombre" class="RadioGender" value="M" id="RadioMale" required><label for="RadioMale">Hombre</label>
				<input type="radio" name="mujer" class="RadioGender" value="F" id="RadioFemale"><label for="RadioFemale">Mujer</label>
			</div>
		</div>
		<!-- fecha de nacimiento-->
		<div class="row">
			<div class="small-3 columns">
				<label id="alertBirthdate" for="right-label" class="text-right">Fecha de nacimiento</label>
			</div>
			<div class="small-9 columns">
				<input type="date" id="textBirthdate">
			</div>
		</div>
		<!-- aniversario boda-->
		<div class="row">
			<div class="small-3 columns">
				<label for="right-label" class="text-right">Aniversario boda</label>
			</div>
			<div class="small-9 columns">
				<input type="date" id="textWeddingAnniversary">
			</div>
		</div>
		<!-- Nacionalidad-->
		<div class="row">
			<div class="small-3 columns">
				<label id="alertNationality" for="right-label" class="text-right">Nacionalidad</label>
			</div>
			<div class="small-9 columns">
				<select id="textNationality">
					<option value="husker">Mexicano</option>
				</select>
			</div>
		</div>
		<!-- Calificacion-->
		<div class="row">
			<div class="small-3 columns">
				<label for="right-label" class="text-right">Calificación</label>
			</div>
			<div class="small-9 columns">
				<input type="text" id="textQualification">
			</div>
		</div>
	</fieldset>
	<!-- Datos del domicilio -->
	<fieldset class="fieldset">
		<legend id="btnAddressData">Datos del domicilio</legend>
		<div id="containerAddress" style="display:none;">
			<!-- calle, numero-->
			<div class="row">
				<div class="small-3 columns">
					<label id="alertStreet" for="right-label" class="text-right">Calle, numero</label>
				</div>
				<div class="small-9 columns">
					<input id="textStreet" type="text" id="right-label">
				</div>
			</div>
			<!-- Colonia -->
			<div class="row">
				<div class="small-3 columns">
					<label id="alertColony" for="right-label" class="text-right">Colonia</label>
				</div>
				<div class="small-9 columns">
					<input id="textColony" type="text" id="right-label">
				</div>
			</div>
			<!-- Ciudad -->
			<div class="row">
				<div class="small-3 columns">
					<label id="alertCity" for="right-label" class="text-right">Ciudad</label>
				</div>
				<div class="small-9 columns">
					<input id="textCity" type="text" id="right-label">
				</div> 
			</div>
			<!-- Edtado -->
			<div class="row">
				<div class="small-3 columns">
					<label id="alertState" for="right-label" class="text-right">Estado</label>
				</div>
				<div class="small-9 columns">
					<select id="textState">
						<?php
							foreach($state as $item){
								?>
									<option value="<?php echo $item->pkStateId ?>" code="<?php echo $item->StateCode; ?>"><?php echo $item->StateDesc ?></option>
								<?php
							}
						?>
					</select>
				</div>
			</div>
			<!-- Pais -->
			<div class="row">
				<div class="small-3 columns">
					<label id="alertCountry" for="right-label" class="text-right">Pais</label>
				</div>
				<div class="small-9 columns">
					<select id="textCountry">
						<?php
							foreach($country as $item){
								?>
									<option value="<?php echo $item->pkCountryId; ?>" code="<?php echo $item->CountryCode; ?>"><?php echo $item->CountryDesc; ?></option>
								<?php
							}
						?>
					</select>
				</div>
			</div>
			<!-- Zip Code -->
			<div class="row">
				<div class="small-3 columns">
					<label id="alertPostalCode" for="right-label" class="text-right">Zip Code</label>
				</div>
				<div class="small-9 columns">
					<input id="textPostalCode" type="text" id="right-label">
				</div>
			</div>
		</div>
	</fieldset>
	<!-- Datos del contacto -->
	<fieldset class="fieldset">
		<legend id="btnContactData">Información del contacto</legend>
		<div id="containerContact" style="display:none">
			<!-- Telefono 1-->
			<div class="row">
				<div class="small-3 columns">
					<label id="alertPhone1" for="right-label" class="text-right">Telefono 1</label>
				</div>
				<div class="small-9 columns">
					<input type="tel" class="phonePeople" id="textPhone1" maxlength="7" placeholder="xxx-xxx-xxxx">
				</div>
			</div>
			<!-- Telefono 2 -->
			<div class="row">
				<div class="small-3 columns">
					<label id="alertPhone2" for="right-label" class="text-right">Telefono 2</label>
				</div>
				<div class="small-9 columns">
					<input type="tel" class="phonePeople" id="textPhone2" maxlength="7" placeholder="xxx-xxx-xxxx">
				</div>
			</div>
			<!-- Telefono 3 -->
			<div class="row">
				<div class="small-3 columns">
					<label id="alertPhone3" for="right-label" class="text-right">Telefono 3</label>
				</div>
				<div class="small-9 columns">
					<input type="tel" class="phonePeople" id="textPhone3" maxlength="7" placeholder="xxx-xxx-xxxx">
				</div>
			</div>
			<!-- Email 1 -->
			<div class="row">
				<div class="small-3 columns">
					<label id="alertEmail1" for="right-label" class="text-right">Email 1</label>
				</div>
				<div class="small-9 columns">
					<input type="email" class="emailPeople" id="textEmail1">
				</div>
			</div>
			<!-- Email 2 -->
			<div class="row">
				<div class="small-3 columns">
					<label id="alertEmail2" for="right-label" class="text-right">Email 2</label>
				</div>
				<div class="small-9 columns">
					<input type="email" class="emailPeople" id="textEmail2">
				</div>
			</div>
		</div>
	</fieldset>
</div>

<script type="text/javascript" src="<?php echo base_url().JS; ?>people.js"></script>