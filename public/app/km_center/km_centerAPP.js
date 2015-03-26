/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";
var centerapp = angular.module('center', []);
centerapp.controller('CenterListCtl', ['$scope', '$http', function ($scope, $http) {
    $scope.currentPage = 0;
    $scope.pageSize = 4;
    $scope.centers = [];
    $http.get('http://192.168.100.26/tobacco/kmcenter').success(function (data) {
        $scope.centers = data.data;
    });
    $scope.centershow = function (item) {
        $scope.itemshow = item;
        var location = $('.location');
        var txtLabel = $('.txtLabel');
        location.show();
        txtLabel.hide()
    }
}]);

centerapp.filter('startFrom', function () {
    return function (input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
});