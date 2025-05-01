<div>
    @php
    $user = Auth::guard('admin')->user();
    @endphp
    <div class="pagetitle bg-light shadow-sm">
        <nav>
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">All sales users</li>
            </ol>
        </nav>
    </div>
    <section class="section" >
        <div class="card">
            <div class="card-header">
                @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
                @endif
                @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                <button wire:click="create()" class="btn btn-primary">Create Sales User</button>
                <button wire:click="add_commission()" class="btn btn-info text-white">{{ $salesUsersCommission?'Update':'Create' }} Sales commission</button>

            </div>
            <div class="card-body mt-2">
                <table class="table mt-2" id="example">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Referral Token</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($salesUsers as $salesUser)
                            <tr>
                                <td>{{ $salesUser->id }}</td>
                                <td>{{ $salesUser->name }}</td>
                                <td><img src="{{ $salesUser->image }}" width="50" alt="{{ $salesUser->name }}"></td>
                                <td>{{ $salesUser->phone }}</td>
                                {{-- <td>{{ $salesUser->address }}</td> --}}
                                <td><!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $salesUser->id }}">
                                      View
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal{{ $salesUser->id }}" tabindex="-1" aria-labelledby="exampleModal{{ $salesUser->id }}Label" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModal{{ $salesUser->id }}Label"></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">
                                            @if($salesUser->referral_token)
                                            <div class="border p-2 rounded">
                                                <div class="d-flex justify-content-center">
                                                    <p class="js-copytextarea pt-2"> {{ $salesUser->referral_token }} </p>

                                                </div>
                                            </div>
                                            @else
                                             <p>Token not found</p>
                                            @endif

                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </td>
                                {{-- <td>{{ $salesUser->referral_token }}</td> --}}
                                <td>{{ $salesUser->email }}</td>
                                <td>
                                    <button wire:click="update_status({{ $salesUser['id'] }})" class="btn btn-sm {{ $salesUser['status'] ? 'btn-success' : 'btn-danger' }}">
                                        {{ $salesUser['status'] ? 'Active' : 'Inactive' }}
                                    </button>
                                </td>
                                <td>
                                    <button wire:click="generateToken({{ $salesUser->id }})" class="btn {{ $salesUser->referral_token ? "btn-warning text-white" : "btn-success"  }} btn-sm">
                                      {{ $salesUser->referral_token ? "Update Token" : "Generate Token"  }}
                                    </button>
                                    <button wire:click="edit({{ $salesUser->id }})" class="btn btn-primary btn-sm"><i class="ri-ball-pen-fill"></i>
                                    </button>
                                    <button wire:click="delete({{ $salesUser->id }})" class="btn btn-danger btn-sm"> <i class="ri-delete-bin-6-fill"></i>
                                    </button>
                                    <a href="{{ route('salesuser.view', $salesUser->id) }}" class="btn btn-secondary btn-sm"> <i class="ri-eye-fill"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($isModalOpen)
            <div class="modal fade show d-block" style="background-color: rgba(0, 0, 0, 0.5);" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $salesUserId ? 'Edit Sales User' : 'Create Sales User' }}</h5>
                            <button type="button" class="close btn" wire:click="closeModal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" wire:model="name">
                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" class="form-control" id="image" wire:model="image">
                                    @if($currentImage)
                                    <div class="mb-2 mt-2">
                                        <img src="{{ $currentImage }}" width="100" alt="Current Image">
                                    </div>
                                    @endif
                                    @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" wire:model="phone">
                                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" wire:model="address">
                                    @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" wire:model="email">
                                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" wire:model="password">
                                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeModal">Close</button>
                            <button type="button" class="btn btn-primary" wire:click="store">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if($CommissionModalOpen)
        <div class="modal fade show d-block" style="background-color: rgba(0, 0, 0, 0.5);" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $salesUsersCommission?'Update':'Create' }} Commision for Sales Man</h5>
                        <button type="button" class="close btn" wire:click="closeModal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="store_commission">
                            <div class="form-group mb-4">
                                <label for="commission_amount">Enter Commission Amount (%)</label>
                                <input type="number" class="form-control" id="commission_amount" wire:model="commission_amount"  placeholder="1%">
                                @error('commission_amount') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            @if($salesUsersCommission)
                            <p>current commission per product : {{ $salesUsersCommission->commission_amount }} % </p>
                            @endif
                            <button type="button" class="btn btn-secondary" wire:click="closeModal">Close</button>
                            <button type="submit" class="btn btn-primary" >Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if($isDeleteModalOpen)
        <div wire:ignore.self id="deleteProductModal" class="modal fade show d-block" style="background-color: rgba(0, 0, 0, 0.5);" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content shadow-lg rounded">
                    <form wire:submit.prevent="destroyProduct">
                        <div class="modal-body">
                            <div class="text-center">
                                <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size: 3rem;"></i>
                                <h5 class="mt-3">Are you sure you want to delete this sales user?</h5>
                            </div>
                        </div>
                        <div class="modal-footer border-0 justify-content-center">
                            <button type="button" class="btn btn-secondary" wire:click="closeModal" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Yes! Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </section>

</div>
