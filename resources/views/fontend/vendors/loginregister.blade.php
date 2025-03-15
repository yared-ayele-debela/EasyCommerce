@extends('fontend.layout')
@section('content')
<div class="container">
    <div class="row justify-content-center">
       <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
          <div class="d-flex justify-content-center pt-4"></div>
          <div class="card mb-3">
             <div class="card-body">
                <div class="pt-4 pb-2">
                   <h5 class="card-title text-center pb-0 fs-4">Login With  Your Vendor Account</h5>
                   <p class="text-center small">Enter your personal details to create account</p>
                </div>
                <form class="row g-3 needs-validation" method="POST" action="{{ url('admin/login') }}" >
                    @csrf
                   <div class="col-12">
                      <label for="email" class="form-label">Your Email</label>
                      <input type="email" name="email" class="form-control" id="email" required="">
                      <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                   </div>

                   <div class="col-12">
                      <label for="password" class="form-label">Password</label> <input type="password" name="password" class="form-control" pattern=".{8,}" title="8 or more characters" id="yourPassword" required="">
                      <div class="invalid-feedback">Please enter your password!</div>
                   </div>

                   <div class="col-12"> <button class="btn btn-primary w-100" type="submit">Login</button></div>

                </form>
             </div>
          </div>
       </div>
       <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
        <div class="d-flex justify-content-center pt-4"></div>
        <div class="card mb-3">
           <div class="card-body">
              <div class="pt-4 pb-2">
                 <h5 class="card-title text-center pb-0 fs-4">Create an for Vendor Account</h5>
                 <p class="text-center small">Enter your personal details to create vendor account</p>
              </div>
              <form class="row g-3 needs-validation" action="{{ url('/vendor/register') }}" method="POST" >
                @csrf
                 <div class="col-12">
                    <label for="yourName" class="form-label">Your Name</label>
                    <input type="text" name="name" class="form-control" id="yourName" pattern="^[A-Za-z]+$"  title="Insert only alphabet" required="">
                    @error('name')
                            <small class=" text-danger">{{ $message }}</small>
                    @enderror
                 </div>
                 <div class="col-12">
                    <label for="yourPhone" class="form-label">Your Phone</label>
                    <input type="number" name="phone" class="form-control" id="yourPhone" required="">
                    @error('phone')
                            <small class=" text-danger">{{ $message }}</small>
                    @enderror
                 </div>
                 <div class="col-12">
                    <label for="yourEmail" class="form-label">Your Email</label> <input type="email" name="email" class="form-control" id="yourEmail" required="">
                    @error('email')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                 </div>
                 <div class="col-12">
                    <label for="yourPassword" class="form-label">Password</label>
                     <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                     title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" name="password" class="form-control" id="yourPassword" required="">
                    @error('password')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                 </div>
                 <div class="col-12">
                    <div class="form-check">
                       <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required=""> <label class="form-check-label" for="acceptTerms">I agree and accept the <a href="#">terms and conditions</a></label>
                       <div class="invalid-feedback">You must agree before submitting.</div>
                    </div>
                    @error('terms')
                    <small class=" text-danger">{{ $message }}</small>
                    @enderror
                 </div>
                 <div class="col-12"> <button class="btn btn-primary w-100" type="submit">Create Account</button></div>

              </form>
           </div>
        </div>
     </div>
    </div>
 </div>

@endsection
