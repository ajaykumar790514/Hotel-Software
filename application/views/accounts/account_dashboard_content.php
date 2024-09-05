<div class="content-wrapper">
    <div class="content-wrapper-before"></div>
    <div class="content-header row">
        <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Accounts</h3>
            <div class="breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper mr-1">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashbord</a>
                        </li>
                        
                        <li class="breadcrumb-item active">Accounts
                        </li>
                    </ol>
                </div>
            </div>
        </div>
       
    </div>
    <div class="content-body">
       

        <!-- line chart section start -->
        <section id="chartjs-line-charts">
            <!-- Line Chart -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <!-- <h4 class="card-title">Income &nbsp; - ₹ <?=$totalIncome?></h4>
                            <h4 class="card-title">Expense - ₹ <?=$totalExpense?> (demo)</h4> -->
                            

                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li>
                                        <form class="form-inline load-content" action="<?=base_url()?>accountChart" method="POST" data-target="#chart"> 

                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                   <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                <i class="ft-calendar"></i>&nbsp;
                                                <span></span> <i class="ft-chevron-down"></i>
                                            </div>
                                            <input type="hidden" name="daterange" id="daterangepickerinput">
                                                </div>
                                               
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
                        <div class="card-content collapse show">
                            <div class="card-body chartjs">
                                <div class="" id="chart">
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           
        </section>
        <!-- // line chart section end -->
      
    </div>
</div>


<script>

$(document).ready(function(){
// $(function() {
    setTimeout(function() {

    var start = moment().subtract(6, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $('#daterangepickerinput').val(start.format('YYYY-MM-DD') + ' , ' + end.format('YYYY-MM-DD'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

    $('.load-content').submit();

    }, 100);

});

 
</script>




    