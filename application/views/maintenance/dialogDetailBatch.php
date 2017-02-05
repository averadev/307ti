<div class="contentModalHeader">

<!-- tabs de los modales -->
<div class="tabsModal">
	<ul class="tabs" id="tabsDetailBatch">
		<li class="tabs-title" attr-screen="tab-DetailBatch" >
			<a>General</a>
		</li>
		<li class="tabs-title active" attr-screen="tab-Maintenance">
			<a>Maintenance</a>
		</li>
	</ul>
</div>
</div>
<!-- contenido del modal -->
<div class="contentModal" id="ContenidoModalContractEdit">
	
	<div id="tab-DetailBatch" class="large-12 columns tab-modal" style="display:none;">
		<!-- Error Message -->
		<div class="row" id="alertValidateContrato" style="display:none;">
			<div class="small-12 columns">
				<div data-alert class="alert-box alert " >
					 Please fill required fields(red)
				</div>
			</div>
		</div>
			<fieldset class="fieldset">
				<legend>
					Details
				</legend>
				<div class="containerContract">
					<div class="row" id="editTermsOfSale">
					<table class="tableAccountResult">
						<thead>
							<tr class="trColspan">
								<th colspan="4" class="colorCrema">Results</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Batch ID:</td>
								<td id="cventaPrice"><?= $Batch[0]->ID;?></td>
								<td>Property:</td>
								<td id="cventaWeeks"><?= $Batch[0]->Property;?></td>
							</tr>
							<tr>
								<td>BatchType:</td>
								<td id="cventaPackR"><?= $Batch[0]->BatchType;?></td>
								<td>Records Num:</td>
								<td id="cventaSalePrice"><?= $Batch[0]->Total;?></td>
							</tr>
							<tr>
								<td>Description:</td>
								<td id="cventaHitch"><?= $Batch[0]->BatchDesc;?></td>
								<td>Maintenace Year:</td>
								<td id="cventaTransferA"><?= $Batch[0]->Year;?></td>
							</tr>
							<tr>
								<td>Status:</td>
								<td id="cventaHitch"><?= $Batch[0]->StatusDesc;?></td>
								<td>Total Amount:</td>
								<td id="cventaTransferA">$ <?= number_format((float)$Batch[0]->TotalAmount, 2, '.', '');?></td>
								
							</tr>
							<tr>
								<td>YnActive:</td>
								<td id="cventaHitch"><?= $Batch[0]->ynActive;?></td>
								<td>CrDt:</td>
								<td id="cventaTransferA"><?= $Batch[0]->CrDt;?></td>
							</tr>
							<tr>
								<td>CrBy:</td>
								<td id="cventaHitch"><?= $Batch[0]->CreateBy;?></td>
								<td>MdDt:</td>
								<td id="cventaTransferA"><?= $Batch[0]->MdDt;?></td>
							</tr>
							<tr>
								<td>Due Date:</td>
								<td id="cventaHitch"><?= $Batch[0]->DueDate;?></td>
							</tr>
						</tbody>
					</table>
				</div>
				</div>
			</fieldset>
			<?php if($statusBatch != 21 && $statusBatch != 6){?>
			<div id="botonesBatch">
				<a data-widget="postBatch" id="postBatch" class="btn btn-primary">
					<div class="label">Post Batch</div>
				</a>
				<a data-widget="cancelBatch" id="cancelBatch" class="btn btn-primary">
					<div class="label">Cancel Batch</div>
				</a>
			</div>
				
			<?php }; ?>
				
	</div>
	<!-- tabs notas -->
	<div id="tab-Maintenance" class="large-12 columns tab-modal" style="display:inline-block;">
	<div class="large-12 columns fiter-section">
		<div class="box" id="boxMaintenanceSearch" relation-attr="box-Maintenance-relation" >
			<!-- body search-->
			<fieldset class="fieldset">
				<legend>
					Details
				</legend>
				<div class="containerContract">
					<div class="row" id="editTermsOfSale">
					<table class="tableAccountResult">
						<thead>
							<tr class="trColspan">
								<th colspan="4" class="colorCrema">Results</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Batch ID:</td>
								<td id="cventaPrice"><?= $Batch[0]->ID;?></td>
								<td>Property:</td>
								<td id="cventaWeeks"><?= $Batch[0]->Property;?></td>
							</tr>
							<tr>
								<td>BatchType:</td>
								<td id="cventaPackR"><?= $Batch[0]->BatchType;?></td>
								<td>Records Num:</td>
								<td id="cventaSalePrice"><?= $Batch[0]->Total;?></td>
							</tr>
							<tr>
								<td>Description:</td>
								<td id="cventaHitch"><?= $Batch[0]->BatchDesc;?></td>
								<td>Maintenace Year:</td>
								<td id="cventaTransferA"><?= $Batch[0]->Year;?></td>
							</tr>
							<tr>
								<td>Status:</td>
								<td id="cventaHitch"><?= $Batch[0]->StatusDesc;?></td>
								<td>Total Amount:</td>
								<td id="cventaTransferA">$<?= number_format((float)$Batch[0]->TotalAmount, 2, '.', '');?></td>
							</tr>
							<tr>
								<td>YnActive:</td>
								<td id="cventaHitch"><?= $Batch[0]->ynActive;?></td>
								<td>CrDt:</td>
								<td id="cventaTransferA"><?= $Batch[0]->CrDt;?></td>
							</tr>
							<tr>
								<td>CrBy:</td>
								<td id="cventaHitch"><?= $Batch[0]->CreateBy;?></td>
								<td>MdDt:</td>
								<td id="cventaTransferA"><?= $Batch[0]->MdDt;?></td>
							</tr>
							<tr>
								<td>Due Date:</td>
								<td id="cventaHitch"><?= $Batch[0]->DueDate;?></td>
								<td class="iconEdit">
									<a id="printReportMaintenance" class="btn btn-primary">
										<div class="label">Print</div>
										<i class="fa fa-print" aria-hidden="true"></i>
									</a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				</div>
			</fieldset>
		</div>
	</div>
			<fieldset class="fieldset" id="fieldsetNoteCon">
				<div class="containerContract">
					<div class="row">
						<table id="tableBatchs" width="100%">
							<thead>
								<tr class="trColspan" >
									<th colspan="14" class="thColspan colorCrema" >Detail</th>
								</tr> 
								<tr>
									<th class="cellEdit">Print</th>
									<th class="cellEdit">CSFBatchID</th>
									<th class="cellEdit">Folio</th>
									<th class="cellGeneral">Legal Name</th>
									<th class="cellGeneral">Maintenance Year</th>
									<th class="cellGeneral">MaintenanceType</th>
									<th class="cellGeneral">FloorPlan</th>
									<th class="cellGeneral">Unit</th>
									<th class="cellGeneral">Intv</th>
									<th class="cellGeneral">View</th>
									<th class="cellGeneral">Year</th>
									<th class="cellGeneral">Maint Amount</th>
									<th class="cellGeneral">PreviousBalance</th>
								</tr>
							</thead>
							<tbody id="tableBatchsBody">
								<?php
								if (isset($Batchs)) {
									foreach($Batchs as $item){?>
									<tr>
									<td><?php echo $item->ID; ?></td>
									<td><?php echo $item->contractID; ?></td>
									<td><?php echo "1-". $item->Folio; ?></td>
									<td><?php echo $item->LegalName; ?></td>
									<td><?php echo $item->Year; ?></td>
									<td><?php echo $item->BatchTypeDesc; ?></td>
									<td><?php echo $item->FloorPlanDesc; ?></td>
									<td><?php echo $item->UnitCode; ?></td>
									<td><?php echo $item->Intv; ?></td>
									<td><?php echo $item->ViewDesc; ?></td>
									<td><?php echo $item->Y2; ?></td>
									<td><?php echo number_format((float)$item->TotalAmount, 2, '.', ''); ?></td>
									<td><?php echo number_format((float)$item->PreviousBalance, 2, '.', ''); ?></td>
									<tr>
									<?php
								}
								
								}?>
							</tbody>
						</table>
					</div>
				</div>
			</fieldset>
	</div>
	
</div>
