<?php

use Livewire\Component;
use Livewire\Attributes\Locked;

new class extends Component {

    #[Locked] public string $serviceClass;
    #[Locked] public string $serviceFunction;

    public string $title;
    public string $timeframe;
    public string $currency;
    public string $value;    
    public bool $withDropdown;

    public array $timeframes = [
        'today'     => 'Hari Ini',
        'thisWeek'  => 'Minggu Ini',
        'thisMonth' => 'Bulan Ini',
        'thisYear'  => 'Tahun Ini',
    ];

    public function mount(
        string $title,
        string $serviceClass,
        string $serviceFunction,
        string $currency        = '',
        bool $withDropdown      = false,
        string $defaultTimeframe = 'today',
    ): void {
        $this->label            = $title;
        $this->serviceClass     = $serviceClass;
        $this->serviceFunction  = $serviceFunction;
        $this->currency         = $currency;
        $this->withDropdown     = $withDropdown;
        $this->timeframe        = $defaultTimeframe;
        $this->fetchData();
    }

    public function setTimeframe(string $timeframe): void
    {
        $this->timeframe = $timeframe;
        $this->fetchData();
    }

    private function fetchData(): void
    {
        $service = app($this->serviceClass);
        $rawData = $service->{$this->serviceFunction}($this->timeframe);
        $this->value = $this->currency ? number_format($rawData, 0, ',', '.') : $rawData;
    }
};

?>

<div class="relative flex flex-col bg-white p-4 rounded-lg gap-1 border border-[#E0D2BB]">
    
    <div wire:loading wire:target class="absolute right-0 left-0 top-0 bottom-0 flex items-center justify-center rounded-md w-full h-full bg-[#E0D2BB]/20 z-20 cursor-wait"></div>

    <div class="w-1/5 max-w-15 h-1 bg-[#C5A880] mb-1 rounded-full"></div>
    <h3 class="font-manrope text-xs text-[#532E1C] tracking-wide">{{ $title }}</h3>
    <strong class="font-noto-serif text-lg text-[#2C180F]">
        @if($currency) {{ $currency }} @endif
        <span>{{ $value }}</span>
    </strong>

    @if($withDropdown)
        <div class="w-full flex justify-end">
            <button data-dropdown-toggle="dropdown-{{ $this->getId() }}" type="button"
                class="font-manrope text-xs text-[#2C180F] font-bold bg-[#F5F2F0] border border-[#2C180F] rounded-sm p-1 cursor-pointer">
                <span>{{ $timeframes[$timeframe] }}</span>
                <i class="ms-1 bi bi-caret-down-fill"></i>
            </button>
        </div>

        <div wire:loading.class="hidden" id="dropdown-{{ $this->getId() }}" class="z-10 hidden bg-[#F5F2F0] border border-[#2C180F] rounded-sm p-1">
            <ul class="font-manrope text-xs text-[#2C180F] flex flex-col gap-0.5">
                @foreach($timeframes as $val => $label)
                    <li>
                        <button type="button" wire:click="setTimeframe('{{ $val }}')"
                            @disabled($timeframe === $val)
                            class="inline-flex items-center w-full p-1 rounded-xs
                                {{ $timeframe === $val
                                    ? 'bg-[#532E1C] text-white'
                                    : 'text-[#2C180F] hover:bg-[rgb(210,194,188)] cursor-pointer' }}">
                            {{ $label }}
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>