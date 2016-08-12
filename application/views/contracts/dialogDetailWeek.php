<div class="row">
	<div class="large-12 columns">
	<table>
    	<thead class="colorCrema">
        	<tr>
            	<th class="cellEdit">Year</th>
                <th class="cellGeneral">NightId</th>
                <th class="cellGeneral">Intv</th>
                <th class="cellGeneral">Unit Code</th>
                <th class="cellGeneral">Date</th>   
            </tr>
		</thead>
		<tbody>
<?php
if (!empty($weekDetail)){
    foreach($weekDetail as $item){?>
	<tr>
	    <td><?php echo $item->OccYear ?></td>
	    <td><?php echo $item->NightId ?></td>
	    <td><?php echo $item->Intv ?></td>
	    <td><?php echo $item->UnitCode ?></td>
	    <td><?php echo $item->Date ?></td>
	</tr>
<?php
}
}else{
    echo "No Detail";
}
?>
		</tbody>
	</table>
	</div>
</div>
