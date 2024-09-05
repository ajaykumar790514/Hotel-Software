<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
            <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block"><?= $title ?></h3>
                <div class="breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper mr-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url() ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <?= $title ?> List
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <style type="text/css">
            .res-page,
            .res-page input,
            .res-page select {
                font-size: 13px !important;
            }
        </style>
        <div class="content-body">
            <!-- Base style table -->
            <section id="base-style">

                <div class="row">

                    <div class="col-12">
                        <div class="card res-page" style="font-size:13px!important">
                            <div class="card-header p-1 pb-0">







                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>


                            </div>

                            <div class="card-content collapse show">
                                <?php // prx($checkin); ?>
                                <div class="table-responsive">
                                    <form class="form ajaxsubmit reload-page" action="<?= $action_url ?>" method="POST" enctype="multipart/form-data">
                                        <table class="table  vertical-align-middle">
                                            <thead>
                                                <tr>
                                                    <th center>Guests</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                echo "<tr> <th>Adults</th> </tr>";
                                                for ($i = 0; $i < $checkin->of_adults; $i++) {
                                                    $id_append = '_adults' . $i;
                                                    
                                                    $type = 'adults';
                                                    echo "<tr>";
                                                    echo "<td class='tb-width-fit-content'>";
                                                    include 'guests_input.php';
                                                    echo "</td>";
                                                    echo "</tr>";
                                                }
                                                if (@$checkin->of_children) {
                                                    echo "<tr> <th>Children</th> </tr>";
                                                    for ($i = 0; $i < $checkin->of_children; $i++) {
                                                        $id_append = '_children' . $i;
                                                        $type = 'children';
                                                        echo "<tr>";
                                                        echo "<td class='tb-width-fit-content'>";
                                                        include 'guests_input.php';
                                                        echo "</td>";
                                                        echo "</tr>";
                                                    }
                                                }

                                                if (@$checkin->of_infant) {
                                                    echo "<tr> <th>Children</th> </tr>";
                                                    for ($i = 0; $i < $checkin->of_infant; $i++) {
                                                        $id_append = '_infant' . $i;
                                                        $type = 'infant';
                                                        echo "<tr>";
                                                        echo "<td class='tb-width-fit-content'>";
                                                        include 'guests_input.php';
                                                        echo "</td>";
                                                        echo "</tr>";
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        
                                            <div class="col-12 p-5">
                                                <div class="form-action float-right">
                                                    <input type="reset" class="btn btn-sm btn-danger mr-1" value="Reset">
                                                    <button type="submit" class="btn btn-sm btn-primary" value="Submit">Submit</button>
                                                </div>
                                            </div>

                                       
                                    </form>
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
    // $('body').on('focusin','input[type="date"]',function(e){
    //     // alert()
    //     e.which = 32;
    //     $('body').trigger(e);
    //     // $( this ).trigger({type: 'keypress', which: 32, keyCode: 32});
    // })
</script>
