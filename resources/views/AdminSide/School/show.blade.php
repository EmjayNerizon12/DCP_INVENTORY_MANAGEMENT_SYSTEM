@extends('layout.Admin-Side')

<title>@yield('title','DCP Dashboard')</title>

@section('content') 
<div class="shadow-sm border-b border-gray-200">
    <div class="max-w-10xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left Panel: School Details -->
            <div>
                <div class="bg-white shadow-lg h-full rounded-lg p-8 flex flex-col items-center">
                    <img 
                        src="{{ $school->image_path ? asset('school-logo/' . $school->image_path) : asset('icon/logo.png') }}" 
                        alt="School Logo" 
                        class="w-32 h-32 rounded-full object-cover border mb-4 shadow"
                    >
                    <h3 class="text-2xl font-bold mb-2 text-blue-700">{{ $school->SchoolName }}</h3>
                    <div class="w-full">
                        <div class="mb-2"><strong>School ID:</strong> {{ $school->SchoolID }}</div>
                        <div class="mb-2"><strong>Region:</strong> {{ $school->Region ?? 'N/A' }}</div>
                        <div class="mb-2"><strong>Province:</strong> {{ $school->Province ?? 'N/A' }}</div>
                        <div class="mb-2"><strong>Division:</strong> {{ $school->Division ?? 'N/A' }}</div>
                        <div class="mb-2"><strong>District:</strong> {{ $school->District ?? 'N/A' }}</div>
                        <div class="mb-2"><strong>School Level:</strong> {{ $school->SchoolLevel ?? 'N/A' }}</div>
                        <div class="mb-2"><strong>School's Contact Number:</strong> {{ $school->SchoolContactNumber ?? 'N/A' }}</div>
                        <div class="mb-2"><strong>School's Email Address:</strong> {{ $school->SchoolEmailAddress ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
            <!-- Middle Panel: School Officials -->
            <div>
                <div class="bg-white  shadow-md rounded-lg p-6 pt-2 h-full flex flex-col">
                    <h3 class="text-xl font-semibold text-blue-700 mb-2 text-center">School Officials</h3>
                    <div class="flex flex-col gap-3">
                        <!-- Principal -->
                        <div class="bg-blue-50 rounded-lg p-4 shadow flex-1">
                            <h4 class="font-semibold text-blue-700 mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                Principal
                            </h4>
                            <div class="mb-1"><strong>Name:</strong> {{ $school->PrincipalName ?? 'N/A' }}</div>
                            <div class="mb-1"><strong>Contact:</strong> {{ $school->PrincipalContact ?? 'N/A' }}</div>
                            <div class="mb-1"><strong>Email:</strong> {{ $school->PrincipalEmail ?? 'N/A' }}</div>
                        </div>
                        <!-- ICT Coordinator -->
                        <div class="bg-green-50 rounded-lg p-4 shadow flex-1">
                            <h4 class="font-semibold text-green-700 mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                ICT Coordinator
                            </h4>
                            <div class="mb-1"><strong>Name:</strong> {{ $school->ICTName ?? 'N/A' }}</div>
                            <div class="mb-1"><strong>Contact:</strong> {{ $school->ICTContact ?? 'N/A' }}</div>
                            <div class="mb-1"><strong>Email:</strong> {{ $school->ICTEmail ?? 'N/A' }}</div>
                        </div>
                        <!-- Property Custodian -->
                        <div class="bg-yellow-50 rounded-lg p-4 shadow flex-1">
                            <h4 class="font-semibold text-yellow-700 mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                Property Custodian
                            </h4>
                            <div class="mb-1"><strong>Name:</strong> {{ $school->CustodianName ?? 'N/A' }}</div>
                            <div class="mb-1"><strong>Contact:</strong> {{ $school->CustodianContact ?? 'N/A' }}</div>
                            <div class="mb-1"><strong>Email:</strong> {{ $school->CustodianEmail ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right Panel: School Location -->
            <div>
                <div class="bg-white shadow-md rounded-lg p-6 h-full flex flex-col">
                    <h3 class="text-xl font-semibold text-blue-700 mb-4 text-center">School Location</h3>
                    @php
                        $lat = $school->schoolCoordinates->Latitude ?? null;
                        $lon = $school->schoolCoordinates->Longitude ?? null;
                    @endphp
                    <div id="school-map" class="w-full h-48 rounded mb-4" style="min-height: 180px;"></div>
                    <div class="mb-2"><strong>Latitude:</strong> <span id="lat-text">{{ $lat ?? 'N/A' }}</span></div>
                    <div class="mb-2"><strong>Longitude:</strong> <span id="lon-text">{{ $lon ?? 'N/A' }}</span></div>
                    <div class="mb-2"><strong>Location:</strong> <span id="location-name">Loading...</span></div>
                </div>
            </div>
        </div>
    </div>  
</div>
 
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
 

<input type="hidden" name="latitude" id="latitude" value="{{ $lat }}">  
<input type="hidden" name="longitude" id="longitude" value="{{ $lon }}">
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // School map display
    const latitude = document.getElementById('latitude').value;
    const longitude = document.getElementById('longitude').value;
    var lat = parseFloat(latitude);
    var lon = parseFloat(longitude);
        if (!isNaN(lat) && !isNaN(lon) && lat !== 0 && lon !== 0) {
            var map = L.map('school-map').setView([lat, lon], 16);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '© OpenStreetMap'
            }).addTo(map);
            L.marker([lat, lon]).addTo(map);

            // Reverse geocode to get location details
            fetch('https://nominatim.openstreetmap.org/reverse?format=json&lat=' + lat + '&lon=' + lon)
                .then(response => response.json())
                .then(function(data) {
                    var address = data.address || {};
                    var street = address.road || address.pedestrian || address.cycleway || address.footway || '';
                    var barangay = address.suburb || address.village || address.neighbourhood || address.hamlet || address.barangay || '';
                    var city = address.city || address.town || address.municipality || address.village || address.county || '';
                    var province = address.state || address.region || address.province || '';
                    var parts = [street, barangay, city, province].filter(Boolean);
                    var location = parts.length ? parts.join(', ') : 'Location not found.';
                    document.getElementById('location-name').textContent = location;
                })
                .catch(function() {
                    document.getElementById('location-name').textContent = 'Unable to fetch location info.';
                });
        } else {
            document.getElementById('school-map').innerHTML = '<div class="text-center text-gray-400 pt-12">No coordinates available.</div>';
            document.getElementById('location-name').textContent = 'No coordinates available.';
        }
    });
</script> 
@endsection