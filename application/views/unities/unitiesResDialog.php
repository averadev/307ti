<div class="large-12 columns">
    <div class="box">
        <div class="box-header pr-color">
                <div class="pull-right box-tools">
                    <span class="box-btn" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </span>
                </div>
                <h3 class="box-title">
                    <span>Add Units</span>
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
                        <label for="propertyRes" class="text-left">Property</label>
                    </div>
                    <div class="small-9 columns">
						<div class="caja" >
							<select type="text" id="propertyRes" name="propertyRes" class="input-group-field round" required></select>
						</div>
                    </div>
                </div>
				<!-- Guests -->
				<div class="row">
					<!-- Guest Adult -->
					<div class="small-12 large-6 columns">
						<label for="guestsAdultRes" class="text-left">Guests Adult
							<div class="caja" >
								<select id="guestsAdultRes" name="guestsAdultRes" class="input-group-field round" required>
									<option value="0">Choose an option</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
								</select>
							</div>
						</label>
					</div>
					<!-- Guest Child -->
					<div class="small-12 large-6 columns">
						<label for="guestChildRes" class="text-left">Guests Child
							<div class="caja" >
								<select id="guestChildRes" name="guestChildRes" class="input-group-field round" required >
									<option value="0">Choose an option</option>
									<option value="1">1</option>
									<option value="2">2</option>
								</select>
							</div>
						</label>
					</div>	
				</div>
				<!-- date time -->
				<div class="row" id="DatesUnitRes">
					<!-- From Date -->
					<div class="small-12 large-6 columns">
						<label for="fromDateUnitRes" class="text-left">Arrival Date
							<div class="input-group date" >
								<span  class="input-group-label prefix"><i class="fa fa-calendar"></i></span>
								<input type="text" id="fromDateUnitRes" name="fromDateUnitRes" class="input-group-field roundRight" readonly required />
							</div>
						</label>
					</div>
					
					<!-- To Date -->
					<div class="small-12 large-6 columns">
						<label for="toDateUnitRes" class="text-left">Departure Date
							<div class="input-group date" >
								<span  class="input-group-label prefix"><i class="fa fa-calendar"></i></span>
								<input type="text" id="toDateUnitRes" name="toDateUnitRes" class="input-group-field roundRight" readonly required />
							</div>
						</label>
					</div>
				</div>
				<!--  -->
				<div class="row">
					<!-- Floor Plan -->
					<div class="small-12 large-6 columns">
						<label for="floorPlanUnitRes" class="text-left">Floor Plan
							<div class="caja" >
								<select id="floorPlanUnitRes" name="floorPlanUnitRes" class="input-group-field round" required>
									<option value="0">Choose an option</option>
								</select>
							</div>
						</label>
					</div>
					<!-- Guest Child -->
					<div class="small-12 large-6 columns">
						<label for="viewUnitRes" class="text-left">View
							<div class="caja" >
								<select id="viewUnitRes" name="viewUnitRes" class="input-group-field round" required >
									<option value="0">Choose an option</option>
								</select>
							</div>
						</label>
					</div>	
				</div>
            <div class="row">
                <div class="large-12 columns">
					<a id="btnGetUnidadesRes" class="btn btn-primary btn-right">
						<div class="label">Search</div>
						<img src="<?php echo base_url().IMG; ?>common/BUSCAR.png"/>
					</a>
					<!--<a  id="btnGetUnidadesRes" href="#" class="button postfix"><i class="fa fa-search"></i></a>-->
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
                <table id="tblUnidadesRes" style="width:100%;">
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
