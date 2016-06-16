<fieldset class="fieldset">
<form>
  <div class="row">
    <div class="small-3 columns">
      <label for="tiposPago" class="text-left">Note Type</label>
    </div>
    <div class="small-9 columns">
		<div class="caja">
			<select id="notesTypes" class="input-group-field round">
				 <?php
                foreach($notesType as $item){?>
                    <option value="<?php echo $item->ID; ?>"><?php echo $item->description; ?></option>
                    <?php
                }
            ?>
			</select>
		</div>
    </div>
  </div>
</form>
<fieldset class="fieldset">
    <legend class="btnAddressData">Description</legend>
    <div class="containerPeople">
        <div class="row">
        <textarea name="" id="NoteDescription" cols="30" rows="10"></textarea>
        </div>
    </div>
</fieldset>
  </fieldset>