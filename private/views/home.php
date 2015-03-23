<script src="bower_components/angularjs/angular.min.js"></script>
<script src="public/app/home/app.js"></script>
<link rel="stylesheet" href="public/app/home/home.css"/>
<div class="home-wrap" ng-app="home-app" ng-controller="HomeCTL">
    <div style="margin: 72px 26px;
  font-size: 23px;
  color: white;
  text-shadow: 2px 2px 1px rgba(0, 0, 0, 0.82);">
        <div>{{date}}</div>
        <div>{{time}}</div>
    </div>
</div>