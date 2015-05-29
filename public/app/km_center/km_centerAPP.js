/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";
var centerapp = angular.module('center', []);
centerapp.controller('CenterListCtl', ['$scope', '$http', function ($scope, $http) {
    $scope.currentPage = 0;
    $scope.pageSize = 4;
    $scope.centers = [];
    $http.get(window.config.api_url+'/kmcenter').success(function (data) {
        $scope.centers = data.data;
    });
    $scope.itemshow = false;
    $scope.centershow = function (item) {
        $scope.itemshow = item;
    };
    $scope.homeClick = function () {
        window.location.href = "?view=home";
    }
}]);

centerapp.filter('startFrom', function () {
    return function (input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
});