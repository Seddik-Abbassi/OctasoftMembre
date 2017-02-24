jQuery(document).ready(function($){

    $('.edit-btn').click(function (e) {
        var id = $(this).attr('data-id');
        var url = $(this).attr('path');
        var data = 'id='+id;

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(data){
                var data = JSON.parse(data);
                $('input[name="fos_user_registration_form[fullname]"]').val(data['fullname']);
                $('input[name="fos_user_registration_form[email]"]').val(data['email']);
                $('input[name="fos_user_registration_form[username]"]').val(data['username']);
                $('input[name="fos_user_registration_form[city]"]').val(data['city']);
                $('select[name="fos_user_registration_form[country]"]').val(data['country']);
                $('input[name="fos_user_registration_form[address]"]').val(data['address']);

                $("<input type='hidden' name='edit' />").insertBefore('#form-user');
                return false;
            }
        });
    });

    $('.delete-btn').click(function (e) {
        var id = $(this).attr('data-id');
        var url = $(this).attr('path');
        var data = 'id='+id;

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(data){
                var data = JSON.parse(data);
                var id = data['id'];
                console.log(data);
                $("tr#user-"+id).hide();
            }
        });
    });

    $("span.glyphicon-trash").click(function(){
        $(".alert-info").hide();
    });

    $('#users-list').dataTable();

});