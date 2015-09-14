<link rel="stylesheet" href="public/app/expert/expert.css"/>
<script src="bower_components/angularjs/angular.min.js"></script>
<script src="public/app/expert/expert.js"></script>
<div class="expert-body" ng-app="expert"
     ng-controller="ExpertListCtl">
    <div class="label_ep"></div>
    <div class="circle">
        <div class="circle-grow" ng-hide="selectedCat==null"></div>
        <div class="lever" ng-class="{down: catPage==1}" ng-click="clickLever()" ng-hide="selectedCat!=null"></div>
        <div class="close-cat" ng-hide="selectedCat==null" ng-click="closeCatClick()"></div>
        <div class="button-slide">
        	<i class="btt-next" ng-show="selectedCat!=null && gurusCurPage < gurusMaxPage" ng-click="setGuruPage(gurusCurPage+1)"></i>
        	<i class="btt-back" ng-show="selectedCat!=null && gurusCurPage > 0" ng-click="setGuruPage(gurusCurPage-1)"></i>
        </div>

        <div class="guru-chose-block" ng-hide="selectedGuru==null">
            <div class="history-btn" title="ประวัตของผู้เชี่ยวชาญ" ng-lightbox='{"trigger": "manual", "element": "lightbox-history"}'></div>
            <div class="blog-btn" title="โพสต์ของผู้เชี่ยวชาญ" ng-click="gotoFeedUser(selectedGuru)"></div>
            <div class="phone-btn" ng-lightbox='{"trigger": "manual", "element": "lightbox-telephone"}'></div>
            <div class="content-btn" title="องค์ความรู้ของผู้เชี่ยวชาญ" ng-lightbox='{"trigger": "manual", "element": "lightbox-content"}'></div>
            <div class="display-picture" ng-style="{'background-image': 'url('+selectedGuru.picture+')'}"></div>
            <div class="name">{{selectedGuru.firstname}} {{selectedGuru.lastname}}</div>
            <div class="cat_name">{{selectedGuru.guru_cat_name}}</div>
            <div style="text-align: center"><div class="leaf"></div></div>
        </div>

        <div class="guru"
             ng-repeat="item in gurusVM"
             ng-class="'guru-'+($index+1)"
             ng-hide="selectedCat==null"
             ng-style="{'background-image': 'url('+item.picture+')'}"
             ng-click="clickGuru(item)">
        </div>

        <div class="cat-icon"
            ng-repeat="item in cats | startFrom:catPage*11 | limitTo: 11"
            ng-class="'cat-'+($index+1)"
            ng-style="{'background-image': 'url('+item.guru_cat_icon_url+')'}"
            ng-click="clickCat($index)">
            <div class="yellow-line" ng-show="selectedCat==null"></div>
            <div class="name"
                ng-show="selectedCat==null"
                ng-attr-center-position="{{centerPositions.indexOf($index) != -1}}">{{item.guru_cat_name}}</div>
        </div>
    </div>

    <div class="lightbox" id="lightbox-history">
        <span ng-lightbox-close class="close-popup-btn"></span>
        <div class="wrap">
            <h1>ประวัติผู้เชี่ยวชาญ</h1>
            <p>{{selectedGuru.guru_history}}</p>
        </div>
    </div>
    <div class="lightbox" id="lightbox-telephone">
        <span ng-lightbox-close class="close-popup-btn"></span>
        <div class="wrap">
            <h1>เบอร์โทรศัพท์ผู้เชี่ยวชาญ</h1>
            <div style="text-align: center;">{{selectedGuru.guru_telephone}}</div>
        </div>
    </div>
    <div class="lightbox" id="lightbox-content">
        <span ng-lightbox-close class="close-popup-btn"></span>
        <div class="wrap">
            <h1>องค์ความรู้ผู้เชียวชาญ</h1>
            <div class="list-content" ng-repeat="item in contents" ng-click="clickContent(item, selectedGuru)">
               	<div class="content-thumb" ng-style="{'background-image': 'url('+item.videos[0].video_thumb_url +')'}" ng-if="item.content_type=='video'">
                	<!-- start display video -->
                    <div class="display-video">
                    	<i class="icon-video"></i>  <!--display video-->
                    </div><!-- end icon video-->
                </div>
                <div class="content-thumb" ng-style="{'background-image': 'url('+item.book_cover_url +')'}" ng-if="item.content_type=='book'">
                	 <!-- start display ebook -->
            		    <div class="display-ebook">
                    	<i class="icon-ebook"></i> <!--display ebook-->
                   </div><!-- end icon video-->
                </div>
                <div class="subject">
                  	<h1 class="name-subject">{{item.content_name}}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
