<x-dashboard-layout>
    <x-slot name="pageTitle">All Agents</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('state.index') }}">State</a></li>
        <li class="breadcrumb-item active">All</li>
    </x-slot>

    <x-slot name="scripts">
        <script>
            $(document).ready(function () {
                $('#allStates').DataTable();
            });
        </script>
    </x-slot>

    <div>
        <div class="card">
            <div class="card-body">
                <table id="allStates" class="table table-striped table-responsive-lg" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr #</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($states as $state)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>
                                    {{ $state->name }}
                                </td>
                                <td>
                                    {{ Str::upper($state->code ?? '""') }}
                                </td>
                                <td>{{ $state->created_at->setTimezone(auth()->user()->timezone)->format('d M Y h:i A') }}</td>
                                <td>
                                    <button class="btn btn-danger" type="button"  data-toggle="modal" data-target="#deleteState_{{$state->id}}">Delete</button>
                                </td>
                            </tr>
                            <div class="modal fade" id="deleteState_{{$state->id}}" tabindex="-1" style="display: none;" aria-modal="true" role="dialog">
                                <div class="modal-dialog modal-danger" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('state.destroy', $state) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="status" value="4">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirm delete state?</h4>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete the state with name <strong>{{ $state->name}}</strong>.</p>
                                                <p class="mt-2">
                                                    <strong>Caution:</strong> This will not delete the states from already made client, leads etc. This change will only reflect the newly created leads.
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                                <button class="btn btn-danger" type="submit">Confirm Delete</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dashboard-layout>
