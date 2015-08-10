/**
 * Created by NUIZ on 3/4/2558.
 */

"use strict";


function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

var app = angular.module('search-app', []);
app.controller('SearchController', ['$scope', '$http', function ($scope, $http) {
    $scope.data = [];
    $scope.keyword = getParameterByName('keyword');

    $scope.search = function(){
        var url = window.config.api_url+'/search?keyword='+$scope.keyword;
        $http.get(url).success(function (data) {
            $scope.data = data;
        });
    };
    $scope.search();

    $scope.viewObjectUrl = function(obj){
        if(obj.object_type == "news"){
            return "index.php?view=news-subtype&id="+obj.object_id;
        }
        else if(obj.object_type == "video"){
            return "index.php?view=video_page&content_id="+obj.object_id;
        }
        else if(obj.object_type == "book"){
            return "index.php?view=book-reader&tp=tp-none&content_id="+obj.object_id+"#book5/page1";
        }
    };
}]);

app.filter('startFrom', function () {
    return function (input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
});