<div class="row section" id="section-unitsHKC">
	<div class="large-12 columns">
		<div class="box" relation-attr="box-unitsHKC-relation">
			<div class="box-header pr-color">
					<div class="pull-right box-tools">
						<span class="box-btn" data-widget="collapse">
							<i class="fa fa-minus"></i>
						</span>
					</div>
					<h3 class="box-title">
						<span>Add unities</span>
					</h3>
			</div>
			<div class="box-body">
				
				<div class="row">
					<!-- Property-->
					<div class="small-12 large-6 columns">
						<label for="property" class="text-left">Property
							<div class="caja" >
								<select type="text" id="propertyHKC" name="property" class="input-group-field round comboHKC" required></select>
							</div>
						</label>
					</div>
					<!-- Unit Type -->
					<div class="small-12 large-6 columns">
						<label for="unitType" class="text-left">Floor Plan
							<div class="caja" >
								<select type="text" id="unitTypeHKC" name="unitType" class="input-group-field round comboHKC" required></select>
							</div>
						</label>
					</div>
				</div>
				
				<div class="row">
					<div class="small-12 large-8 columns">
						<input type="search" id="searchUnitHKC" class="round general" />
					</div>
					<div class="small-12 large-4 columns">
						<a id="btnGetUnities" class="btn btn-primary">
							<div class="label">Buscar</div>
							<img src="<?php echo base_url().IMG; ?>common/BUSCAR.png"/>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="large-12 columns">
		<div class="box" id="box-unitsHKC-relation">
			<div class="box-header pr-color">
				<h3 class="box-title">
					<span>Units Relation</span>
				</h3>
			</div>
			<div class="box-body" id="table-unitsHKC" style="display: block;">
				<div class=" table" >
					<table id="tblUnitHKC" style="width:100%;">
						<thead id="Unidadesthead"></thead>
						<tbody id="Unidadestbody"></tbody>
					</table>
				</div>
				<div class="pagina" >
					<div class="pages">
						<div class="pagination" id="paginationUnitHKC">
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