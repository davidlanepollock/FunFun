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
            document.getElementById('product_name_placeholder').innerHTML = obj.outputproduct.name;
            document.getElementById('product_points_placeholder').innerHTML = obj.outputproduct.desc;
            checkoutQuantity(obj.outputproduct.checkoutquantity);
            document.getElementById('product_manu_desc').innerHTML = obj.outputproduct.manufacturer;
            document.getElementById('product_also_viewed').innerHTML = obj.outputproduct.othersViewed;
            document.getElementById('product_recommended').innerHTML = obj.outputproduct.recommended;
            document.getElementById('product_spec_placeholder').innerHTML = obj.outputproduct.specs;
            document.getElementById('main_product_image_url').src = obj.outputproduct.mainIMG;
            document.getElementById('product_image_url0').src = obj.outputproduct.smainIMG;
            
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
        url: '/product/remove_cart',
        dataType: 'json',
        data: {id: product_id, sid: seller_id},

        success: function (obj) {
            
            print("hello");
        }})
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
