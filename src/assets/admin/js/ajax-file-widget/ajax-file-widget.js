import './ajax-file-widget.css';
//var Dropzone = require('dropzone');
import Dropzone from "dropzone";

(function($){

    let UploadFileWidget = function(o){
        let container,
            dropBoxZoneSelector = ".dropbox-file-zone",
            dropBoxZoneObj,
            fileQueue = [];

        function init(o){
            o = $.extend({
                container: container,
                dropBoxZoneSelector: dropBoxZoneSelector
            }, o);
            container = $(o.container);
            dropBoxZoneObj = container.find(o.dropBoxZoneSelector);
            initDropzone();
        }

        function initDropzone() {
            let dz = new Dropzone(dropBoxZoneObj.get(0),{
                url: "http://fake.url",
                autoQueue: false,
                uploadMultiple: false,
                maxFiles: 1
            });

            dz.on('addedfile', function(file){
                fileQueue.push(file);
                addFile();
                dz.removeFile(file);
                container.trigger('file-added');
            });
        }

        function addFile(){
            if(fileQueue.length > 0){
                let file = fileQueue.pop(),
                    obj = $(container).closest('.ajax-file').find("input[type=file]");
                if(obj.length){
                    obj.ajaxUpload({file});
                }
            }
        }
        init(o);
    }

    $.fn.UploadFileWidget = function(o){
        return this.each(function(){
            if(typeof this.isUploadInitialized == 'undefined'){
                this.isUploadInitialized = true;
                new UploadFileWidget(
                    $.extend(o, {
                        container: this
                    })
                );
            }
        });
    }
})(window.jQuery);