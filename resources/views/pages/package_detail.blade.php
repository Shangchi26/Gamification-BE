@extends('layout')
@section('content')
<section class="bg-gray-100 min-h-screen w-full pl-6 sm:pl-[88px] pr-6 overflow-hidden font-inter">
        <div class="flex w-full items-center gap-1 py-2 font-inter">
            <a href="#" class="text-pink-600">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
            </a>
            <a href="/admin/package-manage" class="text-pink-600">/ Package manage</a>
            <p class="text-gray-400">/ Package detail</p>
        </div>
        <h1 class="font-bold text-2xl leading-7 my-6">Package detail</h1>

        <div class="w-full bg-white rounded-lg shadow my-4 p-6">
            <h3 class="text-base leading-6 uppercase text-gray-400">Package infomation</h3>
            <div class="w-full max-w-md py-2">
                <h3 class="text-sm leading-5 font-medium">Package point: {{ $package->point }}</h3>
            </div>
            <div class="w-full max-w-md py-2">
                <h3 class="text-sm leading-5 font-medium">Package price: {{ $package->price }} VNĐ</h3>
            </div>
        </div>
    </section>
@endsection
