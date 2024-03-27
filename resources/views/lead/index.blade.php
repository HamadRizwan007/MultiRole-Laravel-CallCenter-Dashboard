<x-dashboard-layout>
    @if(request()->routeIs('leads.all_leads'))
        <x-slot name="pageTitle">All Leads</x-slot>
    @endif
    @if(request()->routeIs('leads.created_leads'))
        <x-slot name="pageTitle">Created Leads</x-slot>
    @endif
    @if(request()->routeIs('leads.assigned_leads'))
        <x-slot name="pageTitle">Assigned Leads</x-slot>
    @endif
    @if(request()->routeIs('leads.call_center_leads'))
        <x-slot name="pageTitle">Call Center Leads</x-slot>
    @endif
    @if(request()->routeIs('leads.trashed'))
        <x-slot name="pageTitle">Trashed Leads</x-slot>
    @endif
    @if(auth()->user()->hasRole('client'))
        <x-slot name="pageTitle">My Leads</x-slot>
    @endif
    @if(auth()->user()->hasRole(['client agent', 'client manager', 'client broker']))
        <x-slot name="pageTitle">Leads</x-slot>
    @endif

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('call-center.index') }}">Leads</a></li>
        @if(request()->routeIs('leads.all_leads'))
            <li class="breadcrumb-item active">All</li>
        @endif
        @if(request()->routeIs('leads.created_leads'))
            <li class="breadcrumb-item active">Created</li>
        @endif
        @if(request()->routeIs('leads.assigned_leads'))
            <li class="breadcrumb-item active">Assigned</li>
        @endif
        @if(auth()->user()->hasRole(['client', 'client agent', 'client manager', 'client broker']))
            <li class="breadcrumb-item active">Index</li>
        @endif
    </x-slot>

    <x-slot name="scripts">
        <script>
            $(document).ready(function () {
                $('#allLeads').DataTable({
                });
            })
        
        </script>
    </x-slot>

    <div>
        <!-- tyeeee -->
        <div class="card">
            <div class="card-body">
                <table id="allLeads" class="table table-striped table-responsive-lg no-pagination" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr #</th>
                            <th>State</th>
                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('agent') || auth()->user()->hasRole('call center'))
                            <th>Client</th>
                            @endif
                            <th>Contact</th>
                            @if(!request()->routeIs('leads.trashed'))
                                <th>Quote Type</th>
                                <th>Assign Type</th>
                            @endif
                            @if(!(auth()->user()->hasRole('client') || auth()->user()->hasRole('client agent') || auth()->user()->hasRole('client manager')))
                            <th>@if(!request()->routeIs('leads.assigned_leads', 'leads.created_leads'))Agent /@endif Call Center</th>
                            @endif
                            <th>Created At</th>
                            <th>Attached At</th>
                            @if(request()->routeIs('leads.trashed'))
                                <th>Deleted At</th>
                                <th>Deleted By</th>
                            @endif
                            @if(auth()->user()->hasAnyRole(['call center', 'admin']))
                                <th>Status</th>
                            @endif
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($re as $lead)
                        <tr style="@if(!$lead->client) background: #fff6cf; color: #7A6A38; @endif @if($lead->status == '4')  background-color: #eb7a7a; color: #fff; @endif">
                                <td>{{ $re->firstItem()+$loop->index }}</td>
                                <td>{{ ucfirst($lead->state) }}</td>
                                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('agent') || auth()->user()->hasRole('call center'))
                                    @if(auth()->user()->hasRole('admin'))
                                        <td>{{ $lead->client->name ?? 'NA' }}</td>
                                    @else
                                        <td>{{ $lead->client->uid ?? 'NA' }}</td>
                                    @endif
                                @endif
                                <td>
                                    {{ $lead->name }}
                                    <div><strong>Phone: </strong> {{ $lead->phone }}</div>
                                </td>
                                @if(!request()->routeIs('leads.trashed'))
                                    <td data-order="{{ $lead->quote }}">{{ ucwords($lead->quote_type) }}</td>
                                    <td>{{ ucwords($lead->assign_text_type) }}</td>
                                @endif
                                @if(!(auth()->user()->hasRole('client') || auth()->user()->hasRole('client agent') || auth()->user()->hasRole('client manager')))
                                    <td>
                                        @if(!request()->routeIs('leads.assigned_leads', 'leads.created_leads'))
                                            <div><strong>Agent: </strong>
                                                @if ($lead->agent)
                                                    <a href="{{ route('call-center.show', $lead->agent) }}">{{ $lead->agent->name }}</a>
                                                @else
                                                    @if($lead->agent_id)
                                                        Deleted
                                                    @else
                                                        NA
                                                    @endif
                                                @endif
                                            </div>
                                        @endif
                                        <div><strong>Center: </strong>
                                        @if ($lead->call_center)
                                            <a href="{{ route('call-center.show', $lead->call_center) }}">{{ ucfirst($lead->call_center->center_name) }}</a>
                                        @else
                                            @if($lead->call_center_id)
                                                Deleted
                                            @else
                                                NA
                                            @endif
                                        @endif
                                        </div>
                                    </td>
                                @endif
                                <td>{!! $lead->created_at->setTimezone(auth()->user()->timezone)->format('d M Y\<\b\r\>h:i:s A') !!}</td>
                                <td>{!! $lead->assigned_time ? $lead->assigned_time->setTimezone(auth()->user()->timezone)->format('d M Y\<\b\r\>h:i:s A') : 'NA' !!}</td>
                                @if(request()->routeIs('leads.trashed'))
                                    <td>{!! $lead->deleted_at->setTimezone(auth()->user()->timezone)->format('d M Y\<\b\r\>h:i:s A') !!}</td>
                                    <td>
                                        {{ $lead->deleted_by->center_name ?? $lead->deleted_by->name }}
                                        <p class="text-muted"><strong>Type: </strong>{{ ucwords($lead->deleted_by->getRoleNames()[0]) }}</p>
                                    </td>
                                @endif
                                @if(auth()->user()->hasAnyRole(['call center', 'admin']))

                                    @php
                                        $status_class = 'badge-info';

                                        switch ($lead->status) {
                                            case 1:
                                                $status_class = 'badge-warning text-white';
                                                break;
                                            case 2:
                                                $status_class = 'badge-success';
                                                break;
                                            case 3:
                                                $status_class = 'badge-info';
                                                break;
                                            case 4:
                                                $status_class = 'badge-danger';
                                                break;
                                        }
                                    @endphp
                                    <td class="text-center" data-order="{{ $lead->status }}">
                                        <span class="badge {{ $status_class }}" style="font-size: 12px;">{{ $lead->status_text }}</span>
                                    </td>
                                @endif
                                <td>
                                    <div class="btn-group" role="group" aria-label="User actions">
                                        <a class="btn btn-info" href="{{ route('leads.show', $lead) }}">View</a>
                                        @if(in_array(auth()->user()->id, array_merge($can_edit_ids, [$lead->call_center_id, $lead->agent_id, $lead->created_by_id])) && (auth()->user()->hasRole('admin') || $lead->status != 2))
                                            <a class="btn btn-warning" href="{{ route('leads.edit', $lead) }}">Edit</a>
                                            <a class="btn btn-danger" type="button"  data-toggle="modal" data-target="#deleteLead_{{$lead->id}}">@if(request()->routeIs('leads.trashed'))Permanent Delete @else Delete @endif</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @if(in_array(auth()->user()->id, array_merge($can_edit_ids, [$lead->call_center_id, $lead->agent_id, $lead->created_by_id])) && (auth()->user()->hasRole('admin') || $lead->status != 2))
                                <div class="modal fade" id="deleteLead_{{$lead->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                    <div class="modal-dialog modal-danger" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('leads.destroy', $lead) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-header">
                                                    @if(request()->routeIs('leads.trashed'))
                                                    <h4 class="modal-title">Confirm permanently delete Lead?</h4>
                                                    @else
                                                    <h4 class="modal-title">Confirm Delete Lead?</h4>
                                                    @endif
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if(request()->routeIs('leads.trashed'))
                                                        <p>Are you sure you want to <strong>permanently</strong> delete the lead for person named <strong>{{ $lead->name }}</strong>. This action is not reversible.</p>
                                                    @else
                                                        <p>Are you sure you want to delete the lead for person named <strong>{{ $lead->name }}</strong>. This action is not reversible.</p>
                                                        <div class="form-group">
                                                            <label for="deleteReason">Enter Delete reason below:</label>
                                                            <textarea name="delete_reason" id="deleteReason" class="form-control" rows="10" placeholder="Enter delete reason here..." minlength="5" required></textarea>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                                    <button class="btn btn-danger" type="submit">Confirm Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </tbody>
                    {{ $re->links() }}
                    
                </table>
                
            </div>
        </div>

    </div>
</x-dashboard-layout>
