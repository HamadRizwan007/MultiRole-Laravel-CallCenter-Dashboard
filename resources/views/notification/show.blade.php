<x-dashboard-layout>
    <x-slot name="pageTitle">My Profile</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Profile</li>
    </x-slot>

    <div class="row justify-content-center">
        @error('details')
            <div class="col-md-12">
                <div class="alert alert-warning alert-dismissible fade show mx-auto" role="alert" style="width: max-content; max-width: 640px;">
                    <strong>Warning!</strong> {{ $message }}
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
            </div>
        @enderror
        <div class="col-md-4">
            <div class="card">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <div class="w-50">
                        <img class="c-avatar-img" src="{{ $user->avatar_url }}" alt="{{ ucfirst($user->name) }}">
                    </div>
                    <h1 class="mt-2">{{ $user->name }}</h1>
                    <p><strong>Email: </strong><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
                    <div>
                        @if($user->hasRole('client'))
                            <a class="btn btn-info" href="{{ route('client.edit', $user) }}">Edit Profile</a>
                        @endif
                        @if($user->hasRole('client agent'))
                            <a class="btn btn-info" href="{{ route('client-agent.edit', $user) }}">Edit Profile</a>
                        @endif
                        @if($user->hasRole('call center'))
                            <a class="btn btn-info" href="{{ route('call-center.edit', $user) }}">Edit Profile</a>
                        @endif
                        @if($user->hasRole('agent'))
                            <a class="btn btn-info" href="{{ route('agent.edit', $user) }}">Edit Profile</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if(isset($user_request))
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Requested Changes</div>
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        {!! str_replace("\r\n", "<br>", $user_request) !!}
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-dashboard-layout>
