/**
 * Created by NUIZ on 23/3/2558.
 */

(function(){
    var status = "Right Click Disabled";
    function disableClick(event)
    {
        if(event.button==2)
        {
            return false;
        }
    }
    document.onmousedown = disableClick;
})();

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
        return "";
    }

    function setCookie(cname, cvalue, sec) {
        var d = new Date();
        d.setTime(d.getTime() + (sec*1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    }

    window.userlogin = null;
    window.readyUser = false;
    function onUserReady(cb){
        if(!window.readyUser){
            setTimeout(function(){
                onUserReady(cb);
            }, 100);
        }
        else {
            cb();
        }
    };

    $.get("auth.php?action=get", function(data){
        window.userlogin = data;
        window.readyUser = true;
    }, 'json');

    (function(){
        var kiosk_id = getCookie("kiosk_id");

        if(kiosk_id == ""){
            $.get(config.api_url+'/client/addview?client_id=0');
            return;
        }
        else{
            $.get(config.api_url+'/client/addview?client_id='+kiosk_id);
        }

        var socket = io(config.nfc_auth_ip+"/nfc");
        socket.on("connect", function(){
            socket.emit("subscribe", {kiosk_id: kiosk_id});
        });
        socket.on('publish', function(data){
            onUserReady(function(){
                var send = {nfc_id: data.nfc_id, kiosk_id: kiosk_id};
                if(window.userlogin != null){
                    send.auth_token = window.userlogin.auth_token;
                }
                $.post(config.api_url+"/auth/nfc", send, function(authData){
                    if(authData.register_nfc){
                        if(authData.success){
                            alert("ผูก nfc tag กับ account สำเร็จแล้ว");
                        }
                        else {
                            alert("ท่านได้ทำการลงทะเบียนอุปกรณ์ NFC ไปแล้ว");
                        }
                    }
                    else {
                        $.post('auth.php?action=login', {user: authData}, function(data2){
                            if(typeof data2.error != "undefined"){
                                alert(data2.error);
                                return;
                            }
                            alert("เข้าสู่ระบบ สำเร็จแล้ว");

                            var href = "?view=feed-user&kiosk_id="+kiosk_id+"&account_id="+authData.account_id;
                            if(window.location.href!=href)
                                window.location.href=href;
                            else
                                window.location.reload();
                        }, 'json');
                    }
                });
            });

            // if(typeof data.error != "undefined"){
            //     alert(data.error.message);
            //     $.post('auth.php?action=logout', function(){
            //         window.location.reload();
            //     }, 'json');

            //     return;
            // }

            // $.post('auth.php?action=login', {user: data}, function(data2){
            //     alert("เข้าสู่ระบบ สำเร็จแล้ว");

            //     var href = "?view=news&kiosk_id="+kiosk_id;
            //     if(window.location.href!=href)
            //         window.location.href=href;
            //     else
            //         window.location.reload();
            // }, 'json');
        });
    })();
});
