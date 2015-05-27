/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";
var profileapp = angular.module('profile', []);
profileapp.controller('ProfileListCtl', ['$scope', function ($scope) {
    $scope.homeClick = function(){
        window.location.href = "?view=home";
    }
}]);

profileapp.controller('FeedListCtl', ['$scope', '$http', function ($scope, $http) {
    $scope.posts = [];
    $http.get("http://localhost/tobacco/blog/feed").success(function(data){
        $scope.posts = data.data;
    });
}]);

var videojs_id = 0;
profileapp.directive('videojs', function () {
    var linker = function (scope, element, attrs){
        videojs_id++;
        var id = "videojs_" + videojs_id;
        element.attr("id", id);
        setTimeout(function(){
            videojs(id, {}, function(){}) ;
        }, 1);
    };
    return {
        restrict : 'A',
        link : linker
    };
});
