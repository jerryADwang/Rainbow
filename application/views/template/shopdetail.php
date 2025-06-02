<div class="container col-xl-10 col-xxl-8 py-5">
    <div class="row align-items-center g-lg-5 py-3">
      <div class="col-lg-7 text-center text-lg-start left_image">
        <!-- <h1 class="display-4 fw-bold lh-1 mb-3">Creating my shop</h1>
        <p class="col-lg-10 fs-4">Please fill in the form accurately to ensure that more users can find your restaurant</p> -->
        <img src="https://static.standard.co.uk/s3fs-public/thumbnails/image/2020/10/09/14/adidascarnabystreet09102020.jpg?width=1024&auto=webp&quality=50&crop=968%3A645%2Csmart" alt="background image">
      </div>
      <div class="col-md-10 mx-auto col-lg-5 pt-2">
        <?php echo form_open(base_url().'manage/verifyshop'); ?>
            <div class="p-4 p-md-5 border rounded-3 bg-light">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" required="required" placeholder="The Pancake Manor" name="shopname">
                    <label for="floatingInput">Shop name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingPassword" required="required" placeholder="Pancake" name="type">
                    <label for="floatingPassword">Shop type</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingPassword" required="required" placeholder="9am - 9pm (Mon-Fri)" name="openingday">
                    <label for="floatingPassword">Opening day</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingPassword" required="required" placeholder="18 Charlotte St" name="location">
                    <label for="floatingPassword">Location</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingPassword" required="required" placeholder="$20-$50 pp." name="pp">
                    <label for="floatingPassword">Average price pp.</label>
                </div>
                <div class="error" style="color:red;"><?php echo form_error('shopname'); ?></div>

                <button class="w-100 btn btn-lg btn-primary" type="submit" <?php echo $disable; ?>><?php echo $placeholder; ?></button>

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