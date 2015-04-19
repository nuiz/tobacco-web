<script src="bower_components/angularjs/angular.min.js"></script>
<link rel="stylesheet" href="public/app/subpage/subpage.css"/>
<script src="public/app/subpage/subpage.js"></script>

<div ng-app="subpage" ng-controller="SubpageListCtl">
<div class="bgSubPage"></div>
<div class="label_book"></div>
<!--<div class="search"></div>-->
<div class="back_home" ng-click="subpageClick()"></div>
    <div class="category">
        <a class="type2" href="#"></a>
    </div>
    <div class="Subpagetype" style="display: none">
        <div class="exit2">x
            <a class="exits2" href="#"></a>
        </div>
        <div class="booktype" ng-repeat="booktype in booktypes">
            {{booktype.book_type_name}}
        </div>
    </div>
</div>
<div class="block_book">
    <a href="test.pdf?iframe=true&width=100%&height=100%" rel="prettyPhoto[iframes]"
       title="Google.com opened at 100%">
        <div class="magazine"></div>
    </a>

    <a href="test.pdf?iframe=true&width=100%&height=100%" rel="prettyPhoto[iframes]"
       title="Google.com opened at 100%">
        <div class="magazine2"></div>
    </a>

    <a href="test.pdf?iframe=true&width=100%&height=100%" rel="prettyPhoto[iframes]"
       title="Google.com opened at 100%">
        <div class="magazine3"></div>
    </a>
    <a href="test.pdf?iframe=true&width=100%&height=100%" rel="prettyPhoto[iframes]"
       title="Google.com opened at 100%">
        <div class="magazine4"></div>
    </a>
    <a href="test.pdf?iframe=true&width=100%&height=100%" rel="prettyPhoto[iframes]"
       title="Google.com opened at 100%">
        <div class="magazine5"></div>
    </a>
    <a href="test.pdf?iframe=true&width=100%&height=100%" rel="prettyPhoto[iframes]"
       title="Google.com opened at 100%">
<!--        <div class="lbMg"></div>-->
    </a>
    <a href="test.pdf?iframe=true&width=100%&height=100%" rel="prettyPhoto[iframes]"
       title="Google.com opened at 100%">
        <div class="magazine6"></div>
    </a>
    <a href="test.pdf?iframe=true&width=100%&height=100%" rel="prettyPhoto[iframes]"
       title="Google.com opened at 100%">
        <div class="magazine7"></div>
    </a>
    <a href="test.pdf?iframe=true&width=100%&height=100%" rel="prettyPhoto[iframes]"
       title="Google.com opened at 100%">
        <div class="magazine8"></div>
    </a>
    <a href="test.pdf?iframe=true&width=100%&height=100%" rel="prettyPhoto[iframes]"
       title="Google.com opened at 100%">
        <div class="magazine9"></div>
    </a>
    <a href="test.pdf?iframe=true&width=100%&height=100%" rel="prettyPhoto[iframes]"
       title="Google.com opened at 100%">
        <div class="magazine10"></div>
    </a>
</div>
<script>
    $(function () {
        var type2 = $('.type2');
        var Subpagetype = $('.Subpagetype');
        var exits2 = $('.exits2');
        type2.click(function (e) {
            e.preventDefault();
            Subpagetype.show()
        });
        exits2.click(function (e) {
            e.preventDefault();
            Subpagetype.hide()
        });
    });
</script>