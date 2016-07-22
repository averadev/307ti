<div class="contentModalHeader">
<!-- tabs de los modales -->
<div class="tabsModal">
	<ul class="tabs" id="tabsContrats" data-tabs>
		<li class="tabs-title active" attr-screen="tab-CGeneral" >
			<a>General</a>
		</li>
		<li class="tabs-title" attr-screen="tab-CAccounts">
			<a>Accounts</a>
		</li>
	</ul>
</div>
</div>
<!-- contenido del modal -->
<div class="contentModal" id="ContenidoModalContractEdit">
	<div id="tab-CGeneral" class="large-12 columns tab-modal" style="display:inline-block;">
		
		<fieldset class="fieldset">
			<legend>
				Information about the person
			</legend>
			
		</fieldset>
	</div>

	<!-- tabs cuentas -->
	<div id="tab-CAccounts" class="large-12 columns tab-modal" style="display:none;">
		<div class="tabsModal">
			<ul class="tabs" id="tabsContratsAccounts"  data-tabs>
				<li class="tabs-title active" attr-screen="tab-CASales" attr-accType="1" >
					<a>Reservation</a>
				</li>
				<li class="tabs-title" attr-screen="tab-CALoan" attr-accType="3">
					<a>Front Desk</a>
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
				<a id="btNewTransAccRes" attr_type="newTransAcc" class="btn btn-primary btn-Search">
					<div class="label">New Transaction</div>
					<img src="<?php echo base_url().IMG; ?>common/more.png"/>
				</a>
				<a id="btAddPayAccRes" attr_type="addPayAcc" class="btn btn-primary spanSelect">
					<div class="label">Add Payment</div>
					<img src="<?php echo base_url().IMG; ?>common/more.png"/>
				</a>
			</div>
		</div>
	</div>
</div>
