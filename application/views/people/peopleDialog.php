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
						<img src="http://www.pms.307ti.com/Scripts/ext/images/icons/user_add.gif" alt="">
						<span>New</span>
					</span>
            </div>
        </div>
        <div class="box-body" style="display: block;">
            <div class="row">
                <fieldset class="large-6 columns">
                    <legend>Elige un filtro</legend>
                    <input type="radio" name="filter_people" value="personaId" id="personaId" required><label for="personaId">Persona ID</label>
                    <input checked type="radio" name="filter_people" value="nombre" id="nombre"><label for="nombre">Nombre</label>
                    <input type="radio" name="filter_people" value="apellido" id="apellido"><label for="apellido">Apellido</label>
                    <input type="radio" name="filter_people" value="reservacionId" id="reservacionId"><label for="reservacionId">Reservación ID</label>
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
                                <input type="radio" name="filter_people" value="codEmpleado" id="codEmpleado" required><label for="codEmpleado">Codigo de Empleado</label>
                                <input type="radio" name="filter_people" value="folio" id="folio"><label for="folio">Folio</label>
                                <input type="radio" name="filter_people" value="unidad" id="unidad"><label for="unidad">Unidad ID</label>
                                <input type="radio" name="filter_people" value="email" id="email"><label for="email">Email</label>
                                <input type="radio" name="filter_people" value="contrato" id="contrato"><label for="contrato">Contrato ID</label>
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
            <div class="table" >
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
<script>
    
</script>