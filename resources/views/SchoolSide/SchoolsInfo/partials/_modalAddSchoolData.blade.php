<x-modal id="add-schooldata-modal" size="medium-modal" type="add" icon="person-lg">

	<form id="school-data-form" method="POST" action="{{ route('school.submit.schooldata') }}">
		@csrf
		<div class="grid grid-cols-1 gap-4">
			<div class="flex justify-between">
				<div>
					<h3 class="page-title">Submit School Data</h3>
					<div class="page-subtitle">Encode your school data here</div>
				</div>

			</div>
			<div>
				<label class="form-label">Grade Level <span class="text-red-500">*</span></label>
				<select name="GradeLevelID" class="form-input" required>
					<option value="">-- Select Grade Level --</option>
					@foreach ($gradeLevels as $level)
						<option value="{{ $level['id'] }}" {{ in_array($level['id'], $submittedGradeLevels ?? []) ? 'disabled' : '' }}>
							{{ $level['name'] }}
						</option>
					@endforeach
				</select>
			</div>
			<div>
				<label class="form-label">Total Number of <b>Registered Learners</b> </label>
				<input type="number" name="RegisteredLearners" min="0"
					class="form-input" required>
			</div>
			<div>
				<label class="form-label">Total Number of <b>Teachers</b></label>
				<input type="number" name="Teachers" min="0" class="form-input"
					required>
			</div>
			<div>
				<label class="form-label">Total Number of <b>Sections</b></label>
				<input type="number" name="Sections" min="0" class="form-input"
					required>
			</div>
			<div>
				<label class="form-label"> Total Number of <b>Classrooms</b></label>
				<input type="number" name="Classrooms" min="0" class="form-input"
					required>
			</div>

		</div>
		<input type="hidden" name="pk_school_id" value="{{ Auth::guard('school')->user()->school->pk_school_id }}">
		<div class="my-2 flex md:justify-end justify-center gap-2 w-full">
            <button type="button" onclick="closeAddSchoolData()"
                class="btn-cancel px-4 py-1 sm:w-auto w-full rounded ">Cancel</button>
			<button type="submit"
				class="btn-submit px-4 py-1 sm:w-auto w-full  rounded">Save</button>
		</div>
	</form>

</x-modal>
