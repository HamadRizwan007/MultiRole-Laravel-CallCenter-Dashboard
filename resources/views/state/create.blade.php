<x-dashboard-layout>
    <x-slot name="pageTitle">Create State</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('state.index') }}">States</a></li>
        <li class="breadcrumb-item active">Create State</li>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-md-4">
            <form class="card" action="{{ route('state.store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="card-header"><strong>Create State</strong></div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">State Name</label>
                        <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text" placeholder="Enter the state name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="code">State Code</label>
                        <input class="form-control @error('code') is-invalid @enderror" id="code" name="code" type="text" placeholder="Enter the state code" value="{{ old('code') }}" minlength="2" maxlength="5" required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Create</button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-layout>
