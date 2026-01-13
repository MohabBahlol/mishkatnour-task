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
                    Back to Products
                </button>
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Create New Product</h1>
                        <p class="mt-2 text-gray-600">Add a new product with details</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="px-3 py-1 text-sm font-medium text-blue-700 bg-blue-100 rounded-full">
                            New Product
                        </span>
                    </div>
                </div>
            </div>

            <!-- Main Form Container -->
            <div class="overflow-hidden bg-white rounded-xl border border-gray-200 shadow-lg">
                <!-- Form Header -->
                <div class="px-8 py-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Product Details</h2>
                    <p class="mt-1 text-gray-500">Fill in the details below to create a new product</p>
                </div>

                <!-- Form Content -->
                <form @submit.prevent="handleSubmit" class="p-8">
                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Product Name -->
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    Product Name
                                    <span class="ml-1 text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        ref="nameInput"
                                        type="text"
                                        v-model.trim="formData.name"
                                        required
                                        class="px-4 py-3 w-full rounded-lg border border-gray-300 transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none"
                                        placeholder="Enter product name"
                                        :disabled="loading"
                                        :class="{ 'border-red-300': fieldErrors.name }"
                                    />
                                </div>
                                <p v-if="fieldErrors.name" class="mt-1 text-sm text-red-600">
                                    {{ fieldErrors.name }}
                                </p>
                                <p v-else class="mt-1 text-sm text-gray-500">
                                    Enter a descriptive name for the product
                                </p>
                            </div>

                            <!-- Price -->
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    Price
                                    <span class="ml-1 text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        type="number"
                                        v-model.number="formData.price"
                                        required
                                        min="0"
                                        step="0.01"
                                        style="padding-left: 2.0rem"
                                        class="py-3 pr-8 pl-8 w-full rounded-lg border border-gray-300 transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none"
                                        placeholder="0.00"
                                        :disabled="loading"
                                        :class="{ 'border-red-300': fieldErrors.price }"
                                    />
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <span class="text-gray-500">$</span>
                                    </div>
                                </div>
                                <p v-if="fieldErrors.price" class="mt-1 text-sm text-red-600">
                                    {{ fieldErrors.price }}
                                </p>
                                <p v-else class="mt-1 text-sm text-gray-500">
                                    Enter the product price in USD
                                </p>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Category Select -->
                            <div class="relative">
                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    Category
                                    <span class="ml-1 text-red-500">*</span>
                                </label>

                                <!-- Searchable Select -->
                                <div class="relative">
                                    <input
                                        type="text"
                                        v-model="categorySearch"
                                        @focus="showCategoryDropdown = true"
                                        @blur="onCategoryBlur"
                                        @input="filterCategories"
                                        class="px-4 py-3 pr-10 w-full rounded-lg border border-gray-300 transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none"
                                        placeholder="Search or select a category..."
                                        :disabled="loading || categoriesLoading"
                                        :class="{ 'border-red-300': fieldErrors.category_id }"
                                    />
                                    <div class="flex absolute inset-y-0 right-0 items-center pr-3">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Category Dropdown - Fixed z-index and positioning -->
                                <Transition name="slide-fade">
                                    <div
                                        v-if="showCategoryDropdown && filteredCategories.length > 0"
                                        class="overflow-y-auto absolute z-50 mt-1 w-full max-h-60 bg-white rounded-lg border border-gray-300 shadow-xl"
                                        style="box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);"
                                    >
                                        <div class="overflow-y-auto max-h-48">
                                            <div
                                                v-for="category in filteredCategories"
                                                :key="category.value"
                                                @mousedown.prevent="selectCategory(category)"
                                                class="px-4 py-3 border-b border-gray-100 transition-colors cursor-pointer hover:bg-gray-50 last:border-b-0"
                                                :class="{ 'bg-blue-50 text-blue-700': formData.category_id === category.value }"
                                            >
                                                <div class="font-medium">{{ category.label }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </Transition>

                                <!-- No Results Message -->
                                <Transition name="slide-fade">
                                    <div
                                        v-if="showCategoryDropdown && filteredCategories.length === 0"
                                        class="absolute z-50 mt-1 w-full bg-white rounded-lg border border-gray-300 shadow-xl"
                                    >
                                        <div class="px-4 py-6 text-center text-gray-500">
                                            No categories found
                                        </div>
                                    </div>
                                </Transition>

                                <!-- Selected Category Display -->
                                <div v-if="selectedCategory && !showCategoryDropdown" class="mt-2">
                                    <div class="inline-flex items-center px-3 py-1.5 bg-blue-50 rounded-lg border border-blue-100">
                                        <span class="text-sm font-medium text-blue-700">{{ selectedCategory.label }}</span>
                                        <button
                                            type="button"
                                            @click="clearCategory"
                                            class="ml-2 text-blue-500 hover:text-blue-700"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <p v-if="fieldErrors.category_id" class="mt-1 text-sm text-red-600">
                                    {{ fieldErrors.category_id }}
                                </p>
                                <p v-else class="mt-1 text-sm text-gray-500">
                                    Select the product category
                                </p>
                            </div>

                        </div>

                        <!-- Actions Section (Full Width) -->
                        <div class="col-span-1 lg:col-span-2">
                            <div class="pt-6 mt-6 border-t border-gray-200">
                                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                    <div class="space-y-2">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <svg class="mr-2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>All fields marked with <span class="text-red-500">*</span> are required</span>
                                        </div>
                                    </div>

                                    <div class="flex flex-col gap-3 mt-4 sm:flex-row">
                                        <button
                                            type="button"
                                            @click="goBack"
                                            class="px-6 py-3 font-medium text-gray-700 bg-white rounded-lg border border-gray-300 transition-colors hover:bg-gray-50 disabled:opacity-50"
                                            :disabled="loading"
                                        >
                                            Cancel
                                        </button>
                                        <button
                                            type="submit"
                                            :disabled="loading || !formData.name.trim() || !formData.price || !formData.category_id"
                                            class="flex justify-center items-center px-6 py-3 font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-md transition-all duration-200 hover:from-blue-700 hover:to-blue-800 hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
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
                                            {{ loading ? 'Creating Product...' : 'Create Product' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Success Toast -->
            <Transition name="slide-up">
                <div v-if="success" class="fixed right-4 bottom-4 z-50 px-6 py-4 max-w-md text-white bg-green-500 rounded-lg shadow-lg">
                    <div class="flex items-center">
                        <svg class="mr-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <div>
                            <p class="font-medium">Product created successfully!</p>
                            <p class="mt-1 text-sm opacity-90">Redirecting to products list...</p>
                        </div>
                    </div>
                </div>
            </Transition>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, reactive, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { createProduct, getCategoriesForSelect } from '@/services/productService';
import type { Product } from '@/types/Product';

const router = useRouter();

// Form data
const formData = reactive({
    name: '',
    price: null as number | null,
    category_id: null as number | null,
    description: '',
});

// UI state
const loading = ref(false);
const categoriesLoading = ref(false);
const error = ref('');
const success = ref(false);
const showCategoryDropdown = ref(false);

// Categories
const allCategories = ref<Array<{ value: number; label: string }>>([]);
const categorySearch = ref('');
const selectedCategory = ref<{ value: number; label: string } | null>(null);

// Error handling
const fieldErrors = ref({
    name: '',
    price: '',
    category_id: '',
    description: '',
});

// Refs
const nameInput = ref<HTMLInputElement | null>(null);

// Filtered categories based on search
const filteredCategories = computed(() => {
    if (!categorySearch.value.trim()) {
        return allCategories.value;
    }
    const searchTerm = categorySearch.value.toLowerCase();
    return allCategories.value.filter(category =>
        category.label.toLowerCase().includes(searchTerm)
    );
});

// Focus on name input when page loads
onMounted(() => {
    nameInput.value?.focus();
    loadCategories();
});

// Load categories for select
const loadCategories = async () => {
    try {
        categoriesLoading.value = true;
        allCategories.value = await getCategoriesForSelect();
    } catch (err) {
        console.error('Error loading categories:', err);
        error.value = 'Failed to load categories. Please try again.';
    } finally {
        categoriesLoading.value = false;
    }
};

// Select category
const selectCategory = (category: { value: number; label: string }) => {
    formData.category_id = category.value;
    selectedCategory.value = category;
    categorySearch.value = category.label;
    showCategoryDropdown.value = false;
    fieldErrors.value.category_id = '';
};

// Clear selected category
const clearCategory = () => {
    formData.category_id = null;
    selectedCategory.value = null;
    categorySearch.value = '';
    showCategoryDropdown.value = true;
};

// Filter categories on search
const filterCategories = () => {
    showCategoryDropdown.value = true;
};

// Handle category input blur
const onCategoryBlur = () => {
    setTimeout(() => {
        showCategoryDropdown.value = false;
        // If user typed something but didn't select, clear it if it doesn't match
        if (selectedCategory.value && categorySearch.value !== selectedCategory.value.label) {
            const found = allCategories.value.find(c =>
                c.label.toLowerCase() === categorySearch.value.toLowerCase()
            );
            if (!found) {
                clearCategory();
            }
        }
    }, 200);
};

// Navigate back
const goBack = () => {
    router.push('/products');
};

// Handle form submission
const handleSubmit = async () => {
    // Clear previous errors
    error.value = '';
    fieldErrors.value = {
        name: '',
        price: '',
        category_id: '',
    };

    // Basic validation
    let hasError = false;
    let firstErrorField: string | null = null;

    if (!formData.name.trim()) {
        fieldErrors.value.name = 'Please enter a product name';
        hasError = true;
        if (!firstErrorField) firstErrorField = 'name';
    }

    if (!formData.price || formData.price <= 0) {
        fieldErrors.value.price = 'Please enter a valid price';
        hasError = true;
        if (!firstErrorField) firstErrorField = 'price';
    }

    if (!formData.category_id) {
        fieldErrors.value.category_id = 'Please select a category';
        hasError = true;
        if (!firstErrorField) firstErrorField = 'category_id';
    }

    if (hasError) {
        // Focus on the first field with error
        switch (firstErrorField) {
            case 'name':
                nameInput.value?.focus();
                break;
            case 'price':
                // You might want to add a ref for price input
                document.querySelector<HTMLInputElement>('input[type="number"]')?.focus();
                break;
            case 'category_id':
                // Focus on category search input
                document.querySelector<HTMLInputElement>('input[placeholder*="category"]')?.focus();
                break;
        }
        return;
    }

    try {
        loading.value = true;

        const dataToSend: Product = {
            id: null,
            name: formData.name.trim(),
            price: formData.price!,
            category_id: formData.category_id!,
        };

        // Call the API service
        await createProduct(dataToSend);

        // Show success message
        success.value = true;

        // Redirect after 2 seconds
        setTimeout(() => {
            router.push('/products');
        }, 2000);

    } catch (err: any) {
        console.error('Error creating product:', err);

        // Handle Laravel validation errors
        if (err.response?.status === 422 && err.response?.data?.errors) {
            const laravelErrors = err.response.data.errors;

            // Map Laravel errors to field errors
            Object.keys(laravelErrors).forEach(field => {
                if (field in fieldErrors.value) {
                    fieldErrors.value[field] = laravelErrors[field][0];
                }
            });

            // Focus on first field with error from Laravel
            const firstErrorField = Object.keys(laravelErrors)[0];
            switch (firstErrorField) {
                case 'name':
                    nameInput.value?.focus();
                    break;
                case 'price':
                    document.querySelector<HTMLInputElement>('input[type="number"]')?.focus();
                    break;
                case 'category_id':
                    document.querySelector<HTMLInputElement>('input[placeholder*="category"]')?.focus();
                    break;
            }
        } else {
            // Handle non-validation errors
            error.value = err.response?.data?.message || err.message || 'Failed to create product. Please try again.';
        }
    } finally {
        loading.value = false;
    }
};
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

/* Animation for dropdown */
.slide-fade-enter-active {
    transition: all 0.2s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.15s ease-in;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    opacity: 0;
    transform: translateY(-5px);
}

/* Custom scrollbar for dropdown */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: #f8fafc;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Ensure dropdown appears above everything */
.z-50 {
    z-index: 50 !important;
    max-height: 250px !important;
    overflow-y: auto !important;
}
</style>
