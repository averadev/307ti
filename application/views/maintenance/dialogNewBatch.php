<fieldset class="fieldset">
	<div class="row">
		<div class="small-3 columns">
			<label class="text-left" for="legalName">Property</label>
		</div>
		<div class="small-9 columns"></div>
			<div class="caja" >
				<select id="NProperty" class="txtSearch input-group-field round">
					<?php
						foreach($MProperty as $item){?>
							<option value="<?php echo $item->ID; ?>"><?php echo $item->Description; ?></option><?php
						}?>
				</select>
			</div>
	</div>
	<div class="row">
		<div class="small-3 columns">
			<label class="text-left" for="legalName">Year</label>
		</div>
		<div class="small-9 columns"></div>
			<div class="caja" >
				<select id="NYears" class="txtSearch input-group-field round">
					<?php
						foreach($Years as $item){?>
							<option value="<?php echo $item->Year; ?>"><?php echo $item->Year; ?></option><?php
						}?>
				</select>
			</div>
	</div>
	<div class="row">
		<div class="small-3 columns">
			<label class="text-left" for="legalName">Sale Type</label>
		</div>
		<div class="small-9 columns"></div>
			<div class="caja" >
				<select id="NSaleType" class="txtSearch input-group-field round">
					<?php
						foreach($MSaleType as $item){?>
							<option value="<?php echo $item->ID; ?>"><?php echo $item->Description; ?></option><?php
						}?>
				</select>
			</div>
	</div>
	<div class="row">
		<div class="small-3 columns">
			<label class="text-left" for="legalName">Floor Plan</label>
		</div>
		<div class="small-9 columns"></div>
			<div class="caja" >
				<select id="NFloorPlan" class="txtSearch input-group-field round">
					<?php
						foreach($MFloorPlan as $item){?>
							<option value="<?php echo $item->ID; ?>"><?php echo $item->Description; ?></option><?php
						}?>
				</select>
			</div>
	</div>
	<div class="row">
		<div class="small-3 columns">
			<label class="text-left" for="legalName">Frequency</label>
		</div>
		<div class="small-9 columns"></div>
			<div class="caja" >
				<select id="NFrequency" class="txtSearch input-group-field round">
					<?php
						foreach($MFrequency as $item){?>
							<option value="<?php echo $item->ID; ?>"><?php echo $item->Description; ?></option><?php
						}?>
				</select>
			</div>
	</div>
	<div class="row">
		<div class="small-3 columns">
			<label class="text-left" for="legalName">Season</label>
		</div>
		<div class="small-9 columns"></div>
			<div class="caja" >
				<select id="NSeason" class="txtSearch input-group-field round">
					<?php
						foreach($MSeason as $item){?>
							<option value="<?php echo $item->ID; ?>"><?php echo $item->Description; ?></option><?php
						}?>
				</select>
			</div>
	</div>
</fieldset>



		