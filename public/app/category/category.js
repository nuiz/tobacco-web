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
}]);