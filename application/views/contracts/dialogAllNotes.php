<?php
if (!empty($notes)){
    foreach($notes as $item){?>
    <div class="row">
    <div class="large-12 columns">
        <fieldset class="fieldset notes">
        <div class="row">
          <div class="row">

            <div class="small-3 columns">
              <label for="downpaymentPrice" class="text-left">Code</label>
            </div>
            <div class="small-9 columns">
               <p><?php echo $item->pkNoteId ?></p>
            </div>

             <div class="small-3 columns">
              <label for="downpaymentPrice" class="text-left">Note Type</label>
            </div>
            <div class="small-9 columns">
               <p><?php echo $item->NoteTypeDesc ?></p>
            </div>

             <div class="small-3 columns">
              <label for="downpaymentPrice" class="text-left">Create Date</label>
            </div>
            <div class="small-9 columns">
               <p><?php echo $item->CrDt ?></p>
            </div>

            <div class="small-3 columns">
              <label for="downpaymentPrice" class="text-left">Create By</label>
            </div>
            <div class="small-9 columns">
               <p><?php echo $item->CrBy ?></p>
            </div>
            <div class="small-3 columns">
              <label for="downpaymentPrice" class="text-left">Description</label>
            </div>
            <div class="small-9 columns">
               <p><?php echo $item->NoteDesc ?></p>
            </div>
      </div>
        </div>
    </fieldset>
        </div>
    </div>

<?php
}
}else{
    echo "No notes";
}
?>