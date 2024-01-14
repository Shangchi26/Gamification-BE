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
            <a href="/admin/quest-manage" class="text-pink-600">/ Quest manage</a>
            <p class="text-gray-400">/ Update quest</p>
        </div>
        <h1 class="font-bold text-2xl leading-7 my-6">Update quest</h1>
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 mb-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="w-full bg-white rounded-lg shadow my-4 p-6">
            <h3 class="text-base leading-6 uppercase text-gray-400">Quest infomation</h3>
            <form action="{{ route('quest.update', $quest->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="pt-4 pb-2 w-full max-w-md">
                    <label for="name" class="inline-block text-sm leading-5 font-medium text-gray-900 mb-1">Quest
                        name</label><span class="text-red-500">*</span>
                    <input type="text" id="name" name="name" value="{{ $quest->name }}"
                        class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none text-gray-900">
                </div>
                <div class="w-full max-w-md py-2">
                    <label class="inline-block text-sm leading-5 font-medium text-gray-900 mb-1" for="type">Quest
                        type</label><span class="text-red-500">*</span>
                    <div class="w-full flex justify-around text-gray-900">
                        <div>
                            <input type="radio" id="daily" name="type" value="daily" {{ $quest->type === 'daily' ? 'checked' : ''}}>
                            <label for="daily">Daily</label>
                        </div>
                        <div>
                            <input type="radio" id="one_time" name="type" value="one_time" {{ $quest->type === 'one_time' ? 'checked' : ''}}>
                            <label for="one_time">One time</label>
                        </div>
                    </div>
                </div>
                <div class="pt-4 pb-2 w-full max-w-md">
                    <label for="completion" class="inline-block text-sm leading-5 font-medium text-gray-900 mb-1">Max quest
                        completion</label><span class="text-red-500">*</span>
                    <input type="number" id="completion" name="max_completion" value={{ $quest->max_completion }}
                        class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none text-gray-900">
                </div>
                <div class="pt-4 pb-2 w-full max-w-md">
                    <label for="point" class="inline-block text-sm leading-5 font-medium text-gray-900 mb-1">Quest
                        point</label><span class="text-red-500">*</span>
                    <input type="number" id="point" name="point" value={{ $quest->point }}
                        class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none text-gray-900">
                </div>
                <button type="submit"
                    class="py-2 px-4 mt-2 rounded-lg bg-pink-400 hover:bg-pink-500 text-white duration-300">Send</button>
            </form>
        </div>
    </section>

    <script>
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('fileInput');
        const fileList = document.getElementById('fileList');

        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('border-blue-500', 'border-2');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('border-blue-500', 'border-2');
        });

        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('border-blue-500', 'border-2');

            const files = e.dataTransfer.files;
            handleFiles(files);
        });

        fileInput.addEventListener('change', (e) => {
            const files = e.target.files;
            handleFiles(files);
        });

        function handleFiles(files) {
            fileList.innerHTML = '';

            for (const file of files) {
                const listItem = document.createElement('div');
                listItem.textContent = `${file.name} (${formatBytes(file.size)})`;
                fileList.appendChild(listItem);
            }
        }

        function formatBytes(bytes) {
            if (bytes === 0) return '0 Bytes';

            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));

            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    </script>
@endsection
