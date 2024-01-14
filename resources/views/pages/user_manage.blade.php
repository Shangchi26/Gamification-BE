@extends('layout')
@section('content')
    <section class="bg-gray-200 min-h-screen w-full pl-6 sm:pl-[88px] pr-6 overflow-hidden font-inter">
        <div class="h-4 flex items-center gap-1 my-2">
            <a href="/admin/dashboard" class="text-pink-400">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
            </a>
            <p class="text-gray-400 mt-3">/ User manage</p>
        </div>
        <h1 class="font-bold text-2xl leading-7 my-6">User manage</h1>
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-500 text-white p-4 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif
        <div class="w-full bg-white rounded-lg shadow my-4 p-6">
            <h2 class="text-xl leading-7 font-bold">User list</h2>
            <table class="w-full border-gray-300">
                <thead>
                    <tr class="bg-gray-200 text-xs leading-4 font-medium tracking-wider uppercase text-gray-500">
                        <th class="p-2 border-b text-start max-sm:hidden">Id</th>
                        <th class="p-2 border-b text-start">Name</th>
                        <th class="p-2 border-b text-start">Phone</th>
                        <th class="p-2 border-b text-start">Point</th>
                        <th class="p-2 border-b text-start max-sm:hidden">Is admin</th>
                        <th class="p-2 border-b text-start max-sm:hidden">Is banned</th>
                        <th class="p-2 border-b text-start"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr
                            class="hover:bg-gray-100 even:bg-gray-200 duration-150 text-sm leading-5 font-normal text-gray-500">
                            <td class="p-2 border-b max-sm:hidden">{{ $user->id }}</td>
                            <td class="p-2 border-b">{{ $user->name }}</td>
                            <td class="p-2 border-b">{{ $user->phone }}</td>
                            <td class="p-2 border-b">{{ $user->point }}</td>
                            <td class="p-2 border-b max-sm:hidden">
                                @if ($user->is_admin)
                                    <p class="inline-block my-auto px-[10px] py-[2px] bg-blue-100 text-blue-800 rounded-xl">
                                        Is admin</p>
                                @else
                                    <p class="inline-block my-auto px-[10px] py-[2px] bg-green-100 text-green-800 rounded-xl">
                                        Not admin</p>
                                @endif
                            </td>
                            <td class="p-2 border-b max-sm:hidden">
                                @if ($user->is_banned)
                                    <p class="inline-block my-auto px-[10px] py-[2px] bg-red-100 text-red-800 rounded-xl">
                                        Banned</p>
                                @else
                                    <p class="inline-block my-auto px-[10px] py-[2px] bg-blue-100 text-blue-800 rounded-xl">
                                        Unbanned</p>
                                @endif
                            </td>
                            <td class="p-2 border-b" x-data="{ isFormVisible: false }">
                                <i class="fa-solid fa-ellipsis-vertical cursor-pointer"
                                    @click="isFormVisible = !isFormVisible"></i>
                                @if ($user->is_banned)
                                    <form x-show="isFormVisible"
                                        class="absolute -translate-x-[100%] bg-white px-2 py-1 rounded border"
                                        action="{{ route('user.unban', $user->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <button>Unban user</button>
                                    </form>
                                @else
                                    <form x-show="isFormVisible"
                                        class="absolute -translate-x-[100%] bg-white px-2 py-1 rounded border"
                                        action="{{ route('user.ban', $user->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <button>Ban user</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    {{ $users->onEachSide(2)->appends(Request::query())->links('pagination::bootstrap-4') }}
                </ul>
            </nav>
        </div>
        <div class="w-full bg-white rounded-lg shadow my-4 p-6">
            <h2 class="text-xl leading-7 font-bold">User progess</h2>
            <table class="w-full border-gray-300">
                <thead>
                    <tr class="bg-gray-200 text-xs leading-4 font-medium tracking-wider uppercase text-gray-500">
                        <th class="p-2 border-b text-start">Id</th>
                        <th class="p-2 border-b text-start">Sender</th>
                        <th class="p-2 border-b text-start">Receiver</th>
                        <th class="p-2 border-b text-start">Invite at</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invitations as $item)
                        <tr
                            class="hover:bg-gray-100 even:bg-gray-200 duration-150 text-sm leading-5 font-normal text-gray-500">
                            <td class="p-2 border-b">{{ $item->id }}</td>
                            <td class="p-2 border-b">{{ $item->sender->name }}</td>
                            <td class="p-2 border-b">{{ $item->receiver->name }}</td>
                            <td class="p-2 border-b">{{ $item->formatted_created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    {{ $invitations->onEachSide(2)->appends(Request::query())->links('pagination::bootstrap-4') }}
                </ul>
            </nav>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add this in your HTML file -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Add this script at the end of your view or in your layout file -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all elements with the class 'deleteButton'
            var deleteButtons = document.querySelectorAll('.deleteButton');

            // Attach click event to each delete button
            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    // Get the user name from the data-packagename attribute
                    var packageName = button.getAttribute('data-packagename');

                    // Display SweetAlert2 confirmation popup
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Do you want to delete ' + packageName + ' user?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        // If user clicks 'Yes', submit the form
                        if (result.isConfirmed) {
                            var formId = button.parentElement.id;
                            document.getElementById(formId).submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
