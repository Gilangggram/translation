<?php

use Livewire\Component;
use Livewire\Attributes\Reactive;

new class extends Component
{

    #[Reactive] public string $value;

    public string $title;
    public string $currency;
    
    public function mount(
        string $title,
        string $currency    = '',
    ) {
        $this->title        = $title;
        $this->currency     = $currency;
    }
    
};


?>

<div class="relative flex flex-col bg-white p-4 rounded-lg gap-1 border border-[#E0D2BB]">
    
    <div class="w-1/5 max-w-15 h-1 bg-[#C5A880] mb-1 rounded-full"></div>
    <h3 class="font-manrope text-xs font-medium text-[#532E1C] tracking-wide">{{ $title }}</h3>
    <strong class="font-noto-serif text-lg text-[#2C180F]">
        @if($currency) {{ $currency }} @endif
        <span>{{ $value }}</span>
    </strong>

</div>