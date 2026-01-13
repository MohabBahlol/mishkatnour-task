<template>
    <div class="p-4 min-h-screen bg-gray-50 md:p-8">
        <!-- Header -->
        <div class="mx-auto max-w-7xl">
            <h1 class="mb-2 text-4xl font-bold text-gray-900 md:text-5xl">
                Welcome to <span class="text-blue-600">Mishkat Nour</span>
            </h1>
            <p class="mb-8 text-lg text-gray-600">Discover our premium products</p>

            <!-- Filter Section -->
            <div class="p-6 mb-8 bg-white rounded-xl border border-gray-200 shadow-sm">
                <h2 class="mb-4 text-xl font-semibold text-gray-800">Filter Products</h2>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <!-- Name Search -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Search by Name
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                v-model="filters.name"
                                placeholder="Product name..."
                                class="px-4 py-3 w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none"
                            />
                            <div class="flex absolute inset-y-0 right-0 items-center pr-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="relative">
                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Category
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                v-model="categorySearch"
                                @focus="showCategoryDropdown = true"
                                @blur="onCategoryBlur"
                                @input="filterCategoryOptions"
                                class="px-4 py-3 pr-10 w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none"
                                placeholder="Select category..."
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
                            >
                                <div class="overflow-y-auto max-h-48">
                                    <div
                                        v-for="category in filteredCategories"
                                        :key="category.value"
                                        @mousedown.prevent="selectCategory(category)"
                                        class="px-4 py-3 border-b border-gray-100 transition-colors cursor-pointer hover:bg-gray-50 last:border-b-0"
                                        :class="{ 'bg-blue-50 text-blue-700': filters.category_id === category.value }"
                                    >
                                        <div class="font-medium">{{ category.label }}</div>
                                    </div>
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
                    </div>

                    <!-- Min Price -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Min Price
                        </label>
                        <div class="relative">
                            <input
                                type="number"
                                v-model.number="filters.min_price"
                                min="0"
                                step="0.01"
                                class="py-3 pr-4 pl-8 w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none"
                                placeholder="0.00"
                            />
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <span class="text-gray-500">$</span>
                            </div>
                        </div>
                    </div>

                    <!-- Max Price -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Max Price
                        </label>
                        <div class="relative">
                            <input
                                type="number"
                                v-model.number="filters.max_price"
                                min="0"
                                step="0.01"
                                class="py-3 pr-4 pl-8 w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none"
                                placeholder="9999.99"
                            />
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <span class="text-gray-500">$</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 justify-end pt-6 mt-6 border-t border-gray-200">
                    <button
                        @click="resetFilters"
                        style="padding:.5rem;"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white rounded-lg border border-gray-300 transition-colors hover:bg-gray-50"
                    >
                        Clear Filters
                    </button>
                    <button
                        @click="applyFilters"
                        style="padding:.5rem;"
                        class="flex gap-2 items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg border border-transparent transition-colors hover:bg-blue-700"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Apply Filters
                    </button>
                </div>
            </div>

            <!-- Products Grid -->
            <div v-if="loading" class="flex justify-center items-center py-20">
                <div class="text-center">
                    <svg class="mx-auto w-12 h-12 text-blue-600 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="mt-4 text-gray-600">Loading products...</p>
                </div>
            </div>

            <div v-else>
                <!-- Results Info -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ filteredProducts.length }} Products Found
                        </h3>
                        <p class="text-sm text-gray-500">
                            Showing all available products
                        </p>
                    </div>
                    <div class="flex gap-3 items-center">
                        <span class="px-3 py-1 text-sm font-medium text-blue-700 bg-blue-100 rounded-full">
                            {{ activeFilterCount }} filters active
                        </span>
                    </div>
                </div>

                <!-- Products Grid -->
                <div v-if="filteredProducts.length > 0" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    <div
                        v-for="product in filteredProducts"
                        :key="product.id"
                        class="overflow-hidden bg-white rounded-xl border border-gray-200 shadow-sm transition-shadow duration-300 group hover:shadow-lg"
                    >

                        <!-- Product Info -->
                        <div class="p-6">
                            <!-- Category Badge -->
                            <div class="mb-3">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full">
                                    {{ product.category || 'Uncategorized' }}
                                </span>
                            </div>

                            <!-- Product Name -->
                            <h4 class="mb-2 text-lg font-semibold text-gray-900 transition-colors group-hover:text-blue-600 line-clamp-1">
                                {{ product.name }}
                            </h4>

                            <!-- Price and Actions -->
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-xl font-bold text-gray-900">${{ product.price }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Product Footer -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                            <div class="flex justify-between items-center text-xs text-gray-500">
                                <div class="flex gap-2 items-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>ID: {{ product.id }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- No Products Message -->
                <div v-else class="py-16 text-center">
                    <div class="inline-flex justify-center items-center mb-4 w-16 h-16 bg-gray-100 rounded-full">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="mb-2 text-xl font-semibold text-gray-900">No products found</h3>
                    <p class="mb-6 text-gray-600">Try adjusting your filters or search terms</p>
                    <button
                        @click="resetFilters"
                        class="px-5 py-2.5 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg transition-colors hover:bg-blue-100"
                    >
                        Clear all filters
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid gap-6 mt-4 mt-12 md:grid-cols-3">
                <div class="p-6 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-blue-700">Total Products</p>
                            <h3 class="mt-2 text-3xl font-bold text-gray-900">{{ products.length }}</h3>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <span class="text-xl font-bold text-blue-600">📦</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-gradient-to-br from-green-50 to-green-100 rounded-xl border border-green-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-green-700">Average Price</p>
                            <h3 class="mt-2 text-3xl font-bold text-gray-900">${{ parseFloat(averagePrice).toFixed(2) }}</h3>
                        </div>
                        <div class="p-3 bg-green-100 rounded-lg">
                            <span class="text-xl font-bold text-green-600">💰</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl border border-purple-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-purple-700">Categories</p>
                            <h3 class="mt-2 text-3xl font-bold text-gray-900">{{ uniqueCategories.length }}</h3>
                        </div>
                        <div class="p-3 bg-purple-100 rounded-lg">
                            <span class="text-xl font-bold text-purple-600">🏷️</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, reactive, computed, onMounted } from 'vue';
import { getProducts, getCategoriesForSelect } from '@/services/productService';
import type { Product } from '@/types/Product';

// States
const loading = ref(true);
const products = ref<Product[]>([]);
const showCategoryDropdown = ref(false);

// Filters
const filters = reactive({
    name: '',
    category_id: null as number | null,
    min_price: null as number | null,
    max_price: null as number | null,
});

// Categories
const allCategories = ref<Array<{ value: number; label: string }>>([]);
const categorySearch = ref('');
const selectedCategory = ref<{ value: number; label: string } | null>(null);

// Computed properties
const filteredCategories = computed(() => {
    if (!categorySearch.value.trim()) {
        return allCategories.value;
    }
    const searchTerm = categorySearch.value.toLowerCase();
    return allCategories.value.filter(category =>
        category.label.toLowerCase().includes(searchTerm)
    );
});

const filteredProducts = computed(() => {
    return products.value.filter(product => {
        // Filter by name
        if (filters.name && !product.name.toLowerCase().includes(filters.name.toLowerCase())) {
            return false;
        }

        // Filter by category
        if (filters.category_id && product.category_id !== filters.category_id) {
            return false;
        }

        // Filter by min price
        if (filters.min_price !== null && product.price < filters.min_price) {
            return false;
        }

        // Filter by max price
        if (filters.max_price !== null && product.price > filters.max_price) {
            return false;
        }

        return true;
    });
});

const averagePrice = computed(() => {
    if (products.value.length === 0) return 0;
    const total = products.value.reduce((sum, product) => sum + parseFloat(product.price), 0);
    return total / products.value.length;
});

const uniqueCategories = computed(() => {
    const categories = products.value
        .map(p => p.category)
        .filter(Boolean);
    return [...new Set(categories)];
});

const activeFilterCount = computed(() => {
    let count = 0;
    if (filters.name) count++;
    if (filters.category_id) count++;
    if (filters.min_price !== null) count++;
    if (filters.max_price !== null) count++;
    return count;
});

// Category filter functions
const selectCategory = (category: { value: number; label: string }) => {
    filters.category_id = category.value;
    selectedCategory.value = category;
    categorySearch.value = category.label;
    showCategoryDropdown.value = false;
};

const clearCategory = () => {
    filters.category_id = null;
    selectedCategory.value = null;
    categorySearch.value = '';
    showCategoryDropdown.value = true;
};

const filterCategoryOptions = () => {
    showCategoryDropdown.value = true;
};

const onCategoryBlur = () => {
    setTimeout(() => {
        showCategoryDropdown.value = false;
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

// Filter actions
const applyFilters = () => {
    // Filters are applied automatically via computed property
    console.log('Filters applied:', filters);
};

const resetFilters = () => {
    filters.name = '';
    filters.category_id = null;
    filters.min_price = null;
    filters.max_price = null;
    selectedCategory.value = null;
    categorySearch.value = '';
};

// Load data
const loadData = async () => {
    try {
        loading.value = true;
        const [productsData, categoriesData] = await Promise.all([
            getProducts(),
            getCategoriesForSelect()
        ]);

        products.value = productsData;
        allCategories.value = categoriesData;

    } catch (error) {
        console.error('Error loading data:', error);
    } finally {
        loading.value = false;
    }
};

// Lifecycle
onMounted(() => {
    loadData();
});
</script>

<style scoped>
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

/* Line clamp utility */
.line-clamp-1 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 1;
}

.line-clamp-2 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
}

/* Ensure dropdown appears above everything */
.z-50 {
    z-index: 50 !important;
}
</style>
