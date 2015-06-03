/**
 * Created by NUIZ on 23/3/2558.
 */
$(function(){
    var appW = 1280;
    var appH = 720;
    var $main = $('#main');

    $(window).resize(function(){
        var wH = $(window).height();
        var wW = $(window).width();
        var scale = wW/wH > (16/9)? wH/appH: wW/appW;
        $main.css('transform', 'scale('+scale+')');
    }).resize();

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
        }
        console.log(ca);
        return "";
    }

    (function(){
        var kiosk_id = getCookie("kiosk_id");

        console.log(kiosk_id);
        if(kiosk_id == "")
            return;

        var socket = io(config.nfc_auth_ip+"/nfc");
        socket.on("connect", function(){
            socket.emit("subscribe", {kiosk_id: kiosk_id});
        });
        socket.on('publish', function(data){
            $.post('auth.php?action=login', {user: data}, function(data2){
                alert("เข้าสู่ระบบ สำเร็จแล้ว");

                var href = "?view=news&kiosk_id="+kiosk_id;
                if(window.location.href!=href)
                    window.location.href=href;
                else
                    window.location.reload();
            }, 'json');
        });
    })();
});