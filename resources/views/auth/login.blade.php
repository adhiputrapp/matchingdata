@extends('layouts.app')

@section('content')

<section class="gradient-form h-full">
    <div class="container h-full p-10">
      <div
        class="g-6 flex h-full flex-wrap items-center justify-center text-neutral-800 dark:text-neutral-200">
        <div class="w-full">
          <div
            class="block rounded-lg bg-gray-200 shadow-lg dark:bg-neutral-800">
            <div class="g-0 lg:flex lg:flex-wrap">
              <!-- Left column container-->
              <div class="px-4 mt-32 md:px-0 lg:w-6/12">
                <div class="md:mx-6 md:p-12">
                  <!--Logo-->
                  <div class="text-center">
                    <img
                      class="mx-auto w-48"
                      src="img/banteng.png"
                      alt="logo" />
                    <h4 class="mb-12 mt-1 pb-1 text-xl font-semibold">
                      {{-- Matching Data --}}
                    </h4>
                  </div>
  
                  <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <p class="mb-4">Masukan Akun Anda</p>
                    <!--Username input-->
                    <div class="relative mb-4" data-te-input-wrapper-init>
                    
                        <p class="mb-4 text-sm">E-Mail</p>
                        <input id="exampleFormControlInput1"
                        placeholder="Email"
                         type="email" 
                         class="form-control @error('email') is-invalid @enderror peer block min-h-[auto] w-full rounded border-1 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0" 
                         name="email" value="{{ old('email') }}" required autocomplete="email" autofocus/>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    
                    </div>
  
                    <!--Password input-->
                    <div class="relative mb-4" data-te-input-wrapper-init>
                     
                        <p class="mb-4 text-sm">Password</p>
                        <input
                        placeholder="Password" 
                        id="exampleFormControlInput11" 
                        type="password" 
                        class="form-control @error('password') is-invalid @enderror peer block min-h-[auto] w-full rounded border-1 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0" 
                        name="password" required autocomplete="current-password"/>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                 
                    </div>
  
                    <!--Submit button-->
                    <div class="mb-12 pb-1 pt-1 text-center">
                      <button
                        class="mb-3 inline-block w-full rounded px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_rgba(0,0,0,0.2)] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)] focus:outline-none focus:ring-0 active:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)]"
                        type="submit"
                        data-te-ripple-init
                        data-te-ripple-color="light"
                        style="
                          background: linear-gradient(to bottom right, #000000, #d8363a, #ffffff);
                        ">
                        Log in
                      </button>
  
                      <!--Forgot password link-->
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Lupa Password?') }}
                            </a>
                        @endif
                    </div>
  
                    <!--Register button-->
                    
                  </form>
                </div>
              </div>
  
              <!-- Right column container with background and description-->
              <div
                class="flex items-center rounded-b-lg lg:w-6/12 lg:rounded-r-lg lg:rounded-bl-none"
                style="background: linear-gradient(to bottom right, #000000, #d8363a, #ffffff)">
                <img
                class="mx-auto w-full"
                src="img/ganjar.jpg"
                />
                <div class="px-4 py-6 text-white md:mx-6 md:p-12">
                    {{-- <h4 class="mb-6 text-xl font-semibold">
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                  </h4>
                  <p class="text-sm">
                    Lorem ipsum dolor sit amet, consectetur adipisicing
                    elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis
                    nostrud exercitation ullamco laboris nisi ut aliquip ex
                    ea commodo consequat.
                  </p> --}}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection
