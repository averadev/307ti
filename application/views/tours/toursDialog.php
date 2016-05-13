<div class="row section" id="section-tour">
<div class="large-12 columns">
        <div class="box">
            <div class="box-header pr-color">
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
						<span>( New )</span>
					</span>
                </div>
            </div>
            <div class="box-body box-filter">
                <div class="row">
					<div class="small-12 medium-12 large-12 columns">
						<fieldset class="large-12 columns fieldsetFilter">
							<legend class="legendSearch">Choose a filter</legend>
							<div class="rdoField">
								<input type="checkbox" name="filter_tourID" value="personaId" id="personaIdTour" required>
								<label for="personaIdTour">Persona ID</label>
							</div>
							<div class="rdoField">
								<input checked type="checkbox" name="filter_tourID" value="nombre" id="nombreTour">
								<label for="nombreTour">Nombre</label>
							</div>
							<div class="rdoField">
								<input type="checkbox" name="filter_tourID" value="apellido" id="apellidoTour">
								<label for="apellidoTour">Apellido</label>
							</div>
							<div class="rdoField">
								<input type="checkbox" name="filter_tourID" value="reservacionIdTour" id="reservacionId">
								<label for="reservacionIdTour">Reservación ID</label>
							</div>
						</fieldset>
					</div>
					<div class="small-12 medium-12 large-12 columns">
						<fieldset class="large-12 columns fieldsetFilter">
							<!--<legend><input id="advanceSearchTour" type="checkbox">
							<label for="advanceSearchTour">&nbsp;&nbsp;Advanced search</label>
							</legend>-->
							<div class="rdoField">
								<input type="checkbox" id="advanceSearchTour" class="checkFilter">
								<label for="advanceSearchTour">Advanced search</label>
							</div>
                            <div class="filtersAdvanced" id="advanceTour" style="display: none;">
								<div class="rdoField">
									<input type="checkbox" name="filter_tourID" value="codEmpleadoTour" id="codEmpleadoTour" required>
									<label for="codEmpleadoTour">Codigo de Empleado</label>
								</div>
								<div class="rdoField">
									<input type="checkbox" name="filter_tourID" value="folioTour" id="folioTour">
									<label for="folioTour">Folio</label>
								</div>
								<div class="rdoField">
									<input type="checkbox" name="filter_tourID" value="unidadTour" id="unidadTour">
									<label for="unidadTour">Unidad ID</label>
								</div>
								<div class="rdoField">
									<input type="checkbox" name="filter_tourID" value="emailTour" id="emailTour">
									<label for="email">Email</label>
								</div>
								<div class="rdoField">
									<input type="checkbox" name="filter_tourID" value="contratoTour" id="contratoTour">
									<label for="contratoTour">Contrato ID</label>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="small-12 medium-12 large-12 columns">
						<fieldset class="large-12 columns">
							<legend>Select Period</legend>
							<div class="row">
								<div class="medium-3 columns">
									<input id="startDateTour" class="round" type="date" placeholder="Start Date">
								</div>
								<div class="medium-3 columns">
									<input id="endDateTour" class="round" type="date"  placeholder="End Date">
								</div>
								<div class="medium-3 columns">
									<input id="stringTour" type="text" class="txtSearch" placeholder="Search Field" name="search"  required="">
								</div>
								<div class="medium-3 columns ">
									<a id="btnfindTour" class="btn btn-primary"><i class="fa fa-search"></i>&nbsp;&nbsp;Buscar</a>
									<a id="btnCleanWordTour"  href="#" class="btn btn-primary"><i class="fa fa-trash"></i>&nbsp;&nbsp;Eliminar</a>
								</div>
							</div>
						</fieldset>
					</div>
                    <!--<fieldset class="large-6 columns">
                        <legend>Select Period</legend>
                        <div class="row">
                            <div class="medium-6 columns">
                                <input id="startDateTour" class="round" type="date" placeholder="Start Date">
                            </div>
                            <div class="medium-6 columns">
                                <input id="endDateTour" class="round" type="date"  placeholder="End Date">
                            </div>
                        </div>
                    </fieldset>-->
                </div>
                <!--<div class="row">
                    <div class="medium-6 columns">
                        <fieldset>
                            <legend><input id="advanceSearchTour" type="checkbox">
							<label for="advanceSearchTour">&nbsp;&nbsp;Advanced search</label>
							</legend>

                            <div class="row" id="advanceTour" style="display: none;">
                                <div class="large-12 columns slide">
                                    <input type="checkbox" name="filter_tourID" value="codEmpleadoTour" id="codEmpleadoTour" required><label for="codEmpleadoTour">Codigo de Empleado</label>
                                    <input type="checkbox" name="filter_tourID" value="folioTour" id="folioTour"><label for="folioTour">Folio</label>
                                    <input type="checkbox" name="filter_tourID" value="unidadTour" id="unidadTour"><label for="unidadTour">Unidad ID</label>
                                    <input type="checkbox" name="filter_tourID" value="emailTour" id="emailTour"><label for="email">Email</label>
                                    <input type="checkbox" name="filter_tourID" value="contratoTour" id="contratoTour"><label for="contratoTour">Contrato ID</label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="medium-6 columns">
                        <div class="row">
                            <div class="large-12 columns">
                                <div class="row collapse">
                                    <div class="small-10 columns">
                                        <input id="stringTour" type="text" class="txtSearch" placeholder="Search Field" name="search"  required="">
                                    </div>
                                    <div class="small-1 columns">
                                        <a  id="btnfindTour" href="#" class="button postfix"><i class="fa fa-search"></i></a>
                                    </div>
                                    <div class="small-1 columns">
                                        <a id="btnCleanWordTour"  href="#" class="button postfix"><i class="fa fa-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
            </div>
        </div>
    </div>


    <div class="large-12 columns">
        <div class="box">
            <div class="box-header pr-color">
                <div class="pull-right box-tools">
                </div>
                <h3 class="box-title">
                    <span>Tours Relation</span>
                </h3>
            </div>
            <div class="box-body" style="display: block;">
                <div class=" table" >
                    <table id="tours" style="width:100%;">
                        <thead id="toursthead">
                        </thead>
                        <tbody id="tourstbody"></tbody>
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

<script type="text/javascript" src="<?php echo base_url().JS; ?>tours.js"></script>