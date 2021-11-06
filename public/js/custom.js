$('#pwd_visibility').on('click',function(e){
        var target = e.currentTarget
        $(target).hasClass('show')?hidePassword($(target)):showPassword($(target))
    });
function hidePassword(e){
    e.removeClass('show').addClass('hide')
    e.prev('input').attr('type','password')
    e.children().removeClass('far fa-eye-slash').addClass('far fa-eye');
}
function showPassword(e){
    e.removeClass('hide').addClass('show')
    e.prev('input').attr('type','text')
    e.children().removeClass('far fa-eye').addClass('far fa-eye-slash');
}

$('#pwd_confirm_visibility').on('click',function(e){
        var target = e.currentTarget
        $(target).hasClass('show')?hidePassword($(target)):showPassword($(target))
    });