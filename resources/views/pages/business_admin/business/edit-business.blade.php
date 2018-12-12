@extends('layouts.business')

@section('template_linked_css')
    <style type="text/css" media="screen">
        .help-block {
            font-size: 13px;
            color: #e65251;
            font-weight: 300;
        }

        #create_business li {
            width: 100%;
            padding: 8px 25px;
            font-size: 18px;
            border-radius: 4px;
            background-color: rgba(255, 175, 0, 0.2);
            border-color: rgba(255, 175, 0, 0);
        }

        #create_business li.active {
            background-color: #ffaf00 !important;
            border-color: #ffaf00;
        }

        #create_business a {
            color: #ffaf00;
        }

        #create_business a.active {
            color: #ffffff !important;
        }

        .error {
            font-size: 13px;
            color: #e65251;
            display: block !important;
        }

        .tab-content {
            border: 0px white !important;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <ul class="nav nav-tabs m-b-2" id="create_business">
                    <li class="active">
                        <a href="#new_business" data-toggle="tab" class="active show">Edit Business</a>
                    </li>
                </ul>
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content clearfix">
                            <div class="tab-pane active" id="new_business">
                                @include('pages.business_admin.partials.business_edit')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')
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

        var business_id = "{{ isset($business) ? $business->id: 0 }}";

        $('#business_submit').on('click', function(e) {
            e.preventDefault();

            if($('#business_form').validate().form()) {
                var myform = document.getElementById("business_form");
                var data = new FormData(myform);
                data.append('country', data.get('business_country'));
                data.append('email', data.get('business_email'));

                if(business_id > 0) {
                    <?php
                       $updateRoute = '';
                       if (isset($business)) {
                           $updateRoute = route("business.admin.business.update", [$bzname, $business->id]);
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
                                location.href = '{{ route("business.admin.business.edit", [$bzname]) }}';
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
    });
</script>
@endsection('footer_scripts')