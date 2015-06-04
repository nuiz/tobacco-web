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

        <div class="guru-chose-block" ng-hide="selectedGuru==null">
            <div class="history-btn"></div>
            <div class="blog-btn"></div>
            <div class="phone-btn"></div>
            <div class="content-btn"></div>
            <div class="display-picture"></div>
            <div class="name">{{selectedGuru.firstname}} {{selectedGuru.lastname}}</div>
            <div class="cat_name">{{selectedGuru.guru_cat_name}}</div>
            <div style="text-align: center"><div class="leaf"></div></div>
        </div>

        <div class="guru"
             ng-repeat="item in gurus"
             ng-class="'guru-'+($index+1)"
             ng-hide="selectedCat==null"
             ng-click="clickGuru(item)">
        </div>

        <div class="cat-icon"
            ng-repeat="item in cats | startFrom:catPage*11 | limitTo: 11"
            ng-class="'cat-'+($index+1)"
            ng-click="clickCat($index)">
            <div class="yellow-line" ng-show="selectedCat==null"></div>
            <div class="name" ng-show="selectedCat==null">{{item.guru_cat_name}}</div>
        </div>
    </div>
</div>
