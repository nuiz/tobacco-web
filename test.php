<html>
<body>
<div id="body">
</div>
<script src="public/app/config.js"></script>
<script src="socket.io.js"></script>
<script>
    var socket = io(config.nfc_auth_ip+"/nfc");
    socket.on("connect", function(){
        socket.emit("subscribe", {kiosk_id: 1});
    });
    socket.on('publish', function(data){
        console.log(data);
    });
</script>
</body>
</html>