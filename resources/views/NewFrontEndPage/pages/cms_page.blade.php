@extends('fontend.layout.layout')
@section('content')
<div class="container p-3 mt-3 shadow-sm">
    <div class="rounded p-4" style="background-color:#F5F9FF">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="" style="color:#1E665E;">{{ $cmsPageDetails['title'] }}</h1>
            </div>

        </div>
    </div>
</div>

<div class="container  shadow-sm mb-3 pb-3">
    <div class="page-faq u-s-p-t-30">
            <div class="u-s-m-b-50">
            <div class="about-us-content">
                <p class="peragraph-blog"></p><h2>{{ $cmsPageDetails['title'] }}</h2>
                <p>
                <?php echo nl2br($cmsPageDetails['description']); ?>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
