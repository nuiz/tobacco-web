<script src="bower_components/angularjs/angular.min.js"></script>
<link rel="stylesheet" href="public/app/reserch/reserch.css"/>
<script src="public/app/reserch/reserchAPP.js"></script>
<div ng-app="reserch"
     ng-controller="ReserchListCtl">
    <div class="Tinews">
        <div class="sum">
            <div class="material">รวมเนื้อหา</div>
            <div class="video">รวมวีดีโอ</div>
        </div>
        <div class="Caption">หัวข้อ
            <a href="images/G_reserch/42585048.jpg" rel="prettyPhoto[pp_gal]"
               title="Google.com opened at 100%">
                <div class="Pic">
                    <div class="TextPic">รักษาการ</div>
                </div>
            </a>

            <a href="images/G_reserch/Image.jpeg" rel="prettyPhoto[pp_gal]"
               title="Google.com opened at 100%">
                <div class="PicII">
                    <div class="TextPicII">รักษาการ</div>
                </div>
            </a>
            <a href="images/G_reserch/Image.jpeg" rel="prettyPhoto[pp_gal]"
               title="Google.com opened at 100%">
                <div class="Pix">
                    <div class="TextPix">รักษาการ</div>
                </div>
                <div class="PixII">
                    <div class="TextPixII">รักษาการ</div>
                </div>
            </a>
        </div>

        <div class="CaptionII">หัวข้อ
            <a href="images/G_reserch/Image.jpeg" rel="prettyPhoto[pp_gal]"
               title="Google.com opened at 100%">
                <div class="Picture">
                    <div class="TextPicture">รักษาการ</div>
                </div>
            </a>
            <a href="images/G_reserch/Image.jpeg" rel="prettyPhoto[pp_gal]"
               title="Google.com opened at 100%">
                <div class="PictureII">
                    <div class="TextPicture">รักษาการ</div>
                </div>
            </a>
            <a href="images/G_reserch/Image.jpeg" rel="prettyPhoto[pp_gal]"
               title="Google.com opened at 100%">
            </a>
        </div>
        <div class="CaptionNews">
            <div class="PictureNews">
            </div>

            <div class="other">
                <div class="Pic_other" ng-repeat="other in others | limitTo: 4"></div>
                </a>
            </div>
        </div>
    </div>
    <div class="buttonleft_small"></div>
    <div class="buttonright_small"></div>

    <div class="select">
        <div class="block_select">
            <div class="label_select"
                 ng-click="readmoreClick(reserch.parent_id)"
                 ng-style="{'margin-top': reserchs.length-$index}"
                 ng-repeat="reserch in reserchs | limitTo: 5">
                {{reserch.category_name}}
            </div>
        </div>
        <div class="line">
            <div class="Textline">หมวดหมู่การวิจัย</div>
        </div>
        <div class="buttonleft"></div>
        <div class="buttonright"></div>
        <div class="categoryBack" ng-click="backClick()"></div>
        <div class="groups">
            <div class="on"></div>
            <div class="grps">หมวดหมู่ย่อยกรองทิพย์</div>
            <div class="subtype"
                 ng-repeat="subtype in subtypes | limitTo: 10">
            </div>
            <div class="down"></div>
        </div>
    </div>
    <div ng-app="reserch"
         ng-controller="ReserchListCtl">
    </div>
</div>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        $("a[rel^='prettyPhoto']").prettyPhoto();


        $('.mass').click(function () {
            alert("มวลบุหรี่");
        });


    });

</script>