<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <!--weather card-->
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Upload Promotion</h4>
                <div class="btn-group ml-5" id="toggle_event_editing">
                    <button type="button" id="on_button" class="btn @if(isset($setting)) @if($setting->upload_promotion == 'on') ? btn-info locked_active : btn-default unlocked_inactive @endif @else btn-info locked_active @endif">ON</button>
                    <button type="button" id="off_button" class="btn @if(isset($setting)) @if($setting->upload_promotion == 'off') ? btn-info locked_active : btn-default unlocked_inactive @endif @else btn-default unlocked_inactive @endif">OFF</button>
                </div>
            </div>
        </div>
        <!--weather card ends-->
    </div>
    <div class="col-lg-12 grid-margin stretch-card mt-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Redirect Url Set</h4>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="redirect_url">http://</span>
                    </div>
                    <input id="change_redirect" type="text" class="form-control" aria-describedby="basic-addon3" value="{{ isset($setting) ? $setting->redirect_url : '' }}">
                </div>
                <div class="input-group mb-3" id="submit_redirect_div" hidden>
                    <button type="button" id="save_redirect_url" class="btn btn-warning">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>