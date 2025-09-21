@extends('admin/layout/app')
@section('content')
<script src="{{ asset('admin-assets/js/ckeditor.js')}}"></script>
<link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/tagify/tagify.css')}}" />

<link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css')}}" />
<link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/select2/select2.css')}}" />


<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4 display-inline-block"><span class="text-muted fw-light"><a href="{{url('admin/dashboard')}}">{{__('lang.admin_dashboard')}}</a> /<a href="{{url('admin/blog')}}"> {{__('lang.admin_blog')}} {{__('lang.admin_list')}} </a>/</span> {{__('lang.admin_analytics')}}</h4>
    <div class="row">
        <div class="col">
            <div class="card mb-3">
                
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link active"
                            data-bs-toggle="tab"
                            data-bs-target="#form-tabs-personal"
                            role="tab"
                            aria-selected="true"
                            >
                            {{__('lang.admin_blog_views')}}({{$viewsCount}})
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#form-tabs-likes"
                            role="tab"
                            aria-selected="false"
                            >
                            {{__('lang.admin_blog_like')}}({{$likesCount}})
                            </button>
                        </li>
                         <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#form-tabs-comment"
                            role="tab"
                            aria-selected="false"
                            >
                            {{__('lang.admin_blog_comment')}}({{$commentsCount}})
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#form-tabs-account"
                            role="tab"
                            aria-selected="false"
                            >
                            {{__('lang.admin_blog_bookmark')}}({{$bookmarksCount}})
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#form-tabs-source"
                            role="tab"
                            aria-selected="false"
                            >
                            {{__('lang.admin_blog_share')}}({{$sharesCount}})
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#form-tabs-poll"
                            role="tab"
                            aria-selected="false"
                            >
                            {{__('lang.admin_blog_poll')}}({{$blog_pollsCount}})
                            </button>
                        </li>
                        <!-- <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#form-tabs-social"
                            role="tab"
                            aria-selected="false"
                            >
                            {{__('lang.admin_visibility')}}
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#form-tabs-voting"
                            role="tab"
                            aria-selected="false"
                            >
                            {{__('lang.admin_voting_pool_question')}}
                            </button>
                        </li> -->
                    </ul>
                </div>

                <div class="tab-content">
                    <div class="tab-pane fade active show" id="form-tabs-personal" role="tabpanel">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>{{__('lang.admin_name')}}</th>
                                    <th>{{__('lang.admin_viewed_at')}}</th>
                                </tr>
                            </thead>
                            <tbody>    
                                @if(count($views) > 0) 
                                    @foreach($views as $view) 
                                        <tr>
                                            <td>
                                            @if(isset($view->user) && $view->user!=''){{$view->user->name}}@else {{ __("lang.admin_guest") }} @endif
                                            </td>
                                            <td>
                                                {{date("d-m-Y",strtotime($view->created_at))}}</br>
                                                <span>{{date("h:i A",strtotime($view->created_at))}}</span>
                                            </td>
                                        </tr> 
                                    @endforeach 
                                @else 
                                    <tr>
                                        <td colspan="2" class="record-not-found">
                                            <span>{{__('lang.admin_record_not_found')}}</span>
                                        </td>
                                    </tr> 
                                @endif 
                            </tbody>
                        </table>   
                        <div class="card-footer">
                            <div class="pagination" style="float: right;">
                                {{$views->withQueryString()->links('pagination::bootstrap-4')}}
                            </div>
                        </div>                    
                    </div>
                    <div class="tab-pane fade " id="form-tabs-likes" role="tabpanel">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>{{__('lang.admin_name')}}</th>
                                    <th>{{__('lang.admin_like_at')}}</th>
                                </tr>
                            </thead>
                            <tbody>    
                                @if(count($likes) > 0) 
                                    @foreach($likes as $like) 
                                        <tr>
                                            <td>
                                            @if(isset($like->user) && $like->user!=''){{$like->user->name}}@else {{ __("lang.admin_guest") }} @endif
                                            </td>
                                            <td>
                                                {{date("d-m-Y",strtotime($like->created_at))}}</br>
                                                <span>{{date("h:i A",strtotime($like->created_at))}}</span>
                                            </td>
                                        </tr> 
                                    @endforeach 
                                @else 
                                    <tr>
                                        <td colspan="2" class="record-not-found">
                                            <span>{{__('lang.admin_record_not_found')}}</span>
                                        </td>
                                    </tr> 
                                @endif 
                            </tbody>
                        </table>   
                        <div class="card-footer">
                            <div class="pagination" style="float: right;">
                                {{$likes->withQueryString()->links('pagination::bootstrap-4')}}
                            </div>
                        </div>                    
                    </div>
                    <div class="tab-pane fade" id="form-tabs-comment" role="tabpanel">                    
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>{{__('lang.admin_name')}}</th>
                                    <th>{{__('lang.admin_comment')}}</th>
                                    <th>{{__('lang.admin_total_user_reported')}}</th>
                                    <th>{{__('lang.admin_commented_at')}}</th>
                                    <th>{{__('lang.admin_status')}}</th>
                                    <th>{{__('lang.admin_action')}}</th>
                                </tr>
                            </thead>
                            <tbody>    
                                @if(count($comments) > 0) 
                                    @foreach($comments as $comment) 
                                        <tr>
                                            <td>
                                            @if(isset($comment->user) && $comment->user!=''){{$comment->user->name}}@else {{ __("lang.admin_guest") }} @endif
                                            </td>
                                            <td>
                                            @if(isset($comment->comment) && $comment->comment!=''){{$comment->comment}}@else -- @endif
                                            </td>
                                            <td>{{$comment->reported_count}}</td>
                                            <td>
                                                {{date("d-m-Y",strtotime($comment->created_at))}}</br>
                                                <span>{{date("h:i A",strtotime($comment->created_at))}}</span>
                                            </td>
                                            <td> 
                                                @if($comment->approval_status==2 || $comment->approval_status==0) 
                                                <span class="badge bg-danger">{{__('lang.admin_disapprove')}}</span>
                                                @else
                                                <span class="badge bg-success">{{__('lang.admin_approve')}}</span>
                                                @endif 
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" title="{{__('lang.admin_select_action')}}">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        @if($comment->approval_status==2 || $comment->approval_status==0)
                                                            <a class="dropdown-item" href="{{url('/admin/update-comment-column/'.$comment->id.'/approval_status/1')}}" title="{{__('lang.admin_approve')}}">
                                                            <i class="ti ti-square-check me-1 margin-top-negative-4"></i> {{__('lang.admin_approve')}} </a>
                                                        @endif
                                                        @if($comment->approval_status==1 || $comment->approval_status==0)
                                                            <a class="dropdown-item" href="{{url('/admin/update-comment-column/'.$comment->id.'/approval_status/2')}}" title="{{__('lang.admin_disapprove')}}">
                                                            <i class="ti ti-square-x me-1 margin-top-negative-4"></i> {{__('lang.admin_disapprove')}} </a>
                                                        @endif
                                                        <a class="dropdown-item" type="button" data-bs-toggle="offcanvas" data-bs-target="#edit-new-record_{{$comment->id}}" aria-controls="edit-new-record_{{$comment->id}}" title="{{__('lang.admin_edit')}}">
                                                        <i class="ti ti-pencil me-1 margin-top-negative-4"></i> {{__('lang.admin_edit')}} </a>
                                                        <form id="deleteForm_{{$comment->id}}" action="{{ url('admin/delete-comment', $comment->id) }}" method="POST" onsubmit="return deleteConfirm('deleteForm_{{$comment->id}}');"> @csrf @method('DELETE') <button type="submit" class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="{{__('lang.admin_delete')}}">
                                                            <i class="ti ti-trash me-1 margin-top-negative-4"></i>{{__('lang.admin_delete')}} </button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="offcanvas offcanvas-end" id="edit-new-record_{{$comment->id}}">
                                                    <div class="offcanvas-header border-bottom">
                                                        <h5 class="offcanvas-title" id="exampleModalLabel">{{__('lang.admin_comment')}}</h5>
                                                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                    </div>
                                                    <div class="offcanvas-body flex-grow-1">
                                                        <form class="add-new-record pt-0 row g-2" id="edit-record" action="{{url('admin/update-comment')}}" method="POST" enctype="multipart/form-data" onsubmit="return validateComment();"> @csrf 
                                                            <div class="col-sm-12">
                                                                <input type="hidden" name="id" value="{{$comment->id}}">
                                                                <div class="mb-1">
                                                                <label class="form-label" for="basic-icon-default-fullname">{{__('lang.admin_comment')}} <span class="required">*</span></label>
                                                                <input type="text" class="form-control dt-full-name" id="basic-icon-default-fullname" placeholder="{{__('lang.admin_comment_placeholder')}}" name="comment" value="{{$comment->comment}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">{{__('lang.admin_button_save_changes')}}</button>
                                                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">{{__('lang.admin_button_cancel')}}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr> 
                                    @endforeach 
                                @else 
                                    <tr>
                                        <td colspan="6" class="record-not-found">
                                            <span>{{__('lang.admin_record_not_found')}}</span>
                                        </td>
                                    </tr> 
                                @endif 
                            </tbody>
                        </table>                   
                    </div>
                    <div class="tab-pane fade" id="form-tabs-account" role="tabpanel">                    
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>{{__('lang.admin_name')}}</th>
                                    <th>{{__('lang.admin_viewed_at')}}</th>
                                </tr>
                            </thead>
                            <tbody>    
                                @if(count($bookmarks) > 0) 
                                    @foreach($bookmarks as $bookmark) 
                                        <tr>
                                            <td>
                                                @if(isset($bookmark->user) && $bookmark->user!=''){{$bookmark->user->name}}@else {{ __("lang.admin_guest") }} @endif
                                            </td>
                                            <td>
                                                {{date("d-m-Y",strtotime($bookmark->created_at))}}</br>
                                                <span>{{date("h:i A",strtotime($bookmark->created_at))}}</span>
                                            </td>
                                        </tr> 
                                    @endforeach 
                                @else 
                                    <tr>
                                        <td colspan="2" class="record-not-found">
                                            <span>{{__('lang.admin_record_not_found')}}</span>
                                        </td>
                                    </tr> 
                                @endif 
                            </tbody>
                        </table>   
                        <div class="card-footer">
                            <div class="pagination" style="float: right;">
                                {{$bookmarks->withQueryString()->links('pagination::bootstrap-4')}}
                            </div>
                        </div>                
                    </div>
                    <div class="tab-pane fade" id="form-tabs-source" role="tabpanel">                    
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>{{__('lang.admin_name')}}</th>
                                    <th>{{__('lang.admin_viewed_at')}}</th>
                                </tr>
                            </thead>
                            <tbody>    
                                @if(count($shares) > 0) 
                                    @foreach($shares as $share) 
                                        <tr>
                                            <td>
                                            @if(isset($share->user) && $share->user!=''){{$share->user->name}}@else {{ __("lang.admin_guest") }} @endif
                                            </td>
                                            <td>
                                                {{date("d-m-Y",strtotime($share->created_at))}}</br>
                                                <span>{{date("h:i A",strtotime($share->created_at))}}</span>
                                            </td>
                                        </tr> 
                                    @endforeach 
                                @else 
                                    <tr>
                                        <td colspan="2" class="record-not-found">
                                            <span>{{__('lang.admin_record_not_found')}}</span>
                                        </td>
                                    </tr> 
                                @endif 
                            </tbody>
                        </table>      
                        <div class="card-footer">
                            <div class="pagination" style="float: right;">
                                {{$shares->withQueryString()->links('pagination::bootstrap-4')}}
                            </div>
                        </div>             
                    </div>
                    <div class="tab-pane fade" id="form-tabs-poll" role="tabpanel">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>{{__('lang.admin_title')}}</th>
                                    <th>{{__('lang.admin_option')}}</th>
                                </tr>
                            </thead>
                            <tbody>    
                                @if(count($blog_polls) > 0) 
                                    @foreach($blog_polls as $poll) 
                                        <tr>
                                            <td>
                                                {{ \Helpers::getParticularBlogQuestion($poll->blog_id) }}
                                            </td>
                                            <td>
                                                @php 
                                                    // Get options for the current poll
                                                    $options = \Helpers::getParticularBlogPollQuestionOptions($poll->blog_id);
                                                    
                                                    // Define labels for options
                                                    $optionLabels = ['A' => '{{ __("lang.admin_yes") }}', 'B' => '{{ __("lang.admin_no") }}', 'C' => '{{ __("lang.admin_both") }}', 'D' => '{{ __("lang.admin_no") }}ne of these'];
                                                @endphp
                                                @if(count($options))
                                                    @foreach($options as $index => $option)
                                                        @php 
                                                            // Get alphabet based on option index
                                                            $alphabet = chr(65 + $index); // A, B, C, ...
                                                        @endphp
                                                        <p>
                                                            {{ $alphabet }}: {{ $optionLabels[$alphabet] }} (
                                                            {{ __("lang.admin_votes") }}: {{ \App\Models\BlogAnalytic::where('type', 'blog_poll_option')
                                                                    ->where('blog_poll_option_id', $option->id)
                                                                    ->count() }} )
                                                        </p>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr> 
                                    @endforeach
                                @else 
                                    <tr>
                                        <td colspan="2" class="record-not-found">
                                            <span>{{__('lang.admin_record_not_found')}}</span>
                                        </td>
                                    </tr> 
                                @endif 
                            </tbody>
                        </table>      
                        <div class="card-footer">
                            <div class="pagination" style="float: right;">
                                {{$blog_polls->withQueryString()->links('pagination::bootstrap-4')}}
                            </div>
                        </div>             
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection