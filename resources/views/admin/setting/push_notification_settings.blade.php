@foreach($result as $row)
    @if($row->key == 'enable_notifications')
    <div class="col-md-12 mb-3">
        <label class="switch switch-square">
            <input value="1" type="checkbox" class="switch-input" id="enable_notifications" name="enable_notifications" @if($row->value == 1) checked @endif>
            <span class="switch-toggle-slider">
                <span class="switch-on"></span>
                <span class="switch-off"></span>
            </span>
            <span class="switch-label">{{__('lang.admin_enable_push_notification_placeholder')}}</span>
        </label>
    </div>
    @endif
    @if($row->key == 'one_signal_key')
    <div class="col-md-6 mb-3">
        <label class="form-label" for="one_signal_key">{{__('lang.admin_one_signal_key')}}</label>
        <input type="text" class="form-control" value="{{ \Helpers::maskApiKey($row->value) }}" name="one_signal_key" placeholder="{{__('lang.admin_one_signal_key_placeholder')}}">
    </div>
    @endif
    @if($row->key == 'one_signal_app_id')
    <div class="col-md-6 mb-3">
        <label class="form-label" for="one_signal_app_id">{{__('lang.admin_one_signal_app_id')}}</label>
        <input type="text" class="form-control" value="{{ \Helpers::maskApiKey($row->value) }}" name="one_signal_app_id" placeholder="{{__('lang.admin_one_signal_app_id_placeholder')}}">
    </div>
    @endif
@endforeach