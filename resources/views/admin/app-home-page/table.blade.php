<table class="table">
    <thead class="table-light">
        <tr>
            <th>{{__('lang.admin_id')}}</th>
            <th>{{__('lang.admin_title')}}</th>
            <th>{{__('lang.admin_type')}}</th>
            <th>{{__('lang.admin_type_data')}}</th>
            <th>{{__('lang.admin_status')}}</th>
            <th>{{__('lang.admin_created_date_time')}}</th>
            <th>{{__('lang.admin_action')}}</th>
        </tr>
    </thead>
    <tbody id="app_home_page_table">    
        @php $i=0; @endphp 
        @if(count($result) > 0) 
            @foreach($result as $row) 
                @php $i++; @endphp 
                <tr class="apphomepagerow1" data-id="{{ $row->id }}">
                    <td>{{$i}}</td>
                    <td>{{$row->title}}</td>
                    <td>
                        @if($row->type == 'by_category')
                        {{ __("lang.admin_category") }}
                        @elseif($row->type == 'by_visibility')
                        {{ __("lang.admin_visibility") }}
                        @else
                        {{ __("lang.admin_by_all_blogs") }}
                        @endif
                    </td>
                    <td>
                        @if($row->type == 'by_category')
                            @php
                                $namearray = \Helpers::getTypeDataOfCategoryAppHomePage($row->category_id, $row->sub_category_id);
                            @endphp
                        
                            @if(count($namearray) > 0)
                                @foreach($namearray as $index => $name)
                                    {{ $name }}
                                    @if(($index + 1) % 3 == 0)
                                        <br>
                                    @else
                                        &nbsp;|&nbsp;
                                    @endif
                                @endforeach
                            @else
                                --
                            @endif
                        
                        @elseif($row->type == 'by_visibility')
                            {{ \Helpers::getTypeDataOfVisibilityAppHomePage($row->visibility_id) }}
                        @endif
                    </td>
                    <td>
                        @if($row->status==1) 
                        <a href="{{url('admin/update-app-home-page-status/'.$row->id.'/0')}}">
                            <span class="badge bg-success">{{__('lang.admin_active')}}</span>
                        </a> @else <a href="{{url('admin/update-app-home-page-status/'.$row->id.'/1')}}">
                            <span class="badge bg-danger">{{__('lang.admin_inactive')}}</span>
                        </a> 
                        @endif 
                    </td>
                    <td>
                        {{date("d-m-Y",strtotime($row->created_at))}}</br>
                        <span>{{date("h:i A",strtotime($row->created_at))}}</span>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{url('/admin/edit-app-home-page/'.$row->id)}}">
                                <i class="ti ti-pencil me-1 margin-top-negative-4"></i> {{__('lang.admin_edit')}} </a>
                                <form id="deleteForm_{{$row->id}}" onsubmit="return deleteConfirm('deleteForm_{{$row->id}}');" action="{{ url('admin/delete-app-home-page', $row->id) }}" method="POST"> @csrf @method('DELETE') <button type="submit" class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="{{ __("lang.admin_delete") }}">
                                    <i class="ti ti-trash me-1 margin-top-negative-4"></i>{{__('lang.admin_delete')}} </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr> 
            @endforeach 
        @else 
            <tr>
                <td colspan="8" class="record-not-found">
                    <span>{{__('lang.admin_record_not_found')}}</span>
                </td>
            </tr> 
        @endif 
    </tbody>
</table>