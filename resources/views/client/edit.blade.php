<x-dashboard-layout>
    <x-slot name="pageTitle">Edit Client</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Clients</a></li>
        <li class="breadcrumb-item active">Edit Client</li>
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
        <form class="card" action="{{ route('client.update', $client) }}" enctype="multipart/form-data"
            method="POST">
            @csrf
            @method('PUT')
            <div class="card-header"><strong>Edit Client</strong></div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="fname">First Name</label>
                        <input class="form-control @error('fname') is-invalid @enderror" id="fname" name="fname"
                            type="text" placeholder="Enter first name" value="{{ old('fname', $client->fname) }}"
                            required>
                        @error('fname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="lname">Last Name</label>
                        <input class="form-control @error('lname') is-invalid @enderror" id="lname" name="lname"
                            type="text" placeholder="Enter last name" value="{{ old('lname', $client->lname) }}"
                            required>
                        @error('lname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                            type="email" placeholder="Enter the email" value="{{ old('email', $client->email) }}"
                            required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="phone">Phone</label>
                        <input class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
                            type="text" placeholder="Enter the phone" value="{{ old('phone', $client->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="password">Password</label>
                        <input class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password" type="password" placeholder="Enter the password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="passwordConfirmation">Confirm Password</label>
                        <input class="form-control @error('passwordConfirmation') is-invalid @enderror"
                            id="passwordConfirmation" name="password_confirmation" type="password"
                            placeholder="Enter the password Confirmation">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="username">Username</label>
                        <input class="form-control @error('username') is-invalid @enderror" id="username" name="username" type="text" placeholder="Enter the username" value="{{ old('username', $client->username) }}" required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="agency">Agency</label>
                        <input class="form-control @error('agency') is-invalid @enderror" id="agency" name="agency" type="text" placeholder="Enter Your Agency" value="{{ old('agency',$client->agency) }}">
                        @error('agency')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="leadTypes">Lead Type</label>
                        <select class="@error('lead_type') is-invalid @enderror" id="leadTypes" name="lead_type[]" multiple>
                            @foreach (\App\Models\Lead::$quoteTypes as $key => $type)
                                <option value="{{ $key }}" @if(in_array($key, old('lead_type', $client->lead_type ?? []))) selected @endif>{{ ucwords($type) }}</option>
                            @endforeach
                        </select>
                        @error('lead_type')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="leadRequestTypes">Lead Request Type</label>
                        <select class="@error('requested_lead_type') is-invalid @enderror" id="leadRequestTypes" name="requested_lead_type[]" multiple>
                            @foreach (\App\Models\User::$leadRequestType as $key => $type)
                                <option value="{{ $key }}" @if(in_array($key, old('requested_lead_type', $client->lead_request_type ?? []))) selected @endif>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('requested_lead_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="daily_leads">Daily Leads</label>
                        <input class="form-control @error('daily_leads') is-invalid @enderror" id="daily_leads"
                            name="daily_leads" type="number" min="1"
                            value="{{ old('daily_leads', $client->lead_request_cap) }}"
                            placeholder="Enter daily leads, leave empty for unlimited">
                        @error('daily_leads')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="did_number">DID Number</label>
                        <input class="form-control @error('did_number') is-invalid @enderror" id="did_number"
                            name="did_number" type="text" value="{{ old('did_number', $client->did_number) }}"
                            placeholder="Enter the clients DID number">
                        @error('did_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="lead_states">Lead State</label>
                        <select name="lead_states[]" id="leadStates" class="@error('lead_states') is-invalid @enderror" multiple>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}" @if(in_array($state->id, old('lead_states', $client->lead_states ?? []))) selected @endif>{{ $state->name }}</option>
                            @endforeach
                        </select>
                        @error('lead_states')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="timezone">Timezone</label>
                        <select name="timezone" id="timezone" class="form-control @error('timezone') is-invalid @enderror" required>
                            <option value="">Select Timezone</option>
                            @foreach (App\Models\User::$timezones as $key => $value)
                                <option value="{{ $key }}" @if(old('timezone', $client->timezone) == $key) selected @endif>{{ $value }} -- {{ now()->setTimezone($key)->format('d M Y h:i A') }}</option>
                            @endforeach
                        </select>
                        @error('timezone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group text-left">
                        <label for="avatar">Client Avatar</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icofont-photobucket"></i></span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('avatar') is-invalid @enderror"
                                    id="avatar" name="avatar" accept="image/png,image/jpg,image/jpeg">
                                <label class="custom-file-label" for="avatar">Select client avatar</label>
                            </div>
                        </div>
                        <div class="text-muted">
                            <small>Acceptable image types are jpeg, jpg and png, size between 40KB to 1MB.</small>
                        </div>
                        <script>
                            const avatar = document.getElementById('avatar');
                            avatar.addEventListener('change', e => {
                                if (avatar.files.length > 0) {
                                    const avatarFile = avatar.files[0];
                                    const availableTypes = ['image/png', 'image/jpg', 'image/jpeg'];
                                    document.querySelector('input[name="avatar"]+label').innerHTML = avatarFile.name;

                                    if (!availableTypes.includes(avatarFile.type)) {
                                        document.getElementById('fileTypeError').style.display = 'block';
                                        document.getElementById('fileTypeError').innerHTML =
                                            "Only supported images files are acceptable";
                                        document.getElementById('submitBtn').setAttribute('disabled', true);
                                    } else {
                                        document.getElementById('fileTypeError').style.display = 'none';
                                        document.getElementById('fileTypeError').innerHTML = "";
                                        document.getElementById('submitBtn').removeAttribute('disabled');
                                    }
                                }
                            });
                        </script>
                        <div class="text-danger" id="fileTypeError" @error('avatar') style="display: block;"
                            @enderror>
                            @error('avatar')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    @role('admin')
                    <div class="form-group col-12">
                        <label for="lead_instructions">Lead Instructions</label>
                        <textarea name="lead_instructions" id="leadInstructions" class="form-control @error('lead_instructions') is-invalid @enderror"
                            rows="10"
                            placeholder="Enter intructions for how the lead should be processed for the client!">{{ old('lead_instructions', $client->lead_instructions) }}</textarea>
                        @error('lead_instructions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @endrole
                    @if(env('SHOW_API_MAPPINGS'))
                    <div class="form-group col-md-6">
                        <label for="api_type">Client's External API Type</label>
                        <select name="api_type" id="apiType" class="form-control">
                            <option value="">Select your API Type</option>
                            @foreach (App\Models\User::$apiTypes as $key => $type)
                                <option value="{{ $key }}" @if(old('api_type', $client->api_type) == $key) selected @endif>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('api_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="api_return_id_column">API returned lead id key</label>
                        <input class="form-control @error('api_return_id_column') is-invalid @enderror" id="api_return_id_column"
                            name="api_return_id_column" type="text" value="{{ old('api_return_id_column', $client->api_return_id_column) }}"
                            placeholder="Enter the id key that will be return from API">
                        @error('api_return_id_column')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="api_url">Client's External API URL</label>
                        <textarea name="api_url" id="apiUrl" class="form-control @error('api_url') is-invalid @enderror"
                            rows="10"
                            placeholder="Enter the fully qualified API URL here and make the mapping of lead information using the setup below">{{ old('api_url', $client->api_url) }}</textarea>
                        @error('api_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="api_query_map">External API Query String Data</label>
                        <table class="table table-striped table-responsive-md">
                            <thead>
                                <tr>
                                    <th>Field ID</th>
                                    <th>Field Value</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="query_map">
                                @foreach(old('api_query_map', $client->api_query_map ?? []) as $key => $value)
                                    <tr id="{{ $key }}">
                                        <td>{{ $key }}</td>
                                        <td>{{ $value }}</td>
                                        <td><button class="btn btn-danger" type="button" onclick="removeRow({{ 'queryMap_'.$key }})">Remove</button></div>
                                        <input type="hidden" name="api_query_map[{{ $key }}]" value="{{ $value }}" />
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="3">
                                        <div class="d-flex justify-content-center">
                                            <div class="form-inline">
                                                <div class="form-group">
                                                    <input class="form-control mr-2" type="text" id="newQueryMapId"
                                                        placeholder="Enter ID">
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control mr-2" type="text" id="newQueryMapValue"
                                                        placeholder="Enter Value">
                                                </div>
                                                <button type="button" class="btn btn-info" id="newQueryMapBtn">Add Field</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <script>
                            const newQueryMapId = document.getElementById('newQueryMapId');
                            const newQueryMapValue = document.getElementById('newQueryMapValue');
                            const newQueryMapBtn = document.getElementById('newQueryMapBtn');
                            const queryMap = document.getElementById('query_map');

                            function addNewQueryField() {
                                if (newQueryMapId.value != '') {
                                    const mapField = `<tr id="queryMap_${newQueryMapId.value}">
                                            <td>${newQueryMapId.value}</td>
                                            <td>${newQueryMapValue.value}</td>
                                            <td><button class="btn btn-danger" type="button" onclick="removeRow(queryMap_${newQueryMapId.value})">Remove</button></div>
                                            <input type="hidden" name="api_query_map[${newQueryMapId.value}]" value="${newQueryMapValue.value}" />
                                        </tr>`;

                                    queryMap.innerHTML += mapField;
                                    newQueryMapId.value = '';
                                    newQueryMapValue.value = '';
                                }
                            }

                            newQueryMapBtn.addEventListener('click', addNewQueryField);
                        </script>
                        @error('api_query_map')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="api_static_data">External API Static Data</label>
                        <table class="table table-striped table-responsive-md">
                            <thead>
                                <tr>
                                    <th>Field ID</th>
                                    <th>Field Value</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="static_map">
                                @foreach(old('api_static_data', $client->api_static_data ?? []) as $key => $value)
                                    <tr id="map_{{ $key }}">
                                        <td>{{ $key }}</td>
                                        <td>{{ $value }}</td>
                                        <td><button class="btn btn-danger" type="button" onclick="removeRow({{ 'map_'.$key }})">Remove</button></div>
                                        <input type="hidden" name="api_static_data[{{ $key }}]" value="{{ $value }}" />
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="3">
                                        <div class="d-flex justify-content-center">
                                            <div class="form-inline">
                                                <div class="form-group">
                                                    <input class="form-control mr-2" type="text" id="newMapId"
                                                        placeholder="Enter ID">
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control mr-2" type="text" id="newMapValue"
                                                        placeholder="Enter Value">
                                                </div>
                                                <button type="button" class="btn btn-info" id="newMapBtn">Add Field</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <script>
                            const newMapId = document.getElementById('newMapId');
                            const newMapValue = document.getElementById('newMapValue');
                            const newMapBtn = document.getElementById('newMapBtn');
                            const staticMap = document.getElementById('static_map');

                            function addNewStaticField() {
                                if (newMapId.value != '') {
                                    const mapField = `<tr id="map_${newMapId.value}">
                                            <td>${newMapId.value}</td>
                                            <td>${newMapValue.value}</td>
                                            <td><button class="btn btn-danger" type="button" onclick="removeRow(map_${newMapId.value})">Remove</button></div>
                                            <input type="hidden" name="api_static_data[${newMapId.value}]" value="${newMapValue.value}" />
                                        </tr>`;

                                    staticMap.innerHTML += mapField;
                                    newMapId.value = '';
                                    newMapValue.value = '';
                                }
                            }

                            newMapBtn.addEventListener('click', addNewStaticField);
                        </script>
                        @error('api_static_data')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div>
                            <label for="api_data_map">External API Data Map</label>
                            <table class="table table-striped table-responsive-md">
                                <thead>
                                    <tr>
                                        <th>Field ID</th>
                                        <th>Field Value</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="data_map">
                                    @foreach(old('api_data_map', $client->api_data_map ?? []) as $key => $value)
                                        <tr id="dataMap_{{ $key }}">
                                            <td>{{ $key }}</td>
                                            <td>{{ $value }}</td>
                                            <td><button class="btn btn-danger" type="button" onclick="removeRow({{ 'dataMap_'.$key }})">Remove</button></div>
                                            <input type="hidden" name="api_data_map[{{ $key }}]" value="{{ $value }}" />
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-light">
                                        <td colspan="3">
                                            <div class="d-flex justify-content-center">
                                                <div class="form-inline">
                                                    <div class="form-group">
                                                        <input class="form-control mr-2" type="text" id="newDataMapId"
                                                            placeholder="Enter ID">
                                                    </div>
                                                    <div class="form-group">
                                                        <input class="form-control mr-2" type="text"
                                                            id="newDataMapValue" placeholder="Enter Value">
                                                    </div>
                                                    <button type="button" class="btn btn-info" id="newDataMapBtn">Add Field</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="bg-white">
                                        <td colspan="3" class="text-center">
                                            <button class="btn btn-dark" type="button" data-toggle="modal"
                                                data-target="#mappableFieldList">View Mappable fields</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <script>
                                const newDataMapId = document.getElementById('newDataMapId');
                                const newDataMapValue = document.getElementById('newDataMapValue');
                                const newDataMapBtn = document.getElementById('newDataMapBtn');
                                const dataMap = document.getElementById('data_map');

                                function addNewDataMapField() {
                                    if (newDataMapId.value != '') {
                                        const mapField = `<tr id="dataMap_${newDataMapId.value}">
                                                <td>${newDataMapId.value}</td>
                                                <td>${newDataMapValue.value}</td>
                                                <td><button class="btn btn-danger" type="button" onclick="removeRow(dataMap_${newDataMapId.value})">Remove</button></div>
                                                <input type="hidden" name="api_data_map[${newDataMapId.value}]" value="${newDataMapValue.value}" />
                                            </tr>`;

                                        dataMap.innerHTML += mapField;
                                        newDataMapId.value = '';
                                        newDataMapValue.value = '';
                                    }
                                }

                                function removeRow(row) {
                                    if (row) {
                                        row.remove();
                                    }
                                }

                                newDataMapBtn.addEventListener('click', addNewDataMapField);
                            </script>
                            @error('api_data_map')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </form>

        @if(env('SHOW_API_MAPPINGS'))
        <!-- Mappable Fields Modal -->
        <div class="modal fade" id="mappableFieldList" tabindex="-1" role="dialog" aria-labelledby="mappableFieldListLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mappableFieldListLabel">Mappable Field List</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>You can use the below mentioned fields in the Data Map value like this. [FieldName]</p>
                        <p>The fields marked with * are a composition of other related fields. Like Full Address is made up of address line, city, state, zip_code, country etc.</p>
                        <table class="table table-striped table-responsive-md">
                            <thead>
                                <tr>
                                    <td>Sr. #</td>
                                    <td>Field Name</td>
                                    <td>Field ID</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (\App\Models\Lead::$apiCompatibleFields as $key => $value)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $value }}</td>
                                        <td>{{ $key }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</x-dashboard-layout>
