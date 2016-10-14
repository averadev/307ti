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
	<div class="row">
		<a id="btnSearchContracts" class="btn btn-primary btn-Search float-right">
				<div class="label">Search</div>
				<img src="<?php echo base_url().IMG; ?>common/BUSCAR.png"/>
			</a>
	</div>
	
</fieldset>
			<fieldset class="fieldset" id="fieldsetNoteCon">
				<div class="containerContract">
					<div class="row">
						<table id="tablaSearcBatchs" width="100%">
							<thead>
								<tr class="trColspan" >
									<th colspan="12" class="thColspan colorCrema" >Detail</th>
								</tr> 
								<tr>
									<th class="cellEdit">ContractID</th>
									<th class="cellGeneral">Contract Num</th>
									<th class="cellGeneral">Legal Name</th>
									<th class="cellGeneral">FloorPlan</th>
									<th class="cellGeneral">Frequency</th>
									<th class="cellGeneral">Status</th>
									<th class="cellGeneral">CrDt</th>
									<th class="cellGeneral">FirstOccYear</th>
									<th class="cellGeneral">LastOccYear</th>
									<th class="cellGeneral">Unit Price</th>
									<th class="cellGeneral">Maintenance Price</th>
								</tr>
							</thead>
							<tbody id="tablaSearcBatchsBody">
							</tbody>
						</table>
					</div>
				</div>
			</fieldset>



		