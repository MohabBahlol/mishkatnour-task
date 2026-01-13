<template>
    <h1 class="mb-6 text-4xl font-bold text-gray-900 md:text-5xl">
        Welcome to <span class="text-blue-600">Mishkat Nour</span>
    </h1>
    <p class="mx-auto mb-8 max-w-2xl text-lg text-gray-600">
        A modern web application built with Laravel, Vue.js, Tailwind CSS, and Headless UI.
        Fully responsive and component-based.
    </p>

    <!-- Features Grid -->
    <div class="grid gap-8 mt-16 md:grid-cols-3">
        <div class="p-6 bg-white rounded-xl border shadow-sm">
            <div class="flex justify-center items-center mx-auto mb-4 w-12 h-12 bg-blue-100 rounded-lg">
                <span class="text-xl font-bold text-blue-600">⚡</span>
            </div>
            <h3 class="mb-2 text-xl font-semibold">Fast & Responsive</h3>
            <p class="text-gray-600">Built with Vite for lightning-fast builds and hot reload.</p>
        </div>

        <div class="p-6 bg-white rounded-xl border shadow-sm">
            <div class="flex justify-center items-center mx-auto mb-4 w-12 h-12 bg-green-100 rounded-lg">
                <span class="text-xl font-bold text-green-600">🎨</span>
            </div>
            <h3 class="mb-2 text-xl font-semibold">Beautiful UI</h3>
            <p class="text-gray-600">Styled with Tailwind CSS and Headless UI components.</p>
        </div>

        <div class="p-6 bg-white rounded-xl border shadow-sm">
            <div class="flex justify-center items-center mx-auto mb-4 w-12 h-12 bg-purple-100 rounded-lg">
                <span class="text-xl font-bold text-purple-600">🧩</span>
            </div>
            <h3 class="mb-2 text-xl font-semibold">Component-Based</h3>
            <p class="text-gray-600">Modular Vue components for easy maintenance and scaling.</p>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
    name: 'Home',
})
</script>
