<x-dashboard-layout>
    <x-slot name="pageTitle">Create Client Broker</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('client-broker.index') }}">Client Brokers</a></li>
        <li class="breadcrumb-item active">Create Client Broker</li>
    </x-slot>

    <div>
        <form class="card" action="{{ route('client-broker.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="card-header"><strong>Create Client Broker</strong></div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="fname">First Name</label>
                        <input class="form-control @error('fname') is-invalid @enderror" id="fname" name="fname" type="text" placeholder="Enter first name" value="{{ old('fname') }}" required>
                        @error('fname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="lname">Last Name</label>
                        <input class="form-control @error('lname') is-invalid @enderror" id="lname" name="lname" type="text" placeholder="Enter last name" value="{{ old('lname') }}" required>
                        @error('lname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" placeholder="Enter the email" value="{{ old('email') }}" autocomplete="username" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="phone">Phone</label>
                        <input class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" type="text" placeholder="Enter the phone" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="password">Password</label>
                        <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" placeholder="Enter the password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="passwordConfirmation">Confirm Password</label>
                        <input class="form-control @error('passwordConfirmation') is-invalid @enderror" id="passwordConfirmation" name="password_confirmation" type="password" placeholder="Enter the password Confirmation" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="username">Username</label>
                        <input class="form-control @error('username') is-invalid @enderror" id="username" name="username" type="text" placeholder="Enter the username" value="{{ old('username') }}">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="agency">Agency</label>
                        <input class="form-control @error('agency') is-invalid @enderror" id="agency" name="agency" type="text" placeholder="Enter Agency Name" value="{{ old('agency') }}">
                        @error('agency')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="timezone">Timezone</label>
                        <select name="timezone" id="timezone" class="form-control @error('timezone') is-invalid @enderror" required>
                            <option value="">Select Timezone</option>
                            @foreach (App\Models\User::$timezones as $key => $value)
                                <option value="{{ $key }}" @if(old('timezone') == $key) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('timezone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group text-left">
                        <label for="avatar">Client Broker Avatar</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icofont-photobucket"></i></span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('avatar') is-invalid @enderror" id="avatar" name="avatar" accept="image/png,image/jpg,image/jpeg">
                                <label class="custom-file-label" for="avatar">Select client avatar</label>
                            </div>
                        </div>
                        <div class="text-muted">
                            <small>Acceptable image types are jpeg, jpg and png, size between 40KB to 1MB.</small>
                        </div>
                        <script>
                            const avatar = document.getElementById('avatar');
                            avatar.addEventListener('change', e => {
                                if(avatar.files.length > 0){
                                    const avatarFile = avatar.files[0];
                                    const availableTypes = ['image/png', 'image/jpg', 'image/jpeg'];
                                    document.querySelector('input[name="avatar"]+label').innerHTML =  avatarFile.name;

                                    if(!availableTypes.includes(avatarFile.type)){
                                        document.getElementById('fileTypeError').style.display = 'block';
                                        document.getElementById('fileTypeError').innerHTML = "Only supported images files are acceptable";
                                        document.getElementById('submitBtn').setAttribute('disabled', true);
                                    } else {
                                        document.getElementById('fileTypeError').style.display = 'none';
                                        document.getElementById('fileTypeError').innerHTML = "";
                                        document.getElementById('submitBtn').removeAttribute('disabled');
                                    }
                                }
                            });
                        </script>
                        <div class="text-danger" id="fileTypeError" @error('avatar') style="display: block;" @enderror>
                            @error('avatar')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-group col-12">
                        <label for="lead_instructions">Lead Instructions</label>
                        <textarea name="lead_instructions" id="leadInstructions" class="form-control @error('lead_instructions') is-invalid @enderror"
                            rows="10"
                            placeholder="Enter intructions for how the lead should be processed for the client!">{{ old('lead_instructions') }}</textarea>
                        @error('lead_instructions')
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
