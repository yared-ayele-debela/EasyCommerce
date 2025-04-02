@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container offer-card shadow-sm my-3 py-3">
    <div class="page-faq u-s-p-t-30">
        <div class="u-s-m-b-50">
            <div class="about-us-content">
                <p class="peragraph-blog"></p>
                <h2 class="text-dark">{{ $cmsPageDetails['title'] }}</h2>
                <p class="text-dark">
                    <?php echo nl2br($cmsPageDetails['description']); ?>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

