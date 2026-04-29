@extends('master')

@section('title', 'Stall Login')

@section('content')
<div class="h-screen grid xl:grid-cols-[640px_1fr] grid-cols-1">
        
    <section class="flex flex-col items-center justify-center gap-16 bg-[#E6D7C2]">
        <div>
            <h1 class="font-noto-serif font-bold text-2xl text-center text-[#532E1C]">LOGIN</h1>
            <h2 class="font-manrope text-base text-center text-[#532E1C]">Masuk untuk akses sistem kios / stall</h2>
        </div>

        <div class="w-full">
            <form method="POST" action="{{ route('stall.login.post') }}" class="flex flex-col items-center gap-16">
                @csrf

                <div class="w-full flex flex-col items-center gap-5">
                    <div class="w-full max-w-75 flex flex-col gap-3 items-start">
                        <label for="phone" class="font-manrope font-bold text-sm text-center text-[#532E1C]">Nomor Telepon</label>
                        <input id="phone-number" name="phone_number" type="tel" autocomplete="tel" value="{{ old('phone_number') }}" required 
                            class="w-full border-2 border-[#532E1C] rounded-sm outline-none px-1 focus:bg-[#532E1C]/10">
                    </div>
    
                    <div class="w-full max-w-75 flex flex-col gap-3 items-start">
                        <label for="password" class="font-manrope font-bold text-sm text-center text-[#532E1C]">Password</label>
                        <div class="w-full relative">
                            <input id="password" name="password" type="password" autocomplete="password" required 
                                class="w-full border-2 border-[#532E1C] rounded-sm outline-none px-1 pe-9 focus:bg-[#532E1C]/10">
                            <button type="button" id="toggle-password" class="absolute right-0 h-full bg-[#532E1C] px-2 rounded-e-sm">
                                <i id="eye-icon" class="bi bi-eye text-[#E6D7C2]"></i>
                            </button>
                        </div>
                    </div>  
                </div>

                <button type="submit" class="font-noto-serif text-sm text-[#F3F4F6] w-full bg-[#532E1C] max-w-50 py-1.5 rounded-sm">Login</button>
            </form>
        </div>
    </section>

    <section class="hidden xl:flex flex-col items-center justify-center bg-[#F3F4F6]">
        <img src="{{ asset('images/logo/de-pallet logo.svg') }}" alt="De Pallet">
    </section>
</div>
@endsection