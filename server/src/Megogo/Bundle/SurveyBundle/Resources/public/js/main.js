

$(document).ready(function(){

    var untilDate = new Date();
    var setCounterCookie = function(untilDate){
        untilDate = new Date()
        untilDate.setSeconds(untilDate.getSeconds() + 360);
        $.cookie('counter', untilDate, { path: '/' });
        return untilDate;
    }
    if ($.cookie('counter')){
        untilDate = new Date($.cookie('counter'));
        if (untilDate < (new Date())){
            untilDate = setCounterCookie();
        }
    }else{
        untilDate = setCounterCookie();
    }
    $('#counter').countdown({
        format: 'S',
        until: untilDate,
        onTick: function(){

            if ($.cookie('counterPause')){
                $('#counter').countdown('pause');

            }

        },
        tickInterval:1,
        onExpiry: function(){
            alert('Time expired. All unsaved data would be lost. Page would be reloaded.' );
            $.removeCookie('counter', { path: '/' });
            $.removeCookie('counterPause', { path: '/' });
            window.location.reload();

        }

    });
    var ErrorManager = {
        container: $('#ErrorContainer'),
        setErrors : function (errors){

            ErrorManager.clearErrors();
            var data = '';

            $(errors).each(function(index,item){
                data += '<div class="alert alert-error">'+item+'</div>';
            })
            ErrorManager.container.html(data);
        },
        clearErrors: function(){
            ErrorManager.container.html('');
        }

    }

    var postForm = function( $form, callback ){
        var values = {};
        $.each( $form.serializeArray(), function(i, field) {
            values[field.name] = field.value;
        });
        $.ajax({
            type        : $form.attr( 'method' ),
            url         : $form.attr( 'action' ),
            data        : values,
            success     : function(data) {
                if (data['status'] == 'error'){
                    callback( data.errors );
                }else{
                    window.location.replace(data['redirect']);
                }
            }
        });
    }

    $( 'form' ).submit( function( e ){
        e.preventDefault();
        postForm( $(this), ErrorManager.setErrors);
        return false;
    });

});
