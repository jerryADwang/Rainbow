<div class="container mt-0">
    <div class="shop">
        <div class="row pb-5">
            <div class="col col-md-4">
                <div class="mt-3 ml-5 pt-5" id="shopimage">
                    <img src="<?php echo $path ?>" alt="Shop's image">
                </div>
            </div>


            <div class="col col-md-6">
                <div class="shopname mt-5 pt-2">
                    <h2 style="text-transform:capitalize;"><?php echo $shopname ?></h2>
                    <h3><?php echo $price ?></h3>
                    <h4>Type: <?php echo $type ?></h4>
                    <h5>Location: <?php echo $location ?></h5>
                    <h5>Opening day: <?php echo $openingtime ?></h5>
                </div>
            </div>

            <div class="col col-md-2 mt-5 pt-2">  
                <div class="shopbookmark">
                    <a class="mt-2" role="button" href="<?php echo base_url().'shop/change_status';?>"><i class="<?php echo $status; ?>" style="color:red;"></i></a>
                </div>
                <h6><?php echo $count; ?> likes</h6>
                <div class="wishlist pl-5">
                    <a class="btn btn-outline-success bg-light" role="button" type="submit" href="<?php echo base_url().'shop/change_wishlist';?>"><?php echo $wishlist; ?> <i class="bi bi-bag-heart-fill"></i></a>
                </div>
            </div>

            <div class="col col-md-4">
                 <!-- Menu(M3) -->
            </div>
            <div class="col col-md-8 alert alert-info text-center" role="alert">

                
                <div class="row menu">
                    <div class="col col-md-7">
                        <h3 class="pb-2 text-right" style="color:black;">Menu</h3>
                    </div>
                    <div class="col col-md-5 text-left">
                        <?php echo form_open(base_url().'shop/show_add_menu'); ?>
                            <button class="btn btn-sm btn-outline-success bg-light" style="display:<?php echo $disable; ?>;"type="submit"><i class="bi bi-cloud-plus"></i>&nbspAdd new menu</button>
                        <?php echo form_close(); ?>
                    </div>
                    <?php if(isset($menulist)) 
                        foreach($menulist as $menu){
                        echo '
                            <div class="col col-md-4 mt-2">
                                <img src="https://infs3202-053734f9.uqcloud.net/rainbow/'.$menu->path.'" alt="Shops image">
                                <div class="text-center pt-2"><h4 class="mb-0" style="font-weight:400">'.$menu->menuname.'</h4></div>
                                <div class="text-center"><h5 style="font-weight:700">'.$menu->price.'</h5></div>
                            </div>
                        ';
                    }?>
                </div>
            </div>
            
            <div class="col col-md-4">
                <!-- google maps -->
            </div>

            <div class="col col-md-8 pr-5">
                <div class="commenttop ml-3 pb-1">
                    <div class="col col-md-8 pt-4 p-0">
                        <div class="row">
                            <div class="col col-md-4">
                                Comment
                            </div>
                            <div class="col col-md-6 pt-2">
                                <?php echo form_open(base_url().'shop/show_add_comment'); ?>
                                    <button class="btn btn-sm btn-outline-success bg-light addcomment" type="submit"><i class="bi bi-plus-circle-dotted"></i> New</button>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-3 pt-3 p-0">
                        <?php echo form_open('ajax'); ?>
                            <input class="form-control mr-sm-2" type="text" id="comment-search-bar" placeholder="Search" aria-label="Search">
                        <?php echo form_close(); ?>
                    </div>
                </div>

                <div class="commentbottom">

                    <div class="row mt-4" id="commentresult">
                    </div>
                    <div class="row" id="comments">
                    </div> 

                    <!-- <div class="row mt-4">
                        <div class="col col-md-2 ml-2">
                            <div class="row">
                                <div class="col col-md-2" id="commentimage">
                                    <img src="<?php echo base_url(); ?>/assets/img/default.jpg" alt="user prifile image">
                                </div>                                        
                            </div>
                        </div>
                        <div class="col col-md-7 commentsample">
                            <div class="col col-md-10  content">
                                <div class="usename">Jerry</div>
                                <small>Brisbane city</small>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
                                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                    Ut enim ad minim veniam</p>
                            </div>    
                        </div>
                        <div class="col col-md-2 p-0 commentsample">
                            <div class="commentright">
                                2022/04/22
                            </div>  
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>



<script>
$(document).ready(function(){
load_data();
    function load_data(query){
        $.ajax({
        url:"<?php echo base_url(); ?>ajax/fatch",
        method:"GET",
        data:{query:query},
        success:function(response){
            $('#commentresult').html("");
            if (response == "" ) {
                $('#commentresult').html(response);
            }else{
                var obj = JSON.parse(response);
                if(obj.length>0){
                    var items=[];
                    $.each(obj, function(i,val){
                        if (val.path == null) {
                            val.path ='uploads/default.jpg';
                        }
                        items.push($('<div class="col col-md-2 ml-2 mt-4 bg-light">'+
                                        '<div class="row">'+
                                            '<div class="col col-md-2" id="commentimage">'+
                                                '<img src='+'<?php echo base_url(); ?>'+ val.path +' alt="user prifile image">'));
                        items.push($('<div class="col col-md-7 mt-4 commentsample bg-light">'+
                                        '<div class="col col-md-10  content">'+
                                            '<div class="usename">' + val.username + '</div>'+
                                            '<small style="color:blue;">' + val.location + '</small>'+
                                                '<p>' + val.comment + '</p>'));
                        items.push($('<div class="col col-md-2 p-0 mt-4 commentsample bg-light">'+
                                        '<div class="commentright">'+val.time + '</div>'));
                    });
                    $('#commentresult').append.apply($('#commentresult'), items);
                }else{
                    $('#commentresult').html('<div class="ml-5">'+'<h3>Comments Not Found!</h3>');
                };   
            };
        }
    });
    }
    $('#comment-search-bar').keyup(function(){
        var search = $(this).val();
        if(search != ''){
            load_data(search);
        }else{
            load_data();
        }
    });
});

$(document).ready(function(){
load_data();//这两行干嘛的？
    function load_data(){
        $.ajax({
        url:"<?php echo base_url(); ?>ajax/fatch_comment",
        method:"GET",
        success:function(response){
            $('#comments').html("");
            if (response == "" ) {
                $('#comments').html(response);
            }else{
                var obj = JSON.parse(response);
                if(obj.length>0){
                    var items=[];
                    $.each(obj, function(i,val){
                        if (val.path == null) {
                            val.path ='uploads/default.jpg';
                        }
                        items.push($('<div class="col col-md-2 ml-2 mt-4">'+
                                        '<div class="row">'+
                                            '<div class="col col-md-2" id="commentimage">'+
                                                '<img src='+'<?php echo base_url(); ?>'+ val.path +' alt="user prifile image">'));
                        items.push($('<div class="col col-md-7 mt-4 commentsample">'+
                                        '<div class="col col-md-10  content">'+
                                            '<div class="usename">' + val.username + '</div>'+
                                            '<small style="color:blue;">' + val.location + '</small>'+
                                                '<p class="pt-2 pb-2">' + val.comment + '</p>'+'<'));
                        items.push($('<div class="col col-md-2 p-0 mt-4 commentsample">'+
                                        '<div class="commentright">'+val.time + '</div>'));
                  
                    });

                    $('#comments').append.apply($('#comments'), items);      
                }else{
                    $('#comments').html('<div class="ml-5">'+'<h3>No comment have leave!</h3>');
                }; 
            };
        }
    });
    }
});
</script>