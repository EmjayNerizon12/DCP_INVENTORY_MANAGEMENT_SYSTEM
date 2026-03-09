<x-modal id="add-school-modal" size="large-modal" type="add" icon="school-lg">
	<div class="page-title">Create School</div>
	<div class="page-subtitle">Recipient of DepEd Computerization Program</div>
	<form id="school_add_form" class="space-y-4" action="{{ route('store.schools') }}" enctype="multipart/form-data">
		@csrf
		<div>
			<label for="SchoolID" class="form-label">School ID</label>
			<input type="text" name="SchoolID" id="SchoolID"
				class="form-input" required />
		</div>
		<div>
			<label for="SchoolName" class="form-label">School Name</label>
			<input type="text" name="SchoolName" id="SchoolName"
				class="form-input" required />
		</div>
		<div>
			<label for="SchoolEmailAddress" class="form-label">School Email
				Address</label>
			<input type="email" name="SchoolEmailAddress" id="SchoolEmailAddress"
				class="form-input" required />
		</div>
		<div>
			<label for="SchoolLevel" class="form-label">School Level</label>
			<select name="SchoolLevel" id="SchoolLevel"
				class="form-input" required>
				<option value="" disabled selected>-- Select School Level --</option>
				<option value="Elementary School">Elementary School</option>
				<option value="Junior High School">Junior High School</option>
				<option value="Senior High School">Senior High School</option>
			</select>
		</div>
		<div class="w-full flex flex-col">
			<label class="form-label">School Location (Select on Map)</label>
			<div id="map" style="height: 180px; border-radius: 8px; margin-bottom: 8px; z-index: 0"></div>
			<div class="flex gap-2">
				<div class="w-1/2 flex flex-col">
					<label for="Latitude" class="form-label">Latitude</label>
					<input type="text" name="Latitude" id="latitude" class="px-3 py-2 border border-gray-300 rounded"
						placeholder="Latitude" readonly required>
				</div>
				<div class="w-1/2 flex flex-col">
					<label for="Longitude" class="form-label">Longitude</label>
					<input type="text" name="Longitude" id="longitude" class="px-3 py-2 border border-gray-300 rounded"
						placeholder="Longitude" readonly required>
				</div>
			</div>
		</div>
        <div class="modal-button-container">
            <button type="button" onclick="closeComponentModal('add-school-modal')"
                class="btn-cancel rounded sm:w-fit w-full  px-4 py-1 rounded">
                Cancel
            </button>
            <button type="submit" id="addCCTVButton" class="btn-submit px-4 py-1 rounded sm:w-fit w-full ">
                Save 
            </button>
        </div>
	</form>

</x-modal>
