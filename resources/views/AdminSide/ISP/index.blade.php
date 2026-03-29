@extends('layout.Admin-Side')
<title>@yield('title', 'DCP Dashboard')</title>

@section('content')
    <style>
        th {
            text-transform: uppercase;
            letter-spacing: 0.05rem
        }

        td {
            letter-spacing: 0.05rem
        }

        button {
            letter-spacing: 0.05rem;
            font-weight: 500 !important;
            border-radius: 5px !important;
        }
    </style>
    <div class="md:my-5 mx-0 my-0">

        <div class="flex justify-start gap-2 my-2 items-center">
            <div class="h-16 w-16 bg-white p-3 border border-gray-300 shadow-lg rounded-full flex items-center justify-center">
                <div class="text-white bg-blue-600 p-2 rounded-full">
                    <svg viewBox="0 -2 20 20" class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                        <path d="M11.9795939,3535.00003 C11.9795939,3536.00002 12.8837256,3537 14,3537 C15.1162744,3537 16.0204061,3536.00002 16.0204061,3535.00003 C16.0204061,3532.00008 11.9795939,3532.00008 11.9795939,3535.00003 M9.71370846,3530.7571 L11.1431458,3532.17208 C12.7180523,3530.6121 15.2819477,3530.6121 16.8568542,3532.17208 L18.2862915,3530.7571 C15.9183756,3528.41413 12.0816244,3528.41413 9.71370846,3530.7571 M4,3525.10019 L5.42842711,3526.51516 C10.1551672,3521.83624 17.8448328,3521.83624 22.5715729,3526.51516 L24,3525.10019 C18.4772199,3519.63327 9.52278008,3519.63327 4,3525.10019 M21.1431458,3527.92914 L19.7147187,3529.34312 C16.5638953,3526.22417 11.4361047,3526.22417 8.28528134,3529.34312 L6.85685423,3527.92914 C10.8016971,3524.0242 17.1983029,3524.0242 21.1431458,3527.92914"/>
                    </svg>
                </div>
            </div>
            <div style="letter-spacing: 0.05rem">
                <h2 class="text-2xl font-bold text-gray-800 uppercase">Internet Service Providers Details</h2>
                <div class="text-lg text-gray-600">Create, View, Edit and Remove Details</div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 grid-cols-1 md:gap-4 gap-2 mb-10">
            @php
                $lookupCards = [
                    ['type' => 'provider', 'title' => 'Internet Service Providers List'],
                    ['type' => 'connection_type', 'title' => 'Connection Type for the ISP'],
                    ['type' => 'area', 'title' => 'Area Distribution for the ISP'],
                    ['type' => 'internet_quality', 'title' => 'Internet Quality for the ISP'],
                ];
            @endphp

            @foreach ($lookupCards as $card)
                @include('AdminSide.ISP.Crud._lookupCrud', [
                    'type' => $card['type'],
                    'title' => $card['title'],
                    'items' => $itemsByType[$card['type']] ?? collect(),
                ])
            @endforeach
        </div>
    </div>
@endsection
