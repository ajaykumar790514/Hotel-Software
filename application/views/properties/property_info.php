<?php
// echo "<pre>";
// print_r($row);
// echo "</pre>";
?>
<section>
  <div class="row">
      
      <div class="ol-12 col-lg-12">
          <div class="card">
              <div class="card-header">
                  <h4 class="card-title"><?=$row->propname?></h4>
                  <span class="text-medium-1 info line-height-2 text-uppercase"><?=$type->name?></span>
                  <div class="heading-elements">
                      <ul class="list-inline mb-0 display-block">
                          <li>
                          	
                          	<?=$row->propcodename?> ( <?=$row->propcode?> )
                              <!-- <a class="btn btn-md btn-info box-shadow-2 round btn-min-width pull-right" href="#" target="_blank">In Progress</a> -->
                          </li>
                      </ul>
                  </div>
              </div>
              <div class="card-content collapse show">
                  <div class="card-body pt-0 pb-1">
                      <p> <?=$row->address?></p>

                      <div class="row mb-1">
                          <div class="col-6 col-sm-4 col-md-4 col-lg-4 border-right-blue-grey border-right-lighten-5 text-center">
                              <p class="blue-grey lighten-2 mb-0">Contact Preson</p>
                              <p class="font-medium-5 text-bold-400"><?=$row->contact_preson?></p>
                          </div>
                          <div class="col-6 col-sm-4 col-md-4 col-lg-4 border-right-blue-grey border-right-lighten-5 text-center">
                              <p class="blue-grey lighten-2 mb-0">Contact Preson Mobile</p>
                              <p class="font-medium-5 text-bold-400"><?=$row->contact_preson_mobile?></p>
                          </div>
                         
                          <div class="col-6 col-sm-4 col-md-4 col-lg-4 text-center">
                              <p class="blue-grey lighten-2 mb-0">Location</p>
                              <p class="font-medium-5 text-bold-400"><?=title('location',$row->location_id)?></p>
                          </div>
                      </div>

                      
                  </div>
              </div>
          </div>
      </div>

      <div class="ol-12 col-lg-12">
          <div class="card">
              
              <div class="card-content collapse show">
                  <div class="card-body pt-0 pb-1">

                      <div class="row mb-1">
                          <div class="col-6 col-sm-4 col-md-4 col-lg-4 border-right-blue-grey border-right-lighten-5 text-center">
                              <p class="blue-grey lighten-2 mb-0">Certificate</p>
                              <?php if (@$prop_doc->certificate) { ?>
                              <p class="font-medium-5 text-bold-400"><img src="<?=IMGS_URL.$prop_doc->certificate?>" class="zoom-img" width="100"></p>
                            <?php } ?>
                          </div>
                          <div class="col-6 col-sm-4 col-md-4 col-lg-4 border-right-blue-grey border-right-lighten-5 text-center">
                              <p class="blue-grey lighten-2 mb-0">PAN Card</p>
                              <?php if (@$prop_doc->pan_card) { ?>
                              <p class="font-medium-5 text-bold-400"><img src="<?=IMGS_URL.$prop_doc->pan_card?>" class="zoom-img" width="100"></p>
                              <?php } ?>
                          </div>
                         
                          <div class="col-6 col-sm-4 col-md-4 col-lg-4 text-center">
                              <p class="blue-grey lighten-2 mb-0">GST Certificate</p>
                              <?php if (@$prop_doc->gst_certificate) { ?>
                              <p class="font-medium-5 text-bold-400"><img src="<?=IMGS_URL.$prop_doc->gst_certificate?>" class="zoom-img" width="100"></p>
                              <?php } ?>
                          </div>
                      </div>

                      
                  </div>
              </div>
          </div>
      </div>

  </div>
</section>