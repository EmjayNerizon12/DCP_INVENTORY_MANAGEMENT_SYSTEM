@extends('layout.Admin-Side')

<title>@yield('title', 'DCP Dashboard')</title>

@section('content')
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

	<style>
		button {
			letter-spacing: 0.05rem;
			font-weight: 500 !important;
		}

		input[type="text"] {
			border: 1px solid #ccc;
			width: 100%;
			min-width: 0;
			box-sizing: border-box;
			font-size: 0.95rem;
			padding: 0.5rem 0.75rem;
		}

		.add-school-flex {
			display: flex;
			flex-direction: row;
			align-items: stretch;
			justify-content: center;
			width: 100%;
		}

		.add-school-col {
			background: #fff;
			border-radius: 0.5rem;
			padding: 1rem 1rem;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			min-width: 220px;
			flex: 1 1 0;
		}

		.add-school-logo {
			object-fit: cover;
			border-radius: 50%;
			border: 2px solid #e5e7eb;
			box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.08);
			margin-bottom: 1rem;
		}

		@media (max-width: 900px) {
			.add-school-flex {
				flex-direction: column;
			}

			.add-school-col {
				min-width: unset;
				width: 100%;
			}
		}
	</style>

	<div id="school-errors" class="hidden mt-2">
		<ul class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded text-md" id="school-errors-list"></ul>

	</div>

	<div id="school-result" class="hidden mt-2">
		<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded flex items-center gap-2 text-md">
			<svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
			</svg>
			<span id="school-result-message"></span>
		</div>
	</div>

	<div class="p-2">

		<div class=" flex justify-start gap-2 items-center mb-2">
			<div class="h-10 w-10 p-3 border border-gray-300 shadow-lg rounded-md flex items-center justify-center">
				<div class="text-white bg-blue-600 p-1 rounded-md">
					<svg viewBox="0 0 24 24" class="h-8 w-8" fill="none" xmlns="http://www.w3.org/2000/svg">
						<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
						<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
						<g id="SVGRepo_iconCarrier">
							<path
								d="M21 10L12 5L3 10L6 11.6667M21 10L18 11.6667M21 10V10C21.6129 10.3064 22 10.9328 22 11.618V16.9998M6 11.6667L12 15L18 11.6667M6 11.6667V17.6667L12 21L18 17.6667L18 11.6667"
								stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							</path>
						</g>
					</svg>
				</div>
			</div>
			<div style="letter-spacing: 0.05rem  ">
				<h2 class="page-title">School Recipient</h2>
				<div class="page-subtitle">DCP Package Recipient
				</div>
			</div>
		</div>

		<div class="my-2 w-full flex justify-between sm:flex-row flex-col gap-2">
			
			<div class="flex w-full sm:max-w-sm items-stretch">
				<div class="bg-blue-600 flex items-center px-3 rounded-l h-10">
					<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
						stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
					</svg>
				</div>
				<input type="text" id="searchSchool" placeholder="Search School..."
					class="form-input" />
			</div>
            <div>
				<button class="btn-submit px-4 py-1 rounded" onclick="openAddModal()" type="button">
					Add School
				</button>
			</div>

		</div>
			<div id="schoolCardGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2"></div>
			<div id="schoolPagination" class="my-5 flex flex-wrap justify-center gap-2"></div>
	</div>
	@include('AdminSide.School.partials._addModal')
	@include('AdminSide.School.partials._editModal')
	@include('AdminSide.School.partials._script')

@endsection
