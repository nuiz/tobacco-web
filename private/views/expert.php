<link rel="stylesheet" href="public/app/expert/expert.css"/>
<script src="bower_components/angularjs/angular.min.js"></script>
<script src="public/app/expert/expert.js"></script>
<div class="body">
    <div ng-app="expert"
         ng-controller="ExpertListCtl">
        <div class="bg_expert"></div>
        <div class="label_ep"></div>
        <div class="circle">
            <a class="toggle" href="#"></a>
        </div>
        <div class="circle2" style="display: none">
            <a class="toggle2" href="#"></a>
        </div>
        <div class="back_home" ng-click="homeClick()"></div>
    </div>
</div>
<script>
    $(function () {
        var circle = $('.circle');
        var circle2 = $('.circle2');
        var toggle = $('.toggle');
        var toggle2 = $('.toggle2');

        toggle.click(function (e) {
            e.preventDefault();
            circle.hide();
            circle2.show()
        });
        toggle2.click(function (e) {
            e.preventDefault();
            circle2.hide();
            circle.show()
        });
    });
</script>
