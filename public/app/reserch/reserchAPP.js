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
    $scope.backClick = function () {
        window.location.href = "?view=category";
    };
    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    $scope.reserchs = [];
    var url = "http://192.168.100.15/tobacco/category?parent_id=" + getParameterByName('parent_id');
    $http.get(url).success(function (data) {
        $scope.reserchs = data.data;
    });
}]);

