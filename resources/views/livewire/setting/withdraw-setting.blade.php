<div>
    @php
    $user = Auth::guard('admin')->user();
    @endphp
    <div class="pagetitle bg-light shadow-sm">
        <nav>
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">tax settings</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                        @endif
                        @if(count($withdrawals)<1)
                        <button wire:click="create()" class="btn btn-primary">Create Minimum Amount Withdrawal</button>
                        @endif
                        @if($isCreateModalOpen)
                        @include('livewire.withdraw_setting.create-withdrawal')
                        @endif
                        @if($isDeleteModalOpen)
                        @include('livewire.withdraw_setting.delete-withdrawal')
                        @endif
                    </div>
                    <div class="card-body mt-2">
                        <table class="table mt-2" id="example">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($withdrawals as $withdrawal)
                                <tr>
                                    <td>{{ $withdrawal->id }}</td>
                                    <td>{{ $withdrawal->amount }}</td>
                                    <td>
                                        <button class="btn btn-sm {{ $withdrawal['status'] ? 'btn-success' : 'btn-danger' }}">
                                            {{ $withdrawal['status'] ? 'Active' : 'Inactive' }}
                                        </button>
                                    </td>
                                    <td>
                                        <button wire:click="edit({{ $withdrawal->id }})" class="btn btn-primary btn-sm"><i class=" ri ri-pencil-fill"></i></button>
                                        <button wire:click="confirmDelete({{ $withdrawal->id }})" class="btn btn-danger btn-sm"><i class="ri-delete-bin-6-fill"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                   </div>
                </div>
            </div>
        </div>
    </section>
</div>

