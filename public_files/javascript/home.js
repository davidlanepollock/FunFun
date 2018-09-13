
function posting() {
    document.getElementById("postarea").style.height = "80px";
    document.getElementById("posting").style.marginBottom = "2px";
    document.getElementById("spacer").style.display = "none";
    document.getElementById("toolbar").style.display = "inline-block";
}
;

function friends() {
    document.getElementById("crew").style.display = "none";
    document.getElementById("global").style.display = "none";
    document.getElementById("local").style.display = "none";
    document.getElementById("friends").style.display = "block";
}
;
function crew() {
    document.getElementById("friends").style.display = "none";
    document.getElementById("global").style.display = "none";
    document.getElementById("local").style.display = "none";
    document.getElementById("crew").style.display = "block";
}
;
function favorites() {
    document.getElementById("crew").style.display = "none";
    document.getElementById("global").style.display = "none";
    document.getElementById("friends").style.display = "none";
    document.getElementById("local").style.display = "block";
}
;
function global() {
    document.getElementById("crew").style.display = "none";
    document.getElementById("friends").style.display = "none";
    document.getElementById("local").style.display = "none";
    document.getElementById("global").style.display = "block";
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
        var postBody = $.trim($('#postarea').val());
        var privacy = $.trim($('#privacy-check').val());
        var userTo = $.trim($('#profile-uid').val());
        var dir_username = $("#profile-username").val();

        if (postBody != "" && privacy != "" && userTo != "") {
            $.post("http://localhost/home/makePost", {postBody: postBody, privacy: privacy, userTo: userTo}, function (data) {
                // Insert The Post Into The Feed
            });
        } else {
            alert("Some data has not been entered!!");
        }
    });
});

function yhandler() {
    var user = $("#uid").val();
    var postid;
    var wrap = document.getElementById('middlecon');
    var contentheight = wrap.offsetHeight;
    var yoffset = window.pageYOffset;
    var y = yoffset + window.innerHeight;
    if (y >= contentheight) {
        loadpost('27', '');
    }

    var status = document.getElementById('status');
    status.innerHTML = contentheight + " | " + y;

    function loadpost(uid, postid)
    {

        $('#loading1').css('visibility', 'visible');
        $('#loadingtext1').css('visibility', 'visible');

        $.ajax({
            type: "POST",
            url: "load_post.php",
            data: 'uid=' + uid + '&postid=' + postid,
            dataType: "html",
            success: function (msg) {

                if (parseInt(msg) !== 0)
                {
                    $('#content').append.html(msg);
                    $('#loading1').css('visibility', 'hidden');
                    $('#loadingtext1').css('visibility', 'hidden');
                }
            },
            error: function () {
                $('#content').append.html('error');
                $('#loading1').css('visibility', 'hidden');
                $('#loadingtext1').css('visibility', 'hidden');
            }

        });

    }

}

window.onscroll = yhandler;
