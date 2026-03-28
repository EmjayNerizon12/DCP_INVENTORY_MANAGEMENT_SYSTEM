<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<title>@yield('title')</title>
		<meta name="school-logo" content="{{ asset('icon/logo.png') }}">
		<link rel="icon" type="image/png" href="{{ asset('icon/logo.png') }}">

		@vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/admin.js']);

	</head>

		<body class="antialiased bg-gray-50 flex min-h-screen">
			@include('layout.partials.Admin._style')
			@include('layout.partials.Admin.helpers-script')
			@include('layout.partials.Admin.header')
			@include('layout.partials.Admin.sidebar')
			@include('layout.partials.Admin._script')
			@include('AdminSide.partials.print-style')

		<div class="main-content" id="content">

				<div id="status-notification-container" class="fixed top-0 right-0 z-99 p-4 space-y-3 w-fit">
				@if (session('success'))
					<div class="flex items-icenter justify-between relative p-2 bg-white border border-gray-200 rounded-md shadow-lg">
						<div class="flex items-center gap-3 mr-5">
							<div class="flex items-center justify-center w-6 h-6 rounded-full text-green-600 text-base">
								<svg viewBox="0 0 24 24" class="w-6 h-6" fill="none" xmlns="http://www.w3.org/2000/svg">
									<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
									<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
									<g id="SVGRepo_iconCarrier">
										<path d="M7 13L10 16L17 9" stroke="currentColor" stroke-width="2" stroke-linecap="round"
											stroke-linejoin="round"></path>
										<circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" stroke-linecap="round"
											stroke-linejoin="round"></circle>
									</g>
								</svg>
							</div>
							<p class="text-base font-medium text-gray-800">{{ session('success') }}</p>
						</div>
						<button onclick="this.parentElement.remove()" class="text-gray-800 hover:text-gray-600 w-6 h-6 shadow-none">
							<svg fill="currentColor" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
								<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
								<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
								<g id="SVGRepo_iconCarrier">
									<path
										d="M18.8,16l5.5-5.5c0.8-0.8,0.8-2,0-2.8l0,0C24,7.3,23.5,7,23,7c-0.5,0-1,0.2-1.4,0.6L16,13.2l-5.5-5.5 c-0.8-0.8-2.1-0.8-2.8,0C7.3,8,7,8.5,7,9.1s0.2,1,0.6,1.4l5.5,5.5l-5.5,5.5C7.3,21.9,7,22.4,7,23c0,0.5,0.2,1,0.6,1.4 C8,24.8,8.5,25,9,25c0.5,0,1-0.2,1.4-0.6l5.5-5.5l5.5,5.5c0.8,0.8,2.1,0.8,2.8,0c0.8-0.8,0.8-2.1,0-2.8L18.8,16z">
									</path>
								</g>
							</svg>
						</button>
					</div>
					@elseif (session('error'))
						<div class="flex items-icenter justify-between relative p-2 bg-white border border-gray-200 rounded-md shadow-lg">
							<div class="flex items-center gap-3 mr-5">
								<div class="flex items-center justify-center w-6 h-6 rounded-full text-red-600 text-base">
									<svg viewBox="0 0 24 24" class="w-6 h-6" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M12 8V13" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
										<path d="M12 16H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
										<circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" />
									</svg>
								</div>
								<p class="text-base font-medium text-gray-800">{{ session('error') }}</p>
							</div>
							<button onclick="this.parentElement.remove()" class="text-gray-800 hover:text-gray-600 w-6 h-6 shadow-none">
								<svg fill="currentColor" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
									<path
										d="M18.8,16l5.5-5.5c0.8-0.8,0.8-2,0-2.8l0,0C24,7.3,23.5,7,23,7c-0.5,0-1,0.2-1.4,0.6L16,13.2l-5.5-5.5 c-0.8-0.8-2.1-0.8-2.8,0C7.3,8,7,8.5,7,9.1s0.2,1,0.6,1.4l5.5,5.5l-5.5,5.5C7.3,21.9,7,22.4,7,23c0,0.5,0.2,1,0.6,1.4 C8,24.8,8.5,25,9,25c0.5,0,1-0.2,1.4-0.6l5.5-5.5l5.5,5.5c0.8,0.8,2.1,0.8,2.8,0c0.8-0.8,0.8-2.1,0-2.8L18.8,16z">
									</path>
								</svg>
							</button>
						</div>
					@endif

			</div>
			{{-- Flash messages --}}
			@if ($errors->any())
				<div class="mb-2">
					<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
						<ul class="mt-2 list-disc list-inside text-sm">
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				</div>
			@endif

				{{-- session('error') toast rendered above --}}

			{{-- Page-specific content --}}
			@yield('content')

		</div>

        <div id="logoutConfirmModal" class="fixed inset-0 z-[120] hidden">
            <div class="absolute inset-0 bg-gray-950/50 backdrop-blur-sm" data-close-logout-modal></div>

            <div class="relative min-h-screen flex items-center justify-center p-4">
                <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white shadow-2xl overflow-hidden">
                    <div class="px-6 pt-6 pb-4">
                        <div class="flex items-start gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-600 border border-red-100">
                                <svg viewBox="0 0 24 24" class="w-6 h-6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.75 9V5.25C15.75 4.00736 14.7426 3 13.5 3H6.75C5.50736 3 4.5 4.00736 4.5 5.25V18.75C4.5 19.9926 5.50736 21 6.75 21H13.5C14.7426 21 15.75 19.9926 15.75 18.75V15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M18 12H9.75" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M14.25 8.25L18 12L14.25 15.75" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-950">Log out</h3>
                                <p class="mt-2 text-sm leading-6 text-gray-600">
                                    Are you sure you want to log out of the admin portal?
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 px-6 py-4 bg-gray-50 border-t border-gray-100">
                        <button type="button" id="cancelLogoutButton"
                            class="px-4 py-2.5 rounded-xl border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-100 transition shadow-none">
                            Cancel
                        </button>
                        <a href="{{ route('logout') }}" id="confirmLogoutButton"
                            class="px-4 py-2.5 rounded-xl bg-red-600 text-sm font-semibold text-white hover:bg-red-700 transition shadow-none">
                            Log out
                        </a>
                    </div>
                </div>
            </div>
        </div>

	</body>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			if (typeof renderIcons === 'function') {
				renderIcons();
			}

            const logoutModal = document.getElementById('logoutConfirmModal');
            const cancelLogoutButton = document.getElementById('cancelLogoutButton');
            const logoutTriggers = document.querySelectorAll('[data-open-logout-modal]');
            const logoutCloseTargets = document.querySelectorAll('[data-close-logout-modal]');

            function openLogoutModal(event) {
                if (event) {
                    event.preventDefault();
                }

                if (!logoutModal) return;

                logoutModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeLogoutModal() {
                if (!logoutModal) return;

                logoutModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            logoutTriggers.forEach((trigger) => {
                trigger.addEventListener('click', openLogoutModal);
            });

            logoutCloseTargets.forEach((target) => {
                target.addEventListener('click', closeLogoutModal);
            });

            cancelLogoutButton?.addEventListener('click', closeLogoutModal);

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && logoutModal && !logoutModal.classList.contains('hidden')) {
                    closeLogoutModal();
                }
            });
		});
	</script>

</html>
