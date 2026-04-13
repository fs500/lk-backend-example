import './../css/admin.css';
global.$ = global.jQuery = $ = window.$ = window.jQuery;


function initDropbox(selector, options){
    $(selector).UploadImageWidget(options);
}

(function($){

    $(window).on("ajax_uploader.file_loaded", function(event, $input, data){
        $input
            .closest(".ajax-file")
            .find(".ajax-file_link").html(
            $('<img>').attr("src", data.extraData.thumbnail).show()
        );
    });

    $(document).ready(function(){
        initLink();
        initSearch();
    })

    document.addEventListener('eye.collection.item-added', function(e){
        if(typeof e.detail != "undefined" && typeof e.detail.collection != "undefined"){
            /*
            let collection = $(e.detail.collection);
            if(collection.hasClass("sortable-container")){
                if(collection.data('init') !== true){
                    initSorting(collection.find(".form-widget-compound:first>div").first());
                }
                sortItems(collection);
            }
            */
        }
        initLink();
    }.bind(this));

    function initLink(){
        $(".link-type").off("change").on("change",function(){
            let obj = $(this),
                val = obj.val(),
                container = obj.closest(".block-link"),
                headerField = container.find(".type-header-field"),
                fields = container.find(".type-field");
            fields.each(function(){
                let item = $(this);
                if(item.data('type') != val){
                    item.slideUp(200);
                }
                else{
                    item.slideDown(200,function(){
                        let input = item.find('input[type=text]');
                        if(input.length){
                            input.focus();
                        }
                    });
                }
            });
            if(val != ""){
                headerField.slideDown(200);
            }
            else{
                headerField.slideUp(200);
            }
        })
    }

    function initSearch(){
        $(".search-form").on('submit', function(e){
            let obj = $(this),
                inputs = obj.find('input'),
                dropdowns = obj.find('select')
            ;

            inputs.each(function(){
                let i = $(this),
                    val = i.val()
                ;
                if(!val){
                    i.attr('disabled', true)
                }
            });

            dropdowns.each(function(){
                let d = $(this),
                    val = d.find('option:selected').val()
                ;
                if(!val){
                    d.attr('disabled', true)
                }
            });
        });

        $(".search-form").find('select').on('change', function(){
            $(this).closest(".search-form").submit();
        });

        $(".search-table").find(".sort-column").on('click', function(e){
            e.preventDefault();
            let obj = $(this),
                form = $(".search-form"),
                sort = form.find("#sort"),
                order = form.find("#sortOrder")
            ;
            if(obj.data("field")){
                sort.val(obj.data("field"));
                if(obj.data("order") != ""){
                    order.val(obj.data("order") == "desc" ? "asc" : "desc");
                }
                form.submit();
            }
        })
    }
})(window.jQuery);
