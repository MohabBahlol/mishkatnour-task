<template>
    <div id="app" class="flex flex-col min-h-screen">
        <Header @open-modal="open = true" />
        <main class="flex-grow">
            <div class="container px-4 py-12 mx-auto sm:px-6 lg:px-8">
                <div class="mx-auto text-center">
                    <RouterView />
                </div>
            </div>
        </main>
        <Footer />
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { RouterView } from 'vue-router'
import Header from './components/layout/Header.vue'
import Footer from './components/layout/Footer.vue'

const open = ref(false)
</script>
