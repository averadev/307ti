            
<div class="row fiter-section">
	
    <div class="section-bar">Consultas<div class="collapseFilter"></div></div>
	<div class="section-bar" id="newUser">Nuevo</div>
    <div class="medium-12 columns">
        <div class="row filter-fields">
            <div class="rdoField">
              <input type="radio" id="rdoFilter1" name="rdoFilter" value="Red" checked>
                <label for="rdoFilter1">Persona Id</label>
            </div>
            <div class="rdoField">
              <input type="radio" id="rdoFilter2" name="rdoFilter" value="Red">
                <label for="rdoFilter2">Apellido</label>
            </div>
            <div class="rdoField">
              <input type="radio" id="rdoFilter3" name="rdoFilter" value="Red">
                <label for="rdoFilter3">Nombre</label>
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns rowSearch">
              <input type="text" class="txtSearch" placeholder="Ingresa un parámetro de búsqueda" />
            </div>
        </div>
    </div>
    <div class="medium-2 columns">&nbsp;</div>
</div>

<div class="row pagination-section">
    <div class="medium-2 columns section-bar"><span>Resultados</span></div>
    <div class="pages">
        <div>Pagina</div>
        <div class="number">1</div>
        <div class="selected">2</div>
        <div class="number">3</div>
        <div class="number">4</div>
        <div class="number">5</div>
        <div class="number">6</div>
        <div class="number">7</div>
        <div class="arrow-pag">&rsaquo;</div>
    </div>
</div>

<div class="row table-section">
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
					<input id="textState" type="text" id="right-label">
				</div>
			</div>
			<!-- Pais -->
			<div class="row">
				<div class="small-3 columns">
					<label id="alertCountry" for="right-label" class="text-right">Pais</label>
				</div>
				<div class="small-9 columns">
					<select id="textCountry">
						<option value="1">Mexico</option>
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
					<input type="text" id="textPhone1" placeholder="xxx-xxx-xxxx">
				</div>
			</div>
			<!-- Telefono 2 -->
			<div class="row">
				<div class="small-3 columns">
					<label for="right-label" class="text-right">Telefono 2</label>
				</div>
				<div class="small-9 columns">
					<input type="text" id="textPhone2" placeholder="xxx-xxx-xxxx">
				</div>
			</div>
			<!-- Telefono 3 -->
			<div class="row">
				<div class="small-3 columns">
					<label for="right-label" class="text-right">Telefono 3</label>
				</div>
				<div class="small-9 columns">
					<input type="text" id="textPhone3" placeholder="xxx-xxx-xxxx">
				</div>
			</div>
			<!-- Email 1 -->
			<div class="row">
				<div class="small-3 columns">
					<label id="alertEmail1" for="right-label" class="text-right">Email 1</label>
				</div>
				<div class="small-9 columns">
					<input type="text" id="textEmail1">
				</div>
			</div>
			<!-- Email 2 -->
			<div class="row">
				<div class="small-3 columns">
					<label for="right-label" class="text-right">Email 2</label>
				</div>
				<div class="small-9 columns">
					<input type="text" id="textEmail2">
				</div>
			</div>
		</div>
	</fieldset>
</div>

<script type="text/javascript" src="<?php echo base_url().JS; ?>people.js"></script>