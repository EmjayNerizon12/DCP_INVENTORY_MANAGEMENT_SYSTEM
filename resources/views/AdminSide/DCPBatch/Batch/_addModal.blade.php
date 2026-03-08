<x-modal id="batch-create-modal" size="super-large-modal" type="add" icon="product-lg">
	<form id="batch-create-form" method="POST" action="{{ route('store.batch') }}" class="flex flex-col gap-2 mt-4">
		@csrf

		<div class="text-2xl font-bold mb-2 flex w-full justify-center items-center gap-2">
			Create DCP Batch Recipient
			<x-badge color="blue">New</x-badge>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
			<div>
				<label class="form-label">Package Type <span class="text-red-600">*</span></label>
				<select name="dcp_package_type_id" id="create_package_type" class="form-input" required>
					<option value="">Select Package</option>
					@foreach ($packageTypes as $type)
						<option value="{{ $type->pk_dcp_package_types_id }}">{{ $type->name }}</option>
					@endforeach
				</select>
				<div class="text-red-600 text-sm mt-1" data-error="dcp_package_type_id"></div>
			</div>

			<div>
				<label class="form-label">Recipient School <span class="text-red-600">*</span></label>
				<select name="school_id" id="create_school_id" class="form-input select2" style="width: 100%;" required>
					<option value="">Select School</option>
					@foreach ($schools as $school)
						<option value="{{ $school->pk_school_id }}">
							{{ $school->SchoolName }} - {{ $school->SchoolLevel }}
						</option>
					@endforeach
				</select>
				<div class="text-red-600 text-sm mt-1" data-error="school_id"></div>
			</div>

			<div>
				<label class="form-label">Budget Year <span class="text-red-600">*</span></label>
				<input type="number" name="budget_year" id="create_budget_year" class="form-input" required>
				<div class="text-red-600 text-sm mt-1" data-error="budget_year"></div>
			</div>

			<div class="sm:col-span-3">
				<label class="form-label  flex gap-2 items-center">Batch Label <x-badge color="blue">Auto Generated</x-badge></label>
				<input type="text" name="batch_label" id="create_batch_label" readonly class="form-input bg-gray-100" required>
				<div class="text-red-600 text-sm mt-1" data-error="batch_label"></div>
			</div>

			<div>
				<label class="form-label">Delivery Date <span class="text-red-600">*</span></label>
				<input type="date" name="delivery_date" id="create_delivery_date" class="form-input" required>
				<div class="text-red-600 text-sm mt-1" data-error="delivery_date"></div>
			</div>

			<div>
				<label class="form-label">Supplier Name <span class="text-red-600">*</span></label>
				@php
					$suppliers = \App\Models\DCPItemBrand::all();
				@endphp
				<select name="supplier_name" id="create_supplier_name" class="form-input" required>
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
				<select name="mode_of_delivery" id="create_mode_of_delivery" class="form-input" required>
					<option value="">Select Mode of Delivery</option>
					@foreach ($modes as $mode)
						<option value="{{ $mode->name }}">{{ $mode->name }}</option>
					@endforeach
				</select>
				<div class="text-red-600 text-sm mt-1" data-error="mode_of_delivery"></div>
			</div>

			<div class="hidden">
				<label class="form-label">Submission Status</label>
				<input type="text" class="form-input bg-gray-100" value="For Editing" readonly>
				<input type="hidden" name="submission_status" value="For Editing">
				<div class="text-red-600 text-sm mt-1" data-error="submission_status"></div>
			</div>

			<div class="sm:col-span-3">
				<label class="form-label flex gap-2 items-center">Description <x-badge color="blue">Auto Generated</x-badge></label>
				<textarea name="description" id="create_description" class="form-input"></textarea>
				<div class="text-red-600 text-sm mt-1" data-error="description"></div>
			</div>

			<div id="create-batch-items-section" class="w-full overflow-hidden col-span-1 md:col-span-3 hidden">
				<h3 class="text-lg form-label mb-2">Package Contents</h3>
				<div id="create-batch-items-flex-container" class="flex flex-col md:flex-row flex-wrap gap-4 mx-5"
					style="font-family: Verdana, Geneva, Tahoma, sans-serif"></div>
			</div>
		</div>

		<div class="modal-button-container">
			<button type="button" onclick="closeComponentModal('batch-create-modal')" class="btn-cancel rounded sm:w-fit w-full px-4 py-1 rounded">
				Cancel
			</button>
			<button id="batchCreateSubmitBtn" type="submit" class="btn-submit px-4 py-1 rounded sm:w-fit w-full">
				Add DCP Batch
			</button>
		</div>
	</form>
</x-modal>
