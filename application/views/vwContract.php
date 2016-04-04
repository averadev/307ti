
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
			<th class="cellGeneral">Nombre Lega</th>
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

<div id="dialog-Contract" title="Alta de contratos">
	<!-- <form action="" onsubmit="EnviaServicio(3, 'modal'); return false"> -->

	<div class="small-12 columns">
	<form action="" id="contract" enctype="multipart/form-data" method="post" name="contract">
		<fieldset>
	    	<legend>Contrato</legend>
		     <div class="small-4 columns">
		     	<label>Nombre legal</label>
		        <input type="text" name="nombreContrat">
		      </div>
			<div class="small-4 columns">
				<label>Idioma</label>
			    <select>
			    	<option>Español</option>
			    	<option>Ingles</option>
			    </select>
			 </div>
			<div class="small-4 columns">
				<label>Tour ID</label>
			    <input type="text" name="tourID">
			 </div>
		 </fieldset>
</form>
</div>
<table id="tablecontract">
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
    <!-- <div id="contactForm" class="small-12 small-offset-0 medium-8 medium-offset-2 large-8 large-offset-2 columns">
          
          <label>Nombre legal</label>
          <input id="nameContract" type="text" placeholder="Nombre del contrato" required="">
          <div class="row">
		    <div class="large-6 columns">
		      <label>Selecciona un idioma
		        <select>
		          <option value="Español">Español</option>
		          <option value="Ingles">Ingles</option>
		        </select>
		      </label>
		    </div>
 
  		<div class="large-6 columns">
  			<label>Tour ID</label>
   	 		<input type="text" placeholder="Tour ID" required="">
   	 	</div>
   	 </div>
    </div>
    
   
   <table id="tablecontract">
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

    </div> -->
</div>


<script type="text/javascript" src="<?php echo base_url().JS; ?>contract.js"></script>