<template>
    <footer class="mt-auto bg-gray-50 border-t">
        <div class="container px-4 mx-auto sm:px-6 lg:px-8">
            <!-- Main Footer Content -->
            <div class="py-8 md:py-12">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <!-- Logo and Description -->
                    <div class="md:col-span-2">
                        <div class="flex items-center mb-4 space-x-3">
                            <div class="flex justify-center items-center w-12 h-10 bg-blue-600 rounded-lg">
                                <span class="text-xl font-bold text-white">MN</span>
                            </div>
                            <span class="text-2xl font-bold text-gray-900">Mishkat Nour</span>
                        </div>
                        <p class="max-w-md text-gray-600">
                            A modern web application built with Laravel, Vue.js, and Tailwind CSS.
                            Fast, responsive, and developer-friendly.
                        </p>
                    </div>


                    <!-- Contact Info -->
                    <div>
                        <h3 class="mb-4 text-sm font-semibold tracking-wider text-gray-900 uppercase">
                            Contact
                        </h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-start">
                                <EnvelopeIcon class="flex-shrink-0 mr-2 w-5 h-5 text-gray-400" />
                                <span><a target="_blank" href="mailto:info@mishkatnour.org">info@mishkatnour.org</a></span>
                            </li>
                            <li class="flex items-start">
                                <PhoneIcon class="flex-shrink-0 mr-2 w-5 h-5 text-gray-400" />
                                <span><a target="_blank" href="tel:15623">15623</a></span>
                            </li>
                            <li class="flex items-start">
                                <MapPinIcon class="flex-shrink-0 mr-2 w-5 h-5 text-gray-400" />
                                <span><a target="_blank" href="https://google.com/maps?q=3%20Hassan%20El-Sherif%20Street,%20beside%20Auto%20Dubai,%20Nasr%20City,%20Cairo">3 Hassan El-Sherif Street, beside Auto Dubai, Nasr City, Cairo</a></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Copyright Section -->
            <div class="py-6 border-t border-gray-200">
                <div class="flex flex-col justify-center items-center space-y-4 md:flex-row md:space-y-0">
                    <!-- Copyright Text -->
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            &copy; {{ currentYear }} Mishkat Nour. All rights reserved.
                        </p>
                        <p class="mt-1 text-xs text-gray-500">
                            Built with ❤️ using Laravel, Vue.js, and Tailwind CSS
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { computed } from 'vue'
import {
    EnvelopeIcon,
    PhoneIcon,
    MapPinIcon
} from '@heroicons/vue/24/outline'


const currentYear = computed(() => new Date().getFullYear())
</script>
