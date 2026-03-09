<div class="sm:mx-5 mx-0">
	@if (Auth::guard('school')->user() && Auth::guard('school')->user()->school)
		<div>
			<div class="page-title">School Information Form </div>
			<div class="page-subtitle">Please fill out and submit the guided form</div>

			<form method="POST" id="schoolInformationForm" action="{{ route('school.details.update') }}"
				enctype="multipart/form-data">
				@csrf
				<input type="text" value="{{ Auth::guard('school')->user()->school->pk_school_id }}" name="pk_school_id"
					class="hidden" />
				<input type="text" id="SchoolLevelInput" value="{{ Auth::guard('school')->user()->school->SchoolLevel }}"
					class="hidden" />
				<input type="hidden" name="Region" value="Region I" />
				<input type="hidden" name="Province" value="Pangasinan" />
				<input type="hidden" name="CityMunicipality" value="San Carlos City" />
				<input type="hidden" name="Division" value="San Carlos City" />

				<div class="flex flex-col justify-center gap-2">
					<!-- Section 1: School Details -->
					<div class="w-full bg-white rounded-md overflow-hidden mt-1 p-2">
						<h3 class="text-2xl font-semibold text-blue-700 mb-2">1. School Details</h3>

						<div class="flex flex-col mb-2">
							<label for="SchoolAddress" class="form-label">School Complete Address</label>
							<textarea class="form-input" name="SchoolAddress">{{ Auth::guard('school')->user()->school->SchoolAddress ?? '' }}</textarea>
						</div>

						<div class="flex flex-col mb-2">
							<label class="form-label">Mobile No. 1 <span class="text-red-500">*</span></label>
							<input type="text" name="SchoolContactNumber"
								value="{{ Auth::guard('school')->user()->school->SchoolContactNumber }}" placeholder="+63 000 000 0000"
								class="form-input" />
						</div>

						<div class="flex flex-col mb-2">
							<label class="form-label">Mobile No. 2 <span class="text-red-500">Leave Blank if None</span></label>
							<input type="text" name="SchoolContactNumber2"
								value="{{ Auth::guard('school')->user()->school->SchoolContactNumber2 }}" placeholder="+63 000 000 0000"
								class="form-input" />
						</div>

						<div class="flex flex-col mb-2">
							<label class="form-label">Landline No. <span class="text-red-500">Leave Blank if None</span></label>
							<input type="text" name="SchoolTelNumber" value="{{ Auth::guard('school')->user()->school->SchoolTelNumber }}"
								class="form-input" />
						</div>

						<div class="flex flex-col">
							<label for="District" class="form-label">District <span class="text-red-500">*</span></label>
							<select name="District" id="District" class="form-input"></select>
						</div>
					</div>

					<!-- Section 2: School Coordinates -->
					<div class="w-full bg-white rounded-md overflow-hidden p-2">
						<h3 class="text-2xl font-semibold text-blue-700 mb-2">2. School Coordinates</h3>

						<div class="flex flex-col mb-2">
							<label for="latitude" class="form-label">Latitude</label>
							<input class="form-input" value="{{ Auth::guard('school')->user()->school->schoolCoordinates->Latitude ?? '' }}"
								type="text" name="latitude" disabled>
						</div>

						<div class="flex flex-col mb-2">
							<label for="longitude" class="form-label">Longitude</label>
							<input class="form-input" value="{{ Auth::guard('school')->user()->school->schoolCoordinates->Longitude ?? '' }}"
								type="text" name="longitude" disabled>
						</div>

						<div class="flex-col mb-2">
							<label class="form-label">Is Considered Remote <span class="text-red-500">*</span></label>
							@php
								$isRemote = optional(Auth::guard('school')->user()->school->schoolCoordinates)->is_considered_remote;
							@endphp
							<div class="flex items-center gap-4">
								<label class="flex items-center gap-1">
									<input type="radio" name="is_considered_remote" value="1" {{ $isRemote === 1 ? 'checked' : '' }}>
									<span>True</span>
								</label>
								<label class="flex items-center gap-1">
									<input type="radio" name="is_considered_remote" value="0" {{ $isRemote === 0 ? 'checked' : '' }}>
									<span>False</span>
								</label>
							</div>
						</div>

						<div class="flex-col">
							<label for="uacs" class="form-label">UACS <span class="text-red-500">*</span></label>
							<input class="form-input" value="{{ Auth::guard('school')->user()->school->schoolCoordinates->uacs ?? '' }}"
								type="text" name="uacs">
						</div>
					</div>

					<!-- Section 3: Admin Information -->
					<div class="w-full bg-white rounded-md overflow-hidden p-2">
						<h3 class="text-2xl font-semibold text-blue-700 mb-4">3. School Admin Information</h3>

						<div class="flex flex-col mb-2">
							<label for="admin_position" class="form-label">Admin Position</label>
							<select name="admin_position" class="form-input">
								<option value="">Select Admin Position</option>
								<option value="RO"
									{{ optional(Auth::guard('school')->user()->school)->admin_position === 'RO' ? 'selected' : '' }}>RO</option>
								<option value="SDO Chief"
									{{ optional(Auth::guard('school')->user()->school)->admin_position === 'SDO Chief' ? 'selected' : '' }}>SDO
									Chief</option>
								<option value="School Principal"
									{{ optional(Auth::guard('school')->user()->school)->admin_position === 'School Principal' ? 'selected' : '' }}>
									School Principal</option>
								<option value="Administrator"
									{{ optional(Auth::guard('school')->user()->school)->admin_position === 'Administrator' ? 'selected' : '' }}>
									Administrator</option>
							</select>
						</div>

						<div class="flex flex-col mb-2">
							<label for="admin_email" class="form-label">Admin Email Address</label>
							<input class="form-input" value="{{ Auth::guard('school')->user()->school->admin_email ?? '' }}"
								type="email" name="admin_email">
						</div>

						<div class="flex flex-col mb-2">
							<label for="admin_mobile_no" class="form-label">Admin Mobile No.</label>
							<input class="form-input" value="{{ Auth::guard('school')->user()->school->admin_mobile_no ?? '' }}"
								type="text" name="admin_mobile_no">
						</div>

						<h3 class="text-xl font-semibold text-blue-700 mb-2">Admin Staff Information</h3>

						<div class="flex flex-col mb-2">
							<label for="admin_staff_email" class="form-label">Admin Staff Email</label>
							<input class="form-input" value="{{ Auth::guard('school')->user()->school->admin_staff_email ?? '' }}"
								type="email" name="admin_staff_email">
						</div>

						<div class="flex flex-col">
							<label for="admin_staff_mobile_no" class="form-label">Admin Staff Mobile No.</label>
							<input class="form-input" value="{{ Auth::guard('school')->user()->school->admin_staff_mobile_no ?? '' }}"
								type="text" name="admin_staff_mobile_no">
						</div>
					</div>

					<!-- Section 4: School Information -->
					<div class="w-full bg-white rounded-md overflow-hidden p-2">
						<h3 class="text-2xl font-semibold text-blue-700 mb-4">4. School Information</h3>

						<div class="flex-col mb-2">
							<label class="form-label">Has Network Administrator? <span class="text-red-500">*</span></label>
							@php
								$network = optional(Auth::guard('school')->user()->school)->has_network_admin;
							@endphp
							<div class="flex items-center gap-4">
								<label class="flex items-center gap-1">
									<input type="radio" name="has_network_admin" value="1" {{ $network == 1 ? 'checked' : '' }}>
									<span>True</span>
								</label>
								<label class="flex items-center gap-1">
									<input type="radio" name="has_network_admin" value="0" {{ $network == 0 ? 'checked' : '' }}>
									<span>False</span>
								</label>
							</div>
						</div>

						<div class="flex-col mb-2">
							<label class="form-label">Has Sufficient Bandwidth for Internet Needs? <span
									class="text-red-500">*</span></label>
							@php
								$has_bandwidth = optional(Auth::guard('school')->user()->school)->has_bandwidth;
							@endphp
							<div class="flex items-center gap-4">
								<label class="flex items-center gap-1">
									<input type="radio" name="has_bandwidth" value="1" {{ $has_bandwidth == 1 ? 'checked' : '' }}>
									<span>True</span>
								</label>
								<label class="flex items-center gap-1">
									<input type="radio" name="has_bandwidth" value="0" {{ $has_bandwidth == 0 ? 'checked' : '' }}>
									<span>False</span>
								</label>
							</div>
						</div>

						<div class="flex flex-col mb-2">
							<label for="total_no_teaching" class="form-label">No. of Non-Teaching Staff</label>
							<input class="form-input" value="{{ Auth::guard('school')->user()->school->total_no_teaching ?? '' }}"
								type="text" name="total_no_teaching">
						</div>

						<div class="flex-col">
							<label for="classroom_with_tv" class="form-label">No. of Classrooms with TV</label>
							<input class="form-input" value="{{ Auth::guard('school')->user()->school->classroom_with_tv ?? '' }}"
								type="text" name="classroom_with_tv">
						</div>
					</div>

					<div class="flex justify-end p-2">
						<button type="submit" id="informationFormBtn" class="btn-submit flex items-center gap-1 py-1 px-4 rounded">
							Save 
						</button>
					</div>
				</div>
			</form>
		</div>
	@else
		<div class="bg-white rounded-md shadow-md overflow-hidden p-6 text-center">
			<h3 class="text-lg font-semibold text-red-600 mb-4">No school information found for this account.</h3>
			<p class="text-gray-600">Please contact your administrator to link your account to a school.</p>
		</div>
	@endif
</div>

<script>
	const schoolInformationForm = document.getElementById('schoolInformationForm');
	const informationFormBtn = document.getElementById('informationFormBtn');
	schoolInformationForm.addEventListener('submit', async (e) => {
		e.preventDefault();
		const formData = new FormData(schoolInformationForm);
		buttonLoading(informationFormBtn);
		const response = await fetch(schoolInformationForm.action, {
			method: 'POST',
			headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}',
				'Accept': 'application/json',
			},
			body: formData
		});
		const data = await response.json();
		if (!response.ok) {
			handleErrors(data.errors);
			resetButton(informationFormBtn, 'Save')
			return;
		}
		renderStatusModal(data);
		resetButton(informationFormBtn, 'Save')
	});
</script>
