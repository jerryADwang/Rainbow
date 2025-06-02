<div class="container col-xl-10 col-xxl-8 py-5">
    <div class="row align-items-center g-lg-5 py-3">
      <div class="col-lg-7 text-center text-lg-start left_image">
        <!-- <h1 class="display-4 fw-bold lh-1 mb-3">Creating my shop</h1>
        <p class="col-lg-10 fs-4">Please fill in the form accurately to ensure that more users can find your restaurant</p> -->
        <img src="https://static.standard.co.uk/s3fs-public/thumbnails/image/2020/10/09/14/adidascarnabystreet09102020.jpg?width=1024&auto=webp&quality=50&crop=968%3A645%2Csmart" alt="background image">
      </div>
      <div class="col-md-10 mx-auto col-lg-5 pt-2">
      <?php echo form_open_multipart('shop/createmenu'); ?>
            <div class="p-4 p-md-5 border rounded-3 bg-light">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" required="required" placeholder="Roasted Pork" name="menuname">
                    <label for="floatingInput">Menu name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingprice" required="required" placeholder="$15.8" name="price">
                    <label for="floatingprice">Price</label>
                </div>
                <div class="error" style="color:red;"><?php echo form_error('shopname'); ?></div>
                <hr class="my-4">
                <div class="input-group input-group-sm col mt-4">
                    <h6 class="p-0">Upload you menu image</h6>
                    <small class="text-muted text-center p-0 pb-2 pr-5 col-md-12">We support png and jpg file.</small>
                    <div class="col-md-7 mt-1 ml-5 area text-center">
                        <h4 class="pt-4">Drop file or selected</h4> 
                        <input class="pl-5 pt-1" id="choose-file" type="file" name="userfile" > 
                        <?php echo $error;?>
                    </div>
                    <div class="col-md-12 pt-5">
                        <button class="w-100 btn btn-lg btn-primary" id="upload" type="submit">Create now</button>
                    </div>
                </div>
                <hr class="my-4">
                <small class="text-muted">Make sure the information is correct to create a new menu.</small>
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
.area {
    height:8rem;
    border:3px dashed black;
}
</style>


<script>
    $(document).on("input", "input:file", function(e) {
        $(this).prev().text(e.target.files[0].name);
    });
</script>