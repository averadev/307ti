<div class="row contentModal" id="contentModalPeople">
	
		<div id="tab-PGeneral" class="large-12 columns tab-modal" style="display:inline;">
			<!-- Datos personales -->
			<div class="row" id="alertValPeopleGeneral" style="display:inline;">
				<div class="small-12 columns">
					<!--<div data-alert class="alert-box alert" >-->
					<div class="callout alert">
						Please complete fields in red
					</div>
				</div>
			</div>
	
			<fieldset class="fieldset">
				<legend>Tour Information</legend>
				<!-- nombre-->
				<div class="row">
					<div class="small-12 large-3 columns">
						<label id="alertName" for="right-label" class="text-left">Name</label>
					</div>
					<div class="small-12 large-9 columns">
						<input type="text" id="textName" class="round general">
					</div>
				</div>
				<!-- segundo nombre-->
				<div class="row">
					<div class="small-12 large-3 columns">
						<label  for="idLocation" class="text-left">Location</label>
					</div>
					<div class="small-12 large-9 columns">
						<input type="text" id="idLocation" name="idLocation" class="round general">
					</div>
				</div>
				<!-- apellido paterno-->
				<div class="row">
					<div class="small-12 large-3 columns">
						<label  for="dateTour" class="text-left">Date</label>
					</div>
					<div class="small-12 large-9 columns">
						<input type="date" id="dateTour" name="dateTour" class="round general">
					</div>
				</div>
				<!-- tipo tour-->
				<div class="row">
					<div class="small-12 large-3 columns">
						<label  for="typeTour" class="text-left">Tour Type</label>
					</div>
					<div class="small-12 large-9 columns">
						<select id="typeTour" name="typeTour" class="input-group-field round"></select>
					</div>
				</div>
			</fieldset>
			<!-- Datos del domicilio -->
			<div class="row" id="alertValPeopleAddress" style="display:none;">
				<div class="small-12 columns">
					<div class="callout alert">
						Please complete fields in red
					</div>
				</div>
			</div>

		</div>
	</div>