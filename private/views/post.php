<!--<link href="public/assert/video-js/video-js.min.css" rel="stylesheet">-->
<!--<script src="public/assert/video-js/video.js"></script>-->
<script src="bower_components/angularjs/angular.min.js"></script>
<link rel="stylesheet" href="public/app/post/post.css"/>
<script src="public/app/post/post.js"></script>
<div ng-app="post-app" ng-controller="ProfileCtl">
    <!-- topbar -->
    <div class="tab">
        <a class="logo" href="?view=feed"></a>
<!--        <div class="search">ค้นหา</div>-->
        <div class="status">
            <div class="tus" ng-if="user.account_id">
                <span>
                    <img src="{{user.picture}}" width="40" height="40" class="profile-image">
                    <?php //echo $_SESSION['user']['firstname']; ?>
                    {{user.firstname}}
                </span>
                |
                <a href="?view=feed-user&account_id={{user.account_id}}" style="color: white; text-decoration: none; font-size: 16px;">
                    ดูข้อมูลส่วนตัว
                </a>
            </div>
        </div>
        <div class="icon">
            <!-- <div class="icon-setting"></div> -->
        </div>
    </div>
    <!-- end topbar -->
    
    <div class="data" ng-controller="PostCtl">
    <div class="buttonleft"><img src="img/icon_black.png"> กลับไปหน้าหลัก</div>
        <div class="post"
             ng-class="{'post-text': item.post_type=='text', 'post-video': item.post_type=='video', 'post-video': item.post_type=='image'}">
            <div class="user-des">
                <div class="delete-post"><a href=""><img src="img/delete.png" alt="delete icon" style="width:20px; height:20px;"> ลบ </a></div>
                <div class="user-img"><img src="{{item.user.picture}}" style="width: 38px;  height: 38px;  object-fit: cover;"></div>
                <div class="user-name"><a href="#">{{item.user.firstname + ' ' + item.user.lastname}}</a></div>
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
                </div>
                <div style="margin-top: 5px;">{{item.like_count}} คนถูกใจสิ่งนี้ {{item.comment_count}} ความคิดเห็น</div>
            </div>
        </div>

        <div class="comment-list">
            <div class="post comment"
                ng-repeat="c in comments">
                <div class="user-des">
                    <div class="delete-post"><a href=""><img src="img/delete.png" alt="delete icon" style="width:20px; height:20px;"> ลบ </a></div>
                    <div class="user-img"><img src="{{c.user.picture}}" style="width: 38px;  height: 38px;  object-fit: cover;"></div>
                    <div class="user-name"><a href="#">{{c.user.firstname + ' ' + c.user.lastname}}</a></div>
                    <div class="post-time"><small>{{dateThai(c.created_at)}}</small></div>
                </div>
                <div class="content">
                    <div>{{c.comment_text}}</div>
                </div>
            </div>
        </div>

        <div class="comment-form" ng-if="user.account_id">
            <form ng-submit="addComment()" style="padding: 1px 20px 20px 20px;
            border-radius: 10px;
  background: rgba(0,0,0,0.2);">
                <div class="post comment comment-add-block">
                    <div class="user-des">
                        <div class="user-img"><img src="{{user.picture}}" class="profile-image" width="40" height="40"></div>
                        <div class="user-name"><a href="#">{{userlogin.firstname + ' ' + userlogin.lastname}}</a></div>
                        <div class="post-time"><small>(แสดงความคิดเห็น)</small></div>
                    </div>
                    <div class="content">
                        <div><textarea style="width: 100%; height: 80px; resize: none;" ng-model="addForm.comment_text"></textarea></div>
                        <button class="wood-bg-btn">แสดงความคิดเห็น</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

 