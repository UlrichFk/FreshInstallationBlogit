<table class="table">
    <thead class="table-light">
        <tr>
            @can('delete-short-video')
            <th class="sorting_disabled dt-checkboxes-cell dt-checkboxes-select-all" rowspan="1" colspan="1" style="width: 17.4271px;" data-col="0" aria-label="">
                <input id="selectAll" type="checkbox" class="form-check-input">
            </th>
            @endcan
            <th>{{__('lang.admin_image')}}</th>
            <th>@sortablelink('title', __('lang.admin_title'))</th>
            <th>@sortablelink('schedule_date', __('lang.admin_schedule_date_time'))</th>
            <th>@sortablelink('created_at', __('lang.admin_created_date_time'))</th>
            @can('update-short-video-column')
            <th>{{__('lang.admin_status')}}</th>
            @endcan
            @canany(['update-short-video', 'delete-short-video', 'translation-short-video'])
            <th>{{__('lang.admin_action')}}</th>
            @endcanany
        </tr>
    </thead>
    <tbody>    
        @php $i=0; @endphp 
        @if(count($result) > 0) 
            @foreach($result as $row) 
                @php $i++; @endphp 
                <tr>
                    @can('delete-short-video')
                    <td>
                        <input type="checkbox" class="form-check-input selectCheckbox" value="{{ $row->id }}">
                    </td>
                    @endcan
                    <td>
                        <img src="{{ url('uploads/short_video/'.$row->background_image)}}" class="me-75" height="45" width="80" alt="{{$row->title}}" onerror="this.onerror=null;this.src=`{{ asset('uploads/no-image.png') }}`" />
                    </td>
                    <td>
                        @if (Gate::check('update-short-video'))
                        <a href="{{url('/admin/edit-short-video/'.$row->id)}}">{{$row->title}} </a> 
                        @else
                            {{$row->title}}
                        @endif
                    </td>
                    <td>
                        {{date("d-m-Y",strtotime($row->schedule_date))}}</br>
                        <span>{{date("h:i A",strtotime($row->schedule_date))}}</span>
                    </td>
                    <td>
                        {{date("d-m-Y",strtotime($row->created_at))}}</br>
                        <span>{{date("h:i A",strtotime($row->created_at))}}</span>
                    </td>
                    @can('update-short-video-column')
                    <td>
                        @if($row->status==1)
                            <a href="javascript:;" class="btn btn-xs btn-success waves-effect waves-light" title="{{__('lang.admin_publish')}}">{{__('lang.admin_publish')}}</a>
                        @elseif($row->status==2)
                            <a href="javascript:;" class="btn btn-xs btn-warning waves-effect waves-light" title="{{__('lang.admin_draft')}}">{{__('lang.admin_draft')}}</a>
                        @elseif($row->status==3)
                            <a href="javascript:;" class="btn btn-xs btn-primary waves-effect waves-light" title="{{__('lang.admin_submit')}}">{{__('lang.admin_submit')}}</a>
                        @elseif($row->status==4)
                            <a href="javascript:;" class="btn btn-xs btn-info waves-effect waves-light" title="{{__('lang.admin_scheduled')}}">{{__('lang.admin_scheduled')}}</a>
                        @elseif($row->status==0)
                            <a href="javascript:;" class="btn btn-xs btn-danger waves-effect waves-light" title="{{__('lang.admin_unpublish')}}">{{__('lang.admin_unpublish')}}</a>
                        @endif
                    </td>
                    @endcan
                    @canany(['update-short-video', 'delete-short-video', 'translation-short-video'])
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" title="{{__('lang.admin_select_action')}}">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                @can('update-short-video-column')
                                    @if($row->status==1)
                                        <a class="dropdown-item" href="{{url('/admin/update-short-video-status/'.$row->id.'/0')}}" title="{{__('lang.admin_unpublish')}}">
                                        <i class="ti ti-notes-off me-1 margin-top-negative-4"></i> {{__('lang.admin_unpublish')}} </a>
                                    @elseif($row->status==3)
                                        <a class="dropdown-item" href="{{url('/admin/update-short-video-status/'.$row->id.'/1')}}" title="{{__('lang.admin_unpublish')}}">
                                        <i class="ti ti-notes me-1 margin-top-negative-4"></i> {{__('lang.admin_publish')}} </a>
                                    @endif
                                @endcan

                                @canany(['update-short-video', 'delete-short-video', 'translation-short-video'])

                                    @can('translation-short-video')
                                        <a class="dropdown-item" href="{{url('/admin/short-video/translation/'.$row->id)}}" title="{{__('lang.admin_translation')}}">
                                        <i class="ti ti-language me-1 margin-top-negative-4"></i> {{__('lang.admin_translation')}} </a>
                                        @endcan
                                        
                                        
                                        @can('analytics')
                                        <a class="dropdown-item" href="{{url('/admin/short-video-analytics/'.$row->id)}}" title="{{__('lang.admin_analytics')}}">
                                        <i class="ti ti-report-analytics me-1 margin-top-negative-4"></i> {{__('lang.admin_analytics')}} </a>
                                        @endcan
                                       
                                        @can('update-short-video')
                                        <a class="dropdown-item" href="{{url('/admin/edit-short-video/'.$row->id)}}" title="{{__('lang.admin_edit')}}">
                                        <i class="ti ti-pencil me-1 margin-top-negative-4"></i> {{__('lang.admin_edit')}} </a>
                                        @endcan
             
                                        @can('delete-short-video')
                                        <form id="deleteForm_{{$row->id}}" action="{{ url('admin/delete-short-video', $row->id) }}" method="POST" onsubmit="return deleteConfirm('deleteForm_{{$row->id}}');"> @csrf @method('DELETE') <button type="submit" class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="{{__('lang.admin_delete')}}">
                                            <i class="ti ti-trash me-1 margin-top-negative-4"></i>{{__('lang.admin_delete')}} </button>
                                        </form>
                                    @endcan
                                @endcanany
                            </div>
                        </div>
                    </td>
                    @endcanany

                </tr> 
            @endforeach 
        @else 
            <tr>
                <td colspan="7" class="record-not-found">
                    <span>{{__('lang.admin_record_not_found')}}</span>
                </td>
            </tr> 
        @endif 
    </tbody>
</table>