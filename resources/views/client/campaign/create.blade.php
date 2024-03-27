<x-dashboard-layout>
    <x-slot name="pageTitle">Create Campaign</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('client.show', $client) }}">{{ $client->name }}'s Campaigns</a></li>
        <li class="breadcrumb-item active">Create Campaign</li>
    </x-slot>


    <x-slot name="scripts">
        <script>
            new SlimSelect({
                select: '#leadTypes',
                placeholder: 'Select lead types',
            });

            new SlimSelect({
                select: '#leadRequestTypes',
                placeholder: 'Select lead request type',
            });

            new SlimSelect({
                select: '#leadStates',
                placeholder: 'Select states for leads',
            });
        </script>
    </x-slot>

    <div>
        <form class="card" action="{{ route('client.campaign.store', $client) }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="card-header"><strong>Create Campaign</strong></div>
            <div class="card-body">
                <div class="row justify-content-between align-items-center">
                    <div class="form-group col-md-6">
                        <label for="leadTypes">Lead Type</label>
                        <select class="@error('lead_types') is-invalid @enderror" id="leadTypes" name="lead_types[]" multiple>
                            @foreach (\App\Models\Lead::$quoteTypes as $key => $type)
                                <option value="{{ $key }}" @if(in_array($key, old('lead_types', []))) selected @endif>{{ ucwords($type) }}</option>
                            @endforeach
                        </select>
                        @error('lead_types')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="leadRequestTypes">Lead Request Type</label>
                        <select class="@error('requested_lead_types') is-invalid @enderror" id="leadRequestTypes" name="requested_lead_types[]" multiple>
                            @foreach (\App\Models\User::$leadRequestType as $key => $type)
                                <option value="{{ $key }}" @if(in_array($key, old('requested_lead_types', []))) selected @endif>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('requested_lead_types')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="did_number">DID Number</label>
                        <input class="form-control @error('did_number') is-invalid @enderror" id="did_number" name="did_number" type="text" value="{{ old('did_number') }}" placeholder="Enter the clients DID number">
                        @error('did_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="lead_states">Lead State</label>
                        <select name="lead_states[]" id="leadStates" class="@error('lead_states') is-invalid @enderror" multiple>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}" @if(in_array($state->id, old('lead_states', []))) selected @endif>{{ $state->name }}</option>
                            @endforeach
                        </select>
                        @error('lead_states')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="admin_price">Admin Price</label>
                        <input class="form-control @error('admin_price') is-invalid @enderror" id="admin_price" name="admin_price" type="number" min="0.01" step="0.01" value="{{ old('admin_price') }}" placeholder="Enter daily leads">
                        @error('admin_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="center_price">Center Price</label>
                        <input class="form-control @error('center_price') is-invalid @enderror" id="center_price" name="center_price" type="number" min="0.01" step="0.01" value="{{ old('center_price') }}" placeholder="Enter daily leads">
                        @error('center_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="daily_leads">Daily Leads</label>
                        <input class="form-control @error('daily_leads') is-invalid @enderror" id="daily_leads" name="daily_leads" type="number" min="1" value="{{ old('daily_leads') }}" placeholder="Enter daily leads, leave empty for unlimited">
                        @error('daily_leads')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="status">Lead State</label>
                        <select name="status" id="status" class="form-control" class="@error('status') is-invalid @enderror">
                            @foreach (App\Models\Campaign::$statuses as $key => $status)
                                <option value="{{ $key }}" @if(old('status') == $key) selected @endif>{{ $status }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" type="submit">Create</button>
            </div>
        </form>
    </div>
</x-dashboard-layout>
