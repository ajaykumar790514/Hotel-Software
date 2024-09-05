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
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                                <form autocomplete="off" class="form dynamic-tb-search" action="<?=$tb_url?>" method="POST" enctype="multipart/form-data" tagret-tb="#tb">
                                <div class="row justify-content-center mt-2">
                                <div class="col-sm-2 col-md-2">
                                <div class="form-group">
                                <label for="property">Arrival</label>
                                <input type="date"  class="form-control input-sm" name="start_date" >
                                </div>
                                </div>
                                <div class="col-sm-2 col-md-2">
                                <div class="form-group">
                                <label for="property">Departure</label>
                                <input type="date"  class="form-control input-sm" name="end_date" >
                                </div>
                                </div>
                                    <div class="col-md-3">
                                       <div class="form-group">
                                       <label for="property">Property</label>
                                       <select id="property" name="property" class="form-control input-sm property">
                                      <?php echo optionStatus('', '-- Select --', 1);
                                      foreach ($propmaster as $prop) {
                                      echo optionStatus($prop->id, $prop->propname, 1);
                                      }?>
                                       </select>
                                       </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button type="button"  id="button-excel" class="btn btn-sm btn-primary" style="margin-top:2rem">Export Excel</button>
                                        </div>

                                    </div>
                                </div>
                                </form>
                            </div>
                            <div class="card-content collapse show" id="tb">
                                

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<!-- END: Content-->

<script>
    
    let button = document.querySelector("#button-excel");

button.addEventListener("click", e => {
  let table = document.querySelector("#tb");

  // Get the current date and time
  let currentDateTime = new Date().toISOString().replace(/[-T:\.Z]/g, "");

  // Construct the dynamic file name
  let fileName = `expanse_report_export_${currentDateTime}.xlsx`;

  // Use TableToExcel.convert with the dynamic file name
  TableToExcel.convert(table, { name: fileName });
});
</script>
