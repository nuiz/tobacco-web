/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";

function getJsonFromQuery(query) {
  var result = {};
  query.split("&").forEach(function(part) {
    var item = part.split("=");
    result[item[0]] = decodeURIComponent(item[1]);
  });
  return result;
}

var expertapp = angular.module('expert', []);
expertapp.controller('ExpertListCtl', ['$scope', '$http', function ($scope, $http) {
    $scope.homeClick = function () {
        window.location.href = "?view=home";
    };
    var hashParams = false;
    var hashString = window.location.hash.substr(1);
    if(hashString) {
      hashParams = getJsonFromQuery(hashString);
    }

    $scope.gurus = [];
    $scope.cats = [];
    $http.get(window.config.api_url+"/guru/category").success(function(data){
        data.data = data.data.reverse();
        $scope.cats = data.data;
        if(hashParams.guru_cat_id) {
          var indexCat = (function(){
            for(var i = 0; i < $scope.cats.length; i++) {
              if($scope.cats[i].guru_cat_id == hashParams.guru_cat_id) {
                return i;
              }
            }
            return false;
          })();
          if(indexCat > 10) {
            $scope.catPage = 1;
          }
          $scope.clickCat(indexCat%11);
          hashParams.guru_cat_id = false;
        }
    });

    $scope.centerPositions = [0,1,5,6,10];

    $scope.selectedGuru = null;
    $scope.clickGuru = function(item){
        $scope.selectedGuru = item;
    };

    $scope.catPage = 0;
    $scope.clickLever = function(){
        if($scope.catPage == 0)
            $scope.catPage = 1;
        else
            $scope.catPage = 0;
    };

    $scope.selectedCat = null;
    $scope.clickCat = function(index){
        $scope.selectedCat = index;
        $('.cat-icon').removeClass('selected');
        $('.cat-icon').eq(index).addClass('selected');

        var cat = $scope.cats[($scope.catPage*11)+index];

        $scope.gurus = [];
        $scope.gurusVM = [];
        $scope.gurusMaxPage = 0;
        $scope.gurusCurPage = 0;

        $http.get(window.config.api_url+"/guru?guru_cat_id=" + cat.guru_cat_id).success(function(data){
            $scope.gurus = data.data;
            $scope.gurusMaxPage = Math.floor($scope.gurus.length/8);
            $scope.setGuruPage(0);

            if(hashParams.guru_id) {
              var indexGuru = (function(){
                for(var i = 0; i < $scope.gurus.length; i++) {
                  if($scope.gurus[i].guru_id == hashParams.guru_id) {
                    return i;
                  }
                }
                return false;
              })();
              $scope.gurusCurPage = Math.floor(indexGuru/8);
              indexGuru = indexGuru%8;
              $scope.setGuruPage($scope.gurusCurPage);

              $scope.clickGuru($scope.gurusVM[indexGuru]);
              hashParams.guru_id = false;
              window.location.hash = "";
            }
        });
    };

    $scope.setGuruPage = function(index)
    {
      var size = 8;
      var start = index * size;
      $scope.gurusCurPage = index;
      $scope.gurusVM = $scope.gurus.slice(start, start + size);
    };

    $scope.closeCatClick = function(){
        $scope.selectedCat=null;
        $scope.selectedGuru = null;
    };

    $scope.redirect = function(url){
        window.location.href = url;
    };

    $scope.gotoFeedUser = function(item){
      // var hashStr = window.location.hash.substr(1);
      window.location.hash = $.param({
        guru_id: item.guru_id,
        guru_cat_id: item.guru_cat_id
      });
      setTimeout(function() {
        window.location.href = "?view=feed-user&account_id=" + item.account_id;
      }, 10);
    };
}]);

expertapp.filter('startFrom', function () {
    return function (input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
});



expertapp.directive('centerPosition', function () {
  return {
    restrict: 'A',
    link: function (scope, el, attrs, controller) {
    attrs.$observe('centerPosition', function(val) {
        if(val == "true"){
            scope.$watch( function () {
                return el.outerWidth();
            }, function( newW, oldW ) {
                if(newW == oldW || newW == 0) return;
                var ngtLeft = parseInt(el.outerWidth()/2);
                el.css('margin-left', -ngtLeft);
            });
        }
      });
    }
  };
});

expertapp.directive('ngLightbox', ['$compile', function($compile) {
    return function(scope, element, attr) {
        var lightbox, options, overlay;

        var defaults = {
            'class_name': false,
            'trigger': 'manual',
            'element': element[0],
            'kind': 'normal'
        };

        var options = angular.extend(defaults, angular.fromJson(attr.ngLightbox));

        // check if element is passed by the user
        options.element = typeof options.element === 'string' ? document.getElementById(options.element) : options.element;

        var add_overlay = function(){
            if(document.getElementById('overlay')) return;
            // compiling when we add it to have the close directive kick in
            overlay = $compile('<div id="overlay" ng-lightbox-close/>')(scope);

            // add a custom class if specified
            options.class_name && overlay.addClass(options.class_name);

            // append to dom
            angular.element(".expert-body").append(overlay);

            // load iframe options if defined
            options.kind === 'iframe' && load_iframe();

            // we need to flush the styles before applying a class for animations
            window.getComputedStyle(overlay[0]).opacity;
            overlay.addClass('overlay-active');
            angular.element(options.element).addClass('lightbox-active');
        }

        var load_iframe = function(){
            options.element = options.element || 'lightbox-iframe';
            var iframe = "<div id='" + options.element + "' class='lightbox'><iframe frameBorder=0 width='100%' height='100%' src='" + attr.href + "'></iframe></div>";
            angular.element(document.body).append(iframe)
        }

        if(options.trigger === 'auto'){
            add_overlay();
        }else{
            element.bind('click', function(event) {
                add_overlay();
                event.preventDefault();
                return false;
            });
        }
    }
}]);

expertapp.directive('ngLightboxClose', function() {
    return function(scope, element, attr) {
        var transition_events = ['webkitTransitionEnd', 'mozTransitionEnd', 'msTransitionEnd', 'oTransitionEnd', 'transitionend'];

        angular.forEach(transition_events, function(ev){
            element.bind(ev, function(){
                // on transitions, when the overlay doesnt have a class active, remove it
                !angular.element(document.getElementById('overlay')).hasClass('overlay-active') && angular.element(document.getElementById('overlay')).remove();
            });
        });

        // binding esc key to close
        angular.element(document.body).bind('keydown', function(event){
            event.keyCode === 27 && remove_overlay();
        });

        // binding click on overlay to close
        element.bind('click', function(event) {
            remove_overlay();
        });

        var remove_overlay = function(){
            var overlay = document.getElementById('overlay');
            angular.element(document.getElementsByClassName('lightbox-active')[0]).removeClass('lightbox-active');

            // fallback for ie8 and lower to handle the overlay close without animations
            if(angular.element(document.documentElement).hasClass('lt-ie9')){
                angular.element(overlay).remove();
            }else{
                angular.element(overlay).removeClass('overlay-active');
            }
        }
    }
});
