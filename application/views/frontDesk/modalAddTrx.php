<div class="contentModal" id="section-HKLookUp">
	<div id="tab-HKLPGeneral" class="large-12 columns tab-modal" style="display:inline;">
		<label id="alertFloorPlanHKConfig" class="text-left">Transactions to Post
			<select id="multipleTRX" class="input-group-field round"  multiple="multiple">
			<?php
				foreach($TrxAudit as $item){?>
					<option value="<?php echo $item->ID; ?>"><?php echo $item->TrxTypeDesc; ?></option>
				<?php
				}
			?>
			</select>
			<!--</div>-->
		</label>
	</div>
</div>
<script>
	AUDITTRX = $('#multipleTRX').multipleSelect({
		filter: true,
		width: '100%',
		placeholder: "Select one",
		selectAll: false,
		onClick: function(view) {
		},
	});
</script>