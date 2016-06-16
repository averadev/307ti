<div class="row contentModal" id="contentModalContract">
    <div id="accountTransaction" class="contentAccount">
		<form id="saveAccCont" data-abide>
            <div class="fieldset large-12 columns" style="margin-top:0;"> 
                <!--<legend>
                    Contract Data
                </legend>-->
				<!--<div class="small-4 columns">
                        <label for="legalName" class="text-left">Legal Name</label>
                    </div>
                    <div class="small-8 columns">
                        <input type="text" id="legalName" name="legalName" class="round general" >
                    </div>-->
                <!-- Legal name-->
				<div class="row">
					<div class="small-4 columns">
                        <label for="" class="text-left titleBold">Account ID:</label>
                    </div>
                    <div class="small-8 columns">
                        <label for="" class="text-left">15556</label>
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
                        <label for="" id="balanceAcc" class="text-left">$ 000,000.00</label>
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
				<div class="row">
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
				<!-- Amount -->
				<div class="row">
					<div class="small-4 columns">
                        <label for="AmountAcc" class="text-left">Amount:</label>
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
            </div>
        </form>
    </div>
</div>