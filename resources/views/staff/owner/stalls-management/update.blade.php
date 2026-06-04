@section('title', 'Perbarui Stall')

<div class="w-full min-h-screen bg-[#F0E7D8] p-4">

    <div class="flex flex-col gap-2">
        
        <a href="{{ route('owner.stalls-management.index') }}"
            class="w-fit py-1 ps-1 pe-2 text-sm bg-[#F5F2F0] border border-[#2C180F] rounded-lg text-[#532E1C] cursor-pointer">
                <i class="bi bi-chevron-left text-xs me-1"></i>Kembali
        </a>

        <form wire:submit="update" class="flex flex-col gap-2">

            <div class="flex flex-col bg-white rounded-lg w-full p-4 border border-[#E0D2BB] gap-4">
            
                <div>
                    <h3 class="font-manrope text-sm font-medium text-[#532E1C]">Data Akun Stall</h3>
                    <p class="font-manrope text-xs text-[#80543F]">Data Kredensial untuk Login Stall</p>
                </div>
    
                <div class="flex flex-col gap-4">

                    <div class="flex flex-col items-start gap-1">
                        <label for="phone-number" class="font-manrope text-xs font-semibold tracking-wide text-center text-[#532E1C]">Nomor Telepon <span class="text-red-500">*</span></label>
                        <input type="text"
                            id="phone-number"
                            wire:model="stallForm.owner_number"
                            placeholder="Nomor Telepon"
                            class="w-full py-2 bg-[#F5F2F0] text-xs font-manrope text-[#2C180F] border border-[#2C180F] rounded-md outline-none
                            placeholder:text-[#C5A880] focus:ring-1 focus:ring-[#532E1C] transition">
                        @error('stallForm.phone_number') <span class="text-xs text-[#AD1614]"><i class="bi bi-exclamation-circle text-xs me-1"></i>{{ $message }}</span> @enderror
                    </div>
                    
                </div>
            
            </div>
    
            <div class="flex flex-col bg-white rounded-lg w-full p-4 border border-[#E0D2BB] gap-4">
                
                <div>
                    <h3 class="font-manrope text-sm font-medium text-[#532E1C]">Data Informasi Stall</h3>
                    <p class="font-manrope text-xs text-[#80543F]">Data Detail dan Identitas Stall</p>
                </div>
    
                <div class="flex flex-col gap-4">
    
                    <div class="flex flex-col items-start gap-1">
                        <label for="stall-id" class="font-manrope text-xs font-semibold tracking-wide text-center text-[#532E1C]">ID Stall</label>
                        <input type="text"
                            id="stall-id"
                            wire:model="stallForm.stall_code"
                            class="w-full py-2 bg-[#F1ECE8] text-xs font-manrope text-[#8A6B5A] border border-dashed border-[#C5A880] rounded-md
                                cursor-not-allowed opacity-90"
                            disabled />
                    </div>

                    <div class="flex flex-col items-start gap-1">
                        <label for="stall_name" class="font-manrope text-xs font-semibold tracking-wide text-center text-[#532E1C]">Nama Stall <span class="text-red-500">*</span></label>
                        <input type="text"
                            id="stall-name"
                            wire:model="stallForm.stall_name"
                            placeholder="Nama Stall"
                            class="w-full py-2 bg-[#F5F2F0] text-xs font-manrope text-[#2C180F] border border-[#2C180F] rounded-md outline-none
                            placeholder:text-[#C5A880] focus:ring-1 focus:ring-[#532E1C] transition">
                        
                        @error('stallForm.stall_name') <span class="text-xs text-[#AD1614]"><i class="bi bi-exclamation-circle text-xs me-1"></i>{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col items-start gap-1">
                        <label for="owner-name" class="font-manrope text-xs font-semibold tracking-wide text-center text-[#532E1C]">Nama Owner <span class="text-red-500">*</span></label>
                        <input type="text"
                            id="owner-name"
                            wire:model="stallForm.owner_name"
                            placeholder="Nama Owner Stall"
                            class="w-full py-2 bg-[#F5F2F0] text-xs font-manrope text-[#2C180F] border border-[#2C180F] rounded-md outline-none
                                placeholder:text-[#C5A880] focus:ring-1 focus:ring-[#532E1C] transition"/>

                        @error('stallForm.owner_name') <span class="text-xs text-[#AD1614]"><i class="bi bi-exclamation-circle text-xs me-1"></i>{{ $message }}</span> @enderror
                    </div>             
                    
                </div>
                
            </div>

            <button type="submit" class="w-full font-manrope text-sm font-semibold text-white bg-[#442313] py-2 rounded-lg cursor-pointer">
                <span wire:loading.remove wire:target="update">Perbarui Stall</span>
                <span wire:loading wire:target="update">Menyimpan...</span>
            </button>

        </form>
        
    </div>

</div>