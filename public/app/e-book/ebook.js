/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";
var ebookapp = angular.module('ebook', []);
ebookapp.controller('EbookListCtl', ['$scope', '$http', function ($scope, $http) {
    $http.get('http://192.168.100.26/tobacco/book_type').success(function (data) {
        $scope.booktypes = data.data;
    });
}]);