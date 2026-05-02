@extends('master')

@section('title', 'Stall Login')

@section('body')
    <div class="h-screen grid xl:grid-cols-[640px_1fr] grid-cols-1">
            
        <div class="flex flex-col items-center justify-center gap-16 bg-[#F0E7D8] xl:border-r-2 border-[#532E1C]">
            <div>
                <h1 class="font-noto-serif font-bold text-2xl text-center text-[#532E1C]">LOGIN</h1>
                <p class="font-manrope text-base text-center text-[#532E1C]">Masuk untuk akses sistem kios / stall</p>
            </div>

            <div class="w-full">
                <form method="POST" action="{{ route('stall.login.post') }}" class="flex flex-col items-center gap-16">
                    @csrf

                    <div class="w-full flex flex-col items-center gap-5">
                        <div class="w-full max-w-75 flex flex-col gap-3 items-start">
                            <label for="phone-number" class="font-manrope font-bold text-sm text-center text-[#532E1C]">Nomor Telepon</label>
                            <input id="phone-number" name="phone_number" type="tel" autocomplete="tel" value="{{ old('phone_number') }}" required 
                                class="w-full bg-[#F0E7D8] border-2 border-[#532E1C] rounded-sm outline-none py-0 px-1 text-[#532E1C] focus:bg-[#E0D2BB]">
                        </div>
        
                        <div class="w-full max-w-75 flex flex-col gap-3 items-start">
                            <label for="password" class="font-manrope font-bold text-sm text-center text-[#532E1C]">Password</label>
                            <div class="w-full relative">
                                <input id="password" name="password" type="password" autocomplete="current-password" required 
                                    class="w-full bg-[#F0E7D8]  border-2 border-[#532E1C] rounded-sm outline-none py-0 px-1 pe-9 text-[#532E1C] focus:bg-[#E0D2BB]">
                                <button type="button" id="toggle-password" class="hidden absolute right-0 h-full bg-[#532E1C] px-2 rounded-e-sm">
                                    <i id="eye-icon" class="bi bi-eye text-[#F0E7D8]"></i>
                                </button>
                            </div>
                        </div>  
                    </div>

                    <button type="submit" class="font-noto-serif text-sm text-[#E6E6E6] w-full bg-[#442313] max-w-50 py-1.5 rounded-sm">Login</button>
                </form>
            </div>
        </div>

        <div class="hidden xl:flex flex-col items-center justify-center bg-white">
            <img src="{{ asset('images/logo/de-pallet.svg') }}" alt="De Pallet">
        </div>
    </div>
@endsection