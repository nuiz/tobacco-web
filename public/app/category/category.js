/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";
var categoryapp = angular.module('category', []);
categoryapp.controller('CategorysListCtl', ['$scope', '$http', function ($scope, $http) {
    $http.get('http://192.168.100.26/tobacco').success(function (data) {
        $scope.category = data.data;
    });
}]);