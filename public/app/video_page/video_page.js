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
    });

    $scope.displayVideo = function(item){
        $scope.videoShow = item;
        $('#videoPlayer').attr('src', item.video_url).get(0).play();
    };
}]);