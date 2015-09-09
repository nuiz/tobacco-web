<link rel="stylesheet" href="public/app/category/category.css"/>
<script src="bower_components/angularjs/angular.min.js"></script>
<script src="public/app/category/category.js"></script>
<div class="all"></div>
<div ng-app="category" ng-controller="CategorysListCtl">
    <div class="backHm" ng-click="backClick()"></div>
    <div class="icon">
        <div class="bottom">
            <a class="bottomClick" href="#"></a>
        </div>
        <div class="icon1"
          ng-repeat="item in category1"
          ng-click="readmoreClick(item.category_id)"
          >
            <img src="{{item.desktop_icon_url}}">

            <div>{{item.category_name}}</div>
        </div>
        <!-- <div class="icon1" ng-click="readmoreClick(2)">
            <img src="public/app/category/images/22.png">

            <div>จัดซื้อ/จัดจ้าง</div>
        </div>
        <div class="icon1" ng-click="readmoreClick(3)">
            <img src="public/app/category/images/3.png">

            <div>เทคโนโลยี</div>
        </div>
        <div class="icon1" ng-click="readmoreClick(4)">
            <img src="public/app/category/images/4.png">

            <div>การพิมพ์</div>
        </div>
        <div class="icon1" ng-click="readmoreClick(5)">
            <img src="public/app/category/images/5.png">

            <div>การผลิต</div>
        </div>
        <div class="icon1" ng-click="readmoreClick(6)">
            <img src="public/app/category/images/6.png">

            <div>การวิจัย</div>
        </div>
        <div class="icon1" ng-click="readmoreClick(7)">
            <img src="public/app/category/images/7.png">

            <div>ใบยา</div>
        </div>
        <div class="icon1" ng-click="readmoreClick(8)">
            <img src="public/app/category/images/8.png">

            <div>ความปลอดภัยและสิ่งแวดล้อม</div>
        </div>
        <div class="icon1" ng-click="readmoreClick(9)">
            <img src="public/app/category/images/9.png">

            <div>บุคคล/บริหาร</div>
        </div>
        <div class="icon1" ng-click="readmoreClick(10)">
            <img src="public/app/category/images/10.png">

            <div>งานช่าง</div>
        </div>
        <div class="icon1" ng-click="readmoreClick(11)">
            <img src="public/app/category/images/11.png">

            <div>โครงการย้ายโรงงานใหม่</div>
        </div>
        <div class="icon1" ng-click="readmoreClick(12)">
            <img src="public/app/category/images/12.png">

            <div>กำกับตรวจสอบ</div>
        </div>
        <div class="icon1" ng-click="readmoreClick(13)">
            <img src="public/app/category/images/13.png">

            <div>บัญชี การเงิน งบประมาณ</div>
        </div>
        <div class="icon1" ng-click="readmoreClick(14)">
            <img src="public/app/category/images/14.png">

            <div>ผลิตภัณฑ์</div>
        </div>
        <div class="icon1" ng-click="readmoreClick(15)">
            <img src="public/app/category/images/15.png">

            <div>การแพทย์อาหาร/สุขภาพ</div>
        </div>
        <div class="icon1" ng-click="readmoreClick(16)">
            <img src="public/app/category/images/16.png">

            <div>ความรู้ทั่วไป</div>
        </div> -->
    </div>
    <div class="icon2" style="display: none">
      <div class="icon1"
        ng-repeat="item in category2"
          ng-click="readmoreClick(item.category_id)"
        >
          <img src="{{item.desktop_icon_url}}">

          <div>{{item.category_name}}</div>
      </div>
        <!-- <div class="icon1" ng-click="readmoreClick(17)">
            <img src="public/app/category/images/17.png">

            <div>แผนยุทธศาสตร์</div>
        </div>
        <div class="icon1" ng-click="readmoreClick(18)">
            <img src="public/app/category/images/18.png">

            <div>การตลาดการขาย</div>
        </div> -->
        <div class="bottomBack">
            <a class="bottomBack2" href="#"></a>
        </div>
    </div>
</div>
<script>
    $(function () {
        var icon = $('.icon');
        var bottomClick = $('.bottomClick');
        var icon2 = $('.icon2');
        var bottomBack2 = $('.bottomBack2');
        bottomClick.click(function (e) {
            e.preventDefault();
            icon.hide();
            icon2.show()
        });
        bottomBack2.click(function (e) {
            e.preventDefault();
            icon2.hide();
            icon.show()
        });
    });
</script>
