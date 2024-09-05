<?php
// echo "<pre>";
// print_r($property);
// echo "</pre>";
// die();
?>
<section>
  <div class="row">
      
      <div class="ol-12 col-lg-12">
          <div class="card">
              <div class="card-header">
                  <h4 class="card-title"><?=$row->flat_name?></h4>
                  <span class="text-medium-1 danger line-height-2 text-uppercase"><?=$property->propname?> -</span>
                  <span class="text-medium-1 info line-height-2 text-uppercase"><?=$type->name?></span>
                  <div class="heading-elements">
                      <ul class="list-inline mb-0 display-block">
                          <li>
                          	<?=$row->flat_code_name?> ( <?=$row->flat_no?> )
                          </li>
                      </ul>
                  </div>
              </div>
              <div class="card-content collapse show">
                  <div class="card-body pt-0 pb-1">
                      <p> <?=$row->sub_property_config?></p>

                      <div class="row mb-1">
                          <div class="col-6 col-sm-6 col-md-6 col-lg-6 border-right-blue-grey border-right-lighten-5 text-center">
                              <p class="blue-grey lighten-2 mb-0">Contact Preson</p>
                              <p class="font-medium-5 text-bold-400"><?=$row->contact_preson?></p>
                          </div>
                          <div class="col-6 col-sm-6 col-md-6 col-lg-6 border-right-blue-grey border-right-lighten-5 text-center">
                              <p class="blue-grey lighten-2 mb-0">Contact Preson Mobile</p>
                              <p class="font-medium-5 text-bold-400"><?=$row->contact_preson_mobile?></p>
                          </div>
                         
                      </div>

                      
                  </div>

                  <div class="card-body pt-0 pb-1">
                      <p>Price</p>

                      <div class="row mb-1">
                          <div class="col-6 col-sm-6 col-md-3 col-lg-3 border-right-blue-grey border-right-lighten-5 text-center">
                              <p class="blue-grey lighten-2 mb-0">Daily</p>
                              <p class="font-medium-5 text-bold-400"><?=$row->daily_price?></p>
                          </div>
                          <div class="col-6 col-sm-6 col-md-3 col-lg-3 border-right-blue-grey border-right-lighten-5 text-center">
                              <p class="blue-grey lighten-2 mb-0">Weekly</p>
                              <p class="font-medium-5 text-bold-400"><?=$row->weekly_price?></p>
                          </div>

                          <div class="col-6 col-sm-6 col-md-3 col-lg-3 border-right-blue-grey border-right-lighten-5 text-center">
                              <p class="blue-grey lighten-2 mb-0">Monthly</p>
                              <p class="font-medium-5 text-bold-400"><?=$row->monthly_price?></p>
                          </div>

                          <div class="col-6 col-sm-6 col-md-3 col-lg-3 border-right-blue-grey border-right-lighten-5 text-center">
                              <p class="blue-grey lighten-2 mb-0">Extra Bedding</p>
                              <p class="font-medium-5 text-bold-400"><?=$row->extra_bedding_price?></p>
                          </div>
                         
                      </div>
                  </div>

                  <div class="card-body pt-0 pb-1">
                      <p>Time</p>

                      <div class="row mb-1">
                          <div class="col-6 col-sm-6 col-md-3 col-lg-3 border-right-blue-grey border-right-lighten-5 text-center">
                              <p class="blue-grey lighten-2 mb-0">Check in</p>
                              <p class="font-medium-5 text-bold-400"><?=$row->checkintime?></p>
                          </div>
                          <div class="col-6 col-sm-6 col-md-3 col-lg-3 border-right-blue-grey border-right-lighten-5 text-center">
                              <p class="blue-grey lighten-2 mb-0">Check in upto</p>
                              <p class="font-medium-5 text-bold-400"><?=$row->checkinupto?></p>
                          </div>

                          <div class="col-6 col-sm-6 col-md-3 col-lg-3 border-right-blue-grey border-right-lighten-5 text-center">
                              <p class="blue-grey lighten-2 mb-0">Check out</p>
                              <p class="font-medium-5 text-bold-400"><?=$row->checkouttime?></p>
                          </div>

                          <div class="col-6 col-sm-6 col-md-3 col-lg-3 border-right-blue-grey border-right-lighten-5 text-center">
                              <p class="blue-grey lighten-2 mb-0">Check out upto</p>
                              <p class="font-medium-5 text-bold-400"><?=$row->checkoutupto?></p>
                          </div>
                         
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>