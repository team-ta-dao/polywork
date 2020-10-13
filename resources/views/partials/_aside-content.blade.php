<div class="text-gray-500 dark:text-gray-400">
    <!-- logo -->
    <div class="w-full h-16 flex items-center justify-center bg-gray-200">
        <div class="w-full h-full flex items-center justify-center py-2">
            <img src="https://upload.wikimedia.org/wikipedia/vi/thumb/8/80/FPT_New_Logo.png/1200px-FPT_New_Logo.png" alt="FPT logo" class="max-w-full max-h-full">
        </div>
    </div>

    <ul>
        <!-- Active -->
        <li class="relative">
            @if(request()->is('dashboard'))
            <!-- insert span -->
            <span class="absolute inset-y-0 left-0 w-1 bg-orange-500 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
            @endif

            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 {{ request()->is('dashboard') ? 'text-gray-800 bg-orange-50' : 'hover:text-gray-800' }} px-6 py-3" href="/dashboard">
                <ion-icon name="speedometer" class="w-5 h-5"></ion-icon>

                <span class="ml-4">Dashboard</span>
            </a>
        </li>

        <!-- <li class="relative">
                        <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 px-6 py-3"
                            href="index.html">
                            <ion-icon name="speedometer" class="w-5 h-5"></ion-icon>

                            <span class="ml-4">Dashboard</span>
                        </a>
                    </li> -->

        <li class="relative" x-data="{open:false}">
            <div class="w-full h-full relative">
                @if(request()->is('post/*'))
                <span class="absolute inset-y-0 left-0 w-1 bg-orange-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <button class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 focus:outline-none px-6 py-3 {{ request()->is('post/*') ? 'text-gray-800 bg-orange-50' : 'hover:text-gray-800 dark:hover:text-gray-200' }}" @click="open = true">
                    <span class="inline-flex items-center">
                        <ion-icon name="newspaper" class="w-5 h-5"></ion-icon>
                        <span class="ml-4">All Post</span>
                    </span>
                    <!-- down icon -->
                    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <ul x-show="{{ request()->is('post/*') ? 'open = true' : 'open' }}" @click.away="open = false" x-transition:enter="transition-all ease-in-out duration-300" x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl" x-transition:leave="transition-all ease-in-out duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 tranform scale-90" class=" mt-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md bg-gray-50 dark:text-gray-400 dark:bg-gray-900 mx-6 mb-4">
                <li class="px-4 py-2 transition-colors duration-150 {{ request()->is('post/add-new-post') ? 'text-orange-500 bg-gray-100' : 'hover:text-gray-800' }}">
                    <a class="w-full" href="/post/add-new-post">Add new post</a>
                </li>
                <li class="px-4 py-2 transition-colors duration-150 {{ request()->is('post/all-post') ? 'text-orange-500 bg-gray-100' : 'hover:text-gray-800' }}">
                    <a class="w-full" href="/post/all-post">All post</a>
                </li>
            </ul>
        </li>
        <li class="relative" x-data="{open:false}">
            <div class="w-full h-full relative">
                @if(request()->is('student/*'))
                <span class="absolute inset-y-0 left-0 w-1 bg-orange-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <button class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 focus:outline-none px-6 py-3 {{ request()->is('student/*') ? 'text-gray-800 bg-orange-50' : 'hover:text-gray-800 dark:hover:text-gray-200' }}" @click="open = true">
                    <span class="inline-flex items-center">
                        <ion-icon name="person" class="w-5 h-5"></ion-icon>
                        <span class="ml-4">Students</span>
                    </span>
                    <!-- down icon -->
                    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <ul x-show="{{ request()->is('student/*') ? 'open = true' : 'open' }}" @click.away="open = false" x-transition:enter="transition-all ease-in-out duration-300" x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl" x-transition:leave="transition-all ease-in-out duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 tranform scale-90" class=" mt-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md bg-gray-50 dark:text-gray-400 dark:bg-gray-900 mx-6 mb-4">
                <li class="px-4 py-2 transition-colors duration-150 {{ request()->is('student/add-new-student') ? 'text-orange-500 bg-gray-100' : 'hover:text-gray-800' }}">
                    <a class="w-full" href="/student/add-new-student">Add new Student</a>
                </li>
                <li class="px-4 py-2 transition-colors duration-150 {{ request()->is('student/all-student') ? 'text-orange-500 bg-gray-100' : 'hover:text-gray-800' }}">
                    <a class="w-full" href="/student/all-student">All Students</a>
                </li>
            </ul>
        </li>
        <li class="relative" x-data="{open:false}">
            <div class="w-full h-full relative">
                @if(request()->is('extensions/*'))
                <span class="absolute inset-y-0 left-0 w-1 bg-orange-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <button class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 focus:outline-none px-6 py-3 {{ request()->is('extensions/*') ? 'text-gray-800 bg-orange-50' : 'hover:text-gray-800 dark:hover:text-gray-200' }}" @click="open = true">
                    <span class="inline-flex items-center">
                        <ion-icon name="apps" class="w-5 h-5"></ion-icon>
                        <span class="ml-4">Extensions</span>
                    </span>
                    <!-- down icon -->
                    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            <ul x-show="{{ request()->is('extensions/*') ? 'open = true' : 'open' }}" @click.away="open = false" x-transition:enter="transition-all ease-in-out duration-300" x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl" x-transition:leave="transition-all ease-in-out duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 tranform scale-90" class=" mt-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md bg-gray-50 dark:text-gray-400 dark:bg-gray-900 mx-6 mb-4">
                <li class="px-4 py-2 transition-colors duration-150 {{ request()->is('extensions/categories') ? 'text-orange-500 bg-gray-100' : 'hover:text-gray-800' }}">
                    <a class="w-full" href="/extensions/categories">Categories</a>
                </li>
                <li class="px-4 py-2 transition-colors duration-150 {{ request()->is('student/all-student') ? 'text-orange-500 bg-gray-100' : 'hover:text-gray-800' }}">
                    <a class="w-full" href="/student/all-student">Tags</a>
                </li>
            </ul>
        </li>
    </ul>
    <div class="px-6 my-6">
        <button class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-orange-500 border border-transparent rounded-lg active:bg-orange-600 hover:bg-orange-600 focus:outline-none focus:shadow-outline-purple">
            Create account
            <span class="ml-2" aria-hidden="true">+</span>
        </button>
    </div>
</div>