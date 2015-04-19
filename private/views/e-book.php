<script src="bower_components/angularjs/angular.min.js"></script>
<link rel="stylesheet" href="public/app/e-book/e-book.css"/>
<script src="public/app/e-book/ebook.js"></script>
<div class="body">
    <div ng-app="ebook" ng-controller="EbookListCtl">
        <div class="back_home" ng-click="backhome()"></div>
        <div class="book">
            <div class="booksClick" ng-click="bookClick()"> > </div>
            <div class="mag1"></div>
            <div class="mag2"></div>
            <div class="mag3"></div>
            <div class="mag4"></div>
            <div class="mag5"></div>
            <div class="mag6"></div>
            <div class="mag7"></div>
            <div class="mag8"></div>
        </div>
        <div class="book_other">
            <div class="booksClick" ng-click="bookClick()"> < </div>
            <div class="book1"></div>
            <div class="book2"></div>
            <div class="book3"></div>
            <div class="book4"></div>
            <div class="book5"></div>
            <div class="book6"></div>
            <div class="book7"></div>
            <div class="book8"></div>
        </div>
        <div class="b_shf">
            <div class="shelf_smalls"></div>
            <div class="shelf_book"></div>
            <div class="shelf_small"></div>
            <a href="test.pdf?iframe=true&width=100%&height=100%" rel="prettyPhoto[iframes]"
               title="Google.com opened at 100%">
                <div class="magshf"></div>
            </a>

            <a href="test.pdf?iframe=true&width=100%&height=100%" rel="prettyPhoto[iframes]"
               title="Google.com opened at 100%">
                <div class="magshf2"></div>
            </a>
        </div>
        <div class="label_book"></div>
<!--        <div class="search"></div>-->

        <div class="lb_category">
            <a class="type" href="#"></a>
        </div>
        <div class="Ebooktype" style="display: none">
            <div class="exit">x
                <a class="exit1" href="#"></a>
            </div>
            <div class="booktype" ng-click="bookClick(booktype.book_type_id)" ng-repeat="booktype in booktypes">
                {{booktype.book_type_name}}
            </div>
        </div>

        <div class="bg_black">
            <div class="mag"></div>
            <div class="mag"></div>
            <div class="mag"></div>
        </div>

    </div>
</div>
<script>
    $(function () {
        var type = $('.type');
        var typeEbook = $('.Ebooktype');
        var exit1 = $('.exit1');
        type.click(function (e) {
            e.preventDefault();
            typeEbook.show()
        });
        exit1.click(function (e) {
            e.preventDefault();
            typeEbook.hide()
        });
    });
</script>
