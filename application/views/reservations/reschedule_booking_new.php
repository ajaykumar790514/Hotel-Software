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
                                <?=$title?>
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
                            <div class="card-content" id="addNew">
                                <div class="card-body">
                                    <!-- form -->
                                    <!-- <form class="form ajaxsubmit reload-tb" action="<?=base_url()?>reviews_source/save" method="POST" enctype="multipart/form-data"> -->
                                        <div class="form-body">
                                            <h4 class="form-section">
                                                <?=$title?>
                                            </h4>
                                            
                                        </div>
                                    <!-- </form> -->
                                    <!-- End: form -->
                                    <hr>
                                </div>
                            </div>
<style type="text/css">
    td{
        vertical-align: middle!important;
    }
</style>
                            <div class="card-content collapse show" >
                                
                                <section>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="d-flex flex-row-reverse">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="year">Year</label>
                                                        <select id="year" name="year" class="form-control input-sm" >
                                                            <option value="2021">2021</option>
                                                            <option value="2022">2022</option>
                                                            <option value="2023">2023</option>
                                                            <option value="2024">2024</option>
                                                        </select>
                                                    </div>
                                                    
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="month">Month</label>
                                                        <select id="month" name="month" class="form-control input-sm">
                                                            <option value="01">January</option>
                                                            <option value="02">February</option>
                                                            <option value="03">March</option>
                                                            <option value="04">April</option>
                                                            <option value="05">May</option>
                                                            <option value="06">June</option>
                                                            <option value="07">July</option>
                                                            <option value="08">August</option>
                                                            <option value="09">September</option>
                                                            <option value="10">October</option>
                                                            <option value="11">November</option>
                                                            <option value="12">December</option>
                                                           
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 p-3" id="tb" >
                                            
                                        </div>
                                    </div>
                                </section>
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
$('#month').val('<?=$month?>');
$('#year').val('<?=$year?>');

$(document).on('change','#month,#year',function(event){
    var month = $('#month').val();
    var year  = $('#year').val();
    var uri = "m="+month+"&y="+year;
    var url = "<?=$cal_url?>"+uri;
    loadtb(url);
})
</script>
