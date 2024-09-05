<div class="card-body  my-gallery p-0" itemscope itemtype="http://schema.org/ImageGallery">
    <div class="row text-center">
        <div class="col-md-12">
          <p class="text-danger m-0 p-0">Maximum File Size 100 kb.</p>
        </div>
        <form id="uploadfiles" action="<?=base_url()?>properties/saveimg/<?=$property_id?>" method="POST" enctype="multipart/form-data" style="margin: auto;">
            <p class="text-success m-0 p-0" id="imgsuccess"></p>
            <p class="text-danger m-0 p-0" id="imgerror"></p>
            <label for="uploadimg">
                <img src="<?=base_url()?>static/app-assets/images/select-img.jpg" style="width:150px;" >
            </label>
            <input type="file" hidden="" id="uploadimg" name="image[]" multiple="multiple" >
        </form>
    </div>
<style type="text/css">
/*.img-sm {
    height: 225px;
    max-height: 225px;
    max-width: 255px;
}*/

.change-indexing-left,.change-indexing-right{
  position: absolute;
  height: 30px;
  display: flex;
  align-items: center;
  cursor: pointer;
}
.change-indexing-left{
  left: 5px;
}
.change-indexing-right{
  right: 5px;
}
.change-indexing{
  padding:2px 25px;
  height: 30px;
  width: 100px;
  text-align: center;
}


</style>
    <div class="row" id="images">
      <div class="table-responsive pt-1">
        <table class="table table-striped table-bordered base-style" id="mytable">
          <thead>
            <tr>
               <th>Sr. no.</th>
               <th>Image</th>
               <th>Default</th>
               <th>Description</th>
               <th>Order</th>
               <th style="width: 180px;">Action</th>
            </tr>
          </thead>
          <tbody class="sortable">
              <?php $i=1;
               foreach ($rows as $row) { ?>
                <tr id="<?=$row->id?>">
                  <td><?=$i?></td>
                  <td>
                    <img class="image-sm zoom-img" src="<?=IMGS_URL.$row->photo?>" >
                  </td>
                  <td>
                    <input type="checkbox" <?=($row->iscover==1) ? 'checked' : '' ?> data-id="<?=$row->id?>" > 
                  </td>
                  <td>
                    <textarea class="img-details" data-id="<?=$row->id?>"><?=$row->details?></textarea>
                  </td>
                  <td>
                    <div class="input-group">
                      <span class="change-indexing-left">
                        <i class="la la-arrow-circle-up" aria-hidden="true"></i>
                      </span>
                      <input type="number" class="icon-inside-input change-indexing"  value="<?=$row->indexing?>" data="<?=$row->id?>,propertypic,id,indexing" min="0" >
                      <span class="change-indexing-right">
                        <i class="la la-arrow-circle-down mr-1" aria-hidden="true"></i>
                      </span>
                    </div>
                  </td>
                  <td>
                    <a href="javascript:void(0)" data-delete="image" url="<?=base_url()?>delete_property_images/sub_property/<?=$row->id?>"><i class="la la-trash"></i></a>
                  </td>
                </tr>
             <?php $i++; } ?>
          </tbody>
        </table>
      </div>
    </div>
    
</div>

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
  $('[data-delete="image"]').click(function(){
    var $this = $(this);
    url = $this.attr('url');
    $.post(url,function(data){
        data = JSON.parse(data);
        console.log(data);
        if (data.res=='success') {
            $this.parent().parent().remove();
        }
        alert_toastr(data.res,data.msg);
    })
  }) 


$('#images input[type="checkbox"]').change(function(event){
    $this = $(this);
    id = $this.attr('data-id');
    if (event.currentTarget.checked) {
        $('#images input[type="checkbox"]').prop('checked', false);
        $this.prop('checked', true);
       var type = 'setDefault';  
    }
    else{
        var type = 'removeDefault';
    }
    $.post('<?=base_url()?>sp_default_image',{id:id,type:type})
    .done(function(data){
        console.log(data);
        data = JSON.parse(data);
        alert_toastr(data.res,data.msg);
    })
  })

  var timer;
  $(document).on('keyup','#images .img-details' ,function(event) {
    clearInterval(timer);
    $this = $(this);
    timer = setTimeout(function() {
      var details = $this.val();
      var id = $this.attr('data-id');
      $.post('<?=base_url()?>properties/img_details/<?=$property_id?>',{id:id,details:details})
      .done(function(data){
        console.log(data);
        data = JSON.parse(data);
        alert_toastr(data.res,data.msg);
      })
    }, 1000);
    })
  
</script>  


<script>
function reset_modal(){
    $('#showModal .modal-body').load('<?=base_url()?>properties/images/<?=$property_id?>');
}
</script>