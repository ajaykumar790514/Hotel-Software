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
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
            <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block"><?=$title?></h3>
                <div class="breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper mr-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?=base_url()?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Profile
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Base style table -->
            <section id="base-style">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                </h4>

                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <?php if($user->user_role ==4){?>
                                <hr>
                             <div class="card-content collapse show">
                            <div class="container mt-5">
                                <div class="row">
                                <?php
                                $time=$packages->time;
                                $endDateTime= $packages->expiry_date.' '.date('H:i:s',strtotime($time));
                                $currentDate = new DateTime();
                                $endDate = new DateTime($endDateTime);
                                $remainingDays = $currentDate->diff($endDate)->format('%a'); // Calculate remaining days

                                $expirationText = "Expires on " . $endDate->format('M d, Y h:i A');
                                ?>

                                <div class="card gradient-card col-md-4 col-sm-4 col-lg-4" style="margin-left: -2rem;">
                                    <div class="card-body gradient-card-body">
                                        <h2 class="card-title text-white text-center" style="font-size: 2rem;font-weight:bold"><?=$packages->name?></h2>
                                        <p class="text-center"><img src="<?=IMGS_URL.$packages->pic;?>" alt="" height="70px"></p>
                                        <h5 class="card-text text-white text-center">Validity : <?=$packages->no_of_days;?> Days</h5>
                                        <h3 class="card-text text-white text-center">Price : <?=setting()->currency;?><?=$packages->price;?></h3>
                                        <p class="card-text text-white text-center"><?=$packages->description;?></p>
                                    </div>
                                    <div class="card-body gradient-card-footer">
                                        <center>
                                            <button class="btn btn-success"><b>Active Plan</b></button>
                                        </center>
                                    </div>
                                    <hr style="border:1px solid white;width:100%"> 
                                    <div class="card-body gradient-card-footer">
                                        <p class="text-white text-center"><?=$expirationText;?></p>
                                    </div>
                                </div>

                                <?php foreach($user_packages_master as $packages):?>
                                <div class="card gradient-card col-md-4 col-sm-4 col-lg-4 ml-1">
                                    <div class="card-body gradient-card-body">
                                        <h2 class="card-title text-white text-center" style="font-size: 2rem;font-weight:bold"><?=$packages->name?></h2>
                                        <p class="text-center"><img src="<?=IMGS_URL.$packages->pic;?>" alt="" height="70px"></p>
                                        <h5 class="card-text text-white text-center">Valitidy : <?=$packages->duration_in_days;?> Days</h5>
                                        <h3 class="card-text text-white text-center">Price : <?=setting()->currency;?><?=$packages->price;?></h3>
                                        <p class="card-text text-white text-center"><?=$packages->description;?> Days</p>
                                    </div>
                                    <div class="card-body gradient-card-footer">
                                    <center><button class="btn btn-success" onclick="activatePlan('<?=$packages->property_id?>','<?=$packages->user_id?>','<?=$packages->plan_id?>', '<?=$packages->name?>')"><b>Not Active </b></button></center>
                                    </div>
                                    <hr style="border:1px solid white;width:100%"> 
                                </div>
                                <?php endforeach;?>
                                </div>
                            </div>

                                </div> 
                                <?php }?>
                            <div class="card-content collapse show" id="tb">
                                

                            </div>
                        </div>
                      
                    </div>
                </div>
            </section>
            <!--/ Base style table -->
        </div>
    </div>
</div>
<!-- END: Content-->

<script>

function  activatePlan(property, userid, planId, planName) {
            Swal.fire({
                toast: true,
                type: 'warning',
                title: 'Are you sure?',
                text: `Do you want to activate the ${planName} plan?`,
                timer: 5000,
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: `Yes, activate it!`,
                cancelButtonText: `No`,
            }).then((result) => {
                if (result.value == true) {
                    $.ajax({
                        url: '<?=base_url('activatePlan') ?>', 
                        type: 'POST',
                        data: { plan_id: planId, property: property, user_id: userid },
                        success: function(response) {
                            response = JSON.parse(response);
                            if (response.success) {
                                Swal.fire('Activated!', `${planName} plan has been activated.`, 'success');
                                location.reload();
                            } else {
                                Swal.fire('Failed!', `${planName} Failed to activate the plan.`, 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error!', 'Failed to activate the plan.', 'error');
                        }
                    });
                }
            }).catch(swal.noop);
            return false;
        }

</script>
