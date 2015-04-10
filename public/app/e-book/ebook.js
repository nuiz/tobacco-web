/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";
var ebookapp = angular.module('ebook', []);
ebookapp.controller('EbookListCtl', ['$scope', '$http', function ($scope, $http) {
    $http.get('http://localhost/tobacco/book_type').success(function (data) {
        $scope.booktypes = data.data;
    });
    $scope.bookClick = function(){
        window.location.href = "?view=subpage";
    };
    $scope.backhome = function(){
        window.location.href = "?view=home";
    }
}]);