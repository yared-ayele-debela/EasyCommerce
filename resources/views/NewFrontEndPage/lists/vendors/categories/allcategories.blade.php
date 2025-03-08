
@extends('fontend.layout.layout')
@section('content')
<style>
    .card-img-tiles {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        position: relative;
        background-color: #fff;
        z-index: 5
    }

    .card-img-tiles .main-img>img,
    .card-img-tiles .thumblist>img {
        display: block;
        width: 100%
    }

    .card-img-tiles .main-img {
        width: 67%;
        padding-right: .375rem
    }

    .card-img-tiles .thumblist {
        width: 33%;
        padding-left: .375rem
    }

    .card-img-tiles .thumblist>img {
        margin-bottom: .75rem
    }

    .card-img-tiles .thumblist>img:last-child {
        margin-bottom: 0
    }

    .mb-grid-gutter {
        margin-bottom: 30px !important;
    }

    .cont {
    gap: 30px;
    width: 60%;
    border-radius: 5px;
    padding: 30px;
    }
    .counter{
    display: flex;
    gap: 30px;
    margin-top: 30px;
    }


    .box span{
    font-size: 30px;
    }
    .box p{
    margin: 0;
    }
    .name{
    display: flex;
    gap: 40px;
    }

    .store-banner {
    width: 100%;
    height: 60px;
    object-fit: cover;
    }

    .seller-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 50%;
    position: absolute;
    left: 20px;
    top: 90%;
    border: 5px solid rgb(255, 255, 255);
    transform: translateY(-50%);
    }

/* for flash deal banner */
.position-relative {
    position: relative;
}

.overlay-text {
    position: absolute;
    top: 50%; /* Adjust this value to position the text vertically */
    left: 50%; /* Adjust this value to position the text horizontally */
    transform: translate(-50%, -50%);
    text-align: center; /* Adjust text alignment as needed */
    color: white; /* Text color */
    /* Additional styling */
    background: #1E665E; /* Background color for better readability */
    padding: 10px;
    border-radius: 5px; /* Add border-radius for style */
}
.cards {
     border:none;
    /* border: 0.5px solid #DCDCDD; */
    margin: 10px 4px;
    transition: .6s ease;
    }

    .cards:hover {
    transform: scale(1.05);
    }



    div.scrollcards .card {
    display: inline-block;
    padding: 7px;
    text-decoration: none;
    height: auto;
    /* width: 300px; */
    }
    .circle-image {
    text-align: center;
    }

    .circle-image img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 10px;
    }

    .circle-image p {
    /* font-weight: bold; */
    }

</style>

<div class="container shadow-sm p-3 mt-3 mb-3">
    <div class="d-flex justify-content-between pb-2">
        <div class="text-left">
            <h3 class="sec-maker-h4 text-left text-dark " ><b>ALL CATEGORIES</b></h3>
        </div>

    </div>
    <div class="row">
        <div class="scrollcards">
            @foreach ($categories as $category)
            <div class="card cards " style="border:0.5px solid #E7F2F1;">
                <div class="circle-image">
                <div class="">
                     <a href="{{ url('category/'.$category['id']) }}">
                    @if($category['image'])
                    <img src="{{ asset('/storage/category/'.$category['image']) }}" class="img-fluid">
                    @else
                    <img src="{{ asset('new_frontend/images/banners/b1.png') }}" class="img-fluid">
                    @endif
                </a>
                    <p>{{ $category['name'] }}</p>
                </div>
                </div>
            </div>
            @endforeach

         </div>
         <div class="col-md-12 d-flex justify-content-end ">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection




