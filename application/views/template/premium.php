


<div class="container">
    <div class="row mb-3 text-center mt-5  paypal">
        <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h4 class="my-0 fw-normal">Pro</h4>
            </div>
            <div class="card-body privilege">
                <h1 class="card-title pricing-card-title pb-3">$30<small class="text-muted fw-light">/month</small></h1>
                <ul class="list-unstyled mt-3 mb-4">
                    <li>5 coupons included</li>
                    <li>Help center access</li>
                    <li>Wishlist center access</li>
                    <li>Dozens of Restaurant Exclusive Coupons</li>
                    <li>Read a restaurant review</li>
                </ul>
                <a type="button" class="w-100 btn btn-lg btn-primary" href="<?php echo base_url().'paypal/level/pro';?>">Choose</a>
            </div>
            </div>
        </div>
        <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm border-primary">
            <div class="card-header py-3 text-white bg-primary border-primary">
                <h4 class="my-0 fw-normal">Premium</h4>
            </div>
            <div class="card-body privilege">
                <h1 class="card-title pricing-card-title pb-3">$49<small class="text-muted fw-light">/month</small></h1>
                <ul class="list-unstyled mt-3 mb-4">
                    <li>10 coupons included</li>
                    <li>Help center access</li>
                    <li>Wishlist center access</li>
                    <li>Hundreds of Restaurant Exclusive Coupons</li>
                    <li>Read and Search for a restaurant review</li>
                </ul>
                <a type="button" class="w-100 btn btn-lg btn-primary" href="<?php echo base_url().'paypal/level/premium';?>">Choose</a>
            </div>
            </div>
        </div>
    </div>
</div>

<div class="mb-2 pb-2" style="text-align: center;">
    <h3><?php echo $error; ?></h3>
</div>



<div id="smart-button-container">
    <div style="text-align: center;">
        <div id="paypal-button-container"></div>
    </div>
</div>
<script src="https://www.paypal.com/sdk/js?client-id=sb&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>
<script>
function initPayPalButton() {
    paypal.Buttons({
    style: {
        shape: 'rect',
        color: 'gold',
        layout: 'vertical',
        label: 'checkout',
        
    },

    createOrder: function(data, actions) {
        return actions.order.create({
        purchase_units: [{"description":"Premium level ","amount":{"currency_code":"USD","value":0.02}}]
        });
    },

    onApprove: function(data, actions) {
        return actions.order.capture().then(function(orderData) {
        
        // Full available details
        console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

        $.ajax({
        url:"<?php echo base_url(); ?>profile/update_membership",
        method:"GET",
        data:{level:"Premium"},
        success:function(){
            const element = document.getElementById('paypal-button-container');
            element.innerHTML = '';
            element.innerHTML = '<h3>Thank you for your payment!</h3>';
        }
        });

        // window.location.href = 'https://infs3202-053734f9.uqcloud.net/rainbow/profile/update_membership/Premium';
        
        });
    },

    onError: function(err) {
        console.log(err);
    }
    }).render('#paypal-button-container');
}
initPayPalButton();
</script>