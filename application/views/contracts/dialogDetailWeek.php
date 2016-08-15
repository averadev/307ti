<div class="row">
	<div class="large-12 columns">
	<table>
    	<thead class="colorCrema">
        	<tr>
            	<th class="cellEdit">ID</th>
                <th class="cellGeneral">Folio</th>
                <th class="cellGeneral">LegalName</th>
                <th class="cellGeneral">FloorPlan</th>
                <th class="cellGeneral">FrequencyDesc</th>
                <th class="cellGeneral">StatusDesc</th>
                <th class="cellGeneral">CrDt</th>      
                <th class="cellGeneral">FirstOccYear</th>
                <th class="cellGeneral">LastOccYear</th>   
            </tr>
		</thead>
		<tbody>
<?php
if (!empty($weekDetail)){
    foreach($weekDetail as $item){?>
	<tr>
	    <td><?php echo $item->ID ?></td>
	    <td><?php echo $item->Folio ?></td>
	    <td><?php echo $item->LegalName ?></td>
	    <td><?php echo $item->FloorPlan ?></td>
	    <td><?php echo $item->FrequencyDesc ?></td>
	    <td><?php echo $item->StatusDesc ?></td>
	    <td><?php echo $item->CrDt ?></td>
	    <td><?php echo $item->FirstOccYear ?></td>
	    <td><?php echo $item->LastOccYear ?></td>
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
