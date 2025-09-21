@extends('site.layout.site-app')

@section('title', $blog->title)

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-8">
            <!-- {{ __("lang.site_premium_content") }} Notice -->
            @if($blog->is_premium)
            <div class="alert alert-warning mb-4">
                <div class="d-flex align-items-center">
                    <i class="ti ti-crown me-3 fs-4"></i>
                    <div>
                        <h5 class="alert-heading">{{ __("lang.site_premium_content") }}</h5>
                        <p class="mb-0">{{ __("lang.site_premium_content_message") }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Article Header -->
            <div class="card mb-4">
                <div class="card-body">
                    <h1 class="card-title">{{ $blog->title }}</h1>
                    
                    <div class="d-flex align-items-center text-muted mb-3">
                        <i class="ti ti-calendar me-2"></i>
                        <span>{{ $blog->created_at->format('M d, Y') }}</span>
                        <i class="ti ti-user ms-3 me-2"></i>
                        <span>{{ $blog->author->name ?? 'Admin' }}</span>
                        @if($blog->is_premium)
                        <span class="badge bg-warning ms-2">
                            <i class="ti ti-crown me-1"></i>Premium
                        </span>
                        @endif
                    </div>

                    @if($blog->images && count($blog->images) > 0)
                    <div class="mb-4">
                        <img src="{{ $blog->images[0] }}" alt="{{ $blog->title }}" class="img-fluid rounded">
                    </div>
                    @endif

                    <!-- Content Preview -->
                    <div class="blog-content">
                        @if($blog->is_premium && !auth()->check())
                            <!-- Show preview for non-authenticated users -->
                            <div class="preview-content">
                                {!! Str::limit(strip_tags($blog->description), 300) !!}
                                <div class="preview-overlay mt-4 p-4 bg-light rounded">
                                    <div class="text-center">
                                        <i class="ti ti-lock fs-1 text-muted mb-3"></i>
                                        <h4>{{ __("lang.site_premium_content") }} Locked</h4>
                                        <p class="text-muted">{{ __("lang.site_subscribe") }} to our premium plan to read the full article.</p>
                                        <a href="{{ url('login') }}" class="btn btn-primary me-2">
                                            <i class="ti ti-login me-1"></i>Login
                                        </a>
                                        <a href="{{ url('membership-plans') }}" class="btn btn-outline-primary">
                                            <i class="ti ti-crown me-1"></i>View Plans
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @elseif($blog->is_premium && auth()->check() && !auth()->user()->hasActiveSubscription())
                            <!-- Show preview for authenticated users without subscription -->
                            <div class="preview-content">
                                {!! Str::limit(strip_tags($blog->description), 300) !!}
                                <div class="preview-overlay mt-4 p-4 bg-light rounded">
                                    <div class="text-center">
                                        <i class="ti ti-crown fs-1 text-warning mb-3"></i>
                                        <h4>{{ __("lang.site_premium_content") }}</h4>
                                        <p class="text-muted">Your current subscription doesn't include access to this content.</p>
                                        <a href="{{ url('membership-plans') }}" class="btn btn-primary">
                                            <i class="ti ti-crown me-1"></i>Upgrade Plan
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Show full content for subscribers -->
                            <div class="full-content">
                                {!! $blog->description !!}
                                
                                @if($blog->is_premium && $blog->premium_content)
                                <div class="premium-section mt-4 p-4 bg-light rounded">
                                    <h4><i class="ti ti-crown text-warning me-2"></i>{{ __("lang.site_premium_content") }}</h4>
                                    {!! $blog->premium_content !!}
                                </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            @if(!$blog->is_premium || (auth()->check() && auth()->user()->hasActiveSubscription()))
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Comments</h5>
                </div>
                <div class="card-body">
                    @auth
                    <form action="{{ url('blog/comment') }}" method="POST" class="mb-4">
                        @csrf
                        <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                        <div class="mb-3">
                            <textarea class="form-control" name="comment" rows="3" placeholder="{{ __("lang.site_share_thoughts") }}"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __("lang.site_post_comment") }}</button>
                    </form>
                    @else
                    <div class="alert alert-info">
                        <a href="{{ url('login') }}">Login</a> to leave a comment.
                    </div>
                    @endauth

                    <!-- Comments List -->
                    @if(isset($comments) && count($comments) > 0)
                    <div class="comments-list">
                        @foreach($comments as $comment)
                        <div class="comment-item border-bottom pb-3 mb-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <img src="{{ $comment->user->photo ? url('uploads/user/'.$comment->user->photo) : asset('uploads/no-image.png') }}" 
                                         alt="{{ $comment->user->name }}" class="rounded-circle" width="40" height="40">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">{{ $comment->user->name }}</h6>
                                    <p class="mb-1">{{ $comment->comment }}</p>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted text-center">{{ __("lang.site_no_comments_yet") }}</p>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Subscription CTA -->
            @if($blog->is_premium)
            <div class="card mb-4 border-warning">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0"><i class="ti ti-crown me-2"></i>Premium Access</h5>
                </div>
                <div class="card-body text-center">
                    <i class="ti ti-crown fs-1 text-warning mb-3"></i>
                    <h5>Unlock {{ __("lang.site_premium_content") }}</h5>
                    <p class="text-muted">{{ __("lang.site_get_access_exclusive_content") }}</p>
                    @auth
                        @if(!auth()->user()->hasActiveSubscription())
                        <a href="{{ url('membership-plans') }}" class="btn btn-warning">
                            <i class="ti ti-crown me-1"></i>{{ __("lang.site_subscribe_now") }}
                        </a>
                        @else
                        <div class="alert alert-success">
                            <i class="ti ti-check me-2"></i>You have premium access!
                        </div>
                        @endif
                    @else
                    <a href="{{ url('login') }}" class="btn btn-warning">
                        <i class="ti ti-login me-1"></i>Login to {{ __("lang.site_subscribe") }}
                    </a>
                    @endauth
                </div>
            </div>
            @endif

            <!-- {{ __("lang.site_related_articles") }} -->
            @if(isset($relatedArticles) && count($relatedArticles) > 0)
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __("lang.site_related_articles") }}</h5>
                </div>
                <div class="card-body">
                    @foreach($relatedArticles as $related)
                    <div class="related-article mb-3">
                        <h6><a href="{{ url('blog/'.$related->slug) }}" class="text-decoration-none">{{ $related->title }}</a></h6>
                        <small class="text-muted">{{ $related->created_at->format('M d, Y') }}</small>
                        @if($related->is_premium)
                        <span class="badge bg-warning ms-2">Premium</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Newsletter Signup -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __("lang.site_stay_updated") }}</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">{{ __("lang.site_get_latest_articles_updates") }}</p>
                    <form>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="{{ __("lang.site_enter_your_email") }}">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">{{ __("lang.site_subscribe") }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.preview-overlay {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: 2px dashed #dee2e6;
}

.premium-section {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    border-left: 4px solid #ffc107;
}

.comment-item:last-child {
    border-bottom: none !important;
}

.related-article:hover h6 a {
    color: #696cff !important;
}
</style>
@endpush 