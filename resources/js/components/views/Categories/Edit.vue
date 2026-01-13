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
                        <h1 class="text-3xl font-bold text-gray-900">Edit Category</h1>
                        <p class="mt-2 text-gray-600">Update category information</p>
                        <div v-if="category" class="flex items-center mt-2 space-x-4">
                            <span class="px-3 py-1 text-sm font-medium text-gray-800 bg-gray-100 rounded-full">
                                ID: {{ category.id }}
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="px-3 py-1 text-sm font-medium text-purple-700 bg-purple-100 rounded-full">
                            Editing Mode
                        </span>
                    </div>
                </div>
            </div>

            <!-- Loading State -->
            <div v-if="loading && !category" class="flex justify-center items-center py-20">
                <div class="text-center">
                    <svg class="mx-auto w-12 h-12 text-blue-600 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="mt-4 text-gray-600">Loading category data...</p>
                </div>
            </div>

            <!-- Error State -->
            <div v-else-if="loadError" class="p-8 bg-red-50 rounded-xl border border-red-200">
                <div class="text-center">
                    <svg class="mx-auto w-12 h-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-red-800">Unable to load category</h3>
                    <p class="mt-2 text-red-600">{{ loadError }}</p>
                    <button
                        @click="goBack"
                        class="px-4 py-2 mt-6 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 hover:bg-gray-50"
                    >
                        Go Back
                    </button>
                </div>
            </div>

            <!-- Main Form Container -->
            <div v-else-if="category" class="overflow-hidden bg-white rounded-xl border border-gray-200 shadow-lg">
                <!-- Form Header -->
                <div class="px-8 py-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800">Edit Category Details</h2>
                            <p class="mt-1 text-gray-500">Update the information for this category</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form @submit.prevent="handleSubmit" class="p-8">
                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                        <!-- Left Column -->
                        <div class="space-y-8 lg:col-span-2">
                            <!-- Category Information Section -->
                            <div class="p-6 bg-blue-50 rounded-xl border border-blue-100">
                                <div class="flex items-center mb-4">
                                    <div class="flex justify-center items-center mr-4 w-10 h-10 bg-blue-100 rounded-lg">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Category Information</h3>
                                        <p class="text-sm text-gray-600">Update basic details about your category</p>
                                    </div>
                                </div>

                                <!-- ID Field (Disabled for editing) -->
                                <div class="mb-6">
                                    <label class="block mb-2 text-sm font-medium text-gray-700">
                                        Category ID
                                        <span class="ml-1 text-sm font-normal text-gray-500">(cannot be changed)</span>
                                    </label>
                                    <div class="relative">
                                        <input
                                            type="text"
                                            :value="category.id"
                                            disabled
                                            class="px-4 py-3 w-full text-gray-500 bg-gray-50 rounded-lg border border-gray-300 cursor-not-allowed"
                                        />
                                        <div class="flex absolute inset-y-0 right-0 items-center pr-3 pointer-events-none">
                                            <span class="text-lg font-medium text-gray-400">#</span>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">Category ID cannot be modified after creation</p>
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
                                            placeholder="Enter category name"
                                            :disabled="submitting"
                                            :class="{ 'border-red-400': error }"
                                        />
                                        <div class="flex absolute inset-y-0 right-0 items-center pr-3 pointer-events-none">
                                            <span class="text-gray-400">{{ formData.name.length }}/100</span>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">Current: <span class="font-medium">{{ originalName }}</span></p>

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
=
                        </div>

                        <!-- Actions Section (Full Width) -->
                        <div class="space-y-8 lg:col-span-3">
                            <div class="p-6 bg-gray-50 rounded-xl border border-gray-200">

                                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                    <div class="space-y-2">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <svg class="mr-2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>All fields marked with <span class="text-red-500">*</span> are required</span>
                                        </div>
                                        <div v-if="hasChanges" class="flex items-center text-sm text-blue-600">
                                            <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>You have unsaved changes</span>
                                        </div>
                                    </div>

                                    <div class="flex flex-col gap-3 sm:flex-row">
                                        <button
                                            type="button"
                                            @click="goBack"
                                            class="px-6 py-3 font-medium text-gray-700 bg-white rounded-lg border border-gray-300 transition-colors hover:bg-gray-50 disabled:opacity-50"
                                            :disabled="submitting"
                                        >
                                            Cancel
                                        </button>
                                        <button
                                            type="submit"
                                            :disabled="submitting || !formData.name.trim() || !hasChanges"
                                            class="flex justify-center items-center px-6 py-3 font-medium text-white bg-gradient-to-r from-purple-600 to-purple-700 rounded-lg shadow-md transition-all duration-200 hover:from-purple-700 hover:to-purple-800 hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                        >
                                            <svg
                                                v-if="submitting"
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
                                            {{ submitting ? 'Saving Changes...' : 'Save Changes' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Success Toast -->
        <Transition name="slide-up">
            <div v-if="success" class="fixed right-4 bottom-4 px-6 py-4 max-w-md text-white bg-green-500 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <svg class="mr-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <div>
                        <p class="font-medium">Category updated successfully!</p>
                        <p class="mt-1 text-sm opacity-90">Redirecting to categories list...</p>
                    </div>
                </div>
            </div>
        </Transition>
    </div>
</template>

<script setup lang="ts">
import { ref, reactive, computed, onMounted, watch } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { getCategoryById, updateCategory } from '@/services/categoryService';
import type { Category } from '@/types/Category';

const router = useRouter();
const route = useRoute();

// Get category ID from route parameter
const categoryId = computed(() => parseInt(route.params.id as string));

// States
const loading = ref(true);
const submitting = ref(false);
const loadError = ref('');
const error = ref('');
const success = ref(false);
const category = ref<Category | null>(null);
const originalName = ref('');

// Form data
const formData = reactive({
    id: null as number | null,
    name: '',
});

// Refs
const nameInput = ref<HTMLInputElement | null>(null);

// Computed
const hasChanges = computed(() => {
    if (!category.value) return false;
    return (
        formData.name !== category.value.name ||
        formData.id !== category.value.id
    );
});

const fetchCategory = async () => {
    try {
        loading.value = true;
        loadError.value = '';

        const data = await getCategoryById(categoryId.value);
        category.value = data;
        originalName.value = data.name;

        formData.id = data.id;
        formData.name = data.name;

    } catch (err: any) {
        console.error('Error fetching category:', err);
        loadError.value = err.response?.data?.message || err.message || 'Failed to load category data';
    } finally {
        loading.value = false;
    }
};

watch(category, (newVal) => {
    if (newVal) {
        setTimeout(() => {
            nameInput.value?.focus();
        }, 100);
    }
});

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
        submitting.value = true;
        error.value = '';

        // Prepare update data
        const updateData: Partial<Category> = {
            name: formData.name.trim(),
        };

        // Call the API service
        await updateCategory(categoryId.value, updateData);

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
        submitting.value = false;
    }
};

// Navigate back
const goBack = () => {
    if (hasChanges.value) {
        if (confirm('You have unsaved changes. Are you sure you want to leave?')) {
            router.push('/categories');
        }
    } else {
        router.push('/categories');
    }
};

// Prevent accidental navigation when there are changes
window.addEventListener('beforeunload', (e) => {
    if (hasChanges.value) {
        e.preventDefault();
        e.returnValue = '';
    }
});

// Lifecycle
onMounted(() => {
    fetchCategory();
});
</script>

<style scoped>
/* Animation for success toast */
.slide-up-enter-active,
.slide-up-leave-active {
    transition: all 0.3s ease;
}

.slide-up-enter-from {
    opacity: 0;
    transform: translateY(20px);
}

.slide-up-leave-to {
    opacity: 0;
    transform: translateY(20px);
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 10px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 5px;
}

::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 5px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a1a1a1;
}
</style>
