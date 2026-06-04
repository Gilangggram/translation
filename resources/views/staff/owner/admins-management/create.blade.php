@section('title', 'Tambah Akun Admin')

<div class="w-full min-h-screen bg-[#F0E7D8] p-4">

    <div class="flex flex-col gap-2">
        
        <a href="{{ route('owner.admins-management.index') }}"
            class="w-fit py-1 ps-1 pe-2 text-sm bg-[#F5F2F0] border border-[#2C180F] rounded-lg text-[#532E1C] cursor-pointer">
                <i class="bi bi-chevron-left text-xs me-1"></i>Kembali
        </a>

        <form wire:submit="save" class="flex flex-col gap-2">

            <div class="flex flex-col bg-white rounded-lg w-full p-4 border border-[#E0D2BB] gap-4">
            
                <div>
                    <h3 class="font-manrope text-sm font-medium text-[#532E1C]">Akun Admin</h3>
                    <p class="font-manrope text-xs text-[#80543F]">Data Akun untuk admin</p>
                </div>
    
                <div class="flex flex-col gap-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col items-start gap-1">
                            <label for="phone-number" class="font-manrope text-xs font-semibold tracking-wide text-center text-[#532E1C]">Nomor Telepon <span class="text-red-500">*</span></label>
                            <input type="text"
                                id="phone-number"
                                wire:model="adminForm.admin_number" 
                                placeholder="Nomor Telepon"
                                class="w-full py-2 bg-[#F5F2F0] text-xs font-manrope text-[#2C180F] border border-[#2C180F] rounded-md outline-none
                                placeholder:text-[#C5A880] focus:ring-1 focus:ring-[#532E1C] transition">
                            @error('adminForm.admin_number') <span class="text-xs text-[#AD1614]"><i class="bi bi-exclamation-circle text-xs me-1"></i>{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="flex flex-col items-start gap-1">
                            <label for="name" class="font-manrope text-xs font-semibold tracking-wide text-center text-[#532E1C]">Nama <span class="text-red-500">*</span></label>
                            <input type="text"
                                id="name"
                                wire:model="adminForm.admin_name"
                                placeholder="Nama"
                                class="w-full py-2 bg-[#F5F2F0] text-xs font-manrope text-[#2C180F] border border-[#2C180F] rounded-md outline-none
                                placeholder:text-[#C5A880] focus:ring-1 focus:ring-[#532E1C] transition"/>
                            @error('adminForm.admin_name') <span class="text-xs text-[#AD1614]"><i class="bi bi-exclamation-circle text-xs me-1"></i>{{ $message }}</span> @enderror
                        </div>
                                        
                    </div>

                    <div class="flex flex-col items-start gap-2">
                        <label class="font-manrope text-xs font-semibold tracking-wide text-center text-[#532E1C]">Role <span class="text-red-500">*</span></label>
                        
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" wire:model="adminForm.admin_role" value="owner" 
                                       class="w-4 h-4 cursor-pointer text-[#532E1C] bg-[#F5F2F0] border-[#2C180F] focus:ring-[#532E1C] accent-[#532E1C]">
                                <span class="text-xs font-manrope text-[#2C180F]">Owner</span>
                            </label>
                            
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" wire:model="adminForm.admin_role" value="cashier" 
                                       class="w-4 h-4 cursor-pointer text-[#532E1C] bg-[#F5F2F0] border-[#2C180F] focus:ring-[#532E1C] accent-[#532E1C]">
                                <span class="text-xs font-manrope text-[#2C180F]">Kasir</span>
                            </label>
                        </div>
                        
                        @error('adminForm.role') <span class="text-xs text-[#AD1614]"><i class="bi bi-exclamation-circle text-xs me-1"></i>{{ $message }}</span> @enderror
                    </div>
    
                    <div class="flex flex-col gap-1">

                        <div class="flex flex-col gap-1">

                            <div class="flex items-end gap-2">
                                <div class="w-full flex flex-col items-start gap-1">
                                    <label for="password" class="font-manrope text-xs font-semibold tracking-wide text-center text-[#532E1C]">Password <span class="text-red-500">*</span></label>
                                    <input type="text"
                                        id="password"
                                        wire:model="adminForm.password"
                                        placeholder="Password (min. 6 karakter)"
                                        class="w-full py-2 bg-[#F5F2F0] text-xs font-manrope text-[#2C180F] border border-[#2C180F] rounded-md outline-none
                                        placeholder:text-[#C5A880] focus:ring-1 focus:ring-[#532E1C] transition"/>
                                    
                                </div>
            
                                <div class="shrink-0">
                                    <button type="button" id="btn-generate-password" class="w-fit py-2 px-2 text-xs font-semibold  bg-[#F5F2F0] border border-[#2C180F] rounded-md text-[#532E1C] cursor-pointer m-0">
                                        Generate Password
                                    </button>
                                </div>
    
            
                            </div>

                            @error('adminForm.password') <span class="text-xs text-[#AD1614]"><i class="bi bi-exclamation-circle text-xs me-1"></i>{{ $message }}</span> @enderror


                        </div>
           
                        <p class="font-manrope text-xs text-[#80543F]">Password akan diberikan ke admin baru untuk login pertama kali.</p>
    
                    </div>
                    
                </div>
            
            </div>

            <button type="submit" class="w-full font-manrope text-sm font-semibold text-white bg-[#442313] py-2 rounded-lg cursor-pointer">
                <span wire:loading.remove wire:target="save">Buat Akun</span>
                <span wire:loading wire:target="save">Menyimpan...</span>
            </button>

        </form>
        
    </div>

</div>