<?php
set_time_limit(0);
ini_set('max_execution_time', 180);
?>
<x-dashboard-layout>
    <x-slot name="pageTitle">Clients | Analytics</x-slot>
    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('analytics.index') }}">Analytics</a></li>
        <li class="breadcrumb-item active">Client</li>
    </x-slot>
    <x-slot name="scripts">
        <script>
            $(document).ready(function () {
                $('#allClients').DataTable();
            });
        </script>
    </x-slot>
    <div>
        <div class="row">
            <div class="col-6 col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="text-value-lg">{{ $data_count['all_leads'] }} / {{ $data_count['rejected_leads'] }}</div>
                        <div>Total Leads / Rejected Leads</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="text-value-lg">{{ $data_count['assigned_leads'] }} / {{ $data_count['unassigned_leads'] }}</div>
                        <div>Assigned / Unassigned</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="text-value-lg">{{ $data_count['leads_this_month'] }}</div>
                        <div>Leads This Month</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <div class="text-value-lg">{{ $data_count['total_today'] }}</div>
                        <div>Total Today</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3>Client Leads</h3>
                <div class="text-danger">
                    The following calculations do not include Rejected Leads.
                    <br>
                    The month, week & day time calculations has been adjusted according to client's timezone.
                </div>
            </div>
            <div class="card-body">
                <table id="allClients" class="table table-striped table-responsive-lg" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr #</th>
                            <th>Client</th>
                            <th>Has External API</th>
                            <th>Leads<br><em>Total</em></th>
                            <th>Leads<br><em>This Month</em></th>
                            <th>Leads<br><em>Last Week</em></th>
                            <th>Leads<br><em>This Week</em></th>
                            <th>Leads<br><em>Yesterday</em></th>
                            <th>Leads<br><em>Today</em></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr>
                                <td>{{ $clients->firstItem()+$loop->index }}</td>
                                <td>
                                    <div><a href="{{ route('client.show', $client->id) }}">{{ $client->name }}</a></div>
                                    <strong class="text-muted">{{ $client->email }}</strong>
                                </td>
                                <td>
                                    @if ($client->api_url)
                                        Yes
                                    @else
                                        No
                                    @endif
                                </td>
                                <td>{{ $client->leads->whereIn('status', [1, 2, 3])->count() }}</td>
                                <td>{{ $client->leads->whereIn('status', [1, 2, 3])->filter(function($lead) use($client){
                                    return $lead->assigned_time->copy()->setTimezone($client->timezone)->between(now()->copy()->startOfMonth()->setTimeFromTimeString("00:00:00"), now()->copy()->setTimezone($client->timezone)->endOfMonth()->setTimeFromTimeString("23:59:59"));
                                })->count() }}</td>
                                <td>{{ $client->leads->whereIn('status', [1, 2, 3])->filter(function($lead) use($client){
                                    return $lead->assigned_time->copy()->setTimezone($client->timezone)->between(now()->copy()->setTimezone($client->timezone)->startOfWeek(\Carbon\Carbon::MONDAY)->subWeek()->setTimeFromTimeString("00:00:00"), now()->copy()->setTimezone($client->timezone)->endOfWeek(\Carbon\Carbon::SUNDAY)->subWeek()->setTimeFromTimeString("23:59:59"));
                                })->count() }}</td>
                                <td>{{ $client->leads->whereIn('status', [1, 2, 3])->filter(function($lead) use($client){
                                    return $lead->assigned_time->copy()->setTimezone($client->timezone)->between(now()->copy()->startOfWeek(\Carbon\Carbon::MONDAY)->setTimeFromTimeString("00:00:00"), now()->copy()->setTimezone($client->timezone)->endOfWeek(\Carbon\Carbon::SUNDAY)->setTimeFromTimeString("23:59:59"));
                                })->count() }}</td>
                                <td>{{ $client->leads->whereIn('status', [1, 2, 3])->filter(function($lead) use($client){
                                    return $lead->assigned_time->copy()->setTimezone($client->timezone)->between(now()->yesterday()->setTimeFromTimeString("00:00:00"), now()->copy()->setTimezone($client->timezone)->yesterday()->setTimeFromTimeString("23:59:59"));
                                })->count() }}</td>
                                <td>{{ $client->leads->whereIn('status', [1, 2, 3])->filter(function($lead) use($client){
                                    return $lead->assigned_time->copy()->setTimezone($client->timezone)->between(now()->copy()->setTimezone($client->timezone)->setTimeFromTimeString("00:00:00"), now()->copy()->setTimezone($client->timezone)->setTimeFromTimeString("23:59:59"));
                                })->count() }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="User actions">
                                        <a class="btn btn-primary" href="{{ route('client.leads', $client) }}">View Leads</a>
                                        <a class="btn btn-info" href="{{ route('client.show', $client) }}">Profile</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>

                </table>
            {{ $clients->links() }}

            </div>

        </div>


        {{--  --}}

        
        {{--  --}}
    </div>
</x-dashboard-layout>