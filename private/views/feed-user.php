<link href="public/assert/video-js/video-js.min.css" rel="stylesheet">
<script src="public/assert/video-js/video.js"></script>
<script src="bower_components/angularjs/angular.min.js"></script>
<link rel="stylesheet" href="public/app/feed-user/feed-user.css"/>
<script src="public/app/feed-user/feed-user.js"></script>
<div ng-app="profile" ng-controller="ProfileCtl">
    <div class="tab">
        <a class="logo" href="?view=feed"></a>
<!--        <div class="search">ค้นหา</div>-->
        <div class="status">
            <div class="tus">
                <a href="?view=feed-user&account_id={{user.account_id}}" style="color: white; text-decoration: none;">
                    <img src="http://placehold.it/40x40" class="profile-image">
                    <?php //echo $_SESSION['user']['firstname']; ?>
                    {{user.firstname}}
                </a>
            </div>
        </div>
        <div class="icon">
            <div class="icon-setting"></div>
        </div>
    </div>
    <div class="data" ng-controller="FeedListCtl">
        <div class="paging-list">
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
                <div class="user-img"><img src="http://placehold.it/40x40"></div>
                <div class="user-name"><a href="?view=feed-user&account_id={{item.user.account_id}}">{{item.user.firstname + ' ' + item.user.lastname}}</a></div>
                <div class="post-time"><small>17 พย. 2558 เวลา 15:00 น.</small></div>
            </div>
            <div class="content">
                <div>{{item.post_text}}</div>
                <div ng-if="item.post_type=='image'" class="post-image-list">
                    <img ng-repeat="img in item.images" src="{{img.image_url}}" class="post-img" />
                </div>
                <div ng-if="item.post_type=='video'" class="video-wrap">
                    <video videojs class="video-js vjs-default-skin vjs-big-play-centered video-player" controls
                           preload="auto" width="540" height="303"
                           data-setup="{}">
                        <source src="{{item.video_url}}" type='video/mp4'>
                        <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
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
        <div class="paging-list">
            หน้าที่
            <a ng-repeat="item in paging"
               class="paging"
               ng-class="{'active': item.current}"
               ng-click="setCurrentPage(item.page)">{{item.page}}</a>
        </div>
    </div>
    <div class="homepage" ng-click="homeClick()"></div>
</div>