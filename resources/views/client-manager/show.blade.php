<x-dashboard-layout>
    <x-slot name="pageTitle">Manager Profile</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('client-manager.index') }}">Managers</a></li>
        <li class="breadcrumb-item active">Show</li>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <div class="w-50">
                        <img class="c-avatar-img" src="{{ $manager->avatar_url }}" alt="{{ ucfirst($manager->name) }}">
                    </div>
                    <h1 class="mt-2">{{ $manager->name }}</h1>
                    <p><strong>Email: </strong><a href="mailto:{{ $manager->email }}">{{ $manager->email }}</a></p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <table class="table table-striped table-responsive-md">
                        <tr>
                            <th>First Name</th>
                            <td>{{ $manager->fname }}</td>
                        </tr>
                        <tr>
                            <th>Last Name</th>
                            <td>{{ $manager->lname }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $manager->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $manager->phone ?? 'NA' }}</td>
                        </tr>
                        <tr>
                            <th>Client</th>
                            @if($manager->client)
                                <td>{{ $manager->client->name }}</td>
                            @else
                                <td>NA</td>
                            @endif
                        </tr>
                        <tr>
                            <th>View Permissions</th>
                            <td>{{ ucwords(implode(", ", $manager->view_permissions ?? [])) }}</td>
                        </tr>
                        <tr>
                            <th>Registered At</th>
                            <td>{{ $manager->created_at->setTimezone(auth()->user()->timezone)->format('d M Y h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
