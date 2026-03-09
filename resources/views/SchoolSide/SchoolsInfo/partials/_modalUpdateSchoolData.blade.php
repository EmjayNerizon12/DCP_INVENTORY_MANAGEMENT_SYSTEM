<x-modal id="school-data-form_update" size="medium-modal" type="edit" icon="person-lg">

	<form id="school-data-form_update" method="POST" action="{{ route('school.update.schooldata') }}">
		<div class="page-title">Update School Data Form</div>
		<div class="page-subtitle">School Information</div>
		@csrf
		@method('PUT')

		<input type="hidden" id="pk" name="pk">
		<div class="grid grid-cols-1  gap-4">
			<div>
				<label class="form-label">Grade Level <span class="text-red-500">*</span></label>
				<select name="GradeLevelID" id="GradeLevelID" class="form-input" required>

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
				<input type="number" name="RegisteredLearners" id="RegisteredLearners" min="0" class="form-input" required>
			</div>
			<div>
				<label class="form-label">Total Number of <b>Teachers</b></label>
				<input type="number" name="Teachers" id="Teachers" min="0" class="form-input" required>
			</div>
			<div>
				<label class="form-label">Total Number of <b>Sections</b></label>
				<input type="number" name="Sections" id="Sections" min="0" class="form-input" required>
			</div>
			<div>
				<label class="form-label"> Total Number of <b>Classrooms</b></label>
				<input type="number" name="Classrooms" id="Classrooms" min="0" class="form-input" required>
			</div>

		</div>
		<input type="hidden" name="pk_school_id" value="{{ Auth::guard('school')->user()->school->pk_school_id }}">

		<div class="my-2 flex md:justify-end justify-center gap-2 w-full">
			<button type="button" onclick="closeEditModal()"
				class="btn-cancel px-4 py-1 sm:w-auto w-full rounded ">Cancel</button>
			<button type="submit" class="btn-green px-4 py-1 sm:w-auto w-full  rounded">Update</button>
		</div>
	</form>

</x-modal>
