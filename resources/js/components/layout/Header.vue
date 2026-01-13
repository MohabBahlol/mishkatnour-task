<template>
    <header class="sticky top-0 z-50 w-full border-b bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/60">
        <div class="container px-4 mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="javascript:void(0);" class="flex items-center space-x-2">
                        <div class="flex justify-center items-center w-10 h-8 bg-blue-600 rounded-lg">
                            <span class="text-lg font-bold text-white">MN</span>
                        </div>
                        <span class="hidden text-xl font-bold text-gray-900 sm:inline-block">
                            Mishkat Nour
                        </span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden items-center space-x-1 md:flex">
                    <RouterLink to="/"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200"
                        active-class="text-blue-700 bg-blue-50">
                        <HomeIcon class="mr-2 w-4 h-4" />
                        Home
                    </RouterLink>

                    <RouterLink to="/categories"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200"
                        active-class="text-blue-700 bg-blue-50">
                        <BriefcaseIcon class="mr-2 w-4 h-4" />
                        Categories
                    </RouterLink>

                    <RouterLink to="/products"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200"
                        active-class="text-blue-700 bg-blue-50">
                        <PhoneIcon class="mr-2 w-4 h-4" />
                        Products
                    </RouterLink>

                    <RouterLink to="/shop"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200"
                        active-class="text-blue-700 bg-blue-50">
                        <BriefcaseIcon class="mr-2 w-4 h-4" />
                        Shop
                    </RouterLink>

                </nav>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="inline-flex justify-center items-center p-2 text-gray-700 rounded-md hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                        <span class="sr-only">Open main menu</span>
                        <Bars3Icon v-if="!mobileMenuOpen" class="w-6 h-6" />
                        <XMarkIcon v-else class="w-6 h-6" />
                    </button>
                </div>
            </div>

            <!-- Mobile menu -->
            <Transition enter-active-class="transition duration-200 ease-out"
                enter-from-class="opacity-0 transform -translate-y-2"
                enter-to-class="opacity-100 transform translate-y-0"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100 transform translate-y-0"
                leave-to-class="opacity-0 transform -translate-y-2">
                <div v-if="mobileMenuOpen" class="md:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <RouterLink to="/"
                            @click="mobileMenuOpen = false"
                            class="flex items-center px-3 py-2 text-base font-medium text-gray-700 rounded-md transition-colors duration-200 hover:bg-gray-50 hover:text-gray-900"
                            active-class="text-blue-700 bg-blue-50">
                            <HomeIcon class="mr-3 w-5 h-5" />
                            Home
                        </RouterLink>

                        <RouterLink to="/categories"
                            @click="mobileMenuOpen = false"
                            class="flex items-center px-3 py-2 text-base font-medium text-gray-700 rounded-md transition-colors duration-200 hover:bg-gray-50 hover:text-gray-900"
                            active-class="text-blue-700 bg-blue-50">
                            <BriefcaseIcon class="mr-3 w-5 h-5" />
                            Categories
                        </RouterLink>

                        <RouterLink to="/products"
                            @click="mobileMenuOpen = false"
                            class="flex items-center px-3 py-2 text-base font-medium text-gray-700 rounded-md transition-colors duration-200 hover:bg-gray-50 hover:text-gray-900"
                            active-class="text-blue-700 bg-blue-50">
                            <PhoneIcon class="mr-3 w-5 h-5" />
                            Products
                        </RouterLink>

                        <RouterLink to="/shop"
                            @click="mobileMenuOpen = false"
                            class="flex items-center px-3 py-2 text-base font-medium text-gray-700 rounded-md transition-colors duration-200 hover:bg-gray-50 hover:text-gray-900"
                            active-class="text-blue-700 bg-blue-50">
                            <BriefcaseIcon class="mr-3 w-5 h-5" />
                            Shop
                        </RouterLink>

                    </div>
                </div>
            </Transition>
        </div>
    </header>
</template>

<script setup>
import { ref, computed } from 'vue'

import {
    HomeIcon,
    BriefcaseIcon,
    EnvelopeIcon,
    PhoneIcon,
    Bars3Icon,
    XMarkIcon
} from '@heroicons/vue/24/outline'

// Props
const emit = defineEmits(['openModal'])

// State
const mobileMenuOpen = ref(false)

// Get current route from window location (no Vue Router needed)
const currentRoute = computed(() => {
    return window.location.pathname
});
</script>
