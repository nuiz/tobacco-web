<link rel="stylesheet" href="public/app/expert/expert.css"/>
<script src="bower_components/angularjs/angular.min.js"></script>
<script src="public/app/expert/expert.js"></script>
<div class="expert-body" ng-app="expert"
     ng-controller="ExpertListCtl">
    <div class="label_ep"></div>
    <div class="circle">
        <div class="circle-grow" ng-hide="selectedCat==null"></div>
        <div class="lever" ng-click="clickLever()"></div>

        <div class="cat-icon cat-1" ng-click="clickCat(0)">
            <div class="yellow-line"></div>
            <div class="name">ผู้เชี่ยวชาญกฎหมาย</div>
        </div>
        <div class="cat-icon cat-2" ng-click="clickCat(1)">
            <div class="yellow-line"></div>
            <div class="name">ผู้เชี่ยวชาญด้านการผลิต</div>
        </div>
        <div class="cat-icon cat-3" ng-click="clickCat(2)">
            <div class="yellow-line"></div>
            <div class="name">ผู้เชี่ยวชาญการพิมพ์</div>
        </div>
        <div class="cat-icon cat-4" ng-click="clickCat(3)">
            <div class="yellow-line"></div>
            <div class="name">ผู้เชี่ยวชาญการแพทย์</div>
        </div>
        <div class="cat-icon cat-5" ng-click="clickCat(4)">
            <div class="yellow-line"></div>
            <div class="name">ผู้เชี่ยวชาญการช่าง</div>
        </div>
        <div class="cat-icon cat-6" ng-click="clickCat(5)">
            <div class="yellow-line"></div>
            <div class="name">ผู้เชี่ยวชาญการวิจัย</div>
        </div>
        <div class="cat-icon cat-7" ng-click="clickCat(6)">
            <div class="yellow-line"></div>
            <div class="name">ผู้เชี่ยวชาญบัญชีและงบประมาน</div>
        </div>
        <div class="cat-icon cat-8" ng-click="clickCat(7)">
            <div class="yellow-line"></div>
            <div class="name">ผู้เชี่ยวชาญผลิตภัณฑ์</div>
        </div>
        <div class="cat-icon cat-9" ng-click="clickCat(8)">
            <div class="yellow-line"></div>
            <div class="name">ผู้เชี่ยวชาญบริหาร</div>
        </div>
        <div class="cat-icon cat-10" ng-click="clickCat(9)">
            <div class="yellow-line"></div>
            <div class="name">ผู้เชี่ยวชาญเทคโนโลยี</div>
        </div>
        <div class="cat-icon cat-11" ng-click="clickCat(10)">
            <div class="yellow-line"></div>
            <div class="name">ผู้เชี่ยวชาญการ</div>
        </div>
    </div>
</div>
