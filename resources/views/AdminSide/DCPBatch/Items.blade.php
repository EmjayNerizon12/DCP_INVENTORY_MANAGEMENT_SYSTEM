{{-- filepath: resources/views/AdminSide/DCPBatch/Items.blade.php --}}

@extends('layout.Admin-Side')

@section('title', 'Batch Items')

@section('content')
	<div class="p-2">
		<div class=" flex justify-start gap-2 items-center mb-2">
			<div class="h-10 w-10 bg-white p-3 border border-gray-300 shadow-lg rounded-md flex items-center justify-center">
				<div class="text-white bg-blue-600 p-1 rounded-md">
					<svg viewBox="0 0 24 24" class="w-8 h-8" fill="none" xmlns="http://www.w3.org/2000/svg">
						<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
						<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
						<g id="SVGRepo_iconCarrier">
							<path
								d="M4 15.8294V15.75V8C4 7.69114 4.16659 7.40629 4.43579 7.25487L4.45131 7.24614L11.6182 3.21475L11.6727 3.18411C11.8759 3.06979 12.1241 3.06979 12.3273 3.18411L19.6105 7.28092C19.8511 7.41625 20 7.67083 20 7.94687V8V15.75V15.8294C20 16.1119 19.8506 16.3733 19.6073 16.5167L12.379 20.7766C12.1451 20.9144 11.8549 20.9144 11.621 20.7766L4.39267 16.5167C4.14935 16.3733 4 16.1119 4 15.8294Z"
								stroke="currentColor" stroke-width="2"></path>
							<path d="M12 21V12" stroke="currentColor" stroke-width="2"></path>
							<path d="M12 12L4 7.5" stroke="currentColor" stroke-width="2"></path>
							<path d="M20 7.5L12 12" stroke="currentColor" stroke-width="2"></path>
						</g>
					</svg>
				</div>
			</div>
			<div class="w-full" style="letter-spacing: 0.05rem flex flex-col items-center">
				<div class="page-title">Batch Items List</div>
				<div class="page-subtitle">For Viewing and Monitoring the items in the batch</div>
			</div>
		</div>

		@php
			$groupedItems = $items->groupBy('item_type_id');
		@endphp

		<div class="space-y-6">
			@foreach ($groupedItems as $typeId => $groupByType)
				@php
					$itemType = $itemTypes->firstWhere('pk_dcp_item_types_id', $typeId);
					$itemTypeName = $itemType->name ?? 'Unknown Type';
					$groupedByName = $groupByType->groupBy('item_name');
				@endphp

				<div class="border-l-4 border-blue-500 pl-3">
					<h3 class="text-xl font-bold text-blue-700">{{ $itemTypeName }}</h3>
				</div>

				<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
					@foreach ($groupedByName as $itemName => $groupedItemsByName)
						@foreach ($groupedItemsByName as $item)
							<div class="bg-white tracking-wider shadow rounded border border-gray-300 p-4 hover:shadow-lg transition">
								<h4 class="text-lg font-bold text-gray-800 mb-2">
									{{ $itemName ?? 'Unnamed Item' }}
								</h4>
								<p class="text-gray-700"><span class="font-bold">Generated Code:</span>
									{{ $item->generated_code }}</p>
                                <hr>
								<p class="text-gray-700"><span class="font-bold">Price:</span>
									₱{{ number_format($item->unit_price, 2) }}</p>
								<p class="text-gray-700"><span class="font-bold">Quantity:</span>
									{{ $item->quantity }} {{ $item->unit }}</p>
								<p class="text-gray-700"><span class="font-bold">Condition:</span>
									{{ $item->dcpCondition->name ?? 'N/A' }}</p>
								@php
									$brandName = null;
									if ($item->brand) {
									    $brandName = App\Models\DCPBatchItemBrand::where('pk_dcp_batch_item_brands_id', $item->brand)->value(
									        'brand_name',
									    );
									}
								@endphp
								<p class="text-gray-700"><span class="font-bold">Brand:</span>
									{{ $brandName ?? 'N/A' }}</p>
								<p class="text-gray-700"><span class="font-bold">Serial No.:</span>
									{{ $item->serial_number ?? 'N/A' }}</p>
                                <div class="my-2 flex justify-end">
                                    <button
                                        type="button"
                                        onclick="window.location.href='{{ route('index.product.view', ['code' => $item->generated_code]) }}'"
                                        class="btn-submit px-4 py-1 rounded"
                                    >
                                        View
                                    </button>
                                </div>
								</div>
							@endforeach
						@endforeach
					</div>
				@endforeach
			</div>
		</div>
	@endsection
