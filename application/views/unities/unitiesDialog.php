<div class="large-12 columns">
    <div class="box">
        <div class="box-header pr-color">
                <div class="pull-right box-tools">
                    <span class="box-btn" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </span>
                </div>
                <h3 class="box-title">
                    <span>Add Unidades</span>
                </h3>
                <div class="pull-left box-tools">
                    <span data-widget="newContrat" id="newContract">
                        <span>( New )</span>
                    </span>
                </div>
        </div>
        <div class="box-body">
                <!-- Property-->
                <div class="row">
                    <div class="small-3 columns">
                        <label for="property" class="text-left">Property</label>
                    </div>
                    <div class="small-9 columns">
						<div class="caja" >
							<select type="text" id="property" name="property" class="input-group-field round" required></select>
						</div>
                    </div>
                </div>
                <!-- Unit Type-->
                <div class="row">
                    <div class="small-3 columns">
                        <label for="unitType" class="text-left">Unit Type</label>
                    </div>
                    <div class="small-9 columns">
						<div class="caja" >
                        <select type="text" id="unitType" name="unitType" class="input-group-field round" required></select>
						</div>
                    </div>
                </div>
                <!-- Frequency-->
                <div class="row">
                    <div class="small-3 columns">
                        <label for="frequency" class="text-left">Frequency</label>
                    </div>
                    <div class="small-9 columns">
						<div class="caja" >
                        <select type="text" id="frequency" name="frequency" class="input-group-field round" required></select>
						</div>
				   </div>
                </div>
                <!-- Season-->
                <div class="row">
                    <div class="small-3 columns">
                        <label for="season" class="text-left">Season</label>
                    </div>
                    <div class="small-9 columns">
						<div class="caja" >
                        <select type="text" id="season" name="season" class="input-group-field round" required></select>
						</div>
					</div>
                </div>
                <!-- interval-->
<!--                 <div class="row">
                    <div class="small-3 columns">
                        <label for="interval" class="text-left">Interval</label>
                    </div>
                    <div class="small-9 columns">
						<div class="caja" >
                        <select type="text" id="interval" name="interval" class="input-group-field round" required></select>
						</div>
				   </div>
                </div> -->
            <div class="row">
                <div class="large-12 columns">
					<a id="btngetUnidades" class="btn btn-primary btn-right">
						<div class="label">Buscar</div>
						<img src="<?php echo base_url().IMG; ?>common/BUSCAR.png"/>
					</a>
					<!--<a  id="btngetUnidades" href="#" class="button postfix"><i class="fa fa-search"></i></a>-->
                </div>
            </div>
        </div>
    </div>
</div>


<div class="large-12 columns">
    <div class="box">
        <div class="box-header pr-color">

        </div>
        <div class="box-body" style="display: block;">
            <div class=" table" >
                <table id="tblUnidades" style="width:100%;">
                    <thead id="Unidadesthead"></thead>
                    <tbody id="Unidadestbody"></tbody>
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
