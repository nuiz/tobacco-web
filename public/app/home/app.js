/**
 * Created by NUIZ on 23/3/2558.
 */

var homeApp = angular.module("home-app", []);
homeApp.controller("HomeCTL", ['$scope', function($scope){
    var thMonth = [
        "มกราคม",
        "กุมภาพันธ์",
        "มีนาคม",
        "เมษายน",
        "พฤษภาคม",
        "มิถุนายน",
        "กรกฎาคม",
        "สิงหาคม",
        "กันยายนน",
        "ตุลาคม",
        "พฤจิกายน",
        "ธันวาคม"
    ];

    function setDate(){
        var dateNow = new Date();
        $scope.date = "วันที่ "+dateNow.getDate()+" "+thMonth[dateNow.getMonth()]+" "+(dateNow.getFullYear()+543);
        $scope.time = dateNow.getHours()+":"+dateNow.getMinutes()+" น.";
    }
    setDate();
    setInterval(function(){
        setDate();
        $scope.apply();
    }, 1000);

    var bgAll = [
        "public/images/home/bg1.jpg",
        "public/images/home/bg2.jpg"
    ];
    var bgIndex = 0;

    $scope.bgStyle = {
        'background-image': 'none'
    };
    function setBackground(){
        bgIndex++;
        if(bgIndex >= bgAll.length) bgIndex = 0;

        $scope.bgStyle['background-image'] = 'url('+bgAll[bgIndex]+')';
        $('#main').css($scope.bgStyle);
    }
    setBackground();
    setInterval(function(){
        setBackground();
    }, 5000);
}]);