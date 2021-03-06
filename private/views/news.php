<link rel="stylesheet" href="public/app/news/news.css"/>
<script src="bower_components/angularjs/angular.min.js"></script>
<script src="public/app/news/app.js"></script>

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
    <div class="all">
        <a class="allNews" href="#"></a>
    </div>
    <div class="brief" style="display: none; padding-top: 46px;">
        <div style="overflow: auto; height: 488px;">
            <div class="text_caption"> ข่าวประจำปี {{date.getFullYear()+543}}</div>
            <div class="text_caption number"> ทั้งหมด ({{list2.length}})</div>
            <div
                ng-repeat="m in list2.data"
                ng-show="m.length > 0"
                >
                <div class="monthly">ข่าวประจำเดือน{{thMonth[11-$index]}} ({{m.length}})</div>
                <div class="news-subtype">
                    <div
                        class="news-item"
                        ng-repeat="news in m.data"
                        ng-click="readmoreClick(news.news_id)"
                        >
                        <div class="img"
                             ng-style="{'background-image': 'url('+news.news_cover_url+')'}"></div>
                        <div class="news-text">
                            {{(news.news_description.length > 160) ? news.news_description.substring(0,160)+"...": news.news_description}}
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                </div>
                <div style="clear: both;"></div>
            </div>


        </div>

        <a class="back"> x </a>
    </div>
    <div class="newsday"></div>
    <div class="backhome" ng-click="backClick()"></div>
    <div class="blockyear">
        <div class="Bn_left" ng-click="prevYear()" ng-show="date.getFullYear() > 2014"></div>
        <div class="txt_years">{{date.getFullYear()+543}}</div>
        <div class="Bn_right" ng-click="nextYear()" ng-show="date.getFullYear() < dateNow.getFullYear()"></div>
    </div>
    <div class="blocksum">
        <div class="blockpic">

            <div class="newsLeft news" ng-show="news.length >= 3">
                <div class="news-cover">
                    <img src="{{newsPrev.news_cover_url}}" style="width: 100%; height: auto;">
                </div>
                <div class="news-body">
                    <h2 class="news-name">{{newsPrev.news_name}}</h2>
                    <p class="news-description">{{(newsPrev.news_description.length > 160) ? newsPrev.news_description.substring(0,160)+"...": newsPrev.news_description;}}</p>
                </div>
            </div>

            <div class="newsMid news" ng-show="news.length >= 1">
                <div class="read-more" ng-click="readmoreClick(newsCur.news_id)">อ่านต่อ</div>
                <div class="news-cover">
                    <img src="{{newsCur.news_cover_url}}" style="width: 100%; height: auto;">
                </div>
                <div class="news-body">
                    <h2 class="news-name">{{newsCur.news_name}}</h2>
                    <p class="news-description">{{(newsCur.news_description.length > 300) ? newsCur.news_description.substring(0,300)+"...": newsCur.news_description;}}</p>
                </div>
            </div>

            <div class="newsRight news" ng-show="news.length >= 2">
                <div class="news-cover">
                    <img src="{{newsNext.news_cover_url}}" style="width: 100%; height: auto;">
                </div>
                <div class="news-body">
                    <h2 class="news-name">{{newsNext.news_name}}</h2>
                    <p class="news-description">{{(newsNext.news_description.length > 160) ? newsNext.news_description.substring(0,160)+"...": newsNext.news_description;}}</p>
                </div>
            </div>

            <div class="prev" ng-click="prev()"></div>
            <div class="next" ng-click="next()"></div>
        </div>
        <div class="blockDM">
            <div class="blockDate">
                <!-- <div class="date">
                    <div class="bt_left" ng-show="pagingStart > 0" ng-click="pagingPrev()"> <</div>
                    <div class="dates" ng-repeat="item in news" ng-click="setcurrentNews($index)" ng-show="$index >= pagingStart && $index < pagingStart + pagingLimit">{{$index+1}}</div>
                    <div class="bt_right" ng-show="news.length > pagingStart + pagingLimit" ng-click="pagingNext()"> ></div>
                </div> -->
                <div class="month">
                    <div class="months" ng-click="setMonth(0)" ng-class="{active: date.getMonth()==0}">ม.ค.<div class="g"></div></div>
                    <div class="months" ng-click="setMonth(1)" ng-class="{active: date.getMonth()==1}">ก.พ.<div class="g"></div></div>
                    <div class="months" ng-click="setMonth(2)" ng-class="{active: date.getMonth()==2}">มี.ค.<div class="g"></div></div>
                    <div class="months" ng-click="setMonth(3)" ng-class="{active: date.getMonth()==3}">เม.ย.<div class="g"></div></div>
                    <div class="months" ng-click="setMonth(4)" ng-class="{active: date.getMonth()==4}">พ.ค.<div class="g"></div></div>
                    <div class="months" ng-click="setMonth(5)" ng-class="{active: date.getMonth()==5}">มิ.ย.<div class="g"></div></div>
                    <div class="months" ng-click="setMonth(6)" ng-class="{active: date.getMonth()==6}">ก.ค.<div class="g"></div></div>
                    <div class="months" ng-click="setMonth(7)" ng-class="{active: date.getMonth()==7}">ส.ค.<div class="g"></div></div>
                    <div class="months" ng-click="setMonth(8)" ng-class="{active: date.getMonth()==8}">ก.ย.<div class="g"></div></div>
                    <div class="months" ng-click="setMonth(9)" ng-class="{active: date.getMonth()==9}">ต.ค.<div class="g"></div></div>
                    <div class="months" ng-click="setMonth(10)" ng-class="{active: date.getMonth()==10}">พ.ย.<div class="g"></div></div>
                    <div class="months" ng-click="setMonth(11)" ng-class="{active: date.getMonth()==11}">ธ.ค.<div class="g"></div></div>
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