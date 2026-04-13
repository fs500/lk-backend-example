(function($){

    $('.action-refresh').on('click', function(e){
        e.preventDefault();
        let obj = $(this),
            url = obj.attr('href'),
            i = obj.find('i'),
            t = obj.find('span'),
            text = t.text()
        ;
        obj.blur();
        if(obj.hasClass('process')){
            return false;
        }
        $.ajax(url, {
            dataType: 'json',
            beforeSend: function(){
                process(obj, i, t);
            },
            success: function(data){
                if(data.success){
                    success(obj, i, t, data);
                }
                else{
                    error(obj, i, t);
                }
                reset(obj, i, t, text);
            },
            error: function(){
                error(obj, i, t);
                reset(obj, i, t, text);
            }
        })
    });

    function process(obj, i, t){
        obj
            .removeClass('btn-secondary')
            .addClass('btn-warning process')
        ;
        i.addClass('fa-spin');
        t.text("Обновляется...");
    }

    function success(obj, i, t, data){
        obj
            .removeClass('btn-warning')
            .addClass('btn-success')
        ;
        i.removeClass('fa-spin fa-refresh').addClass('fa-check');
        t.text("Обновлено");
        if(data.date){
            $(".update-date-field").text(data.date);
        }
    }

    function error(obj, i, t){
        obj
            .removeClass('btn-warning')
            .addClass('btn-danger')
        ;
        i.removeClass('fa-spin fa-refresh').addClass('fa-times');
        t.text("Ошибка");
    }

    function reset(obj, i, t, text){
        setTimeout(function(){
            obj
                .removeClass('process btn-danger btn-success')
                .addClass('btn-secondary')
            ;
            i.removeClass('fa-spin fa-check fa-times').addClass('fa-refresh');
            t.text(text);
        }, 3000);
    }

})(window.jQuery);