<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>
			let dashboardSummaryPromise = null;

			document.addEventListener('DOMContentLoaded', async function() {
				loadPrimaryDashboardCards();
				loadAssetDepreciationSummary();
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

			function getDashboardSummary() {
				if (!dashboardSummaryPromise) {
					dashboardSummaryPromise = fetch("/Admin/Dashboard/api/asset-deprecation-value")
						.then((response) => {
							if (!response.ok) {
								throw new Error(`Failed to load dashboard summary (${response.status})`);
							}
							return response.json();
						});
				}

				return dashboardSummaryPromise;
			}

			function renderPrimaryCardContent(type, value) {
				const cardMap = {
					schools: {
						label: "Total Number of Schools",
						colorClass: "bg-blue-600",
						icon: `
							<svg class="w-10 h-10" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
								<path d="M21 10L12 5L3 10L12 15L21 10Z" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M6 11.5V17.5L12 21L18 17.5V11.5" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M21 10V17" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						`
					},
					batches: {
						label: "Total DCP Batch",
						colorClass: "bg-green-600",
						icon: `
							<svg class="w-10 h-10" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
								<path d="M12 12V21" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M20 8L12 12L4 8" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M11 2.6L19 7C20 7.6 20 8 20 9V16C20 17 20 17.6 19 18L12 22L5 18C4 17.6 4 17 4 16V9C4 8 4 7.6 5 7L11 2.6Z" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						`
					},
					items: {
						label: "Total DCP Items",
						colorClass: "bg-yellow-500",
						icon: `
							<svg class="w-10 h-10" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
								<path d="M3 7H21V10H3V7Z" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M5 10H19V18C19 19 18 20 17 20H7C6 20 5 19 5 18V10Z" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M9 14H15" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						`
					},
					packages: {
						label: "Total DCP Package",
						colorClass: "bg-red-600",
						icon: `
							<svg class="md:w-10 md:h-10 w-8 h-8" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
								<path d="M12 3L3 8V16L12 21L21 16V8L12 3Z" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M3.5 7.8L12 12.5L20.5 7.8" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M12 12.5V21" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						`
					}
				};

				const config = cardMap[type];
				if (!config) return "";

				return `
					<div class="dashboard-icon-container">
						<div class="${config.colorClass} dashboard-icon">
							${config.icon}
						</div>
					</div>
					<div class="w-full">
						<p class="dashboard-card-label">${config.label}</p>
						<h3 class="dashboard-card-value">${Number(value ?? 0).toLocaleString()}</h3>
					</div>
				`;
			}

			function renderPrimaryCardArrow(type) {
				const arrowMap = {
					schools: "bg-blue-50 text-blue-600",
					batches: "bg-green-50 text-green-600",
					items: "bg-yellow-50 text-yellow-600",
					packages: "bg-red-50 text-red-600"
				};

				const colorClass = arrowMap[type];
				if (!colorClass) return "";

				return `
					<span class="absolute top-3 right-3 inline-flex h-9 w-9 items-center justify-center rounded-full ${colorClass} transition-transform duration-200 group-hover:translate-x-1">
						<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
							<path d="M5 12H19" stroke-linecap="round" stroke-linejoin="round" />
							<path d="M12 5L19 12L12 19" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</span>
				`;
			}

			async function loadPrimaryDashboardCards() {
				const cardTargets = [{
						id: "schools-card-content",
						type: "schools",
						key: "total_schools",
						arrowId: "schools-card-arrow"
					},
					{
						id: "batches-card-content",
						type: "batches",
						key: "total_batches",
						arrowId: "batches-card-arrow"
					},
					{
						id: "items-card-content",
						type: "items",
						key: "total_items",
						arrowId: "items-card-arrow"
					},
					{
						id: "packages-card-content",
						type: "packages",
						key: "total_packages",
						arrowId: "packages-card-arrow"
					}
				];

				try {
					const res = await getDashboardSummary();

					cardTargets.forEach((card) => {
						const target = document.getElementById(card.id);
						const arrowTarget = document.getElementById(card.arrowId);
						if (!target) return;
						target.innerHTML = renderPrimaryCardContent(card.type, res?.[card.key] ?? 0);
						if (arrowTarget) arrowTarget.outerHTML = renderPrimaryCardArrow(card.type);
					});
				} catch (error) {
					console.error("Error fetching primary dashboard cards:", error);
					cardTargets.forEach((card) => {
						const target = document.getElementById(card.id);
						const arrowTarget = document.getElementById(card.arrowId);
						if (!target) return;
						target.innerHTML = renderPrimaryCardContent(card.type, 0);
						if (arrowTarget) arrowTarget.outerHTML = renderPrimaryCardArrow(card.type);
					});
				}
			}

			function renderTableSpinnerRow(colspan) {
				const widthClasses = ["w-10", "w-20", "w-24", "w-32", "w-40"];
				const alignmentClass = (cellIndex) => {
					if (cellIndex === 0 && colspan >= 5) return "justify-center";
					if (cellIndex === colspan - 2) return "justify-center";
					return "justify-start";
				};

				const buildCell = (rowIndex, cellIndex) => {
					if (cellIndex === colspan - 1) {
						return `
							<td class="td-cell">
								<div class="w-full h-4 rounded-full bg-gray-200/80 overflow-hidden">
									<div class="h-full rounded-full bg-gray-300 animate-pulse" style="width:${55 + ((rowIndex + cellIndex) % 4) * 10}%;"></div>
								</div>
							</td>
						`;
					}

					const widthClass = widthClasses[(rowIndex + cellIndex) % widthClasses.length];

					return `
						<td class="td-cell">
							<div class="flex ${alignmentClass(cellIndex)}">
								<div class="h-4 ${widthClass} rounded-md bg-gray-200 animate-pulse"></div>
							</div>
						</td>
					`;
				};

				const rows = Array.from({
					length: 6
				}, (_, rowIndex) => `
					<tr class="border-b border-gray-200/80">
						${Array.from({
							length: colspan
						}, (_, cellIndex) => buildCell(rowIndex, cellIndex)).join("")}
					</tr>
				`).join("");

				return rows;
			}

			function renderSummaryCardSpinner() {
				return `
					<div class="bg-white p-4 rounded-md shadow-sm border border-gray-300">
						<div class="flex items-start justify-between gap-3">
							<div class="w-full">
								<div class="h-3 w-24 rounded bg-gray-200 animate-pulse"></div>
								<div class="mt-4 h-8 w-28 rounded-md bg-gray-200 animate-pulse"></div>
							</div>
							<div class="h-3 w-3 rounded-full bg-gray-200 animate-pulse mt-1 shrink-0"></div>
						</div>
					</div>
				`;
			}

			async function loadAssetDepreciationSummary() {
				const cardContainer = document.getElementById("card-condition-container");
				if (!cardContainer) return;

			cardContainer.innerHTML = Array.from({
				length: 4
			}, () => renderSummaryCardSpinner()).join("");

				try {
					const res = await getDashboardSummary();

				const summaryCards = [{
						label: "Disposed",
						value: Number(res?.disposed ?? 0).toLocaleString(),
						color: "#DC2626"
					},
					{
						label: "Functional",
						value: Number(res?.functional ?? 0).toLocaleString(),
						color: "#16A34A"
					},
					{
						label: "Asset Value",
						value: `PHP ${Number(res?.asset_value ?? 0).toLocaleString(undefined, {
							minimumFractionDigits: 2,
							maximumFractionDigits: 2
						})}`,
						color: "#01378E"
					},
					{
						label: "Depreciation Value",
						value: `PHP ${Number(res?.deprecation_value ?? 0).toLocaleString(undefined, {
							minimumFractionDigits: 2,
							maximumFractionDigits: 2
						})}`,
						color: "#F59E0B"
					}
				];

				cardContainer.innerHTML = summaryCards.map((card) => `
					<div class="bg-white rounded-md shadow-sm border border-gray-300 p-4">
						<div class="flex items-start justify-between gap-3">
							<div>
								<p class="text-sm font-medium uppercase tracking-wide text-gray-500">${card.label}</p>
								<h3 class="mt-3 text-2xl md:text-3xl font-bold text-gray-800 break-words">${card.value}</h3>
							</div>
							<span class="inline-flex h-3 w-3 rounded-full mt-1 shrink-0" style="background-color:${card.color};"></span>
						</div>
					</div>
				`).join("");
			} catch (error) {
				console.error("Error fetching asset summary:", error);
				cardContainer.innerHTML = `
					<div class="bg-white rounded-md shadow-sm border border-gray-300 p-4 col-span-full text-center font-semibold text-gray-600">
						Failed to load summary data
					</div>
				`;
			}
		}

			async function loadItemConditions() {
			const tableBody = document.getElementById("condition-table");
			if (!tableBody) return;

			tableBody.innerHTML = renderTableSpinnerRow(3);

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

			function renderEquipmentCardContent(type, value) {
				const cardMap = {
					isp: {
						label: "Schools with Internet",
						backgroundColor: "#F7931E",
						icon: `
							<svg class="w-10 h-10" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
								<path d="M5 12.55a11 11 0 0 1 14.08 0" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M1.42 9a16 16 0 0 1 21.16 0" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M8.53 16.11a6 6 0 0 1 6.95 0" stroke-linecap="round" stroke-linejoin="round" />
								<circle cx="12" cy="20" r="1" fill="white" stroke="none" />
							</svg>
						`
					},
					biometric: {
						label: "Schools with Biometrics",
						backgroundColor: "#8DC63F",
						icon: `
							<svg class="w-10 h-10" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
								<path d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M3 10a9 9 0 0118 0" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						`
					},
					cctv: {
						label: "Schools with CCTV",
						backgroundColor: "#4CAF50",
						icon: `
							<svg class="w-10 h-10" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
								<path d="M15 10l4.553-2.069A1 1 0 0121 8.87v6.26a1 1 0 01-1.447.894L15 14" stroke-linecap="round" stroke-linejoin="round" />
								<rect x="3" y="8" width="12" height="8" rx="2" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						`
					},
					schoolEquipment: {
						label: "Specific Equipment",
						backgroundColor: "#6366F1",
						icon: `
							<svg class="w-10 h-10" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
								<path d="M4 7.5L12 3L20 7.5L12 12L4 7.5Z" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M4 16.5L12 21L20 16.5" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M4 12L12 16.5L20 12" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M12 12V21" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						`
					}
				};

				const config = cardMap[type];
				if (!config) return "";

				return `
					<div class="dashboard-icon-container">
						<div class="dashboard-icon" style="background-color:${config.backgroundColor};">
							${config.icon}
						</div>
					</div>
					<div>
						<p class="dashboard-card-label">${config.label}</p>
						<h3 class="dashboard-card-value">${Number(value ?? 0).toLocaleString()}</h3>
					</div>
				`;
			}

			async function loadEquipmentCounts() {
				const cardTargets = [{
						id: "isp-card-content",
						type: "isp"
					},
					{
						id: "biometric-card-content",
						type: "biometric"
					},
					{
						id: "cctv-card-content",
						type: "cctv"
					},
					{
						id: "school-equipment-card-content",
						type: "schoolEquipment"
					}
				];

				try {
					const response = await fetch('/Admin/api/count-equipment');
					if (!response.ok) throw new Error(`Failed to load equipment counts (${response.status})`);
					const res = await response.json();

					document.getElementById("isp-card-content").innerHTML = renderEquipmentCardContent("isp", res?.isp_count ?? 0);
					document.getElementById("biometric-card-content").innerHTML = renderEquipmentCardContent("biometric", res?.biometric_count ?? 0);
					document.getElementById("cctv-card-content").innerHTML = renderEquipmentCardContent("cctv", res?.cctv_count ?? 0);
					document.getElementById("school-equipment-card-content").innerHTML = renderEquipmentCardContent("schoolEquipment", res?.school_equipment_count ?? 0);
				} catch (error) {
					console.error('Error fetching equipment counts:', error);
					cardTargets.forEach((card) => {
						const target = document.getElementById(card.id);
						if (!target) return;
						target.innerHTML = renderEquipmentCardContent(card.type, 0);
					});
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
