@extends('layouts.business')

@section('template_linked_css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.print.css" media="print"
          rel="stylesheet">
    <style type="text/css" media="screen">
        .help-block {
            font-size: 13px;
            color: #e65251;
            font-weight: 300;
        }

        #div_logo_edit {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.3);
            border-radius: 4px;
            border: 1px solid rgba(0, 0, 0, 0.07)
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-gradient-primary text-white">
                        <h4>Promotion Image Setting</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-gradient-success" id="default_promotion_set">Default Promotion Set</button>
                                <a href="{{ route('business.admin.promotions', ['bzname' => $bzname]) }}"><button class="btn btn-gradient-primary">Show All Promotions</button></a>
                            </div>
                        </div>
                        <input type="hidden" id="promotion_data" value="{{ isset($settings) ? $settings : '' }}">
                        <div id="calendar" class="full-calendar"></div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="createContractModal" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="card-header bg-gradient-primary text-white">
                            <div class="row">
                                <div class="col-md-11">
                                    <h5 class="modal-title" id="promotion_setting_modal_title">Promotion Setting</h5>
                                </div>
                                <div class="col-md-1 text-right">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="create_promotion_form">
                                {!! csrf_field() !!}
                                <div id="setting_field">
                                    <div class="col-sm-12 form-group">
                                        <label for="end-date">Title</label>
                                        <input type="text" name="title" id="title" class="form-control">
                                        <div class="errorTxt"></div>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <label for="start-date">Start Date</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control">
                                        <div class="errorTxt"></div>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <label for="end-date">End Date</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control">
                                        <div class="errorTxt"></div>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <label for="end-date">Start Time</label>
                                        <input type="time" name="start_time" id="start_time" class="form-control">
                                        <div class="errorTxt"></div>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <label for="end-date">End Time</label>
                                        <input type="time" name="end_time" id="end_time" class="form-control">
                                        <div class="errorTxt"></div>
                                    </div>
                                </div>
                                <hr>
                                <h5>Select One</h5>
                                <div class="row">
                                    @foreach($promotions as $index => $promotion)
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input"
                                                               name="promotion_id" id="promotion_radio_{{ $index }}"
                                                               value="{{ $promotion->id }}"
                                                               @if($index == 0) checked @else @endif>
                                                        Image {{$index}}
                                                    </label>
                                                    <img src="{{ $promotion->path }}" width="100%">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </form>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-gradient-success" data-dismiss="modal">Close
                                </button>
                                <button type="button" class="btn btn-gradient-primary" id="save_category">Save changes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <script src="/js/calendar.js"></script>
    <script type="text/javascript">
        // Initialize validator
        $('#create_promotion_form').validate({
            rules: {
                'title': {
                    required: true,
                },
                'start_date': {
                    required: true,
                },
                'end_date': {
                    required: true,
                }
            },
            errorPlacement: function(error, element) {
                var placement = $(element).parent().find('.errorTxt');
                if (placement) {
                    $(placement).append(error)
                } else {
                    error.insertAfter(element);
                }
            }
        });

        document.getElementById("start_time").value = "06:30";
        document.getElementById("end_time").value = "10:00";

        var default_setting = 0;

        $('#default_promotion_set').on('click', function() {
            document.getElementById('setting_field').style.display = 'none';
            $('#promotion_setting_modal_title').text('Set Default Promotion');

            $('#createContractModal').modal({
                show: true
            });

            default_setting = 1;
        });

        $('#save_category').on('click', function() {
            var myform = document.getElementById("create_promotion_form");
            var data = new FormData(myform);
            data.append('default', default_setting);

            if (default_setting || $('#create_promotion_form').validate().form()) {
                $.ajax({
                    url: '{{ route("business.admin.business.setting", ['bzname' => $bzname]) }}',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST', // For jQuery < 1.9
                    success: function (data) {
                        $('#createContractModal').modal('hide');
                        location.href = '{{ route("business.admin.business.setting", ['bzname' => $bzname]) }}';
                    },
                    error: function (xhr, status, error) {

                    }
                });
            }
        });
    </script>
@endsection
