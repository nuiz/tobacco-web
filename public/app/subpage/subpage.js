/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";
var subpageapp = angular.module('subpage', []);
subpageapp.controller('SubpageListCtl', ['$scope', '$http', function ($scope, $http) {
    $http.get('http://192.168.100.26/tobacco/book_type').success(function (data) {
        $scope.booktypes = data.data;
    });
}]);