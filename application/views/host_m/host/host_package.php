<div class="card-content collapse show">
    <div class="card-body">
     
    <div class="card-content collapse show">
       <div class="container mt-5">
        <div class="row">
          <div class="card gradient-card col-md-12 col-sm-12 col-lg-12">
            <div class="card-body gradient-card-body">
              <h2 class="card-title text-white text-center" style="font-size: 2rem;font-weight:bold"><?=$package_master->name?></h2>
                 <h5 class="card-text text-white text-center">Valitidy : <?=$package->no_of_days;?> Days</h5>
                   <h3 class="card-text text-white text-center">Price : <?=$package_master->price;?> / mo</h3>
                        <p class="card-text text-white text-center"><?=$package_master->description;?> Days</p>
                        <p class="card-text text-white text-center">Plan Status :- <?php if($package->active=='1'){ echo "Activated";}else{echo "Deactivated";};?></p>
                        <p class="card-text text-white text-center">Payment Status :- <?php if($package->status=='2'){ echo "Success";}elseif($package->status=='3'){ echo "Pending";}elseif($package->status=='4'){ echo "Failed";}elseif($package->status=='1'){ echo "Free Plan";}else{echo "Not Any Select Plan";};?></p>
                       </div>
                                    <div class="card-body gradient-card-footer">
                                    <center><button class="btn btn-success"><b>Selected Plan</b></button></center>
                                    </div>
                                    <!-- <hr style="border:1px solid white;width:100%"> -->
                                </div>
                                </div>
                            </div>

                                </div>
   </div>
   </div>
   <style>
     .gradient-card {
        background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(227,46,250,1) 0%, rgba(76,0,255,1) 100%);
            border: none;
            border-radius: 10px;
            color: #fff;
        }

        /* Custom padding and margin for better appearance */
        .gradient-card-body {
            padding: 20px;
        }
        .gradient-card-footer {
            padding: 20px;
        }
</style>