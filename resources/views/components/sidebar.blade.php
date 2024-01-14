<!-- component -->
<div x-data="setup()" x-init="$refs.loading.classList.add('hidden');" @resize.window="watchScreen()" class="fixed z-10">
    <div class="flex h-screen antialiased text-gray-900 bg-gray-100 dark:bg-dark dark:text-light font-inter">
        <!-- Loading screen -->
        <div x-ref="loading"
            class="fixed inset-0 z-50 flex items-center justify-center text-2xl font-semibold text-white bg-black opacity-30">
            Loading.....
        </div>

        <!-- Sidebar -->
        <div class="flex flex-shrink-0 transition-all">
            <div x-show="isSidebarOpen" @click="isSidebarOpen = false" class="fixed inset-0 z-10 bg-black bg-opacity-50">
            </div>
            <div x-show="isSidebarOpen" class="fixed inset-y-0 z-10 w-16 bg-white"></div>

            <!-- Mobile bottom bar -->
            <nav aria-label="Options"
                class="fixed inset-x-0 bottom-0 flex flex-row-reverse items-center justify-between px-4 py-2 bg-white border-t border-indigo-100 sm:hidden shadow-t rounded-t-3xl">
                <!-- Menu button -->
                <button
                    @click="(isSidebarOpen && currentSidebarTab == 'linksTab') ? isSidebarOpen = false : isSidebarOpen = true; currentSidebarTab = 'linksTab'"
                    class="p-2 transition-colors rounded-lg shadow-md hover:bg-indigo-800 hover:text-white focus:outline-none focus:ring focus:ring-indigo-600 focus:ring-offset-white focus:ring-offset-2"
                    :class="(isSidebarOpen && currentSidebarTab == 'linksTab') ? 'text-white bg-indigo-600' :
                    'text-gray-500 bg-white'">
                    <span class="sr-only">Toggle sidebar</span>
                    <svg aria-hidden="true" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>

                <!-- Logo -->
                <a href="/admin/dashboard" class=" font-bold text-xl leading-7 text-gray-900 no-underline">
                    Booker
                </a>
            </nav>

            <!-- Left mini bar -->
            <nav aria-label="Options"
                class="z-20 flex-col items-center flex-shrink-0 hidden w-16 py-4 bg-gray-800 shadow-md sm:flex">
                <!-- Logo -->
                <div class="flex-shrink-0 py-4">
                    <a href="#" class=" text-white">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </a>
                </div>
                <div class="flex flex-col items-center flex-1 p-2 space-y-4">
                    <!-- Menu button -->
                    <button
                        @click="(isSidebarOpen && currentSidebarTab == 'linksTab') ? isSidebarOpen = false : isSidebarOpen = true; currentSidebarTab = 'linksTab'"
                        class="p-2 transition-colors rounded-lg shadow-md hover:bg-gray-600 text-white">
                        <span class="sr-only">Toggle sidebar</span>
                        <svg aria-hidden="true" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                    </button>
                </div>

                <!-- logout -->
                <div class="relative flex items-center flex-shrink-0 p-2">
                    <a href="/admin/logout" class="flex items-center space-x-2 text-white">
                        <svg aria-hidden="true" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </a>
                </div>
            </nav>

            <div x-transition:enter="transform transition-transform duration-300"
                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition-transform duration-300"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                x-show="isSidebarOpen"
                class="fixed inset-y-0 left-0 z-10 flex-shrink-0 w-64 bg-white shadow-lg sm:left-16 rounded-tr-3xl rounded-br-3xl sm:w-72 lg:static lg:w-64">
                <nav x-show="currentSidebarTab == 'linksTab'" aria-label="Main" class="flex flex-col h-full">
                    <!-- Logo -->
                    <div class="flex items-center px-6 flex-shrink-0 py-10">
                        <a href="#" class="no-underline">
                            <h2 class="font-bold leading-7 text-xl text-gray-900">Booker</h2>
                        </a>
                    </div>

                    <!-- Links -->
                    <ul class="flex-1 px-6 space-y-2 overflow-hidden hover:overflow-auto w-full">
                        <li class="w-full hover:bg-pink-50 duration-150 py-2 hover:px-2 group"><a
                                href="/admin/dashboard"
                                class="block w-full text-sm leading-5 font-normal no-underline text-gray-500 group-hover:text-[#FF6281] rounded-md">Dashboard</a>
                        </li>
                        <li class="w-full hover:bg-pink-50 duration-150 py-2 hover:px-2 group"><a
                                href="/admin/chest-manage"
                                class="block w-full text-sm leading-5 font-normal no-underline text-gray-500 group-hover:text-[#FF6281] rounded-md">Chests manage</a>
                        </li>
                        <li class="w-full hover:bg-pink-50 duration-150 py-2 hover:px-2 group"><a
                                href="/admin/item-manage"
                                class="block w-full text-sm leading-5 font-normal no-underline text-gray-500 group-hover:text-[#FF6281] rounded-md">Items manage</a>
                        </li>
                        <li class="w-full hover:bg-pink-50 duration-150 py-2 hover:px-2 group"><a
                                href="/admin/package-manage"
                                class="block w-full text-sm leading-5 font-normal no-underline text-gray-500 group-hover:text-[#FF6281] rounded-md">Packages manage</a>
                        </li>
                        <li class="w-full hover:bg-pink-50 duration-150 py-2 hover:px-2 group"><a
                                href="/admin/quest-manage"
                                class="block w-full text-sm leading-5 font-normal no-underline text-gray-500 group-hover:text-[#FF6281] rounded-md">Quests manage</a>
                        </li>
                        <li class="w-full hover:bg-pink-50 duration-150 py-2 hover:px-2 group"><a
                                href="/admin/user-manage"
                                class="block w-full text-sm leading-5 font-normal no-underline text-gray-500 group-hover:text-[#FF6281] rounded-md">Users manage</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.min.js" defer></script>
<script>
    const setup = () => {
        return {
            isSidebarOpen: false,
            currentSidebarTab: null,
            isSettingsPanelOpen: false,
            isSubHeaderOpen: false,
            watchScreen() {
                if (window.innerWidth <= 1024) {
                    this.isSidebarOpen = false
                }
            },
        }
    }
</script>
