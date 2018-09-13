// JavaScript Document

function posting() {
    document.getElementById("postarea").style.height = "80px";
    document.getElementById("posting").style.marginBottom = "2px";
    document.getElementById("spacer").style.display = "none";
    document.getElementById("toolbar").style.display = "inline-block";
}
;

function postdef(input) {
    var id = "postdef" + input;
    if (document.getElementById(id).style.display === "none") {
        document.getElementById(id).style.display = "block";
    } else {
        document.getElementById(id).style.display = "none";
    }
}
;
$(function () {
    $(document).on('submit', '#postForm', function () {
        var postBody = $.trim($('#postText').val());
        var privacy = $.trim($('#privacy-check').val());
        var userTo = $.trim($('#profile-uid').val());
        var dir_username = $("#profile-username").val();

        if (postBody != "" && privacy != "" && userTo != "") {
            $.post("/profile/" + dir_username + "/makePost", {postBody: postBody, privacy: privacy, userTo: userTo}, function (data) {
                // Insert The Post Into The Feed
            });
        } else {
            alert("Some data has not been entered!!");
        }
    });
});
function adduser() {
var adduser = $.trim($('#add').val());
var dir_username = $("#profile-username").val();
        $.post("/profile/" + dir_username + "/addfriend", {adduser: adduser}, function(data){
            document.getElementById("add").innerHTML = "Request Sent";
        });
    }
        