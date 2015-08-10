<script src="bower_components/angularjs/angular.min.js"></script>
<script src="public/app/login/app.js"></script>
<link rel="stylesheet" href="public/app/login/login.css"/>
<div ng-app="loginApp" ng-controller="LoginCTL">
	<a class="close-btn" href="index.php?view=news"></a>
    <form id="loginform" ng-submit="submitLogin()">
        <input type="text" id="username-input" ng-model="username" autofocus />
        <input type="password" id="password-input" ng-model="password" />
        <button type="submit" id="submit-btn"></button>
    </form>
</div>