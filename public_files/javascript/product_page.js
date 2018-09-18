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
function product_grab(product_id, product_name, product_auth)
{
    jQuery.ajax({
        type: "POST",
        url: '/product/grab_product',
        dataType: 'json',
        data: {id: product_id, name: product_name, auth: product_auth},

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
            document.getElementById('addproducttoCart').addEventListener("click", function () {
                addtoCart(1, 1)
            });
            hideSidePictures();
            document.getElementById('product_image_url0').style = "visability: visable;"
            IMG0 = obj.outputproduct.IMG0;
            if (obj.outputproduct.IMG1 !== 'null')
            {
                IMG1 = obj.outputproduct.IMG1;
                document.getElementById('product_image_url1').src = obj.outputproduct.sIMG1;
                document.getElementById('product_image_url1').style = "visability: visable;"
            }
            if (obj.outputproduct.IMG2 !== 'null')
            {
                IMG2 = obj.outputproduct.IMG2;
                document.getElementById('product_image_url2').src = obj.outputproduct.sIMG2;
                document.getElementById('product_image_url2').style = "visability: visable;"
            }
            if (obj.outputproduct.IMG3 !== 'null')
            {
                IMG3 = obj.outputproduct.IMG3;
                document.getElementById('product_image_url3').src = obj.outputproduct.sIMG3;
                document.getElementById('product_image_url3').style = "visability: visable;"
            }
            if (obj.outputproduct.IMG4 !== 'null')
            {
                IMG4 = obj.outputproduct.IMG4;
                document.getElementById('product_image_url4').src = obj.outputproduct.sIMG4;
                document.getElementById('product_image_url4').style = "display: inline-flex;"
            }
        }}

    );

    // return false;
    return false;
}
;
function addtoCart(product_id, seller_id)
{
    jQuery.ajax({
        type: "POST",
        url: '/product/add_cart',
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
