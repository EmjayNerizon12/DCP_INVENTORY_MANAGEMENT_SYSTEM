@extends('layout.Admin-Side')

<title>@yield('title', 'DCP Dashboard')</title>

@section('content')
	<div class="p-2">
		<div class="rounded-lg overflow-hidden  py-2">

			<div class="grid md:grid-cols-4 grid-cols-2 gap-4 mb-4">

				<!-- Total Schools -->
				<div class="bg-white shadow-md rounded-md border border-gray-300 p-5 flex flex-col justify-between">
					<div class="flex flex-col space-y-0 w-full gap-4 items-center justify-center">

						<div class="dashboard-icon-container">
							<div class="  bg-blue-600 dashboard-icon">
								<svg class="w-10 h-10" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
									<path d="M21 10L12 5L3 10L12 15L21 10Z" stroke-linecap="round" stroke-linejoin="round" />
									<path d="M6 11.5V17.5L12 21L18 17.5V11.5" stroke-linecap="round" stroke-linejoin="round" />
									<path d="M21 10V17" stroke-linecap="round" stroke-linejoin="round" />
								</svg>
							</div>
						</div>

						<div class="w-full">
							<p class="dashboard-card-label">Total Number of Schools</p>
							<h3 class="dashboard-card-value">{{ $totalSchools }}</h3>
						</div>
						<div class="flex justify-end items-center ">
							<a href="{{ url('Schools/index') }}" class="admin-button btn-submit px-4 py-1 rounded">
								Schools
							</a>
						</div>
					</div>
				</div>

				<!-- Total Batches -->
				<div class="bg-white shadow-md rounded-md border border-gray-300 p-5 flex flex-col justify-between">
					<div class="flex flex-col   w-full gap-4 items-center justify-center">

						<div class="dashboard-icon-container">
							<div class="bg-green-600 dashboard-icon">
								<!-- Clipboard Icon -->
								<svg class="w-10 h-10" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
									<path d="M12 12V21" stroke-linecap="round" stroke-linejoin="round" />
									<path d="M20 8L12 12L4 8" stroke-linecap="round" stroke-linejoin="round" />
									<path
										d="M11 2.6L19 7C20 7.6 20 8 20 9V16C20 17 20 17.6 19 18L12 22L5 18C4 17.6 4 17 4 16V9C4 8 4 7.6 5 7L11 2.6Z"
										stroke-linecap="round" stroke-linejoin="round" />
								</svg>
							</div>
						</div>
						<div class="w-full">
							<p class="dashboard-card-label">Total DCP Batch
							</p>
							<h3 class="dashboard-card-value">
								{{ $totalBatches }}</h3>
						</div>

						<div class="flex justify-end items-center  ">
							<a href="{{ url('Admin/DCPBatch/index') }}" class="admin-button btn-green px-4 py-1 rounded">
								Batches
							</a>
						</div>
					</div>
				</div>

				<!-- Total Items -->
				<div class="bg-white shadow-md rounded-md   border border-gray-300 p-5 flex flex-col justify-between">
					<div class="flex flex-col w-full gap-4 items-center justify-center">
						<div class="dashboard-icon-container">

							<div class="bg-yellow-500 dashboard-icon">
								<!-- Archive Icon -->
								<svg class="w-10 h-10" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
									<path d="M3 7H21V10H3V7Z" stroke-linecap="round" stroke-linejoin="round" />
									<path d="M5 10H19V18C19 19 18 20 17 20H7C6 20 5 19 5 18V10Z" stroke-linecap="round" stroke-linejoin="round" />
									<path d="M9 14H15" stroke-linecap="round" stroke-linejoin="round" />
								</svg>
							</div>
						</div>
						<div class="w-full">
							<p class="dashboard-card-label">Total DCP Items</p>
							<h3 class="dashboard-card-value">{{ $totalItems }}</h3>
						</div>

						<div class="flex justify-end items-center ">
							<a href="{{ url('item-type') }}" class="admin-button btn-update px-4 py-1 rounded">
								Items
							</a>
						</div>
					</div>
				</div>
				<div class="bg-white shadow-md rounded-md border border-gray-300 p-5 flex flex-col justify-between">
					<div class="flex flex-col w-full gap-4 items-center justify-center">
						<div class="dashboard-icon-container">

							<div class="bg-red-600 text-white dashboard-icon">
								<!-- Cube Icon -->
								<svg class="md:w-10 md:h-10 w-8 h-8" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
									<path d="M12 3L3 8V16L12 21L21 16V8L12 3Z" stroke-linecap="round" stroke-linejoin="round" />
									<path d="M3.5 7.8L12 12.5L20.5 7.8" stroke-linecap="round" stroke-linejoin="round" />
									<path d="M12 12.5V21" stroke-linecap="round" stroke-linejoin="round" />
								</svg>
							</div>
						</div>
						<div class="w-full">
							<p class="dashboard-card-label">Total DCP Package</p>
							<h3 class="dashboard-card-value">{{ $totalPackages }}</h3>
						</div>

						<div class="flex justify-end items-center ">
							<a href="{{ url('package-type/create') }}" class="admin-button btn-delete px-4 py-1 rounded">
								Packages
							</a>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div style="letter-spacing: 0.05rem" class="md:text-xl text-lg font-semibold text-gray-800  my-2 mt-5">School
			Equipments Summary</div>
		<div class="grid grid-cols-2 md:grid-cols-4 md:gap-2 gap-2   my-2 ">
			<!-- Total Schools Card -->
			<div class="bg-white rounded-sm border border-gray-300 shadow-md p-1 text-center">
				<div class="bg-blue-600 h-full text-white p-4 text-center">

					<h2 class="page-subtitle text-white">Total Number of Schools</h2>
					<p id="total_schools" class="page-title text-white">--</p>
				</div>
			</div>
			<!-- ISP Card -->
			<div class="bg-white rounded-sm shadow-md p-1 border border-gray-300 text-center">
				<div style="background-color:#F7931E;" class="  h-full text-white p-4 text-center">

					<h2 class="page-subtitle text-white">Total Number of Schools with Internet </h2>
					<p id="isp_count" class="page-title text-white">--</p>
				</div>
			</div>

			<!-- Biometric Card -->
			<div class="bg-white rounded-sm shadow-md p-1 border border-gray-300 text-center">
				<div style="background-color:#8DC63F;" class="  h-full text-white p-4 text-center">

					<h2 class="page-subtitle text-white">Total Number of Schools with Biometrics</h2>
					<p id="biometric_count" class="page-title text-white">--</p>
				</div>
			</div>
			<!-- CCTV Card -->
			<div class="bg-white rounded-sm shadow-md border border-gray-300 p-1 text-center">
				<div style="background-color:#4CAF50;" class="  h-full text-white p-4 text-center">

					<h2 class="page-subtitle text-white">Total Number of Schools with CCTV</h2>
					<p id="cctv_count" class="page-title text-white">--</p>
				</div>
			</div>

		</div>

		<div style="letter-spacing: 0.05rem" class="md:text-xl text-lg font-semibold text-gray-800 my-2 mt-5">DCP Batch
			Items Summary</div>
		<div class="grid grid-cols-1 overflow-x-auto">
			<div id="card-condition-container" class="grid md:grid-cols-3 grid-cols-2 md:gap-4 gap-2 mb-2    ">

			</div>
			<table class="table w-full bg-white  border-collapse border border-gray-300 mt-3" style="letter-spacing: 0.05rem">
				<thead>
					<tr class="top-header">
						<th colspan="3" class="px-4">DCP Product Conditions</th>
					</tr>
					<tr class="sub-header">
						<td class="px-4">Condition</td>
						<td class="px-4">Count</td>
						<td class="px-4">Visualization</td>
					</tr>
				</thead>
				<tbody id="condition-table"></tbody>
			</table>

			<style>
				.progress-container {
					width: 100%;
					background: #e5e7eb;
					/* gray-300 */
					border-radius: 6px;
					height: 20px;
					overflow: hidden;
				}

				.progress-bar {
					height: 100%;
					border-radius: 6px;
					transition: width 0.4s ease;
				}
			</style>
		</div>

		<div class="my-2">
			<div class="flex overflow-x-auto gap-3 py-4">
				<button id="btn-item" type="button" class="tab-btn theme-button px-4 py-1 rounded" aria-controls="tab-item"
					aria-selected="true">
					DCP Product
				</button>

				<button id="btn-package" type="button" class="tab-btn btn-cancel px-4 py-1 rounded" aria-controls="tab-package"
					aria-selected="false">
					DCP Package
				</button>

				<button id="btn-school" type="button" class="tab-btn btn-cancel px-4 py-1 rounded" aria-controls="tab-school"
					aria-selected="false">
					DCP Batch
				</button>
			</div>
			<div id="tab-item" class="tab-content" role="tabpanel" aria-labelledby="btn-item">
				<div class="bg-white border border-gray-300 rounded-lg shadow-md p-6">
					<div class="flex md:flex-row flex-col gap-4">
						<div class="w-full">
							<div class="h-[400px]"><canvas id="myPieChart"></canvas></div>
						</div>
						<div class="w-full">
							<table class="border-collapse w-full table-auto" style="letter-spacing:0.05rem">
								<thead class="bg-white sticky top-0">
									<tr>
										<th class="px-4 py-2 border border-gray-300 uppercase">Item Type</th>
										<th class="px-4 py-2 border border-gray-300 uppercase">Count</th>
									</tr>
								</thead>
								<tbody id="item-type-table"></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<!-- TAB CONTENT 2 -->
			<div id="tab-package" class="tab-content hidden" hidden role="tabpanel" aria-labelledby="btn-package">
				<div class="bg-white border border-gray-300 rounded-lg shadow-md p-6 max-w-full overflow-x-auto thin-scroll">
					<div class="flex md:flex-row flex-col gap-4">
						<div class="w-full">
							<div class="h-[400px]"><canvas id="pie_package"></canvas></div>
						</div>
						<div class="overflow-y-auto shadow-md w-full">
							<table class="border-collapse w-full" style="letter-spacing:0.05rem">
								<thead class="bg-white sticky top-0">
									<tr>
										<th class="px-4 py-2 border border-gray-300 uppercase">Package Code</th>
										<th class="px-4 py-2 border border-gray-300 uppercase">Package Name</th>
										<th class="px-4 py-2 border border-gray-300 uppercase">Total Package Acquired</th>
									</tr>
								</thead>
								<tbody id="package-type-table"></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<!-- TAB CONTENT 3 -->
			<div id="tab-school" class="tab-content hidden" hidden role="tabpanel" aria-labelledby="btn-school">
				<div class="bg-white border border-gray-300 rounded-lg shadow-md p-6">
					<div class="h-[400px] overflow-y-auto">
						<canvas id="school_pie"></canvas>
					</div>
				</div>
			</div>

		</div>
	</div>
	@include('AdminSide.Dashboard.partials._script')
@endsection
