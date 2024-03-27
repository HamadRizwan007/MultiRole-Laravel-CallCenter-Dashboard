<x-dashboard-layout>
    <x-slot name="pageTitle">All Notifications</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('notification.index') }}">Leads</a></li>
        <li class="breadcrumb-item active">All</li>
    </x-slot>

    <x-slot name="scripts">
        <script>
            $(document).ready(function () {
                $('#allNotifications').DataTable();
            })
        </script>
    </x-slot>

    <div>
        <div class="card">
            <div class="card-body">
                <table id="allNotifications" class="table table-striped table-responsive-lg" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr #</th>
                            <th>Notification</th>
                            <th>Sent At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notifications as $notification)
                            <tr>
                                <td>{{ $notifications->firstItem()+$loop->index }}</td>
                                <td>{{ $notification->data['text'] }}</td>
                                <td>{{ $notification->created_at->setTimezone(auth()->user()->timezone)->format('d M Y h:i A') }}</td>
                                <td>
                                    <a class="btn btn-info" href="{{ $notification->data['action_url'] }}">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $notifications->links() }}

            </div>
        </div>
    </div>
</x-dashboard-layout>
