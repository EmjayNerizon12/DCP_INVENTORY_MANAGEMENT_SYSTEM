	<x-modal id="edit-modal" size="medium-modal" type="edit" icon="equipment-lg">

		<div class="flex flex-col items-center justify-center gap-0">
			<div class="text-center">
				<div class="page-title">Update Non-DCP Item </div>
				<div class="page-subtitle">This information will be included for reports.</div>
			</div>
		</div>
		<form action="{{ route('schools.nondcpitem.update') }}" method="POST" class="grid md:grid-cols-2 grid-cols-1 gap-2">
			@csrf
			@method('PUT')
			<input type="hidden" name="pk_non_dcp_item_id" id="pk_non_dcp_item_id">
			<div class="mb-2  md:col-span-1 col-span-2">
				<label for="item_description" class="form-label">Item Description</label>
				<textarea id="item_description" placeholder="eg. Computer, Laptop, Smart TV" name="item_description"
				 class="form-input"></textarea>
			</div>
			<div class="mb-2 md:col-span-1 col-span-2">
				<label for="unit_price" class="form-label">Unit Price</label>
				<input type="number" id="unit_price" step="0.01" name="unit_price" placeholder="0.00"
					class="form-input">
			</div>
			<div class="mb-2 md:col-span-1 col-span-2">
				<label for="date_acquired" class="form-label">Date Acquired</label>
				<input type="date" id="date_acquired" name="date_acquired" class="form-input">
			</div>
			<div class="mb-2 md:col-span-1 col-span-2">
				<label for="total_item" class="form-label">Total Item</label>
				<input placeholder="0" id="total_item" type="text" name="total_item"
					class="form-input">
			</div>
			<div class="mb-2 md:col-span-1 col-span-2">
				<label for="total_functional" class="form-label">Total Functional</label>
				<input type="text" placeholder="0" id="total_functional" name="total_functional"
					class="form-input">
			</div>
			<div class="mb-2 md:col-span-1 col-span-2">
				<label for="fund_source" class="form-label">Fund Source</label>
				<select name="fund_source_id" id="fund_source_id" class="form-input">
					@php
						$fund_sources = App\Models\FundSource::all();
					@endphp
					<option value="">Select </option>
					@foreach ($fund_sources as $fund_source)
						<option value="{{ $fund_source->pk_fund_source_id }}">{{ $fund_source->name }}</option>
					@endforeach
				</select>

			</div>
			<div class="mb-2 md:col-span-1 col-span-2">
				<label for="item_holder_and_location" class="form-label">Item Holder - Location</label>
				<textarea name="item_holder_and_location" id="item_holder_and_location" class="form-input"
				 placeholder="Name and Location of the Item User"></textarea>
			</div>
			<div class="mb-2 md:col-span-1 col-span-2">
				<label for="remarks" class="form-label">Remarks</label>
				<textarea name="remarks" id="remarks" class="form-input"
				 placeholder="Description of the Non-DCP item"></textarea>
			</div>
			<div class="flex md:justify-end justify-center  col-span-2 gap-2  ">
				<button type="button" class="md:w-auto w-full py-1 px-4 btn-cancel rounded   "
					onclick="document.getElementById('edit-modal').classList.add('hidden')">
					Cancel
				</button>
				<button type="submit" class="md:w-auto w-full  btn-green py-1 px-4   rounded   ">
					Update
				</button>
			</div>
		</form>

	</x-modal>
