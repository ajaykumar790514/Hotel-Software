<!-- form -->
<form class="form ajaxsubmit reload-tb" action="<?=$action_url?>" method="POST" enctype="multipart/form-data">
    <div class="form-body">
        <div class="form-group col-6 pl-0">
            <label for="name">Amount From</label>
            <input type="text" class="form-control" placeholder="Amount From" name="from" value="<?=(@$row->from!=null) ? $row->from : '' ?>">
        </div>

        <div class="form-group col-6 pr-0">
            <label for="name">Amount To</label>
            <input type="text" id="name" class="form-control" placeholder="Amount To" name="to" value="<?=(@$row->to) ? $row->to : '' ?>">
         </div>   
  
        <div class="form-group">
            <label for="speed">Tax Rate %</label>
            <input type="text" class="form-control" placeholder="Tax Rate" name="tax_rate" value="<?=(@$row->tax_rate) ? $row->tax_rate : '' ?>">
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
<!-- End: form -->


