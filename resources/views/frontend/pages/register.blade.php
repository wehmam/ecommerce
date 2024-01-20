<!DOCTYPE html>
<html lang="en" class="border-l">
<head>
    <meta charset="UTF-8">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>Register</title>
    <style>
        * {
            margin:0;
            padding:0;
        }
        .input {
            transition: border 0.2s ease-in-out;
            min-width: 280px
        }
        .input:focus+.label,
        .input:active+.label,
        .input.filled+.label {
            font-size: .75rem;
            transition: all 0.2s ease-out;
            top: -0.3rem;
            color: #6b7280;
        }
        .label {
            transition: all 0.2s ease-out;
            top: 0.4rem;
            left: 0;
        }
    </style>
</head>
<body>
    <body class="font-mono bg-gray-400">
		<!-- Container -->

			<div class="flex justify-center px-6 my-12">
				<!-- Row -->
				<div class="w-full xl:w-3/4 lg:w-11/12 flex">
					<!-- Col -->
					<div
						class="w-full h-auto bg-gray-400 hidden lg:block lg:w-5/12 bg-cover rounded-l-lg"
						style="background-image: url('https://images.unsplash.com/photo-1593642532781-03e79bf5bec2?ixlib=rb-1.2.1&ixid=MnwxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=776&q=80')"
					></div>
					<!-- Col -->
					<div class="w-full lg:w-7/12 bg-white p-5 rounded-lg lg:rounded-l-none">
						<h3 class="pt-4 text-2xl text-center">Create an Account!</h3>
						<form class="px-8 pt-6 pb-8 mb-4 bg-white rounded" action="{{ url("/register") }}" method="post">
							@csrf
							<div class="mb-4 md:flex md:justify-between">
								{{-- <div class="mb-4 md:mr-2 md:mb-0"> --}}
                                <div class="w-full">
									<label class="block mb-2 text-sm font-bold text-gray-700" for="firstName">
										Name
									</label>
									<input
										class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
										id="firstName"
                                        name="name"
										type="text"
										placeholder="Full Name"
										value="{{ old('name') }}"
									/>
								</div>
							</div>
							<div class="mb-4">
								<label class="block mb-2 text-sm font-bold text-gray-700" for="email">
									Email
								</label>
								<input
									class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
									id="email"
                                    name="email"
									type="email"
									placeholder="Email"
									value="{{ old('email') }}"
								/>
							</div>
							<div class="mb-4 md:flex md:justify-between">
								<div class="mb-4 md:mr-2 md:mb-0">
									<label class="block mb-2 text-sm font-bold text-gray-700" for="password">
										Password
									</label>
                                    {{-- border-red-500 (class for make password wrong) --}}
									<input
										class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border  rounded shadow appearance-none focus:outline-none focus:shadow-outline"
										id="password"
                                        name="password"
										type="password"
										placeholder="******************"
									/>
									{{-- <p class="text-xs italic text-red-500">Please choose a password.</p> --}}
								</div>
								<div class="md:ml-2">
									<label class="block mb-2 text-sm font-bold text-gray-700" for="c_password">
										Confirm Password
									</label>
									<input
										class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
										id="c_password"
                                        name="password_confirmation"
										type="password"
										placeholder="******************"
									/>
								</div>
							</div>
							<div class="mb-6 text-center">
								<button
									class="w-full px-4 py-2 font-bold text-black bg-yellow-400 rounded-full hover:bg-yellow-300 focus:outline-none focus:shadow-outline"
									type="submit"
								>
									Register Account
								</button>
							</div>
							<hr class="mb-6 border-t" />
							{{-- <div class="text-center">
								<a
									class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800"
									href="#"
								>
									Forgot Password?
								</a>
							</div> --}}
							<div class="text-center">
								<a
									class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800"
									href="{{ url("login") }}"
								>
									Already have an account? Login!
								</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	const sessionStatus  = "{{ Session::has('status') }}"
	const sessionMessage = "{{ Session::get('status') }}"
	const sessionClass   = "{{ Session::get('alert-class') }}"
	console.log("session class " + sessionClass)
	if(sessionStatus) {
		Swal.fire(
			sessionClass == "error" ? "Opps!" : "Success!" ,
			sessionMessage,
			sessionClass
		)
	}
</script>
</body>
</html>
