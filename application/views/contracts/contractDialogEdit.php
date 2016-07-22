<div class="contentModalHeader">
<div class="row collapse headerGeneral" >
	<div class="small-12 medium-12 large-12 columns headerModalBtn"  > 
		<a id="btnFrontPage" class="btn btn-primary spanSelect">
			<div class="label">Front Page</div>
			<i class="fa fa-columns fa-lg"></i>
		</a>
		<a id="btnIWillPay" class="btn btn-primary spanSelect">
			<div class="label">I will pay</div>
			<i class="fa fa-money fa-lg"></i>
		</a>
		<a id="btnVoucher" class="btn btn-primary spanSelect">
			<div class="label">Voucher</div>
			<i class="fa fa-file-text-o fa-lg"></i>
		</a>
		<a id="btnDatasheet" class="btn btn-primary spanSelect">
			<div class="label">Data sheet</div>
			<i class="fa fa-list-alt fa-lg"></i>
		</a>
		<a id="btnAccountStatus" class="btn btn-primary spanSelect">
			<div class="label">Account status</div>
			<i class="fa fa-credit-card fa-lg"></i>
		</a>
	</div>
</div>
<div class="row headerDescription headerGeneral" style="padding: 8px;">
	<div class="small-12 medium-12 large-8 columns"  >
		<label class="headerDescriptionTitle" id="editContractTitle"><?php  echo "[".$contract[0]->Folio ."-".$contract[0]->ID."]".$contract[0]->LegalName;?></label>
		<label class="headerGeneral" id="editContracFloorPlan"><?php echo $contract[0]->FloorPlan;?></label>
		<label class="headerGeneral" id="editContracYear">Year: <?php echo $contract[0]->FirstOccYear; ?></label>
	</div>
	<div class="small-12 medium-12 large-4 columns"  >
		<label class="headerGeneral" id="editContracStatus">Status: <?php echo $contract[0]->StatusDesc;?></label>
		<label class="headerGeneral">Flags: 
		<?php
			if (!empty($flags)) {
				 foreach($flags as $item){
			 		echo $item->FlagDesc.", ";
			 	}
			}
		?></label>
	</div>
</div>
<!-- tabs de los modales -->
<div class="tabsModal">
	<ul class="tabs" id="tabsContrats" data-tabs>
		<li class="tabs-title active" attr-screen="tab-CGeneral" >
			<a>General</a>
		</li>
		<li class="tabs-title" attr-screen="tab-CAccounts">
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
					Contract Data
				</legend>
				<div class="containerContract">
					<div class="row">
						<div class="small-12 columns">
							<a id="btnRefinancingContract" class="button tiny">
							<i class="fa fa-user-plus">Refinancing contract</i></a>
						</div>
						<table id="peopleContract" width="100%">
							<thead>
								<tr class="trColspan" >
									<th colspan="8" class="thColspan" >People</th>
								</tr> 
								<tr>
									<th class="cellEdit" >ID</th>
									<th class="cellGeneral">Name</th>
									<th class="cellGeneral">Last Name</th>
									<th class="cellGeneral" >Address</th>
									<th class="cellGeneral" >Primary</th>
									<th class="cellGeneral" >Beneficiary</th>
									<th></th>
								</tr>
							</thead>
							<tbody id="peoplesContract"></tbody>
						</table>
					</div>
				</div>
				<!-- Unidades -->
				<div class="containerContract" style="margin-top:10px">
				
                    <div class="row">
                        <table id="tableUnidades" width="100%">
                            <thead>
								<tr class="trColspan">
									<th colspan="9">Units</th>
								</tr>
								<tr>
									<!-- <th class="cellEdit oculto">ID</th>
									<th class="cellEdit oculto">Frequency</th> -->
									<th class="cellEdit" >Code</th>
									<th class="cellGeneral">Description</th>
									<th class="cellGeneral">Price</th>
									<th class="cellGeneral" ># Week</th>
									<th class="cellGeneral" >Fisrt Year OCC</th>
									<th class="cellGeneral" >Last Year OCC</th>
<!-- 									<th class="cellGeneral" >Frequency</th> -->
<!-- 									<th></th> -->
								</tr>
							</thead>
							<tbody id="tableUnidadesContract"></tbody>
                        </table>
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
					<table class="tableAccountResult">
						<thead>
							<tr class="trColspan">
								<th colspan="4">Results</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Price</td>
								<td id="cventaPrice">$00.00</td>
								<td>Number of weeks</td>
								<td id="cventaWeeks"></td>
							</tr>
							<tr>
								<td>Discount</td>
								<td id="cventaPackR">$00.00</td>
								<td>Sale price</td>
								<td id="cventaSalePrice">$00.00</td>
							</tr>
							<tr>
								<td>Deposit</td>
								<td id="cventaHitch">$00.00</td>
								<td>Transferred amount</td>
								<td id="cventaTransferA">$00.00</td>
							</tr>
							<tr>
								<td>Cost contract</td>
								<td id="cventaCostContract">$00.00</td>
								<td>Hook amount transferred more</td>
								<td id="cventaAmountTransfer">$000,000.00</td>
							</tr>
							<tr>
								<td>Pack amount</td>
								<td id="cventapackAmount">$000,000.00</td>
								<td>Balance to be financed</td>
								<td id="cventaFinanced">$00.00</td>
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
					<table class="tableAccountResult">
						<thead>
							<tr class="trColspan">
								<th colspan="4">Results</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Balance to be Financed</td>
								<td id="cfbalanceFinanced">$00.00</td>
								<td>Type of funding</td>
								<td>$00.00</td>
							</tr>
							<tr>
								<td>Monthly payment</td>
								<td id="cfPagoMensual">$00.00</td>
								<td>Cost collection</td>
								<td>$000,000.00</td>
							</tr>
							<tr>
								<td>% Discount</td>
								<td id="cfEnganche">$00.00</td>
								<td>Total funding</td>
								<td>$000,000.00</td>
							</tr>
							<tr>
								<td>Total monthly payment</td>
								<td>$000,000.00</td>
							</tr>
						</tbody>
					</table>
				</div>
			</fieldset>
			<!-- Tour -->
			<fieldset class="fieldset" style="margin-bottom: 50px;"  id="tourEditCon">
				<legend class="btnCollapseField"  attr-screen="editOr" >
					<img class="imgCollapseFieldset" src="<?php echo base_url().IMG; ?>common/iconCollapseDown.png"/>
					Tour
				</legend>
				<div class="row" id="editOr" style="display:none;">
					<div class="small-12 medium-8 large-6 columns">
						<!-- Tour ID-->
						<div class="row">
							<div class="small-3 columns">
								<label  for="TourID" class="text-left">Tour ID</label>
							</div>
							<div class="large-9 columns">
								<div class="row collapse">
									<div class="small-10 columns">
										<input readonly value="<?php echo $idTour; ?>" type="text" placeholder="ID" name="TourID" id="TourID">
									</div>
									<div class="small-2 columns">
										<a id="btnAddTourID" href="#" class="button postfix"><i class="fa fa-user-plus">Add</i></a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="small-12 medium-8 large-6 columns" style="text-align:right;"> 
						<a id="btnUpdateTourID" class="button small"><i class="fa fa-save fa-lg">Save</i></a>
						<a id="btn" class="button small"><i class="fa fa-minus-circle fa-lg">Delete</i></a>
					</div>
				</div>
			</fieldset>
	</div>

	<!-- tabs cuentas -->
	<div id="tab-CAccounts" class="large-12 columns tab-modal" style="display:none;">
		<div class="tabsModal">
			<ul class="tabs" id="tabsContratsAccounts"  data-tabs>
				<li class="tabs-title active" attr-screen="tab-CASales" attr-accType="1" >
					<a>Sales</a>
				</li>
				<li class="tabs-title" attr-screen="tab-CAMaintenance" attr-accType="3">
					<a>Maintenance</a>
				</li>
				<li class="tabs-title" attr-screen="tab-CALoan" attr-accType="2">
					<a>Loan</a>
				</li>
			</ul>
		</div>
		<!-- contenido del modal -->
		<div class="ModalContractAccounts">
			<!-- ventas-->
			<div id="tab-CASales" class="large-12 columns tab-modal" style="display:inline;">
				<div class="row" style="padding:0;">
					<div class="large-12 columns" style="padding:0;" >
						<table class="tableAccountResult" id="tableSaleAccRes" style="margin-top:16px;">
							<tbody>
								<tr>
									<td >Folio Contract</td>
									<td class="folioAccount">00000</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Balance</td>
									<td class="balanceAccount">$000,000.00</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Balance of Deposits</td>
									<td class="balanceDepAccount">$000,000.00</td>
									<td>Defeated Deposits</td>
									<td class="defeatedDepAccount">$000,000.00</td>
								</tr>
								<tr>
									<td>Balance Sales</td>
									<td class="balanceSaleAccount">$000,000.00</td>
									<td>Defeated Sales</td>
									<td class="defeatedSaleAccount">$000,000.00</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row" style="padding:0;">
					<div class="large-12 columns table-section2" style="padding:0;" >
						<table id="tableAccountSeller" width="100%" style="min-height:150px;">
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
			<!-- mantenimiento -->
			<div id="tab-CAMaintenance" class="large-12 columns tab-modal" style="display:none;">
				<div class="row" style="padding:0;">
					<div class="large-12 columns" style="padding:0;" >
						<table class="tableAccountResult" id="tableMainteAccRes" style="margin-top:16px;">
							<tbody>
								<tr>
									<td>Folio Contract</td>
									<td class="folioAccount">00000</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Balance Maintenance</td>
									<td class="balanceDepAccount">$000,000.00</td>
									<td>Defeated Maintenance</td>
									<td class="defeatedDepAccount">$000,000.00</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row" style="padding:0;">
					<div class="large-12 columns table-section2" style="padding:0;" >
						<table id="tableAccountMaintenance" width="100%" style="min-height:150px;">
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
			<div id="tab-CALoan" class="large-12 columns tab-modal" style="display:none;">
				<div class="row" style="padding:0;">
					<div class="large-12 columns" style="padding:0;" >
						<table class="tableAccountResult" id="tableLoanAccRes" style="margin-top:16px;">
							<tbody>
								<tr>
									<td>Folio Contract</td>
									<td>00000</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Miscellaneous balance</td>
									<td class="folioAccount">$000,000.00</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Balance of Deposits</td>
									<td class="balanceDepAccount">$000,000.00</td>
									<td>Defeated Deposits</td>
									<td class="defeatedDepAccount">$000,000.00</td>
								</tr>
								<tr>
									<td>Balance Sales</td>
									<td class="balanceSaleAccount">$000,000.00</td>
									<td>Defeated Sales</td>
									<td class="defeatedSaleAccount">$000,000.00</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row" style="padding:0;">
					<div class="large-12 columns table-section2" style="padding:0;" >
						<table id="tableAccountLoan" width="100%" style="min-height:150px;">
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
			<div class="small-12 large-12 columns" style="padding-top:5px;">
				<a id="btNewTransAcc" attr_type="newTransAcc" class="btn btn-primary btn-Search">
					<div class="label">New Transaction</div>
					<img src="<?php echo base_url().IMG; ?>common/more.png"/>
				</a>
				<a id="btAddPayAcc" attr_type="addPayAcc" class="btn btn-primary spanSelect">
					<div class="label">Add Payment</div>
					<img src="<?php echo base_url().IMG; ?>common/more.png"/>
				</a>
			</div>
		</div>
	</div>

	<!-- tabs vendedores -->
	<div id="tab-CVendors" class="large-12 columns tab-modal" style="display:none;">
		<form id="editDataContractVendedores" data-abide='ajax'>
			<fieldset class="fieldset">
				<div class="containerContract">
					<div class="row">
						<table id="tableSellerSelected" width="100%" style="min-height:250px;">
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
				<a id="btnNewSeller" class="button tiny"><i class="fa fa-user-plus fa-lg">New seller</i></a>
				<a id="btnRemoveSeller" class="button tiny"><i class="fa fa-user-times fa-lg">Remove Sale People</i></a>
			</div>
		</form>
	</div>
	<!-- tabs vendedores -->
	<div id="tab-CProvisions" class="large-12 columns tab-modal" style="display:none;">
		<form data-abide='ajax'>
			<fieldset class="fieldset">
				
				<div class="containerContract">
					<div class="row">
						<table id="tableProvisionsSelected" width="100%" style="min-height:250px;">
							<thead>
								<tr class="trColspan" >
									<th colspan="8" class="thColspan" >Gifts</th>
								</tr> 
								<tr>
									<th class="cellGeneral">Code</th>
									<th class="cellGeneral">Description</th>
									<th class="cellGeneral" >Precio</th>
									<th></th>
								</tr>
							</thead>
							<tbody id="tablaGiftsbody"></tbody>
						</table>
					</div>
				</div>
			</fieldset>
			<div class="small-12 medium-12 large-12 columns" > 
				<a id="btnNewProvision" class="button tiny"><i class="fa fa-plus-circle fa-lg">New Provision</i></a>
			</div>
		</form>
	</div>
	<!-- tabs años de ocupacion -->
	<div id="tab-COccupation" class="large-12 columns tab-modal" style="display:none;">
		<form  data-abide='ajax'>
			<fieldset class="fieldset">
				<div class="containerContract">
					<div class="row">
						<table id="tableCOccupationSelected" width="100%">
							<thead>
								<tr class="trColspan" >
									<th colspan="8" class="thColspan" >Occupancy</th>
								</tr> 
								<tr>
									<th class="cellGeneral">Occupancy Type</th>
									<th class="cellGeneral">Occupation Year</th>
									<th class="cellGeneral">Week</th>
									<th></th>
								</tr>
							</thead>
							<tbody id="tableCOccupationSelectedbody"></tbody>
						</table>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
	<!-- tabs años de ocupacion -->
	<div id="tab-CDocuments" class="large-12 columns tab-modal" style="display:none;">
		<form data-abide='ajax'>
			<fieldset class="fieldset">
				<div class="containerContract">
					<div class="row">
						<table id="tableCDocumentsSelected" width="100%" style="min-height:250px;">
							<thead>
								<tr class="trColspan" >
									<th colspan="8" class="thColspan" >Occupancy</th>
								</tr> 
								<tr>
									<th class="cellEdit"></th>
									<th class="cellGeneral">Creation date</th>
									<th class="cellGeneral">Document type</th>
									<th class="cellGeneral">User</th>
									<th class="cellGeneral">Printed</th>
								</tr>
							</thead>
							<tbody>
								<tr></tr>
							</tbody>
						</table>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
	<!-- tabs notas -->
	<div id="tab-CNotes" class="large-12 columns tab-modal" style="display:none;">
		<form  data-abide='ajax'>
			<fieldset class="fieldset editBox">
				<div class="containerContract">
					<div class="row">
						<table id="tableCNotesSelected" width="100%">
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
							<tbody id="tableCNotesSelectedBody"></tbody>
						</table>
					</div>
				</div>
			</fieldset>
			<div class="small-12 medium-12 large-12 columns" > 
				<a id="btnNewNote" class="button tiny"><i class="fa fa-plus-circle fa-lg">New Note</i></a>
				<a id="btnGetAllNotes" class="button tiny"><i class="fa fa-sticky-note-o fa-lg">See all notes</i></a>
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
							<table id="tableFlagsList" width="100%" style="min-height:250px;">
								<thead>
									<tr class="trColspan" >
										<th colspan="3" class="thColspan" >List of flags</th>
									</tr> 
									<tr>
										<th class="cellGeneral">ID</th>
										<th class="cellGeneral">Code</th>
										<th class="cellGeneral">Descripción</th>
									</tr>
								</thead>
								<tbody id="tableFlagsListBody"></tbody>
							</table>
						</div>
						<div class="small-12 medium-6 large-6 columns">
							<table id="tableCNotesAssignedSelected" width="100%" style="min-height:250px;">
								<thead>
									<tr class="trColspan" >
										<th colspan="3" class="thColspan" >Assigned flags</th>
									</tr> 
									<tr>
										<th class="cellGeneral">ID</th>
										<th class="cellGeneral">Code</th>
										<th class="cellGeneral">Descripción</th>
									</tr>
								</thead>
								<tbody id="flagsAsignedBody"></tbody>
							</table>
						</div>
					</div>
				</div>
			</fieldset>
			<div class="small-12 medium-12 large-12 columns" > 
				<a id="btnSAveFlags" class="button tiny"><i class="fa fa-save fa-lg">Save</i></a>
				<a id="btnNextStatus" class="button tiny"><i id="iNextStatus" class="fa fa-refresh fa-lg"></i>Next Status</a>
<!-- 				<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i> -->
			</div>
		</form>
	</div>
	<!-- archivos -->
	<div id="tab-CFiles" class="large-12 columns tab-modal" style="display:none;">
		<form  data-abide='ajax'>
			<fieldset class="fieldset">
				<div class="containerContract" id="contentTableFile">
					<div class="row">
						<table id="tableCFilesSelected" width="100%" >
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
				<a id="btnNewFile" class="btn btn-primary btn-Search">
					<div class="label">New file</div>
					<img src="<?php echo base_url().IMG; ?>common/more.png"/>
				</a>
			</div>
		</form>
	</div>
	
</div>
