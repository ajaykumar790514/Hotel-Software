<link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
<script src="https://unpkg.com/dropzone"></script>
<script src="https://unpkg.com/cropperjs"></script>

<div class="card-body  my-gallery p-0" itemscope itemtype="http://schema.org/ImageGallery">
    <div class="row text-center">
        <form id="uploadfiles" action="<?=base_url()?>sub_properties/<?=$pro_id?>/saveimg/<?=$flat_id?>" method="POST" enctype="multipart/form-data" style="margin: auto;">
            <p class="text-success m-0 p-0" id="imgsuccess"></p>
            <p class="text-danger m-0 p-0" id="imgerror"></p>
            <label for="uploadimg">
                <img src="<?=base_url()?>static/app-assets/images/select-img.jpg" style="width:150px;" >
            </label>
            <input type="file" hidden="" id="uploadimg" name="image" >
            <!-- <input type="file" hidden="" id="uploadimg" name="image" onchange="$('#uploadfiles').submit()" > -->
        </form>

    </div>
    <div class="row" id="cropimgbox">
        <div class="col-md-3">
            <div class="preview"></div>
            <button type="button" id="crop" class="btn btn-primary btn-sm">Upload</button>
            <button  onclick="reset_modal()" class="btn btn-danger btn-sm">Cancel</button>
        </div>
        <div class="col-md-7">
           
        <img src="" id="sample_image" /> 
        </div>
        
        
        
    </div>
<style type="text/css">
    .img-wrap {
   position: relative;
    height: 225px;
    margin-top: 25px;

}
.img-wrap .close {
    position: absolute;
    top: 2px;
    right: 2px;
    z-index: 100;
    color:red;
    cursor: pointer;
}
.img-wrap img{
    width: 100%;
    max-height: 100%;
}
</style>
    <div class="row" id="images">
    <?php foreach ($rows as $row) { ?>
        <div class="col-md-3">
           <div class="img-wrap">
                <span class="close" data-delete="image" url="<?=base_url()?>delete_property_images/sub_property/<?=$row->id?>">&times;</span>
                <input type="checkbox" <?=($row->iscover==1) ? 'checked' : '' ?> data-id="<?=$row->id?>" > default 
                <img src="<?=img_base_url()?><?=$row->photo?>">
            </div> 
        </div>
        
    <?php } ?>
    </div>
    
</div>

<script type="text/javascript">
  $('[data-delete="image"]').click(function(){
    var $this = $(this);
    url = $this.attr('url');
    $.post(url,function(data){
        data = JSON.parse(data);
        console.log(data);
        if (data.res=='success') {
            $this.parent().parent().remove();
        }
        alert(data.msg);
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
    })
  })
</script>


        <style>

        


        img {
            display: block;
            max-width: 100%;
        }

        .preview {
            overflow: hidden;
            width: 160px; 
            height: 160px;
            margin: 10px;
            border: 1px solid red;
        }

       

        .overlay {
          position: absolute;
          bottom: 10px;
          left: 0;
          right: 0;
          background-color: rgba(255, 255, 255, 0.5);
          overflow: hidden;
          height: 0;
          transition: .5s ease;
          width: 100%;
        }

        .image_area:hover .overlay {
          height: 50%;
          cursor: pointer;
        }

        .text {
          color: #333;
          font-size: 20px;
          position: absolute;
          top: 50%;
          left: 50%;
          -webkit-transform: translate(-50%, -50%);
          -ms-transform: translate(-50%, -50%);
          transform: translate(-50%, -50%);
          text-align: center;
        }
        
        </style>



  


<script>

$(document).ready(function(){
        $('#cropimgbox').slideToggle();

    var $modal = $('#modalimg');

    var image = document.getElementById('sample_image');

    var cropper;

    $('#uploadimg').change(function(event){
        $('#uploadfiles').slideToggle();
        $('#cropimgbox').slideToggle();
        var files = event.target.files;

        var done = function(url){
            image.src = url;
            // $modal.modal('show');
        };

        if(files && files.length > 0)
        {
            reader = new FileReader();
            reader.onload = function(event)
            {
                done(reader.result);
                cropperr();
            };
            reader.readAsDataURL(files[0]);
        }
    });

    var cropperr =  function() {
        cropper = new Cropper(image, {
            aspectRatio: 4 / 3,
            viewMode: 3,
            movable:false,
            preview:'.preview'
        });
    };
    var cropperrdes = function(){
        cropper.destroy();
        cropper = null;
    };

    $('#crop').click(function(){
        canvas = cropper.getCroppedCanvas({
            width:400,
            height:400
        });

        canvas.toBlob(function(blob){
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function(){
                var base64data = reader.result;
                $.ajax({
                    url:'<?=base_url()?>sub_properties/<?=$pro_id?>/saveimgtest/<?=$flat_id?>',
                    method:'POST',
                    data:{image:base64data},
                    success:function(data)
                    {
                        cropperrdes();
                        reset_modal();
                    }
                });
            };
        });
    });


    
    
});
function reset_modal(){
    $('#showModal .modal-body').load('<?=base_url()?>sub_properties/<?=$pro_id?>/images/<?=$flat_id?>');
}
</script>