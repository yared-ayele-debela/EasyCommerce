<div>
    <?php
        use App\Models\Vendor;
   ?>
    @php
    $user = Auth::guard('admin')->user();
    @endphp
    <div class="pagetitle bg-light shadow-sm">
        <nav>
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">all withdraw requests</li>
            </ol>
        </nav>
    </div>
    <section class="section" >
        <div class="card">
            <div class="card-header">
                @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

            </div>
            <div class="card-body mt-2">
                <table class="table mt-2" id="example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Vendor Name</th>
                            <td>Image</td>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                        @php
                            $vendor=Vendor::where('id',$request->vendor->vendor_id)->first();
                        @endphp
                            <tr>
                                <td> <a href="{{ url('admin/vendors/details/'.$vendor->id) }}" target="_blank"><i class=" ri ri-eye-line text-white bg-secondary p-1 rounded"></i></a> {{ $request->id }}</td>
                                <td>{{ $request->vendor->name }}</td>
                                <td>
                                    <img src="{{ $request->vendor->image }}" width="36px" alt="Profile" class="rounded-circle">
                                </td>
                                <td>{{ $request->vendor->mobile }}</td>
                                <td>
                                  {{ $request->vendor->email }}
                                </td>
                                <td>
                                    {{ $request->amount }}
                                </td>
                                <td>
                                    @if($request->status==="rejected")
                                    <button class="btn btn-danger btn-sm">Rejected</button>
                                    @endif
                                    @if($request->status==="pending")
                                    <button class="btn btn-primary btn-sm">Pending</button>
                                    @endif
                                    @if($request->status==="approved")
                                    <button class="btn btn-success btn-sm">Approves</button>
                                    @endif
                                </td>
                                <td class="d-flex">
                                    @if($request->status!=="pending")
                                    @if($request->status==="rejected")
                                    <button class="btn btn-danger btn-sm" disabled>Rejected</button>
                                    @endif
                                    @if($request->status==="approved")
                                    <button class="btn btn-success btn-sm" disabled>Approved</button>
                                    @endif
                                    @else
                                    <button class="btn btn-success btn-sm" wire:click="approveRequest({{ $request->id }})">Approve</button> &nbsp;
                                    <button class="btn btn-danger btn-sm" wire:click="rejectRequest({{ $request->id }})">Reject</button>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($isModalOpen)
            <div class="modal fade show d-block" style="background-color: rgba(0, 0, 0, 0.5);" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form wire:submit.prevent="confirmApproveRequest">
                            <div class="modal-header">
                                <h5 class="modal-title">Approve Withdrawal Request</h5>
                                <button type="button" class="close btn" wire:click="closeModal" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-2">
                                    <label for="receipt">Receipt</label>
                                    <input type="file" id="receipt" wire:model="receipt" class="form-control">
                                    @error('receipt') <span class="text-danger">{{ $message }}</span> @enderror
                                    <div wire:loading wire:target="receipt">Uploading...</div>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="description">Note</label><br>
                                    {{-- <input type="text" id="description" wire:model="description" class="form-control"> --}}
                                    <textarea id="description" wire:model="description" class="form-control" cols="30" rows="3"></textarea>
                                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" wire:click="closeModal" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit"  class="btn btn-primary">Approve</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif


       @if($isRejectModalOpen)
        <div class="modal fade show d-block" style="background-color: rgba(0, 0, 0, 0.5);" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form wire:submit.prevent="confirmRejectRequest">
                        <div class="modal-header">
                            <h5 class="modal-title">Reject Withdrawal Request</h5>
                            <button type="button" class="close btn" wire:click="closeRejectModal" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="description">Note</label>
                                <textarea id="description" wire:model="description" class="form-control" cols="30" rows="3"></textarea>
                                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeRejectModal" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Reject</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

    </section>

</div>
