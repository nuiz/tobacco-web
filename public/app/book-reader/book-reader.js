/**
 * Created by laddamart on 3/11/15 AD.
 */
"use strict";
var ebookapp = angular.module('book-reader', []);
ebookapp.controller('ReaderCtl', ['$scope', '$http', function ($scope, $http) {

    var urlCreator = window.URL || window.webkitURL;

    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    function dataUrlToBlob(dataURL) {
        var BASE64_MARKER = ';base64,';
        if (dataURL.indexOf(BASE64_MARKER) == -1) {
            var parts = dataURL.split(',');
            var contentType = parts[0].split(':')[1];
            var raw = decodeURIComponent(parts[1]);

            return new Blob([raw], {type: contentType});
        }

        var parts = dataURL.split(BASE64_MARKER);
        var contentType = parts[0].split(':')[1];
        var raw = window.atob(parts[1]);
        var rawLength = raw.length;

        var uInt8Array = new Uint8Array(rawLength);

        for (var i = 0; i < rawLength; ++i) {
            uInt8Array[i] = raw.charCodeAt(i);
        }

        return new Blob([uInt8Array], {type: contentType});
    }


    $scope.book = {};
    $scope.pages = [];

    $http.get(window.config.api_url+'/content/' + getParameterByName('content_id')).success(function (data) {
        $scope.book = data;
        fetchBook();
    });

    (function($scope){
        var thMonth = [
            "มกราคม",
            "กุมภาพันธ์",
            "มีนาคม",
            "เมษายน",
            "พฤษภาคม",
            "มิถุนายน",
            "กรกฎาคม",
            "สิงหาคม",
            "กันยายน",
            "ตุลาคม",
            "พฤจิกายน",
            "ธันวาคม"
        ];

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }

        $scope.dateThai = function(dateInput, timeStamp){
            if(!timeStamp){
                var dateObject = new Date(dateInput);
            }
            else {
                var dateObject = new Date();
                dateObject.setTime(parseInt(dateInput) * 1000);
            }
            var date = "วันที่ "+dateObject.getDate()+" "+thMonth[dateObject.getMonth()]+" "+(dateObject.getFullYear()+543);
            var time = checkTime(dateObject.getHours())+":"+checkTime(dateObject.getMinutes())+" น.";

            //return date + " เวลา " + time;
            return date;
        };
    })($scope);

    function fetchBook(){
        PDFJS.workerSrc = 'pdfjs/src/worker_loader.js';

        var currPage = 1;
        var numPages = 0;
        var thePDF = null;

        $scope.pages = [];
        var successNumPage = 0;

        PDFJS.getDocument($scope.book.book_url).then(function(pdf) {

            //Set PDFJS global object (so we can easily access in our page functions
            thePDF = pdf;

            //How many pages it has
            numPages = pdf.numPages;

            //Start with first page
            //pdf.getPage( 1 ).then( handlePages );
            for(var num = 1; num <= numPages; num++){
                //$scope.pages.push(null);
                pdf.getPage(num).then(handlePage);
            }
        });



        function handlePage(page)
        {
            $scope.pages[page.pageIndex] = {
                page: page
            };

            successNumPage++;
            // if ( thePDF !== null && currPage <= numPages )

            if ( successNumPage >= numPages )
            {
                $scope.$apply();
                $.loadBook();
                cbCompletePages();
            }
        }

        function cbCompletePages(){
            $scope.pages.forEach(function(item, index){
                var viewport = item.page.getViewport(1.5);

                //We'll create a canvas for each page to draw it on
                var canvas = document.createElement( "canvas" );
                canvas.style.display = "block";
                var context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                //Draw it on the canvas
                item.page.render({canvasContext: context, viewport: viewport});

                // var blob = dataUrlToBlob(canvas.toDataURL());

                $('.bookpage[bookpage="'+index+'"]').append(canvas);
                $(canvas).css({'width': '100%'});
            });
        }

        //PDFJS.getDocument($scope.book.book_url).then(function(pdf) {
        //    // Using promise to fetch the page
        //
        //    var length = pdf.getLength();
        //    console.log(length);
        //    pdf.getPage(1).then(function(page) {
        //        var scale = 1.5;
        //        var viewport = page.getViewport(scale);
        //
        //        //
        //        // Prepare canvas using PDF page dimensions
        //        //
        //        var $canvas = $('<canvas></canvas>').appendTo('#canvas-wrap');
        //        var canvas = $canvas.get(0);
        //        var context = canvas.getContext('2d');
        //        canvas.height = viewport.height;
        //        canvas.width = viewport.width;
        //
        //        //
        //        // Render PDF page into canvas context
        //        //
        //        var renderContext = {
        //            canvasContext: context,
        //            viewport: viewport
        //        };
        //        page.render(renderContext);
        //    });
        //});
    }
}]);
