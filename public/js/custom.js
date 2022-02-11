$('#pwd_visibility').on('click',function(e){
        var target = e.currentTarget
        $(target).hasClass('show')?hidePassword($(target)):showPassword($(target))
    });
function hidePassword(e){
    e.removeClass('show').addClass('hide')
    e.prev('input').attr('type','password')
    e.children().removeClass('fa fa-eye-slash').addClass('fa fa-eye');
}
function showPassword(e){
    e.removeClass('hide').addClass('show')
    e.prev('input').attr('type','text')
    e.children().removeClass('fa fa-eye').addClass('fa fa-eye-slash');
}

$('#pwd_confirm_visibility').on('click',function(e){
    var target = e.currentTarget
    $(target).hasClass('show')?hidePassword($(target)):showPassword($(target))
});

$.ajax({
    type: "get",
    url: "/asdc_new/userprofile/get-sidebar-data/",
    success: function (response) {
        $('#sidebar-name').text(response.firstname +" " + response.lastname);
        var asset_url = $('#sidebar-img').data('asset-url');
        if(response.photo){
            $('#sidebar-img').attr("src",asset_url+"/storage/app/profile_photos/"+response.photo);
        }       
    },
    error:function (er){
        console.error(er);
    }
});