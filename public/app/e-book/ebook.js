/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";
var ebookapp = angular.module('ebook', []);
ebookapp.controller('EbookListCtl', ['$scope', '$http', function ($scope, $http) {
    $scope.booktypes = [];
    $scope.books_group = [
        [],[]
    ];
    $http.get('http://localhost/tobacco/book_type').success(function (data) {
        $scope.booktypes = data.data;
        fetchBook();
    });

    function fetchBook(){
        var url = 'http://localhost/tobacco/ebook?';
        url += $.param({
            "book_type_id": $scope.booktypes[0].book_type_id
        });
        $http.get(url).success(function (data) {
            $scope.books_group[0] = data.data;
        });

        url = 'http://localhost/tobacco/ebook?';
        url += $.param({
            "book_type_id": $scope.booktypes[1].book_type_id
        });
        $http.get(url).success(function (data) {
            $scope.books_group[1] = data.data;
        });
    }

    $scope.bookClick = function(id){
        window.location.href = "?view=subpage&book_type_id="+id;
    };
    $scope.backhome = function(){
        window.location.href = "?view=home";
    };

    $scope.read = function(content_id){
        window.location.href = "?view=book-reader&tp=tp-none&content_id="+content_id;
    };
}]);