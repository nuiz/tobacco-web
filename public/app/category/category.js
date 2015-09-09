/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";
var categoryapp = angular.module('category', []);
categoryapp.controller('CategorysListCtl', ['$scope', '$http', function ($scope, $http) {
    $scope.backClick = function(){
        window.location.href = "?view=home";
    };
    $scope.readmoreClick = function (id) {
        window.location.href = "?view=reserch&tp=tp-blank&id="+id;
    }
    $http.get(window.config.api_url+'/category').success(function (data) {
        $scope.category1 = data.data.slice(0, 16);
        $scope.category2 = data.data.slice(16, 32);
    });
}]);
