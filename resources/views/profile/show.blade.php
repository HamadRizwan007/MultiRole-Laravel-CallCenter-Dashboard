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
                    @if(!auth()->user()->hasRole('admin'))
                        <div>
                            <button class="btn btn-info" type="button"  data-toggle="modal" data-target="#updateProfileRequest">Request Update</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <table class="table table-striped table-responsive-md">
                        <tr>
                            <th>First Name</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $user->phone ?? 'NA' }}</td>
                        </tr>
                        @if(auth()->user()->hasRole('call center'))
                            <tr>
                                <th>Center Name</th>
                                <td>{{ auth()->user()->center_name }}</td>
                            </tr>
                        @endif
                        @if(auth()->user()->hasRole('client agent'))
                            <tr>
                                <th>Client</th>
                                <td>{{ auth()->user()->client->name ?? 'NA' }}</td>
                            </tr>
                        @endif
                        @if(auth()->user()->hasRole('agent'))
                            <tr>
                                <th>Client</th>
                                <td>{{ auth()->user()->call_center->center_name ?? 'NA' }}</td>
                            </tr>
                        @endif
                        @if(auth()->user()->address_line)
                            <tr>
                                <th>Address</th>
                                <td>{{ auth()->user()->full_address }}</td>
                            </tr>
                        @endif
                        @if (auth()->user()->hasRole('client'))
                            <tr>
                                <th>DID Number</th>
                                <td>{{ auth()->user()->did_number ?? 'NA' }}</td>
                            </tr>
                            <tr>
                                <th>Lead Transfer Type</th>
                                <td>{{ auth()->user()->lead_request_type_text ?? 'NA' }}</td>
                            </tr>
                            <tr>
                                <th>Daily Leads</th>
                                <td>{{ auth()->user()->lead_request_cap ?? 'Unlimited' }}</td>
                            </tr>
                            <tr>
                                <th>Assigned States</th>
                                <td>{{ auth()->user()->lead_state_names }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Registered At</th>
                            <td>{{ $user->created_at->setTimezone(auth()->user()->timezone)->format('d M Y h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if (auth()->user()->hasAnyRole(['admin', 'client broker', 'client']))
        <div class="row justify-content-center">
            @if(auth()->user()->lead_instructions)
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="h2">Lead Instructions</h4>
                        </div>
                        <div class="card-body">
                            {!! str_replace(["\n", "\n\r", "\xA0", "&#160;"], "<br>", auth()->user()->lead_instructions) !!}
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="mb-0">Timetable ({{ auth()->user()->timezone }})</h4>
                        @role('admin')
                        <div>
                            @if(auth()->user()->client_timetable)
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#updateTimetableModal">Update Timetable</button>
                            @else
                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#createTimetableModal">Create Timetable</button>
                            @endif
                        </div>
                        @endrole
                    </div>
                    <div class="card-body">
                        @if(auth()->user()->client_timetable)
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Sr #</th>
                                    <th>Day</th>
                                    <th>Lead Count</th>
                                    <th>Timing</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (\App\Models\ClientTimetable::$weekdays as $day => $number)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $day }}</td>
                                        <td>{{ $client->client_timetable->{Str::lower($day."_lead_count")} ?? 0 }}</td>
                                        <td>
                                            @if(auth()->user()->client_timetable->{Str::lower($day."_timing")} != 3)
                                                {{ \App\Models\ClientTimetable::$dayTimingOptions[auth()->user()->client_timetable->{Str::lower($day)."_timing"}] }}
                                            @else
                                                <div class="d-flex flex-wrap justify-content-start align-items-center">
                                                    @foreach (auth()->user()->client_timetable->{Str::lower($day)."_time_sets"} as $set)
                                                        <div class="mr-2">
                                                            <strong>Start: </strong> {{ now()->setTimeFromTimeString($set['start'])->format('h:i A') }}<br>
                                                            <strong>End: </strong> {{ now()->setTimeFromTimeString($set['end'])->format('h:i A') }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            <p>No timetable set for the client!</p>
                            <p class="font-weight-bold">Leads can be transfered to the client at any time.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(!auth()->user()->hasRole('admin'))
        <div class="modal fade" id="updateProfileRequest" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-primary" role="document">
                <div class="modal-content">
                    <form action="{{ route('profile.request-profile-change') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title">Request a profile Amendment</h4>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <label for="details">What do you want to change?</label>
                            <textarea name="details" id="details" class="form-control" rows="10" placeholder="Describe the changes you want done to your profile.">{{ old('details') }}</textarea>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit">Send Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</x-dashboard-layout>
