<!-- Local Storage Form -->
<form method="POST" id="update-local-storage-record" action="{{ url('admin/update-setting') }}" enctype="multipart/form-data">
    <input type="hidden" name="page_name" value="storage-setting">
    @csrf
    @foreach($result as $row)
        @if($row->key == 'default_storage')
            <div class="row mt-2">
                <div class="col-md-5">
                    <h5>{{ __('lang.admin_local_storage_heading') }}</h5>
                </div>
                <div class="col-md-2">
                    <button type="button" id="set-as-default-local-storage-btn" class="btn btn-sm btn-info" value="{{ $row->value }}" {{ $row->value == 'local_storage' ? 'disabled' : '' }}>
                        {{ $row->value == 'local_storage' ? __('lang.admin_default') : __('lang.admin_set_as_default') }}
                    </button>
                </div>
            </div>
        @endif
    @endforeach
</form>

<!-- S3 Storage Form -->
<form method="POST" id="update-s3-storage-record" action="{{url('admin/update-setting')}}" method="POST" enctype="multipart/form-data">
    @csrf
    @foreach($result as $row)
        @if($row->key == 'default_storage')
            <div class="row mt-1">
                <div class="col-md-5">
                    <h5>{{ __('lang.admin_s3_storage_heading') }}</h5>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-sm btn-info" id="set-as-default-btn" type="button" value="{{ $row->value }}" {{ $row->value == 's3_storage' ? 'disabled' : '' }}>
                        {{ $row->value == 's3_storage' ? __('lang.admin_default') : __('lang.admin_set_as_default') }}
                    </button>
                </div>
                @php
                $value = Session::get('imagePath');
                @endphp
                @if($value)
                <p class="mt-2 image_path_cls"> Image Path :- {{$value}}</p>
                @endif
            </div>
        @endif
    @endforeach


    <input type="hidden" name="page_name" value="storage-setting">
    <div class="row">
    @foreach($result as $row)
        @if($row->key == 'aws_access_key_id')
        <div class="col-md-6 mb-3">
            <label class="form-label" for="aws_access_key_id">{{__('lang.admin_aws_access_key_id')}}</label>
            <input type="text" class="form-control" value="{{ \Helpers::maskApiKey($row->value) }}" name="aws_access_key_id" placeholder="{{__('lang.admin_aws_access_key_id_placeholder')}}">
        </div>
        @endif

        @if($row->key == 'aws_secret_access_key')
        <div class="col-md-6 mb-3">
            <label class="form-label" for="aws_secret_access_key">{{__('lang.admin_aws_secret_access_key')}}</label>
            <input type="text" class="form-control" value="{{ \Helpers::maskApiKey($row->value) }}" name="aws_secret_access_key" placeholder="{{__('lang.admin_aws_secret_access_key_placeholder')}}">
        </div>
        @endif

        @if($row->key == 'aws_default_region')
        <div class="col-md-4 mb-3">
            <label class="form-label" for="aws_default_region">{{__('lang.admin_aws_default_region')}}</label>
            <input type="text" class="form-control" value="{{ $row->value }}" name="aws_default_region" placeholder="{{__('lang.admin_aws_default_region_placeholder')}}">
        </div>
        @endif

        @if($row->key == 'aws_bucket')
        <div class="col-md-4 mb-3">
            <label class="form-label" for="aws_bucket">{{__('lang.admin_aws_bucket')}}</label>
            <input type="text" class="form-control" value="{{ $row->value }}" name="aws_bucket" placeholder="{{__('lang.admin_aws_bucket_placeholder')}}">
        </div>
        @endif

        @if($row->key == 'aws_url')
        <div class="col-md-4 mb-3">
            <label class="form-label" for="aws_url">{{__('lang.admin_aws_url')}}</label>
            <input type="text" class="form-control" value="{{$row->value }}" name="aws_url" placeholder="{{__('lang.admin_aws_url_placeholder')}}">
        </div>
        @endif
    @endforeach
    </div>

    <div class="col-12 d-flex flex-sm-row flex-column mt-2">
        <button type="submit" class="btn btn-primary mb-1 mb-sm-0 me-0 me-sm-1">{{__('lang.admin_button_save_changes')}}</button>
        <a href="{!! url('admin/dashboard') !!}" class="btn btn-outline-secondary">{{__('lang.admin_button_back')}}</a>
    </div>

</form>

<!-- Modal for Image Upload -->
<div class="modal fade" id="s3TestModal" tabindex="-1" aria-labelledby="s3TestModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="s3TestModalLabel">{{ __('Please select an image for testing S3 bucket configuration') }}</h5>
            </div>
            <div class="modal-body">
                <input type="file" class="form-control-file" id="s3_test_image" name="s3_test_image">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-modal-btn" data-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" class="btn btn-primary" id="test-s3-btn">{{ __('Test') }}</button>
            </div>
        </div>
    </div>
</div>


<!-- Include SweetAlert2 library -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- JavaScript for form validation and AJAX call -->
<script>
// for s3 storage
$(document).ready(function() {
    $('#set-as-default-btn').click(function() {
        // Validate form fields
        var valid = true;
        $('#update-s3-storage-record').find('input[type="text"]').each(function() {
            if ($(this).val() === '') {
                valid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (valid) {
            // Show modal for image upload
            $('#s3TestModal').modal('show');
        }
    });

    $('#test-s3-btn').click(function() {
        var formData = new FormData();
        var fileInput = $('#s3_test_image')[0];
        if (fileInput.files.length > 0) {
            formData.append('s3_test_image', fileInput.files[0]);
        } else {
            alert('Please select an image.');
            return;
        }

        alert('Please wait.......');

        $.ajax({
                url: '{{ url("admin/test-s3-connection") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                      title: "Success!",
                      text: "Connection to S3 bucket successful.",
                      icon: "success"
                    }).then(function() {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to connect to S3 bucket.',
                        icon: 'error',
                    });
                }
            });
    });

    // Reload page on modal close or confirmation
    $(document).on('hidden.bs.modal', '#s3TestModal', function() {
        location.reload();
    });
});



// for close modal
$(document).on('click','.close-modal-btn',function(){
$('#s3TestModal').modal('hide');
});

// for local storage
$(document).on('click','#set-as-default-local-storage-btn',function(){
    $.ajax({
            url: '{{ url("admin/test-local-connection") }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Handle success response
                location.reload();
            },
            error: function(xhr) {
                // Handle error response
                alert('Error: ' + xhr.responseText);
            }
        });

});
</script>
