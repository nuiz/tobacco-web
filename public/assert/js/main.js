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
});