<!--<link href="public/assert/video-js/video-js.min.css" rel="stylesheet">-->
<!--<script src="public/assert/video-js/video.js"></script>-->
<script src="bower_components/angularjs/angular.min.js"></script>
<link rel="stylesheet" href="public/app/feed-search/feed-search.css"/>
<script src="public/app/feed-search/feed-search.js"></script>
<div ng-app="feed-search-app" ng-controller="ProfileCtl">
    <!-- topbar -->
    <div class="tab">
        <a class="logo" href="?view=feed"></a>
        <div class="search">
            <form action="index.php">
                <input type="hidden" name="view" value="feed-search">
                <input type="text" name="keyword" placeholder="ค้นหาพนักงาน" style="  width: 391px;
      height: 35px;
      display: block;
      outline: none;
      border: none;
      background: none;
      padding-left: 10px;">
            </form>
        </div>
        <div class="status">
            <div class="tus" ng-if="user.account_id">
                <a href="?view=feed-user&account_id={{user.account_id}}" style="color: white; text-decoration: none;">
                    <img src="{{user.picture}}" width="40" height="40" class="profile-image">
                    <?php //echo $_SESSION['user']['firstname']; ?>
                    {{user.firstname}}
                </a>
            </div>
        </div>
        <div class="icon">
            <!-- <div class="icon-setting"></div> -->
        </div>
    </div>
    <!-- end topbar -->
    <div class="data" ng-controller="SearchUserCtl" style="background: rgb(155, 106, 31);">
        <div>
            <div ng-repeat="item in search_users" style="margin-top: 10px;">
                <a href="?view=feed-user&account_id={{item.account_id}}" style="text-decoration: none;">
                    <img src="{{item.picture}}" width="40" height="40" style="vertical-align: middle; border-radius: 2px;"> <span>{{item.firstname}} {{item.lastname}}</span>
                </a>
            </div>
        </div>
    </div>
</div>