<script src="bower_components/angularjs/angular.min.js"></script>
<link rel="stylesheet" href="public/app/profile/profile.css"/>
<script src="public/app/profile/profile.js"></script>
<div ng-app="profile" ng-controller="ProfileListCtl">
    <div class="tab">
        <div class="logo"></div>
<!--        <div class="search">ค้นหาเพื่อน</div>-->
        <div class="status">
            <div class="image"></div>
            <div class="tus"><?php echo $_SESSION['user']['firstname']; ?>|</div>
        </div>
        <div class="icon">
<!--            <div class="icon-later"></div>-->
<!--            <div class="icon-alert"></div>-->
            <div class="icon-setting"></div>
        </div>
    </div>
    <div class="data">
        Test
    </div>
    <div class="homepage" ng-click="homeClick()"></div>
</div>