<header class="z-10 h-16 py-4 bg-white bg-gray-200 dark:bg-gray-800">
    <div class="container flex items-center justify-between h-full px-6 mx-auto text-purple-600 dark:text-purple-300">
        <!-- Mobile hamburger -->
        <button class="p-1 mr-5 flex items-center rounded-md md:hidden focus:outline-none" @click="toggleSideMenu" aria-label="Menu">
            <ion-icon name="menu" class="w-6 h-6 text-orange-500"></ion-icon>
        </button>
        <!-- Search input -->
        <div class="flex flex-1 lg:mr-32">
            <div class="relative w-full max-w-xl mr-6 focus-within:text-purple-500">
                <div class="absolute inset-y-0 flex items-center pl-2">
                    <ion-icon name="search" class="w-4 h-4 text-orange-600"></ion-icon>
                </div>
                <input class="w-full pl-8 pr-2 py-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input" type="text" placeholder="Search for projects" aria-label="Search" />
            </div>
        </div>
        <ul class="flex items-center flex-shrink-0 space-x-6">
            <!-- Notifications menu -->
            <li class="relative" x-data="{ open:false}">
                <button class="relative align-middle rounded-md focus:outline-none focus:shadow-outline-purple" @click="open = true" aria-label="Notifications" aria-haspopup="true">
                    <ion-icon name="notifications" class="w-5 h-5 text-gray-500"></ion-icon>
                    <!-- Notification badge -->
                    <span aria-hidden="true" class="absolute top-0 right-0 inline-block w-2 h-2 transform translate-x-1 -translate-y-1 bg-red-600 rounded-full dark:border-gray-800"></span>
                </button>
                <ul x-show="open" @click.away="open = false" x-on:keydown.escape="open = false" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:text-gray-300 dark:border-gray-700 dark:bg-gray-700">
                    <li class="flex">
                        <a class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="#">
                            <span>Messages</span>
                            <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600">
                                13
                            </span>
                        </a>
                    </li>
                    <li class="flex">
                        <a class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="#">
                            <span>Sales</span>
                            <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600">
                                2
                            </span>
                        </a>
                    </li>
                    <li class="flex">
                        <a class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="#">
                            <span>Alerts</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- Profile menu -->
            <li class="relative" x-data="{ open:false }">
                <button class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none" @click="open = true" @keydown.escape="open = flase" aria-label="Account" aria-haspopup="true">
                    <img class="object-cover w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1502378735452-bc7d86632805?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=aa3a807e1bbdfd4364d1f449eaa96d82" alt="" aria-hidden="true" />
                </button>
                <ul @click.away="open = false" @keydown.escape="open = false" x-show="open" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700" aria-label="submenu">
                    <li class="flex">
                        <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="#">
                            <ion-icon name="person" class="w-4 h-4 mr-3"></ion-icon>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li class="flex">
                        <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="#">
                            <ion-icon name="cog" class="w-4 h-4 mr-3"></ion-icon>
                            <span>Settings</span>
                        </a>
                    </li>
                    <li class="flex text-red-500">
                        <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-red-600" href="#">
                            <ion-icon name="log-out" class="w-4 h-4 mr-3"></ion-icon>
                            <span>Log out</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</header>