<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>
	document.addEventListener('DOMContentLoaded', async function() {
		loadItemConditions();
		loadEquipmentCounts();
		itemTypeChartLoaded();
		packageChartLoaded();
		schoolChartLoaded();
		const tabs = {
			"btn-item": "tab-item",
			"btn-package": "tab-package",
			"btn-school": "tab-school"
		};

		const setActiveTab = (btnId, {
			focusButton = false
		} = {}) => {
			document.querySelectorAll(".tab-content").forEach(div => {
				div.classList.add("hidden");
				div.setAttribute("hidden", "");
			});

			document.querySelectorAll(".tab-btn").forEach(btn => {
				btn.classList.remove("theme-button");
				btn.classList.add("btn-cancel");
				btn.setAttribute("aria-selected", "false");
				btn.setAttribute("tabindex", "-1");
			});

			const panelId = tabs[btnId];
			const panel = panelId ? document.getElementById(panelId) : null;
			if (panel) {
				panel.classList.remove("hidden");
				panel.removeAttribute("hidden");
			}

			const button = document.getElementById(btnId);
			if (button) {
				button.classList.add("theme-button");
				button.classList.remove("btn-cancel");
				button.setAttribute("aria-selected", "true");
				button.setAttribute("tabindex", "0");
				if (focusButton) button.focus({
					preventScroll: true
				});
			}
		};

		Object.keys(tabs).forEach(btnId => {
			const button = document.getElementById(btnId);
			if (!button) return;

			button.addEventListener("click", (e) => {
				e.preventDefault();
				setActiveTab(btnId, {
					focusButton: true
				});
			});
		});

		const initiallySelected = document.querySelector('.tab-btn[aria-selected="true"]');
		setActiveTab(initiallySelected?.id || "btn-item");
	});
	const bgColors = [
		"#16A34A", // green
		"#DC2626", // red
		"#3B82F6", // blue fair
		"#FACC15", // yellow
		"#4F46E5", // indigo
		"#4B5563", // light gray - missing
	];

	function renderTableSpinnerRow(colspan) {
		return `
            <tr>
                <td colspan="${colspan}" class="td-cell">
                    <div class="spinner-container spinned-container py-6">
                        <div class="dashboard-loading-component"></div>
                    </div>
                </td>
            </tr>
        `;
	}

	async function loadItemConditions() {
		const cardContainer = document.getElementById("card-condition-container");
		const tableBody = document.getElementById("condition-table");
		if (!cardContainer || !tableBody) return;

		tableBody.innerHTML = renderTableSpinnerRow(3);
		cardContainer.innerHTML = "";

		try {
			const response = await fetch("api/item-conditions");
			if (!response.ok) throw new Error(`Failed to load item conditions (${response.status})`);
			const res = await response.json();
			const results = Array.isArray(res) ? res : [];

			tableBody.innerHTML = "";

			if (results.length === 0) {
				tableBody.innerHTML = `
                    <tr>
                        <td colspan="3" class="td-cell text-center font-semibold">No Data Found</td>
                    </tr>
                `;
				return;
			}

			const maxCount = Math.max(...results.map(d => Number(d?.count) || 0));

			results.forEach((data, index) => {
				const condition = data?.condition ?? "";
				const count = Number(data?.count) || 0;
				const color = bgColors[index] ?? "#01378E";
				const percent = maxCount > 0 ? (count / maxCount) * 100 : 0;

				const wrapper = document.createElement("div");
				wrapper.className = "bg-white p-1 rounded-md shadow-sm border border-gray-300";

				const newCard = document.createElement("div");
				newCard.id = `card-${index + 1}`;
				newCard.className =
					"max-w-full flex flex-col justify-center mx-auto w-full rounded-sm p-3 text-center";

				newCard.innerHTML = `
                    <div style="letter-spacing:0.05rem;" class="md:text-lg text-md uppercase font-semibold text-dark">
                        ${condition}
                    </div>
                    <div>
                        <div onclick="toggleCard(${data.id})" class="bg-white transform scale-100 hover:scale-110 transition duration-300 ease-in-out p-1 rounded-full shadow-md inline-flex border border-gray-300 items-center justify-center">
                            <div style="background-color:${color};" class="w-12 h-12 md:w-16 md:h-16 text-white font-semibold flex items-center justify-center rounded-full">
                                <span class="md:text-lg text-lg">${count}</span>
                            </div>
                        </div>
                    </div>
                `;

				wrapper.appendChild(newCard);
				cardContainer.appendChild(wrapper);

				const row = document.createElement("tr");
				row.innerHTML = `
                    <td class="td-cell">${condition}</td>
                    <td class="td-cell text-center">${count}</td>
                    <td class="td-cell">
                        <div class="progress-container">
                            <div class="progress-bar" style="width: ${percent}%; background-color: ${color};"></div>
                        </div>
                    </td>
                `;
				tableBody.appendChild(row);
			});
		} catch (error) {
			console.error("Error fetching item conditions:", error);
			tableBody.innerHTML = `
                <tr>
                    <td colspan="3" class="td-cell text-center font-semibold">Failed to load data</td>
                </tr>
            `;
		}
	}

	async function loadEquipmentCounts() {
		try {
			const response = await fetch('/Admin/api/count-equipment');
			if (!response.ok) throw new Error(`Failed to load equipment counts (${response.status})`);
			const res = await response.json();

			document.getElementById("cctv_count").textContent = `${res?.cctv_count ?? 0}`;
			document.getElementById("biometric_count").textContent = `${res?.biometric_count ?? 0}`;
			document.getElementById("isp_count").textContent = `${res?.isp_count ?? 0}`;
			document.getElementById("total_schools").textContent = `${res?.total_schools ?? 0}`;
		} catch (error) {
			console.error('Error fetching equipment counts:', error);
		}
	}

	function toggleCard(cardId) {
		window.location.href = `/Admin/ItemConditions/${cardId}`
	}

	async function itemTypeChartLoaded() {
		const tableBody = document.getElementById('item-type-table');
		if (!tableBody) return;

		tableBody.innerHTML = renderTableSpinnerRow(4);

		try {
			const response = await fetch('api/item-categories');
			if (!response.ok) throw new Error(`Failed to load item categories (${response.status})`);
			const res = await response.json();
			const data = Array.isArray(res) ? res : [];

			data.sort((a, b) => (Number(b?.total) || 0) - (Number(a?.total) || 0));
			const largest = data.reduce((max, item) => Math.max(max, Number(item?.total) || 0),0);

			let rows = '';
			if (data.length > 0) {
				data.forEach((item) => {
					const color = '#01378E';
					const itemTotal = Number(item?.total) || 0;
					const percent = largest > 0 ? (itemTotal / largest) * 100 : 0;

					rows += `
                            <tr>
                                <td class="td-cell">${item?.dcp_item_type?.code ?? ''}</td>
                                <td class="td-cell">${item?.dcp_item_type?.name ?? ''}</td>
                                <td class="td-cell text-center font-bold">${itemTotal}</td>
                                <td class="td-cell">
                                    <div class="progress-container">
                                        <div class="progress-bar" style="width: ${percent}%; background-color: ${color};"></div>
                                    </div>
                                </td>
                            </tr>
                        `;
				});
			} else {
				rows = `
                        <tr>
                            <td colspan="4" class="td-cell text-center font-semibold">No Data Found</td>
                        </tr>
                    `;
			}

			tableBody.innerHTML = rows;
		} catch (error) {
			console.error('Error fetching item categories:', error);
			tableBody.innerHTML = `
                    <tr>
                        <td colspan="4" class="td-cell text-center font-semibold">Failed to load data</td>
                    </tr>
                `;
		}
	}

	async function packageChartLoaded() {
		const tableBody = document.getElementById('package-type-table');
		if (!tableBody) return;

		tableBody.innerHTML = renderTableSpinnerRow(4);

		try {
			const response = await fetch('api/package-categories');
			if (!response.ok) throw new Error(`Failed to load package categories (${response.status})`);
			const res = await response.json();
			const data = Array.isArray(res) ? res : [];

			data.sort((a, b) => (Number(b?.total) || 0) - (Number(a?.total) || 0));
			const largest = data.reduce((max, item) => Math.max(max, Number(item?.total) || 0),0);

			let rows = '';
			if (data.length > 0) {
				data.forEach((item) => {
					const color = '#01378E';
					const itemTotal = Number(item?.total) || 0;
					const percent = largest > 0 ? (itemTotal / largest) * 100 : 0;

					rows += `
                            <tr>
                                <td class="td-cell">${item?.dcp_package_type?.code ?? ''}</td>
                                <td class="td-cell">${item?.dcp_package_type?.name ?? ''}</td>
                                <td class="td-cell text-center font-bold">${itemTotal}</td>
                                <td class="td-cell">
                                    <div class="progress-container">
                                        <div class="progress-bar" style="width: ${percent}%; background-color: ${color};"></div>
                                    </div>
                                </td>
                            </tr>
                        `;
				});
			} else {
				rows = `
                        <tr>
                            <td colspan="4" class="td-cell text-center font-semibold">No Data Found</td>
                        </tr>
                    `;
			}

			tableBody.innerHTML = rows;
		} catch (error) {
			console.error('Error fetching package categories:', error);
			tableBody.innerHTML = `
                    <tr>
                        <td colspan="4" class="td-cell text-center font-semibold">Failed to load data</td>
                    </tr>
                `;
		}
	}

	async function schoolChartLoaded() {
		const tableBody = document.getElementById('batch-distributed-table');
		if (!tableBody) return;

		tableBody.innerHTML = renderTableSpinnerRow(5);

		try {
			const response = await fetch('api/school-categories');
			if (!response.ok) throw new Error(`Failed to load school categories (${response.status})`);
			const res = await response.json();
			const data = Array.isArray(res) ? res : [];

			data.sort((a, b) => (Number(b?.total) || 0) - (Number(a?.total) || 0));
			const largest = data.reduce((max, item) => Math.max(max, Number(item?.total) || 0),0);

			let rows = '';
			if (data.length > 0) {
				data.forEach((item, index) => {
					const color = '#01378E';
					const itemTotal = Number(item?.total) || 0;
					const percent = largest > 0 ? (itemTotal / largest) * 100 : 0;

					rows += `
                            <tr>
                                <td class="td-cell text-center">${index + 1}</td>
                                <td class="td-cell">${item?.school?.SchoolName ?? ''}</td>
                                <td class="td-cell">${item?.school?.SchoolLevel ?? ''}</td>
                                <td class="td-cell text-center font-bold">${itemTotal}</td>
                                <td class="td-cell">
                                    <div class="progress-container">
                                        <div class="progress-bar" style="width: ${percent}%; background-color: ${color};"></div>
                                    </div>
                                </td>
                            </tr>
                        `;
				});
			} else {
				rows = `
                        <tr>
                            <td colspan="5" class="td-cell text-center font-semibold">No Data Found</td>
                        </tr>
                    `;
			}

			tableBody.innerHTML = rows;
		} catch (error) {
			console.error('Error fetching school categories:', error);
			tableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="td-cell text-center font-semibold">Failed to load data</td>
                    </tr>
                `;
		}
	}
</script>
