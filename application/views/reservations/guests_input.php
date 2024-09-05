<div class="row border rounded m-1 pt-1 pb-1 ">
    <div class="col-md-12">
        <h5><strong>Guest - <?= $i + 1 ?></strong></h5>
    </div>
<input type="hidden" name="guest_row_count[]" id="" value="<?=$id_append;?>">
<input type="hidden" name="checkin_id[]" value="<?=$checkin_id;?>">
<input type="hidden" name="booking_id[]" value="<?=$booking_id;?>">
<?php $rs = $this->model->getRow('check_in_guests',['booking_id'=>$booking_id,'checkin_id'=>$checkin_id,'guest_row_count'=>$id_append]);?>
<input type="hidden" name="id[]" value="<?=@$rs->id;?>">  
<input type="hidden" name="total_person[]" value="<?=$total_persons;?> "> 
<div class="col-md-3">
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="name[]" placeholder="Enter Name" required value="<?=@$rs->name;?>">
            <input type="hidden" class="form-control" name="type[]" value="<?=$type?>">
            
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>Nationality</label>
            <input type="text" class="form-control" name="nationality[]" placeholder="Enter Nationality" value="<?=@$rs->nationality;?>">
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>Id Proof Type</label>
            <select class="form-control" name="id_proof_type[]">
                <option value="">-- Select --</option>
                <option value="Aadhaar card" <?php if(@$rs->id_proof_type=='Aadhaar card'){echo "selected";} ;?>  >Aadhaar Card</option>
                <option value="Driver Licence"  <?php if(@$rs->id_proof_type=='Driver Licence'){echo "selected";} ;?> >Driver Licence</option>
                <option value="Voter card" <?php if(@$rs->id_proof_type=='Voter card'){echo "selected";} ;?>  >Voter card</option>
                <option value="Visa"  <?php if(@$rs->id_proof_type=='Visa'){echo "selected";} ;?>  >Visa</option>
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>Id Proof No</label>
            <input type="text" class="form-control" name="id_proof_no[]" placeholder="Enter ID Proof Doc Number" value="<?=@$rs->id_proof_no;?>">
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="id_proof_pic_front<?= $id_append ?>">Id Proof Pic Front <span class="text-danger"> ( Maximum file size 100 kb.)</span></label>
            <fieldset class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="id_proof_pic_front<?= $id_append ?>" name="id_proof_pic_front[]">
                    <label class="custom-file-label" for="id_proof_pic_front<?= $id_append ?>">Choose file</label>
                </div>
            </fieldset>
            <?php if(!empty(@$rs->id_proof_pic_front)){;?>
            <img src="<?php echo IMGS_URL.@$rs->id_proof_pic_front ;?>" alt="" height="50px" width="80px">
            <?php }?>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="id_proof_pic_back<?= $id_append ?>">Id Proof Pic Back <span class="text-danger"> ( Maximum file size 100 kb.)</span></label>
            <fieldset class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="id_proof_pic_back<?= $id_append ?>" name="id_proof_pic_back[]">
                    <label class="custom-file-label" for="id_proof_pic_back<?= $id_append ?>">Choose file</label>
                </div>
            </fieldset>
            <?php if(!empty(@$rs->id_proof_pic_back)){;?>
            <img src="<?php echo IMGS_URL.@$rs->id_proof_pic_back ;?>" alt="" height="50px" width="80px">
            <?php }?>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="agrement_doc<?= $id_append ?>">Agrement Document <span class="text-danger"> ( Maximum file size 100 kb.)</span></label>

            <fieldset class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="agrement_doc<?= $id_append ?>" name="agrement_doc[]">
                    <label class="custom-file-label" for="agrement_doc<?= $id_append ?>">Choose file</label>
                </div>
            </fieldset>
            <?php if(!empty(@$rs->agreement_doc)){;?>
            <img src="<?php echo IMGS_URL.@$rs->agreement_doc ;?>" alt="" height="50px" width="80px">
            <?php }?>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="guest_photo<?= $id_append ?>">Guest Photo <span class="text-danger"> ( Maximum file size 100 kb.)</span></label>

            <fieldset class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="guest_photo<?= $id_append ?>" name="guest_photo[]">
                    <label class="custom-file-label" for="guest_photo<?= $id_append ?>">Choose file</label>
                </div>
            </fieldset>
            <?php if(!empty(@$rs->guest_photo)){;?>
            <img src="<?php echo IMGS_URL.@$rs->guest_photo ;?>" alt="" height="50px" width="80px">
            <?php }?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Contact Number</label>
            <input type="number" class="form-control" placeholder="Enter Contact" name="contact[]" value="<?=@$rs->contact;?>">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" class="form-control" placeholder="Enter Email" name="email[]" value="<?=@$rs->email;?>">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Address</label>
            <input type="text" class="form-control" placeholder="Enter Address" name="address[]" value="<?=@$rs->address;?>">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Coming From</label>
            <input type="text" class="form-control" placeholder="Enter Coming From" name="coming[]" value="<?=@$rs->coming;?>">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Going To</label>
            <input type="text" class="form-control" placeholder="Enter Going To" name="going[]" value="<?=@$rs->going;?>">
        </div>
    </div>
</div>
