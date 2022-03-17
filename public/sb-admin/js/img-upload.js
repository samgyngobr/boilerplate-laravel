
"use strict";

var AjaxFileUploader = function( target, loading ) {

    this._file = null;
    var self = this;

    this.uploadFile = function( uploadUrl, file ) {

        var xhr = new XMLHttpRequest();

        xhr.onprogress = function (e) {
            console.log( 'onprogress', e );
        };

        xhr.onload = function (e) {
            console.log( 'onload', e );
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

