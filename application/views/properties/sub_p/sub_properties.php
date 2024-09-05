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
                                <a href="<?=base_url()?>properties">Properties</a>
                            </li>
                            <li class="breadcrumb-item active">
                               Rooms List
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
                                    <a href="<?=base_url()?>sub_properties/<?=$propertyrow->id?>/new" class="btn btn-primary btn-sm add-btn"> 
                                        <i class="ft-plus"></i> Add Rooms
                                    </a>

                                    <select class="form-control input-sm btn-tb-f" onchange="properties(this)" >
                                    
                                        <?php
                                        echo optionStatus('','-- Select --');
                                        foreach ($properties as $row) {
                                            $selected = '';
                                            // if ($row->id==@$_COOKIE['property_id']) {
                                            //     $selected = 'selected';
                                            // }
                                            echo optionStatus($row->id,$row->propname,$row->status,$selected);
                                        }
                                        ?>
                                    </select>
                                    <select id="properties_type" class="form-control input-sm btn-tb-f" onchange="properties_type(this)">
                                     <option value="" >-- Select --</option>
                                     </select>
                                <!--     <select class="form-control input-sm btn-tb-f" onchange="properties_type(this)" >
                                        <?php
                                        foreach ($properties_type as $row) {
                                            $selected = '';
                                            if ($row->spt_id==$propertyrow->id) {
                                                $selected = 'selected';
                                            }
                                            echo optionStatus($row->spt_id,$row->name,$row->active,$selected);
                                        }
                                        ?>
                                    </select> -->

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
function properties(e) {
    var pro_id  = $(e).val();
    $('#properties_type').load('<?=base_url()?>getSubPropertyType/'+pro_id);
    // var url     = '<?//=base_url()?>sub_properties/'+pro_id+'/tb';
    // $('#tb').load(url);
    // window.history.pushState('page2', 'Title', '<?//=base_url()?>sub_properties/'+pro_id);

}

function properties_type(e) {
    var pro_id  = '<?=$propertyrow->id?>';
    var type_id  = $(e).val();
    var url     = '<?=base_url()?>sub_properties/'+pro_id+'/tb/'+type_id;
    $('#tb').load(url);
    // window.history.pushState('page2', 'Title', '<?=base_url()?>sub_properties/'+pro_id);
}

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
