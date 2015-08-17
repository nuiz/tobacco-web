<!--<link href="public/assert/video-js/video-js.min.css" rel="stylesheet">-->
<!--<script src="public/assert/video-js/video.js"></script>-->
<script src="public/assert/customScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<link rel="stylesheet" href="public/assert/customScrollbar/jquery.mCustomScrollbar.min.css"/>

<script src="bower_components/angularjs/angular.min.js"></script>
<link rel="stylesheet" href="public/app/feed-user/feed-user.css"/>
<script src="public/app/feed-user/feed-user.js"></script>
<div ng-app="profile" ng-controller="ProfileCtl">
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
                <span>
                    <img src="{{user.picture}}" width="40" height="40" class="profile-image">
                    <?php //echo $_SESSION['user']['firstname']; ?>
                    {{user.firstname}}
                </span>
                |
                <a href="?view=feed-user&account_id={{user.account_id}}" style="color: #000; text-decoration: none; font-size:16px;>
                    ดูข้อมูลส่วนตัว
                </a>
            </div>
        </div>
        <div class="icon">
            <!-- <div class="icon-setting"></div> -->
        </div>
    </div>
    <div class="mCustomScrollbar data" ng-controller="FeedListCtl">
        <div class="user-profile" style="border-bottom:1px solid gainsboro; padding: 10px 0;">
            <div class="user-profile-picture" style="float: left; margin-right: 20px;">
                <img src="{{user.picture}}" />
            </div>
            <div class="user-profile-detail" style="float: left;"">
                <div style="margin: 10px 0;">รหัสพนักงาน: {{user.username}}</div>
                <div style="margin: 10px 0;">ชื่อ: {{user.firstname}} {{user.lastname}}</div>
            </div>
            <div style="clear: both;"></div>
        </div>
        <div class="paging-list" ng-show="total > 0" stlye="color: #000;">
            หน้าที่
            <a ng-repeat="item in paging"
               class="paging"
               ng-class="{'active': item.current}"
               ng-click="setCurrentPage(item.page)">{{item.page}}</a>
        </div>
        <div class="post"
             ng-repeat="item in posts"
             ng-class="{'post-text': item.post_type=='text', 'post-video': item.post_type=='video', 'post-video': item.post_type=='image'}">
            <div class="user-des">
                <div class="user-img"><img src="{{item.user.picture}}" style="width: 38px;  height: 38px;  object-fit: cover;"></div>
                <div class="user-name"><a href="?view=feed-user&account_id={{item.user.account_id}}">{{item.user.firstname + ' ' + item.user.lastname}}</a></div>
                <div class="post-time"><small>{{dateThai(item.created_at)}}</small></div>
            </div>
            <div class="content">
                <div>{{item.post_text}}</div>
                <div ng-if="item.post_type=='image'" class="post-image-list">
                    <img ng-repeat="img in item.images" src="{{img.image_url}}" class="post-img" />
                </div>
                <div ng-if="item.post_type=='video'" class="video-wrap">
                    <video class="video-player" controls
                           width="540" height="303">
                        <source src="{{item.video_url}}" type='video/mp4'>
                    </video>
                </div>
            </div>
            <div class="description">
                <div>
                    <a class="like-btn" href="" ng-click="like(item)" ng-hide="item.liked">ถูกใจ</a>
                    <a class="unlike-btn" href="" ng-click="unlike(item)" ng-show="item.liked">เลิกถูกใจ</a>
                    <a class="add-comment" href="?view=post&post_id={{item.post_id}}">แสดงความคิดเห็น</a>
                </div>
                <div style="margin-top: 5px;">{{item.like_count}} คนถูกใจสิ่งนี้ {{item.comment_count}} ความคิดเห็น</div>
            </div>
        </div>
        <div class="paging-list" ng-show="total > 0" style="color: #000;s">
            หน้าที่
            <a ng-repeat="item in paging"
               class="paging"
               ng-class="{'active': item.current}"
               ng-click="setCurrentPage(item.page)">{{item.page}}</a>
        </div>
    </div>
    <div class="homepage" ng-click="homeClick()"></div>
</div>