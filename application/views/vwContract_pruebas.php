<div class="row section" xmlns:display="http://www.w3.org/1999/xhtml" xmlns:display="http://www.w3.org/1999/xhtml"
	 xmlns:display="http://www.w3.org/1999/xhtml">
	<div class="large-12 columns">
		<div class="box">
			<div class="box-header blue_divina">
				<div class="pull-right box-tools">
					<span class="box-btn" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</span>
	                 <span class="box-btn" data-widget="remove">
	               		<i class="fa fa-times"></i>
	               </span>
               </div>
               <h3 class="box-title">
               	<i id="newContract" class="fa fa-file-text-o"></i>
               	<span>Busqueda de Contratos</span>
               </h3>
			</div>
			<div class="box-body" style="display: block;">
				<div class="row">
					  <fieldset class="large-6 columns">
					    <legend>Elige un filtro</legend>
					    <input type="radio" name="filtro_contrato" value="personaId" id="personaId" required><label for="personaId">Persona ID</label>
					    <input type="radio" name="filtro_contrato" value="nombre" id="nombre"><label for="nombre">Nombre</label>
					    <input type="radio" name="filtro_contrato" value="apellido" id="apellido"><label for="apellido">Apellido</label>
					    <input type="radio" name="filtro_contrato" value="reservacionId" id="reservacionId"><label for="reservacionId">Reservación ID</label>
					  </fieldset>
					  <fieldset class="large-6 columns">
					  	<legend>Elige un Periodo</legend>
					    <div class="row">
							<div class="medium-6 columns">
						        <input id="startDate" type="date" placeholder="Fecha Inicial">
						    </div>
						    <div class="medium-6 columns">
						    <input id="endDate" type="date" placeholder="Fecha final">
						    </div>
  						</div>
					  </fieldset>
				</div>
				<div class="row">
					<div class="medium-6 columns">
					<fieldset>
						<legend><input id="busquedaAvanazada" type="checkbox">Busqueda Avanzada</legend>
						<div class="row" id="avanzada" style="display: none;">
							<div class="large-12 columns slide">
							  	<input type="radio" name="filtro_contrato" value="codEmpleado" id="codEmpleado" required><label for="codEmpleado">Codigo de Empleado</label>
					    		<input type="radio" name="filtro_contrato" value="folio" id="folio"><label for="folio">Folio</label>
					    		<input type="radio" name="filtro_contrato" value="unidad" id="unidad"><label for="unidad">Unidad ID</label>
					    		<input type="radio" name="filtro_contrato" value="email" id="email"><label for="email">Email</label>
					    		<input type="radio" name="filtro_contrato" value="contrato" id="contrato"><label for="contrato">Contrato ID</label>
							</div>
						</div>
					</fieldset>
				    </div>
				    <div class="medium-6 columns">
				     	<div class="row">
						    <div class="large-12 columns">
						      <div class="row collapse">
						        <div class="small-10 columns">
						          <input type="text" placeholder="Campo de Búsqueda" name="search"  required="">
						        </div>
						        <div class="small-1 columns">
						          <a  id="btnfind" href="#" class="button postfix"><i class="fa fa-search"></i></a>
						        </div>
						         <div class="small-1 columns">
						          <a id="btnTourID"  href="#" class="button postfix"><i class="fa fa-trash"></i></a>
						        </div>
						      </div>
						    </div>
						  </div>
				    </div>
  				</div>
			</div>
		</div>
	</div>


		<div class="large-12 columns">
		<div class="box">
			<div class="box-header blue_divina">
				<div class="pull-right box-tools">
					<span class="box-btn" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</span>
	               <span class="box-btn" data-widget="remove">
	               		<i class="fa fa-times"></i>
	               </span>
               </div>
               <h3 class="box-title">
               	<i class="fa fa-file-text-o"></i>
               	<span>Relación de Contratos</span>
               </h3>
			</div>
			<div class="box-body" style="display: block;">
				<table style="width:100%;">
					<thead id="tblContratoshead">
					</thead>
					<tbody id="tblContratosbody"></tbody>
               </table>
			</div>
		</div>
	</div>
	
</div>

<div id="dialog-Contract" title="Alta de Contratos" style="display: none;">
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
	<form id="saveDataContract" data-abide novalidate>
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
				<select id="idiomaContract" form="saveDataContract" required="">
      			<option></option>
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
	          <input type="text" placeholder="ID" name="TourID" id="TourID" required>
	          <small class="error">verifica los datos</small>
	        </div>
	        <div class="small-2 columns">
	          <a id="btnAddTourID" href="#" class="button postfix">Agregara</a>
	        </div>
	      </div>
	    </div>
	  </div>

		<div class="containerPeople">
		<div class="row">
<!-- 				<div class="divLoadingTable">
				<div class="bgLoadingTable"></div>
				<div class="loadingTable" >
					<div class="subLoadingTable">
						<label>Cargando..</label>
						<div id="progressbar"></div>
					</div>
				</div>
			</div> -->
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
				<!-- <div class="divLoadingTable">
					<div class="bgLoadingTable"></div>
					<div class="loadingTable" >
						<div class="subLoadingTable">
							<label>Cargando..</label>
							<div id="progressbar"></div>
						</div>
					</div>
				</div> -->
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
	<div data-abide-error class="alert callout" style="display: none;">
    <p><i class="fi-alert"></i> Por favor rellene los campos Obligatorios(rojo).</p>
  </div>
	  <div class="row">
    <fieldset class="large-6 columns">
      <button class="button" type="submit" value="Submit">Submit</button>
    </fieldset>
    <fieldset class="large-6 columns">
      <button class="button" type="reset" value="Reset">Reset</button>
    </fieldset>
  </div>

</form>
	</div>
</div>
</div>


<div id="dialog-casa" title="Alta de Contratos" style="display: none;">
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
	<form id="saveDataContract" data-abide novalidate>
		<fieldset class="fieldset">
			<legend>
				Datos Casa
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
				<select id="idiomaContract" form="saveDataContract" required="">
      			<option></option>
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
	          <input type="text" placeholder="ID" name="TourID" id="TourID" required>
	          <small class="error">verifica los datos</small>
	        </div>
	        <div class="small-2 columns">
	          <a id="btnAddTourID" onclick="showModals('dialog-casa', cleanAddPeople);" href="#" class="button postfix">Agregar</a>
	        </div>
	      </div>
	    </div>
	  </div>

		<div class="containerPeople">
		<div class="row">
<!-- 				<div class="divLoadingTable">
				<div class="bgLoadingTable"></div>
				<div class="loadingTable" >
					<div class="subLoadingTable">
						<label>Cargando..</label>
						<div id="progressbar"></div>
					</div>
				</div>
			</div> -->
			<div class="small-12 columns">
				<a  href="#" class="button tiny"><i class="fa fa-user-plus"></i></a>
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
				<!-- <div class="divLoadingTable">
					<div class="bgLoadingTable"></div>
					<div class="loadingTable" >
						<div class="subLoadingTable">
							<label>Cargando..</label>
							<div id="progressbar"></div>
						</div>
					</div>
				</div> -->
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
	<div data-abide-error class="alert callout" style="display: none;">
    <p><i class="fi-alert"></i> Por favor rellene los campos Obligatorios(rojo).</p>
  </div>
	  <div class="row">
    <fieldset class="large-6 columns">
      <button class="button" type="submit" value="Submit">Submit</button>
    </fieldset>
    <fieldset class="large-6 columns">
      <button class="button" type="reset" value="Reset">Reset</button>
    </fieldset>
  </div>

</form>
	</div>
</div>
</div>

<script type="text/javascript" src="<?php echo base_url().JS; ?>contract.js"></script>