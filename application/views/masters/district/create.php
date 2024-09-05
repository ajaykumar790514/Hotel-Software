
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
                            <li class="breadcrumb-item">
                                <a href="<?=$back_url?>">District Master</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Create / Update hello
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
                                <h4 class="card-title"><a href="<?=$back_url?>" class="btn btn-primary btn-sm"><i class="ft-list"></i> District</a></h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                
                            </div>
                           
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <!-- form -->
                                    <form class="form ajaxsubmit <?=$form_class?>" action="<?=$action_url?>" method="POST" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" id="name" class="form-control" placeholder="Name" name="name" value="<?=(@$row->name) ? $row->name : '' ?>">
                                            </div>

                                            <div class="form-group">
                                                <label>ROT Code</label>
                                                <input type="text" class="form-control" placeholder="ROT Code" name="rot_code" value="<?=(@$row->rot_code) ? $row->rot_code : '' ?>">
                                            </div>

                                            <div class="form-group">
                                                <label for="longitude">State</label>
                                                <select class="form-control" name="state_id" id="state">
                                                    <?=(@$states) ? $states : '' ?>
                                                </select>
                                                
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
                                </div>
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

      

