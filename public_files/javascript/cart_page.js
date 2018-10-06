/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var mainIMG;
var IMG1;
var IMG2;
var IMG3;
var IMG4;
function cart_grab(product_auth)
{
    jQuery.ajax({
        type: "POST",
        url: '/shoppingcart/grab_cart',
        dataType: 'json',
        data: {auth: product_auth},
        
        success: function (obj) {
            document.getElementById('cart-items').innerHTML = '';
            for(var i = 0; i < obj.length; i++)
            {
                var newElement = document.createElement('div');
                newElement.setAttribute('id', 'cart-item');
                newElement.innerHTML = '<div id="cart-item-picture"></div>\n\
                <div id="cart-item-title">'+obj[i].product_info.name +'\n\
                <div id="cart-item-seller">By: MSD Merch</div></div>\n\
                <div id="cart-item-quantity"></div>\n\
                <div id="cart-item-price">\n\
                <div id="cart-item-o-price">$19.33</div>\n\
                <div id="cart-item-s-price">$14.95</div></div>\n\
                <div id="cart-actions">\n\
                <div id="cart-item-remove" onClick="removefromCart('+obj[i].product_id + ',' + obj[i].seller_id +')">X</div>\n\
                <div id="cart-item-save">Save</div></div></div>';
           document.getElementById('cart-items').appendChild(newElement);
           
        
                }
        }}

    );

    // return false;
    return false;
}
;
function addtoCart(product_id, seller_id)
{
    var selected = document.getElementById('checkoutSelect');
    var product_quantity = selected.options[selected.selectedIndex].value;
    jQuery.ajax({
        type: "POST",
        url: '/product/add_cart',
        dataType: 'json',
        data: {id: product_id, sid: seller_id, quantity: product_quantity},

        success: function (obj) {
            
            print("hello");
        }})
}
;
function removefromCart(product_id, seller_id)
{
    jQuery.ajax({
        type: "POST",
        url: '/shoppingcart/remove_cart',
        dataType: 'json',
        data: {id: product_id, sid: seller_id},

        success: function (obj) {
            
            //if successfully removed
            window.location.reload(true); 
        }})
    window.location.reload(true); 
}
;
function checkoutQuantity(quantity)
{
    var checkoutQuantity = document.getElementById('checkoutSelect');
    for (var i = 0; i < quantity; i++)
    {
        checkoutQuantity.innerHTML += "<option id='q" + (i + 1) + "'>" + (i + 1) + "</option>;";
    }
}
function hideSidePictures()
{
    document.getElementById('product_image_url0').style = "visability: hidden;";
    document.getElementById('product_image_url1').style = "visability: hidden;";
    document.getElementById('product_image_url2').style = "visability: hidden;";
    document.getElementById('product_image_url3').style = "visability: hidden;";
    document.getElementById('product_image_url4').style = "display: none;";
}

function imageGrab()
{
    var target = event.target || event.srcElement;
    var clickIMG = target.id;
    transparentBorder();
    switch (clickIMG)
    {
        case "product_image_url0":
            document.getElementById('main_product_image_url').src = IMG0;
            document.getElementById('product_image_url0').style = "border: 2px solid red";
            break;
        case "product_image_url1":
            document.getElementById('main_product_image_url').src = IMG1;
            document.getElementById('product_image_url1').style = "border: 2px solid red";
            break;
        case "product_image_url2":
            document.getElementById('main_product_image_url').src = IMG2;
            document.getElementById('product_image_url2').style = "border: 2px solid red";
            break;
        case "product_image_url3":
            document.getElementById('main_product_image_url').src = IMG3;
            document.getElementById('product_image_url3').style = "border: 2px solid red";
            break;
        case "product_image_url4":
            document.getElementById('main_product_image_url').src = IMG4;
            document.getElementById('product_image_url4').style = "border: 2px solid red";
            break;

    }
}
function transparentBorder()
{
    document.getElementById('product_image_url0').style = "border: 2px solid tranparent";
    document.getElementById('product_image_url1').style = "border: 2px solid tranparent";
    document.getElementById('product_image_url2').style = "border: 2px solid tranparent";
    document.getElementById('product_image_url3').style = "border: 2px solid tranparent";
    document.getElementById('product_image_url4').style = "border: 2px solid tranparent";

}
;
