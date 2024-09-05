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
                                    <form autocomplete="off" class="form ajaxsubmit save-expenses reload-tb" action="<?=base_url('expenses/save')?>" 
                                          method="POST" enctype="multipart/form-data" >
                                        <div class="row ">
                                            <div class="col"><h3>Add Expense</h3></div>
                                        </div>
                                        <input type="hidden" name="prop_master_id" value="<?=@$_COOKIE['property_id'];?>">
                                        <div class="row justify-content-end">
                                            <!-- <div class="col-md-2">
                                                <div class="form-group">
                                                    <select id="prop_master_id" name="prop_master_id" class="form-control input-sm">
                                                    <?php
                                                        // echo optionStatus('','-- Select Property --');
                                                        // foreach ($propmaster as $row) {
                                                        //     $title = $row->propname .'( '.$row->propcodename.' ) - '.title('cities',$row->city,'id','name');
                                                        //     echo optionStatus($row->id,$title);
                                                        // }
                                                    ?>
                                                    </select>
                                                    <input type="hidden" name="id">
                                                </div>
                                            </div>  -->

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <select id="expense_master_id" name="expense_master_id" class="form-control input-sm">
                                                    <?php
                                                        echo optionStatus('','-- Select Expense Type --');
                                                        foreach ($expmaster as $row) {
                                                            echo optionStatus($row->id,$row->name);
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div> 
                                           <div class="col-md-2">
                                                <div class="form-group">
                                                    <input type="number" autocomplete="false"  name="amount" id="amount" class="form-control input-sm" placeholder="Amount" />
                                                </div>

                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    
                                                    <input type="datetime-local" id="date_time"name="date_time" value="<?=date('Y-m-d\TH:i')?>" max="<?=date('Y-m-d\TH:i')?>" class="form-control input-sm">
                                                </div>

                                            </div>

                                            <div class="col-md-3">
                                              
                                                <fieldset class="form-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input form-control input-sm" id="photo" name="photo">
                                                        <input type="hidden" name="old_receipt" >
                                                        <label class="custom-file-label input-sm" for="inputGroupFile01">Choose Receipt</label>
                                                    </div>
                                                    <label for="" class="text-danger">Maximum file size 100 kb.</label>
                                                </fieldset>
                                                
                                            </div>


                                            <div class="col-sm-1">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary btn-sm" value="Save" >Save</button>

                                                </div>
                                                
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="form-group">
                                                    <input type="reset" class="btn btn-danger btn-sm" value="Cancel" />
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </form>
                                   
                                </h4>
                                
                                
                            </div>
                           
                        </div>
                    </div>
                </div>
            </section>
            <!--/ Base style table -->
           <!-- Base style table -->
            <section id="base-style">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                    
                                    <a href="<?=base_url()?>expense_type" class="btn btn-primary btn-sm ml-1">
                                        <!-- <i class="ft-plus"></i>  -->
                                        Manage Expanse Type
                                    </a>
                                </h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li>
                                        <?php 
                                        // echo prx($_POST);
                                         ?>
                                        <form class="form-inline" action="" method="POST"> 
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <input type="date" name="from" class="form-control input-sm" placeholder="From" value="<?=$from?>">
                                                </div>
                                                <input type="date" name="to" class="form-control input-sm" placeholder="To" value="<?=$to?>">
                                                <div class="input-group-append">
                                                    <input type="submit" class="btn btn-sm btn-primary text-white" value="Apply">
                                                </div>
                                            </div>
                                        </form>
                                    </li>
                                    <li><a data-action="reload" class="reload-page"><i class="ft-rotate-cw"></i></a></li>
                                   
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
<script type="text/javascript">
      $('input[type="file"]').bind('change', function() {
        var fileSizeInBytes=(this.files[0].size);
        //alert(a);
        var fileSizeInKB = fileSizeInBytes / 1024; // Convert bytes to KB
        if(fileSizeInKB > 100) {
            alert_toastr('error','Maximum file size should be 100 KB.');
            $('button[type=submit]').prop('disabled', true);
        }else{
            $('button[type=submit]').prop('disabled', false);
        }
    });
    $('body').on('click','.update-expenses',function(event) {
        $('.save-expenses [name=prop_master_id]').val($(this).data('prop_master_id'));
        $('.save-expenses [name=expense_master_id]').val($(this).data('expense_master_id'));
        $('.save-expenses [name=amount]').val($(this).data('amount'));
        $('.save-expenses [name=date_time]').val($(this).data('date_time'));
        $('.save-expenses [name=old_receipt]').val($(this).data('old_receipt'));
        $('.save-expenses [name=id]').val($(this).data('id'));
    })
</script>