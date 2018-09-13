/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var accessKey;

function msdTag(key)
{
   // if (navigator.cookieEnabled) {
        var uid = cookieSet();
        //check if cookie already set
        if (!uid)
        {
            var uid = null;
            var siteID = '1234';
            grabID(siteID, key);
        }
        //update variables since cookie is set
        else {
            msdTagUpdate(uid);
        }
        //try iframe method
 //   } else {
  //      alert("cookies disabled!");
 //   }
}
;
function msdTagUpdate(uID)
{
//    setCookie("MSDAnalytics", uID, 30);
    //update site variables
    if (cookieSet())
    {   //grab page info
        alert(window.location.pathname);
        var path = window.location.pathname;
        var host = window.location.host;
        var protocol = window.location.protocol;

    }
    else{
        msdCookieSet("MSDAnalytics", uID, 30);
        msdCookieSet("MSDTracking", "False", 30);
    }
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function cookieSet() {
    var user = getCookie("MSDAnalytics");
    if (user !== "") {
        //alert("Welcome again " + user);
        return user;
    }
    return false;
}
function storageSet(){
    var user = localStorage.getItem("MSDAnalytics");
    if(user !== ""){
        return user;
    }
    return false;
}
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
function grabID(siteID, key)
{
    var uID = null;
    jQuery.ajax({
        type: "POST",
        url: 'http://localhost:8888/InventorySystem/Ads/grabID',
        dataType: 'json',
        data: {siteID: siteID, siteKey: key},

        success: function (obj) {
            // var result = JSON.parse(obj);
            //obj = JSON.stringify(obj);
            // if (obj.id === 1111) {
            uID = obj.id;
            siteID = obj.siteID;
            var userIP = obj.uIP;
            //check if webpage is approved/active
            if (uID === 1111) {
                alert("Error");
            }
            //page is approved and active
            else {
                alert(userIP);
                msdTagUpdate(uID);
            }
            // } else {
            //     console.log(obj.error);
            // }
        }
        
    });

    // return false;
    return false;
};
function msdCookieSet(CookieName, Value, Time){
       var uID = null;
    jQuery.ajax({
        type: "POST",
        url: 'http://localhost:8888/InventorySystem/Ads/setCookie',
        dataType: 'json',
        data: {Name: CookieName, Value: Value, Time: Time},

        success: function (obj) {
            // var result = JSON.parse(obj);
            //obj = JSON.stringify(obj);
            // if (obj.id === 1111) {
            var set = obj.set;
            //check if webpage is approved/active
            alert(set);
            if (set) {
                alert("success2 " + set);
            }
            //page is approved and active
            else {
                alert("error");
            }
            // } else {
            //     console.log(obj.error);
            // }
        }
        
    });

}