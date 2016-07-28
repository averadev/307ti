<div class="row">
	<div class="large-12 columns">
	<table>
    	<thead class="colorCrema">
        	<tr>
            	<th class="cellEdit">ID</th>
                <th class="cellGeneral">Note type</th>
                <th class="cellGeneral">Creation date</th>
                <th class="cellGeneral">Created by</th>
                <th class="cellGeneral">Note</th>   
            </tr>
		</thead>
		<tbody>
<?php
if (!empty($notes)){
    foreach($notes as $item){?>
	<tr>
	    <td><?php echo $item->pkNoteId ?></td>
	    <td><?php echo $item->NoteTypeDesc ?></td>
	    <td><?php echo $item->CrDt ?></td>
	    <td><?php echo $item->CrBy ?></td>
	    <td><?php echo $item->NoteDesc ?></td>
	</tr>
<?php
}
}else{
    echo "No notes";
}
?>
		</tbody>
	</table>
	</div>
</div>
