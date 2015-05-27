<link href="public/assert/video-js/video-js.min.css" rel="stylesheet">
<script src="public/assert/video-js/video.js"></script>
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
    <div class="data" ng-controller="FeedListCtl">
        <div>
            <a class="wood-bg-btn">โพสต์ข้อความ</a>
            <a class="wood-bg-btn">โพสต์รูปภาพ</a>
            <a class="wood-bg-btn">โพสต์วิดีโอ</a>
        </div>
        <div class="form-post-section">
            <form id="form-post-text">
                <div>
                    <textarea type="text" class="post-textarea"></textarea>
                </div>
                <div>
                    <button type="submit" class="wood-bg-btn">โพสต์</button>
                </div>
            </form>
        </div>
        <div class="post"
             ng-repeat="item in posts"
             ng-class="{'post-text': item.post_type=='text', 'post-video': item.post_type=='video', 'post-video': item.post_type=='image'}">
            <div class="user-des">
                <div class="user-img"><img src="http://placehold.it/40x40"></div>
                <div class="user-name"><a href="#">{{item.user.firstname + ' ' + item.user.lastname}}</a></div>
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
                <span>{{item.like_count}} ถูกใจ {{item.comment_count}} ความคิดเห็น</span>
                <a class="add-comment" href="">แสดงความคิดเห็น</a>
            </div>
        </div>

<!--        <div class="post post-text">-->
<!--            <div class="user-des">-->
<!--                <div class="user-img"><img src="http://placehold.it/40x40"></div>-->
<!--                <div class="user-name"><a href="#">นางทดสอบ ทดสอบนะ</a></div>-->
<!--                <div class="post-time"><small>17 พย. 2558 เวลา 15:00 น.</small></div>-->
<!--            </div>-->
<!--            <div class="clearfix"></div>-->
<!--            <div class="content">-->
<!--                <div>Lorem Ipsum คือ เนื้อหาจำลองแบบเรียบๆ ที่ใช้กันในธุรกิจงานพิมพ์หรืองานเรียงพิมพ์ มันได้กลายมาเป็นเนื้อหาจำลองมาตรฐานของธุรกิจดังกล่าวมาตั้งแต่ศตวรรษที่ 16 เมื่อเครื่องพิมพ์โนเนมเครื่องหนึ่งนำรางตัวพิมพ์มาสลับสับตำแหน่งตัวอักษรเพื่อทำหนังสือตัวอย่าง Lorem Ipsum อยู่ยงคงกระพันมาไม่ใช่แค่เพียงห้าศตวรรษ แต่อยู่มาจนถึงยุคที่พลิกโฉมเข้าสู่งานเรียงพิมพ์ด้วยวิธีทางอิเล็กทรอนิกส์ และยังคงสภาพเดิมไว้อย่างไม่มีการเปลี่ยนแปลง มันได้รับความนิยมมากขึ้นในยุค ค.ศ. 1960 เมื่อแผ่น Letraset วางจำหน่ายโดยมีข้อความบนนั้นเป็น Lorem Ipsum และล่าสุดกว่านั้น คือเมื่อซอฟท์แวร์การทำสื่อสิ่งพิมพ์ (Desktop Publishing) อย่าง Aldus PageMaker ได้รวมเอา Lorem Ipsum เวอร์ชั่นต่างๆ เข้าไว้ในซอฟท์แวร์ด้วย</div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="post post-image">-->
<!--            <div class="user-des">-->
<!--                <div class="user-img"><img src="http://placehold.it/40x40"></div>-->
<!--                <div class="user-name"><a href="#">นางทดสอบ ทดสอบนะ</a></div>-->
<!--                <div class="post-time"><small>17 พย. 2558 เวลา 15:00 น.</small></div>-->
<!--            </div>-->
<!--            <div class="clearfix"></div>-->
<!--            <div class="content">-->
<!--                <div>Lorem Ipsum คือ เนื้อหาจำลองแบบเรียบๆ ที่ใช้กันในธุรกิจงานพิมพ์หรืองานเรียงพิมพ์ มันได้กลายมาเป็นเนื้อหาจำลองมาตรฐานของธุรกิจดังกล่าวมาตั้งแต่ศตวรรษที่ 16 เมื่อเครื่องพิมพ์โนเนมเครื่องหนึ่งนำรางตัวพิมพ์มาสลับสับตำแหน่งตัวอักษรเพื่อทำหนังสือตัวอย่าง Lorem Ipsum อยู่ยงคงกระพันมาไม่ใช่แค่เพียงห้าศตวรรษ แต่อยู่มาจนถึงยุคที่พลิกโฉมเข้าสู่งานเรียงพิมพ์ด้วยวิธีทางอิเล็กทรอนิกส์ และยังคงสภาพเดิมไว้อย่างไม่มีการเปลี่ยนแปลง มันได้รับความนิยมมากขึ้นในยุค ค.ศ. 1960 เมื่อแผ่น Letraset วางจำหน่ายโดยมีข้อความบนนั้นเป็น Lorem Ipsum และล่าสุดกว่านั้น คือเมื่อซอฟท์แวร์การทำสื่อสิ่งพิมพ์ (Desktop Publishing) อย่าง Aldus PageMaker ได้รวมเอา Lorem Ipsum เวอร์ชั่นต่างๆ เข้าไว้ในซอฟท์แวร์ด้วย</div>-->
<!--                <div class="post-image-list">-->
<!--                    <img src="http://placehold.it/180x180">-->
<!--                    <img src="http://placehold.it/180x180">-->
<!--                    <img src="http://placehold.it/180x180">-->
<!--                    <img src="http://placehold.it/180x180">-->
<!--                    <img src="http://placehold.it/180x180">-->
<!--                    <img src="http://placehold.it/180x180">-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="post post-video">-->
<!--            <div class="user-des">-->
<!--                <div class="user-img"><img src="http://placehold.it/40x40"></div>-->
<!--                <div class="user-name"><a href="#">นางทดสอบ ทดสอบนะ</a></div>-->
<!--                <div class="post-time"><small>17 พย. 2558 เวลา 15:00 น.</small></div>-->
<!--            </div>-->
<!--            <div class="clearfix"></div>-->
<!--            <div class="content">-->
<!--                <div>Lorem Ipsum คือ เนื้อหาจำลองแบบเรียบๆ ที่ใช้กันในธุรกิจงานพิมพ์หรืองานเรียงพิมพ์ มันได้กลายมาเป็นเนื้อหาจำลองมาตรฐานของธุรกิจดังกล่าวมาตั้งแต่ศตวรรษที่ 16 เมื่อเครื่องพิมพ์โนเนมเครื่องหนึ่งนำรางตัวพิมพ์มาสลับสับตำแหน่งตัวอักษรเพื่อทำหนังสือตัวอย่าง Lorem Ipsum อยู่ยงคงกระพันมาไม่ใช่แค่เพียงห้าศตวรรษ แต่อยู่มาจนถึงยุคที่พลิกโฉมเข้าสู่งานเรียงพิมพ์ด้วยวิธีทางอิเล็กทรอนิกส์ และยังคงสภาพเดิมไว้อย่างไม่มีการเปลี่ยนแปลง มันได้รับความนิยมมากขึ้นในยุค ค.ศ. 1960 เมื่อแผ่น Letraset วางจำหน่ายโดยมีข้อความบนนั้นเป็น Lorem Ipsum และล่าสุดกว่านั้น คือเมื่อซอฟท์แวร์การทำสื่อสิ่งพิมพ์ (Desktop Publishing) อย่าง Aldus PageMaker ได้รวมเอา Lorem Ipsum เวอร์ชั่นต่างๆ เข้าไว้ในซอฟท์แวร์ด้วย</div>-->
<!--                <div class="video-wrap">-->
<!--                    <video id="MY_VIDEO_1" class="video-js vjs-default-skin vjs-big-play-centered video-player" controls-->
<!--                           preload="auto" width="540" height="303"-->
<!--                           data-setup="{}">-->
<!--                        <source src="http://www.w3schools.com/html/mov_bbb.mp4" type='video/mp4'>-->
<!--                        <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>-->
<!--                    </video>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </div>
    <div class="homepage" ng-click="homeClick()"></div>
</div>