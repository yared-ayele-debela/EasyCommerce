@extends('admindashboard.maindashboard')
@section('dashboard')

<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Send Email</li>
        </ol>
    </nav>
</div>
<section class="section col-md-12">
    <div class="card border-0">
        <div class="card-body pt-3">
            <h5 class="card-title">Send Mail To All Newsletter Subscriber</h5>

            <form class="g-3" action="{{ route('send-email-to-all-users') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                    <label for="subject" class="form-label">Subject </label>
                    <input type="text" class="form-control" name="subject">
                    @error('name')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="message" class="mb-2 mt-2">Message</label>
                    <textarea name="message" id="description" cols="30" rows="10"></textarea>
                </div>
                <div class="form-group pt-3 ">
                    <input type="submit" class=" btn btn-primary pt-2 pb-2 shadow" value="Send Email">
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
</section>
@endsection

