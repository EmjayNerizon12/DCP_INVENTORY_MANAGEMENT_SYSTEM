<script>
	const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
	const batchListUrl = @json(route('batch.list.json'));
	const batchDestroyUrlTemplate = @json(route('destroy.batch', ['batchId' => '___ID___']));
	const batchApproveUrlTemplate = @json(route('approve.batch', ['id' => '___ID___']));
	const batchItemsUrlTemplate = @json(route('index.items', ['batch' => '___ID___']));

	const packageItemsUrlTemplate = @json(url('/api/package-items/___ID___'));

	function escapeHtml(value) {
		return String(value ?? '')
			.replace(/&/g, '&amp;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;')
			.replace(/'/g, '&#039;');
	}

	function buildUrl(template, id) {
		return String(template).replace('___ID___', String(id));
	}

	function encodeBatchData(batch) {
		try {
			return encodeURIComponent(JSON.stringify(batch ?? {}));
		} catch (e) {
			return encodeURIComponent('{}');
		}
	}

	function setBatchListState({
		loading = false,
		empty = false
	} = {}) {
		const loadingEl = document.getElementById('batchCardLoading');
		const emptyEl = document.getElementById('batchCardEmpty');
		if (loadingEl) loadingEl.classList.toggle('hidden', !loading);
		if (emptyEl) emptyEl.classList.toggle('hidden', !empty);
	}

	function showContainer1() {
		document.getElementById('batch-list-display').style.display = 'block';
		document.getElementById('school-batch-list').style.display = 'none';

		const btnSchoolBatch = document.getElementById('btnSchoolBatch');
		const btnBatchList = document.getElementById('btnBatchList');

		btnSchoolBatch.classList.remove('theme-button');
		btnSchoolBatch.classList.add('btn-cancel');

		btnBatchList.classList.remove('btn-cancel');
		btnBatchList.classList.add('theme-button');
	}

	function showContainer2() {
		document.getElementById('batch-list-display').style.display = 'none';
		document.getElementById('school-batch-list').style.display = 'block';

		const btnSchoolBatch = document.getElementById('btnSchoolBatch');
		const btnBatchList = document.getElementById('btnBatchList');

		btnBatchList.classList.remove('theme-button');
		btnBatchList.classList.add('btn-cancel');

		btnSchoolBatch.classList.remove('btn-cancel');
		btnSchoolBatch.classList.add('theme-button');
	}

	function openCreateBatchModal() {
		const form = document.getElementById('batch-create-form');
		if (form) {
			form.reset();
			handleErrors({}, form);
		}

		const section = document.getElementById('create-batch-items-section');
		const container = document.getElementById('create-batch-items-flex-container');
		if (section) section.classList.add('hidden');
		if (container) container.innerHTML = '';

		openComponentModal('batch-create-modal');

		if (window.jQuery && jQuery.fn.select2) {
			jQuery('#create_school_id').trigger('change.select2');
		}
	}

	function openEditBatchModal(batch) {
		const form = document.getElementById('batch-edit-form');
		if (!form) return;

		handleErrors({}, form);

		document.getElementById('edit_id').value = batch.id ?? '';
		document.getElementById('edit_dcp_package_type_id').value = batch.dcp_package_type_id ?? '';
		document.getElementById('edit_school_id').value = batch.school_id ?? '';
		document.getElementById('edit_budget_year').value = batch.budget_year ?? '';
		document.getElementById('edit_batch_label_hidden').value = batch.batch_label ?? '';

		document.getElementById('edit_package_type_name').value = batch.package_type_name ?? '';
		document.getElementById('edit_school_name').value =
			`${batch.school_name ?? ''}${batch.school_level ? ' - ' + batch.school_level : ''}`;
		document.getElementById('edit_budget_year_display').value = batch.budget_year ?? '';
		document.getElementById('edit_batch_label_display').value = batch.batch_label ?? '';

		document.getElementById('edit_delivery_date').value = (batch.delivery_date ?? '').toString().slice(0, 10);
		document.getElementById('edit_supplier_name').value = batch.supplier_name ?? '';
		document.getElementById('edit_mode_of_delivery').value = batch.mode_of_delivery ?? '';
		// document.getElementById('edit_submission_status').value = batch.submission_status ?? 'For Editing';
		document.getElementById('edit_description').value = batch.description ?? '';

		openComponentModal('batch-edit-modal');
	}

	async function submitFormWithFetch(form, submitBtn, submitText) {
		if (!form) return {
			ok: false
		};
		setLoadingText(submitBtn);
		handleErrors({}, form);

		try {
			const res = await fetch(form.action, {
				method: 'POST',
				headers: {
					'Accept': 'application/json',
					'X-CSRF-TOKEN': csrfToken,
					'X-Requested-With': 'XMLHttpRequest',
				},
				body: new FormData(form),
			});

			const data = await res.json().catch(() => ({
				success: false,
				message: 'Invalid server response.',
			}));

			if (res.status === 422 && data.errors) {
				handleErrors(data.errors, form);
				return {
					ok: false,
					validation: true,
					data
				};
			}

			if (!res.ok || !data.success) {
				renderStatusModal({
					success: false,
					errors: data.message || 'Request failed.'
				});
				return {
					ok: false,
					data
				};
			}

			renderStatusModal({
				success: true,
				message: data.message || 'Saved successfully.'
			});
			return {
				ok: true,
				data
			};
		} catch (err) {
			console.error(err);
			renderStatusModal({
				success: false,
				errors: 'Network/server error. Please try again.'
			});
			return {
				ok: false
			};
		} finally {
			resetButtonText(submitBtn, submitText);
		}
	}

	async function deleteBatch(batchId) {
		if (!confirm('Are you sure you want to delete this batch?')) return {
			ok: false,
			cancelled: true
		};

		try {
			const res = await fetch(buildUrl(batchDestroyUrlTemplate, batchId), {
				method: 'DELETE',
				headers: {
					'Accept': 'application/json',
					'X-CSRF-TOKEN': csrfToken,
					'X-Requested-With': 'XMLHttpRequest',
				},
			});

			const data = await res.json().catch(() => ({
				success: false,
				message: 'Invalid server response.',
			}));

			if (!res.ok || !data.success) {
				renderStatusModal({
					success: false,
					errors: data.message || 'Delete failed.'
				});
				return {
					ok: false,
					data
				};
			}

			renderStatusModal({
				success: true,
				message: data.message || 'Deleted successfully.'
			});
			return {
				ok: true,
				data
			};
		} catch (err) {
			console.error(err);
			renderStatusModal({
				success: false,
				errors: 'Network/server error. Please try again.'
			});
			return {
				ok: false
			};
		}
	}

	async function approveBatch(batchId) {
		if (!confirm('Approve this batch?')) return {
			ok: false,
			cancelled: true
		};

		try {
			const res = await fetch(buildUrl(batchApproveUrlTemplate, batchId), {
				method: 'POST',
				headers: {
					'Accept': 'application/json',
					'X-CSRF-TOKEN': csrfToken,
					'X-Requested-With': 'XMLHttpRequest',
				},
			});

			const data = await res.json().catch(() => ({
				success: false,
				message: 'Invalid server response.',
			}));

			if (!res.ok || !data.success) {
				renderStatusModal({
					success: false,
					errors: data.message || 'Approve failed.'
				});
				return {
					ok: false,
					data
				};
			}

			renderStatusModal({
				success: true,
				message: data.message || 'Approved successfully.'
			});
			return {
				ok: true,
				data
			};
		} catch (err) {
			console.error(err);
			renderStatusModal({
				success: false,
				errors: 'Network/server error. Please try again.'
			});
			return {
				ok: false
			};
		}
	}

	function getExpandedBatchIds() {
		const expanded = new Set();
		document.querySelectorAll('#batchCardContainer .js-batch-details').forEach(el => {
			if (!el.classList.contains('hidden')) {
				const id = parseInt(el.getAttribute('data-batch-id'), 10);
				if (Number.isFinite(id)) expanded.add(id);
			}
		});
		return expanded;
	}

	function toggleBatchDetails(batchId) {
		const details = document.getElementById(`batch-details-${batchId}`);
		const btn = document.getElementById(`toggle-batch-details-${batchId}`);
		if (!details) return;

		details.classList.toggle('hidden');
		details.classList.toggle('block');

		if (btn) {
			const label = btn.querySelector('span');
			if (label) label.textContent = details.classList.contains('hidden') ? 'Show' : 'Hide';
		}
	}

	function statusBadge(batch) {
		if (batch.approval_status === 'Pending') {
			return `<x-badge color="yellow">For Approval</x-badge>`;
		}
		if (batch.approval_status === 'Approved') {
			return `<x-badge color="green">Approved: ${escapeHtml(batch.date_approved || '')}</x-badge>`;
		}
		return `<x-badge color="blue">For Submission</x-bad>`;
	}

	function renderBatches(batches, meta, expandedIds) {
		const container = document.getElementById('batchCardContainer');
		if (!container) return;

		if (!Array.isArray(batches) || batches.length === 0) {
			container.innerHTML = '';
			setBatchListState({
				loading: false,
				empty: true
			});
			renderPagination(meta);
			return;
		}

		const startIndex = meta?.from ? meta.from - 1 : 0;

		container.innerHTML = batches.map((batch, idx) => {
			const number = startIndex + idx + 1;
			const delivery = batch.delivery_date_formatted || '';

			const approveBtn = batch.approval_status === 'Pending' ?
				`<button type="button" class="btn-submit px-3 py-1 rounded" data-action="approve" data-batch-id="${batch.id}">Approve</button>` :
				'';

			return `
				<div id="card-${batch.id}" class="bg-white border border-gray-300 rounded shadow-md p-4 hover:shadow-lg transition">
					<div class="flex items-start justify-between gap-2">
						<div class="cursor-pointer flex-1" data-action="toggle" data-batch-id="${batch.id}">
							<div class="flex items-center font-bold gap-2 mb-2 tracking-wide">
								${number}. ${escapeHtml(batch.batch_label)}
							</div>
							<div class="flex flex-start">
								${statusBadge(batch)}
							</div>
							<div class="text-base text-gray-600 font-medium mt-2 tracking-wider">
								 <span class="font-bold">Recipient:</span>  ${escapeHtml(batch.school_name || 'N/A')}
							</div>
							<div class="flex justify-start">
								<x-badge color="green">${escapeHtml(batch.school_level || '')}</x-badge>
							</div>
						</div>
						<button id="toggle-batch-details-${batch.id}" type="button" class="btn-cancel px-3 py-1 rounded" data-action="toggle" data-batch-id="${batch.id}">
							<span> Show </span>
						</button>
					</div>

					<div id="batch-details-${batch.id}" data-batch-id="${batch.id}" class="js-batch-details mt-3 hidden">
						<p class="text-md text-gray-600 mb-1"><b>Package:</b> ${escapeHtml(batch.package_type_name || '')}</p>
						<p class="text-md text-gray-600 mb-1"><b>Description:</b> ${escapeHtml(batch.description || '')}</p>
						<p class="text-md text-gray-600 mb-1"><b>Delivery:</b> ${escapeHtml(delivery)}</p>
						<p class="text-md text-gray-600 mb-1"><b>Supplier:</b> ${escapeHtml(batch.supplier_name || '')}</p>
						<p class="text-md text-gray-600 mb-3"><b>Mode:</b> ${escapeHtml(batch.mode_of_delivery || '')}</p>

						<div class="flex flex-wrap gap-2">
							<button type="button" class="btn-submit px-3 py-1 rounded"><a href="${escapeHtml(buildUrl(batchItemsUrlTemplate, batch.id))}">Product</a></button>
							<button type="button" class="btn-update px-3 py-1 rounded" data-action="edit" data-batch="${encodeBatchData(batch)}">Edit</button>
							${approveBtn}
							<button type="button" class="btn-delete px-3 py-1 rounded" data-action="delete" data-batch-id="${batch.id}">Delete</button>
						</div>
					</div>
				</div>
			`;
		}).join('');

		setBatchListState({
			loading: false,
			empty: false
		});

		if (expandedIds && expandedIds.size) {
			expandedIds.forEach(id => toggleBatchDetails(id));
		}

		renderPagination(meta);
	}

	let batchState = {
		page: 1,
		q: '',
		per_page: 20
	};

	async function loadBatches({
		page,
		q,
		preserveExpanded = true
	} = {}) {
		const expanded = preserveExpanded ? getExpandedBatchIds() : new Set();
		if (typeof page === 'number') batchState.page = page;
		if (typeof q === 'string') batchState.q = q;

		setBatchListState({
			loading: true,
			empty: false
		});

		const url = new URL(batchListUrl, window.location.origin);
		url.searchParams.set('page', String(batchState.page));
		url.searchParams.set('per_page', String(batchState.per_page));
		if (batchState.q) url.searchParams.set('q', batchState.q);

		try {
			const res = await fetch(url.toString(), {
				method: 'GET',
				headers: {
					'Accept': 'application/json',
					'X-Requested-With': 'XMLHttpRequest',
				},
			});

			const payload = await res.json().catch(() => null);
			const data = payload?.data;

			if (!res.ok || !payload?.success || !data) {
				renderBatches([], {}, expanded);
				renderStatusModal({
					success: false,
					errors: payload?.message || 'Failed to load batches.'
				});
				return {
					ok: false
				};
			}

			renderBatches(data.batches || [], data.meta || {}, expanded);
			return {
				ok: true
			};
		} catch (err) {
			console.error(err);
			renderBatches([], {}, expanded);
			renderStatusModal({
				success: false,
				errors: 'Network/server error while loading batches.'
			});
			return {
				ok: false
			};
		} finally {
			setBatchListState({
				loading: false
			});
		}
	}

	function renderPagination(meta) {
		const el = document.getElementById('batchPagination');
		if (!el) return;

		const current = Number(meta?.current_page || 1);
		const last = Number(meta?.last_page || 1);
		const from = meta?.from ?? 0;
		const to = meta?.to ?? 0;
		const total = meta?.total ?? 0;

		if (!last || last <= 1) {
			el.innerHTML = total ? `<div class="text-sm text-gray-600">Showing ${from}-${to} of ${total}</div>` : '';
			return;
		}

		const pages = [];
		const start = Math.max(1, current - 2);
		const end = Math.min(last, current + 2);
		for (let p = start; p <= end; p++) pages.push(p);

		el.innerHTML = `
			<div class="text-sm text-gray-600">Showing ${from}-${to} of ${total}</div>
			<div class="flex flex-wrap gap-2 items-center justify-center">
				<button type="button" class="btn-cancel px-3 py-1 rounded" data-page="${Math.max(1, current - 1)}" ${current <= 1 ? 'disabled' : ''}>Prev</button>
				${pages.map(p => `
					<button type="button" class="${p === current ? 'btn-submit' : 'btn-cancel'} px-3 py-1 rounded" data-page="${p}">
						${p}
					</button>
				`).join('')}
				<button type="button" class="btn-submit px-3 py-1 rounded" data-page="${Math.min(last, current + 1)}" ${current >= last ? 'disabled' : ''}>Next</button>
			</div>
		`;
	}

	function updateCreateBatchLabel() {
		const packageTypeSelect = document.getElementById('create_package_type');
		const budgetYearInput = document.getElementById('create_budget_year');
		const batchLabelInput = document.getElementById('create_batch_label');
		if (!packageTypeSelect || !budgetYearInput || !batchLabelInput) return;

		const selectedOption = packageTypeSelect.options[packageTypeSelect.selectedIndex];
		const packageName = selectedOption ? selectedOption.text : '';
		const year = budgetYearInput.value;

		batchLabelInput.value = (packageName && year) ? `DCP ${year} - ${packageName}` : '';
	}

	async function refreshCreatePackageItems() {
		const packageSelect = document.getElementById('create_package_type');
		const itemsSection = document.getElementById('create-batch-items-section');
		const itemsFlexContainer = document.getElementById('create-batch-items-flex-container');
		const descriptionInput = document.getElementById('create_description');
		if (!packageSelect || !itemsSection || !itemsFlexContainer || !descriptionInput) return;

		const packageTypeId = packageSelect.value;
		itemsFlexContainer.innerHTML = '';

		if (!packageTypeId) {
			itemsSection.classList.add('hidden');
			return;
		}

		try {
			const res = await fetch(buildUrl(packageItemsUrlTemplate, packageTypeId), {
				headers: {
					'Accept': 'application/json'
				}
			});
			const data = await res.json().catch(() => []);

			if (!Array.isArray(data) || data.length === 0) {
				itemsSection.classList.add('hidden');
				return;
			}

			const bgColors = ['bg-red-100', 'bg-yellow-100', 'bg-green-100', 'bg-blue-100', 'bg-indigo-100',
				'bg-purple-100', 'bg-pink-100', 'bg-orange-100', 'bg-teal-100', 'bg-cyan-100'
			];
			const sorted = [...data].sort((a, b) => (Number(b.quantity) || 0) - (Number(a.quantity) || 0));

			const descriptionParts = [];
			sorted.forEach((item, index) => {
				const bgColor = bgColors[index % bgColors.length];
				itemsFlexContainer.insertAdjacentHTML('beforeend', `
					<div class="flex-1 min-w-[200px] border rounded shadow p-4 ${bgColor} text-center" style="border: 1px solid #282828;">
						<p class="text-gray-800"><b>${escapeHtml(item.quantity)}</b> - ${escapeHtml(item.item_name)}</p>
					</div>
				`);
				descriptionParts.push(`${item.quantity} ${item.item_name}`);
			});

			descriptionInput.value = `(${descriptionParts.join('; ')})`;
			itemsSection.classList.remove('hidden');
		} catch (err) {
			console.error(err);
			itemsSection.classList.add('hidden');
		}
	}

	async function loadSchools() {
		const tbody = document.getElementById('tbody-school');
		if (!tbody) return;
		tbody.innerHTML = '';

		const response = await fetch('/Admin/api/schools-with-packages');
		const res = await response.json();
		const data = res.schools || [];

		data.forEach((school, index) => {
			const row = document.createElement('tr');
			row.classList.add('school-rows');
			const batchDisplay = school.TotalBatch == 0
				? `<x-badge color="red">No Batch Received</x-badge>`
				: `<x-badge color="green">${escapeHtml(school.TotalBatch)} Batch Received</x-badge>`;
			row.innerHTML = `
				<td class="bg-white text-center">${index + 1}</td>
				<td class="bg-white tracking-wide">${escapeHtml(school.SchoolName)}</td>
				<td class="bg-white tracking-wide text-center">${escapeHtml(school.SchoolLevel)}</td>
				<td class="font-bold text-lg whitespace-nowrap" style="text-align:center;">
					${batchDisplay}
				</td>
				<td class="bg-white font-semibold whitespace-nowrap" style="text-align:right">
					₱ ${Number(school.TotalCost || 0).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
				</td>
			`;
			tbody.appendChild(row);
		});
	}

	document.addEventListener('DOMContentLoaded', function() {
		showContainer1();
		loadSchools();

		if (window.jQuery && jQuery.fn.select2) {
			jQuery('.select2').select2({
				placeholder: 'Select School',
				allowClear: true
			});
		}

		const createPackageType = document.getElementById('create_package_type');
		const createBudgetYear = document.getElementById('create_budget_year');
		if (createPackageType) {
			createPackageType.addEventListener('change', function() {
				updateCreateBatchLabel();
				refreshCreatePackageItems();
			});
		}
		if (createBudgetYear) createBudgetYear.addEventListener('input', updateCreateBatchLabel);

		const createForm = document.getElementById('batch-create-form');
		if (createForm) {
			createForm.addEventListener('submit', async function(e) {
				e.preventDefault();
				const submitBtn = document.getElementById('batchCreateSubmitBtn');
				const result = await submitFormWithFetch(createForm, submitBtn, 'Add DCP Batch');
				if (result.ok) {
					closeComponentModal('batch-create-modal');
					createForm.reset();
					await loadBatches({
						page: 1,
						preserveExpanded: false
					});
				}
			});
		}

		const editForm = document.getElementById('batch-edit-form');
		if (editForm) {
			editForm.addEventListener('submit', async function(e) {
				e.preventDefault();
				const submitBtn = document.getElementById('batchEditSubmitBtn');
				const result = await submitFormWithFetch(editForm, submitBtn, 'Update');
				if (result.ok) {
					closeComponentModal('batch-edit-modal');
					await loadBatches({
						preserveExpanded: true
					});
				}
			});
		}

		const searchInput = document.getElementById('searchBatch');
		let searchTimer = null;
		if (searchInput) {
			searchInput.addEventListener('input', function() {
				clearTimeout(searchTimer);
				searchTimer = setTimeout(() => {
					loadBatches({
						page: 1,
						q: searchInput.value || '',
						preserveExpanded: false
					});
				}, 350);
			});
		}

		const pagination = document.getElementById('batchPagination');
		if (pagination) {
			pagination.addEventListener('click', function(event) {
				const btn = event.target.closest('button[data-page]');
				if (!btn) return;
				if (btn.disabled) return;
				const page = parseInt(btn.getAttribute('data-page'), 10);
				if (!Number.isFinite(page)) return;
				loadBatches({
					page
				});
			});
		}

		const container = document.getElementById('batchCardContainer');
		if (container) {
			container.addEventListener('click', async function(event) {
				const actionEl = event.target.closest('[data-action]');
				if (!actionEl) return;

				const action = actionEl.getAttribute('data-action');
				const batchId = parseInt(actionEl.getAttribute('data-batch-id'), 10);

				if (action === 'toggle') {
					if (Number.isFinite(batchId)) toggleBatchDetails(batchId);
					return;
				}

				if (action === 'delete') {
					if (!Number.isFinite(batchId)) return;
					const result = await deleteBatch(batchId);
					if (result.ok) await loadBatches({
						preserveExpanded: false
					});
					return;
				}

				if (action === 'approve') {
					if (!Number.isFinite(batchId)) return;
					const result = await approveBatch(batchId);
					if (result.ok) await loadBatches({
						preserveExpanded: true
					});
					return;
				}

				if (action === 'edit') {
					const batchJson = actionEl.getAttribute('data-batch') || encodeURIComponent('{}');
					let batch = {};
					try {
						batch = JSON.parse(decodeURIComponent(batchJson));
					} catch (e) {
						batch = {};
					}
					openEditBatchModal(batch);
					return;
				}
			});
		}

		loadBatches({
			page: 1,
			preserveExpanded: false
		});
	});
</script>
