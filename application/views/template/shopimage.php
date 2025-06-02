<div class="container col-xl-10 col-xxl-8 py-5">
    <div class="row align-items-center g-lg-5 py-3">
      <div class="col-lg-7 text-center text-lg-start left_image">
        <!-- <h1 class="display-4 fw-bold lh-1 mb-3">Creating my shop</h1>
        <p class="col-lg-10 fs-4">Please fill in the form accurately to ensure that more users can find your restaurant</p> -->
        <img src="https://static.standard.co.uk/s3fs-public/thumbnails/image/2020/10/09/14/adidascarnabystreet09102020.jpg?width=1024&auto=webp&quality=50&crop=968%3A645%2Csmart" alt="background image">
      </div>
      <div class="col-md-10 mx-auto col-lg-5 pt-2">
        <?php echo form_open_multipart('manage/do_upload'); ?>
            <div class="p-4 p-md-5 border rounded-3 bg-light">
                <div class="input-group input-group-sm col mt-4">
                    <h6 class="p-0">Upload you shop's image</h6>
                    <small class="text-muted p-0 pb-5">&nbsp &nbsp We support png and jpg file.</small>
                    <div class="col-md-12">
                        <input id="choose-file"type="file" name="userfile" > 
                        <?php echo $error;?>
                    </div>
                    
                    <div class="col-md-12">
                        <button class="w-100 btn btn-lg btn-primary" id="upload" type="submit">Upload now</button>
                    </div>
                </div>
                <hr class="my-4">
                <small class="text-muted">Make sure the information is correct to create the restaurant.</small>
            </div>
            
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
  <div class="b-example-divider"></div>


<style>
.left_image img{
    width:40rem;
    height:41.5rem;
}
</style>