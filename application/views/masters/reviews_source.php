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
                                Reviews Source Master List
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
                                <h4 class="card-title"><a href="javascript:void(0)" data-toggle="collapse" data-target="#addNew" class="btn btn-primary btn-sm"><i class="ft-plus"></i> Add New Reviews Source</a></h4>
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
                            <div class="card-content collapse" id="addNew">
                                <div class="card-body">
                                    <!-- form -->
                                    <form class="form ajaxsubmit reload-tb" action="<?=base_url()?>reviews_source/save" method="POST" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <h4 class="form-section">
                                                <i class="la la-building"></i>Reviews Source Name
                                            </h4>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                        <input type="text" id="name" class="form-control" placeholder="Reviews Source Name" name="name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                   <div class="form-actions text-right border-none">
                                                        <button type="reset" class="btn btn-danger mr-1" data-toggle="collapse" data-target="#addNew">
                                                            <i class="ft-x"></i> Cancel
                                                        </button>
                                                        <button type="submit" class="btn btn-primary mr-1">
                                                            <i class="ft-check"></i> Save
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- End: form -->
                                    <hr>
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

