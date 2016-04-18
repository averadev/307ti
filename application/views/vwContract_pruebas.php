<div class="row section">
	<div class="large-12 columns">
		<div class="box">
			<div class="box-header blue_divina">
				<div class="pull-right box-tools">
					<span class="box-btn" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</span>
               </div>
               <h3 class="box-title">
               	<span>Contract Search</span>
               </h3>
				<div class="pull-left box-tools">
					<span data-widget="newContrat" id="newContract">
						<img src="http://www.pms.307ti.com/Scripts/ext/images/icons/contract.png" alt="">
						<span>New</span>
					</span>
				</div>
<!--				<i id="newContract" class="fa fa-file-text-o"></i>-->
			</div>
			<div class="box-body" style="display: block;">
				<div class="row">
					  <fieldset class="large-6 columns">
					    <legend>Elige un filtro</legend>
					    <input type="radio" name="filtro_contrato" value="personaId" id="personaId" required><label for="personaId">Persona ID</label>
					    <input checked type="radio" name="filtro_contrato" value="nombre" id="nombre"><label for="nombre">Nombre</label>
					    <input type="radio" name="filtro_contrato" value="apellido" id="apellido"><label for="apellido">Apellido</label>
					    <input type="radio" name="filtro_contrato" value="reservacionId" id="reservacionId"><label for="reservacionId">Reservación ID</label>
					  </fieldset>
					  <fieldset class="large-6 columns">
					  	<legend>Select Period</legend>
					    <div class="row">
							<div class="medium-6 columns">
						        <input id="startDate" class="round" type="date" placeholder="Fecha Inicial">
						    </div>
						    <div class="medium-6 columns">
						    <input id="endDate" class="round" type="date"  placeholder="Fecha final">
						    </div>
  						</div>
					  </fieldset>
				</div>
				<div class="row">
					<div class="medium-6 columns">
					<fieldset>
						<legend><input id="busquedaAvanazada" type="checkbox">Advanced search</legend>

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
						          <input id="stringContrat" type="text" class="txtSearch" placeholder="Search Field" name="search"  required="">
						        </div>
						        <div class="small-1 columns">
						          <a  id="btnfind" href="#" class="button postfix"><i class="fa fa-search"></i></a>
						        </div>
						         <div class="small-1 columns">
						          <a id="btnCleanWord"  href="#" class="button postfix"><i class="fa fa-trash"></i></a>
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
               </div>
               <h3 class="box-title">
               	<span>Contracts Relation</span>
               </h3>
			</div>
			<div class="box-body" style="display: block;">
				<div class=" table" >
					<table id="tblContrat" style="width:100%;">
						<thead id="tblContratoshead">
						</thead>
						<tbody id="tblContratosbody"></tbody>
					</table>
				</div>
				<div class="pagina" >
					<div class="pages">
						<div class="pagination" id="paginationPeople">
							<a href="#" class="first" data-action="first">&laquo;</a>
							<a href="#" class="previous" data-action="previous">&lsaquo;</a>
							<input type="text" class="general" readonly="readonly" />
							<a href="#" class="next" data-action="next">&rsaquo;</a>
							<a href="#" class="last" data-action="last">&raquo;</a>
						</div>
						<input type="hidden" id="paginationPeople" value="true" />
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>

<div id="dialog-Contract" title="Create Contract" style="display: none;">
	<div class="contentModal">
		<div id="tabs-1">
		<!-- Error Message -->
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
				Contract Data
			</legend>
		<!-- Legal name-->
		<div class="row">
			<div class="small-3 columns">
					<label for="legalName" class="text-left">Legal Name</label>
			</div>
			<div class="small-9 columns">
				<input type="text" id="legalName" name="legalName" class="general" required>
			</div>
		</div>
		<!-- Language-->
		<div class="row">
			<div class="small-3 columns">
				<label id="alertLastName" for="right-label" class="text-left">Language</label>
			</div>
			<div class="small-9 columns">
				<select id="selectLanguage" form="saveDataContract" required="">
<!--      			<option></option>-->
<!--					<option value="espanol">Español</option>-->
<!--					<option value="ingles">Ingles</option>-->
				</select>

			</div>
		</div>
		<!-- Tour ID-->
	  <div class="row">
	  <div class="small-3 columns">
				<label for="right-label" class="text-left">Tour ID</label>
		</div>
	    <div class="large-9 columns">
	      <div class="row collapse">
	        <div class="small-10 columns">
	          <input type="text" placeholder="ID" name="TourID" id="TourID" required>
	        </div>
	        <div class="small-2 columns">
	          <a id="btnAddTourID" href="#" class="button postfix">Add</a>
	        </div>
	      </div>
	    </div>
	  </div>

		<div class="containerPeople">
		<div class="row">
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
					<th></th>
				</tr>
			</thead>
			<tbody>
                <tr>
                    <td>23</td>
                    <td>Faustino</td>
                    <td>Loeza</td>
                    <td>Cancun</td>
                    <td><input type="radio" name="people" value="1"></td>
                    <td><input type="radio" name="people" value="2"></td>
                    <td><input type="radio" name="people" value="3"></td>
                    <td><button type="button" class="alert button"><i class="fa fa-minus-circle fa-lg" aria-hidden="true"></i></button></td>
                </tr>
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
                    <th></th>
				</tr>
			</thead>
			<tbody>
            <tr>
                <td>sds5d5</td>
                <td>PArgo 1 3Rec</td>
                <td>$38,000.00</td>
                <td>#1</td>
                <td>2016</td>
                <td><input type="radio" name="people" value="2"></td>
                <td><input type="radio" name="people" value="3"></td>
                <td><button type="button" class="alert button"><i class="fa fa-minus-circle fa-lg" aria-hidden="true"></i></button></td>
            </tr>
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
					<select id="typeSales">
	      			
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
    <p><i class="fi-alert"></i> please fill required fields (red).</p>
  </div>

</form>
	</div>
</div>
</div>


<div id="dialog-tourID" title="Tour ID" style="display: none;">
    <div class="large-12 columns">
        <div class="box">
            <div class="box-header green">
                <div class="pull-right box-tools">
					<span class="box-btn" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</span>
                </div>
                <h3 class="box-title">
                    <span>Add Tour ID</span>
                </h3>
                <div class="pull-left box-tools">
					<span data-widget="newContrat" id="newContract">
						<img src="http://www.pms.307ti.com/Scripts/ext/images/icons/contract.png" alt="">
						<span>New</span>
					</span>
                </div>
            </div>
            <div class="box-body" style="display: block;">
                <div class="row">
                    <fieldset class="large-6 columns">
                        <legend>Elige un filtro</legend>
                        <input type="radio" name="filtro_contrato" value="personaId" id="personaId" required><label for="personaId">Persona ID</label>
                        <input checked type="radio" name="filtro_contrato" value="nombre" id="nombre"><label for="nombre">Nombre</label>
                        <input type="radio" name="filtro_contrato" value="apellido" id="apellido"><label for="apellido">Apellido</label>
                        <input type="radio" name="filtro_contrato" value="reservacionId" id="reservacionId"><label for="reservacionId">Reservación ID</label>
                    </fieldset>
                    <fieldset class="large-6 columns">
                        <legend>Select Period</legend>
                        <div class="row">
                            <div class="medium-6 columns">
                                <input id="startDate" class="round" type="date" placeholder="Fecha Inicial">
                            </div>
                            <div class="medium-6 columns">
                                <input id="endDate" class="round" type="date"  placeholder="Fecha final">
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="row">
                    <div class="medium-6 columns">
                        <fieldset>
                            <legend><input id="busquedaAvanazada" type="checkbox">Advanced search</legend>

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
                                        <input id="stringContrat" type="text" class="txtSearch" placeholder="Search Field" name="search"  required="">
                                    </div>
                                    <div class="small-1 columns">
                                        <a  id="btnfind" href="#" class="button postfix"><i class="fa fa-search"></i></a>
                                    </div>
                                    <div class="small-1 columns">
                                        <a id="btnCleanWord"  href="#" class="button postfix"><i class="fa fa-trash"></i></a>
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
                </div>
                <h3 class="box-title">
                    <span>Contracts Relation</span>
                </h3>
            </div>
            <div class="box-body" style="display: block;">
                <div class=" table" >
                    <table id="tblContrat" style="width:100%;">
                        <thead id="tblContratoshead">
                        </thead>
                        <tbody id="tblContratosbody"></tbody>
                    </table>
                </div>
                <div class="pagina" >
                    <div class="pages">
                        <div class="pagination" id="paginationPeople">
                            <a href="#" class="first" data-action="first">&laquo;</a>
                            <a href="#" class="previous" data-action="previous">&lsaquo;</a>
                            <input type="text" class="general" readonly="readonly" />
                            <a href="#" class="next" data-action="next">&rsaquo;</a>
                            <a href="#" class="last" data-action="last">&raquo;</a>
                        </div>
                        <input type="hidden" id="paginationPeople" value="true" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="dialog-Personas" title="People" style="display: none;">
    <div class="large-12 columns">
        <div class="box">
            <div class="box-header green">
                <div class="pull-right box-tools">
					<span class="box-btn" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</span>
                </div>
                <h3 class="box-title">
                    <span>Add People</span>
                </h3>
                <div class="pull-left box-tools">
					<span data-widget="newContrat" id="newContract">
						<img src="http://www.pms.307ti.com/Scripts/ext/images/icons/contract.png" alt="">
						<span>New</span>
					</span>
                </div>
            </div>
            <div class="box-body" style="display: block;">
                <div class="row">
                    <fieldset class="large-6 columns">
                        <legend>Elige un filtro</legend>
                        <input type="radio" name="filtro_contrato" value="personaId" id="personaId" required><label for="personaId">Persona ID</label>
                        <input checked type="radio" name="filtro_contrato" value="nombre" id="nombre"><label for="nombre">Nombre</label>
                        <input type="radio" name="filtro_contrato" value="apellido" id="apellido"><label for="apellido">Apellido</label>
                        <input type="radio" name="filtro_contrato" value="reservacionId" id="reservacionId"><label for="reservacionId">Reservación ID</label>
                    </fieldset>
                    <fieldset class="large-6 columns">
                        <legend>Select Period</legend>
                        <div class="row">
                            <div class="medium-6 columns">
                                <input id="startDate" class="round" type="date" placeholder="Fecha Inicial">
                            </div>
                            <div class="medium-6 columns">
                                <input id="endDate" class="round" type="date"  placeholder="Fecha final">
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="row">
                    <div class="medium-6 columns">
                        <fieldset>
                            <legend><input id="busquedaAvanazada" type="checkbox">Advanced search</legend>

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
                                        <input id="stringContrat" type="text" class="txtSearch" placeholder="Search Field" name="search"  required="">
                                    </div>
                                    <div class="small-1 columns">
                                        <a  id="btnfind" href="#" class="button postfix"><i class="fa fa-search"></i></a>
                                    </div>
                                    <div class="small-1 columns">
                                        <a id="btnCleanWord"  href="#" class="button postfix"><i class="fa fa-trash"></i></a>
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

            </div>
            <div class="box-body" style="display: block;">
                <div class=" table" >
                    <table id="tblContrat" style="width:100%;">
                        <thead id="tblContratoshead">
                        </thead>
                        <tbody id="tblContratosbody"></tbody>
                    </table>
                </div>
                <div class="pagina" >
                    <div class="pages">
                        <div class="pagination" id="paginationPeople">
                            <a href="#" class="first" data-action="first">&laquo;</a>
                            <a href="#" class="previous" data-action="previous">&lsaquo;</a>
                            <input type="text" class="general" readonly="readonly" />
                            <a href="#" class="next" data-action="next">&rsaquo;</a>
                            <a href="#" class="last" data-action="last">&raquo;</a>
                        </div>
                        <input type="hidden" id="paginationPeople" value="true" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="dialog-Unidades" title="Unidades" style="display: none;">
    <div class="large-12 columns">
        <div class="box">
            <div class="box-header green">
                <div class="pull-right box-tools">
					<span class="box-btn" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</span>
                </div>
                <h3 class="box-title">
                    <span>Add Unidades</span>
                </h3>
            </div>
            <div class="box-body" style="display: block;">
                <div class="row">
                    <fieldset class="large-6 columns">
                        <legend>Elige un filtro</legend>
                        <input type="radio" name="filtro_contrato" value="personaId" id="personaId" required><label for="personaId">Persona ID</label>
                        <input checked type="radio" name="filtro_contrato" value="nombre" id="nombre"><label for="nombre">Nombre</label>
                        <input type="radio" name="filtro_contrato" value="apellido" id="apellido"><label for="apellido">Apellido</label>
                        <input type="radio" name="filtro_contrato" value="reservacionId" id="reservacionId"><label for="reservacionId">Reservación ID</label>
                    </fieldset>
                    <fieldset class="large-6 columns">
                        <legend>Select Period</legend>
                        <div class="row">
                            <div class="medium-6 columns">
                                <input id="startDate" class="round" type="date" placeholder="Fecha Inicial">
                            </div>
                            <div class="medium-6 columns">
                                <input id="endDate" class="round" type="date"  placeholder="Fecha final">
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="row">
                    <div class="medium-6 columns">
                        <fieldset>
                            <legend><input id="busquedaAvanazada" type="checkbox">Advanced search</legend>

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
                                        <input id="stringContrat" type="text" class="txtSearch" placeholder="Search Field" name="search"  required="">
                                    </div>
                                    <div class="small-1 columns">
                                        <a  id="btnfind" href="#" class="button postfix"><i class="fa fa-search"></i></a>
                                    </div>
                                    <div class="small-1 columns">
                                        <a id="btnCleanWord"  href="#" class="button postfix"><i class="fa fa-trash"></i></a>
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

            </div>
            <div class="box-body" style="display: block;">
                <div class=" table" >
                    <table id="tblContrat" style="width:100%;">
                        <thead id="tblContratoshead">
                        </thead>
                        <tbody id="tblContratosbody"></tbody>
                    </table>
                </div>
                <div class="pagina" >
                    <div class="pages">
                        <div class="pagination" id="paginationPeople">
                            <a href="#" class="first" data-action="first">&laquo;</a>
                            <a href="#" class="previous" data-action="previous">&lsaquo;</a>
                            <input type="text" class="general" readonly="readonly" />
                            <a href="#" class="next" data-action="next">&rsaquo;</a>
                            <a href="#" class="last" data-action="last">&raquo;</a>
                        </div>
                        <input type="hidden" id="paginationPeople" value="true" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url().JS; ?>contract.js"></script>