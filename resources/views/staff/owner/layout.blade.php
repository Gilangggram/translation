@extends('master')

@section('body')
    <div class="flex min-h-screen">

        <aside id="sidebar" class="fixed top-0 left-0 z-40 h-screen w-56 transition-transform -translate-x-full lg:translate-x-0 lg:sticky lg:shrink-0">
            @include('components.staff.owner.sidebar')
        </aside> 
        
        <div class="flex flex-col flex-1">
            <header class="sticky top-0 z-30">
                @include('components.staff.owner.topbar') 
            </header>

            <main class="flex-1 relative">
                {{ $slot }}
            </main>
        </div>
    </div>
@endsection