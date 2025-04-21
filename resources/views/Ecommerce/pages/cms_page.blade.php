@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
         </button>
        <h5 class="my-4 text-dark text-center">{{ $cmsPageDetails['title'] }}</h5>
    </div>
</div>
<div class="container offer-card shadow-sm mb-3 p-4">
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

