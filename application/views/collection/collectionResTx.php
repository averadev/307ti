		<div class="tabsModal">
			<ul class="tabs" id="tabsContratsAccounts"  data-tabs>
				<li class="tabs-title active" attr-screen="tab-coRes" attr-accType="6" attr-accCode="RES" >
					<a>Reservation</a>
				</li>
				<li class="tabs-title" attr-screen="tab-coFront" attr-accType="5" attr-accCode="FDK" >
					<a>Front Desk</a>
				</li>
			</ul>
		</div>
		<!-- contenido del modal -->
		<div class="ModalContractAccounts">
			<!-- Reservation -->
			<div id="tab-coRes" class="large-12 columns tab-modal" style="display:inline;">
				<div class="row" style="padding:0;">
					<div class="large-12 columns" style="padding:0;" >
						<table class="tableAccountResult" id="tableResAccColl" style="margin-top:16px;">
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
			<!-- Front desk -->
			<div id="tab-coFront" class="large-12 columns tab-modal" style="display:none;">
				<div class="row" style="padding:0;">
					<div class="large-12 columns" style="padding:0;" >
						<table class="tableAccountResult" id="tableFrontAccColl" style="margin-top:16px;">
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
				<a id="btNewTransAccColl" attr_type="newTransAcc" class="btn btn-primary btn-Search">
					<div class="label">New Transaction</div>
					<img src="<?php echo base_url().IMG; ?>common/more.png"/>
				</a>
				<a id="btAddPayAccColl" attr_type="addPayAcc" class="btn btn-primary spanSelect">
					<div class="label">Add Payment</div>
					<img src="<?php echo base_url().IMG; ?>common/more.png"/>
				</a>
			</div>
		</div>