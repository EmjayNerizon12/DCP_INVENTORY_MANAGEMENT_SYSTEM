<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<title>Login - DCP Inventory Management System</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" type="image/png" href="{{ asset('icon/logo.png') }}">
		<meta name="school-logo" content="{{ asset('icon/logo.png') }}">
		<meta name="school-name" content="Admin Access">
		<style>
			.login-body-font {
				font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
			}

			.login-title-font {
				font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
			}
		</style>
		@vite(['resources/css/app.css', 'resources/css/admin.css'])
	</head>

	<body class="min-h-screen bg-slate-100 text-gray-800 antialiased login-body-font">
		<div class="relative min-h-screen overflow-hidden bg-slate-100">
			<div class="relative mx-auto flex min-h-screen max-w-7xl items-center px-4 py-8 sm:px-6 lg:px-8">
				<div
					class="grid w-full overflow-hidden rounded-xl border border-gray-200 bg-white shadow-md lg:grid-cols-[1.05fr_0.95fr]">
					<div
						class="relative hidden overflow-hidden bg-[#0B3C8A] px-8 py-10 text-white lg:flex lg:flex-col lg:justify-between">
						<div class="relative">
							<div class="mb-10 flex items-center gap-4">
								<img src="{{ asset('icon/sdo-logo.png') }}"
									class="h-16 w-16 rounded-full border-2 border-white/30 object-cover bg-white shadow-lg" alt="SDO Logo">
								<div>
									<p class="text-xs font-semibold uppercase tracking-[0.28em] text-blue-100">ICT/ITO Portal</p>
									<h2 class="mt-1 text-lg font-semibold tracking-[0.14em] text-white">DCP Management System</h2>
								</div>
							</div>

							<div class="max-w-md">
								<p class="text-sm font-semibold uppercase tracking-[0.32em] text-blue-200">Schools Division Office</p>
								<h1 class="mt-4 text-3xl font-bold leading-tight tracking-[0.04em] sm:text-4xl login-title-font">San Carlos City
								</h1>
								<p class="mt-5 text-base leading-7 text-blue-50/95 sm:text-lg sm:leading-8">
									Centralized monitoring and management of ICT packages for public schools, aligned with the AdminSide workspace.
								</p>
							</div>
						</div>

						<div class="relative grid gap-4 text-sm text-blue-50/90 sm:grid-cols-2">
							<div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-sm">
								<p class="text-xs uppercase tracking-[0.22em] text-blue-100">System</p>
								<p class="mt-2 text-base font-semibold text-white">DCP Inventory Management System</p>
							</div>
							<div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-sm">
								<p class="text-xs uppercase tracking-[0.22em] text-blue-100">Access</p>
								<p class="mt-2 text-base font-semibold text-white">Secure credentials for administrators</p>
							</div>
						</div>
					</div>

					<div class="px-4 py-5 sm:px-8 sm:py-8 lg:px-10 lg:py-10">
						<div class="mx-auto flex w-full max-w-md flex-col justify-center">
							<div class="mb-6 flex items-center gap-3 sm:gap-4 lg:hidden">
								<img src="{{ asset('icon/sdo-logo.png') }}"
									class="h-20 w-20 rounded-full border border-blue-200 object-cover bg-white shadow-md sm:h-14 sm:w-14"
									alt="SDO Logo">
								<div>
									<p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#2F6FE4]">ICT/ITO Portal</p>
									<h1 class="text-base font-bold text-[#0B3C8A] sm:text-lg login-title-font">San Carlos City</h1>
									<p class="text-sm text-slate-600">DCP Management System</p>
								</div>
							</div>

							<div class="mb-7 sm:mb-8">
								<div class="flex items-center gap-3">
									<img src="{{ asset('icon/logo.png') }}"
										class="h-20 w-20 rounded-full border border-blue-100 bg-white p-1 shadow-sm sm:h-16 sm:w-16"
										alt="eDCP Hub Logo">
									<div>
										<p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#2F6FE4]">Welcome Back</p>
										<h2 class="mt-1 text-2xl font-bold leading-tight text-slate-900 sm:text-3xl login-title-font">eDCP Hub</h2>
									</div>
								</div>
								<p class="mt-4 text-sm leading-6 text-slate-600 sm:mt-5 sm:text-base sm:leading-7">
									Sign in using your administrator credentials to continue to the DCP Inventory Management System.
								</p>
							</div>

							<form class="space-y-5" onsubmit="event.preventDefault(); login();">
								<div>
									<label for="username"
										class="mb-1.5 block text-[0.85rem] font-semibold uppercase tracking-[0.16em] text-slate-700">Username</label>
									<input type="text" id="username" name="username" required
										class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-[0.96rem] text-slate-900 shadow-sm transition focus:border-[#2F6FE4] focus:outline-none focus:ring-2 focus:ring-blue-200"
										placeholder="Enter your username">
								</div>

								<div>
									<label for="password"
										class="mb-1.5 block text-[0.85rem] font-semibold uppercase tracking-[0.16em] text-slate-700">Password</label>
									<div class="relative">
										<input type="password" id="password" name="password" required
											class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-4 pr-11 text-[0.96rem] text-slate-900 shadow-sm transition focus:border-[#2F6FE4] focus:outline-none focus:ring-2 focus:ring-blue-200"
											placeholder="Enter your password">
										<button type="button" id="togglePassword"
											class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 shadow-none transition hover:text-[#0B3C8A]">
											<svg id="eyeIcon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0">
												</path>
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
													d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7s-8.268-2.943-9.542-7z">
												</path>
											</svg>
										</button>
									</div>
								</div>

								<button id="login-button-submit" type="submit"
									class="w-full rounded-xl border border-[#2F6FE4] bg-[#2F6FE4] py-3 text-[0.94rem] font-semibold uppercase tracking-[0.18em] text-white shadow-md transition hover:bg-[#1D4ED8] disabled:cursor-not-allowed disabled:opacity-60">
									Sign In
								</button>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="login-modal" class="fixed inset-0 z-50 hidden">
			<div class="fixed inset-0 bg-gray-950/50 backdrop-blur-sm transition-opacity" data-close-login-modal></div>
			<div class="fixed inset-0 flex items-center justify-center p-4">
				<div
					class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all border border-gray-200">
					<div class="px-6 py-6">
						<div class="flex items-start gap-4">
							<div id="status-icon-wrapper" class="flex h-12 w-12 items-center justify-center rounded-xl border shrink-0">
								<div id="status-icon"></div>
							</div>
							<div class="flex-1">
								<h3 id="status-title" class="text-lg font-semibold text-gray-950"></h3>
								<div id="status-text" class="mt-2 text-sm leading-6 text-gray-600"></div>
							</div>
						</div>
					</div>
					<div class="px-6 py-4 flex justify-end gap-3 bg-gray-50 border-t border-gray-100">
						<button id="modal-cancel-button" type="button"
							class="hidden justify-center rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-[0.9rem] font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 shadow-none">
							Cancel
						</button>
						<button id="modal-button"
							class="inline-flex justify-center rounded-xl border border-transparent bg-[#2F6FE4] px-4 py-2.5 text-[0.9rem] font-medium text-white hover:bg-[#1D4ED8] focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 shadow-none">
							Continue
						</button>
					</div>
				</div>
			</div>
		</div>

		<script>
			const togglePassword = document.getElementById('togglePassword');
			const passwordInput = document.getElementById('password');
			const eyeIcon = document.getElementById('eyeIcon');
			const loginButton = document.getElementById('login-button-submit');
			const usernameInput = document.getElementById('username');
			const loginModal = document.getElementById('login-modal');
			const modalButton = document.getElementById('modal-button');
			const modalCancelButton = document.getElementById('modal-cancel-button');
			const statusTitle = document.getElementById('status-title');
			const statusText = document.getElementById('status-text');
			const statusIcon = document.getElementById('status-icon');
			const statusIconWrapper = document.getElementById('status-icon-wrapper');

			togglePassword.addEventListener('click', () => {
				const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
				passwordInput.setAttribute('type', type);

				if (type === 'password') {
					eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7s-8.268-2.943-9.542-7z"></path>
                `;
				} else {
					eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                `;
				}
			});

			function openLoginModal() {
				loginModal.classList.remove('hidden');
				document.body.classList.add('overflow-hidden');
			}

			function closeLoginModal() {
				loginModal.classList.add('hidden');
				document.body.classList.remove('overflow-hidden');
			}

			function setLoginModalState({
				type,
				title,
				message,
				confirmText,
				onConfirm,
				showCancel = false,
			}) {
				const isSuccess = type === 'success';

				statusTitle.textContent = title;
				statusText.innerHTML = message;
				statusIconWrapper.className =
					`flex h-12 w-12 items-center justify-center rounded-xl border shrink-0 ${isSuccess ? 'bg-blue-50 text-[#2F6FE4] border-blue-100' : 'bg-red-50 text-red-600 border-red-100'}`;
				statusIcon.innerHTML = isSuccess ?
					`<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<circle cx="12" cy="12" r="9" stroke-width="2"></circle>
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8 12.5l2.5 2.5L16 9"></path>
					</svg>` :
					`<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path d="M12 8V13" stroke-width="2.2" stroke-linecap="round"></path>
						<path d="M12 16H12.01" stroke-width="2.2" stroke-linecap="round"></path>
						<circle cx="12" cy="12" r="9" stroke-width="2"></circle>
					</svg>`;

				modalButton.textContent = confirmText;
				modalButton.className = isSuccess ?
					'inline-flex justify-center rounded-xl border border-transparent bg-[#2F6FE4] px-4 py-2.5 text-[0.9rem] font-medium text-white hover:bg-[#1D4ED8] focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 shadow-none' :
					'inline-flex justify-center rounded-xl border border-transparent bg-red-600 px-4 py-2.5 text-[0.9rem] font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 shadow-none';
				modalButton.onclick = onConfirm;

				modalCancelButton.classList.toggle('hidden', !showCancel);
				modalCancelButton.classList.toggle('inline-flex', showCancel);

				openLoginModal();
			}

			document.querySelectorAll('[data-close-login-modal]').forEach((element) => {
				element.addEventListener('click', closeLoginModal);
			});

			modalCancelButton.addEventListener('click', closeLoginModal);

			document.addEventListener('keydown', (event) => {
				if (event.key === 'Escape' && !loginModal.classList.contains('hidden')) {
					closeLoginModal();
				}
			});

			async function login() {
				try {
					loginButton.disabled = true;
					loginButton.textContent = 'Signing In...';

					const response = await fetch('/login-submit', {
						method: 'POST',
						headers: {
							'Content-Type': 'application/json',
							'X-CSRF-TOKEN': '{{ csrf_token() }}',
						},
						body: JSON.stringify({
							username: usernameInput.value,
							password: passwordInput.value,
						}),
					});

					const data = await response.json();

					if (data.success) {
						setLoginModalState({
							type: 'success',
							title: data.message ?? 'Login successful',
							message: 'You have successfully logged into your account.',
							confirmText: 'Continue',
							onConfirm: function() {
								window.location.href = data.redirect_url;
							},
						});
					} else {
						setLoginModalState({
							type: 'error',
							title: 'Login failed',
							message: data.message ?? 'Invalid username or password. Please try again.',
							confirmText: 'Try Again',
							showCancel: true,
							onConfirm: function() {
								closeLoginModal();
							},
						});
					}
				} catch (error) {
					setLoginModalState({
						type: 'error',
						title: 'Login failed',
						message: 'Something went wrong. Please try again.',
						confirmText: 'Try Again',
						showCancel: true,
						onConfirm: function() {
							closeLoginModal();
						},
					});
				} finally {
					loginButton.disabled = false;
					loginButton.textContent = 'Sign In';
				}
			}

			@if ($errors->any())
				setLoginModalState({
					type: 'error',
					title: 'Login failed',
					message: `{!! implode('<br>', $errors->all()) !!}`,
					confirmText: 'Try Again',
					showCancel: true,
					onConfirm: function() {
						closeLoginModal();
					},
				});
			@endif
		</script>
	</body>

</html>
