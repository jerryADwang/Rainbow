<html>
  <head>
          <title>Rainbow</title>     
          <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
          <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/header.css">
          <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/login.css">           
          <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/register.css">
          <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/profile.css">
          <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/update.css">
          <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/shop.css">
          <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/home.css">
          <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/paypal.css">
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
          <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>
          <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script> 
          <script src="<?php echo base_url(); ?>assets/js/register.js"></script> 
          <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
  </head>
  <body>
<script>
        // Show select image using file input.
        function readURL(input) {
            $('#default_img').show();
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#select')
                        .attr('src', e.target.result)
                        .width(300)
                        .height(200);

                };

                reader.readAsDataURL(input. files[0]);
            }
        }
</script>
    <nav class="navbar">
      <a class="navbar-brand ml-4" role="button" href="<?php echo base_url().'home';?>">Rainbow</a>

    <!-- <div class="dropdown">
      <button class="btn btn-lg btn-danger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
        Dropdown button
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li><a class="dropdown-item" href="#">Action</a></li>
        <li><a class="dropdown-item" href="#">Another action</a></li>
        <li><a class="dropdown-item" href="#">Something else here</a></li>
      </ul>
    </div> -->
    
      <a class="btn btn-lg btn-outline-success  my-2 my-sm-0 bg-light" role="button" type="submit" href="<?php echo base_url().'home/show_nodification';?>">Message <i class="bi bi-chevron-down"></i></a>

      <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" id="nav-search-bar" type="search" placeholder="Search" aria-label="Search" name="searchtext">
          <!-- <button class="btn btn-lg btn-outline-success  my-2 my-sm-0 bg-light" href="<?php echo base_url().'search';?>" type="submit"><i class="bi bi-search"></i> Search</button> -->
      </form>

      <ul class="nav">
        <li class="navbar-choice">
          <a href="<?php echo base_url().'favorites';?>"> Wishlist &#32<i class="bi bi-bag-heart-fill"></i></a>
        </li>
        <li class="navbar-choice">
          <a href="<?php echo base_url().'manage';?>"> Manage shop </a>
        </li>
        <li class="navbar-choice">
          <a href="<?php echo base_url().'profile';?>"> User Profile </a>
        </li>

        <!-- 需要判断好看还是不需要 -->
        <!-- <?php if($this->session->userdata('logged_in')) : ?>
          <li class="navbar-choice">
          <a href="<?php echo base_url().'paypal';?>"> Memberships</a>
        <?php endif; ?> -->
        <li class="navbar-choice">
          <a href="<?php echo base_url().'paypal';?>"> Membership
            <!-- <div class="spinner-grow text-light" role="status">
              <span class="visually-hidden"></span>
            </div> -->
          </a>
        </li>

        <?php if(!$this->session->userdata('logged_in')) : ?>
          <li class="navbar-choice">
            <a href="<?php echo base_url(); ?>login"> Login </a>
          </li>
        <?php endif; ?>
        <?php if($this->session->userdata('logged_in')) : ?>
          <li class="navbar-choice">
            <a href="<?php echo base_url(); ?>login/logout"> Logout </a>
          </li>
        <?php endif; ?>
      </ul>  
    </nav>
    <div class="container">
      <div class="row mt-4 shop_collection" id="searchresult">
      </div>
    </div>
    
<script>
$(document).ready(function(){
load_data();
    function load_data(query){
        $.ajax({
        url:"<?php echo base_url(); ?>ajax/fatch_shop",
        method:"GET",
        data:{query:query},
        success:function(response){
            $('#searchresult').html("");
            if (response == "" ) {
                $('#searchresult').html(response);
            }else{
                var obj = JSON.parse(response);
                if(obj.length>0){
                    var items=[];
                    $.each(obj, function(i,val){
                        items.push($('<div class="col col-md-3 ml-2 mt-4">'+
                                        '<div class="row">'+
                                            '<div class="col col-md-2 pb-2" id="searchimage">'+                         
                                                '<a href='+'<?php echo base_url(); ?>'+ '/shop/shoppage/' + encodeURIComponent(val.name) + '> <img src='+'<?php echo base_url(); ?>'+ val.picturepath +' alt="user prifile image">'));
                        items.push($('<div class="col col-md-6 mt-4" style="border-bottom: 1px solid #949a9e;>'+
                                        '<div class="col col-md-10  content">'+
                                            '<h3 style="text-transform:capitalize;">' + val.name + '</h3>'+
                                            '<h4 class="mt-2 mb-2" style="color:blue;">' + val.location + '</h4>'+
                                                '<h5 style="text-transform:capitalize;">' + 'Type:&nbsp'+ val.type + '</h5>'));
                        items.push($('<div class="col col-md-2 p-0 mt-4">'+
                                        '<h4>'+val.price + '</h4>'));
                    });
                    $('#searchresult').append.apply($('#searchresult'), items);
                }else{
                    $('#searchresult').html('<div class="ml-5">'+'<h3>Shop Not Found!</h3>');
                };   
            };
        }
    });
    }
    $('#nav-search-bar').keyup(function(){
        var search = $(this).val();
        if(search != ''){
            load_data(search);
        }else{
            load_data();
        }
    });
});
</script>



