@extends('layouts.business')

@section('template_linked_css')
    <style type="text/css" media="screen">
        .help-block {
            font-size: 13px;
            color: #e65251;
            font-weight: 300;
        }

        .promotion_hlabel {
            font-size: 12px;
            font-weight: 100;
        }

        #div_promotion_upload {
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
                        @if(isset($promotions))
                            <h4>Promotion Images</h4>
                        @else
                            <h4>Upload Promotion Image</h4>
                        @endif
                    </div>

                    <div class="card-body">
                        @if($status == 'on')
                            @if(isset($promotions))
                                <div class="row">
                                    @foreach($promotions as $promotion)
                                    <div class="col-md-4">
                                        <img src="{{ $promotion->path }}" width="100%">
                                        <button type="button" class="btn btn-gradient-primary pull-right mt-2 ml-2" onclick="editPromotion({{ $promotion->id }})">Edit</button>
                                        {!! Form::open(array('url' => '/business/'.$bzname.'/admin/business/promotion/' . $promotion->id, 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                                        {!! Form::hidden('_method', 'DELETE') !!}
                                        {!! Form::button('Delete', array('class' => 'btn btn-gradient-danger pull-right mt-2','type' => 'button' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete', 'data-message' => 'Are you sure you want to delete this Promotion Image ?')) !!}
                                        {!! Form::close() !!}
                                    </div>
                                    @endforeach
                                </div>
                            @endif
                            <div class="col-md-8 pull-right" style="display: @if($count < 20) block @else none @endif" id="div_promotion_upload">
                                {!! Form::open(array('route' => ['business.admin.business.promotion', 'bzname' => $bzname], 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation', 'enctype' =>"multipart/form-data")) !!}

                                {!! csrf_field() !!}

                                <div class="form-group mt-4 has-feedback row {{ $errors->has('email') ? ' has-error ' : '' }}">
                                    {!! Form::label('promotion_image', 'Promotion Img', array('class' => 'col-md-3 control-label')) !!}
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="hidden" name="promotion_id" id="promotion_id">
                                            {!! Form::file('promotion_image', NULL, array('id' => 'promotion_image', 'class' => 'form-control')) !!}
                                        </div>
                                        @if ($errors->has('promotion_image'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('promotion_image') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <button type="button" class="btn btn-gradient-danger margin-bottom-1 mb-1 ml-1 float-right" id="cancel_update" style="display: none;">Cancel</button>
                                {!! Form::button('Upload New', array('class' => 'btn btn-gradient-success margin-bottom-1 mb-1 float-right','type' => 'submit', 'id' => 'create_promotion', 'disabled'=>'disabled' )) !!}
                                {!! Form::close() !!}
                            </div>
                        @else
                            <div class="col-md-12">
                                <label>Upload Promotion is Disabled by Super Admin</label>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-delete')

@endsection

@section('footer_scripts')
    @include('scripts.delete-modal-script')
    <script type="text/javascript">
        var count = "{{ isset($count) ? $count : 0 }}";
        function editPromotion(id) {
            document.getElementById('promotion_id').value = id;
            document.getElementById('div_promotion_upload').style.display = 'block';
            document.getElementById('cancel_update').style.display = 'block';
            document.getElementById('create_promotion').innerHTML = 'Update Promotion Img';
        }

        $('#cancel_update').click(function() {
            document.getElementById('promotion_id').value = '';
            document.getElementById('cancel_update').style.display = 'none';
            document.getElementById('create_promotion').innerHTML = 'Upload New';
            if(count >= 20) {
                document.getElementById('div_promotion_upload').style.display = 'none';
            }
        });

        $(document).on("change", "#promotion_image", function(e) {
            document.getElementById("create_promotion").disabled = false;
            if(this.files[0].size > 1048576)
            {
                alert("The file size should be smaller than 1MB !");
                document.getElementById("create_promotion").disabled = true;
            }
        });
    </script>
@endsection
