<main class="container" id="nodification">
</main>

<script>
load_data();
setInterval(load_data, 5000);
function load_data(){
    $.ajax({
    url:"<?php echo base_url(); ?>ajax/fatch_nodification",
    method:"GET",
    success:function(response){
        $('#nodification').html("");
        if (response == "" ) {
            $('#nodification').html(response);
        }else{
            var obj = JSON.parse(response);
            if(obj.length>0){
                var items=[];
                $.each(obj, function(i,val){
                    items.push($('<div class="bg-light p-5 rounded mt-3">'+'<h3 class="blockquote p-0 m-0" style="text-transform:capitalize; font-size:2rem;">'+val.shopname+'</h3>'+'<small class="blockquote-footer pt-2">'+val.time+'</small>'
                    +'<p class="lead pt-1">'+val.message+'</p>'+'<blockquote class="pl-2"><p>"'+val.text+'"</p></blockquote>'
                    +'<a class="btn btn-lg btn-primary" href='+'<?php echo base_url(); ?>'+ '/shop/shoppage/' + encodeURIComponent(val.shopname) + '/'+ val.id + ' role="button">Check it out »</a>'));
                });
                $('#nodification').append.apply($('#nodification'), items);      
            }else{
                $('#nodification').html('<div class="ml-5">'+'<h3>No message have leave!</h3>');
            }; 
        };
    }
});
}

</script>