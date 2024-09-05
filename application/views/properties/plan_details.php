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
<hr>
                        <div class="card-content collapse show">
                            <div class="container mt-5 ml-5">
                                <div class="row">
                                <div class="card gradient-card col-md-6 col-sm-6 col-lg-6">
                                    <div class="card-body gradient-card-body">
                                        <h2 class="card-title text-white text-center" style="font-size: 2rem;font-weight:bold"><?=@$packages->name?></h2>
                                        <p class="text-center"><img src="<?=IMGS_URL.@$packages->pic;?>" alt="" height="70px"></p>
                                        <h5 class="card-text text-white text-center">Valitidy : <?=@$packages->no_of_days;?> Days</h5>
                                        <h3 class="card-text text-white text-center">Price : <?=setting()->currency;?><?=@$packages->price;?></h3>
                                        <p class="card-text text-white text-center"><?=@$packages->description;?> Days</p>
                                    </div>
                                    <div class="card-body gradient-card-footer">
                                    <center><button class="btn btn-success"><b>Already Selected</b></button></center>
                                    </div>
                                </div>
                                </div>
                              </div>

                                </div> 
                        <a href="<?=base_url()?>checkSubProperty/<?=@$packages->property_id?>" class="float-right">Upgrade your Plan</a>
                    
                       