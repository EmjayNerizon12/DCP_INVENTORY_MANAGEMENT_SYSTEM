@extends('layout.Admin-Side')

<title>@yield('title', 'DCP Dashboard')</title>

@section('content')
<div class="p-2">
    <div class="rounded-lg overflow-hidden mb-2 py-2">
        <div class="grid md:grid-cols-4 grid-cols-2 gap-4">
            <a href="{{ route('index.schools') }}"
                class="group relative bg-white shadow-md rounded-md border border-gray-300 p-5 flex flex-col justify-between transition-all duration-200 focus:outline-none">
                <span id="schools-card-arrow"
                    class="absolute top-3 right-3 inline-flex h-9 w-9 items-center justify-center rounded-full bg-gray-200 animate-pulse">
                </span>
                <div id="schools-card-content" class="flex flex-col space-y-0 w-full gap-4 items-center justify-center">
                    <div class="dashboard-icon-container">
                        <div class="h-16 w-16 rounded-full bg-gray-200 animate-pulse"></div>
                    </div>
                    <div class="w-full">
                        <div class="h-4 w-32 mx-auto rounded bg-gray-200 animate-pulse"></div>
                        <div class="h-8 w-16 mx-auto mt-3 rounded-md bg-gray-200 animate-pulse"></div>
                    </div>
                </div>
            </a>

            <!-- Total Batches -->
            <a href="{{ route('index.batch') }}"
                class="group relative bg-white shadow-md rounded-md border border-gray-300 p-5 flex flex-col justify-between transition-all duration-200 focus:outline-none">
                <span id="batches-card-arrow"
                    class="absolute top-3 right-3 inline-flex h-9 w-9 items-center justify-center rounded-full bg-gray-200 animate-pulse">
                </span>
                <div id="batches-card-content" class="flex flex-col w-full gap-4 items-center justify-center">
                    <div class="dashboard-icon-container">
                        <div class="h-16 w-16 rounded-full bg-gray-200 animate-pulse"></div>
                    </div>
                    <div class="w-full">
                        <div class="h-4 w-28 mx-auto rounded bg-gray-200 animate-pulse"></div>
                        <div class="h-8 w-16 mx-auto mt-3 rounded-md bg-gray-200 animate-pulse"></div>
                    </div>

                </div>
            </a>

            <!-- Total Items -->
            <a href="{{ route('index.dcp.items') }}"
                class="group relative bg-white shadow-md rounded-md border border-gray-300 p-5 flex flex-col justify-between transition-all duration-200 focus:outline-none">
                <span id="items-card-arrow"
                    class="absolute top-3 right-3 inline-flex h-9 w-9 items-center justify-center rounded-full bg-gray-200 animate-pulse">
                </span>
                <div id="items-card-content" class="flex flex-col w-full gap-4 items-center justify-center">
                    <div class="dashboard-icon-container">
                        <div class="h-16 w-16 rounded-full bg-gray-200 animate-pulse"></div>
                    </div>
                    <div class="w-full">
                        <div class="h-4 w-28 mx-auto rounded bg-gray-200 animate-pulse"></div>
                        <div class="h-8 w-16 mx-auto mt-3 rounded-md bg-gray-200 animate-pulse"></div>
                    </div>

                </div>
            </a>
            <a href="{{ route('index.dcp.package') }}"
                class="group relative bg-white shadow-md rounded-md border border-gray-300 p-5 flex flex-col justify-between transition-all duration-200 focus:outline-none">
                <span id="packages-card-arrow"
                    class="absolute top-3 right-3 inline-flex h-9 w-9 items-center justify-center rounded-full bg-gray-200 animate-pulse">
                </span>
                <div id="packages-card-content" class="flex flex-col w-full gap-4 items-center justify-center">
                    <div class="dashboard-icon-container">
                        <div class="h-16 w-16 rounded-full bg-gray-200 animate-pulse"></div>
                    </div>
                    <div class="w-full">
                        <div class="h-4 w-28 mx-auto rounded bg-gray-200 animate-pulse"></div>
                        <div class="h-8 w-16 mx-auto mt-3 rounded-md bg-gray-200 animate-pulse"></div>
                    </div>

                </div>
            </a>
        </div>

    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 md:gap-4 gap-2">
        <div class="bg-white shadow-md rounded-md border border-gray-300 p-5 flex flex-col justify-center gap-3">
            <div id="isp-card-content" class="flex flex-col justify-center gap-3">
                <div class="dashboard-icon-container">
                    <div class="h-16 w-16 rounded-full bg-gray-200 animate-pulse"></div>
                </div>
                <div>
                    <div class="h-4 w-32 rounded bg-gray-200 animate-pulse"></div>
                    <div class="h-8 w-16 rounded-md bg-gray-200 animate-pulse mt-3"></div>
                </div>
            </div>
        </div>

        <!-- Biometric Card -->
        <div class="bg-white shadow-md rounded-md border border-gray-300 p-5 flex flex-col gap-3">
            <div id="biometric-card-content" class="flex flex-col gap-3">
                <div class="dashboard-icon-container">
                    <div class="h-16 w-16 rounded-full bg-gray-200 animate-pulse"></div>
                </div>
                <div>
                    <div class="h-4 w-36 rounded bg-gray-200 animate-pulse"></div>
                    <div class="h-8 w-16 rounded-md bg-gray-200 animate-pulse mt-3"></div>
                </div>
            </div>
        </div>

        <!-- CCTV Card -->
        <div class="bg-white shadow-md rounded-md border border-gray-300 p-5 flex flex-col gap-3">
            <div id="cctv-card-content" class="flex flex-col gap-3">
                <div class="dashboard-icon-container">
                    <div class="h-16 w-16 rounded-full bg-gray-200 animate-pulse"></div>
                </div>
                <div>
                    <div class="h-4 w-28 rounded bg-gray-200 animate-pulse"></div>
                    <div class="h-8 w-16 rounded-md bg-gray-200 animate-pulse mt-3"></div>
                </div>
            </div>
        </div>

    </div>

    <div class="md:text-xl text-lg font-semibold text-gray-800 my-2 mt-5">Product Value Summary</div>
    <div class="grid grid-cols-1 overflow-x-auto">
        <div id="card-condition-container" class="grid md:grid-cols-4 grid-cols-2 md:gap-4 gap-2 mb-2">
        </div>
        <table class="table w-full bg-white  border-collapse border border-gray-300 mt-3"
            style="letter-spacing: 0.05rem">
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
                width: 100% !important;
                height: 20px !important;
                border: 2px solid #fff !important;

                background: #e5e7eb !important;
                border-radius: 6px !important;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5) !important;
                overflow: hidden;
            }

            .progress-bar {
                height: 100%;
                border-radius: 6px;
                transition: width 0.3s ease;
            }
        </style>
    </div>

    <div class="my-2">
        <div class="flex overflow-x-auto gap-3 py-4">
            <button id="btn-item" type="button" class="tab-btn theme-button px-4 py-1 rounded" aria-controls="tab-item"
                aria-selected="true">
                DCP Product
            </button>

            <button id="btn-package" type="button" class="tab-btn btn-cancel px-4 py-1 rounded"
                aria-controls="tab-package" aria-selected="false">
                DCP Package
            </button>

            <button id="btn-school" type="button" class="tab-btn btn-cancel px-4 py-1 rounded"
                aria-controls="tab-school" aria-selected="false">
                DCP Batch
            </button>
        </div>
        <div id="tab-item" class="tab-content" role="tabpanel" aria-labelledby="btn-item">
            <div class="overflow-x-auto thin-scroll">
                <table class="border-collapse bg-collapse w-full table-auto">
                    <thead class="bg-white sticky top-0">
                        <tr class="top-header">
                            <td colspan="4" class="td-cell text-white">DCP Product Type</td>
                        </tr>
                        <tr class="sub-header">
                            <td class="td-cell">Product Code</td>
                            <td class="td-cell">Product Name</td>
                            <td class="td-cell">Count</td>
                            <td class="td-cell">Visual</th>
                        </tr>
                    </thead>
                    <tbody id="item-type-table"></tbody>
                </table>
            </div>
        </div>

        <div id="tab-package" class="tab-content hidden" hidden role="tabpanel" aria-labelledby="btn-package">
            <div class="overflow-y-auto w-full thin-scroll">
                <table class="border-collapse w-full table-auto">
                    <thead class="bg-white sticky top-0">
                        <tr class="top-header">
                            <th colspan="4" class="td-cell text-white">DCP Package Type</th>
                        </tr>
                        <tr class="sub-header">
                            <th class="td-cell">Package Code</th>
                            <th class="td-cell">Package Name</th>
                            <th class="td-cell">Package Distributed</th>
                            <th class="td-cell">Visual</th>
                        </tr>
                    </thead>
                    <tbody id="package-type-table"></tbody>
                </table>
            </div>

        </div>

        <div id="tab-school" class="tab-content hidden" hidden role="tabpanel" aria-labelledby="btn-school">
            <div class="overflow-y-auto w-full thin-scroll">
                <table class="border-collapse w-full table-auto">
                    <thead class="bg-white sticky top-0">
                        <tr class="top-header">
                            <th colspan="5" class="td-cell text-white">DCP Batch Received by School</th>
                        </tr>
                        <tr class="sub-header">
                            <th class="td-cell text-center">No.</th>
                            <th class="td-cell">School Name</th>
                            <th class="td-cell">School Level</th>
                            <th class="td-cell">Total Batch Received</th>
                            <th class="td-cell">Visual</th>
                        </tr>
                    </thead>
                    <tbody id="batch-distributed-table"></tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@include('AdminSide.Dashboard.partials._script')
@endsection
