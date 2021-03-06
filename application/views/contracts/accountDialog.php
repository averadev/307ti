<div class="row contentModal" id="contentModalContract">
    <div id="accountTransaction" class="contentAccount">
		<form id="saveAccCont" data-abide>
            <div class="fieldset large-12 columns" style="margin-top:0;"> 
				<div class="row">
					<div class="small-4 columns">
                        <label for="accountIdAcc" class="text-left titleBold">Account ID:</label>
                    </div>
                    <div class="small-8 columns">
                        <label id="accountIdAcc" for="accountIdAcc" class="text-left">000</label>
                    </div>
                </div>
				<div class="row">
					<div class="small-4 columns">
                        <label for="" class="text-left titleBold">Account type:</label>
                    </div>
                    <div class="small-8 columns">
                        <label for="" class="text-left">Sale</label>
                    </div>
                </div>
				<div class="row">
					<div class="small-4 columns">
                        <label for="" class="text-left titleBold">Name:</label>
                    </div>
                    <div class="small-8 columns">
                        <label for="" id="legalNameAcc" class="text-left">Name</label>
                    </div>
                </div>
				<div class="row">
					<div class="small-4 columns">
                        <label for="" class="text-left titleBold">Balance:</label>
                    </div>
                    <div class="small-8 columns">
                        <label for="" id="balanceAcc" class="text-left">$ 0.00</label>
                    </div>
                </div>
			</div>
			<div class="fieldset large-12 columns" style="margin-top:0;">
				<!-- Transaction type -->
				<div class="row">
					<div class="small-4 columns">
                        <label for="slcTransTypeAcc" class="text-left">Transaction type:</label>
                    </div>
                    <div class="small-8 columns">
                        <div class="caja" >
							<select id="slcTransTypeAcc" name="slcTransTypeAcc" class="input-group-field round" required>
							</select>
						</div>
                    </div>
                </div>
				<!-- Concept transition type -->
				<div class="row" id="grpTrxClassAcc">
					<div class="small-4 columns">
                        <label for="slcTrxClassAcc" class="text-left">Concept transition type:</label>
                    </div>
                    <div class="small-8 columns">
                        <div class="caja" >
							<select id="slcTrxClassAcc" name="slcTrxClassAcc" class="input-group-field round" required>
							</select>
						</div>
                    </div>
                </div>
                <!-- Concept transition type -->
                <div class="row">
                    <div class="small-4 columns">
                        <label for="CurrencyTrxClassAcc" class="text-left">Currency:</label>
                    </div>
                    <div class="small-8 columns">
                        <div class="caja" >
                            <select id="CurrencyTrxClassAcc" name="CurrencyTrxClassAcc" class="input-group-field round" required>
                            </select>
                        </div>
                    </div>
                </div>
				<!-- Amount -->
				<div class="row">
					<div class="small-4 columns">
                        <label for="AmountAcc" class="text-left">Amount to Pay:</label>
                    </div>
                    <div class="small-8 columns">
                        <input type="number" id="AmountAcc" name="AmountAcc" class="round general" required >
                    </div>
                </div>
				<!-- Date of application -->
				<div class="row">
					<div class="small-4 columns">
                        <label for="dueDateAcc" class="text-left">Date of application:</label>
                    </div>
                    <div class="small-8 columns">
						<div class="input-group date" id="dateBirthdate" >
							<span  class="input-group-label prefix"><i class="fa fa-calendar"></i></span>
							<input required type="text" id="dueDateAcc" name="dueDateAcc" class="input-group-field roundRight" readonly />
						</div>
                    </div>
                </div>
				<!-- Document -->
				<div class="row">
					<div class="small-4 columns">
                        <label for="documentAcc" class="text-left">Document:</label>
                    </div>
                    <div class="small-8 columns">
                        <input type="text" id="documentAcc" name="documentAcc" class="round general" >
                    </div>
                </div>
				<!-- Reference -->
				<div class="row">
					<div class="small-4 columns">
                        <label for="referenceAcc" class="text-left">Reference:</label>
                    </div>
                    <div class="small-8 columns">
                        <input type="text" id="referenceAcc" name="referenceAcc" class="round general" >
                    </div>
                </div>
                <div class="row displayInline" id="inputCheckAll">
                    <div class="small-4 columns">
                        <label for="referenceAcc" class="text-left"></label>
                    </div>
                    <a id="btnCheckAll" class="btn btn-primary btn-Search">
                        <div class="label">Select All</div>
                        <i class="fa fa-check-circle" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="row displayInline" id="inputUnCheckAll">
                    <div class="small-4 columns">
                        <label for="referenceAcc" class="text-left"></label>
                    </div>
                    <a id="btnUnCheckAll" class="btn btn-primary btn-Search">
                        <div class="label">Unselect All</div>
                        <i class="fa fa-check-circle" aria-hidden="true"></i>
                    </a>
                </div>


            </div>
			<div class="fieldset large-12 columns" style="margin-top:0; min-height:200px;" id="grpTablePayAcc" >
				<div class="row" style="padding:0;">
					<div class="large-12 columns" style="padding:0;" >
						<table id="tabletPaymentAccoun" width="100%" style="min-height:150px;">
							<thead>
								<!--<tr class="trColspan" >
									<th colspan="9" class="thColspan" >Seller</th>
								</tr> -->
								<tr>
									<th class="cellGeneral">
										<input type="checkbox" id="checkFilter1" class="checkFilter" value="peopleId">
										<label for="checkFilter1">&nbsp;</label>
									</th>
									<th class="cellGeneral">Id</th>
									<th class="cellGeneral">Code</th>
									<th class="cellGeneral">Concept Trxid</th>
									<th class="cellGeneral">Date</th>
									<th class="cellGeneral">Monto</th>
									<th class="cellGeneral">Monto Bal</th>
								</tr>
							</thead>
							<tbody>
								<tr></tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="small-6 columns">
                        <label for="" class="text-left titleBold" style="text-align: right;">Amount to be settled:</label>
                    </div>
                    <div class="small-6 columns">
                        <label for="" id="amountSettledAcc" class="text-left">$ 0.00</label>
                    </div>
                </div>
			</div>
        </form>
    </div>
</div>