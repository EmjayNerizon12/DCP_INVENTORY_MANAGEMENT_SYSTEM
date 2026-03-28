<div id="sidebar" class="sidebar py-10 ">
	@php
		$navCategories = [
		    'DCP Item' => [
		        [
		            'label' => 'Product',
                    'core' => true,
		            'url' => route('index.dcp.items'),
		            'active' => request()->routeIs('index.dcp.items'),
		            'icon' => '<svg viewBox="0 0 24 24" class="w-10 h-10" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
							<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
							<g id="SVGRepo_iconCarrier">
								<path
									d="M4 15.8294V15.75V8C4 7.69114 4.16659 7.40629 4.43579 7.25487L4.45131 7.24614L11.6182 3.21475L11.6727 3.18411C11.8759 3.06979 12.1241 3.06979 12.3273 3.18411L19.6105 7.28092C19.8511 7.41625 20 7.67083 20 7.94687V8V15.75V15.8294C20 16.1119 19.8506 16.3733 19.6073 16.5167L12.379 20.7766C12.1451 20.9144 11.8549 20.9144 11.621 20.7766L4.39267 16.5167C4.14935 16.3733 4 16.1119 4 15.8294Z"
									stroke="currentColor" stroke-width="2"></path>
								<path d="M12 21V12" stroke="currentColor" stroke-width="2"></path>
								<path d="M12 12L4 7.5" stroke="currentColor" stroke-width="2"></path>
								<path d="M20 7.5L12 12" stroke="currentColor" stroke-width="2"></path>
							</g>
						</svg>',
		        ],
		        [
		            'label' => 'Package',
                    'core' => true,
		            'url' => route('index.dcp.package'),
		            'active' => request()->routeIs('index.dcp.package'),
		            'icon' => '<svg viewBox="0 0 24 24" class="w-10 h-10" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
							<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
							<g id="SVGRepo_iconCarrier">
								<path
									d="M4 15.8294V15.75V8C4 7.69114 4.16659 7.40629 4.43579 7.25487L4.45131 7.24614L11.6182 3.21475L11.6727 3.18411C11.8759 3.06979 12.1241 3.06979 12.3273 3.18411L19.6105 7.28092C19.8511 7.41625 20 7.67083 20 7.94687V8V15.75V15.8294C20 16.1119 19.8506 16.3733 19.6073 16.5167L12.379 20.7766C12.1451 20.9144 11.8549 20.9144 11.621 20.7766L4.39267 16.5167C4.14935 16.3733 4 16.1119 4 15.8294Z"
									stroke="currentColor" stroke-width="2"></path>
								<path d="M12 21V12" stroke="currentColor" stroke-width="2"></path>
								<path d="M12 12L4 7.5" stroke="currentColor" stroke-width="2"></path>
								<path d="M20 7.5L12 12" stroke="currentColor" stroke-width="2"></path>
							</g>
						</svg>',
		        ],
		        [
		            'label' => 'Batch',
                    'core' => true,
		            'url' => route('index.batch'),
		            'active' => Request::is('Admin/DCPBatch/index'),
		            'icon' => '<svg viewBox="0 0 24 24" class="w-10 h-10" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
							<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
							<g id="SVGRepo_iconCarrier">
								<path
									d="M4 15.8294V15.75V8C4 7.69114 4.16659 7.40629 4.43579 7.25487L4.45131 7.24614L11.6182 3.21475L11.6727 3.18411C11.8759 3.06979 12.1241 3.06979 12.3273 3.18411L19.6105 7.28092C19.8511 7.41625 20 7.67083 20 7.94687V8V15.75V15.8294C20 16.1119 19.8506 16.3733 19.6073 16.5167L12.379 20.7766C12.1451 20.9144 11.8549 20.9144 11.621 20.7766L4.39267 16.5167C4.14935 16.3733 4 16.1119 4 15.8294Z"
									stroke="currentColor" stroke-width="2"></path>
								<path d="M12 21V12" stroke="currentColor" stroke-width="2"></path>
								<path d="M12 12L4 7.5" stroke="currentColor" stroke-width="2"></path>
								<path d="M20 7.5L12 12" stroke="currentColor" stroke-width="2"></path>
							</g>
						</svg>',
		        ],
		        [
		            'label' => 'Inventory',
                    'core' => true,
		            'url' => route('index.SchoolsInventory'),
		            'active' => request()->routeIs('index.SchoolsInventory'),
		            'icon' => '<svg viewBox="0 0 24 24" class="w-10 h-10" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
							<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
							<g id="SVGRepo_iconCarrier">
								<path
									d="M4 15.8294V15.75V8C4 7.69114 4.16659 7.40629 4.43579 7.25487L4.45131 7.24614L11.6182 3.21475L11.6727 3.18411C11.8759 3.06979 12.1241 3.06979 12.3273 3.18411L19.6105 7.28092C19.8511 7.41625 20 7.67083 20 7.94687V8V15.75V15.8294C20 16.1119 19.8506 16.3733 19.6073 16.5167L12.379 20.7766C12.1451 20.9144 11.8549 20.9144 11.621 20.7766L4.39267 16.5167C4.14935 16.3733 4 16.1119 4 15.8294Z"
									stroke="currentColor" stroke-width="2"></path>
								<path d="M12 21V12" stroke="currentColor" stroke-width="2"></path>
								<path d="M12 12L4 7.5" stroke="currentColor" stroke-width="2"></path>
								<path d="M20 7.5L12 12" stroke="currentColor" stroke-width="2"></path>
							</g>
						</svg>',
		        ],
		        [
		            'label' => 'Product Condition',
		            'url' => url('/Admin/ItemConditions/0'),
		            'active' => Request::is('Admin/ItemConditions/0'),
		            'icon' => '<svg viewBox="0 0 24 24" class="w-10 h-10" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
							<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
							<g id="SVGRepo_iconCarrier">
								<path
									d="M4 15.8294V15.75V8C4 7.69114 4.16659 7.40629 4.43579 7.25487L4.45131 7.24614L11.6182 3.21475L11.6727 3.18411C11.8759 3.06979 12.1241 3.06979 12.3273 3.18411L19.6105 7.28092C19.8511 7.41625 20 7.67083 20 7.94687V8V15.75V15.8294C20 16.1119 19.8506 16.3733 19.6073 16.5167L12.379 20.7766C12.1451 20.9144 11.8549 20.9144 11.621 20.7766L4.39267 16.5167C4.14935 16.3733 4 16.1119 4 15.8294Z"
									stroke="currentColor" stroke-width="2"></path>
								<path d="M12 21V12" stroke="currentColor" stroke-width="2"></path>
								<path d="M12 12L4 7.5" stroke="currentColor" stroke-width="2"></path>
								<path d="M20 7.5L12 12" stroke="currentColor" stroke-width="2"></path>
							</g>
						</svg>',
		        ],
		    ],
		    'Dropdowns' => [
		        [
		            'label' => 'Products',
		            'url' => route('index.crud'),
		            'active' => request()->routeIs('index.crud'),
		            'icon' =>
		                '<svg viewBox="-0.5 0 25 25" class="w-6 h-6 mr-2" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M19 3.32001H16C14.8954 3.32001 14 4.21544 14 5.32001V8.32001C14 9.42458 14.8954 10.32 16 10.32H19C20.1046 10.32 21 9.42458 21 8.32001V5.32001C21 4.21544 20.1046 3.32001 19 3.32001Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M8 3.32001H5C3.89543 3.32001 3 4.21544 3 5.32001V8.32001C3 9.42458 3.89543 10.32 5 10.32H8C9.10457 10.32 10 9.42458 10 8.32001V5.32001C10 4.21544 9.10457 3.32001 8 3.32001Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M19 14.32H16C14.8954 14.32 14 15.2154 14 16.32V19.32C14 20.4246 14.8954 21.32 16 21.32H19C20.1046 21.32 21 20.4246 21 19.32V16.32C21 15.2154 20.1046 14.32 19 14.32Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M8 14.32H5C3.89543 14.32 3 15.2154 3 16.32V19.32C3 20.4246 3.89543 21.32 5 21.32H8C9.10457 21.32 10 20.4246 10 19.32V16.32C10 15.2154 9.10457 14.32 8 14.32Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>',
		        ],
		        [
		            'label' => 'Internet',
		            'url' => route('isp.index.list'),
		            'active' => request()->routeIs('isp.index.list'),
		            'icon' =>
		                '<svg viewBox="0 0 20 20" fill="none" class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M8.763 13.58a1.75 1.75 0 1 1 2.473 2.477 1.75 1.75 0 0 1-2.473-2.478v.001zM3.4 10.825c3.64-3.64 9.56-3.64 13.2 0l-1.65 1.65a7.007 7.007 0 0 0-9.9 0l-1.65-1.65zm-3.3-3.3c5.46-5.459 14.34-5.459 19.8 0l-1.65 1.65c-4.55-4.55-11.95-4.55-16.5 0L.1 7.526v-.001z" fill="currentColor"></path></g></svg>',
		        ],
		        [
		            'label' => 'Employee',
		            'url' => route('employee.index'),
		            'active' => request()->routeIs('employee.index'),
		            'icon' =>
		                '<svg fill="currentColor" class="w-6 h-6 mr-2" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>employee_solid</title> <g id="aad88ad3-6d51-4184-9840-f392d18dd002" data-name="Layer 3"> <circle cx="16.86" cy="9.73" r="6.46"></circle> <rect x="21" y="28" width="7" height="1.4"></rect> <path d="M15,30v3a1,1,0,0,0,1,1H33a1,1,0,0,0,1-1V23a1,1,0,0,0-1-1H26V20.53a1,1,0,0,0-2,0V22H22V18.42A32.12,32.12,0,0,0,16.86,18a26,26,0,0,0-11,2.39,3.28,3.28,0,0,0-1.88,3V30Zm17,2H17V24h7v.42a1,1,0,0,0,2,0V24h6Z"></path> </g> </g></svg>',
		        ],
		        [
		            'label' => 'Equipment',
		            'url' => route('admin.schoolEquipment.index'),
		            'active' => request()->routeIs('admin.schoolEquipment.index'),
		            'icon' =>
		                '<svg fill="currentColor"  class="w-6 h-6 mr-2" viewBox="-3.5 0 19 19" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M11.405 5.34a.554.554 0 1 1-.996.485 5.563 5.563 0 0 0-1.375-1.782 1.201 1.201 0 0 0-1.786 1.05v.61a.476.476 0 0 1-.475.475h-2.48a.476.476 0 0 1-.475-.475v.07a1.194 1.194 0 0 0-.196-.657 2.145 2.145 0 0 1-.084-.113 1.202 1.202 0 0 0-1.94.134.554.554 0 0 1-1.06-.23v-2.28a.554.554 0 0 1 1.07-.202 1.2 1.2 0 0 0 1.902.148 2.176 2.176 0 0 1 .137-.186l.007-.011h.003a2.167 2.167 0 0 1 1.668-.781h.03a.516.516 0 0 1 .058-.003 6.662 6.662 0 0 1 5.993 3.748zM6.768 7.455a.476.476 0 0 0-.475-.475H4.578a.477.477 0 0 0-.475.475V16.9a.476.476 0 0 0 .475.475h1.715a.476.476 0 0 0 .475-.475z"></path></g></svg>',
		        ],
		        [
		            'label' => 'CCTV & Biomertrics',
		            'url' => route('equipment.index.list'),
		            'active' => request()->routeIs('equipment.index.list'),
		            'icon' =>
		                '<svg viewBox="0 0 24 24" class="w-6 h-6 mr-2" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>fingerprint_line</title> <g id="页面-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="System" transform="translate(-48.000000, -288.000000)"> <g id="fingerprint_line" transform="translate(48.000000, 288.000000)"> <path d="M24,0 L24,24 L0,24 L0,0 L24,0 Z M12.5934901,23.257841 L12.5819402,23.2595131 L12.5108777,23.2950439 L12.4918791,23.2987469 L12.4918791,23.2987469 L12.4767152,23.2950439 L12.4056548,23.2595131 C12.3958229,23.2563662 12.3870493,23.2590235 12.3821421,23.2649074 L12.3780323,23.275831 L12.360941,23.7031097 L12.3658947,23.7234994 L12.3769048,23.7357139 L12.4804777,23.8096931 L12.4953491,23.8136134 L12.4953491,23.8136134 L12.5071152,23.8096931 L12.6106902,23.7357139 L12.6232938,23.7196733 L12.6232938,23.7196733 L12.6266527,23.7031097 L12.609561,23.275831 C12.6075724,23.2657013 12.6010112,23.2592993 12.5934901,23.257841 L12.5934901,23.257841 Z M12.8583906,23.1452862 L12.8445485,23.1473072 L12.6598443,23.2396597 L12.6498822,23.2499052 L12.6498822,23.2499052 L12.6471943,23.2611114 L12.6650943,23.6906389 L12.6699349,23.7034178 L12.6699349,23.7034178 L12.678386,23.7104931 L12.8793402,23.8032389 C12.8914285,23.8068999 12.9022333,23.8029875 12.9078286,23.7952264 L12.9118235,23.7811639 L12.8776777,23.1665331 C12.8752882,23.1545897 12.8674102,23.1470016 12.8583906,23.1452862 L12.8583906,23.1452862 Z M12.1430473,23.1473072 C12.1332178,23.1423925 12.1221763,23.1452606 12.1156365,23.1525954 L12.1099173,23.1665331 L12.0757714,23.7811639 C12.0751323,23.7926639 12.0828099,23.8018602 12.0926481,23.8045676 L12.108256,23.8032389 L12.3092106,23.7104931 L12.3186497,23.7024347 L12.3186497,23.7024347 L12.3225043,23.6906389 L12.340401,23.2611114 L12.337245,23.2485176 L12.337245,23.2485176 L12.3277531,23.2396597 L12.1430473,23.1473072 Z" id="MingCute" fill-rule="nonzero"> </path> <path d="M12,4 C8.13401,4 5,7.13401 5,11 L5,13 C5,13.5523 4.55228,14 4,14 C3.44772,14 3,13.5523 3,13 L3,11 C3,6.02944 7.02944,2 12,2 C16.9706,2 21,6.02944 21,11 L21,14 C20.9998,14.2621 20.9888,14.5244 20.9752,14.786 C20.9508,15.2591 20.9018,15.913 20.8033,16.6351 C20.6145,18.0199 20.2178,19.8763 19.3,21.1 C18.9686,21.5418 18.3418,21.6314 17.9,21.3 C17.4582,20.9686 17.3686,20.3418 17.7,19.9 C18.2822,19.1237 18.6355,17.7301 18.8217,16.3649 C18.9107,15.712 18.9555,15.1159 18.9779,14.6827 C18.9897,14.4553 18.9996,14.2273 19,13.9996 L19,11 C19,7.13401 15.866,4 12,4 Z M12,8 C10.3431,8 9,9.34315 9,11 L9,12 C9,12.9403 8.69626,14.1008 8.13235,15.1581 C7.56532,16.2213 6.68336,17.2764 5.44721,17.8944 C4.95324,18.1414 4.35256,17.9412 4.10557,17.4472 C3.85858,16.9532 4.05881,16.3526 4.55279,16.1056 C5.31664,15.7236 5.93468,15.0287 6.36765,14.2169 C6.80374,13.3992 7,12.5597 7,12 L7,11 C7,8.23858 9.23858,6 12,6 C14.7614,6 17.0000161,8.23858 17.0000161,11 L17.0000161,12 L17.0000161,12.1166 C17.0006,15.0415 17.0014,18.9672 13.6402,21.7682 C13.2159,22.1218 12.5853,22.0645 12.2318,21.6402 C11.8782,21.2159 11.9355,20.5853 12.3598,20.2318 C14.9537,18.0702 15,15.0635 15,12 L15,11 C15,9.34315 13.6569,8 12,8 Z M13,11.5 C13,10.9477 12.5523,10.5 12,10.5 C11.4477,10.5 11,10.9477 11,11.5 C11,12.6974 10.8785,14.2023 10.4263,15.5588 C9.97506,16.9125 9.2319,18.016 8.05279,18.6056 C7.55881,18.8526 7.35858,19.4532 7.60557,19.9472 C7.85256,20.4412 8.45324,20.6414 8.94721,20.3944 C10.7681,19.484 11.7749,17.8375 12.3237,16.1912 C12.8715,14.5477 13,12.8026 13,11.5 Z" id="形状" fill="currentColor"> </path> </g> </g> </g> </g></svg>',
		        ],
		    ],
            'Report' => [
		        [
		            'label' => 'Reports',
		            'url' => route('admin.reports.index'),
		            'active' => request()->routeIs('admin.reports.index'),
		            'icon' =>
		                '<svg class="w-6 h-6 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M9.29289 1.29289C9.48043 1.10536 9.73478 1 10 1H18C19.6569 1 21 2.34315 21 4V20C21 21.6569 19.6569 23 18 23H6C4.34315 23 3 21.6569 3 20V8C3 7.73478 3.10536 7.48043 3.29289 7.29289L9.29289 1.29289ZM18 3H11V8C11 8.55228 10.5523 9 10 9H5V20C5 20.5523 5.44772 21 6 21H18C18.5523 21 19 20.5523 19 20V4C19 3.44772 18.5523 3 18 3ZM6.41421 7H9V4.41421L6.41421 7ZM7 13C7 12.4477 7.44772 12 8 12H16C16.5523 12 17 12.4477 17 13C17 13.5523 16.5523 14 16 14H8C7.44772 14 7 13.5523 7 13ZM7 17C7 16.4477 7.44772 16 8 16H16C16.5523 16 17 16.4477 17 17C17 17.5523 16.5523 18 16 18H8C7.44772 18 7 17.5523 7 17Z" fill="currentColor"></path> </g></svg>',
		        ],
             ],
            'Setting' => [
		        [
		            'label' => 'Administrator',
		            'url' => route('admin.account.index'),
		            'active' => request()->routeIs('admin.account.index'),
		            'icon' =>
		                '<svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><title>Account Settings</title><path d="M9.6,3.32a3.86,3.86,0,1,0,3.86,3.85A3.85,3.85,0,0,0,9.6,3.32M16.35,11a.26.26,0,0,0-.25.21l-.18,1.27a4.63,4.63,0,0,0-.82.45l-1.2-.48a.3.3,0,0,0-.3.13l-1,1.66a.24.24,0,0,0,.06.31l1,.79a3.94,3.94,0,0,0,0,1l-1,.79a.23.23,0,0,0-.06.3l1,1.67c.06.13.19.13.3.13l1.2-.49a3.85,3.85,0,0,0,.82.46l.18,1.27a.24.24,0,0,0,.25.2h1.93a.24.24,0,0,0,.23-.2l.18-1.27a5,5,0,0,0,.81-.46l1.19.49c.12,0,.25,0,.32-.13l1-1.67a.23.23,0,0,0-.06-.3l-1-.79a4,4,0,0,0,0-.49,2.67,2.67,0,0,0,0-.48l1-.79a.25.25,0,0,0,.06-.31l-1-1.66c-.06-.13-.19-.13-.31-.13L19.5,13a4.07,4.07,0,0,0-.82-.45l-.18-1.27a.23.23,0,0,0-.22-.21H16.46M9.71,13C5.45,13,2,14.7,2,16.83v1.92h9.33a6.65,6.65,0,0,1,0-5.69A13.56,13.56,0,0,0,9.71,13m7.6,1.43a1.45,1.45,0,1,1,0,2.89,1.45,1.45,0,0,1,0-2.89Z"></path></g></svg>',
		        ],
                   [
		            'label' => 'Logout',
		            'url' => route('logout'),
                    'modal' => 'logout',
		            'active' => request()->routeIs('logout'),
		            'icon' =>
		                '<svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>logout</title> <path d="M0 9.875v12.219c0 1.125 0.469 2.125 1.219 2.906 0.75 0.75 1.719 1.156 2.844 1.156h6.125v-2.531h-6.125c-0.844 0-1.5-0.688-1.5-1.531v-12.219c0-0.844 0.656-1.5 1.5-1.5h6.125v-2.563h-6.125c-1.125 0-2.094 0.438-2.844 1.188-0.75 0.781-1.219 1.75-1.219 2.875zM6.719 13.563v4.875c0 0.563 0.5 1.031 1.063 1.031h5.656v3.844c0 0.344 0.188 0.625 0.5 0.781 0.125 0.031 0.25 0.031 0.313 0.031 0.219 0 0.406-0.063 0.563-0.219l7.344-7.344c0.344-0.281 0.313-0.844 0-1.156l-7.344-7.313c-0.438-0.469-1.375-0.188-1.375 0.563v3.875h-5.656c-0.563 0-1.063 0.469-1.063 1.031z"></path> </g></svg>',
		        ],
             ],
		];

		$topLinks = [
		    [
		        'label' => 'Dashboard',
		        'url' => route('admin.dashboard'),
		        'active' => request()->routeIs('admin.dashboard'),
		        'icon' =>
		            '<svg  class="w-6 h-6 mr-2" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M8 0L0 6V8H1V15H4V10H7V15H15V8H16V6L14 4.5V1H11V2.25L8 0ZM9 10H12V13H9V10Z" fill="currentColor"></path> </g></svg>',
		    ],
		    [
		        'label' => 'Product Search',
		        'url' => route('index.page.search'),
		        'active' => request()->routeIs('index.page.search'),
		        'icon' =>
		            '<svg  class="w-6 h-6 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15.7955 15.8111L21 21M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>',
		    ],
		    [
		        'label' => 'Product Disposal',
		        'url' => route('admin.scan.monitor'),
		        'active' => request()->routeIs('admin.scan.monitor'),
		        'icon' =>
		            '<svg  class="w-6 h-6 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6 6L6.80086 18.0129C6.871 19.065 6.90607 19.5911 7.13332 19.99C7.33339 20.3412 7.63517 20.6235 7.99889 20.7998C8.41202 21 8.94135 21 10 21M18 6L17.8 9M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M17 15.5V17H18.5M21 17C21 19.2091 19.2091 21 17 21C14.7909 21 13 19.2091 13 17C13 14.7909 14.7909 13 17 13C19.2091 13 21 14.7909 21 17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>',
		    ],
		    [
		        'label' => 'School',
		        'url' => route('index.schools'),
		        'active' => request()->routeIs('index.schools'),
		        'icon' =>
		            '<svg class="w-6 h-6 mr-2" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><title>ionicons-v5-q</title><polygon points="32 192 256 64 480 192 256 320 32 192" style="fill:none;stroke:currentColor;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></polygon><polyline points="112 240 112 368 256 448 400 368 400 240" style="fill:none;stroke:currentColor;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></polyline><line x1="480" y1="368" x2="480" y2="192" style="fill:none;stroke:currentColor;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></line><line x1="256" y1="320" x2="256" y2="448" style="fill:none;stroke:currentColor;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></line></g></svg>',
		    ],
		    [
		        'label' => 'School Accounts',
		        'url' => route('user.schools'),
		        'active' => request()->routeIs('user.schools'),
		        'icon' =>
		            '<svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M 33.7033 50.6023 C 45.8956 50.6023 56 40.4980 56 28.3056 C 56 16.1355 45.8735 6.0088 33.6809 6.0088 C 22.4539 6.0088 12.9559 14.6536 11.6086 25.5437 C 18.5918 25.6560 24.4523 30.7755 25.6648 37.4668 C 28.0449 36.4563 30.8068 35.8725 33.7033 35.8725 C 39.2269 35.8725 44.0994 37.9383 47.0632 41.1267 C 43.6952 44.6071 38.9575 46.8076 33.6809 46.8076 C 30.5822 46.8076 27.6632 46.0217 25.1034 44.6969 C 24.6993 45.8870 24.1604 47.0096 23.4194 48.0650 C 26.5405 49.6817 30.0209 50.6023 33.7033 50.6023 Z M 33.6809 32.1002 C 29.3921 32.1002 26.1363 28.3505 26.1363 23.6800 C 26.1363 19.2566 29.4595 15.4170 33.6809 15.4170 C 37.9246 15.4170 41.2703 19.2566 41.2478 23.6800 C 41.2478 28.3505 37.9920 32.1002 33.6809 32.1002 Z M 11.4066 51.4555 C 17.6712 51.4555 22.8132 46.3360 22.8132 40.0489 C 22.8132 33.8068 17.6712 28.6424 11.4066 28.6424 C 5.1644 28.6424 0 33.8068 0 40.0489 C 0 46.3360 5.1644 51.4555 11.4066 51.4555 Z M 11.4066 41.8453 C 10.6656 41.8453 10.1267 41.3513 10.1043 40.6103 L 9.9246 34.4130 C 9.9022 33.5373 10.5084 32.9311 11.4066 32.9311 C 12.3272 32.9311 12.9110 33.5373 12.8885 34.4130 L 12.7089 40.6103 C 12.6865 41.3513 12.1700 41.8453 11.4066 41.8453 Z M 11.4066 47.2117 C 10.3961 47.2117 9.5654 46.3809 9.5654 45.3705 C 9.5654 44.3601 10.3961 43.5293 11.4066 43.5293 C 12.4395 43.5293 13.2478 44.3601 13.2478 45.3705 C 13.2478 46.3809 12.4395 47.2117 11.4066 47.2117 Z"></path></g></svg>',
		    ],
		];
	@endphp
	<nav class="mt-4 space-y-1 sidebar-nav">
		@foreach ($topLinks as $link)
			<div class=" tracking-wider mt-3">
				<a href="{{ $link['url'] }}"
					class="nav-link relative flex  justify-start text-sm md:text-lg  mx-2 rounded-md transition-all
					{{ $link['active'] ? 'active' : '' }}">
					{!! $link['icon'] !!}
					{{ $link['label'] }}
				</a>
			</div>
		@endforeach
		@foreach ($navCategories as $category => $links)
			<div class="tracking-wider mt-3">

				<div class="flex items-center gap-2 text-sm md:text-lg px-4 py-2 mx-2 mt-4">
					{{ $category }} <x-badge color="blue">Feature</x-badge>
				</div>
				@foreach ($links as $link)
					<a href="{{ $link['url'] }}" style="letter-spacing:0.05rem;"
                        @if (($link['modal'] ?? null) === 'logout')
                            data-open-logout-modal="true"
                        @endif
							class="flex flex justify-start text-sm md:text-lg nav-link rounded-md md:text-base px-4 py-2
							{{ $link['active'] ? 'active' : '' }}">
						{!! $link['icon'] !!}
						{{ $link['label'] }}
                        @if (isset($link['core']) && $link['core'])
                                @if ($link['active'])
                                <div class="ml-auto"> <x-badge color="white">Core</x-badge></div>
                                @else
                                <div class="ml-auto"> <x-badge color="green">Core</x-badge></div>
                                @endif
                        @endif

					</a>
				@endforeach
			</div>
		@endforeach

	</nav>
</div>
