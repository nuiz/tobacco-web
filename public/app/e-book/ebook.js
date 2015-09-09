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
    // $http.get(window.config.api_url+'/book_type').success(function (data) {
    //     $scope.booktypes = data.data;
    //     fetchBook();
    // });

    $scope.page1 = 0;
    $scope.page2 = 1;
    $scope.category = [];

    $scope.category_show = [null, null];
    $http.get(window.config.api_url+'/category').success(function (data) {
        $scope.category = data.data;
        $scope.category_show = $scope.category.slice(0, 2);
        fetchBook();
    });

    // function fetchBook(){
    //     var url = window.config.api_url+'/ebook?';
    //     url += $.param({
    //         "book_type_id": $scope.booktypes[0].book_type_id
    //     });
    //     $http.get(url).success(function (data) {
    //         $scope.books_group[0] = data.data;
    //     });
    //
    //     url = window.config.api_url+'/ebook?';
    //     url += $.param({
    //         "book_type_id": $scope.booktypes[1].book_type_id
    //     });
    //     $http.get(url).success(function (data) {
    //         $scope.books_group[1] = data.data;
    //     });
    // }

    $scope.backCat = function()
    {
      $scope.page1 -= 2;
      $scope.page2 -= 2;

      if($scope.page1 < 0) {
        $scope.page1 = $scope.category.length + $scope.page1;
      }
      if($scope.page2 < 0) {
        $scope.page2 = $scope.category.length + $scope.page2;
      }
      fetchBook();
    };
    $scope.nextCat = function()
    {
      $scope.page1 += 2;
      $scope.page2 += 2;

      if($scope.page1 >= $scope.category.length) {
        $scope.page1 = $scope.page1 - $scope.category.length;
      }
      if($scope.page2 >= $scope.category.length) {
        $scope.page2 = $scope.page2 - $scope.category.length;
      }
      fetchBook();
    };

    function fetchBook(){
        $scope.category_show = [
          $scope.category[$scope.page1],
          $scope.category[$scope.page2]
        ];

        var url = window.config.api_url+'/content?';
        url += $.param({
            "category_id": $scope.category[$scope.page1].category_id
        });
        $http.get(url).success(function (data) {
            var list = data.data.filter(function(o) {
              return o.content_type == "book";
            });
            $scope.books_group[0] = list;
        });

        url = window.config.api_url+'/content?';
        url += $.param({
            "category_id": $scope.category[$scope.page2].category_id
        });
        $http.get(url).success(function (data) {
            var list = data.data.filter(function(o) {
              return o.content_type == "book";
            });
            $scope.books_group[1] = list;
        });
    }

    var url = window.config.api_url+'/ebook/showpage';
    $scope.showpageBooks = [];
    $http.get(url).success(function (data) {
        $scope.showpageBooks = data;
    });

    $scope.bookClick = function(id){
        window.location.href = "?view=subpage&category_id="+id;
    };
    $scope.backhome = function(){
        window.location.href = "?view=home";
    };

    $scope.read = function(content_id){
        window.location.href = "?view=book-reader&tp=tp-none&content_id="+content_id;
    };
}]);
