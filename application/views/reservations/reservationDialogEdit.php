<?php 
if (!isset($contract)) {
	$contract[0] = new StdClass;
}
if(!isset($contract[0]->ID)){$contract[0]->ID = "";};
if(!isset($contract[0]->fkResTypeId)){$contract[0]->fkResTypeId = "";};
if(!isset($contract[0]->Confirmation_code)){$contract[0]->Confirmation_code ="";};
if(!isset($contract[0]->FloorPlan)){$contract[0]->FloorPlan = "";};
if(!isset($contract[0]->arrivaDate)){$contract[0]->arrivaDate="";};
if(!isset($contract[0]->depatureDate)){$contract[0]->depatureDate ="";};
if(!isset($contract[0]->FirstOccYear)){$contract[0]->FirstOccYear ="";};
if(!isset($contract[0]->ResRelated)){$contract[0]->ResRelated="";};
if(!isset($contract[0]->Occ_type)){$contract[0]->Occ_type ="";};
if(!isset($contract[0]->LegalName)){$contract[0]->LegalName ="";};
?>
<div class="contentModalHeader">
<div class="row collapse headerGeneral" >
	<div class="small-12 medium-12 large-12 columns headerModalBtn"  > 
		<a id="" class="btn btn-primary spanSelect btnReportRes" attr_type="CheckOutRes" >
			<div class="label">Out Letter</div>
			<i class="fa fa-columns fa-lg"></i>
		</a>
		<a id="" class="btn btn-primary spanSelect btnReportRes" attr_type="FarewellRes" >
			<div class="label">Farewell</div>
			<i class="fa fa-money fa-lg"></i>
		</a>
		<a id="" class="btn btn-primary spanSelect btnReportRes" attr_type="GuestInfromationRes">
			<div class="label">Guest Information Form</div>
			<i class="fa fa-file-text-o fa-lg"></i>
		</a>
		<a id="" class="btn btn-primary spanSelect btnReportRes" attr_type="Invoice">
			<div class="label">Invoice</div>
			<i class="fa fa-file-text-o fa-lg"></i>
		</a>
		<a id="" class="btn btn-primary spanSelect btnReportRes" attr_type="Statement">
			<div class="label">Statement</div>
			<i class="fa fa-file-text-o fa-lg"></i>
		</a>
		<a id="" class="btn btn-primary spanSelect btnReportRes" attr_type="ReservationConfirmation">
			<div class="label">Reservation Confirmation</div>
			<i class="fa fa-file-text-o fa-lg"></i>
		</a>
		<a id="" class="btn btn-primary spanSelect btnReportRes" attr_type="RoomChange">
			<div class="label">Room Change</div>
			<i class="fa fa-file-text-o fa-lg"></i>
		</a>
	</div>
</div>
<div class="row headerDescription headerGeneral" style="padding: 8px;">
	<div class="small-12 medium-12 large-8 columns"  >
	<p id="idReservationX" style="display: none;"><?php echo $contract[0]->ID;  ?></p>
	<p id="idResTypeX" style="display: none;"><?php echo $contract[0]->fkResTypeId;  ?></p>
		<label class="headerDescriptionTitle small-12 columns" id="editContractTitle"><?php echo $contract[0]->Confirmation_code; ?></label>
		<label class="headerDescriptionTitle small-12 columns" id="legalNAMER"><?php echo "Legal Name :". $contract[0]->LegalName; ?></label>
		<label class="headerDescriptionTitle small-12 columns"><?php echo "Balance :$". number_format((float)$Balance, 2, '.', '');?></label>
		<label class="headerGeneral small-12 columns" id="editContracFloorPlan"><?php echo $contract[0]->FloorPlan;?></label>
		<label class="headerGeneral small-12 columns" id="editContracYear">Year: <?php echo $contract[0]->FirstOccYear; ?></label>
		<label class="headerGeneral small-6 columns"><?php echo "Expected Arrival: ". $contract[0]->arrivaDate; ?></label>
		<label class="headerGeneral small-6 columns" id="dateCheckIn"><?php  echo "Check In: ". $dateCheckIn;?></label>
		<label class="headerGeneral small-6 columns"><?php echo "Expected Deperture: ".$contract[0]->depatureDate; ?></label>
		<label class="headerGeneral small-6 columns" id="dateCheckOut"><?php  echo "Check Out: ". $dateCheckOut;?></label>

	</div>
	<div class="small-12 medium-12 large-4 columns"  >
		<label class="headerGeneral" id="editReservationStatus">Status: <?php echo $statusActual;?></label>
		<label class="headerGeneral" id="editReservationStatus">ResRelated : <?php echo $ResConf; ?></label>
		<label id="flagsContracEditRes" class="headerGeneral">Flags: 
		<?php
			if (!empty($flags)) {
				 foreach($flags as $item){
			 		echo $item->FlagDesc.", ";
			 	}
			}
		?></label>
		<label class="headerGeneral" id="editOccTypeCodeRes"><?php echo "OccTypeCode: ". $contract[0]->Occ_type;  ?></label>
	</div>
</div>
<!-- tabs de los modales -->
<div class="tabsModal">
	<ul class="tabs" id="tabsContratsRes" data-tabs>
		<li class="tabs-title active" attr-screen="tab-CGeneral" >
			<a>General</a>
		</li>
		<li class="tabs-title" attr-screen="tab-RAccounts" id="RAccounts">
			<a>Accounts</a>
		</li>
		<li class="tabs-title" attr-screen="tab-CVendors">
			<a>Sales People</a>
		</li>
		<li class="tabs-title" attr-screen="tab-CProvisions">
			<a>Gifts</a>
		</li>
		<li class="tabs-title" attr-screen="tab-COccupation">
			<a>Occupancy</a>
		</li>
		<li class="tabs-title" attr-screen="tab-CDocuments">
			<a>Documents</a>
		</li>
		<li class="tabs-title" attr-screen="tab-CNotes">
			<a>Notes</a>
		</li>
		<li class="tabs-title" attr-screen="tab-CFlags">
			<a>Flags</a>
		</li>
		<li class="tabs-title" attr-screen="tab-CFiles">
			<a>Files</a>
		</li>
	</ul>
</div>
</div>
<!-- contenido del modal -->
<div class="contentModal" id="ContenidoModalContractEdit">
	
	<div id="tab-CGeneral" class="large-12 columns tab-modal" style="display:inline-block;">
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
					Reservation Data
				</legend>
				<div class="containerContract">
					<div class="row">
						<div class="small-6 columns">
							<a id="btnRefinancingReservation" class="btn btn-primary">
								<div class="label">Refinancing reservation</div>
								<span>
									<i class="fa fa-user-plus"></i>
								</span>
							</a>
							<!--<a id="btnRefinancingReservation" class="button tiny">
							<i class="fa fa-user-plus">Refinancing reservation</i></a>-->
						</div>
						<div class="small-6 columns">
							<?php
								if( !($statusActual == "Cancel" || $statusActual == "Exchange") ){
									?>
									<a id="btnNextStatusRes" class="btn btn-primary btn-right">
										<div class="label">Change Status</div>
										<span>
											<i id="iNextStatus" class="fa fa-refresh fa-lg"></i>
										</span>
									</a>
									<?php
								}
							?>
						</div>
					</div>
				</div>
				</br>
				<!-- people -->
				<div class="containerPeople">
					<div class="row">
						<div class="small-12 columns">
                            <!--<a id="btnAddPeople" href="#" class="button tiny"><i class="fa fa-user-plus"></i></a>-->
							<a id="btnAddPeopleResEdit" attr_table="peopleContractRes" class="btn btn-primary spanSelect">
								<div class="label">Add</div>
								<img src="<?php echo base_url().IMG; ?>common/more.png"/>
							</a>
							<a id="btnSavePeopleRes" class="btn btn-primary spanSelect">
								<div class="label">Save Changes</div>
								<img src="<?php echo base_url().IMG; ?>common/more.png"/>
							</a>
                        </div>
						<div class="small-12 columns">
							<table id="peopleContractRes" width="100%" class="cell-border">
								<thead>
									<tr class="trColspan" >
										<th colspan="8" class="thColspan" >People</th>
									</tr> 
									<tr>
										<th class="cellEdit" >Check In</th>
										<th class="cellEdit" >ID</th>
										<th class="cellGeneral">Name</th>
										<th class="cellGeneral">Last Name</th>
										<th class="cellGeneral" >Address</th>
										<th class="cellGeneral" >Main</th>
										<th class="cellGeneral" >Secondary</th>
										<th class="cellGeneral">Delete</th>
										<th></th>
									</tr>
								</thead>
								<tbody id="peoplesReservation"></tbody>
							</table>
							
						</div>
					</div>
				</div>
				
				<!-- Unidades -->
				<div class="containerContract" style="margin-top:10px">
                    <div class="row">
						<div class="small-12 columns">
                            <!--<a id="btnAddPeople" href="#" class="button tiny"><i class="fa fa-user-plus"></i></a>-->
							<a id="btnChangeUnitRes" attr_table="tableUnidades" class="btn btn-primary spanSelect">
								<div class="label">Change Unit</div>
								<img src="<?php echo base_url().IMG; ?>common/more.png"/>
							</a>
							<!--<a id="btnSaveUnitRes" class="btn btn-primary spanSelect">
								<div class="label">Save Changes</div>
								<img src="<?php echo base_url().IMG; ?>common/more.png"/>
							</a>-->
                        </div>
						<div class="small-12 columns">
							<table id="tableUnidades" width="100%" class="cell-border">
								<thead>
									<tr class="trColspan">
										<th colspan="9">Units</th>
									</tr>
									<tr>
									<th class="cellEdit" >ID</th>
										<th class="cellEdit" >Code</th>
										<th class="cellGeneral">Description</th>
										<th class="cellGeneral">Price</th>
										<th class="cellGeneral" ># Week</th>
										<th class="cellGeneral" >Fisrt Year OCC</th>
										<th class="cellGeneral" >Last Year OCC</th>
										<th class="cellGeneral" >OCCYear</th>
										<th></th>
									</tr>
								</thead>
								<tbody id="tableUnidadesReservation"></tbody>
							</table>
						</div>
                    </div>
                </div>
			</fieldset>
			
			<!-- Condiciones de venta -->
			<fieldset class="fieldset" id="ventaCondi">
				<legend class="btnCollapseField"  attr-screen="editTermsOfSale" >
					<img class="imgCollapseFieldset" src="<?php echo base_url().IMG; ?>common/iconCollapseDown.png"/>
					Terms of sale
				</legend>
				<div class="row" id="editTermsOfSale" style="display:none;">
					<table class="tableAccountResult" class="cell-border">
						<thead>
							<tr class="trColspan">
								<th colspan="4">Results</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Price</td>
								<td id="cventaPriceRes">$00.00</td>
								<td>Number of weeks</td>
								<td id="cventaWeeksRes"></td>
							</tr>
							<tr>
								<td>Discount</td>
								<td id="cventaPackRRes">$00.00</td>
								<td>Sale price</td>
								<td id="cventaSalePriceRes">$00.00</td>
							</tr>
							<tr>
								<td>Deposit</td>
								<td id="cventaHitchRes">$00.00</td>
								<td>Transferred amount</td>
								<td id="cventaTransferARes">$00.00</td>
							</tr>
							<tr>
								<td>Cost contract</td>
								<td id="cventaCostContractRes">$00.00</td>
								<td>Downpayment</td>
								<td id="cventaAmountTransfer">$0.00</td>
							</tr>
							<tr>
								<td>Pack amount</td>
								<td id="cventapackAmountRes">$0.00</td>
								<td>Balance to be financed</td>
								<td id="cventaFinancedRes">$00.00</td>
							</tr>
						</tbody>
					</table>
				</div>
			</fieldset>
			
			<!-- Condiciones de financiamiento -->
			<fieldset class="fieldset" id="finTerminos">
				<legend class="btnCollapseField"  attr-screen="editTermsOfFinancing" >
					<img class="imgCollapseFieldset" src="<?php echo base_url().IMG; ?>common/iconCollapseDown.png"/>
					 Financig Terms
				</legend>
				<div class="row" id="editTermsOfFinancing" style="display:none;">
					<table class="tableAccountResult" class="cell-border">
						<thead>
							<tr class="trColspan">
								<th colspan="4" class="colorCrema">Results</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Balance to Finance</td>
								<td id="cfbalanceFinancedRes"></td>
								<td>Type of Finance</td>
								<td id="typeFinanceRes"></td>
							</tr>
							<tr>
								<td>Monthly Payment</td>
								<td id="cfPagoMensualRes">$00.00</td>
								<td>Collection Cost</td>
								<td id="CollectionCostRes"></td>
							</tr>
							<tr>
								<td>% Discount</td>
								<td id="cfEngancheRes">$00.00</td>
								<td>Total funding</td>
								<td id="totalFoundingRes"></td>
							</tr>
							<tr>
								<td>Total Monthly Payment</td>
								<td id="totalMonthlyPaymentRes"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</fieldset>
	</div>

	<!-- tabs cuentas -->
	<div id="tab-RAccounts" class="large-12 columns tab-modal" style="display:none;">
		<div class="tabsModal">
			<ul class="tabs" id="tabsContratsAccounts"  data-tabs>
				<li class="tabs-title active" attr-screen="tab-RARes" attr-accType="6" attr-accCode="RES" >
					<a>Reservation</a>
				</li>
				<li class="tabs-title" attr-screen="ADVDeposit" attr-accType="7" attr-accCode="ADep" >
					<a>ADV Deposit</a>
				</li>
			</ul>
		</div>
		<!-- contenido del modal -->
		<div class="ModalContractAccounts">
			<div id="tab-RARes" class="large-12 columns tab-modal" style="display:inline;">
				<div class="row" style="padding:0;">
					<div class="large-12 columns" style="padding:0;" >
						<table class="tableAccountResult" id="tableReservationAccRes" style="margin-top:16px;" class="cell-border">
							<tbody>
								<tr>
									<td >Folio Reservation</td>
									<td class="folioAccount">00000</td>
									<td>Balance of Deposits</td>
									<td class="balanceDepAccount">$0.00</td>
									<td>Credit Limit</td>
									<td id="creditLimitRes"><?php echo floatval($creditLimit); ?></td>
									<td>Past Due Deposits</td>
									<td class="defeatedDepAccount">$0.00</td>
								</tr>
								<tr>
									<td>Balance</td>
									<td class="balanceAccount"><?php echo floatval($Balance);?></td>
									<td>Balance Sales</td>
									<td class="balanceSaleAccount">$0.00</td>
									<td></td>
									<td></td>
									<td>Past Due Sales</td>
									<td class="defeatedSaleAccount">$0.00</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row" style="padding:0;">
					<div class="large-12 columns table-section2" style="padding:0;" >
						<table id="tableAccountSeller" width="100%" style="min-height:150px;" class="cell-border" >
							<thead>
								<!--<tr class="trColspan" >
									<th colspan="9" class="thColspan" >Seller</th>
								</tr> -->
								<tr>
									<th class="cellGeneral">Id</th>
									<th class="cellGeneral">Code</th>
									<th class="cellGeneral">Active</th>
									<th class="cellGeneral">Type</th>
									<th class="cellGeneral">Sign transaction</th>
									<th class="cellGeneral">Concept Trxid</th>
									<th class="cellGeneral">Date</th>
									<th class="cellGeneral">Rode</th>
									<th class="cellGeneral">Monto Bal</th>
								</tr>
							</thead>
							<tbody>
								<tr></tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Misceláneos -->
			<div id="ADVDeposit" class="large-12 columns tab-modal" style="display:none;">
				<div class="row" style="padding:0;">
					<div class="large-12 columns" style="padding:0;" >
						<table class="tableAccountResult" id="tableAccountLoanDetail" style="margin-top:16px;" class="cell-border" >
							<tbody>
								<tr>
									<td >Folio Reservation</td>
									<td class="folioAccount">00000</td>
									<td></td>
									<td ></td>
								</tr>
								<tr>
									<td>Balance</td>
									<td class="balanceAccount"><?php echo floatval($financeBalance);?></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Balance of Deposits</td>
									<td class="balanceDepAccount">$0.00</td>
									<td>Past Due Deposits</td>
									<td class="defeatedDepAccount">$0.00</td>
								</tr>
								<tr>
									<td>Balance Sales</td>
									<td class="balanceSaleAccount">$0.00</td>
									<td>Past Due Sales</td>
									<td class="defeatedSaleAccount">$0.00</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row" style="padding:0;">
					<div class="large-12 columns table-section2" style="padding:0;" >
						<table id="tableAccountLoan" width="100%" style="min-height:150px;" class="cell-border">
							<thead>
								<tr>
									<th class="cellGeneral">Id</th>
									<th class="cellGeneral">Code</th>
									<th class="cellGeneral">Active</th>
									<th class="cellGeneral">Type</th>
									<th class="cellGeneral">Sign transaction</th>
									<th class="cellGeneral">Concept Trxid</th>
									<th class="cellGeneral">Date</th>
									<th class="cellGeneral">Rode</th>
									<th class="cellGeneral">Monto Bal</th>
								</tr>
							</thead>
							<tbody>
								<tr></tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="small-12 large-12 columns" id="btnsTransRes" style="padding-top:5px;">
				<?php
					if( !($statusActual == "Cancel" || $statusActual == "Exchange") ){
					?>
						<p id="NEWRES" class="oculto"></p>
						<p id="NEWFRONT" class="oculto"></p>
						<p id="NEWDEPS" class="oculto"></p>
						<a  id="btNewTransAccRes" attr_type="newTransAcc" class="btn btn-primary btn-Search" <?php if( $statusActual == "Out"){ ?> style="display:none;" <?php  }?> >
							<div class="label">New Transaction</div>
							<img src="<?php echo base_url().IMG; ?>common/more.png"/>
						</a>
						<a id="btAddPayAccRes" attr_type="addPayAcc" class="btn btn-primary spanSelect">
							<div class="label">Add Payment</div>
							<img src="<?php echo base_url().IMG; ?>common/more.png"/>
						</a>
						<a id="btnShowPayCardASR" attr_type="cardASR" class="btn btn-primary spanSelect">
							<div class="label">Card Associated</div>
							<img src="<?php echo base_url().IMG; ?>common/more.png"/>
						</a>
						<a id="btAddCreditLimitRes" attr_type="addLimitAcc" class="btn btn-primary spanSelect">
							<div class="label">Credit Limit</div>
							<img src="<?php echo base_url().IMG; ?>common/more.png"/>
						</a>
						<a id="btAddLinkACC" attr_type="linkACC" class="btn btn-primary spanSelect">
							<div class="label">Link Reservation</div>
							<i class="fa fa-arrow-right" ></i>
						</a>
					<?php
					}
				?>
			</div>
		</div>
	</div>

	<!-- tabs vendedores -->
	<div id="tab-CVendors" class="large-12 columns tab-modal" style="display:none;">
		<form id="editDataContractVendedores" data-abide='ajax'>
			<fieldset class="fieldset">
				<div class="containerContract">
					<div class="row">
						<table id="tableSellerSelected" width="100%" style="min-height:250px;" class="cell-border">
							<thead>
								<tr class="trColspan" >
									<th colspan="8" class="thColspan" >Sales People</th>
								</tr> 
								<tr>
									<th class="cellEdit" >ID</th>
									<th class="cellGeneral">Code</th>
									<th class="cellGeneral">Name</th>
									<th></th>
								</tr>
							</thead>
							<tbody id="tableSellerSelectedbody">
								<tr></tr>
							</tbody>
						</table>
					</div>
				</div>
			</fieldset>
			<div class="small-12 medium-12 large-12 columns" > 
				<a id="btnNewSellerRes" class="button tiny"><i class="fa fa-user-plus fa-lg">New</i></a>
				<a id="btnRemoveSeller" class="button tiny"><i class="fa fa-user-times fa-lg">Remove</i></a>
			</div>
		</form>
	</div>
	<!-- tabs vendedores -->
	<div id="tab-CProvisions" class="large-12 columns tab-modal" style="display:none;">
		<form data-abide='ajax'>
			<fieldset class="fieldset">
				
				<div class="containerContract">
					<div class="row">
						<table id="tableProvisionsSelected" width="100%" style="min-height:250px;" class="cell-border">
							<thead>
								<tr class="trColspan" >
									<th colspan="8" class="thColspan" >Gifts</th>
								</tr> 
								<tr>
									<th class="cellGeneral">Code</th>
									<th class="cellGeneral">Description</th>
									<th class="cellGeneral" >Price</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr></tr>
							</tbody>
						</table>
					</div>
				</div>
			</fieldset>
			<div class="small-12 medium-12 large-12 columns" > 
				<a id="btnNewProvisionRes" class="button tiny"><i class="fa fa-plus-circle fa-lg">New</i></a>
			</div>
		</form>
	</div>
	<!-- tabs años de ocupacion -->
	<div id="tab-COccupation" class="large-12 columns tab-modal" style="display:none;">
		<form  data-abide='ajax'>
			<fieldset class="fieldset">
				<div class="containerContract" id="content-OccupationRes">
					<div class="row">
						<table id="tableCOccupationSelected" width="100%" class="cell-border" >
							<thead>
								<tr class="trColspan" >
									<th colspan="8" class="thColspan" >Occupancy</th>
								</tr> 
								<tr>
									<th class="cellGeneral">Occupancy Type</th>
									<th class="cellGeneral">Occupation Year</th>
									<th class="cellGeneral">Week</th>
									<th class="cellGeneral">First Year</th>
									<th class="cellGeneral">Last Year</th>
									<th></th>
								</tr>
							</thead>
							<tbody id="tableCOccupationSelectedbodyRes"></tbody>
						</table>
					</div>
				</div>
			</fieldset>
			<?php
				if( !($statusActual == "Cancel" || $statusActual == "Exchange") ){
					//if($contract[0]->fkResTypeId == 7){
						?>
						<div class="small-12 medium-12 large-12 columns" > 
							<a id="btnNewOccRes" class="btn btn-primary btn-Search">
								<div class="label">New Night</div>
								<img src="<?php echo base_url().IMG; ?>common/more.png"/>
							</a>
						</div>
						<?php
					//}
				}
			?>
		</form>
	</div>
	<!-- tabs años de ocupacion -->
	<div id="tab-CDocuments" class="large-12 columns tab-modal" style="display:none;">
		<form data-abide='ajax'>
			<fieldset class="fieldset">
				<div class="containerContract">
					<div class="row">
						<table id="tableCDocumentsSelected" width="100%" class="cell-border" >
							<thead>
								<tr class="trColspan" >
									<th colspan="8" class="thColspan" >Documents</th>
								</tr> 
								<tr>
									<th class="cellGeneral">Id</th>
									<th class="cellGeneral">File</th>
									<th class="cellGeneral">Description</th>
									<th class="cellGeneral">User</th>
									<th class="cellGeneral">Date</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</fieldset>
<!-- 			<div class="small-12 medium-12 large-12 columns" > 
				<a id="btnDeleteDocRes" class="btn btn-primary btn-Search">
					<div class="label">Delete Document</div>
					<img src="<?php echo base_url().IMG; ?>common/BORRAR2.png"/>
				</a>
			</div> -->
		</form>
	</div>
	<!-- tabs notas -->
	<div id="tab-CNotes" class="large-12 columns tab-modal" style="display:none;">
		<form  data-abide='ajax'>
			<fieldset class="fieldset editBox">
				<div class="containerContract">
					<div class="row">
						<table id="tableCNotesSelected" width="100%" class="cell-border">
							<thead>
								<tr class="trColspan" >
									<th colspan="8" class="thColspan" >Notes</th>
								</tr> 
								<tr>
									<th class="cellEdit">ID</th>
									<th class="cellGeneral">Note type</th>
									<th class="cellGeneral">Note</th>
									<th class="cellGeneral">Creation date</th>
									<th class="cellGeneral">Created by</th>
									
								</tr>
							</thead>
							<tbody id="tableCNotesSelectedBodyRes"></tbody>
						</table>
					</div>
				</div>
			</fieldset>
			<div class="small-12 medium-12 large-12 columns" > 
				<a id="btnNewNoteRes" class="button tiny"><i class="fa fa-plus-circle fa-lg">New Note</i></a>
				<a id="btnGetAllNotesRes" class="button tiny"><i class="fa fa-sticky-note-o fa-lg">See all notes</i></a>
			</div>
		</form>
	</div>
	<!-- Banderas -->
	<div id="tab-CFlags" class="large-12 columns tab-modal" style="display:none;">
		<form  data-abide='ajax'>
			<fieldset class="fieldset">
				<div class="containerContract">
					<div class="row">
						<div class="small-12 medium-6 large-6 columns">
							<table id="tableFlagsListRes" width="100%" style="min-height:250px;" class="cell-border">
								<thead>
									<tr class="trColspan" >
										<th colspan="4" class="thColspan" >List of flags</th>
									</tr> 
									<tr>
										<th class="cellGeneral">ID</th>
										<th class="cellGeneral">Code</th>
										<th class="cellGeneral">Description</th>
									</tr>
								</thead>
								<tbody id="tableFlagsListBodyRes"></tbody>
							</table>
						</div>
						<div class="small-12 medium-6 large-6 columns">
							<table id="tableCNotesAssignedSelected" width="100%" class="cell-border">
								<thead>
									<tr class="trColspan" >
										<th colspan="4" class="thColspan" >Assigned flags</th>
									</tr> 
									<tr>
										<th class="cellGeneral">DELETE</th>
										<th class="cellGeneral">ID</th>
										<th class="cellGeneral">Code</th>
										<th class="cellGeneral">Description</th>
									</tr>
								</thead>
								<tbody id="flagsAsignedBodyRes"></tbody>
							</table>
						</div>
					</div>
				</div>
			</fieldset>
<!-- 			<div class="small-12 medium-12 large-12 columns" > 
				<a id="btnSAveFlagsRes" class="button tiny"><i class="fa fa-save fa-lg">Save</i></a>
			</div> -->
		</form>
	</div>
	<!-- archivos -->
	<div id="tab-CFiles" class="large-12 columns tab-modal" style="display:none;">
		<form  data-abide='ajax'>
			<fieldset class="fieldset">
				<div class="containerContract" id="contentTableFileRes">
					<div class="row">
						<table id="tableCFilesSelectedRes" width="100%" class="cell-border" >
							<thead>
								<tr class="trColspan" >
									<th colspan="8" class="thColspan" >Notes</th>
								</tr> 
								<tr>
									<th class="cellGeneral">Id</th>
									<th class="cellGeneral">File</th>
									<th class="cellGeneral">Description</th>
									<th class="cellGeneral">User</th>
									<th class="cellGeneral">Date</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</fieldset>
			<div class="small-12 medium-12 large-12 columns" > 
				<a id="btnNewFileRes" class="btn btn-primary btn-Search">
					<div class="label">New file</div>
					<img src="<?php echo base_url().IMG; ?>common/more.png"/>
				</a>
			</div>
		</form>
	</div>
	
</div>
