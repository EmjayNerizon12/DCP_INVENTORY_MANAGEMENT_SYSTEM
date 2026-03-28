<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<title>Login - DCP Inventory Management System</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" type="image/png" href="{{ asset('icon/logo.png') }}">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<meta name="school-logo" content="{{ asset('icon/logo.png') }}">
		<meta name="school-name" content="Admin Access">
        
		<link
			href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap"
			rel="stylesheet">
		<style>
			.login-body-font {
				font-family: "Plus Jakarta Sans", "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
			}

			.login-title-font {
				font-family: "Space Grotesk", "Plus Jakarta Sans", "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
			}
		</style>
		@vite(['resources/css/app.css','resources/css/admin.css'])
	</head>

		<body class="min-h-screen bg-gray-200 text-gray-800 antialiased login-body-font">
		<div class="min-h-screen flex items-center justify-center px-4 py-8">
			<div class="w-full max-w-md bg-white border border-gray-300 rounded-xl shadow-md p-6 sm:p-8">
				<div class="flex items-center justify-center gap-3 mb-5">
					<img src="{{ asset('icon/logo.png') }}"
						class="h-20 w-20 sm:h-30 sm:w-30 rounded-full border border-gray-300 bg-white p-1 shadow-sm" alt="eDCP Hub Logo">
				</div>

				<div class="text-center mb-7">
						<h1
							class="text-[1.85rem] sm:text-[2.1rem] leading-tight font-semibold tracking-tight text-gray-900 login-title-font">
						eDCP Hub
					</h1>
					<p class="mt-2 sm:text-lg text-sm leading-6 text-gray-600 font-medium">
						A Centralized ICT Package Management<br>
						for SDO San Carlos City Public Schools
					</p>
				</div>

				<form class="space-y-5" onsubmit="event.preventDefault(); login();">
					<div>
						<label for="username"
							class="block text-[0.86rem] font-semibold tracking-wide text-gray-700 mb-1.5">Username</label>
						<input type="text" id="username" name="username" required
							class="w-full rounded-md border border-gray-300 bg-white px-3.5 py-2.5 text-[0.95rem] text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500"
							placeholder="Enter your username">
					</div>

					<div>
						<label for="password"
							class="block text-[0.86rem] font-semibold tracking-wide text-gray-700 mb-1.5">Password</label>
						<div class="relative">
							<input type="password" id="password" name="password" required
								class="w-full rounded-md border border-gray-300 bg-white pl-3.5 pr-10 py-2.5 text-[0.95rem] text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500"
								placeholder="Enter your password">
							<button type="button" id="togglePassword"
								class="absolute shadow-none inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700">
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
						class="w-full rounded-md bg-gray-800 text-white text-[0.92rem] font-semibold tracking-[0.04em] py-2.5 hover:bg-gray-900 disabled:opacity-60 disabled:cursor-not-allowed">
						Sign In
					</button>
				</form>
			</div>
		</div>

		<div id="login-modal" class="fixed inset-0 z-50 hidden">
			<div class="fixed inset-0 bg-gray-950/50 backdrop-blur-sm transition-opacity" data-close-login-modal></div>
			<div class="fixed inset-0 flex items-center justify-center p-4">
				<div
					class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all border border-gray-200">
					<div class="px-6 py-6">
						<div class="flex items-start gap-4">
							<div id="status-icon-wrapper"
								class="flex h-12 w-12 items-center justify-center rounded-xl border shrink-0">
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
							class="inline-flex justify-center rounded-xl border border-transparent bg-gray-800 px-4 py-2.5 text-[0.9rem] font-medium text-white hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 shadow-none">
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
					`flex h-12 w-12 items-center justify-center rounded-xl border shrink-0 ${isSuccess ? 'bg-green-50 text-green-600 border-green-100' : 'bg-red-50 text-red-600 border-red-100'}`;
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
					'inline-flex justify-center rounded-xl border border-transparent bg-gray-900 px-4 py-2.5 text-[0.9rem] font-medium text-white hover:bg-black focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 shadow-none' :
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
