/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";
var reserchapp = angular.module('reserch', []);

function startFrom (input, start) {
    start = +start; //parse to int\
    return input.slice(start);
}

function filterType (input, type) {
    var list = type?
        input.filter(function(item){
            return item.content_type == type;
        })
        : input;

    return list;
}

reserchapp.controller('ReserchListCtl', ['$scope', '$http', function ($scope, $http) {
    $scope.now = new Date();

    $scope.main_category = null;
    $scope.lv2_category = null;
    $scope.lv3_category = null;

    $scope.category = null;

    $scope.lv2_page = 0;
    $scope.lv3_page = 0;

    $scope.lv2_categories = [];
    $scope.lv3_categories = [];

    $scope.pagingContent = 0;

    $scope.backClick = function () {
        window.location.href = "?view=category";
    };
    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    var firstBeforeLv2 = true;
    $scope.clickMain = function(){
        $scope.lv3_category = null;
        $scope.lv2_category = null;

        var url = window.config.api_url+"/category/" + getParameterByName('id');
        $http.get(url).success(function (data) {
            $scope.main_category = data;
            $scope.category = data;
            $scope.fetchContents();
        });

        url = window.config.api_url+"/category?parent_id=" + getParameterByName('id');
        $http.get(url).success(function (data) {
            $scope.lv2_page = 0;
            $scope.lv2_categories = data.data;
            $scope.lv3_categories = [];
            if($scope.lv2_categories.length > 0 && firstBeforeLv2){
                $scope.lv2Click($scope.lv2_categories[0]);
                firstBeforeLv2 = false;
            }
        });
    };
    $scope.clickMain();

    $scope.lv2Click = function(lv2){
        $scope.lv3_category = null;
        $scope.lv2_category = lv2;
        $scope.category = lv2;
        var url = window.config.api_url+"/category?parent_id=" + lv2.category_id;
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
        var url = window.config.api_url+"/content/by_category?category_id="+$scope.category.category_id;
        $http.get(url).success(function(data) {
            $scope.contents = data.data.map(function(o) {
              o.created_at = parseInt(o.created_at);
              return o;
            });
            $scope.contents.sort(function(a, b) {
              return b.created_at - a.created_at;
            });
            $scope.contents.sort(function(a, b) {
              return b.created_at - a.created_at;
            });

            var maxVal = Math.max.apply(null, $scope.contents.map(function(o) {
              return o.view_count;
            }));

            $scope.contents = $scope.contents.map(function(o) {
              if(o.view_count == maxVal && $scope.contents.length > 1) {
                o.hot = true;
              }
              else {
                o.hot = false;
              }
              return o;
            });
            console.log($scope.contents);
            // console.log($scope.now.getTime(), ($scope.contents[9].created_at + (24*60*60*30))*1000);
        });
    };

    $scope.contentClick = function(item){
        if(item.content_type=='video'){
            window.location.href = "?view=video_page&content_id="+item.content_id;
        }
        else {
            window.location.href = "?view=book-reader&tp=tp-none&content_id="+item.content_id+"#book5/page1";
        }
    };

    $scope.filterType = false;
    $scope.clickFilter = function(type){
        $scope.filterType = type;
        $scope.pagingContent = 0;
    };

    $scope.getFilterContentLength = function(){
        var list = $scope.contents;
        list = filterType(list, $scope.filterType);

        return list.length;
    }
}]);

reserchapp.filter('startFrom', function () {
    return startFrom;
});

reserchapp.filter('filterType', function () {
    return filterType;
});
