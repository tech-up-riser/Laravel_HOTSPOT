<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('form[id="business_form"]').validate({
            rules: {
                business_name: 'required',
                business_fullname: 'required',
                owner_name: 'required',
                business_email: {
                    required: true,
                    email: true,
                },
                address1: 'required',
                address2: 'required',
                city: 'required',
                business_country: 'required',
                postcode: 'required',


            },
            messages: {
                business_name: 'This field is required',
                business_fullname: 'This field is required',
                busineowner_namess_fullname: 'This field is required',
                business_email: 'Enter a valid email',
                address1: 'This field is required',
                address2: 'This field is required',
                city: 'This field is required',
                business_country: 'This field is required',
                postcode: 'This field is required',
            },
            submitHandler: function(form) {
            }
        });

        $('form[id="business_admin_form"]').validate({
            rules: {
                name: 'required',
                first_name: 'required',
                last_name: 'required',
                email: {
                    required: true,
                    email: true,
                },
                gender: 'required',
                city: 'required',
                country: 'required',
                year: 'required',
                password: {
                    required: true,
                    minlength: 5
                },
                password_confirmation: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                }


            },
            messages: {
                name: 'This field is required',
                first_name: 'This field is required',
                last_name: 'This field is required',
                email: 'Enter a valid email',
                gender: 'This field is required',
                city: 'This field is required',
                year: 'This field is required',
                password: {
                    required: 'Password field is required',
                    minlength: 'Must above 5 letters',
                },
                password_confirmation: {
                    required: 'Password Confirmation field is required',
                    minlength: 'Must above 5 letters',
                    equalTo: 'Password not match'
                }
            },
            submitHandler: function(form) {
            }
        });

        var business_id = "{{ isset($business) ? $business->id: 0 }}";
        var business_admin_id = "{{ isset($user) ? $user->id: 0 }}";

        $('#business_submit').on('click', function(e) {
           e.preventDefault();

            if($('#business_form').validate().form()) {
                var myform = document.getElementById("business_form");
                var data = new FormData(myform);
                data.append('country', data.get('business_country'));
                data.append('email', data.get('business_email'));

                if(business_id < 1) {
                    $.ajax({
                        url: '{{ route("admin.business.store") }}',
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST', // For jQuery < 1.9
                        success: function (data) {
                            if(data.success) {
                                business_id = data.business.id;
                                $('#li_business_admin').click();
                            }else {
                                alert(data.msg);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log(error);
                        }

                    });
                }else {
                    <?php
                       $updateRoute = '';
                       if (isset($business)) {
                           $updateRoute = route("admin.business.update", [$business->id]);
                       }
                    ?>

                        $.ajax({
                        url: '{{ $updateRoute }}',
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST', // For jQuery < 1.9
                        success: function (data) {
                            if(data.success) {
                                $('#li_business_admin').click();
                            }else {
                                alert(data.msg);
                            }
                        },
                        error: function (xhr, status, error) {

                        }

                    });
                }
            }
        });


        $('#business_admin_submit').on('click', function(e) {
            e.preventDefault();
            console.log("aafdsafdsafsad===", business_id);
            if(business_id > 0) {
                if($('#business_admin_form').validate().form()) {
                    var myform = document.getElementById("business_admin_form");
                    var data = new FormData(myform);
                    data.append('business_id', business_id);

                    if(business_admin_id < 1) {
                        $.ajax({
                            url: '{{ route("admin.business_admin.store") }}',
                            data: data,
                            cache: false,
                            contentType: false,
                            processData: false,
                            type: 'POST', // For jQuery < 1.9
                            success: function (data) {
                                console.log(data);
                                if(data.success) {
                                    business_admin_id = data.business_admin.id;
                                    $('#li_business_setting').click();
                                }else {
                                    alert(data.msg);
                                }
                            },
                            error: function (xhr, status, error) {
                                console.log(error);
                            }

                        });
                    }else {
                        <?php
                            $updateRoute = '';
                            if (isset($user)) {
                                $updateRoute = route("admin.business_admin.update", [$user->id]);
                            }
                        ?>

                            $.ajax({
                            url: '{{ $updateRoute }}',
                            data: data,
                            cache: false,
                            contentType: false,
                            processData: false,
                            type: 'POST', // For jQuery < 1.9
                            success: function (data) {
                                if(data.success) {
                                    $('#li_business_setting').click();
                                }else {
                                    alert(data.msg);
                                }
                            },
                            error: function (xhr, status, error) {

                            }

                        });
                    }
                }
            }else {
                alert('Please Insert Business First !');
            }
        });


        //Admin Setting for Business
        $('#on_button').click(function(){
            if(business_id > 0) {
                <?php
                    $updateRoute = route("admin.setting.update");
                ?>

                var formData = new FormData();
                formData.append("_token", '{{ csrf_token() }}');
                formData.append("upload_promotion", 'on');
                formData.append("business_id", business_id);

                $.ajax({
                    url: '{{ $updateRoute }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST', // For jQuery < 1.9
                    success: function (data) {
                        if (data.success) {
                            document.getElementById("on_button").setAttribute("class", "btn locked_active btn-info");
                            document.getElementById("off_button").setAttribute("class", "btn unlocked_inactive btn-default");
                        }
                    },
                    error: function (xhr, status, error) {

                    }
                });
            }else {
                alert("Please Insert Business First !");
            }
        });

        $('#off_button').click(function(){
            if(business_id > 0) {
                <?php
                    $updateRoute = route("admin.setting.update");
                ?>

                var formData = new FormData();
                formData.append("_token", '{{ csrf_token() }}');
                formData.append("upload_promotion", 'off');
                formData.append("business_id", business_id);

                $.ajax({
                    url: '{{ $updateRoute }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST', // For jQuery < 1.9
                    success: function (data) {
                        if (data.success) {
                            document.getElementById("off_button").setAttribute("class", "btn locked_active btn-info");
                            document.getElementById("on_button").setAttribute("class", "btn unlocked_inactive btn-default");
                        }
                    },
                    error: function (xhr, status, error) {

                    }
                });
            }else {
                alert("Please Insert Business First !");
            }
        });

        var redirect_url = "{{ isset($setting) ? $setting->redirect_url : '' }}";
        $('#change_redirect').on('input', function(e) {
            if(e.target.value !== redirect_url) {
                document.getElementById('submit_redirect_div').removeAttribute('hidden');
            }else {
                document.getElementById('submit_redirect_div').setAttribute("hidden", "hidden");
            }
        });

        $('#save_redirect_url').click(function(){
            if(business_id > 0) {
                <?php
                    $updateRoute = route("admin.setting.update");
                ?>

                var formData = new FormData();
                var redirect_url = document.getElementById('change_redirect').value;
                formData.append("_token", '{{ csrf_token() }}');
                formData.append("redirect_url", redirect_url);
                formData.append("business_id", business_id);

                $.ajax({
                    url: '{{ $updateRoute }}',
                    data:  formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST', // For jQuery < 1.9
                    success: function (data) {
                        if(data.success) {
                            document.getElementById('submit_redirect_div').setAttribute("hidden", "hidden");
                        }
                    },
                    error: function (xhr, status, error) {

                    }
                });
            }else {
                alert("Please Insert Business First !");
            }

        });
    });
</script>