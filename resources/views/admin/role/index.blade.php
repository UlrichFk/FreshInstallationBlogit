@extends('admin/layout/app') 
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4 display-inline-block">
    <span class="text-muted fw-light">
      <a href="{{url('admin/dashboard')}}">{{__('lang.admin_dashboard')}}</a> / </span> {{__('lang.admin_roles')}} {{__('lang.admin_list')}}
  </h4>
  @can('add-role')
  <button class="btn btn-secondary btn-primary float-right mt-3" type="button" href="javascript:;" data-bs-toggle="modal" data-bs-target="#addRoleModal" class="role-edit-modal">
    <span>
      <i class="ti ti-plus me-md-1"></i>
      <span class="d-md-inline-block d-none">{{__('lang.admin_create_role')}}</span>
    </span>
  </button>
  @endcan
  <div class="card">
    <div class="card-header">
      <h5 class="card-title display-inline-block">{{__('lang.admin_roles')}} {{__('lang.admin_list')}}</h5>
      <h6 class="float-right"> <?php if ($result->firstItem() != null) {?> {{__('lang.admin_showing')}} {{ $result->firstItem() }}-{{ $result->lastItem() }} {{__('lang.admin_of')}} {{ $result->total() }} <?php }?> </h6>
    </div>
    <div class="table-responsive text-nowrap"> @include('admin/role/table') </div>
    <div class="card-footer">
      <div class="pagination" style="float: right;">
        {{$result->withQueryString()->links('pagination::bootstrap-4')}}
      </div>
    </div>
  </div>
  <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-add-new-role">
    <div class="modal-content p-4">
      <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-body">
        <div class="text-center mb-4">
          <h3 class="role-title mb-2">{{__('lang.admin_add_role')}}</h3>
          <p class="text-muted">{{__('lang.admin_set_role_permission')}}</p>
        </div>

        <!-- Add Role Form -->
        <form class="row g-3" id="add-record" onsubmit="return validateRole('add-record');" action="{{url('admin/add-role')}}" method="POST">
          @csrf
          <div class="col-12 mb-4">
            <label class="form-label" for="name">{{__('lang.admin_role_name')}} <span class="required">*</span></label>
            <input type="text" id="name" name="name" class="form-control" placeholder="{{__('lang.admin_role_name_placeholder')}}" />
          </div>

          <!-- Role Permissions Section -->
          <div class="col-12">
            <h5>{{__('lang.admin_role_permissions')}}</h5>
            <div class="row">
                <div class="col-md-3">
                  <input class="form-check-input permission-all-checkbox_List" type="checkbox" value="List" data-permission="List" onclick="selectAllSameData('permission-all-checkbox_List','permission-checkbox_List');"/>
                  <label class="form-check-label" for="All"> All List</label>
                </div>
                <div class="col-md-3">
                  <input class="form-check-input permission-all-checkbox_Add" type="checkbox" value="Add" data-permission="Add" onclick="selectAllSameData('permission-all-checkbox_Add','permission-checkbox_Add');"/>
                  <label class="form-check-label" for="Add"> All Add</label>
                </div>
                <div class="col-md-3">
                  <input class="form-check-input permission-all-checkbox_Update" type="checkbox" value="Update" data-permission="Update" onclick="selectAllSameData('permission-all-checkbox_Update','permission-checkbox_Update');"/>
                  <label class="form-check-label" for="Update"> All Update</label>
                </div>
                <div class="col-md-3">
                  <input class="form-check-input permission-all-checkbox_Status Change" type="checkbox" data-permission="Status" onclick="selectAllSameData('permission-all-checkbox_Status','permission-checkbox_Status');"/>
                  <label class="form-check-label" for="Status"> All Status Change</label>
                </div>
                <div class="col-md-3">
                  <input class="form-check-input permission-all-checkbox_Delete" type="checkbox" value="{{ __("lang.admin_delete") }}" data-permission="Delete" onclick="selectAllSameData('permission-all-checkbox_Delete','permission-checkbox_Delete');"/>
                  <label class="form-check-label" for="Delete"> All Delete</label>
                </div>
                <div class="col-md-3">
                  <input class="form-check-input permission-all-checkbox_Sortable" type="checkbox" value="{{ __("lang.admin_delete") }}" data-permission="Delete" onclick="selectAllSameData('permission-all-checkbox_Sortable','permission-checkbox_Sortable');"/>
                  <label class="form-check-label" for="Delete"> All Sortable</label>
                </div>
                <div class="col-md-3">
                  <input class="form-check-input permission-all-checkbox_Analytics" type="checkbox" value="Analytics" data-permission="Analytics" onclick="selectAllSameData('permission-all-checkbox_Analytics','permission-checkbox_Analytics');"/>
                  <label class="form-check-label" for="Analytics"> All Analytics</label>
                </div>
                <div class="col-md-3">
                  <input class="form-check-input permission-all-checkbox_Notification" type="checkbox" value="Notification" data-permission="Notification" onclick="selectAllSameData('permission-all-checkbox_Notification','permission-checkbox_Notification');"/>
                  <label class="form-check-label" for="Notification"> All Notification</label>
                </div>
                <div class="col-md-3">
                  <input class="form-check-input permission-all-checkbox_Translation" type="checkbox" value="Translation" data-permission="Translation" onclick="selectAllSameData('permission-all-checkbox_Translation','permission-checkbox_Translation');"/>
                  <label class="form-check-label" for="Translation"> All Translation</label>
                </div>
                <div class="col-md-3">
                  <input class="form-check-input permission-all-checkbox_Publish" type="checkbox" value="Publish" data-permission="Publish" onclick="selectAllSameData('permission-all-checkbox_Publish','permission-checkbox_Publish');"/>
                  <label class="form-check-label" for="Publish"> All Publish</label>
                </div>
                <div class="col-md-3">
                  <input class="form-check-input permission-all-checkbox_Personalization" type="checkbox" value="Personalization" data-permission="Personalization" onclick="selectAllSameData('permission-all-checkbox_Personalization','permission-checkbox_Personalization');"/>
                  <label class="form-check-label" for="Personalization"> All Personalization</label>
                </div>
                <div class="col-md-3">
                  <input class="form-check-input permission-all-checkbox_View" type="checkbox" value="View" data-permission="View" onclick="selectAllSameData('permission-all-checkbox_View','permission-checkbox_View');"/>
                  <label class="form-check-label" for="View"> All View</label>
                </div>
              </div>
          </div>

          <!-- Permission Table -->
          <div class="table-responsive mt-3">
            <table class="table table-bordered">
              <thead class="table-light">
                <tr>
                  <th>Module</th>
                  <th>Permissions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($permission as $value)
                <tr>
                  <td class="fw-semibold">@if($value->module=='Blog')Blog/Quote @else {{$value->module}} @endif</td>
                  <td>
                    <div class="d-flex flex-wrap">
                      @foreach($value->permission as $detail)
                      <div class="form-check me-3">
                        <input class="form-check-input permission-checkbox_{{ $detail->permission_name }}" type="checkbox" id="{{ $detail->route_name }}" name="permission[]" value="{{$detail->id}}" {{$detail->is_default ? 'checked' : ''}} />
                        <label class="form-check-label" for="{{ $detail->route_name }}">{{ $detail->permission_name }}</label>
                      </div>
                      @endforeach
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <!-- Form Actions -->
          <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-primary">{{__('lang.admin_button_save_changes')}}</button>
            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">{{__('lang.admin_button_cancel')}}</button>
          </div>
        </form>
        <!-- End of Form -->
      </div>
    </div>
  </div>
</div>

</div> 
@endsection