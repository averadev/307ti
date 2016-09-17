
<!-- contenido del modal -->
<div class="contentModal" id="section-HKC">
	<div id="tab-HKGeneral" class="large-12 columns tab-modal" style="display:inline;">
		<!-- Error Message -->
		<div class="row" id="alertValidateContrato" style="display:none;">
			<div class="small-12 columns">
				<div data-alert class="alert-box alert " >
					Por favor rellene los campos Obligatorios(rojo)
				</div>
			</div>
		</div>
		<form id="formHKConfig" data-abide='ajax'>
			<!-- people -->
			<div class="fieldset large-12 columns">
				<legend>Section</legend>
				<div class="row">
                    <div class="small-3 columns">
                        <label for="legalSectionHKC" class="text-left">Section</label>
                    </div>
                    <div class="small-9 columns">
                        <input type="text" id="textSectionHKC" name="sectionHKC" class="round general" required>
						<small class="error hidden">please enter the section.</small>
                    </div>
                </div>
				<div class="row">
                    <div class="small-3 columns">
                        <label for="legalServiceTypeHKC" class="text-left">Service Type</label>
                    </div>
                    <div class="small-9 columns">
						<div class="caja" >
							<select type="text" id="SltServiceTypeHKC" name="ServiceTypeHKC" class="input-group-field round"></select>
						</div>
						<small class="error hidden">please select a service type.</small>
                    </div>
                </div>
			</div>
			<!-- maind -->
			<div class="fieldset large-12 columns">
                <legend>People maid</legend>

                <div class="containerPeopleHKC">
                    <div class="row">
                        <div class="small-12 columns">
                            <!--<a id="btnAddPeople" href="#" class="button tiny"><i class="fa fa-user-plus"></i></a>-->
							<a id="btnAddPeopleHKCMaid" class="btn btn-primary spanSelect">
								<div class="label">Add</div>
								<img src="<?php echo base_url().IMG; ?>common/more.png"/>
							</a>
                        </div>
                        <div class="small-12 columns">
                            <table id="tablePeopleMaidSelectedHKC" width="100%">
                                <thead>
									<tr>
										<th class="cellEdit" >ID</th>
										<th class="cellGeneral">Name</th>
										<th class="cellGeneral">Last name</th>
										<th></th>
									</tr>
								</thead>
                                <tbody>
									<tr class="rowSpace"><td colspan="10" ></td></tr>
								</tbody>
							</table>
							<small class="error hidden">please select a pleople maid.</small>
                        </div>
                    </div>
                </div>
            </div>
			<!-- superior -->
			<div class="fieldset large-12 columns">
                <legend>People superior</legend>

                <div class="containerPeopleHKC">
                    <div class="row">
                        <div class="small-12 columns">
                            <!--<a id="btnAddPeople" href="#" class="button tiny"><i class="fa fa-user-plus"></i></a>-->
							<a id="btnAddPeopleHKCSupe" class="btn btn-primary spanSelect">
								<div class="label">Add</div>
								<img src="<?php echo base_url().IMG; ?>common/more.png"/>
							</a>
                        </div>
                        <div class="small-12 columns">
                            <table id="tablePeopleSupeSelectedHKC" width="100%">
                                <thead>
									<tr>
										<th class="cellEdit" >ID</th>
										<th class="cellGeneral">Name</th>
										<th class="cellGeneral">Last name</th>
										<th></th>
									</tr>
								</thead>
                                <tbody>
									<tr class="rowSpace"><td colspan="10" ></td></tr>
								</tbody>
							</table>
							<small class="error hidden">please select a pleople superior.</small>
                        </div>
                    </div>
                </div>
            </div>
			
			<!-- Unidades -->
            <div class="fieldset large-12 columns" id="unitHKConfig">
                <legend class="">Units</legend>
                <div class="containerPeople">
                    <div class="row">
                        <div class="small-12 columns">
                            <!--<a id="btnAddUnidades" href="#" class="button tiny"><i class="fa fa-home"></i></a>-->
							<a id="btnAddUnitHKC" class="btn btn-primary spanSelect">
								<div class="label">Add</div>
								<img src="<?php echo base_url().IMG; ?>common/more.png"/>
							</a>
                        </div>
                        <div class="small-12 columns table-section2">
                            <table id="tableUnitsSelectedHKC" width="100%">
                                <thead>
                                    <tr>
										<th class="cellEdit" >id</th>
                                        <th class="cellEdit" >Code</th>
                                        <th class="cellGeneral">FloorPlanDesc</th>
                                        <th class="cellGeneral">PropertyName</th>
                                        <th class="cellGeneral"></th>
                                    </tr>
                                </thead>
								<tbody>
									<tr class="rowSpace"><td colspan="10" ></td></tr>
								</tbody>
                            </table>
							<small class="error hidden">please select 1 unit.</small>
                        </div>
                    </div>
                </div>
            </div>
			
		</form>
	</div>
</div>
<script>
   /* $('#btnAddTourID').click(function(){
        ajaxHTML('dialog-tourID', 'tours/modal');
        showModals('dialog-tourID', cleanAddPeople);
    });
    $('#btnAddPeople').click(function(){
        $('#dialog-People').empty();
        ajaxHTML('dialog-People', 'people/');
        showModals('dialog-People', cleanAddPeople);
    });
    $('#btnAddUnidades').click(function(){
        ajaxHTML('dialog-Unidades', 'contract/modalUnidades');
        showModals('dialog-Unidades', cleanAddUnidades);
    });*/

</script>