/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";
var subpageapp = angular.module('subpage', []);
subpageapp.controller('SubpageListCtl', ['$scope', '$http', function ($scope, $http) {
    $http.get(window.config.api_url+'/category').success(function (data) {
        $scope.category = data.data;
    });
    $scope.subpageClick = function(){
        window.location.href = "?view=e-book";
    };
    $scope.bookClick = function(id){
        window.location.href = "?view=subpage&category_id="+id;
    };
    $http.get(window.config.api_url+'/category/'+getParameterByName('category_id')).success(function (data) {
        $scope.categoryNow = data;
    });

    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    $scope.books = [];

    var keyword = getParameterByName('keyword');
    if(!keyword){
        var url = window.config.api_url+"/content?category_id="+getParameterByName('category_id');
        $http.get(url).success(function (data) {
            var list = data.data.filter(function(o) {
              return o.content_type == "book";
            });
            $scope.books = list;
        });
    }
    else {
        var url = window.config.api_url+"/ebook/search?keyword="+keyword;
        $http.get(url).success(function (data) {
            $scope.books = data.data;
        });
    }

}]);
