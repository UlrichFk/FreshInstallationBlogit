@extends('admin/layout/app')
@section('content')

<link rel="stylesheet" href="{{ asset('admin-assets/vendor/css/pages/cards-advance.css')}}"/>
<link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/apex-charts/apex-charts.css')}}" />
<link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/swiper/swiper.css')}}" />
<link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-sm-6 col-lg-3 mb-4">
      <div class="card card-border-shadow-primary">
        @canany(['blog'])
        <a href="{{url('admin/blog?type=post')}}" style="color:unset;">
        @endcanany
          <div class="card-body">
            <div class="d-flex align-items-center mb-2 pb-1">
              <div class="avatar me-2">
                <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-article ti-md"></i></span>
              </div>
              <h4 class="ms-1 mb-0">{{$blog}}</h4>
            </div>
            <p class="mb-1">{{__('lang.admin_total')}} {{__('lang.admin_blogs')}}</p>
          </div>
        @canany(['blog'])
        </a>
        @endcanany
      </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
      <div class="card card-border-shadow-warning">
        @canany(['blog'])
        <a href="{{url('admin/blog?type=quote')}}" style="color:unset;">
        @endcanany
          <div class="card-body">
            <div class="d-flex align-items-center mb-2 pb-1">
              <div class="avatar me-2">
                <span class="avatar-initial rounded bg-label-warning"
                  ><i class="ti ti-quote ti-md"></i
                ></span>
              </div>
              <h4 class="ms-1 mb-0">{{$quote}}</h4>
            </div>
            <p class="mb-1">{{__('lang.admin_total')}} {{__('lang.admin_quotes')}}</p>
          </div>
        @canany(['blog'])
        </a>
        @endcanany
      </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
      <div class="card card-border-shadow-danger">
        @can('category')
        <a href="{{url('admin/category')}}" style="color:unset;">
        @endcan
          <div class="card-body">
            <div class="d-flex align-items-center mb-2 pb-1">
              <div class="avatar me-2">
                <span class="avatar-initial rounded bg-label-danger"
                  ><i class="ti ti-category ti-md"></i
                ></span>
              </div>
              <h4 class="ms-1 mb-0">{{$category}}</h4>
            </div>
            <p class="mb-1">{{__('lang.admin_total')}} {{__('lang.admin_categories')}}</p>
          </div>
        @can('category')
        </a>
        @endcan
      </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-4">
      <div class="card card-border-shadow-info">
        @canany(['user'])
        <a href="{{url('admin/user')}}" style="color:unset;">
        @endcanany
          <div class="card-body">
            <div class="d-flex align-items-center mb-2 pb-1">
              <div class="avatar me-2">
                <span class="avatar-initial rounded bg-label-info"><i class="ti ti-users"></i></span>
              </div>
              <h4 class="ms-1 mb-0">{{$user}}</h4>
            </div>
            <p class="mb-1">{{__('lang.admin_total')}} {{__('lang.admin_users')}}</p>
          </div>
        @canany(['user'])
        </a>
        @endcanany
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-4 col-12 mb-4">
      <div class="card">
        <h5 class="card-header">{{__('lang.admin_user_by_users')}} </h5>
        <div class="card-body">
          <canvas id="doughnutChart" class="chartjs mb-4" data-height="350"></canvas>
          <ul class="doughnut-legend d-flex justify-content-around ps-0 mb-2 pt-1">
            <li class="ct-series-0 d-flex flex-column">
              <h5 class="mb-0 fw-bold">{{__('lang.admin_email')}}</h5>
              <span
                class="badge badge-dot my-2 cursor-pointer rounded-pill"
                style="background-color: #28dac6; width: 35px; height: 6px"
              ></span>
            </li>
            <li class="ct-series-1 d-flex flex-column">
              <h5 class="mb-0 fw-bold">{{__('lang.admin_google')}}</h5>
              <span
                class="badge badge-dot my-2 cursor-pointer rounded-pill"
                style="background-color: #EA4335; width: 35px; height: 6px"
              ></span>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-xl-8 col-12 mb-4">
      <div class="card">
        <div class="card-header header-elements">
          <h5 class="card-title mb-0">{{__('lang.admin_user_statistic')}}</h5>
          <div class="card-action-element ms-auto py-0">
            <form>
                @csrf
                <div class="d-flex align-items-center">
                    <i class="font-medium-2" data-feather="calendar"></i>
                    <input type="text" class="form-control flatpickr-range" placeholder="YYYY-MM-DD" name="date_range" />
                    <button type="submit" class="btn btn-primary data-submit"><i class="menu-icon tf-icons ti ti-search"></i></button>
                </div>
            </form>
          </div>
        </div>
        <div class="card-body">
          <canvas id="barChart1" class="chartjs" data-height="400"></canvas>
        </div>
      </div>
    </div>
    <div class="col-lg-12 mb-4"> 
    <div class="card">
      <div class="card-header">
        <h5 class="card-title display-inline-block">{{__('lang.admin_most_view_blogs')}}</h5>
      </div>
      <div class="table-responsive"> 
      <table class="table">
          <thead class="table-light">
            <tr>
                <th>{{__('lang.admin_image')}}</th>
                <th>{{__('lang.admin_title')}}</th>
                <th>{{__('lang.admin_visibility')}}</th>
                <th>{{__('lang.admin_views')}}</th>
                <th>{{__('lang.admin_created_date_time')}}  </th>
                <th>{{__('lang.admin_status')}}</th>
                <th>{{__('lang.admin_action')}}</th>
            </tr>
        </thead>
        <tbody>    
            @php $i=0; @endphp 
            @if(count($most_viewed_blogs) > 0) 
                @foreach($most_viewed_blogs as $most_viewed_blog) 
                    @php $i++; @endphp 
                    <tr>
                        <td>
                            @if($most_viewed_blog->type=="post")
                              @if($most_viewed_blog->image!='')
                              <img src="{{ url('uploads/blog/80x45/'.$most_viewed_blog->image->image)}}" class="me-75" height="45" width="80" alt="{{$most_viewed_blog->title}}" onerror="this.onerror=null;this.src=`{{ asset('uploads/no-image.png') }}`" />
                              @else
                              <img src="{{ url('uploads/no-image.png')}}" class="me-75" height="45" width="80" alt="{{$most_viewed_blog->title}}"/>
                              @endif
                            @else
                              <img src="{{ url('uploads/blog/'.$most_viewed_blog->background_image)}}" class="me-75"  width="80" alt="{{$most_viewed_blog->title}}" onerror="this.onerror=null;this.src=`{{ asset('uploads/no-image.png') }}`" />
                            @endif
                        </td>
                        <td>
                            <a href="{{url('/admin/update-blog/'.$most_viewed_blog->type.'/'.$most_viewed_blog->id)}}">{{$most_viewed_blog->title}}</a></br>
                            <span><small>{{$most_viewed_blog->category_names}}</small></span>
                        </td>
                        <td>
                            @if(count($most_viewed_blog->blog_visibility))
                                @foreach($most_viewed_blog->blog_visibility as $blog_visibility)
                                    @if($blog_visibility->visibility!='')
                                        <button type="button" class="btn btn-xs btn-primary waves-effect waves-light">{{$blog_visibility->visibility->display_name}}</button>
                                    @endif
                                @endforeach
                            @else
                                --
                            @endif
                        </td>
                        <td>
                            {{$most_viewed_blog->view_count}}
                        </td>
                        <td>
                            {{date("d-m-Y",strtotime($most_viewed_blog->created_at))}}</br>
                            <span>{{date("h:i A",strtotime($most_viewed_blog->created_at))}}</span>
                        </td>
                        <td>
                            @if($most_viewed_blog->status==1)
                                <a href="javascript:;" class="btn btn-xs btn-success waves-effect waves-light" title="{{__('lang.admin_publish')}}">{{__('lang.admin_publish')}}</a>
                            @elseif($most_viewed_blog->status==2)
                                <a href="javascript:;" class="btn btn-xs btn-warning waves-effect waves-light" title="{{__('lang.admin_draft')}}">{{__('lang.admin_draft')}}</a>
                            @elseif($most_viewed_blog->status==3)
                                <a href="javascript:;" class="btn btn-xs btn-primary waves-effect waves-light" title="{{__('lang.admin_submit')}}">{{__('lang.admin_submit')}}</a>
                            @elseif($most_viewed_blog->status==4)
                                <a href="javascript:;" class="btn btn-xs btn-info waves-effect waves-light" title="{{__('lang.admin_scheduled')}}">{{__('lang.admin_scheduled')}}</a>
                            @elseif($most_viewed_blog->status==0)
                                <a href="javascript:;" class="btn btn-xs btn-danger waves-effect waves-light" title="{{__('lang.admin_unpublish')}}">{{__('lang.admin_unpublish')}}</a>
                            @endif
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" title="{{__('lang.admin_select_action')}}">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu">
                                    @if($most_viewed_blog->status==1)
                                        <a class="dropdown-item" href="{{url('/admin/update-blog-status/'.$most_viewed_blog->id.'/0')}}" title="{{__('lang.admin_unpublish')}}">
                                        <i class="ti ti-notes-off me-1 margin-top-negative-4"></i> {{__('lang.admin_unpublish')}} </a>
                                    @endif
                                    <a class="dropdown-item" href="{{url('/admin/update-blog/'.$most_viewed_blog->type.'/'.$most_viewed_blog->id)}}" title="{{__('lang.admin_edit')}}">
                                    <i class="ti ti-pencil me-1 margin-top-negative-4"></i> {{__('lang.admin_edit')}} </a>
                                    <span class="dropdown-item send_notification_to_users" data-id="{{$most_viewed_blog->id}}" title="{{__('lang.admin_notification')}}" style="cursor:pointer">
                                    <i class="ti ti-bell me-1 margin-top-negative-4"></i> {{__('lang.admin_notification')}} </span>
                                    <a class="dropdown-item" href="{{url('/admin/analytics/'.$most_viewed_blog->id)}}" title="{{__('lang.admin_analytics')}}">
                                      <i class="ti ti-report-analytics me-1 margin-top-negative-4"></i> {{__('lang.admin_analytics')}} </a>
                                    <a class="dropdown-item" href="{{url('/admin/blog/translation/'.$most_viewed_blog->id)}}" title="{{__('lang.admin_translation')}}">
                                    <i class="ti ti-language me-1 margin-top-negative-4"></i> {{__('lang.admin_translation')}} </a>
                                    <form id="deleteForm_{{$most_viewed_blog->id}}" action="{{ url('admin/delete-blog', $most_viewed_blog->id) }}" method="POST" onsubmit="return deleteConfirm('deleteForm_{{$most_viewed_blog->id}}');"> @csrf @method('DELETE') <button type="submit" class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="{{__('lang.admin_delete')}}">
                                        <i class="ti ti-trash me-1 margin-top-negative-4"></i>{{__('lang.admin_delete')}} </button>
                                    </form>
                                </div>
                            </div>
                        </td>
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
      </div>
    </div>
    </div>

    <div class="col-lg-12 mb-4"> 
    <div class="card">
      <div class="card-header">
        <h5 class="card-title display-inline-block">{{__('lang.admin_selected_categories')}}</h5>
      </div>
      <div class="table-responsive"> 
      <table class="table">
          <thead class="table-light">
            <tr class="text-nowrap">
                <th>{{__('lang.admin_id')}}</th>
                <th>{{__('lang.admin_image')}}</th>
                <th>{{__('lang.admin_main_category')}}</th>
                <th>{{__('lang.admin_name')}}</th>
                <th>{{__('lang.admin_total_blogs')}}</th>
                @can('update-category-column')
                <th>{{__('lang.admin_featured')}}</th>
                @endcan
                @can('update-category-column')
                <th>{{__('lang.admin_status')}}</th>
                @endcan
                @canany(['update-category', 'delete-category', 'translation-category'])
                <th>{{__('lang.admin_action')}}</th>
                @endcanany
            </tr>
        </thead>
        <tbody>    
            @php $i=0; @endphp 
            @if(count($most_selected_categories) > 0) 
                @foreach($most_selected_categories as $most_selected_category) 
                    @php $i++; @endphp 
                    <tr>
                        <td>{{$i}}</td>
                        <td>
                            <img src="{{ url('uploads/category/'.$most_selected_category->image)}}" class="me-75" height="50" width="50" alt="{{$most_selected_category->name}}" onerror="this.onerror=null;this.src=`{{ asset('uploads/no-image.png') }}`" />
                        </td>
                        <td>@if(isset($most_selected_category->main_category) && $most_selected_category->main_category!='')<a class="cursor-pointer" data-bs-toggle="offcanvas" data-bs-target="#edit-new-record_{{$most_selected_category->main_category->id}}" aria-controls="edit-new-record_{{$most_selected_category->main_category->id}}">{{$most_selected_category->main_category->name}}</a>@else--@endif</td>
                        <td><a class="cursor-pointer" data-bs-toggle="offcanvas" data-bs-target="#edit-new-record_{{$most_selected_category->id}}" aria-controls="edit-new-record_{{$most_selected_category->id}}">{{$most_selected_category->name}}</a></td>
                        <td><a href="{{url('admin/blog?category_id='.$most_selected_category->id)}}">{{$most_selected_category->blog_count}}</a></td>
                        @can('update-category-column')
                        <td> @if($most_selected_category->is_featured==1) 
                            <a href="{{url('admin/update-category-column/'.$most_selected_category->id.'/is_featured/0')}}" title="{{__('lang.admin_yes')}}">
                            <span class="badge bg-success">{{__('lang.admin_yes')}}</span>
                            </a> @else <a href="{{url('admin/update-category-column/'.$most_selected_category->id.'/is_featured/1')}}" title="{{__('lang.admin_no')}}">
                            <span class="badge bg-danger">{{__('lang.admin_no')}}</span>
                            </a> @endif 
                        </td>
                        @endcan
                        @can('update-category-column')
                        <td> @if($most_selected_category->status==1) <a href="{{url('admin/update-category-column/'.$most_selected_category->id.'/status/0')}}" title="{{__('lang.admin_active')}}">
                            <span class="badge bg-success">{{__('lang.admin_active')}}</span>
                            </a> @else <a href="{{url('admin/update-category-column/'.$most_selected_category->id.'/status/1')}}" title="{{__('lang.admin_inactive')}}">
                            <span class="badge bg-danger">{{__('lang.admin_inactive')}}</span>
                            </a> @endif 
                        </td>
                        @endcan
                        @canany(['update-category', 'delete-category', 'translation-category'])
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" title="{{__('lang.admin_select_action')}}">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu">
                                    @can('translation-category')
                                    <a class="dropdown-item" href="{{url('/admin/translation-category/'.$most_selected_category->id)}}" title="{{__('lang.admin_translation')}}">
                                    <i class="ti ti-language me-1 margin-top-negative-4"></i> {{__('lang.admin_translation')}} </a>
                                    @endcan
                                    @can('delete-category')
                                    <form id="deleteForm_{{$most_selected_category->id}}" action="{{ url('admin/delete-category', $most_selected_category->id) }}" method="POST" onsubmit="return deleteConfirm('deleteForm_{{$most_selected_category->id}}');"> @csrf @method('DELETE') <button type="submit" class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="{{__('lang.admin_delete')}}">
                                        <i class="ti ti-trash me-1 margin-top-negative-4"></i>{{__('lang.admin_delete')}} </button>
                                    </form>
                                    @endcan
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
      </div>
    </div>
    </div>
  </div>
</div>
@endsection
