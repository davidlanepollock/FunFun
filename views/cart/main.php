<script type="text/javascript" src="/public_files/javascript/cart_page.js"></script>
<?= Sessions::get('s_id'); ?>
<script type="text/javascript">
    cart_grab(<?= $this->auth; ?>);
</script>
<div class="core-con">
    <div class="cart_core">
        <div class="product_cart">
            <div id="cart-head">Product Cart</div>
            <div id="cart-items">
                <div id="cart-item">
                    <div id="cart-item-picture"></div>
                    <div id='cart-item-title'>Title of Product Here
                        <div id="cart-item-seller">By: MSD Merch</div>

                    </div>
                    <div id='cart-item-quantity'></div>
                    <div id='cart-item-price'>
                        <div id="cart-item-o-price">$19.33</div>
                        <div id='cart-item-s-price'>$14.95</div>
                    </div>
                    <div id="cart-actions">
                        <div id='cart-item-remove'>X</div>
                        <div id="cart-item-save">Save</div>
                    </div>
                </div>

            </div>
        </div>
        <div id="cart-total">

            <div id="cart-total-price">
                Subtotal: $123.33
            </div>
            <div id="cart-total-shippingtax">
                Estimated Shipping & Tax: $9.95
            </div>
            <div id="cart-total-final">
                Estimated Total: $150.22
            </div>
            <input type="button" id="cart-checkout-button" value="Proceed To Checkout">
            <input type="button" id="cart-return-button" value="Continue Shopping">
        </div>

    </div>
    <div id="product_spec_placeholder"></div>
    <div id="product_manu_desc"></div>
    <div class="target_recommendation">
        <div id="product_also_viewed"></div>
        <div id="product_recommended"></div>
    </div>
</div>