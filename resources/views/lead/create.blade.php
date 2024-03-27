<x-dashboard-layout>
    <x-slot name="pageTitle">Create Lead</x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('leads.index') }}">Leads</a></li>
        <li class="breadcrumb-item active">Create Lead</li>
    </x-slot>

    <x-slot name="scripts">
        <script>
            $(document).ready(function() {
                if (document.getElementById('selectLeadClient')) {
                    new SlimSelect({
                        select: "#selectLeadClient"
                    });
                }
                if (document.getElementById('selectCenterAgent')) {
                    new SlimSelect({
                        select: '#selectCenterAgent'
                    })
                }
                if (document.getElementById('state')) {
                    new SlimSelect({
                        select: "#state"
                    });
                }
                if (document.getElementById('homeTypeField')) {
                    new SlimSelect({
                        select: '#homeTypeField select'
                    })
                }

                if (document.getElementById('interestedInQuoteField')) {
                    new SlimSelect({
                        select: "#interestedInQuoteField select",
                        placeholder: "Select the quote that the client is interested in..",
                    })
                }

                if (document.getElementById('canPayThroughField')) {
                    new SlimSelect({
                        select: "#canPayThroughField select",
                        placeholder: "Select the option by which the client can make payments",
                    })
                }
            });

            const homeowner_fields = [
                document.getElementById('ownerTypeField'),
                document.getElementById('homeTypeField'),
                document.getElementById('homeBuiltAfter2006'),
                document.getElementById('home4MilesAwayFromWater'),
                document.getElementById('condoBuiltAfter2001'),
                document.getElementById('insuredByField'),
            ];

            const car_fields = [
                document.getElementById('carFieldA'),
                document.getElementById('carFieldB'),
                document.getElementById('carFieldC'),
                document.getElementById('insuredByField'),
            ];

            const health_fields = [
                document.getElementById('interestedInQuoteField'),
                document.getElementById('activeCheckingAccountField'),
                document.getElementById('canPayThroughField'),
                document.getElementById('insuredByField'),
            ];

            const final_expense_fields = [
                document.getElementById('interestedInQuoteField'),
                document.getElementById('activeCheckingAccountField'),
                document.getElementById('canPayThroughField'),
                document.getElementById('hasActiveSsnField'),
                document.getElementById('decisionMakerField'),
                document.getElementById('monthlyPayment_40_100Field'),
                document.getElementById('anyCriticalIllnessField'),
                document.getElementById('criticalIllnessField'),
                document.getElementById('moveForwardTodayField'),
                document.getElementById('favFourDigitsField'),
            ];

            const handleQuoteUpdate = () => {
                const targetValue = document.getElementById('quote').value;
                switch (targetValue) {
                    case '1':
                        car_fields.forEach(e => {
                            if (e) {
                                e.classList.remove('show-node');
                            }
                        });
                        health_fields.forEach(e => {
                            if (e) {
                                e.classList.remove('show-node');
                            }
                        });
                        final_expense_fields.forEach(e => {
                            if (e) {
                                e.classList.remove('show-node');
                            }
                        });
                        homeowner_fields.forEach(e => {
                            if (e) {
                                e.classList.add('show-node');
                            }
                        });
                        break;
                    case '2':
                        homeowner_fields.forEach(e => {
                            if (e) {
                                e.classList.remove('show-node');
                            }
                        });
                        health_fields.forEach(e => {
                            if (e) {
                                e.classList.remove('show-node');
                            }
                        });
                        final_expense_fields.forEach(e => {
                            if (e) {
                                e.classList.remove('show-node');
                            }
                        });
                        car_fields.forEach(e => {
                            if (e) {
                                e.classList.add('show-node');
                            }
                        });
                        break;
                    case '3':
                        health_fields.forEach(e => {
                            if (e) {
                                e.classList.remove('show-node');
                            }
                        });
                        final_expense_fields.forEach(e => {
                            if (e) {
                                e.classList.remove('show-node');
                            }
                        });
                        homeowner_fields.forEach(e => {
                            if (e) {
                                e.classList.add('show-node');
                            }
                        });
                        car_fields.forEach(e => {
                            if (e) {
                                e.classList.add('show-node');
                            }
                        });
                        break;
                    case '4':
                        homeowner_fields.forEach(e => {
                            if (e) {
                                e.classList.remove('show-node');
                            }
                        });
                        car_fields.forEach(e => {
                            if (e) {
                                e.classList.remove('show-node');
                            }
                        });
                        final_expense_fields.forEach(e => {
                            if (e) {
                                e.classList.remove('show-node');
                            }
                        });
                        health_fields.forEach(e => {
                            if (e) {
                                e.classList.add('show-node');
                            }
                        });
                        break;
                    case '5':
                        homeowner_fields.forEach(e => {
                            if (e) {
                                e.classList.remove('show-node');
                            }
                        });
                        car_fields.forEach(e => {
                            if (e) {
                                e.classList.remove('show-node');
                            }
                        });
                        health_fields.forEach(e => {
                            if (e) {
                                e.classList.remove('show-node');
                            }
                        });
                        final_expense_fields.forEach(e => {
                            if (e) {
                                e.classList.add('show-node');
                            }
                        });
                        break;

                    default:
                        homeowner_fields.forEach(e => {
                            if (e) {
                                e.classList.remove('show-node');
                            }
                        });
                        car_fields.forEach(e => {
                            if (e) {
                                e.classList.remove('show-node');
                            }
                        });
                        health_fields.forEach(e => {
                            if (e) {
                                e.classList.remove('show-node');
                            }
                        });
                        final_expense_fields.forEach(e => {
                            if (e) {
                                e.classList.remove('show-node');
                            }
                        });
                        break;
                }
            }

            document.getElementById('quote').addEventListener('change', handleQuoteUpdate);
            handleQuoteUpdate();

            function validateNumber() {
                window.open('https://tcpa.tools/', 'Validate Phone Number',
                    'width=640,height=450');
                return false;
            }

            document.getElementById('checkNumber').addEventListener('click', validateNumber);

            const acceptedFormat = [
                "dd-mm-yyyy",
                "dd-LLLL-yyyy",
                "dd mm yyyy",
                "dd LLLL yyyy",
                "dd/mm/yyyy",
                "dd/LLLL/yyyy",
            ];

            const parseDate = (date) => {
                for (let i = 0; i < acceptedFormat.length; i++) {
                    const format = acceptedFormat[i];

                    const luxonDate = DateTime.fromFormat(date, format);
                    if (!luxonDate.invalidReason) {
                        return luxonDate;
                    }
                }
                return null;
            }

            const dateOfBirthInput = document.getElementById('dob');
            const ageInput = document.getElementById('calculatedAge');
            const calculateAge = () => {
                const error = document.querySelector('#dob ~ .invalid-feedback');
                if (error) {
                    error.remove();
                }

                if (dateOfBirthInput.value) {
                    const parsed_date = parseDate(dateOfBirthInput.value);
                    if (parsed_date) {
                        ageInput.value = Math.floor(DateTime.now().diff(parsed_date, 'years').toObject().years);
                    } else {
                        ageInput.value = "";
                        dateOfBirthInput.parentNode.insertAdjacentHTML('beforeend',
                            `<div class="invalid-feedback d-block">Date is unparseable! Parsable formats are: ${["01-12-1998", "01/12/1998", "01 12 1998"].join(", ")}</div>`
                            );
                    }
                    return;
                }

                ageInput.value = "";
            }

            dateOfBirthInput.addEventListener('keyup', calculateAge);
            dateOfBirthInput.addEventListener('update', calculateAge);
            dateOfBirthInput.addEventListener('change', calculateAge);
            $(document).ready(function() {
                calculateAge();
            })
        </script>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <form class="card" action="{{ route('leads.store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="card-header"><strong>Create Lead</strong></div>
                <div class="card-body">
                    @if (auth()->user()->hasRole('admin') ||
                        auth()->user()->hasRole('call center'))
                        <div class="form-group">
                            <label for="owner_email">Select Agent</label>
                            <select name="agent" id="selectCenterAgent">
                                <option value="" selected>Agent @if (!auth()->user()->hasRole('call center'))
                                        - [Call Center]
                                    @endif
                                </option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        @if (old('agent') == $user->id) selected @endif>{{ $user->name }}
                                        @if (!auth()->user()->hasRole('call center'))
                                            - [{{ ucfirst($user->call_center->name) }}]
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('agent')
                                <div class="text-danger font-weight-bold text-xsmall">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="quote">Quote Type</label>
                        <select name="quote" id="quote" class="form-control" required>
                            <option value="">Select Quote Type</option>
                            @foreach (\App\Models\Lead::$quoteTypes as $key => $type)
                                <option value="{{ $key }}" @if (old('quote') == $key) selected @endif>
                                    {{ ucwords($type) }}
                                </option>
                            @endforeach
                        </select>
                        @error('quote')
                            <div class="invalid-feedback d-block font-weight-bold text-xsmall">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fname">First Name</label>
                            <input class="form-control @error('fname') is-invalid @enderror" id="fname"
                                name="fname" type="text" placeholder="Enter first name"
                                value="{{ old('fname') }}" required>
                            @error('fname')
                                <div class="invalid-feedback d-block font-weight-bold text-xsmall">{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="lname">Last Name</label>
                            <input class="form-control @error('lname') is-invalid @enderror" id="lname"
                                name="lname" type="text" placeholder="Enter last name" value="{{ old('lname') }}"
                                required>
                            @error('lname')
                                <div class="invalid-feedback d-block font-weight-bold text-xsmall">{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="dob">Date of Birth</label>
                            <input class="form-control @error('dob') is-invalid @enderror" id="dob" name="dob"
                                type="text" placeholder="Enter date of birth dd/mm/yyyy"
                                value="{{ old('dob') ? \Carbon\Carbon::parse(old('dob'))->format('d-m-Y') : '' }}"
                                pattern="(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]|(?:Jan|Mar|May|Jul|Aug|Oct|Dec)))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2]|(?:Jan|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec))\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)(?:0?2|(?:Feb))\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9]|(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep))|(?:1[0-2]|(?:Oct|Nov|Dec)))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})"
                                required>
                            @error('dob')
                                <div class="invalid-feedback d-block font-weight-bold text-xsmall">{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="calculatedAge">Calculated Age</label>
                            <input type="number" class="form-control" id="calculatedAge" placeholder="Calculated Age"
                                disabled>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-9 form-group">
                            <label for="phone">Phone</label>
                            <input class="form-control @error('phone') is-invalid @enderror" id="phone"
                                name="phone" type="text" placeholder="Enter phone number"
                                value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="invalid-feedback d-block font-weight-bold text-xsmall">{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="" class="d-block">Validate</label>
                            <button type="button" class="btn btn-info" id="checkNumber">Check Number</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="address_line">Address Line</label>
                            <input class="form-control @error('address_line') is-invalid @enderror" id="address_line"
                                name="address_line" type="text" placeholder="Enter center address"
                                value="{{ old('address_line') }}">
                            @error('address_line')
                                <div class="invalid-feedback d-block font-weight-bold text-xsmall">{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="city">City</label>
                            <input class="form-control @error('city') is-invalid @enderror" id="city"
                                name="city" type="text" placeholder="Enter city name"
                                value="{{ old('city') }}">
                            @error('city')
                                <div class="invalid-feedback d-block font-weight-bold text-xsmall">{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6" style="z-index: 3050;">
                            <label for="state">State</label>
                            <select name="state" id="state" class="@error('state') is-invalid @enderror">
                                <option value="">Select State</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->name }}"
                                        @if (old('state') == $state->name || old('state') == $state->code) selected @endif>{{ $state->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('state')
                                <div class="invalid-feedback d-block font-weight-bold text-xsmall">{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="post_code">Post Code</label>
                            <input class="form-control @error('post_code') is-invalid @enderror" id="post_code"
                                name="post_code" type="text" placeholder="Enter post code"
                                value="{{ old('post_code') }}">
                            @error('post_code')
                                <div class="invalid-feedback d-block font-weight-bold text-xsmall">{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <input type="hidden" name="country" value="United States">

                    <div class="form-group conditional-show" id="ownerTypeField">
                        <label for="owner_type">Is homeowner?</label>
                        <select name="owner_type" id="owner_type"
                            class="form-control @error('owner_type') is-invalid @enderror">
                            <option value="">Is the person home owner</option>
                            @foreach (\App\Models\Lead::$ownerTypes as $value)
                                <option value="{{ $value }}"
                                    @if (old('owner_type') == $value) selected @endif>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('owner_type')
                            <div class="invalid-feedback d-block font-weight-bold text-xsmall">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group conditional-show" id="homeTypeField" style="z-index: 70;">
                        <label for="home_type">Home Type</label>
                        <select name="home_type" id="home_type">
                            <option value="">Select the Home type</option>
                            @foreach (\App\Models\Lead::$homeTypes as $value)
                                <option value="{{ $value }}"
                                    @if (old('home_type') == $value) selected @endif>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('home_type')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group conditional-show" id="insuredByField">
                        <label for="insured_by">Insured By</label>
                        <input class="form-control @error('insured_by') is-invalid @enderror" id="insured_by"
                            name="insured_by" type="text" placeholder="Enter the insurance owner"
                            value="{{ old('insured_by') }}">
                        @error('insured_by')
                            <div class="invalid-feedback d-block font-weight-bold text-xsmall">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group conditional-show" id="interestedInQuoteField" style="z-index: 2010;">
                        <label for="quote_interested_in">Interested In Quote</label>
                        <select name="quote_interested_in[]" id="quote_interested_in" multiple>
                            @foreach (\App\Models\Lead::$interestedInQuotes as $key => $value)
                                <option value="{{ $key }}"
                                    @if (in_array($key, old('quote_interested_in', []))) selected @endif>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('quote_interested_in')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group conditional-show" id="activeCheckingAccountField">
                        <label for="have_active_checking_account">Has an Active Checking Account</label>
                        <select name="have_active_checking_account" id="have_active_checking_account"
                            class="form-control">
                            <option value="">Select an Option</option>
                            @foreach (\App\Models\Lead::$activeCheckingAccountOptions as $key => $value)
                                <option value="{{ $key }}"
                                    @if (old('have_active_checking_account') == $key) ) selected @endif>{{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('have_active_checking_account')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group conditional-show" id="canPayThroughField" style="z-index: 1050;">
                        <label for="can_pay_through">Payment Through</label>
                        <select name="can_pay_through[]" id="can_pay_through" multiple>
                            @foreach (\App\Models\Lead::$canPayThroughOptions as $key => $value)
                                <option value="{{ $key }}"
                                    @if (in_array($key, old('can_pay_through', []))) selected @endif>{{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('can_pay_through')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6 conditional-show" id="hasActiveSsnField">
                            <label for="has_active_ssn">Active SSN</label>
                            <select name="has_active_ssn" id="has_active_ssn" class="form-control">
                                <option value="">Select an Option</option>
                                @foreach (\App\Models\Lead::$yesNoOptions as $key => $value)
                                    <option value="{{ $key }}"
                                        @if (old('has_active_ssn') == $key) ) selected @endif>{{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('has_active_ssn')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6 conditional-show" id="decisionMakerField">
                            <label for="decision_maker">Decision Maker</label>
                            <select name="decision_maker" id="decision_maker" class="form-control">
                                <option value="">Select an Option</option>
                                @foreach (\App\Models\Lead::$yesNoOptions as $key => $value)
                                    <option value="{{ $key }}"
                                        @if (old('decision_maker') == $key) ) selected @endif>{{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('decision_maker')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6 conditional-show" id="monthlyPayment_40_100Field">
                            <label for="monthly_payment_40_100">Monthly Payment 35$-75$</label>
                            <select name="monthly_payment_40_100" id="monthly_payment_40_100" class="form-control">
                                <option value="">Select an Option</option>
                                @foreach (\App\Models\Lead::$yesNoOptions as $key => $value)
                                    <option value="{{ $key }}"
                                        @if (old('monthly_payment_40_100') == $key) ) selected @endif>{{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('monthly_payment_40_100')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6 conditional-show" id="favFourDigitsField">
                            <label for="fav_four_digits">Your favorite 4 digits (Any Random numbers)</label>
                            <input type="text" name="fav_four_digits" id="fav_four_digits" class="form-control"
                                value="{{ old('fav_four_digits') }}"
                                placeholder="Enter four favorite digits" minlength="4" maxlength="4">
                            @error('fav_four_digits')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-12 conditional-show" id="moveForwardTodayField">
                            <label for="move_forward_today">If we find you an affordable option, are you willing to move forward with an application today?</label>
                            <select name="move_forward_today" id="move_forward_today" class="form-control">
                                <option value="">Select an Option</option>
                                @foreach (\App\Models\Lead::$yesNoOptions as $key => $value)
                                    <option value="{{ $key }}"
                                        @if (old('move_forward_today') == $key) ) selected @endif>{{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('move_forward_today')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6 conditional-show" id="anyCriticalIllnessField">
                            <label for="any_critical_illness">Any Critical Illness</label>
                            <select name="any_critical_illness" id="any_critical_illness" class="form-control">
                                <option value="">Select an Option</option>
                                @foreach (\App\Models\Lead::$yesNoOptions as $key => $value)
                                    <option value="{{ $key }}"
                                        @if (old('any_critical_illness') == $key) ) selected @endif>{{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('any_critical_illness')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6 conditional-show" id="criticalIllnessField">
                            <label for="critical_illness">Describe Illness</label>
                            <input type="text" name="critical_illness" id="critical_illness" class="form-control"
                                value="{{ old('critical_illness') }}"
                                placeholder="Describe Illness if 'critical illness' is yes.">
                            @error('critical_illness')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row align-items-end">
                        <div class="form-group col-md-4 conditional-show" id="homeBuiltAfter2006">
                            <label for="home_built_after_2006">House constructed in or after 2006?</label>
                            <select name="home_built_after_2006" id="home_built_after_2006" class="form-control">
                                <option value="">Select the correct option</option>
                                @foreach (['Not Applicable' => 'Not Applicable', 'Yes' => 'Yes', 'No' => 'No'] as $key => $value)
                                    <option value="{{ $key }}"
                                        @if ($key == old('home_built_after_2006')) selected @endif>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('home_built_after_2006')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4 conditional-show" id="home4MilesAwayFromWater">
                            <label for="home_4_miles_away_from_water">Is your property atleast 4 Miles away from any
                                water
                                front?</label>
                            <select name="home_4_miles_away_from_water" id="home_4_miles_away_from_water"
                                class="form-control">
                                <option value="">Select the correct option</option>
                                @foreach (['Not Applicable' => 'Not Applicable', 'Yes' => 'Yes', 'No' => 'No'] as $key => $value)
                                    <option value="{{ $key }}"
                                        @if ($key == old('home_4_miles_away_from_water')) selected @endif>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('home_4_miles_away_from_water')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4 conditional-show" id="condoBuiltAfter2001">
                            <label for="condo_built_after_2001">Apartment/Condo constructed in or after 2001?</label>
                            <select name="condo_built_after_2001" id="condo_built_after_2001" class="form-control">
                                <option value="">Select the correct option</option>
                                @foreach (['Not Applicable' => 'Not Applicable', 'Yes' => 'Yes', 'No' => 'No'] as $key => $value)
                                    <option value="{{ $key }}"
                                        @if ($key == old('condo_built_after_2001')) selected @endif>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('condo_built_after_2001')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group conditional-show" id="carFieldA">
                        <label for="cars_owned">Number of Cars Owned</label>
                        <select name="cars_owned" id="cars_owned"
                            class="form-control @error('cars_owned') is-invalid @enderror">
                            <option value="">Select the number of cars owned</option>
                            @for ($i = 0; $i < 11; $i++)
                                <option value="{{ $i }}"
                                    @if (old('cars_owned') == $i) selected @endif>{{ $i }}
                                </option>
                            @endfor
                        </select>
                        @error('cars_owned')
                            <div class="invalid-feedback d-block font-weight-bold text-xsmall">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group conditional-show" id="carFieldB">
                        <label for="description">Cars Description (Year, Make, Model)</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                            placeholder="Enter any other extra information about the lead here...." rows="6">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback d-block font-weight-bold text-xsmall">{{ $message }}</div>
                        @enderror
                    </div>

                    <input type="hidden" name="call_time" value="4">
                    <div class="form-group">
                        <label for="client">Lead Client</label>
                        <select name="client" id="selectLeadClient">
                            <option value="" selected>Select Client</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}"
                                    @if (old('client') == $client->id) selected @endif
                                    @if (!$client->currently_accepting_leads) disabled @endif>
                                    @if (auth()->user()->hasRole('admin'))
                                        {{ $client->id }} - {{ $client->name }}
                                    @else
                                        {{ $client->uid }}
                                    @endif
                                    @if (!$client->currently_accepting_leads)
                                        - Paused
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('client')
                            <div class="invalid-feedback d-block font-weight-bold text-xsmall">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="assign_type">Assign Type</label>
                        <select name="assign_type" class="form-control @error('assign_type') is-invalid @enderror">
                            <option value="" selected>Select lead assignment type</option>
                            @foreach (\App\Models\Lead::$assignTypes as $key => $type)
                                <option value="{{ $key }}"
                                    @if (old('assign_type') == $key) selected @endif>{{ ucwords($type) }}
                                </option>
                            @endforeach
                        </select>
                        @error('assign_type')
                            <div class="invalid-feedback d-block font-weight-bold text-xsmall">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Create</button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-layout>
