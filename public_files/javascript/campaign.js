/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function MSDCampaign(obj)
{
    
    grabCampaign(null);
    if(typeof obj !== 'undefined'){
        $("#campaignList").html(obj);
    }
}

function grabCampaign(sortType)
{
    var uID = null;
    var myDiv = document.getElementById("campaignList");
    jQuery.ajax({
        type: "POST",
        url: 'http://localhost:8888/InventorySystem/Ads/grabCampaign',
        dataType: 'json',
        data: {sort: sortType},

        success: function (obj) {
            // var result = JSON.parse(obj);
            //obj = JSON.stringify(obj);
            // if (obj.id === 1111) {
            uID = obj.id;
            var Campaign = obj.campaigns;
            //check if webpage is approved/active
            if (uID === 1111) {
                myDiv.innerHTML = "You currently have no campaigns created. Create one by clicking 'Create'.";
            }
            //page is approved and active
            else {
                var temp = null;
                myDiv.innerHTML = "";
                for (var i = 0; i < obj.rowCount; i++)
                {
                    var count = i + 1;
                    if (Campaign[i].enabled == 1) {
                        temp = '<div class="enabled">';
                    } else {
                        temp = '<div class="disabled">';
                    }
                    myDiv.innerHTML += '<div id="' + Campaign[i].id + '" class="campaignElement hover" onClick="updateCampaign(' + Campaign[i].id + ')"><div class="list-item">' +
                            temp + '</div>' +
                            '<div class="element">' + count + '</div>'
                            + '<div class="element">' + Campaign[i].name + '</div>'
                            + '<div class="element">' + new Date(Campaign[i].date_created).toLocaleString() + '</div>'
                            + '</div></div>';
                }
            }
            // } else {
            //     console.log(obj.error);
            // }
        }

    });

    // return false;
    return false;
}
;
function updateCampaign(campaignID)
{
    var uID = null;
    var myDiv = document.getElementById("campaignList");
    jQuery.ajax({
        type: "POST",
        url: 'http://localhost:8888/InventorySystem/Ads/updateCampaignView',
        dataType: 'json',
        data: {id: campaignID},

        success: function (obj) {
            // var result = JSON.parse(obj);
            //obj = JSON.stringify(obj);
            // if (obj.id === 1111) {
            uID = obj.id;
            var Campaign = obj.campaigns;
            //check if webpage is approved/active
            if (uID === 1111) {
                myDiv.innerHTML = "There was an error processing your request.";
            }
            //page is approved and active
            else {
                var temp = null;
                if (Campaign[0].enabled == 1) {
                    temp = 'Enabled';
                } else {
                    temp = 'Disabled';
                }
                myDiv.innerHTML = "";
                myDiv.innerHTML += '<div class="campaignElement hover">Name: ' +
                        Campaign[0].name + '</div>' +
                        '<div class="campaignElement hover">Current Status: ' + temp + '</div>'
                        + '<div class="campaignElement no-hover">Date Created: ' + Campaign[0].date_created + '</div>'
                        + '<div class="campaignElement no-hover">Last Updated: ' + Campaign[0].last_accessed + '</div>'
                        + '<div class="campaignElement no-hover"><div class="inputField">'
                        + '<input class="input" onClick="updatedCampaign(' + Campaign[0].id + ');" type="submit" value="Save Changes"></div></div>'
                        + '<div class="campaignElement no-hover"><div class="inputField">'
                        + '<input class="input" onClick="MSDCampaign();" type="submit" value="Cancel"></div></div>'
            }
        }
        // } else {
        //     console.log(obj.error);
        // }
    }

    );

    // return false;
    return false;
}
function updatedCampaign(campaignID)
{
    var uID = null;
    var myDiv = document.getElementById("campaignList");
    jQuery.ajax({
        type: "POST",
        url: 'http://localhost:8888/InventorySystem/Ads/updateCampaign',
        dataType: 'json',
        data: {id: campaignID},

        success: function (obj) {
            // var result = JSON.parse(obj);
            //obj = JSON.stringify(obj);
            // if (obj.id === 1111) {
            uID = obj.id;
            var Campaign = obj.campaigns;
            var noti = obj.noti;
            //check if webpage is approved/active
            if (uID === 1111) {
                myDiv.innerHTML = "There was an error processing your request.";
            }else{
                MSDCampaign(noti);
        }
        // } else {
        //     console.log(obj.error);
        // }
        }}

    );

    // return false;
    return false;
};
