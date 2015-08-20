/**
 * Created by NuizHome on 7/5/2558.
 */
var loginapp = angular.module('loginApp', []);
loginapp.controller('LoginCTL', ['$scope', '$http', function ($scope, $http) {
    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) == '0') {
              return c.substring(name.length,c.length);
            }
        }
        return "";
    }

    $scope.submitLogin = function(){
        var kiosk_id = getCookie('kiosk_id');
        var login_url = window.config.api_url+'/login?client_type=' + (kiosk_id == ""? "pc": "kiosk");
        
        var req1 = {
            method: 'POST',
            url: login_url,
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
                    window.location.href="?view=feed";
                });
            }
            else {
                alert(data.error.message);
            }
        });
    };
}]);
