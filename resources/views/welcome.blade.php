<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <title>{{setting('site_seo_title')}}</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('site-assets/css/styles.css')}}">
    <link rel="icon" type="image/x-icon" href="{{url('uploads/setting/'.setting('site_favicon'))}}" />
</head>
<body id="top" class="ss-preload theme-static">
    <div id="preloader">
        <div id="loader" class="dots-fade">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <section id="intro" class="s-intro">
        <div class="s-intro__bg"></div>
        <header class="s-intro__header"> 
            <div class="s-intro__logo">
                <a class="logo" href="{{url('/')}}">
                    <img src="{{ url('uploads/setting/'.setting('site_logo'))}}" alt="{[setting('site_name')]}" onerror="this.onerror=null;this.src=`{{ asset('uploads/no-logo-image.png') }}`">
                </a>
            </div>
        </header> 
        <div class="row s-intro__content">
            <div class="column">
                <?php $maintenanceModeTitle = DB::table('settings')->where('key', 'maintainance_title')->value('value'); ?>
                <div class="text-pretitle">
                    {{$maintenanceModeTitle}}
                </div>
                <?php $maintenanceModeText = DB::table('settings')->where('key', 'maintainance_short_text')->value('value'); ?>
                <h1 class="text-huge-title">
                    {{$maintenanceModeText}}
                </h1>
            </div>
        </div>
    </section>

</body>
</html>