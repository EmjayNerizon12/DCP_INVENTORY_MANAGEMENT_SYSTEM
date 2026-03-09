<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
	function openAddModal() {
		document.getElementById('add-school-modal').classList.remove('hidden');
	}
 
	document.addEventListener('DOMContentLoaded', function() {
		document.getElementById('school_add_form').addEventListener('submit', function(e) {
			e.preventDefault();
			const form = e.target;
			const formData = new FormData(form);

			fetch(form.action, {
					method: 'POST',

					headers: {
						'X-CSRF-TOKEN': '{{ csrf_token() }}'
					},
					body: formData
				})
				.then(res => res.json())
				.then(data => {
					// Hide previous errors
					const errorDiv = document.getElementById('school-errors');
					const errorList = document.getElementById('school-errors-list');
					errorDiv.classList.add('hidden');
					errorList.innerHTML = '';

					if (data.success) {
						// Show styled success message
						const resultDiv = document.getElementById('school-result');
						const resultMsg = document.getElementById('school-result-message');
						resultMsg.innerText = data.message || "School added successfully!";
						resultDiv.classList.remove('hidden');
						form.reset();
					} else if (data.errors) {
						// Show validation errors
						errorDiv.classList.remove('hidden');
						for (const key in data.errors) {
							data.errors[key].forEach(msg => {
								const li = document.createElement('li');
								li.textContent = msg;
								errorList.appendChild(li);
							});
						}
					} else {
						alert('Error adding school: ' + (data.message || 'Unknown error'));
					}
				})
				.catch(error => {
					console.error('Error:', error);
					alert('An error occurred while adding the school.');
				});
		});
	});

	function deleteSchool(schoolId) {
		if (confirm('Are you sure you want to delete this school?')) {
			fetch(`/schools/${schoolId}`, {
					method: 'DELETE',
					headers: {
						'X-CSRF-TOKEN': '{{ csrf_token() }}'
					}
				})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						const resultDiv = document.getElementById('school-result');
						const resultMsg = document.getElementById('school-result-message');
						resultMsg.innerText = data.message || "School deleted successfully!";
						resultDiv.classList.remove('hidden');
						const keyword = document.getElementById('searchSchool')?.value ?? '';
						if (typeof loadSchools === 'function') {
							loadSchools(keyword, 1);
						}

					} else if (data.errors) {
						const errorDiv = document.getElementById('school-errors');
						const errorList = document.getElementById('school-errors-list');
						errorDiv.classList.remove('hidden');
						errorList.innerHTML = '';
						for (const key in data.errors) {
							data.errors[key].forEach(msg => {
								const li = document.createElement('li');
								li.textContent = msg;
								errorList.appendChild(li);
							});
						}

					} else {
						alert('Error deleting school: ' + (data.message || 'Unknown error'));
					}
				})
				.catch(error => {
					console.error('Error:', error);
					alert('An error occurred while deleting the school.');
				});
		}
	}
 
	document.addEventListener('DOMContentLoaded', function() {
		var map = L.map('map').setView([15.928, 120.348], 12); // Centered on Pangasinan
		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			maxZoom: 19,
			attribution: '© OpenStreetMap'
		}).addTo(map);
		var marker;

		function setLatLng(lat, lng) {
			document.getElementById('latitude').value = lat;
			document.getElementById('longitude').value = lng;
		}
		map.on('click', function(e) {
			if (marker) map.removeLayer(marker);
			marker = L.marker(e.latlng).addTo(map);
			setLatLng(e.latlng.lat, e.latlng.lng);
		});
		var schoolNameInput = document.getElementById('SchoolName');
		if (schoolNameInput) {
			var schoolNameTimeout;
			schoolNameInput.addEventListener('input', function(e) {
				clearTimeout(schoolNameTimeout);
				var value = this.value.trim();
				if (value.length > 2) {
					schoolNameTimeout = setTimeout(function() {
						var query = value + ', San Carlos Pangasinan';
						fetch('https://nominatim.openstreetmap.org/search?format=json&q=' +
								encodeURIComponent(query))
							.then(function(response) {
								return response.json();
							})
							.then(function(data) {
								if (data && data.length > 0) {
									var lat = parseFloat(data[0].lat);
									var lon = parseFloat(data[0].lon);
									map.setView([lat, lon], 16);
									if (marker) map.removeLayer(marker);
									marker = L.marker([lat, lon]).addTo(map);
									setLatLng(lat, lon);
								}
							})
							.catch(function(err) {
								// Optionally handle error
								// console.error('Map search error:', err);
							});
					}, 600); // debounce
				}
			});
		}
	});
	const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

	function showEditSchoolForm(pk_school_id, schoolID, schoolName, schoolLevel, email) {
		const form = document.getElementById('school-edit-form');

		document.getElementById('edit_pk_school_id').value = pk_school_id;
		document.getElementById('edit_SchoolID').value = schoolID;
		document.getElementById('edit_SchoolName').value = schoolName;
		document.getElementById('edit_SchoolLevel').value = schoolLevel;
		document.getElementById('edit_SchoolEmailAddress').value = email;

		form.action = `/update-school/${pk_school_id}`;
		document.getElementById('school-edit-modal').classList.remove('hidden');
	}

	function cancelSchoolEdit() {
		document.getElementById('school-edit-modal').classList.add('hidden');
		document.getElementById('school-edit-form').reset();
	}

	function formatLastLogin(lastLogin) {
		if (!lastLogin) return 'No login yet';
		return new Date(lastLogin).toLocaleString('en-US', {
			month: 'long',
			day: 'numeric',
			year: 'numeric',
			hour: 'numeric',
			minute: '2-digit',
			hour12: true,
		});
	}

	function escapeJsString(value) {
		if (value === null || value === undefined) return '';
		return String(value).replace(/'/g, "\\'");
	}

	function renderSchoolCard(school) {
		return `
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 flex flex-col items-center text-center transition hover:shadow-lg">
            <img class="w-24 h-24 object-cover rounded-full mb-3"
                src="${school.image_path ? '/school-logo/' + school.image_path : '/icon/logo.png'}"
                alt="School Logo">
            <h3 class="text-lg font-semibold text-gray-800">${school.SchoolName}</h3>
            <x-badge color="blue">${school.SchoolLevel}</x-badge>
            <x-badge color="green">${school.SchoolID}</x-badge>
            <x-badge color="yellow">${school.SchoolEmailAddress ?? 'Email not found'}</x-badge>
            <p class="text-sm text-gray-700 mt-2">Last Login: ${formatLastLogin(school.school_user?.last_login)}</p>
            <div class="mt-4 w-full">
                <form action="/send-mail/${school.pk_school_id}" method="POST" class="w-full">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <button type="submit" class="btn-green px-4 py-1 rounded w-full my-2">
                        Notify School ICT Coor.
                    </button>
                </form>
            </div>
            <div class="flex flex-row gap-2 w-full">
                <button type="button"
                    onclick="window.location.href='/schools/${school.pk_school_id}'"
                    class="btn-submit px-4 py-1 rounded flex-1 w-full">
                    Details
                </button>
                <button
                    onclick="showEditSchoolForm(
                        '${school.pk_school_id}',
                        '${escapeJsString(school.SchoolID)}',
                        '${escapeJsString(school.SchoolName)}',
                        '${escapeJsString(school.SchoolLevel)}',
                        '${escapeJsString(school.SchoolEmailAddress ?? '')}'
                    )"
                    class="btn-update px-4 py-1 rounded flex-1 w-full">
                    Edit
                </button>
                <button type="button" onclick="deleteSchool('${school.pk_school_id}')"
                    class="btn-delete px-4 py-1 rounded flex-1 w-full">
                    Delete
                </button>
            </div>
        </div>`;
	}

	function renderPagination(pagination, query) {
		const paginationContainer = document.getElementById('schoolPagination');
		if (!paginationContainer) return;

		const {
			current_page,
			last_page
		} = pagination;

		if (!last_page || last_page <= 1) {
			paginationContainer.innerHTML = '';
			return;
		}

		let html = '';
		const makeBtn = (label, page, disabled = false, active = false) => `
        <button
            type="button"
            ${disabled ? 'disabled' : ''}
            data-page="${page}"
            class="px-3 py-1 rounded border text-sm ${
                active
                    ? 'btn-submit'
                    : 'btn-cancel'
            } ${disabled ? 'opacity-50 cursor-not-allowed' : ''}">
            ${label}
        </button>`;

		html += makeBtn('Prev', current_page - 1, current_page <= 1);

		for (let page = 1; page <= last_page; page++) {
			if (
				page === 1 ||
				page === last_page ||
				(page >= current_page - 1 && page <= current_page + 1)
			) {
				html += makeBtn(String(page), page, false, page === current_page);
			} else if (
				page === current_page - 2 ||
				page === current_page + 2
			) {
				html += `<span class="px-1 text-gray-500">...</span>`;
			}
		}

		html += makeBtn('Next', current_page + 1, current_page >= last_page);

		paginationContainer.innerHTML = html;

		paginationContainer.querySelectorAll('button[data-page]').forEach((button) => {
			button.addEventListener('click', () => {
				const page = Number(button.dataset.page);
				if (Number.isFinite(page) && page > 0) {
					loadSchools(query, page);
				}
			});
		});
	}

	async function loadSchools(query = '', page = 1) {
		const target = document.getElementById('schoolCardGrid');
		const normalizedQuery = query.trim();

		try {
			const response = await fetch(
				`/Admin/schools/search?query=${encodeURIComponent(normalizedQuery)}&page=${page}&per_page=6`
			);
			const payload = await response.json();
			const rows = payload?.data ?? [];
			const pagination = payload?.pagination ?? {};

			if (!rows.length) {
				target.innerHTML = '<p class="col-span-full text-center text-gray-500">No results found.</p>';
				renderPagination({
					current_page: 1,
					last_page: 1
				}, normalizedQuery);
				return;
			}

			target.innerHTML = rows.map(renderSchoolCard).join('');
			renderPagination(pagination, normalizedQuery);
		} catch (error) {
			console.error('Search error:', error);
		}
	}

	let searchTimer = null;
	document.getElementById('searchSchool')?.addEventListener('input', function() {
		const keyword = this.value;
		clearTimeout(searchTimer);
		searchTimer = setTimeout(() => loadSchools(keyword, 1), 300);
	});

	document.addEventListener('DOMContentLoaded', () => {
		loadSchools('', 1);
	});
</script>
