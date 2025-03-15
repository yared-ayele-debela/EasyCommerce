<div>
    @php
    $user = Auth::guard('admin')->user();
    @endphp
<div class="pagetitle bg-light shadow-sm">
    <nav>
        <ol class="breadcrumb p-3">
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">withdraw requests</li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <h5><strong>Your recently withdraw requests</strong></h5>
            </div>
            <div class="card-body mt-2">
                <table class="table mt-2" id="example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Withdraw Amount</th>
                            <th>Status</th>
                            <th>Description</th>
                            <th>Recepit</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                        <tr>
                                <td>{{ $request->id }}</td>
                                <td>{{ $request->amount }}</td>
                                <td>
                                    @if($request->status==="rejected")
                                    <button class="btn btn-sm btn-danger">
                                        {{ $request['status']}}
                                    </button>
                                    @endif
                                    @if($request->status==="approved")
                                    <button class="btn btn-sm btn-success">
                                        {{ $request['status']}}
                                    </button>
                                    @endif
                                    @if($request->status==="pending")
                                    <button class="btn btn-sm text-white btn-warning">
                                        {{ $request['status']}}
                                    </button>
                                    @endif
                                </td>
                                 <td>
                                    @if($request->description)
                                    <strong>Description:</strong> {{ $request->description }} <br>
                                @endif
                                 </td>
                                  <td>
                                    @if($request->receipt)
                                    <strong>Receipt:</strong> <a href="{{ Storage::url($request->receipt) }}" target="_blank">View Receipt</a> <br>
                                    @endif
                                  </td>
                                <td>
                                   {{ $request->created_at }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
               </div>
           </div>
      </div>
      <div class="col-md-4">
        @if ($user && $user->hasPermissionByRole('add withdrawal request'))
        <div class="card">
            <div class="card-header">
                @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                <h5>Send Withdrawal Request</h5>
            </div>
            <div class="card-body mt-2">
                    <form wire:submit.prevent="createRequest">
                        <div class="form-group mb-2">
                            <label for="amount">Amount</label>
                        <input type="text" id="amount" wire:model="amount" class="form-control" placeholder="100">
                        @error('amount')
                        <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Create Request</button>
                    </form>
                </div>
            </div>
        @endif
     </div>
    </div>

</section>


</div>
