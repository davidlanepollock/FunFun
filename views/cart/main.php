<script type="text/javascript" src="/public_files/javascript/cart_page.js"></script>
<?= Sessions::get('s_id'); ?>
<script type="text/javascript">
    cart_grab(<?= $this->auth; ?>);
</script>
<div class="product_core">
    <div class="product_picture">
        <div id="more_product_images">
            <img onclick="imageGrab()" class="product_side_image" <?php if($this->product['IMG0']==null){echo 'style="display=none;"';} ?> <?php if($this->js == false && !$this->product['IMG0']==null){echo 'src="' . $this->product['IMG0'] . '"';} ?> id="product_image_url0">
            <img onclick="imageGrab()" class="product_side_image" <?php if($this->product['IMG1']==null){echo 'style="display=none;"';} ?> <?php if($this->js == false && !$this->product['IMG1']==null){echo 'src="' . $this->product['IMG1'] . '"';} ?> id="product_image_url1">
            <img onclick="imageGrab()" class="product_side_image" <?php if($this->product['IMG2']==null){echo 'style="display=none;"';} ?> <?php if($this->js == false && !$this->product['IMG2']==null){echo 'src="' . $this->product['IMG2'] . '"';} ?>id="product_image_url2">
            <img onclick="imageGrab()" class="product_side_image" <?php if($this->product['IMG3']==null){echo 'style="display=none;"';} ?> <?php if($this->js == false && !$this->product['IMG3']==null){echo 'src="' . $this->product['IMG3'] . '"';} ?> id="product_image_url3">
            <img onclick="imageGrab()" class="product_side_image" <?php if($this->product['IMG4']==null){echo 'style="display=none;"';} ?> <?php if($this->js == false && !$this->product['IMG4']==null){echo 'src="' . $this->product['IMG4'] . '"';} ?> id="product_image_url4">
        </div>
        <div id="main_product_image">
            <img id="main_product_image_url" src="<?php if($this->js == false){echo $this->product['mainIMG'];} ?>">
        </div>

    </div>
    <div id="product_name_placeholder"></div>
    <div id="product_points_placeholder"></div>
    <div id="product_checkout">
        <div class="product_checkout_shipto"></div>
        <div class="product_checkout_button"> 
            <label>Quantity: </label>
            <select id="checkoutSelect" name="quantity"></select> 
            <div id="addproducttoCart"  class="product_checkout_button_cart">Add To Cart </div>
        </div>
    </div>

</div>
<div id="product_spec_placeholder"></div>
<div id="product_manu_desc"></div>
<div class="target_recommendations">
    <div id="product_also_viewed"></div>
    <div id="product_recommended"></div>
</div>