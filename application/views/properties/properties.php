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
                                Property List
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
                                <?php 
                                // total user package property
                                 /*$rs = $this->model->get_user_property($user->id);
                                $userproperty = $this->model->get_user_assign_property($user->id);
                                 if($rs->no_of_properties < $userproperty){ ?>
                                <h4 class="card-title"><a href="<?=base_url()?>properties/new" class="btn btn-primary btn-sm"><i class="ft-plus"></i> Add New Property</a></h4>
                                <?php }else{?>
                                    <h4 class="card-title text-white"><a onclick="full_msg()" class="btn btn-primary btn-sm"><i class="ft-plus"></i> Add New Property</a></h4>
                                <?php } */?>
								<?php if($user->user_role =='4'):?>
                                    <h4 class="card-title"><a href="<?=base_url()?>properties/new" class="btn btn-primary btn-sm"><i class="ft-plus"></i> Add New Property</a></h4>
									<?php  endif;?>
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
    function full_msg()
    {
        alert_toastr('error','Property limit exceeded.Kindly upgrade your plan');
    }
</script>
