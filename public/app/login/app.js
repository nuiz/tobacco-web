/**
 * Created by NuizHome on 7/5/2558.
 */
var loginapp = angular.module('loginApp', []);
loginapp.controller('LoginCTL', ['$scope', '$http', function ($scope, $http) {
    $scope.submitLogin = function(){
        var req1 = {
            method: 'POST',
            url: window.config.api_url+'/login',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            data: $.param({
                username: $scope.username,
                password: $scope.password
            })
        };

        $http(req1).success(function(data){
            if(typeof data.error == "undefined"){
                var req = {
                    method: 'POST',
                    url: 'auth.php?action=login',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    data: $.param({ user: data })
                };

                $http(req).success(function(){
                    window.location.href="?view=feed"
                });
            }
            else {
                alert(data.error.message);
            }
        });
    };
}]);