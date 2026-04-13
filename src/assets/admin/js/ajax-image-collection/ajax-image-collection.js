import './ajax-image-collection.css';
//var Dropzone = require('dropzone');
import Dropzone from "dropzone";
require('webpack-jquery-ui/sortable');

(function($){

    let UploadImageWidget = function(o){
        let container,
            sortingSelector,
            sortingHandlerSelector = false,
            sortFieldSelector = ".sort-field",
            dropBoxZoneSelector = ".dropbox-zone",
            addButtonSelector = ".field-collection-add-button",
            groupSelector = ".ajax-file",
            sortingObj,
            enableSorting = true,
            dropBoxZoneObj,
            addButtonObj,
            addEvent = "eye.collection.item-added",
            removeEvent = "eye.collection.item-removed",
            fileQueue = [];

        function init(o){
            o = $.extend({
                container: container,
                sortingSelector: sortingSelector,
                dropBoxZoneSelector: dropBoxZoneSelector,
                addButtonSelector: addButtonSelector,
            }, o);
            container = $(o.container);
            sortingObj = container.find(o.sortingSelector);
            dropBoxZoneObj = container.find(o.dropBoxZoneSelector);
            addButtonObj = container.find(o.addButtonSelector);
            sortingSelector = o.sortingSelector;
            sortingHandlerSelector = o.sortingHandlerSelector;
            if(enableSorting && sortingSelector){
                initSorting();
            }
            initDropzone();
        }

        function initDropzone() {
            let dz = new Dropzone(dropBoxZoneObj.get(0),{
                url: "http://fake.url",
                autoQueue: false
            });

            dz.on('addedfile', function(file){
                fileQueue.push(file);
                addButtonObj.trigger('click');
                dz.removeFile(file);
            });
        }

        function initSorting(){
            $(sortingSelector).sortable({
                stop: function(){
                    sortItems();
                }
            })
        }

        function sortItems(){
            container.find(sortFieldSelector).each(function(index){
                if(sortingHandlerSelector){
                    $(sortingSelector).find(sortingHandlerSelector).show();
                    $(sortingSelector).sortable("option", "handle", sortingHandlerSelector);
                }
                $(this).val(index);
            })
        }

        if(addEvent){
            document.addEventListener(addEvent,onFileAdded)
        }

        if(removeEvent){
            document.addEventListener(removeEvent,function(){
                sortItems();
            })
        }

        function onFileAdded(event){
            if(fileQueue.length > 0){
                let file = fileQueue.pop(),
                    obj = event.detail.newItem;
                if(obj.find("input[type=file]").first().length){
                    obj.find("input[type=file]").first().ajaxUpload({file});
                }
            }
            sortItems();
        }
        init(o);
    }

    $.fn.UploadImageWidget = function(o){
        return this.each(function(){
            if(typeof this.isUploadInitialized == 'undefined'){
                this.isUploadInitialized = true;
                new UploadImageWidget(
                    $.extend(o, {
                        container: this
                    })
                );
            }
        });
    }
})(window.jQuery);
