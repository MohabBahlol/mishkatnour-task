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
                        <h1 class="text-3xl font-bold text-gray-900">Edit Product</h1>
                        <p class="mt-2 text-gray-600">Update product information</p>
                        <div v-if="product" class="flex items-center mt-2 space-x-4">
                            <span class="px-3 py-1 text-sm font-medium text-gray-800 bg-gray-100 rounded-full">
                                ID: {{ product.id }}
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
            <div v-if="loading && !product" class="flex justify-center items-center py-20">
                <div class="text-center">
                    <svg class="mx-auto w-12 h-12 text-blue-600 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="mt-4 text-gray-600">Loading product data...</p>
                </div>
            </div>

            <!-- Error State -->
            <div v-else-if="loadError" class="p-8 bg-red-50 rounded-xl border border-red-200">
                <div class="text-center">
                    <svg class="mx-auto w-12 h-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-red-800">Unable to load product</h3>
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
            <div v-else-if="product" class="overflow-hidden bg-white rounded-xl border border-gray-200 shadow-lg">
                <!-- Form Header -->
                <div class="px-8 py-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800">Edit Product Details</h2>
                            <p class="mt-1 text-gray-500">Update the information for this product</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form @submit.prevent="handleSubmit" class="p-8">
                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- ID Field (Disabled for editing) -->
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    Product ID
                                    <span class="ml-1 text-sm font-normal text-gray-500">(cannot be changed)</span>
                                </label>
                                <div class="relative">
                                    <input
                                        type="text"
                                        :value="product.id"
                                        disabled
                                        class="px-4 py-3 w-full text-gray-500 bg-gray-50 rounded-lg border border-gray-300 cursor-not-allowed"
                                    />
                                    <div class="flex absolute inset-y-0 right-0 items-center pr-3 pointer-events-none">
                                        <span class="text-lg font-medium text-gray-400">#</span>
                                    </div>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Product ID cannot be modified after creation</p>
                            </div>

                            <!-- Product Name Field -->
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
                                        :disabled="submitting"
                                        :class="{ 'border-red-300': fieldErrors.name }"
                                    />
                                    <div class="flex absolute inset-y-0 right-0 items-center pr-3 pointer-events-none">
                                        <span class="text-gray-400">{{ formData.name.length }}/100</span>
                                    </div>
                                </div>
                                <p v-if="fieldErrors.name" class="mt-1 text-sm text-red-600">
                                    {{ fieldErrors.name }}
                                </p>
                                <p v-else class="mt-1 text-sm text-gray-500">
                                    Enter a descriptive name for the product
                                </p>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Price Field -->
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    Price
                                    <span class="ml-1 text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        ref="priceInput"
                                        type="number"
                                        v-model.number="formData.price"
                                        required
                                        min="0"
                                        style="padding-left: 2.0rem;"
                                        step="0.01"
                                        class="py-3 pr-4 pl-8 w-full rounded-lg border border-gray-300 transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none"
                                        placeholder="0.00"
                                        :disabled="submitting"
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

                            <!-- Category Select -->
                            <div class="relative">
                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    Category
                                    <span class="ml-1 text-red-500">*</span>
                                </label>

                                <!-- Searchable Select -->
                                <div class="relative">
                                    <input
                                        ref="categoryInput"
                                        type="text"
                                        v-model="categorySearch"
                                        @focus="showCategoryDropdown = true"
                                        @blur="onCategoryBlur"
                                        @input="filterCategories"
                                        class="px-4 py-3 pr-10 w-full rounded-lg border border-gray-300 transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none"
                                        placeholder="Search or select a category..."
                                        :disabled="submitting || categoriesLoading"
                                        :class="{ 'border-red-300': fieldErrors.category_id }"
                                    />
                                    <div class="flex absolute inset-y-0 right-0 items-center pr-3">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Category Dropdown -->
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
                                        <div v-if="hasChanges" class="flex items-center text-sm text-blue-600">
                                            <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>You have unsaved changes</span>
                                        </div>
                                    </div>

                                    <div class="flex flex-col gap-3 mt-4 sm:flex-row">
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
                                            :disabled="submitting || !formData.name.trim() || !formData.price || !formData.category_id || !hasChanges"
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
            <div v-if="success" class="fixed right-4 bottom-4 z-50 px-6 py-4 max-w-md text-white bg-green-500 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <svg class="mr-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <div>
                        <p class="font-medium">Product updated successfully!</p>
                        <p class="mt-1 text-sm opacity-90">Redirecting to products list...</p>
                    </div>
                </div>
            </div>
        </Transition>
    </div>
</template>

<script setup lang="ts">
import { ref, reactive, computed, onMounted, watch } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { getProductById, updateProduct, getCategoriesForSelect } from '@/services/productService';
import type { Product } from '@/types/Product';

const router = useRouter();
const route = useRoute();

// Get product ID from route parameter
const productId = computed(() => parseInt(route.params.id as string));

// States
const loading = ref(true);
const submitting = ref(false);
const categoriesLoading = ref(false);
const loadError = ref('');
const success = ref(false);
const showCategoryDropdown = ref(false);

// Product data
const product = ref<Product | null>(null);

// Form data
const formData = reactive({
    id: null as number | null,
    name: '',
    price: null as number | null,
    category_id: null as number | null,
});

// Categories
const allCategories = ref<Array<{ value: number; label: string }>>([]);
const categorySearch = ref('');
const selectedCategory = ref<{ value: number; label: string } | null>(null);

// Error handling
const fieldErrors = ref({
    name: '',
    price: '',
    category_id: '',
});

// Refs for focusing
const nameInput = ref<HTMLInputElement | null>(null);
const priceInput = ref<HTMLInputElement | null>(null);
const categoryInput = ref<HTMLInputElement | null>(null);

// Field refs map for focusing
const fieldRefs: Record<string, any> = {
    name: nameInput,
    price: priceInput,
    category_id: categoryInput
};

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

// Computed for changes detection
const hasChanges = computed(() => {
    if (!product.value) return false;
    return (
        formData.name !== product.value.name ||
        formData.price !== product.value.price ||
        formData.category_id !== product.value.category_id
    );
});

// Helper function to focus on specific field
const focusOnField = (fieldName: string | null) => {
    if (fieldName && fieldName in fieldRefs) {
        const ref = fieldRefs[fieldName];
        ref.value?.focus();

        // Special handling for category field
        if (fieldName === 'category_id') {
            showCategoryDropdown.value = true;
        }
    }
};

// Load product data
const fetchProduct = async () => {
    try {
        loading.value = true;
        loadError.value = '';

        const data = await getProductById(productId.value);
        product.value = data;

        // Initialize form data
        formData.id = data.id;
        formData.name = data.name;
        formData.price = data.price;
        formData.category_id = data.category_id;

        // Load categories and set selected category
        await loadCategories();

        // Set selected category display
        if (formData.category_id) {
            const category = allCategories.value.find(c => c.value === formData.category_id);
            if (category) {
                selectedCategory.value = category;
                categorySearch.value = category.label;
            }
        }

    } catch (err: any) {
        console.error('Error fetching product:', err);
        loadError.value = err.response?.data?.message || err.message || 'Failed to load product data';
    } finally {
        loading.value = false;
    }
};

// Load categories for select
const loadCategories = async () => {
    try {
        categoriesLoading.value = true;
        allCategories.value = await getCategoriesForSelect();
    } catch (err) {
        console.error('Error loading categories:', err);
        loadError.value = 'Failed to load categories. Please try again.';
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

// Focus on name input when data is loaded
watch(product, (newVal) => {
    if (newVal) {
        setTimeout(() => {
            nameInput.value?.focus();
        }, 100);
    }
});

// Handle form submission
const handleSubmit = async () => {
    // Clear previous errors
    fieldErrors.value = {
        name: '',
        price: '',
        category_id: '',
    };

    // Track the first error for focusing
    let firstErrorField: string | null = null;

    // Validate name
    if (!formData.name.trim()) {
        fieldErrors.value.name = 'Please enter a product name';
        if (!firstErrorField) firstErrorField = 'name';
    }

    // Validate price
    if (!formData.price) {
        fieldErrors.value.price = 'Please enter a price';
        if (!firstErrorField) firstErrorField = 'price';
    } else if (formData.price <= 0) {
        fieldErrors.value.price = 'Price must be greater than 0';
        if (!firstErrorField) firstErrorField = 'price';
    }

    // Validate category
    if (!formData.category_id) {
        fieldErrors.value.category_id = 'Please select a category';
        if (!firstErrorField) firstErrorField = 'category_id';
    }

    // Check if there are any errors
    const hasError = Object.values(fieldErrors.value).some(error => error !== '');

    if (hasError && firstErrorField) {
        focusOnField(firstErrorField);
        return;
    }

    try {
        submitting.value = true;

        const dataToSend: any = {
            name: formData.name.trim(),
            price: formData.price!,
            category_id: formData.category_id!,
        };

        // Call the API service
        await updateProduct(productId.value, dataToSend);

        // Show success message
        success.value = true;

        // Redirect after 2 seconds
        setTimeout(() => {
            router.push('/products');
        }, 2000);

    } catch (err: any) {
        console.error('Error updating product:', err);

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
            const firstLaravelErrorField = Object.keys(laravelErrors)[0];
            if (firstLaravelErrorField) {
                focusOnField(firstLaravelErrorField);
            }
        } else {
            // Handle non-validation errors
            loadError.value = err.response?.data?.message || err.message || 'Failed to update product. Please try again.';
        }
    } finally {
        submitting.value = false;
    }
};

// Navigate back
const goBack = () => {
    if (hasChanges.value) {
        if (confirm('You have unsaved changes. Are you sure you want to leave?')) {
            router.push('/products');
        }
    } else {
        router.push('/products');
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
    fetchProduct();
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
}
</style>
