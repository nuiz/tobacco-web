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

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }


    function setDate(){
        var dateObject = new Date();
        var date = "วันที่ " + dateObject.getDate() + " " + thMonth[dateObject.getMonth()] + " " + (dateObject.getFullYear() + 543);
        var time = checkTime(dateObject.getHours()) + ":" + checkTime(dateObject.getMinutes()) + " น.";

        var dThai = date + " เวลา " + time;
        $scope.time = dThai;
    }
    setDate();
    setInterval(function(){
        setDate();
        $scope.$apply();
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
