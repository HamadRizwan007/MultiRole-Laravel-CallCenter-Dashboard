<x-dashboard-layout>
    <x-slot name="pageTitle">Update Call Center</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('agent.index') }}">Call Centers</a></li>
        <li class="breadcrumb-item active">Update Call Center</li>
    </x-slot>

    <div>
        <form class="card" action="{{ route('call-center.update', $call_center) }}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PUT')
            <div class="card-header"><strong>Update Call Center</strong></div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="fname">First Name</label>
                        <input class="form-control @error('fname') is-invalid @enderror" id="fname" name="fname" type="text" placeholder="Enter first name" value="{{ old('fname', $call_center->fname) }}" required>
                        @error('fname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="lname">Last Name</label>
                        <input class="form-control @error('lname') is-invalid @enderror" id="lname" name="lname" type="text" placeholder="Enter last name" value="{{ old('lname', $call_center->lname) }}" required>
                        @error('lname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" placeholder="Enter the call center email" value="{{ old('email', $call_center->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="phone">Phone</label>
                        <input class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" type="text" placeholder="Enter the phone" value="{{ old('phone', $call_center->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="password">Password</label>
                        <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" placeholder="Enter the password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="passwordConfirmation">Confirm Password</label>
                        <input class="form-control @error('passwordConfirmation') is-invalid @enderror" id="passwordConfirmation" name="password_confirmation" type="password" placeholder="Enter the password Confirmation">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="center_name">Center Name</label>
                        <input class="form-control @error('center_name') is-invalid @enderror" id="center_name" name="center_name" type="text" placeholder="Enter the call center name" value="{{ old('center_name', $call_center->center_name) }}" required>
                        @error('center_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group text-left">
                        <label for="centerLogo">Call Center Logo</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icofont-photobucket"></i></span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('centerLogo') is-invalid @enderror" id="centerLogo" name="center_logo" accept="image/png,image/jpg,image/jpeg">
                                <label class="custom-file-label" for="centerLogo">Select center logo</label>
                            </div>
                        </div>
                        <div class="text-muted">
                            <small>Acceptable image types are jpeg, jpg and png, size between 40KB to 1MB.</small>
                        </div>
                        <script>
                            const centerLogo = document.getElementById('centerLogo');
                            centerLogo.addEventListener('change', e => {
                                if(centerLogo.files.length > 0){
                                    const centerLogoFile = centerLogo.files[0];
                                    const availableTypes = ['image/png', 'image/jpg', 'image/jpeg'];
                                    document.querySelector('input[name="center_logo"]+label').innerHTML =  centerLogoFile.name;

                                    if(!availableTypes.includes(centerLogoFile.type)){
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
                    </div><div class="form-group col-md-4">
                        <label for="address_line">Address Line</label>
                        <input class="form-control @error('address_line') is-invalid @enderror" id="address_line" name="address_line" type="text" placeholder="Enter center address" value="{{ old('address_line', $call_center->address_line) }}" required>
                        @error('address_line')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="city">City</label>
                        <input class="form-control @error('city') is-invalid @enderror" id="city" name="city" type="text" placeholder="Enter city name" value="{{ old('city', $call_center->city) }}" required>
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="state">State</label>
                        <input class="form-control @error('state') is-invalid @enderror" id="state" name="state" type="text" placeholder="Enter state" value="{{ old('state', $call_center->state) }}" required>
                        @error('state')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="post_code">Post Code</label>
                        <input class="form-control @error('post_code') is-invalid @enderror" id="post_code" name="post_code" type="text" placeholder="Enter post code" value="{{ old('post_code', $call_center->zip_code) }}" required>
                        @error('post_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="country">Country</label>
                        <input class="form-control @error('country') is-invalid @enderror" id="country" name="country" type="text" placeholder="Enter country" value="United States" readonly>
                        @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="timezone">Timezone</label>
                        <select name="timezone" id="timezone" class="form-control @error('timezone') is-invalid @enderror" required>
                            <option value="">Select Timezone</option>
                            @foreach (App\Models\User::$timezones as $key => $value)
                                <option value="{{ $key }}" @if(old('timezone', $call_center->timezone) == $key) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('timezone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" type="submit">Update Information</button>
            </div>
        </form>
    </div>
</x-dashboard-layout>
