@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container py-4">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 fw-bold text-dark">Frequently Asked Questions</h5>
    </div>
    <div class="accordion" id="faqAccordion">
        @foreach ($allfaq as $index => $faq)
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading-{{$index}}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{$index}}" aria-expanded="false" aria-controls="faq-{{$index}}">
                    {{ $faq['question'] }}
                </button>
            </h2>
            <div id="faq-{{$index}}" class="accordion-collapse collapse" aria-labelledby="heading-{{$index}}" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <strong>Answer:</strong> {{ $faq['answer'] }}
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="text-center mt-4">
        <p class="fs-5">Can't find your answer?
            <a href="{{ url('/contact') }}" class="btn btn-primary rounded rounded-1 ms-2">Contact Us</a>
        </p>
    </div>
</div>
<!--container-->
@endsection
