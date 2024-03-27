<x-dashboard-layout>
    <x-slot name="pageTitle">Agent Profile</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('agent.index') }}">Agents</a></li>
        <li class="breadcrumb-item active">Show</li>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <div class="w-50">
                        <img class="c-avatar-img" src="{{ $agent->avatar_url }}" alt="{{ ucfirst($agent->name) }}">
                    </div>
                    <h1 class="mt-2">{{ $agent->name }}</h1>
                    <p><strong>Email: </strong><a href="mailto:{{ $agent->email }}">{{ $agent->email }}</a></p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <table class="table table-striped table-responsive-md">
                        <tr>
                            <th>First Name</th>
                            <td>{{ $agent->fname }}</td>
                        </tr>
                        <tr>
                            <th>Last Name</th>
                            <td>{{ $agent->lname }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $agent->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $agent->phone ?? 'NA' }}</td>
                        </tr>
                        <tr>
                            <th>Call Center</th>
                            @if($agent->call_center)
                                <td>{{ $agent->call_center->center_name }}</td>
                            @else
                                <td>NA</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Registered At</th>
                            <td>{{ $agent->created_at->setTimezone(auth()->user()->timezone)->format('d M Y h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
