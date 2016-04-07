<div class="row fiter-section" id="section-contract">
    <div class="section-bar">Consultas<div class="collapseFilter"></div></div>
	<div class="section-bar" id="newContract">Nuevo</div>
    <div class="medium-12 columns">
        <div class="row filter-fields">
			<div class="large-12 columns">
				<div class="rdoField">
				<input type="checkbox" id="checkFilter1" class="checkFilter" value="contractId">
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
					<div class="row" id="containerFilterAdvContract" style="display:none;">
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
		<div class="pagination" id="paginationcontract">
			<a href="#" class="first" data-action="first">&laquo;</a>
			<a href="#" class="previous" data-action="previous">&lsaquo;</a>
			<input type="text" readonly="readonly" />
			<a href="#" class="next" data-action="next">&rsaquo;</a>
			<a href="#" class="last" data-action="last">&raquo;</a>
		</div>
		<input type="hidden" id="paginationcontract" value="true" />
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
	<table id="tablecontract" width="100%">
	<thead>
		<tr>
			<th class="cellEdit" ></th>
			<th class="cellEdit" >ContratoId</th>
			<th class="cellGeneral" >Folio</th>
			<th class="cellGeneral">Nombre Legal</th>
			<th class="cellGeneral">Tipo Unidad</th>
			<th class="cellGeneral" >Fecruencia</th>
			<th class="cellGeneral" >status</th>
			<th class="cellDate" >Fecha Creación</th>
			<th class="cellGeneral" >Primer año ocupación</th>
			<th class="cellGeneral" >Ultimo año ocupación</th>
			<th class="cellGeneral" >Precio Unidad</th>
			<th class="cellGeneral" >Precio Venta</th>

		</tr>
	</thead>
	<tbody>
		
	</tbody>
	</table>
</div>

<div id="dialog-tourID" title="busqueda ID Tour">
	<div class="contentModal">
	        <div class="row filter-fields">
			<div class="large-12 columns">
				<div class="rdoField">
				<input type="checkbox" id="checkFilter1" class="checkFilter" value="contractId">
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
					<div class="small-12 ">
				<fieldset class="fieldset fieldsetFilter-advanced-hide" id="fieldsetFilterAdvanced">
					<legend>
						<input type="checkbox" id="checkFilterAdvance" class="checkFilter">Busqueda Avanzada
					</legend>
					<div class="row" id="containerFilterAdv" >
						<div class="large-6 columns">
							<input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="initials" id="RadioInitials" checked><label for="RadioInitials">OPC</label>
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
					<!-- fecha Inicial-->
					<div class="small-12 large-6 columns">
						<label id="alertBirthdate" for="alertBirthdate" class="text-left">De
							<input type="date" id="" class="general" >
						</label>
					</div>
					<!-- Fecha final-->
					<div class="small-12 large-6 columns">
						<label for="textWeddingAnniversary" class="text-left">A:
							<input type="date" id="" class="general">
						</label>
					</div>
		</div>
		

	<div class="row">
	  <div class="small-2 columns">
				<label id="alertLastName" for="right-label" class="text-left">Buscar</label>
		</div>
	    <div class="large-10 columns">
	      <div class="row collapse">
	        <div class="small-8 columns">
	          <input type="text" placeholder="Campo de busqueda">
	        </div>
	        <div class="small-2 columns">
	          <a id="btn" data-reveal-id="btn" href="#" class="button postfix">Limpiar</a>
	        </div>
	        <div class="small-2 columns">
	          <a id="btn" data-reveal-id="btn" href="#" class="button postfix">Agregar</a>
	        </div>
	      </div>
	    </div>
		</div>
		<div class="row">
			<fieldset>
				<legend>Relacion de tours</legend>
				<div class="row">
					<table>
						<thead>
				<tr>
					<th class="cellEdit" >Tour ID</th>
					<th class="cellGeneral">Persona ID</th>
					<th class="cellGeneral">Nombre</th>
					<th class="cellGeneral" >Apellidos</th>
					<th class="cellGeneral" >Fecha Tour</th>
					<th class="cellGeneral" >Locación Contacto</th>
					<th class="cellGeneral" >OPC</th>
					<th class="cellGeneral" >Adultos Mayores</th>
					<th class="cellGeneral" >Menores</th>
					<th class="cellGeneral" >Nacionalidad</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
					</table>
				</div>
			</fieldset>
		</div>

 </div>
</div>




<div id="dialog-Personas" title="Personas" style="display: none;">
	<div class="contentModal">
	        <div class="row filter-fields">
			<div class="large-12 columns">
				<div class="rdoField">
				<input type="checkbox" id="checkFilter1" class="checkFilter" value="contractId">
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
					<div class="row" id="containerFilterAdvContract" >
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
					<!-- fecha Inicial-->
					<div class="small-12 large-6 columns">
						<label id="alertBirthdate" for="alertBirthdate" class="text-left">De
							<input type="date" id="" class="general" >
						</label>
					</div>
					<!-- Fecha final-->
					<div class="small-12 large-6 columns">
						<label for="textWeddingAnniversary" class="text-left">A:
							<input type="date" id="" class="general">
						</label>
					</div>
		</div>
	<div class="row">
	  <div class="small-2 columns">
				<label id="alertLastName" for="right-label" class="text-left">Buscar</label>
		</div>
	    <div class="large-10 columns">
	      <div class="row collapse">
	        <div class="small-8 columns">
	          <input type="text" placeholder="Campo de busqueda">
	        </div>
	        <div class="small-2 columns">
	          <a id="btn" data-reveal-id="btn" href="#" class="button postfix">Limpiar</a>
	        </div>
	        <div class="small-2 columns">
	          <a id="btn" data-reveal-id="btn" href="#" class="button postfix">Agregar</a>
	        </div>
	      </div>
	    </div>
		</div>
		<div class="row">
			<fieldset>
				<legend>Relacion de tours</legend>
				<div class="row">
					<table class="smal-12 columns">
						<thead>
				<tr>
					<th class="cellEdit" > <input type="checkbox"></th>
					<th class="cellGeneral" >ID</th>
					<th class="cellGeneral">Nombre</th>
					<th class="cellGeneral">Apellido</th>
					<th class="cellGeneral" >Dirección</th>
					<th class="cellGeneral" ></th>
				</tr>
			</thead>
			<tbody>
			</tbody>
					</table>
				</div>
			</fieldset>
		</div>

 </div>
</div>


<div id="dialog-Unidades" title="Unidades" style="display: none;">
	<div class="contentModal">
	        <div class="row filter-fields">
			<div class="large-12 columns">
				<div class="rdoField">
				<input type="checkbox" id="checkFilter1" class="checkFilter" value="contractId">
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
					<legend><input type="checkbox" id="checkFilterAdvance" class="checkFilter">Busqueda Avanzada</legend>
					<div class="row" id="containerFilterAdvContract" >
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
					<!-- fecha Inicial-->
					<div class="small-12 large-6 columns">
						<label id="alertBirthdate" for="alertBirthdate" class="text-left">De
							<input type="date" id="" class="general" >
						</label>
					</div>
					<!-- Fecha final-->
					<div class="small-12 large-6 columns">
						<label for="textWeddingAnniversary" class="text-left">A:
							<input type="date" id="" class="general">
						</label>
					</div>
		</div>
	<div class="row">
	  <div class="small-2 columns">
				<label id="alertLastName" for="right-label" class="text-left">Buscar</label>
		</div>
	    <div class="large-10 columns">
	      <div class="row collapse">
	        <div class="small-8 columns">
	          <input type="text" placeholder="Campo de busqueda">
	        </div>
	        <div class="small-2 columns">
	          <a id="btn" data-reveal-id="btn" href="#" class="button postfix">Limpiar</a>
	        </div>
	        <div class="small-2 columns">
	          <a id="btn" data-reveal-id="btn" href="#" class="button postfix">Agregar</a>
	        </div>
	      </div>
	    </div>
		</div>
		<div class="row">
			<fieldset>
				<legend>Relacion de tours</legend>
				<div class="row">
					<table class="smal-12 columns">
						<thead>
				<tr>
					<th class="cellEdit" > <input type="checkbox"></th>
					<th class="cellGeneral" >ID</th>
					<th class="cellGeneral">Nombre</th>
					<th class="cellGeneral">Apellido</th>
					<th class="cellGeneral" >Dirección</th>
					<th class="cellGeneral" ></th>
				</tr>
			</thead>
			<tbody>
			</tbody>
					</table>
				</div>
			</fieldset>
		</div>

 </div>
</div>


<div id="dialog-Contract" title="Alta de Contratos">
	<div class="contentModal">
		<div id="tabs-1">
		<!-- Mensaje Error -->
			<div class="row" id="alertValidateContrato" style="display:none;">
				<div class="small-12 columns">
					<div data-alert class="alert-box alert " >
						Por favor rellene los campos Obligatorios(rojo)
					</div>
				</div>
			</div>
	<form id="saveDataContract">
		<fieldset class="fieldset">
			<legend>
				Datos Contrato
			</legend>
		<!-- nombre legal-->
		<div class="row">
			<div class="small-3 columns">
				<label for="legalName" class="text-left">Nombre legal</label>
			</div>
			<div class="small-9 columns">
				<input name="legalName" type="text" id="legalName" name="legalName" class="general" required>
			</div>
		</div>
		<!-- Idioma-->
		<div class="row">
			<div class="small-3 columns">
				<label id="alertLastName" for="right-label" class="text-left">Idioma</label>
			</div>
			<div class="small-9 columns">
				<select id="idiomaContract" form="saveDataContract">
      			<option selected disabled>Elige</option>
					<option value="espanol">Español</option>
					<option value="ingles">Ingles</option>
				</select>
			</div>
		</div>
		<!-- Tour ID-->
	  <div class="row">
	  <div class="small-3 columns">
				<label id="tourID" for="right-label" class="text-left">Tour ID</label>
		</div>
	    <div class="large-9 columns">
	      <div class="row collapse">
	        <div class="small-10 columns">
	          <input type="text" placeholder="ID" name="TourID" id="TourID">
	          <small class="error">Invalid entry</small>
	        </div>
	        <div class="small-2 columns">
	          <a id="btnTourID" data-reveal-id="btnTourID" href="#" class="button postfix">Agregar</a>
	        </div>
	      </div>
	    </div>
	  </div>

		<div class="containerPeople">
		<div class="row">
				<div class="divLoadingTable">
				<div class="bgLoadingTable"></div>
				<div class="loadingTable" >
					<div class="subLoadingTable">
						<label>Cargando..</label>
						<div id="progressbar"></div>
					</div>
				</div>
			</div>
			<div class="small-12 columns">
				<a id="btnAddPeople" href="#" class="button tiny"><i class="fa fa-user-plus"></i></a>
			</div>
			<table id="tablePeople" width="100%">
			<thead>
				<tr>
					<th class="cellEdit" >ID</th>
					<th class="cellGeneral">Nombre</th>
					<th class="cellGeneral">Apellidos</th>
					<th class="cellGeneral" >Dirección</th>
					<th class="cellGeneral" >Persona Principal</th>
					<th class="cellGeneral" >Persona Secundaria</th>
					<th class="cellGeneral" >Beneficiario</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
			</table>
	</div>
		</div>
	</fieldset>


<!-- Unidades -->

	<fieldset class="fieldset">
		<legend class="btnAddressData">Unidades</legend>
		<div class="containerPeople">
			<div class="row">
				<div class="divLoadingTable">
					<div class="bgLoadingTable"></div>
					<div class="loadingTable" >
						<div class="subLoadingTable">
							<label>Cargando..</label>
							<div id="progressbar"></div>
						</div>
					</div>
				</div>
		<div class="small-12 columns">
			<a id="btnAddUnidades" href="#" class="button tiny"><i class="fa fa-home"></i></a>
		</div>
		<table id="tableUnidades" width="100%">
			<thead>
				<tr>
					<th class="cellEdit" >Codigo</th>
					<th class="cellGeneral">Descripcion</th>
					<th class="cellGeneral">Precio</th>
					<th class="cellGeneral" ># de Semana</th>
					<th class="cellGeneral" >Primer año OCC</th>
					<th class="cellGeneral" >Ultimo año OCC</th>
					<th class="cellGeneral" >Frecuencia</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		</div>
		</div>
	</fieldset>

<fieldset class="fieldset">
		<legend>Condiciones de Financiamiento</legend>
		<!-- nombre legal-->
		<div class="row">
			<div class="small-6 columns">
			<div class="row">
								<div class="small-3 columns">
					<label  class="text-left">Tipo de venta</label>
				</div>
				<div class="small-9 columns">
					<select>
	      			<option selected disabled>Seleccione un tipo</option>
						<option>Unidad de Compañia</option>
						<option>Reventa</option>
						<option>Upgrade</option>
						<option>Downgrade</option>
					</select>
				</div>
			</div>

			</div>
		<div class="small-6 columns">
			<div class="row">
			  <div class="small-3 columns">
						<label id="alertLastName" for="right-label" class="text-left">Contrato Relacionado</label>
					</div>
			    <div class="large-9 columns">
			      <div class="row collapse">
			        <div class="small-10 columns">
			          <input id="contractR" name="contractR" type="text" placeholder="Folio">
			        </div>
			        <div class="small-2 columns">
			          <a href="#" class="button postfix"><i class="fa fa-search"></i></a>
			        </div>
			      </div>
			    </div>
	  </div>
		</div>
		</div>
		<div class="row">
		<table id="tableFinanciamiento" class="small-12 columns">
			<thead>
				<tr>
					<th class="cellEdit" >Folio</th>
					<th class="cellGeneral">Nombre Legal</th>
					<th class="cellGeneral">Tipo de unidad</th>
					<th class="cellDate" >Fecha</th>
					<th class="cellGeneral" >Total</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		</div>
	<div class="row">
    <div class="large-4 columns">
      <label>Precio Unidad
        <input id="precioUnidad" name="precioUNIDAD" type="text" placeholder="Precio Unidad" />
      </label>
    </div>
    <div class="large-4 columns">
      <label>Referencia Pack
        <input type="text" name="referenciaPACK" placeholder="Referencia" />
      </label>
    </div>
    <div class="large-4 columns">
      <label>Precio Venta
        <input type="text" name="precioVENTA" placeholder="Precio Venta" />
      </label>
    </div>
  </div>


	<div class="row">
    	<div class="large-4 columns">
      		<label>Enganche
        		<input type="text" placeholder="Precio Unidad" />
      		</label>
    	</div>
    <div class="large-4 columns">
      <label>Elige</label>
      <input type="radio" name="pokemon" value="Red" id="porcentaje"><label for="pokemonRed">Porcentaje</label>
      <input type="radio" name="pokemon" value="Blue" id="cantidad"><label for="pokemonBlue">Cantidad</label>
    </div>
    <div class="large-4 columns">
      		<label>Monto
        		<input type="text" placeholder="%" />
      		</label>
    	</div>
   </div>
   <!--Enganche-->
<div class="row">
	<div class="small-3 columns">
		<label id="alertLastName" for="right-label" class="text-left">Deposito Enganche</label>
	</div>
    <div class="large-9 columns">
      <div class="row collapse">
        <div class="small-10 columns">
          <input type="text" placeholder="Deposito">
        </div>
        <div class="small-2 columns">
          <a href="#" class="button postfix">Capturar</a>
        </div>
      </div>
    </div>
  </div>
  <!--Pagos progrmados-->
  <div class="row">
	<div class="small-3 columns">
		<label id="alertLastName" for="right-label" class="text-left">Pagos programados</label>
	</div>
    <div class="large-9 columns">
      <div class="row collapse">
        <div class="small-10 columns">
          <input type="text" placeholder="Deposito">
        </div>
        <div class="small-2 columns">
          <a href="#" class="button postfix">Capturar</a>
        </div>
      </div>
    </div>
  </div>
    <!--Montos a Descontar-->
  <div class="row">
	<div class="small-3 columns">
		<label id="alertLastName" for="right-label" class="text-left">Montos Regalados a Descontar</label>
	</div>
    <div class="large-9 columns">
      <div class="row collapse">
        <div class="small-10 columns">
          <input type="text" placeholder="Deposito">
        </div>
        <div class="small-2 columns">
          <a href="#" class="button postfix">Capturar</a>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
  	<fieldset>
  		<legend>
  			<i class="fa fa-money"></i>
  		</legend>
  		<div class="row">
  			<p>Pack agregados</p>
  		<table id="tableDescuentos" class="large-12 columns">
			<thead>
				<tr>
					<th class="cellGeneral" >Tipo de Pack</th>
					<th class="cellGeneral">Monto</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
  		</div>
  	</fieldset>
  </div>
  	<div class="row">
		<div class="small-6 columns">
			<label>Montro transferido</label>
			<input type="text" placeholder="monto">
		</div>
		<div class="small-6 columns">
			<label>Balance a financiar</label>
			<input type="text" placeholder="monto">
		</div>
	</div>
	</fieldset>
</form>
	</div>
</div>
</div>




<script type="text/javascript" src="<?php echo base_url().JS; ?>contract.js"></script>