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
                                <h4 class="card-title">
                                    <a href="<?=base_url()?>expenses" class="btn btn-primary btn-sm">
                                        <i class="ft-arrow-left"></i> Back
                                    </a>
                                    
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

                               
                                    <form autocomplete="off" class="form ajaxsubmit save-expense-type reload-tb" action="<?=base_url('expense_type/save')?>" 
                                          method="POST" enctype="multipart/form-data" >
                                        <div class="row justify-content-center">
                                           <div class="col-md-4">
                                                <div class="form-group">
                                                    <input autocomplete="false"  name="name" id="name" class="form-control input-sm" placeholder="New Expense Type" />
                                                    <input type="hidden" name="id">
                                                </div>

                                            </div>


                                            <div class="col-sm-1">
                                                <div class="form-group">
                                                    <input type="submit" class="btn btn-primary btn-sm" value="Save" />

                                                </div>
                                                
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="form-group">
                                                    <input type="reset" class="btn btn-danger btn-sm" value="Cancel" />
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
            <!--/ Base style table -->
        </div>
    </div>
</div>
<!-- END: Content-->
<script type="text/javascript">
    $('body').on('click','.update-expense-type',function(event) {

        $('.save-expense-type [name=name]').val($(this).data('name'));
        $('.save-expense-type [name=id]').val($(this).data('id'));
    })
</script>
<script type="text/javascript">
    setTimeout(function() {
        if (!$('body').hasClass('menu-collapsed')) {
            sidebar_hide();
        }
    }, 1000);

    function setCookie(cname, cvalue, exdays) {
      const d = new Date();
      d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
      let expires = "expires="+d.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
      let name = cname + "=";
      let ca = document.cookie.split(';');
      for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }

    $(document).on('change','.propmaster',function(event) {
       var value = $(this).val();
       setCookie('property_id', value, 365);
       window.location.reload();
       //$('#tb').load('<?=base_url()?>propCalendar/calendar/'+value);
       // $.post('<?=base_url()?>propCalendar/calendar/'+value)
   })
</script>