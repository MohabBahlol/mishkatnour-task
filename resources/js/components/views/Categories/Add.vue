<template>
    <div class="p-4 min-h-screen bg-gray-50 md:p-8">
        <!-- Header -->
        <div class="mx-auto max-w-6xl">
            <!-- Back Button and Title -->
            <div class="mb-8">
                <button
                    @click="goBack"
                    class="inline-flex items-center mb-4 text-gray-600 hover:text-gray-900 group"
                >
                    <svg class="mr-2 w-5 h-5 transition-transform transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Categories
                </button>
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Create New Category</h1>
                        <p class="mt-2 text-gray-600">Add a new category to organize your products or services</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="px-3 py-1 text-sm font-medium text-blue-700 bg-blue-100 rounded-full">
                            New Category
                        </span>
                    </div>
                </div>
            </div>

            <!-- Main Form Container -->
            <div class="overflow-hidden bg-white rounded-xl border border-gray-200 shadow-lg">
                <!-- Form Header -->
                <div class="px-8 py-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Category Details</h2>
                    <p class="mt-1 text-gray-500">Fill in the details below to create a new category</p>
                </div>

                <!-- Form Content -->
                <form @submit.prevent="handleSubmit" class="p-8">
                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                        <!-- Left Column -->
                        <div class="space-y-8 lg:col-span-3">
                            <!-- Category Name Section -->
                            <div class="p-6 bg-blue-50 rounded-xl border border-blue-100">
                                <div class="flex items-center mb-4">
                                    <div class="flex justify-center items-center mr-4 w-10 h-10 bg-blue-100 rounded-lg">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Category Information</h3>
                                        <p class="text-sm text-gray-600">Basic details about your category</p>
                                    </div>
                                </div>

                                <!-- Category Name Field -->
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">
                                        Category Name
                                        <span class="ml-1 text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input
                                            ref="nameInput"
                                            type="text"
                                            v-model.trim="formData.name"
                                            required
                                            class="px-4 py-3.5 w-full text-lg rounded-lg border border-gray-300 transition-all duration-200 focus:ring-3 focus:ring-blue-500 focus:border-blue-500 focus:outline-none"
                                            placeholder="Enter category name (e.g., Electronics, Clothing, Furniture)"
                                            :disabled="loading"
                                            :class="{ 'border-red-400': error }"
                                        />
                                        <div class="flex absolute inset-y-0 right-0 items-center pr-3 pointer-events-none">
                                            <span class="text-gray-400">{{ formData.name.length }}/100</span>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">Choose a clear and descriptive name for your category</p>

                                    <!-- Error Message -->
                                    <div v-if="error" class="p-4 mt-4 bg-red-50 rounded-lg border border-red-200">
                                        <div class="flex items-center">
                                            <svg class="flex-shrink-0 mr-3 w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-red-800">{{ error }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="space-y-8 lg:col-span-3">
                            <div class="p-6 bg-gray-50 rounded-xl border border-gray-200">
                                <h3 class="mb-4 text-lg font-semibold text-gray-900">Actions</h3>

                                <div class="space-y-4">
                                    <button
                                        type="submit"
                                        :disabled="loading || !formData.name.trim()"
                                        class="flex justify-center items-center px-6 py-3.5 w-full font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-md transition-all duration-200 hover:from-blue-700 hover:to-blue-800 hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                    >
                                        <svg
                                            v-if="loading"
                                            class="mr-3 -ml-1 w-5 h-5 text-white animate-spin"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                        >
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <svg
                                            v-else
                                            class="mr-3 w-5 h-5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ loading ? 'Creating Category...' : 'Create Category' }}
                                    </button>

                                    <button
                                        type="button"
                                        @click="goBack"
                                        class="px-6 py-3.5 w-full font-medium text-gray-700 bg-white rounded-lg border border-gray-300 transition-colors hover:bg-gray-50"
                                        :disabled="loading"
                                    >
                                        Cancel
                                    </button>

                                    <div class="pt-4 border-t border-gray-200">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <svg class="mr-2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>All fields marked with <span class="text-red-500">*</span> are required</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Success Toast -->
            <Transition name="slide-up">
                <div v-if="success" class="fixed right-4 bottom-4 px-6 py-4 max-w-md text-white bg-green-500 rounded-lg shadow-lg">
                    <div class="flex items-center">
                        <svg class="mr-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <div>
                            <p class="font-medium">Category created successfully!</p>
                            <p class="mt-1 text-sm opacity-90">Redirecting to categories list...</p>
                        </div>
                    </div>
                </div>
            </Transition>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { createCategory } from '@/services/categoryService';
import type { Category } from '@/types/Category';

const router = useRouter();

// Form data
const formData = reactive({
    id: null as number | null,
    name: '',
});

// UI state
const loading = ref(false);
const error = ref('');
const success = ref(false);

// Refs
const nameInput = ref<HTMLInputElement | null>(null);

// Focus on name input when page loads
onMounted(() => {
    nameInput.value?.focus();
});

// Navigate back
const goBack = () => {
    router.push('/categories');
};

// Handle form submission
const handleSubmit = async () => {
    if (!formData.name.trim()) {
        error.value = 'Please enter a category name';
        nameInput.value?.focus();
        return;
    }

    if (formData.name.length > 100) {
        error.value = 'Category name must be less than 100 characters';
        nameInput.value?.focus();
        return;
    }

    try {
        loading.value = true;
        error.value = '';

        const dataToSend: Category = {
            id: null,
            name: formData.name.trim(),
        };

        if (formData.id) {
            dataToSend.id = formData.id;
        }

        // Call the API service
        await createCategory(dataToSend);

        // Show success message
        success.value = true;

        // Redirect after 2 seconds
        setTimeout(() => {
            router.push('/categories');
        }, 2000);

    } catch (err: any) {
        console.error('Error creating category:', err);

        // Handle Laravel validation errors
        if (err.response?.status === 422 && err.response?.data?.errors) {
            const laravelErrors = err.response.data.errors;

            // If there are general errors (not field-specific)
            if (err.response.data.message) {
                error.value = laravelErrors.name.join('<br/> ');
            }

            // Focus on first field with error
            const firstErrorField = Object.keys(laravelErrors)[0];
            if (firstErrorField === 'name' && nameInput.value) {
                nameInput.value.focus();
            }
        } else {
            // Handle non-validation errors
            error.value = err.response?.data?.message || err.message || 'Failed to create category. Please try again.';
        }
    } finally {
        loading.value = false;
    }
};
</script>
