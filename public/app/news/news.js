/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";
var newsapp = angular.module('news', []);
newsapp.controller('NewsListCtl', ['$scope', '$http', function ($scope, $http) {
    $http.get('http://192.168.100.26/tobacco/book_type').success(function (data) {
        $scope.news = data.data;
        $scope.currentPage = 0;
        $scope.leftClick = function(){
        $scope.rightClick = function(){
        }
        }
    });
}]);