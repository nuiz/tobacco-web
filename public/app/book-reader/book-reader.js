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

    $http.get('http://localhost/tobacco/content/' + getParameterByName('content_id')).success(function (data) {
        $scope.book = data;
        fetchBook();
    });

    function fetchBook(){
        PDFJS.workerSrc = 'pdfjs/src/worker_loader.js';

        var currPage = 1;
        var numPages = 0;
        var thePDF = null;

        $scope.pages = [];

        PDFJS.getDocument($scope.book.book_url).then(function(pdf) {

            //Set PDFJS global object (so we can easily access in our page functions
            thePDF = pdf;

            //How many pages it has
            numPages = pdf.numPages;

            //Start with first page
            pdf.getPage( 1 ).then( handlePages );
        });



        function handlePages(page)
        {
            //This gives us the page's dimensions at full scale
            var viewport = page.getViewport( 0.7 );

            //We'll create a canvas for each page to draw it on
            var canvas = document.createElement( "canvas" );
            canvas.style.display = "block";
            var context = canvas.getContext('2d');
            //canvas.height = viewport.height;
            //canvas.width = viewport.width;

            canvas.height = 671;
            canvas.width = 506;

            //Draw it on the canvas
            page.render({canvasContext: context, viewport: viewport});

            //Add it to the web page
            //document.body.appendChild( canvas );
            var blob = dataUrlToBlob(canvas.toDataURL());
            $scope.pages.push({
                canvas: canvas
                //blob: blob,
                //url: urlCreator.createObjectURL(blob),
                //data_url: canvas.toDataURL()
            });

            //Move to next page
            currPage++;
            if ( thePDF !== null && currPage <= numPages )
            {
                thePDF.getPage( currPage ).then( handlePages );
            }
            else {
                $scope.$apply();

                $scope.pages.forEach(function(item, index){
                    $('.bookpage[bookpage="'+index+'"]').append(item.canvas);
                });

                $.loadBook();
            }
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