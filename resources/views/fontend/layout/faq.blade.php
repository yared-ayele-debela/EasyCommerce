@extends('fontend.layout.layout')
@section('content')


<div class="container p-3 mt-3  mb-3 shadow-sm">
    <div class="rounded p-4" style="background-color:#E7F2F1">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3 class="" style="color:#1E665E;">FREQUENTLY QUESTIONS</h3>
                <p  style="color:#1E665E;">Below are frequently asked questions, you may find the answer for yourself.</p>
            </div>

        </div>
    </div>
</div>

<div class="container  shadow-sm mb-3 pb-3">
    <div class="page-faq u-s-p-t-30">
            <div class="u-s-m-b-50">
                @foreach ($allfaq as $index => $faq )
                <div class="f-a-q u-s-m-b-30">
                    <a data-toggle="collapse" href="#faq-{{$index}}">{{$faq['question']}}</a>
                    <div class="collapse" id="faq-{{$index}}">
                        <p>
                          Answer : {{ $faq['answer'] }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-left">
                <p>Can't find your answers? <a href="{{ url('/contact') }}" style="color:rgb(0, 0, 0)">Contact Us</h5>
                </a>
            </div>
    </div>
</div>

<!--container-->
@endsection
