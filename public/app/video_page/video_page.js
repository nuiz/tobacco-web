/**
 * Created by NUIZ on 21/4/2558.
 */

var app = angular.module("video-page", []);
app.controller("VideoPageCtrl", ['$scope', '$http', function($scope, $http){
    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    $scope.content = {};
    $scope.videoShow = {};

    $http.get(window.config.api_url+'/content/' + getParameterByName('content_id')).success(function (data) {
        $scope.content = data;
        $scope.displayVideo(data.videos[0]);

        $http.get(window.config.api_url+'/category/'+$scope.content.category_id).success(function(data){
            var fnGetParent = function(obj) {
              if(obj.parent) {
                return fnGetParent(obj.parent);
              }
              return obj.category_id;
            };
            $scope.backHref = "?view=reserch&tp=tp-blank&id=" + fnGetParent(data);
        });
    });

    $scope.displayVideo = function(item){
        $scope.videoShow = item;
        $('#videoPlayer').attr('src', item.video_url).get(0).play();
    };

    (function($scope){
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

        $scope.dateThai = function(dateInput){
            var dateObject = new Date(dateInput * 1000);
            var date = "วันที่ "+dateObject.getDate()+" "+thMonth[dateObject.getMonth()]+" "+(dateObject.getFullYear()+543);
            // var time = checkTime(dateObject.getHours())+":"+checkTime(dateObject.getMinutes())+" น.";

            // return date + " เวลา " + time;
            return date;
        };
    })($scope);
}]);
