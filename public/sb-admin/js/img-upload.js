
"use strict";

// https://github.com/fengyuanchen/cropperjs/blob/main/README.md

var AjaxFileUploader = function( target, loading ) {

    this._file = null;
    var self = this;

    this.uploadFile = function( uploadUrl, file ) {

        var xhr = new XMLHttpRequest();

        //xhr.onreadystatechange = function() {
        //    console.log( xhr.readyState );
        //}

        xhr.onprogress = function (e) {
            $('#' + loading).removeClass('d-none');
        };

        xhr.onload = function (e) {

            $('#' + loading).addClass('d-none');
            $('#modal-crop').modal();

            var jsonResponse = JSON.parse(xhr.responseText);

            if( jsonResponse.success == true )
                loadCropper( jsonResponse.message )
            else
                console.log('error')
        };

        xhr.onerror = function (e) {
            console.log( 'onerror', e );
        };

        xhr.open("post", uploadUrl, true);

        xhr.setRequestHeader( "X-File-Name"  , file.name );
        xhr.setRequestHeader( "X-File-Size"  , file.size );
        xhr.setRequestHeader( "X-File-Type"  , file.type );

        var formData = new FormData();
        formData.append("file", file);

        xhr.send(formData);
    };
};

AjaxFileUploader.IsAsyncFileUploadSupported = function () {
    return typeof (new XMLHttpRequest().upload) !== 'undefined';
}


document.addEventListener("DOMContentLoaded", function(event) {

    document.querySelector(".img-upload").addEventListener( 'change', function( e ) {

        if( this.files.length > 0 )
        {
            var target           = this.getAttribute('data-target');
            var loading          = this.getAttribute('data-loading');
            var url              = this.getAttribute('data-url');
            var ajaxFileUploader = new AjaxFileUploader( target, loading );

            if ( AjaxFileUploader.IsAsyncFileUploadSupported )
            {
                ajaxFileUploader.uploadFile( url, this.files[0]);
            }
            else
            {
                console.log( "Can't upload files" );
            }

        } // if( this.files[0] )

    }, false );


});


function loadCropper( data )
{
    $('#thumbnail').attr("src", data.path + data.file);
    $('#file').attr("src", data.file);

    var Cropper   = window.Cropper;
    var container = document.querySelector('.img-container');
    var image = container.getElementsByTagName('img').item(0);

    var cropper = new Cropper( image, {
        aspectRatio  : 2.0756756756757,
        zoomable     : false,
        rotatable    : false,
        scalable     : false,
        viewMode     : 1,
        crop         : function(e) {
            $('#x').val( e.x );
            $('#y').val( e.y );
            $('#w').val( e.width );
            $('#h').val( e.height );
        }
    });
}
