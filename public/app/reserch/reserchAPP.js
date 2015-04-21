/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";
var reserchapp = angular.module('reserch', []);
reserchapp.controller('ReserchListCtl', ['$scope', '$http', function ($scope, $http) {
    $scope.main_category = null;
    $scope.lv2_category = null;
    $scope.lv3_category = null;

    $scope.category = null;

    $scope.lv2_page = 0;
    $scope.lv3_page = 0;

    $scope.lv2_categories = [];
    $scope.lv3_categories = [];

    $scope.backClick = function () {
        window.location.href = "?view=category";
    };
    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    $scope.clickMain = function(){
        var url = "http://localhost/tobacco/category/" + getParameterByName('id');
        $http.get(url).success(function (data) {
            $scope.main_category = data;
            $scope.category = data;
            $scope.fetchContents();
        });

        url = "http://localhost/tobacco/category?parent_id=" + getParameterByName('id');
        $http.get(url).success(function (data) {
            $scope.lv2_page = 0;
            $scope.lv2_categories = data.data;
        });
    };
    $scope.clickMain();

    $scope.lv2Click = function(lv2){
        $scope.lv2_category = lv2;
        $scope.category = lv2;
        var url = "http://localhost/tobacco/category?parent_id=" + lv2.category_id;
        $http.get(url).success(function (data) {
            $scope.lv3_page = 0;
            $scope.lv3_categories = data.data;
        });
        $scope.fetchContents();
    };

    $scope.lv3Click = function(lv3){
        $scope.lv3_category = lv3;
        $scope.category = lv3;
        $scope.fetchContents();
    };

    $scope.contents = [];
    $scope.fetchContents = function(){
        var url = "http://localhost/tobacco/content/by_category?category_id="+$scope.category.category_id;
        $http.get(url).success(function(data){
            console.log(data);
            $scope.contents = data.data;
        });
    };

    $scope.contentClick = function(item){
        if(item.content_type=='video'){
            window.location.href = "?view=video_page&content_id="+item.content_id;
        }
        else {
            window.location.href = "?view=book-reader&tp=tp-none&content_id="+item.content_id;
        }
    };

    $scope.displayVideo = function(video){

    };
}]);

reserchapp.filter('startFrom', function () {
    return function (input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
});
