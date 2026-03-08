<x-modal id="batch-edit-modal" size="super-large-modal" type="edit" icon="product-lg">
	<form id="batch-edit-form" method="POST" action="{{ route('update.batch') }}" class="flex flex-col gap-2 mt-4">
		@csrf
		@method('PUT')

		<div class="text-2xl font-bold mb-2 flex w-full justify-center items-center gap-2">
			Edit DCP Batch
			<x-badge color="yellow">Update</x-badge>
		</div>

		<input type="hidden" name="id" id="edit_id">

		<!-- Disabled fields (submitted via hidden inputs) -->
		<input type="hidden" name="dcp_package_type_id" id="edit_dcp_package_type_id">
		<input type="hidden" name="school_id" id="edit_school_id">
		<input type="hidden" name="budget_year" id="edit_budget_year">
		<input type="hidden" name="batch_label" id="edit_batch_label_hidden">

		<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
			<div>
				<label class="form-label">Package Type</label>
				<input type="text" id="edit_package_type_name" class="form-input bg-gray-100" readonly>
			</div>

			<div>
				<label class="form-label">Recipient School</label>
				<input type="text" id="edit_school_name" class="form-input bg-gray-100" readonly>
			</div>

			<div>
				<label class="form-label">Budget Year</label>
				<input type="number" id="edit_budget_year_display" class="form-input bg-gray-100" readonly>
			</div>

			<div class="sm:col-span-3">
                <label class="form-label  flex gap-2 items-center">Batch Label <x-badge color="green">Auto Generated</x-badge> <x-badge color="blue">Read Only</x-badge></label>
				<input type="text" id="edit_batch_label_display" class="form-input bg-gray-100" readonly>
				<div class="text-red-600 text-sm mt-1" data-error="batch_label"></div>
			</div>

			<div>
				<label class="form-label">Delivery Date <span class="text-red-600">*</span></label>
				<input type="date" name="delivery_date" id="edit_delivery_date" class="form-input" required>
				<div class="text-red-600 text-sm mt-1" data-error="delivery_date"></div>
			</div>

			<div>
				<label class="form-label">Supplier Name <span class="text-red-600">*</span></label>
				@php
					$suppliers = \App\Models\DCPItemBrand::all();
				@endphp
				<select name="supplier_name" id="edit_supplier_name" class="form-input" required>
					<option value="">Select Supplier</option>
					@foreach ($suppliers as $supplier)
						<option value="{{ $supplier->name }}">{{ $supplier->name }}</option>
					@endforeach
				</select>
				<div class="text-red-600 text-sm mt-1" data-error="supplier_name"></div>
			</div>

			<div>
				<label class="form-label">Mode of Delivery <span class="text-red-600">*</span></label>
				@php
					$modes = \App\Models\DCPItemModeDelivery::all();
				@endphp
				<select name="mode_of_delivery" id="edit_mode_of_delivery" class="form-input" required>
					<option value="">Select Mode of Delivery</option>
					@foreach ($modes as $mode)
						<option value="{{ $mode->name }}">{{ $mode->name }}</option>
					@endforeach
				</select>
				<div class="text-red-600 text-sm mt-1" data-error="mode_of_delivery"></div>
			</div>

			<div class="hidden">
				<label class="form-label">Submission Status <span class="text-red-600">*</span></label>
				<select name="submission_status" id="edit_submission_status" class="form-input" required>
					<option value="FOR EDITING">For Editing</option>
					<option value="FOR UPDATING">For Updating</option>
					<option value="APPROVED">Approved</option>
				</select>
				<div class="text-red-600 text-sm mt-1" data-error="submission_status"></div>
			</div>

			<div class="md:col-span-3">
                <label class="form-label  flex gap-2 items-center">Description <x-badge color="green">Auto Generated</x-badge> <x-badge color="yellow">Editable</x-badge></label>
				<textarea name="description" id="edit_description" class="form-input"></textarea>
				<div class="text-red-600 text-sm mt-1" data-error="description"></div>
			</div>
		</div>

		<div class="modal-button-container">
			<button type="button" onclick="closeComponentModal('batch-edit-modal')" class="btn-cancel rounded sm:w-fit w-full px-4 py-1 rounded">
				Cancel
			</button>
			<button id="batchEditSubmitBtn" type="submit" class="btn-green px-4 py-1 rounded sm:w-fit w-full">
				Update
			</button>
		</div>
	</form>
</x-modal>
