@extends('layout.SchoolSideLayout')

@section('content')
    <div class="md:p-6 p-2 ">
        <div class="flex justify-start space-x-4">

            <div>

                <div class="page-title">Non DCP Items</div>
                <div class="page-subtitle">eg. Computer, Laptop, Smart TV - Unit
                    Price, Date
                    Acquired
                </div>

            </div>

        </div>
        <div class="flex justify-start my-2">

            <button title="Show Info Modal" type="button" onclick="openModal()" class="btn-submit py-1 px-4 rounded">
                Add New Item
            </button>

        </div>
        <div class="overflow-x-auto thin-scroll">
            <table class="table-auto  border border-gray-800 w-full table-collapse">
                <thead>
                    <tr>
                        <td class="top-header" colspan="9">NON DCP ITEMS</td>
                    </tr>
                    <tr>
                        <th class="sub-header text-center">
                            No. </th>

                        <th class="sub-header text-center">
                            Item - Description </th>
                        <th class="sub-header text-center">
                            Unit - Price </th>
                        <th class="sub-header text-center">
                            Date Acquired </th>
                        <th class="sub-header text-center">
                            Functional </th>
                        <th class="sub-header text-center">
                            Fund Source </th>
                        <th class="sub-header text-center">
                            Item Holder - Location </th>
                        <th class="sub-header text-center">
                            Remarks</th>
                        <th class="sub-header text-center">
                            Action</th>

                    </tr>
                </thead>
                <tbody class="tracking-wider">

                    @forelse ($non_dcp as $index => $item)
                        <tr>
                            <td class="td-cell text-center">
                                {{ $index + 1 }}</td>
                            <td class="td-cell text-center">{{ $item->item_description }}
                            </td>
                            <td class="td-cell text-center">{{ $item->unit_price }}</td>

                            <td class="td-cell text-center">
                                {{ \Carbon\Carbon::parse($item->date_acquired)->format('F j, Y') }}
                            </td>



                            <td class="td-cell text-center">{{ $item->total_functional }}
                                /
                                {{ $item->total_item }}</td>
                            <td class="td-cell text-center">
                                {{ $item->fund_source->name ?? 'N/A' }}
                            </td>
                            <td class="td-cell text-center">
                                {{ $item->item_holder_and_location ?? 'N/A' }}</td>
                            <td class="td-cell text-center">{{ $item->remarks }}</td>
                            <td class="td-cell text-center">
                                <div class="flex flex-row gap-2 justify-center">


                                    <div
                                        class="action-button">

                                        <button title="Edit ISP" class="btn-update p-1 rounded-full"
                                            onclick='editModal(
                                        {{ $item->pk_non_dcp_item_id }},
                                        @json($item->item_description),
                                        {{ $item->unit_price }},
                                        "{{ $item->date_acquired }}",
                                        {{ $item->total_functional }},
                                        {{ $item->total_item }},
                                        {{ $item->fund_source_id }},
                                        @json($item->item_holder_and_location),
                                        @json($item->remarks)
                                      )'>
                                             @include('SchoolSide.components.svg.edit-sm')
                                        </button>
                                    </div>
                                    <div
                                        class="action-button">

                                        <button type="button" title="Remove ISP"
                                            onclick="deleteItem({{ $item->pk_non_dcp_item_id }})"
                                            class="btn-delete p-1 rounded-full">
                                             @include('SchoolSide.components.svg.delete-sm')

                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-gray-500">No Non DCP items found for your
                                school.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @include('SchoolSide.NonDCP.partials._modalAdd')
    @include('SchoolSide.NonDCP.partials._modalEdit')
    @include('SchoolSide.NonDCP.partials._script')
@endsection
