@extends('layout.Admin-Side')
<title>@yield('title', 'School Users')</title>

@section('content')
		<div class="p-2">
			<div class="mb-4 rounded-md border border-gray-200 bg-white p-4 shadow-md">
				<div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
					<div class="flex justify-start gap-2 items-center">
						<div class="h-10 w-10 bg-white p-3 border border-gray-300 shadow-lg rounded-md flex items-center justify-center">
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
						<div>
							<h2 class="page-title">School User Account</h2>
							<div class="page-subtitle">School User Account List</div>
						</div>
					</div>

					<div class="flex w-full flex-col gap-3 sm:flex-row lg:w-auto lg:items-center">
						<div class="w-full sm:w-40">
							<label for="viewSelector" class="sr-only">Select school user view</label>
							<select id="viewSelector" data-switch-selector class="form-input" onchange="toggleUserView(this.value)">
								<option value="0">Overview</option>
								<option value="1">Table</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div id="divContainer1">
				<div class="flex w-full sm:max-w-sm my-2">
					<div class="bg-blue-600 flex items-center px-3 rounded-l h-10">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
							stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
						</svg>
					</div>
					<input type="text" id="searchSchoolUser" placeholder="Search School..." class="form-input" />
				</div>
				<div id="schoolUsersCardContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2"></div>
				<div id="schoolUsersPagination" class="flex flex-wrap justify-center gap-2 my-5"></div>
			</div>
	        <div class="my-2">
	            <button class="btn-submit rounded px-4 py-1" onclick="window.print()">Print Document</button>
	        </div>
			<div class="hidden border border-gray-200 shadow p-4 bg-white" id="divContainer2">
				<div id="printableArea" class="bg-white ">
					<div id="list-account" class="bg-white"></div>
			</div>
		</div>

	</div>

	<script>
		const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
		const submitLoginRoute = "{{ route('submit-login') }}";
		const resetPasswordRoute = "{{ route('admin.reset.school_user.password') }}";

		function escapeJsString(value) {
			if (value === null || value === undefined) return '';
			return String(value).replace(/'/g, "\\'");
		}

		function renderUserCard(user) {
			const logo = user.image_path ? `/school-logo/${user.image_path}` : '/icon/logo.png';
			return `
				<div class="bg-gradient-to-br from-white to-gray-50 border border-gray-300 rounded-md p-6 shadow-sm hover:shadow-md transition duration-300">
					<div class="grid grid-cols-3 items-center justify-between mb-6">
						<div>
							<img class="md:w-24 md:h-24 w-20 h-20 rounded-full object-cover" src="${logo}" alt="">
						</div>
						<div class="col-span-2 flex flex-col justify-start">
							<div class="text-xl font-bold text-gray-900">${user.SchoolName ?? ''}</div>
							<div class="flex flex-wrap gap-2 mt-2">
								<x-badge color="blue">${user.SchoolLevel ?? ''} </x-badge>
								<x-badge color="green">${user.SchoolID ?? ''}</x-badge>
							</div>
						</div>
					</div>

					<div class="space-y-3">
						<div class="flex justify-between gap-4">
							<p class="text-sm text-gray-500">Username</p>
							<p class="text-sm font-medium text-gray-800 break-all">${user.user_username ?? ''}</p>
						</div>
						<div class="flex justify-between gap-4">
							<p class="text-sm text-gray-500">Default Password</p>
							<p class="text-sm font-medium text-gray-800">${user.default_password ?? ''}</p>
						</div>
					</div>

					<div class="border-t border-gray-200 my-6"></div>

					<div class="flex flex-wrap gap-3">
						<form action="${submitLoginRoute}" method="POST" onsubmit="return confirm('Are you sure you want to login this account directly?');">
							<input type="hidden" name="_token" value="${csrfToken}">
							<input type="hidden" name="username" value="${escapeJsString(user.user_username ?? '')}">
							<input type="hidden" name="password" value="${escapeJsString(user.default_password ?? '')}">
							<input type="hidden" name="fromAdmin" value="1">
							<button type="submit" class="btn-submit px-4 py-1 rounded">Log in</button>
						</form>

						<form action="${resetPasswordRoute}" method="POST" onsubmit="return confirm('Are you sure you want to reset this user\\'s password?');">
							<input type="hidden" name="_token" value="${csrfToken}">
							<input type="hidden" name="_method" value="PUT">
							<input type="hidden" name="id" value="${user.user_id}">
							<button type="submit" class="btn-cancel px-4 py-1 rounded">Reset Password</button>
						</form>
					</div>
				</div>
			`;
		}

		function renderPagination(pagination, query) {
			const paginationContainer = document.getElementById('schoolUsersPagination');
			if (!paginationContainer) return;

			const {
				current_page,
				last_page
			} = pagination;
			if (!last_page || last_page <= 1) {
				paginationContainer.innerHTML = '';
				return;
			}

			const makeBtn = (label, page, disabled = false, active = false) => `
				<button type="button"
					${disabled ? 'disabled' : ''}
					data-page="${page}"
					class="px-3 py-1 rounded border text-sm ${
						active ? 'bg-blue-600 text-white border-blue-600' : 'bg-white shadow text-gray-700 border-gray-300 hover:bg-gray-100'
					} ${disabled ? 'opacity-50 cursor-not-allowed' : ''}">
					${label}
				</button>`;

			let html = '';
			html += makeBtn('Prev', current_page - 1, current_page <= 1);

			for (let page = 1; page <= last_page; page++) {
				if (page === 1 || page === last_page || (page >= current_page - 1 && page <= current_page + 1)) {
					html += makeBtn(String(page), page, false, page === current_page);
				} else if (page === current_page - 2 || page === current_page + 2) {
					html += `<span class="px-1 text-gray-500">...</span>`;
				}
			}

			html += makeBtn('Next', current_page + 1, current_page >= last_page);
			paginationContainer.innerHTML = html;

			paginationContainer.querySelectorAll('button[data-page]').forEach((button) => {
				button.addEventListener('click', () => {
					const page = Number(button.dataset.page);
					if (Number.isFinite(page) && page > 0) {
						loadSchoolUsers(query, page);
					}
				});
			});
		}

		async function loadSchoolUsers(query = '', page = 1) {
			const target = document.getElementById('schoolUsersCardContainer');
			const normalizedQuery = query.trim();

			try {
				const response = await fetch(
					`api-get-accounts?query=${encodeURIComponent(normalizedQuery)}&page=${page}&per_page=6`
				);
				const payload = await response.json();
				const rows = payload?.data ?? [];
				const pagination = payload?.pagination ?? {};

				if (!rows.length) {
					target.innerHTML = '<p class="text-center text-gray-500 col-span-3">No results found.</p>';
					renderPagination({
						current_page: 1,
						last_page: 1
					}, normalizedQuery);
					return;
				}

				target.innerHTML = rows.map(renderUserCard).join('');
				renderPagination(pagination, normalizedQuery);
			} catch (error) {
				console.error('Search error:', error);
			}
		}

		let searchTimer = null;
		document.getElementById('searchSchoolUser')?.addEventListener('input', function() {
			const keyword = this.value;
			clearTimeout(searchTimer);
			searchTimer = setTimeout(() => loadSchoolUsers(keyword, 1), 300);
		});

		document.addEventListener('DOMContentLoaded', () => {
			loadSchoolUsers('', 1);
		});
		async function getAccountList() {
			const container = document.getElementById("list-account");
			const response = await fetch('api-get-accounts?all=1');
			const res = await response.json();
			const data = res.data ?? [];
			const table = document.createElement('table');
			table.classList.add('table', 'table-striped', 'table-bordered', 'table-hover', 'w-full');
			const printHeader = document.createElement('div');
			printHeader.innerHTML = `
              <div id="print-header"  class="w-full flex flex-col justify-center items-center mb-4">

                <img class="h-24 w-24 object-cover rounded-full border-2 border-gray-300"
                    src="{{ asset('icon/logo.png') }}"
                    alt="">
                 <div class="text-xl text-center font-semibold text-gray-700">DepEd Computerization Program (Management Information System)
                </div>
                <div class="text-lg text-center font-medium text-gray-700">Schools Division Office - San Carlos City Division
                </div>
            </div>

            `;
			const thead = document.createElement('thead');
			thead.innerHTML = `
                <tr >
                    <th class="secondary-header text-center">No.</th>
                    <th class="secondary-header">School Name</th>
                    <th class="secondary-header">School Level</th>
                    <th class="secondary-header">Email Address</th>
                    <th class="secondary-header">Default Password</th>
                </tr>
            `;
			const tbody = document.createElement('tbody');
			data.forEach((obj, index) => {
				if (obj.default_password != 'admin') {

					tbody.innerHTML += `
                    <tr>
                    <td class="td-cell text-center">${index + 1}</td>
                    <td class="td-cell">${obj.SchoolName ?? ''}</td>
                    <td class="td-cell">${obj.SchoolLevel ?? ''}</td>
                    <td class="td-cell">${obj.user_username ?? ''}</td>
                    <td class="td-cell whitespace-nowrap">${obj.default_password}</td>
                    </tr>
                    `;
				}
			});
			table.appendChild(thead);
			table.appendChild(tbody);
			container.appendChild(printHeader);
			container.appendChild(table);
			console.log(res.data);
		}
		getAccountList();
	</script>
	@include('AdminSide.partials._scriptSwitchButton')
@endsection
