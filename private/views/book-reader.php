<!doctype html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">

    <!-- viewport -->
    <meta content="width=device-width,initial-scale=1" name="viewport">

    <!-- title -->
    <title>Book-Reader</title>

    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/angularjs/angular.min.js"></script>

    <script src="pdfjs/src/shared/util.js"></script>
    <script src="pdfjs/src/display/api.js"></script>
    <script src="pdfjs/src/display/metadata.js"></script>
    <script src="pdfjs/src/display/canvas.js"></script>
    <script src="pdfjs/src/display/webgl.js"></script>
    <script src="pdfjs/src/display/pattern_helper.js"></script>
    <script src="pdfjs/src/display/font_loader.js"></script>
    <script src="pdfjs/src/display/annotation_helper.js"></script>

    <script src="public/app/config.js"></script>
    <script>
    // window.config = {
    //     nfc_auth_ip: "http://<?php echo $_SERVER["HTTP_HOST"];?>:5000",
    //     api_url: "http://<?php echo $_SERVER["HTTP_HOST"];?>/tobacco"
    // };
    </script>
    <script>
    window.config = {
        nfc_auth_ip: "http://58.137.91.19:5000",
        api_url: "http://58.137.91.19/tobacco"
    };
    </script>

    <link rel="stylesheet" href="public/app/book-reader/book-reader.css"/>
    <script src="public/app/book-reader/book-reader.js"></script>

    <!-- add css and js for flipbook -->
    <link type="text/css" href="book_reader/css/style.css" rel="stylesheet">
    <link type="text/css" href="book_reader/css/page-styles.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Play:400,700">
    <!--<script src="bower_components/jquery/dist/jquery.min.js"></script>-->
    <script src="book_reader/js/turn.js"></script>
    <script src="book_reader/js/jquery.fullscreen.js"></script>
    <script src="book_reader/js/jquery.address-1.6.min.js"></script>
    <script src="book_reader/js/wait.js"></script>
    <script src="book_reader/js/onload.js"></script>


    <link rel="stylesheet" href="public/assert/font/font.css"/>
    <!-- style css  -->
    <style>
        html,body {
            margin: 0;
            padding: 0;
            overflow:auto !important;
            font-family: THSarabun;
        }

        #fb5 .fb5-bcg-book {
            background-image: url(public/images/home/bg2.jpg);
        }
    </style>

</head>

<body ng-app="book-reader" ng-controller="ReaderCtl">

<!-- BEGIN FLIPBOOK STRUCTURE -->
<div id="fb5-ajax">

    <!-- BEGIN HTML BOOK -->
    <div data-current="book5" class="fb5" id="fb5">

        <!-- PRELOADER -->
        <div class="fb5-preloader">
            <div id="wBall_1" class="wBall">
                <div class="wInnerBall">
                </div>
            </div>
            <div id="wBall_2" class="wBall">
                <div class="wInnerBall">
                </div>
            </div>
            <div id="wBall_3" class="wBall">
                <div class="wInnerBall">
                </div>
            </div>
            <div id="wBall_4" class="wBall">
                <div class="wInnerBall">
                </div>
            </div>
            <div id="wBall_5" class="wBall">
                <div class="wInnerBall">
                </div>
            </div>
        </div>

        <!-- BACK BUTTON -->
        <!--        <a href="#" id="fb5-button-back">BACK</a>-->

        <!-- BACKGROUND FOR BOOK -->
        <div class="fb5-bcg-book"></div>

        <!-- BEGIN CONTAINER BOOK -->
        <div id="fb5-container-book">

            <!-- BEGIN deep linking -->
            <section id="fb5-deeplinking">
                <ul>
                    <li data-address="page1" data-page="1"></li>

                    <li
                        ng-repeat="item in pages"
                        data-page="{{$index+2}}"
                        data-address="{{$index+2}}"
                        </li>

<!--                    <li data-address="page2-page3" data-page="2"></li>-->
<!--                    <li data-address="page2-page3" data-page="3"></li>-->
<!--                    <li data-address="page4-5" data-page="4"></li>-->
<!--                    <li data-address="page4-5" data-page="5"></li>-->
<!--                    <li data-address="page6-page7" data-page="6"></li>-->
<!--                    <li data-address="page6-page7" data-page="7"></li>-->
<!--                    <li data-address="page8-page9" data-page="8"></li>-->
<!--                    <li data-address="page8-page9" data-page="9"></li>-->
<!--                    <li data-address="10-11" data-page="10"></li>-->
<!--                    <li data-address="10-11" data-page="11"></li>-->
<!--                    <li data-address="end" data-page="12"></li>-->
                </ul>
            </section>
            <!-- END deep linking -->

            <!-- BEGIN ABOUT -->
            <section id="fb5-about">
                <div style="padding: 10px 30px; background: rgba(0, 0, 0, 0.258824); height: 100%;">
                    <h3>ชื่อหนังสือ</h3>
                   <p>{{book.content_name}}</p>
                   <h3>คำอธิบาย</h3>
                   <p>{{book.content_description}}</p>
                    <h3>ชื่อผู้แต่ง</h3>
                   <p>{{book.book_author}}</p>
                    <h3>วันที่ตีพิมพ์</h3>
                   <p>{{dateThai(book.book_date)}}</p>
                    <h3>วันที่เผยแพร่</h3>
                   <p>{{dateThai(book.created_at, true)}}</p>
                </div>
            </section>
            <!-- END ABOUT -->
<style>
#fb5 #fb5-about p {
    font-size: 1.375em;
}
</style>

            <!-- BEGIN BOOK -->
            <div id="fb5-book">


                <!-- BEGIN PAGE 1-->
                <div data-background-image="{{book.book_cover_url}}" class="">

                    <!-- container page book -->
                    <div class="fb5-cont-page-book">

                        <!-- description for page from  -->
                        <div class="fb5-page-book">

                        </div>

                        <!-- number page and title for page -->
                        <div class="fb5-meta">
                            <span class="fb5-num">1</span>
                            <!-- <span class="fb5-description">Collection 2014</span>-->
                        </div>

                    </div> <!-- end container page book -->

                </div>
                <!-- END PAGE 1 >

                <!-- BEGIN REPEAT PAGE-->
                <div
                    ng-repeat="item in pages"
                    data-background-image=""
                    class="">

                    <!-- container page book -->
                    <div class="fb5-cont-page-book">

                        <!-- description for page from -->
                        <div class="fb5-page-book" ng-class="'bookpage'" bookpage="{{$index}}">

                        </div>

                        <!-- number page and title for page -->
                        <div class="fb5-meta">
                            <span class="fb5-num">{{$index+1}}</span>
                        </div>


                    </div> <!-- end container page book -->

                </div>
                <!-- END REPEAT PAGE -->

            </div>
            <!-- END BOOK -->


            <!-- arrows -->
            <a class="fb5-nav-arrow prev"></a>
            <a class="fb5-nav-arrow next"></a>


        </div>
        <!-- END CONTAINER BOOK -->

        <!-- BEGIN FOOTER -->
        <div id="fb5-footer">

            <div class="fb5-bcg-tools"></div>

            <a id="fb5-logo" target="_blank" href="">
                <!--                <img alt="" src="img/logo.png">-->
            </a>

            <div class="fb5-menu" id="fb5-center">
                <ul>

                    <?php if(!isset($_COOKIE["kiosk_id"])){ ?>
                    <!-- icon download -->
                    <li>
                        <a title="DOWNLOAD" class="fb5-download" href="{{book.book_url}}" download=""></a>
                    </li>
                    <?php }?>

                    <!-- icon_zoom_in -->
                    <li>
                        <a title="ZOOM IN" class="fb5-zoom-in"></a>
                    </li>

                    <!-- icon_zoom_out -->

                    <li>
                        <a title="ZOOM OUT " class="fb5-zoom-out"></a>
                    </li>

                    <!-- icon_zoom_auto -->
                    <li>
                        <a title="ZOOM AUTO " class="fb5-zoom-auto"></a>
                    </li>

                    <!-- icon_zoom_original -->
                    <li>
                        <a title="ZOOM ORIGINAL (SCALE 1:1)" class="fb5-zoom-original"></a>
                    </li>


                    <!-- icon_allpages -->
<!--                    <li>-->
<!--                        <a title="SHOW ALL PAGES " class="fb5-show-all"></a>-->
<!--                    </li>-->


                    <!-- icon_home -->
                    <li>
                        <a title="SHOW HOME PAGE " class="fb5-home" href="<?php echo $_SERVER['HTTP_REFERER'];?>"></a>
                    </li>

                </ul>
            </div>

            <div class="fb5-menu" id="fb5-right">
                <ul>
                    <!-- icon page manager -->
                    <li class="fb5-goto">
                        <label for="fb5-page-number" id="fb5-label-page-number">PAGE</label>
                        <input type="text" id="fb5-page-number">
                        <button type="button">GO</button>
                    </li>

                    <!-- icon contact form -->
                    <!--                    <li>-->
                    <!--                        <a title="SEND MESSAGE" class="contact"></a>-->
                    <!--                    </li>-->

                    <!-- icon fullscreen -->
                    <li>
                        <a title="FULL / NORMAL SCREEN" class="fb5-fullscreen"></a>
                    </li>

                </ul>
            </div>



        </div>
        <!-- END FOOTER -->

        <!-- BEGIN CONTACT FORM -->
        <div id="fb5-contact" class="fb5-overlay">

            <form>
                <a class="fb5-close">X</a>

                <fieldset>
                    <h3>CONTACT</h3>

                    <p>
                        <input type="text" class="req" id="fb5-form-name" value="name...">
                    </p>

                    <p>
                        <input type="text" class="req" id="fb5-form-email" value="email...">
                    </p>

                    <p>
                        <textarea class="req" id="fb5-form-message">message...</textarea>
                    </p>

                    <p>
                        <button type="submit">SEND MESSAGE</button>
                    </p>
                </fieldset>

                <fieldset class="fb5-thanks">
                    <h1>Thanks for your email</h1>
                    <p>Lorem ipsum dolor sit amet, vel ad sint fugit, velit nostro pertinax ex qui, no ceteros civibus explicari est. Eleifend electram ea mea, omittam reprehendunt nam at. Putant argumentum cum ex. At soluta principes dissentias nam, elit voluptatum vel ex.</p>		</fieldset>
            </form>

        </div>
        <!-- END CONTACT FORM -->

        <!-- BEGIN ALL PAGES -->
        <div id="fb5-all-pages" class="fb5-overlay">

            <section class="fb5-container-pages">

                <div id="fb5-menu-holder">

                    <ul id="fb5-slider">
<!--
                        <li class="1">
                            <img alt="" data-src="pages/thumbs/1_.jpg">
                        </li>

                        <li class="2">
                            <img alt="" data-src="pages/thumbs/2_.jpg">
                        </li>

                        <li class="3">
                            <img alt="" data-src="pages/thumbs/3_.jpg">
                        </li>

                        <li class="4">
                            <img alt="" data-src="pages/thumbs/4_5_.jpg">
                        </li>

                        <li class="6">
                            <img alt="" data-src="pages/thumbs/6_.jpg">
                        </li>

                        <li class="7">
                            <img alt="" data-src="pages/thumbs/7_.jpg">
                        </li>

                        <li class="8">
                            <img alt="" data-src="pages/thumbs/8_.jpg">
                        </li>

                        <li class="9">
                            <img alt="" data-src="pages/thumbs/9_.jpg">
                        </li>

                        <li class="10">
                            <img alt="" data-src="pages/thumbs/10_11_.jpg">
                        </li>

                        <li class="12">
                            <img alt="" data-src="pages/thumbs/12_.jpg">
                        </li> -->

                    </ul>

                </div>

            </section>

        </div>
        <!-- END ALL PAGES -->

    </div>
    <!-- END HTML BOOK -->

</div>
<!-- END FLIPBOOK STRUCTURE -->

<!-- CONFIGURATION FLIPBOOK -->
<script>
    jQuery('#fb5').data('config',
        {
            "page_width":"550",
            "page_height":"715",
            "email_form":"office@somedomain.com",
            "zoom_double_click":"1",
            "zoom_step":"0.06",
            "double_click_enabled":"true",
            "tooltip_visible":"true",
            "toolbar_visible":"true",
            "gotopage_width":"30",
            "deeplinking_enabled":"true",
            "rtl":"false",
            'full_area':'true',
            'lazy_loading_thumbs':'false',
            'lazy_loading_pages':'false'
        });
</script>




</body>
</html>
