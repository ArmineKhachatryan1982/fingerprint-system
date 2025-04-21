$(function () {
    $('#selectedRole').on("change", function () {
        console.log($('#selectedRole'))
        var selectedValues = $(this).val();
        console.log()
            // if ($.inArray('client_admin', selectedValues) !== -1 || $.inArray('client_admin_rfID', selectedValues) !== -1) {
        if( $(this).val()=="client_admin" || $(this).val()=="client_admin_rfID" ){
            console.log("inner")
            console.log($(this).val())

         

            $.ajax({
                url: '/client-component',
                type: 'POST',
                data: {
                    // _token: '{{ csrf_token() }}',
                    // name:userName,
                    // email:userEmail,
                    // password:userPassword,
                    // confirmPassword:userConfirmPassword,
                    // userRole:userRole
                    // Любые данные, которые нужно передать
                },
                success: function(response) {
                    console.log(response.html)

                    $('#componentContainer').html(response.html);
                    $('#loginBtn').css({
                        'display': 'none'
                    });
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });


        }else{
            $('#componentContainer').html('');
        }


    })

})
