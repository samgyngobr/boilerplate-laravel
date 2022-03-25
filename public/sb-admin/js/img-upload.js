
"use strict";

// https://github.com/fengyuanchen/cropperjs/blob/main/README.md

var _cropper;
var _data;
var _width;
var _height;
var _target;

var AjaxFileUploader = function( target, loading, width, height ) {

    this._file = null;
    var self = this;

    this.uploadFile = function( uploadUrl, file ) {

        var xhr = new XMLHttpRequest();

        //xhr.onreadystatechange = function() {
        //    console.log( xhr.readyState );
        //}

        xhr.onprogress = function (e) {
            $(loading).removeClass('d-none');
        };

        xhr.onload = function (e) {

            $(loading).addClass('d-none');

            var jsonResponse = JSON.parse( xhr.responseText );

            if( jsonResponse.success == true )
            {
                _data   = jsonResponse.message;
                _width  = width;
                _height = height;
                _target = target;

                $('#modal-crop').modal();
            }
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

    var qs = document.querySelector(".img-upload") !== null ;

    if( qs )
    {
        document.querySelector(".img-upload").addEventListener( 'change', function( e ) {

            if( this.files.length > 0 )
            {
                var target  = this.getAttribute('data-target');
                var loading = this.getAttribute('data-loading');
                var url     = this.getAttribute('data-url');
                var width   = this.getAttribute('data-width');
                var height  = this.getAttribute('data-height');

                var ajaxFileUploader = new AjaxFileUploader( target, loading, width, height );

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
    }
});



$('#modal-crop').on('shown.bs.modal', function () {

    $('#thumbnail').attr("src", _data.path + _data.file);

    var Cropper   = window.Cropper;
    var container = document.querySelector('.img-container');
    var image     = container.getElementsByTagName('img').item(0);

    _cropper = new Cropper( image, {
        aspectRatio  : _width / _height,
        zoomable     : false,
        rotatable    : false,
        scalable     : false,
        viewMode     : 1,
        crop         : function(e) {

            $( _target ).val( JSON.stringify({
                'file'  : _data.file,
                'crop'  : e.detail,
                'width' : _width,
                'height': _height,
            }) );

        }
    });

}).on('hidden.bs.modal', function () {

    if( _cropper )
        _cropper.destroy();
});
