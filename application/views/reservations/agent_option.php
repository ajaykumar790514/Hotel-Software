<div class="row p-0">
	<div class="col-md-6">
		<div class="form-group">
           	<label for="agent">Agent</label><br>
           	<select autocomplete="random-value" class="form-control" id="agent" name="agent">
           		<?php 
				echo optionStatus('','-- Select --',1);
				foreach ($agent as $row) {
					echo optionStatus($row->id,$row->name.' ('.$row->mobile.')'.' ('.$row->company_name.')',1);
				}
				?>           		
           	</select>
        </div>	
    </div>
    <div class="col-md-6 align-self-center">
    	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#showModal" data-whatever="Add Agent" data-url="<?=$new_url_agent?>">Add Agent</button>
    </div>	
</div>