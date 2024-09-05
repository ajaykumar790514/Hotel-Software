<!-- form -->
<form class="form ajaxsubmit reload-tb" action="<?=$action_url?>" method="POST" enctype="multipart/form-data">
    <div class="form-body">
        <div class="form-group">
            <label for="name">Kitchen</label>
            <select id="private_or_shared" class="form-control" name="private_or_shared">
                <option value="">-- Select --</option>
                <option value="Private" <?=(@$row->private_or_shared=='Private') ? 'selected' : '' ?> >
                    Private
                </option>
                <option value="Shared" <?=(@$row->private_or_shared=='Shared') ? 'selected' : '' ?>>
                    Shared
                </option>
            </select>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                 <h4>Food Arrangement</h4>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="in_house_restatement">In House Restatement</label>
                    <select id="in_house_restatement" class="form-control" name="in_house_restatement">
                        <option value="">-- Select --</option>
                        <option value="Yes" <?=(@$row->in_house_restatement=='Yes') ? 'selected' : '' ?> >
                            Yes
                        </option>
                        <option value="No" <?=(@$row->in_house_restatement=='No') ? 'selected' : '' ?>>
                            No
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="order_from_outside">Order from outside</label>
                    <select id="order_from_outside" class="form-control" name="order_from_outside">
                        <option value="">-- Select --</option>
                        <option value="Yes" <?=(@$row->order_from_outside=='Yes') ? 'selected' : '' ?> >
                            Yes
                        </option>
                        <option value="No" <?=(@$row->order_from_outside=='No') ? 'selected' : '' ?>>
                            No
                        </option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="breakfast">Break Fast</label>
                    <select id="breakfast" class="form-control" name="breakfast">
                        <option value="">-- Select --</option>
                        <option value="1" <?=(@$row->breakfast=='1') ? 'selected' : '' ?> >
                            Yes
                        </option>
                        <option value="0" <?=(@$row->breakfast=='0') ? 'selected' : '' ?>>
                            No
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="breakfast_price">Breakfast Price</label>
                    <input type="number" class="form-control" name="breakfast_price" id="breakfast_price" value="<?=(@$row->breakfast_price) ? $row->breakfast_price : '' ?>" placeholder="Breakfast Price" >
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="lunch">Lunch</label>
                    <select id="lunch" class="form-control" name="lunch">
                        <option value="">-- Select --</option>
                        <option value="1" <?=(@$row->lunch=='1') ? 'selected' : '' ?> >
                            Yes
                        </option>
                        <option value="0" <?=(@$row->lunch=='0') ? 'selected' : '' ?>>
                            No
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lunch_price">Lunch Price</label>
                    <input type="number" class="form-control" name="lunch_price" id="lunch_price" value="<?=(@$row->lunch_price) ? $row->lunch_price : '' ?>" placeholder="Lunch Price">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="dinner">Dinner</label>
                    <select id="dinner" class="form-control" name="dinner">
                        <option value="">-- Select --</option>
                        <option value="1" <?=(@$row->dinner=='1') ? 'selected' : '' ?> >
                            Yes
                        </option>
                        <option value="0" <?=(@$row->dinner=='0') ? 'selected' : '' ?>>
                            No
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="dinner_price">Dinner Price</label>
                    <input type="number" class="form-control" name="dinner_price" id="dinner_price" value="<?=(@$row->dinner_price) ? $row->dinner_price : '' ?>" placeholder="Dinner Price">
                </div>
            </div>
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


