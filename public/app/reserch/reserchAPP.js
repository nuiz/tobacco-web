/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";
var reserchapp = angular.module('reserch', []);
reserchapp.controller('ReserchListCtl', ['$scope', '$http', function ($scope, $http) {
    $scope.reserchs = [
        {
            category_name: "abc"
        },
        {
            category_name: "abc"
        },
        {
            category_name: "abc"
        },
        {
            category_name: "abc"
        },
        {
            category_name: "abc"
        }
    ];
    $scope.subtypes = [
        {
            subtype_name: "aaa"
        },
        {
            subtype_name: "aaa"
        },
        {
            subtype_name: "aaa"
        },
        {
            subtype_name: "aaa"
        },
        {
            subtype_name: "aaa"
        },
        {
            subtype_name: "aaa"
        },
        {
            subtype_name: "aaa"
        },
        {
            subtype_name: "aaa"
        },
        {
            subtype_name: "aaa"
        },
        {
            subtype_name: "aaa"
        }
    ];
    $scope.others = [
        {
            other_name: "test"
        },
        {
            other_name: "test"
        },
        {
            other_name: "test"
        },
        {
            other_name: "test"
        }
    ];
}]);

