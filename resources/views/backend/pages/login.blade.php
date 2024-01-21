<!DOCTYPE html>
<html lang="en" class="border-l">
<head>
    <meta charset="UTF-8">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>Login</title>
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
<header>
    <a aria-label="Linkedin" class="z-10 mt-9 absolute md:ml-12 ml-9" href="/">
        {{-- <img src="https://importir.com/images/com-01.png" onclick="window.location.open(window.location.origin)" class="w-36" alt=""> --}}
    </a>
</header>
<div class="h-screen bg-white relative flex flex-col space-y-10 justify-center items-center">
        @if(Session::has('status'))
            <div id="alert-2" class="flex p-4 mb-4 bg-red-100 rounded-lg dark:bg-red-200" role="alert" onclick="this.classList.add('invisible')">
                <svg class="flex-shrink-0 w-5 h-5 text-red-700 dark:text-red-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <div class="ml-3 text-sm font-medium text-red-700 dark:text-red-800">
                {{ Session::get('status') }}
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8 dark:bg-red-200 dark:text-red-600 dark:hover:bg-red-300" data-collapse-toggle="alert-2" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
        @endif

    <div class="bg-white md:shadow-lg shadow-none rounded p-6 w-96" >
        <h1 class="text-3xl font-bold leading-normal" >Sign in Admin</h1>
        <form class="space-y-10 mt-5" method="POST" action="{{ url("backend/login") }}">
            @csrf

            <div class="mb-4 relative">
                <span class="block text-sm font-medium text-slate-700 mb-3 leading-tighter text-gray-500 text-base">Email</span>
                <input id="email" class="w-full rounded px-3 border border-gray-500 pt-5 pb-2 focus:outline-none input active:outline-none @error('email') border-red-500 @enderror" type="text" name="email" value="{{ old('email') }}" autofocus>
            </div>
            <div class="mb-4 relative">
                <span class="block text-sm font-medium text-slate-700 mb-3 leading-tighter text-gray-500 text-base">Password</span>
                <div class="relative flex items-center border border-gray-500 focus:ring focus:border-blue-500 rounded">
                    <input id="password" class="w-full rounded px-3 pt-5 outline-none pb-2 focus:outline-none active:outline-none input active:border-blue-500 @error('email') border-red-500 @enderror" name="password" type="password"/>
                    <a id="labelShow" class="text-sm font-bold text-blue-700 hover:bg-gray-200 rounded-full px-2 py-1 mr-1 leading-normal cursor-pointer" onclick="changeType()">show</a>
                </div>
            </div>
            <div class="-m-2">
                {{-- <a class="font-bold text-blue-700 hover:bg-gray-200 hover:underline hover:p-5 p-4 rounded-full" href="#" onclick="alert('Opps Incoming Feature!')">Forgot password?</a> --}}
            </div>
            <button class="w-full text-center bg-blue-400 hover:bg-blue-900 rounded-full text-white py-3 font-medium" type="submit">Sign in</button>
        </form>
    </div>
    <p>Member Area<a class="text-blue-700 font-bold hover:bg-gray-200 hover:underline hover:p-5 p-2 rounded-full" href="{{ url("") }}">Home</a></p>
</div>
<script>
    function changeType() {
        const pass = document.querySelector("#password")
        if(pass.type == "password") {
            pass.type = "text"
            document.querySelector("#pwdText").style.display = "none"
            document.querySelector("#labelShow").textContent = "hide"
        } else {
            pass.type = "password"
            document.querySelector("#pwdText").style.display = ""
            document.querySelector("#labelShow").textContent = "show"
        }
    }
</script>
</body>
</html>
