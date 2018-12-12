<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var business_id = "{{ isset($business) ? $business->id: 0 }}";

        //Login Facebook Setting
        $('#facebook_on_button').click(function(){
            if(business_id > 0) {
                <?php
                    $updateRoute = route("business.admin.business.login_setting", ['bzname' => $bzname]);
                ?>

                var formData = new FormData();
                formData.append("_token", '{{ csrf_token() }}');
                formData.append("facebook", 'on');
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
                            document.getElementById("facebook_on_button").setAttribute("class", "btn locked_active btn-info");
                            document.getElementById("facebook_off_button").setAttribute("class", "btn unlocked_inactive btn-default");
                        }
                    },
                    error: function (xhr, status, error) {

                    }
                });
            }else {
                alert("Please Insert Business First !");
            }
        });

        $('#facebook_off_button').click(function(){
            if(business_id > 0) {
                <?php
                    $updateRoute = route("business.admin.business.login_setting", ['bzname' => $bzname]);
                ?>

                var formData = new FormData();
                formData.append("_token", '{{ csrf_token() }}');
                formData.append("facebook", 'off');
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
                            document.getElementById("facebook_off_button").setAttribute("class", "btn locked_active btn-info");
                            document.getElementById("facebook_on_button").setAttribute("class", "btn unlocked_inactive btn-default");
                        }
                    },
                    error: function (xhr, status, error) {

                    }
                });
            }else {
                alert("Please Insert Business First !");
            }
        });

        //Login Twitter Setting
        $('#twitter_on_button').click(function(){
            if(business_id > 0) {
                <?php
                    $updateRoute = route("business.admin.business.login_setting", ['bzname' => $bzname]);
                ?>

                var formData = new FormData();
                formData.append("_token", '{{ csrf_token() }}');
                formData.append("twitter", 'on');
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
                            document.getElementById("twitter_on_button").setAttribute("class", "btn locked_active btn-info");
                            document.getElementById("twitter_off_button").setAttribute("class", "btn unlocked_inactive btn-default");
                        }
                    },
                    error: function (xhr, status, error) {

                    }
                });
            }else {
                alert("Please Insert Business First !");
            }
        });

        $('#twitter_off_button').click(function(){
            if(business_id > 0) {
                <?php
                    $updateRoute = route("business.admin.business.login_setting", ['bzname' => $bzname]);
                ?>

                var formData = new FormData();
                formData.append("_token", '{{ csrf_token() }}');
                formData.append("twitter", 'off');
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
                            document.getElementById("twitter_off_button").setAttribute("class", "btn locked_active btn-info");
                            document.getElementById("twitter_on_button").setAttribute("class", "btn unlocked_inactive btn-default");
                        }
                    },
                    error: function (xhr, status, error) {

                    }
                });
            }else {
                alert("Please Insert Business First !");
            }
        });

        //Login Instagram Setting
        $('#instagram_on_button').click(function(){
            if(business_id > 0) {
                    <?php
                    $updateRoute = route("business.admin.business.login_setting", ['bzname' => $bzname]);
                    ?>

                var formData = new FormData();
                formData.append("_token", '{{ csrf_token() }}');
                formData.append("instagram", 'on');
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
                            document.getElementById("instagram_on_button").setAttribute("class", "btn locked_active btn-info");
                            document.getElementById("instagram_off_button").setAttribute("class", "btn unlocked_inactive btn-default");
                        }
                    },
                    error: function (xhr, status, error) {

                    }
                });
            }else {
                alert("Please Insert Business First !");
            }
        });

        $('#instagram_off_button').click(function(){
            if(business_id > 0) {
                    <?php
                    $updateRoute = route("business.admin.business.login_setting", ['bzname' => $bzname]);
                    ?>

                var formData = new FormData();
                formData.append("_token", '{{ csrf_token() }}');
                formData.append("instagram", 'off');
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
                            document.getElementById("instagram_off_button").setAttribute("class", "btn locked_active btn-info");
                            document.getElementById("instagram_on_button").setAttribute("class", "btn unlocked_inactive btn-default");
                        }
                    },
                    error: function (xhr, status, error) {

                    }
                });
            }else {
                alert("Please Insert Business First !");
            }
        });

        //Login Linkedin Setting
        $('#linkedin_on_button').click(function(){
            if(business_id > 0) {
                    <?php
                    $updateRoute = route("business.admin.business.login_setting", ['bzname' => $bzname]);
                    ?>

                var formData = new FormData();
                formData.append("_token", '{{ csrf_token() }}');
                formData.append("linkedin", 'on');
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
                            document.getElementById("linkedin_on_button").setAttribute("class", "btn locked_active btn-info");
                            document.getElementById("linkedin_off_button").setAttribute("class", "btn unlocked_inactive btn-default");
                        }
                    },
                    error: function (xhr, status, error) {

                    }
                });
            }else {
                alert("Please Insert Business First !");
            }
        });

        $('#linkedin_off_button').click(function(){
            if(business_id > 0) {
                    <?php
                    $updateRoute = route("business.admin.business.login_setting", ['bzname' => $bzname]);
                    ?>

                var formData = new FormData();
                formData.append("_token", '{{ csrf_token() }}');
                formData.append("linkedin", 'off');
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
                            document.getElementById("linkedin_off_button").setAttribute("class", "btn locked_active btn-info");
                            document.getElementById("linkedin_on_button").setAttribute("class", "btn unlocked_inactive btn-default");
                        }
                    },
                    error: function (xhr, status, error) {

                    }
                });
            }else {
                alert("Please Insert Business First !");
            }
        });

        //Login Wechat Setting
        $('#wechat_on_button').click(function(){
            if(business_id > 0) {
                    <?php
                    $updateRoute = route("business.admin.business.login_setting", ['bzname' => $bzname]);
                    ?>

                var formData = new FormData();
                formData.append("_token", '{{ csrf_token() }}');
                formData.append("wechat", 'on');
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
                            document.getElementById("wechat_on_button").setAttribute("class", "btn locked_active btn-info");
                            document.getElementById("wechat_off_button").setAttribute("class", "btn unlocked_inactive btn-default");
                        }
                    },
                    error: function (xhr, status, error) {

                    }
                });
            }else {
                alert("Please Insert Business First !");
            }
        });

        $('#wechat_off_button').click(function(){
            if(business_id > 0) {
                    <?php
                    $updateRoute = route("business.admin.business.login_setting", ['bzname' => $bzname]);
                    ?>

                var formData = new FormData();
                formData.append("_token", '{{ csrf_token() }}');
                formData.append("wechat", 'off');
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
                            document.getElementById("wechat_off_button").setAttribute("class", "btn locked_active btn-info");
                            document.getElementById("wechat_on_button").setAttribute("class", "btn unlocked_inactive btn-default");
                        }
                    },
                    error: function (xhr, status, error) {

                    }
                });
            }else {
                alert("Please Insert Business First !");
            }
        });

        //Login Vkontakte Setting
        $('#vkontakte_on_button').click(function(){
            if(business_id > 0) {
                    <?php
                    $updateRoute = route("business.admin.business.login_setting", ['bzname' => $bzname]);
                    ?>

                var formData = new FormData();
                formData.append("_token", '{{ csrf_token() }}');
                formData.append("vkontakte", 'on');
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
                            document.getElementById("vkontakte_on_button").setAttribute("class", "btn locked_active btn-info");
                            document.getElementById("vkontakte_off_button").setAttribute("class", "btn unlocked_inactive btn-default");
                        }
                    },
                    error: function (xhr, status, error) {

                    }
                });
            }else {
                alert("Please Insert Business First !");
            }
        });

        $('#vkontakte_off_button').click(function(){
            if(business_id > 0) {
                    <?php
                    $updateRoute = route("business.admin.business.login_setting", ['bzname' => $bzname]);
                    ?>

                var formData = new FormData();
                formData.append("_token", '{{ csrf_token() }}');
                formData.append("vkontakte", 'off');
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
                            document.getElementById("vkontakte_off_button").setAttribute("class", "btn locked_active btn-info");
                            document.getElementById("vkontakte_on_button").setAttribute("class", "btn unlocked_inactive btn-default");
                        }
                    },
                    error: function (xhr, status, error) {

                    }
                });
            }else {
                alert("Please Insert Business First !");
            }
        });

        $('#save_texts').click(function(){
            if(business_id > 0) {
                <?php
                    $updateRoute = route("business.admin.business.login_setting", ['bzname' => $bzname]);
                ?>

                var facebook_text = document.getElementById('facebook_text').value;
                var twitter_text = document.getElementById('twitter_text').value;
                var instagram_text = document.getElementById('instagram_text').value;
                var linkedin_text = document.getElementById('linkedin_text').value;
                var wechat_text = document.getElementById('wechat_text').value;
                var vkontakte_text = document.getElementById('vkontakte_text').value;

                var formData = new FormData();
                formData.append("_token", '{{ csrf_token() }}');
                formData.append("facebook_text", facebook_text);
                formData.append("twitter_text", twitter_text);
                formData.append("instagram_text", instagram_text);
                formData.append("linkedin_text", linkedin_text);
                formData.append("wechat_text", wechat_text);
                formData.append("vkontakte_text", vkontakte_text);
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
                            console.log('Texts Saved Successfully !');
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