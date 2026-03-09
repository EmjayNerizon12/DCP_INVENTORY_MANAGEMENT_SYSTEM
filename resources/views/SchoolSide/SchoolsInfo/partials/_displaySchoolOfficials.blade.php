<div id="school_officials" class="sm:mx-5 mx-0">

	<form method="POST" id="schoolOfficialForm" action="{{ route('schoolOfficials.store') }}">
	</form>
	<input type="hidden" name="school_id" id="school_id" value="{{ Auth::guard('school')->user()->school->pk_school_id }}">
</div>

<script>
	const schoolOfficialForm = document.getElementById('schoolOfficialForm');
	const schoolId = document.getElementById('school_id').value;

	async function fetchEmployees(schoolId) {
		const response = await fetch(`/api/School/schoolEmployees/${schoolId}`);
		const res = await response.json();
		if (!response.ok) {
			alert('Failed to fetch data');
		}
		const data = res.data;
		return data;
	}
	async function fetchSchoolInformation(schoolId) {
		const response = await fetch(`/api/School/schoolInformation/${schoolId}`);
		const res = await response.json();
		if (!response.ok) {
			alert('Failed to fetch data');
		}
		const data = res.data;

		const employees = await fetchEmployees(schoolId);
		renderOfficialForm(data[0].school_officials[0], employees);

	}

	function renderOfficialForm(officials, employees) {
		schoolOfficialForm.innerHTML = `
        <div>
            <div class="page-title">School Officials Form </div>
            <div class="page-subtitle">Please fill out and submit the guided form</div>
            <div class="flex flex-col gap-4">
                <div>
                    <label class="form-label">1. School Head</label>
                    <select name="school_head" id="" class="form-input" required>
                        <option value="">Select</option>
                        ${employees.map(emp => `
                            <option value="${emp.pk_schools_employee_id}" ${officials?.school_head?.pk_schools_employee_id == emp.pk_schools_employee_id ? 'selected' : ' ' }>
                                ${emp.employee_number} - ${emp.fname} ${emp.mname ?? ''} ${emp.lname} ${emp.suffix_name ?? ''}
                            </option>
                        `).join('')}
                    </select>
                </div>
                <div>
                    <label class="form-label">2. School's ICT Coordinator</label>
                    <select name="ict_coordinator" id="" class="form-input" required>
                        <option value="">Select</option>
                        ${employees.map(emp => `
                            <option value="${emp.pk_schools_employee_id}" ${officials?.ict_coordinator?.pk_schools_employee_id == emp.pk_schools_employee_id ? 'selected' : ' ' }>
                                ${emp.employee_number} - ${emp.fname} ${emp.mname ?? ''} ${emp.lname} ${emp.suffix_name ?? ''}
                            </option>
                        `).join('')}
                    </select>
                </div>
                <div>
                    <label class="form-label">3. School's Property Custodian</label>
                    <select name="property_custodian" id="" class="form-input mb-2" required>
                        <option value="">Select</option>
                        ${employees.map(emp => `
                            <option value="${emp.pk_schools_employee_id}" ${officials?.property_custodian?.pk_schools_employee_id == emp.pk_schools_employee_id ? 'selected' : ' ' }>
                                ${emp.employee_number} - ${emp.fname} ${emp.mname ?? ''} ${emp.lname} ${emp.suffix_name ?? ''}
                            </option>
                        `).join('')}
                    </select>
                </div>
            </div>
            <div class="flex justify-end my-2">
                <button type="submit" id="officialFormButton" class="btn-submit py-1 px-4 rounded">
                    Save
                </button>
            </div>
            
        </div>
        `;
	}
	schoolOfficialForm.addEventListener('submit', async (e) => {
		const officialFormButton = document.getElementById('officialFormButton');
		e.preventDefault();
		buttonLoading(officialFormButton);
		const formData = new FormData(schoolOfficialForm);
		formData.append('school_id', schoolId);
		const response = await fetch(schoolOfficialForm.action, {
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
			resetButton(officialFormButton, 'Save')
			return;
		}
		renderStatusModal(data);
		schoolOfficialForm.reset();
		resetButton(officialFormButton, 'Save')
		fetchSchoolInformation(schoolId);
	});

	fetchSchoolInformation(schoolId);
</script>
