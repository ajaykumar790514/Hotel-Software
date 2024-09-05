<!-- form -->
<form class="form ajaxsubmit reload-tb" action="<?=$action_url?>" method="POST" enctype="multipart/form-data">
    <div class="form-body">
        <div class="form-group">
            <label for="provider">Provider</label>
            <select id="provider" class="form-control" name="provider">
                <?php
                echo optionStatus('','-- Select --',1);
                foreach ($providers as $provider) {
                    $selected = '';
                    if (@$row->provider) {
                        if ($provider->name == $row->provider) {
                            $selected = 'selected';
                        }
                    }
                    echo optionStatus($provider->name,$provider->name,$provider->status,$selected);
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="speed">Speed</label>
            <input type="text" class="form-control" name="speed" id="speed" value="<?=(@$row->speed) ? $row->speed : '' ?>" >
        </div>
        
        <div class="form-group">
            <label for="in_house_restatement">Other mobile networks </label>
            <?php
            echo br();
            
            echo checkbox('mobile_networks[]','Airtel','Airtel');
            echo checkbox('mobile_networks[]','BSNL Mobile','BSNL Mobile');
            echo checkbox('mobile_networks[]','Jio','Jio');
            echo checkbox('mobile_networks[]','Vi','Vi');
            ?>
        </div>    
       
    </div>

    <div class="form-actions text-right">
        <button type="reset" class="btn btn-danger btn-sm mr-1" data-dismiss="modal">
            <i class="ft-x"></i> Cancel
        </button>
        <button type="submit" class="btn btn-primary btn-sm mr-1">
            <i class="ft-check"></i> Save
        </button>
    </div>
</form>

<?php
// echo $row->mobile_networks;
if (@$row->mobile_networks) {
   $mobile_networks = explode(",",$row->mobile_networks);
   foreach ($mobile_networks as $nrow) { ?>
    <script type="text/javascript">
        $('[value="<?=$nrow?>"]').attr('checked','true');
    </script>
   <?php }
}
?>
<!-- End: form -->


