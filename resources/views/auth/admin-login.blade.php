@extends('master')

@section('title', 'Admin Login')

@section('body')
    <div class="h-screen flex flex-col justify-center items-center bg-[#F9F3EA]">
        <div class="grid grid-cols-1 xl:grid-cols-[1fr_1fr] w-full sm:max-w-120 xl:max-w-240 h-full sm:h-150 overflow-hidden rounded-lg">
        
            <div class="hidden xl:flex flex-col items-center justify-center relative">
                <img src="{{ asset('images/background/photo.png') }}" alt="De Pallet" class="w-full h-150 object-cover">
                <div class="absolute inset-0 bg-linear-to-t from-black/70 via-black/10 to-transparent"></div>

                <div class="absolute bottom-10 left-10">
                    <h1 class="font-abril-fatface text-4xl text-white">De'Pallet Cafe</h1>
                    <p class="font-manrope text-base text-[#F9F3EA]">
                        Login Sistem <strong class="font-semibold">Admin</strong>
                    </p>
                </div>
            </div>

            <div class="flex flex-col items-center justify-center gap-10 bg-white">
                <div class="flex flex-col w-full max-w-75 gap-1">
                    <h2 class="font-noto-serif font-bold text-xl text-start text-[#532E1C]">LOGIN</h2>
                    <p class="font-manrope text-sm text-start ">
                        @if ($errors->has('login'))
                            <span class="text-[#AD1614]"><i class="bi bi-exclamation-triangle-fill pe-2"></i>{{ $errors->first('login') }}</span>
                        @else
                            <span class="text-[#532E1C]">Silahkan isi data diri untuk akses sistem</span>
                        @endif
                    </p>            
                </div>
    
                <div class="w-full">
                    <form method="POST" action="{{ route('admin.login.post') }}" class="flex flex-col items-center gap-10">
                        @csrf
        
                        <div class="w-full flex flex-col items-center gap-5">
    
                            <div class="w-full max-w-75 flex flex-col gap-2 items-start">
                                <label for="phone-number" class="font-manrope text-xs font-semibold tracking-wide text-center text-[#532E1C]">NOMOR TELEPON</label>
                                <div class="w-full relative  rounded-sm overflow-hidden">
                                    <input id="phone-number" name="phone_number" type="tel" autocomplete="tel" value="{{ old('phone_number') }}" required 
                                        class="w-full bg-[#F5F2F0] border-none rounded-sm outline-none py-1.5 px-1 text-[#532E1C] text-sm focus:bg-[#E2E2E2]">
                                    
                                    @if ($errors->has('phone_number'))
                                        <div class="absolute bottom-0 h-0.5 w-full bg-[#AD1614]"></div>
                                    @else
                                        <div class="absolute bottom-0 h-0.5 w-full bg-[#532E1C]"></div>
                                    @endif
                                </div>

                                @error('phone_number')
                                    <p class="text-sm -mt-1 text-[#AD1614]"><i class="bi bi-exclamation-circle text-xs me-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
            
                            <div class="w-full max-w-75 flex flex-col gap-2 items-start">
                                <label for="password" class="font-manrope text-xs font-semibold tracking-wide text-center text-[#532E1C]">PASSWORD</label>
                                <div class="w-full relative rounded-sm overflow-hidden">
                                    <input id="password" name="password" type="password" autocomplete="current-password" required 
                                        class="w-full bg-[#F5F2F0] border-none rounded-sm outline-none py-1.5 px-1 pe-9 text-[#532E1C] text-sm focus:bg-[#E2E2E2]">
                                    <button type="button" id="toggle-password" class="hidden absolute right-0 h-full bg-[#532E1C] px-2 rounded-e-sm z-30">
                                        <i id="eye-icon" class="bi bi-eye text-[#F0E7D8]"></i>
                                    </button>

                                    @if ($errors->has('password'))
                                        <div class="absolute bottom-0 h-0.5 w-full bg-[#AD1614]"></div>
                                    @else
                                        <div class="absolute bottom-0 h-0.5 w-full bg-[#532E1C]"></div>
                                    @endif
                                </div>
                                
                                @error('password')
                                    <p class="text-sm -mt-1 text-[#AD1614]"><i class="bi bi-exclamation-circle text-xs me-1"></i>{{ $message }}</p>
                                @enderror
                            </div>  
                        </div>
        
                        <button type="submit" class="font-noto-serif text-sm text-white w-full bg-[#442313] max-w-75 py-2 rounded-sm">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection