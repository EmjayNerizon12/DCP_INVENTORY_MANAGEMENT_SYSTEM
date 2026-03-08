@extends('layout.Admin-Side')
<title>@yield('title', 'DCP Dashboard')</title>

@section('content')
	<style>
		.table {
			border-collapse: collapse;
			width: 100%;
			border: 1px solid #282828;
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
		}

		.table th,
		.table td {
			border: 1px solid #989898;
			padding: 10px;
			text-align: left;
		}

		.table th {
			background: #e9e9e9;
			color: #333;
		}

		.school-rows {
			text-align: center;
		}

		button {
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			letter-spacing: 0.05rem;
			font-weight: 500 !important;
		}

		input,
		textarea,
		select {
			border: 1px solid #ccc
		}
	</style>

	<!-- Select2 (used in modals) -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

	@include('AdminSide.DCPBatch.Batch._addModal')
	@include('AdminSide.DCPBatch.Batch._editModal')

	<div class="p-2">
		<div class="flex md:flex-row flex-col justify-between items-center">
			<div class="flex justify-start gap-2 items-center w-full">
				<div class="h-10 w-10 bg-white border border-gray-300 shadow-lg rounded-md flex items-center justify-center">
					<div class="text-white p-1 bg-blue-600 rounded-md">
						<svg viewBox="0 0 24 24" class="w-8 h-8" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M4 15.8294V15.75V8C4 7.69114 4.16659 7.40629 4.43579 7.25487L4.45131 7.24614L11.6182 3.21475L11.6727 3.18411C11.8759 3.06979 12.1241 3.06979 12.3273 3.18411L19.6105 7.28092C19.8511 7.41625 20 7.67083 20 7.94687V8V15.75V15.8294C20 16.1119 19.8506 16.3733 19.6073 16.5167L12.379 20.7766C12.1451 20.9144 11.8549 20.9144 11.621 20.7766L4.39267 16.5167C4.14935 16.3733 4 16.1119 4 15.8294Z"
								stroke="currentColor" stroke-width="2"></path>
							<path d="M12 21V12" stroke="currentColor" stroke-width="2"></path>
							<path d="M12 12L4 7.5" stroke="currentColor" stroke-width="2"></path>
							<path d="M20 7.5L12 12" stroke="currentColor" stroke-width="2"></path>
						</svg>
					</div>
				</div>

				<div class="tracking-wider">
					<h2 class="text-2xl font-bold text-gray-800 uppercase">DCP Batch List</h2>
					<div class="text-lg text-gray-600 mb-2">List of Batches assigned in every Schools</div>
				</div>
			</div>
			<div class="w-full flex md:justify-end justify-start my-2">
				<button type="button" onclick="openCreateBatchModal()" class="btn-submit py-1  px-4 rounded">
					Add Batch
				</button>
			</div>
		</div>

		<div class="my-3 flex justify-end gap-2 w-full">
			<button id="btnBatchList" type="button" class="theme-button px-4 py-1 rounded" onclick="showContainer1()">
				Overview
			</button>
			<button id="btnSchoolBatch" type="button" class="btn-cancel px-4 py-1 rounded" onclick="showContainer2()">
				Table
			</button>
		</div>

		<div id="batch-list-display">
			@include('AdminSide.DCPBatch.Batch._cards')
			<div class="form-label">Search</div>
			
			<div class="flex w-full sm:max-w-sm items-stretch my-2 ">
				<div class="bg-blue-600 flex items-center px-3 rounded-l h-10">
					@include('svg.search-sm')
				</div>
				<input type="text" id="searchBatch"
					class="form-input" />
			</div>
		
			<div id="batchCardLoading" class="text-center text-gray-500 py-8">Loading batches...</div>
			<div id="batchCardEmpty" class="text-center text-gray-500 py-8 hidden">No batches found.</div>
			<div id="batchCardContainer" class="grid grid-cols-1 xl:grid-cols-3 sm:grid-cols-2 gap-4"></div>
			<div id="batchPagination" class="mt-4 flex flex-col md:flex-row items-center justify-between gap-2"></div>
		</div>

		<div id="school-batch-list" class="overflow-x-auto thin-scroll" style="display:none">
			<table class="table bg-white">
				<thead class="text-gray-700 uppercase text-md">
					<tr class="top-header">
						<td colspan="5">DCP Batch Cost per school</td>
					</tr>
					<tr class="sub-header">
						<td class="text-center">No.</td>
						<td>School Name</td>
						<td>School Level</td>
						<td class="text-center">Total Batch Received</td>
						<td>Overall Cost</td>
					</tr>
				</thead>
				<tbody id="tbody-school"></tbody>
			</table>
		</div>
	</div>

	@include('AdminSide.DCPBatch.Batch._script')
@endsection

