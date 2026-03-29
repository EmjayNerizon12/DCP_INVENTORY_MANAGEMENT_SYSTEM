<div class="grid sm:grid-cols-4 grid-cols-1 md:gap-4 gap-2 my-4">
	<div class="flex items-center gap-4 bg-white border border-gray-300 shadow rounded p-4 transition hover:shadow-lg">
		<div class="flex items-center justify-center p-1 rounded-full shadow-sm border border-gray-300 bg-white">
			<div class="flex items-center justify-center sm:w-12 sm:h-12 h-8 w-8 rounded-full bg-yellow-400 text-white">
				@include('svg.clock-lg')
			</div>
		</div>
		<div>
			<div class="sm:text-lg text-sm font-semibold uppercase text-gray-700">Pending</div>
			<p class="sm:text-2xl text-lg font-bold text-yellow-600">{{ $total_pending }}</p>
		</div>
	</div>

	<div class="flex items-center gap-4 bg-white border border-gray-300 shadow rounded p-4 transition hover:shadow-lg">
		<div class="flex items-center justify-center p-1 rounded-full shadow-sm border border-gray-300 bg-white">
			<div class="flex items-center justify-center sm:w-12 sm:h-12 h-8 w-8 rounded-full bg-gray-500 text-white">
				@include('svg.clock-lg')
			</div>
		</div>
		<div>
			<div class="sm:text-lg text-sm font-semibold uppercase text-gray-700">Not Submitted</div>
			<p class="sm:text-2xl text-lg font-bold text-gray-600">{{ $total_unsubmitted }}</p>
		</div>
	</div>

	<div class="flex items-center gap-4 bg-white border border-gray-300 shadow rounded p-4 transition hover:shadow-lg">
		<div class="flex items-center justify-center p-1 rounded-full shadow-sm border border-gray-300 bg-white">
			<div class="flex items-center justify-center sm:w-12 sm:h-12 h-8 w-8 rounded-full text-white bg-green-600">
				@include('svg.check-lg')
			</div>
		</div>
		<div>
			<h3 class="sm:text-lg text-sm font-semibold uppercase text-gray-700">Approved</h3>
			<p class="sm:text-2xl text-lg font-bold text-green-600">{{ $total_approved }}</p>
		</div>
	</div>

	<div class="flex items-center gap-4 bg-white border border-gray-300 shadow rounded p-4 transition hover:shadow-lg">
		<div class="flex items-center justify-center p-1 rounded-full shadow-sm border border-gray-300 bg-white">
			<div class="flex items-center justify-center sm:w-12 sm:h-12 h-8 w-8 rounded-full text-white bg-blue-600">
				@include('svg.product-lg')
			</div>
		</div>
		<div>
			<h3 class="sm:text-lg text-sm font-semibold uppercase text-gray-700">Batches</h3>
			<p class="sm:text-2xl text-lg font-bold text-blue-600">{{ $total_batches }}</p>
		</div>
	</div>
</div>

