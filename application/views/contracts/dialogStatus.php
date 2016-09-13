<div class="contentModal" id="">
	<fieldset class="fieldset">
        <div class="row">
			<div class="small-12 columns">
				<label  class="text-left">Status</label>
				<div class="caja" >
					<select id="statusRes" class="input-group-field round">
						<?php
						foreach($statusCon as $item){
							?>
							<option value="<?php echo $item->ID; ?>" <?php if($item->fkStatusId != null){ ?> selected  <?php }?>  ><?php echo $item->StatusDesc; ?></option>
							<?php
						}
						?>
					</select>
				</div>
			</div>
		</div>
	</fieldset>
</div>