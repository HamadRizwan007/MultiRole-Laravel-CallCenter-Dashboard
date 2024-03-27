<x-dashboard-layout>
    <x-slot name="pageTitle">All Clients</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('client.public-index') }}">Clients</a></li>
        <li class="breadcrumb-item active">All</li>
    </x-slot>

    <x-slot name="scripts">
        <script>
            $(document).ready(function () {
                $('#allClients').DataTable();
            });
        </script>
    </x-slot>

    <div>
        <div class="card">
            <div class="card-body">
                <table id="allClients" class="table table-striped table-responsive-lg" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr #</th>
                            <th>ID</th>
                            <th>Lead Types</th>
                            <th>Quote Type</th>
                            <th>Lead Accept Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $client->uid }}</td>
                                <td>{{ ucwords($client->lead_type_text ?? 'NA') }}</td>
                                <td>{{ ucwords($client->lead_request_type_text ?? 'NA') }}</td>
                                <td style="font-size: 1rem;" data-order="{{ $client->currently_accepting_leads ? 1:2 }}">
                                    @if($client->currently_accepting_leads)
                                        <span class="badge badge-success text-white">Active</span>
                                    @else
                                        <span class="badge badge-danger text-white">Paused</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="User actions">
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#clientTimetableModal_{{ $client->id }}">View Timetable</button>
                                        <button class="btn btn-info" data-toggle="modal" data-target="#clientStateModal_{{ $client->id }}">View States</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @foreach ($clients as $client)
                    <div class="modal fade" id="clientTimetableModal_{{ $client->id }}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-primary @if($client->client_timetable) modal-lg @endif" role="document">
                            <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Client Timetable ({{ $client->timezone_text }})</h4>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        @if($client->client_timetable)
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
                                                                @if($client->client_timetable->{Str::lower($day."_timing")} != 3)
                                                                    {{ \App\Models\ClientTimetable::$dayTimingOptions[$client->client_timetable->{Str::lower($day)."_timing"}] }}
                                                                @else
                                                                    <div class="d-flex flex-wrap justify-content-start align-items-center">
                                                                        @foreach ($client->client_timetable->{Str::lower($day)."_time_sets"} as $set)
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
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="clientStateModal_{{ $client->id }}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-info" role="document">
                            <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Client States</h4>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Sr #</th>
                                                    <th>State Code</th>
                                                    <th>Sate Name</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($client->lead_states as $state)
                                                    @php
                                                        $state = $states->where('id', $state)->first();
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $loop->index + 1 }}</td>
                                                        <td>{{ $state->code }}</td>
                                                        <td>{{ $state->name }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-dashboard-layout>
