<link rel="stylesheet" href="public/app/news/news.css"/>
<script src="bower_components/angularjs/angular.min.js"></script>
<script src="public/app/news/app.js"></script>

<link href="public/assert/ionic/ionic.css" rel="stylesheet">
<script src="public/assert/ionic/ionic.bundle.js"></script>

<style>
    .loading-lightbox {
        width: 100%;
        height: 100%;
        position: absolute;
        z-index: 100;
        background: rgba(0, 0, 0, 0.5);
    }

    p {
        text-align: center;
        margin-bottom: 40px !important;
    }

    .spinner svg {
        width: 19% !important;
        height: 85px !important;
    }

    .loading-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -100px;
        margin-left: -100px;
    }
</style>

<div ng-app="news-app" ng-controller="NewsController">
    <div class="loading-lightbox" ng-hide="initSuccess">
        <ion-spinner icon="android" class="loading-btn"></ion-spinner>
    </div>

    <div class="all">
        <a class="allNews" href="#"></a>
    </div>
    <div class="brief" style="display: none">
        <div class="text_caption"> ข่าวประจำปี 2557</div>
        <div class="text_caption number"> ทั้งหมด (1200)</div>
        <div class="monthly">ข่าวประจำเดือนตุลาคม (180)</div>
        <div class="news-subtype">
            <div class="news-item">
                <div class="img"></div>
                <div class="news-text">
                    "มาริโอ้ เมาเร่อ" เป็นอีกหนึ่งดาราหนุ่มที่ถูกจับตามองอย่างมาก
                    ช่วงฤดูกาลคัดเลือกทหารเกณฑ์ประจำปี
                </div>
            </div>
            <div class="news-item">
                <div class="img"></div>
                <div class="news-text">
                    "มาริโอ้ เมาเร่อ" เป็นอีกหนึ่งดาราหนุ่มที่ถูกจับตามองอย่างมาก
                    ช่วงฤดูกาลคัดเลือกทหารเกณฑ์ประจำปี
                </div>
            </div>
            <div class="news-item">
                <div class="img"></div>
                <div class="news-text">
                    "มาริโอ้ เมาเร่อ" เป็นอีกหนึ่งดาราหนุ่มที่ถูกจับตามองอย่างมาก
                    ช่วงฤดูกาลคัดเลือกทหารเกณฑ์ประจำปี
                </div>
            </div>
            <div class="news-item">
                <div class="img"></div>
                <div class="news-text">
                    "มาริโอ้ เมาเร่อ" เป็นอีกหนึ่งดาราหนุ่มที่ถูกจับตามองอย่างมาก
                    ช่วงฤดูกาลคัดเลือกทหารเกณฑ์ประจำปี
                </div>
            </div>
            <div class="news-item">
                <div class="img"></div>
                <div class="news-text">
                    "มาริโอ้ เมาเร่อ" เป็นอีกหนึ่งดาราหนุ่มที่ถูกจับตามองอย่างมาก
                    ช่วงฤดูกาลคัดเลือกทหารเกณฑ์ประจำปี
                </div>
            </div>
            <div class="news-item">
                <div class="img"></div>
                <div class="news-text">
                    "มาริโอ้ เมาเร่อ" เป็นอีกหนึ่งดาราหนุ่มที่ถูกจับตามองอย่างมาก
                    ช่วงฤดูกาลคัดเลือกทหารเกณฑ์ประจำปี
                </div>
            </div>
        </div>

        <div class="monthly-n">ข่าวประจำเดือนพฤศจิกายน (120)</div>
        <div class="news-subtype-n">
            <div class="news-item-n">
                <div class="img"></div>
                <div class="news-text">
                    "มาริโอ้ เมาเร่อ" เป็นอีกหนึ่งดาราหนุ่มที่ถูกจับตามองอย่างมาก
                    ช่วงฤดูกาลคัดเลือกทหารเกณฑ์ประจำปี
                </div>
            </div>
            <div class="news-item-n">
                <div class="img"></div>
                <div class="news-text">
                    "มาริโอ้ เมาเร่อ" เป็นอีกหนึ่งดาราหนุ่มที่ถูกจับตามองอย่างมาก
                    ช่วงฤดูกาลคัดเลือกทหารเกณฑ์ประจำปี
                </div>
            </div>
            <div class="news-item-n">
                <div class="img"></div>
                <div class="news-text">
                    "มาริโอ้ เมาเร่อ" เป็นอีกหนึ่งดาราหนุ่มที่ถูกจับตามองอย่างมาก
                    ช่วงฤดูกาลคัดเลือกทหารเกณฑ์ประจำปี
                </div>
            </div>

        </div>

        <a class="back"> x </a>
    </div>
    <div class="newsday"></div>
    <div class="backhome" ng-click="backClick()"></div>
    <div class="blockyear">
        <div class="Bn_left"></div>
        <div class="txt_years">2556</div>
        <div class="Bn_right"></div>
    </div>
    <div class="blocksum">
        <div class="blockpic">

            <div class="newsLeft news">
                <div class="news-cover" ng-style="{'background-image': 'url('+newsPrev.news_image_url+')'}"></div>
                <div class="news-body">
                    <h2 id="news-name">{{newsPrev.news_name}}</h2>

                    <p id="news-description">{{newsPrev.news_description}}</p>
                </div>
            </div>

            <div class="newsMid news">
                <div class="read-more" ng-click="readmoreClick()">อ่านต่อ</div>
                <div class="news-cover" ng-style="{'background-image': 'url('+newsCur.news_image_url+')'}"></div>
                <div class="news-body">
                    <h2 id="news-name">{{newsCur.news_name}}</h2>

                    <p id="news-description">{{newsCur.news_description}}</p>
                </div>
            </div>

            <div class="newsRight news">
                <div class="news-cover" ng-style="{'background-image': 'url('+newsNext.news_image_url+')'}"></div>
                <div class="news-body">
                    <h2 id="news-name">{{newsNext.news_name}}</h2>

                    <p id="news-description">{{newsNext.news_description}}</p>
                </div>
            </div>

            <div class="prev" ng-click="prev()"> <</div>
            <div class="next" ng-click="next()"> ></div>
        </div>
        <div class="blockDM">
            <div class="blockDate">
                <div class="date">
                    <div class="bt_left"> <</div>
                    <div class="dates" ng-repeat="item in news" ng-click="setcurrentNews($index)">{{$index+1}}</div>
                    <div class="bt_right"> ></div>
                </div>
                <div class="month">
                    <div class="months">ม.ค.</div>
                    <div class="months">ก.พ.</div>
                    <div class="months">มี.ค.</div>
                    <div class="months">เม.ย.</div>
                    <div class="months">พ.ค.</div>
                    <div class="months">มิ.ย.</div>
                    <div class="months">ก.ค.</div>
                    <div class="months">ส.ค.</div>
                    <div class="months">ก.ย.</div>
                    <div class="months">ต.ค.</div>
                    <div class="months">พ.ย.</div>
                    <div class="months">ธ.ค.</div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        var allNews = $('.allNews');
        var brief = $('.brief');
        var back = $('.back');
        allNews.click(function (e) {
            e.preventDefault();
            brief.show()
        });
        back.click(function (e) {
            e.preventDefault();
            brief.hide()
        });
    })
</script>