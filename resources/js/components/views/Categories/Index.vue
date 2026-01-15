<template>
    <div class="p-4 md:p-6">
        <div class="mb-6">
            <div class="flex flex-col gap-4 justify-between md:flex-row md:items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Categories</h1>
                    <div class="flex gap-4 items-center mt-2">
                        <span class="px-3 py-1 text-sm font-medium text-blue-700 bg-blue-100 rounded-full">
                            {{ paginationData.total || 0 }} categories
                        </span>
                        <div class="text-sm text-gray-600">
                            Manage and export your category data
                        </div>
                    </div>
                </div>
                <button @click="router.push('/categories/add')"
                    class="flex gap-2 items-center px-4 py-2 text-white bg-blue-600 rounded-lg transition-colors hover:bg-blue-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add New Category
                </button>
            </div>
        </div>

        <div class="p-4 mb-6 bg-white rounded-lg border border-gray-200 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex flex-wrap gap-3 items-center">
                    <!-- Global Search Input -->
                    <div class="relative">
                        <input
                            v-model="searchQuery"
                            @input="handleSearch"
                            type="search"
                            placeholder="Search categories..."
                            class="py-2 pr-4 pl-10 text-sm rounded-lg border border-gray-300 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                        <svg class="absolute top-2.5 left-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    <button type="button"
                        class="flex gap-2 items-center px-4 py-2 text-sm text-white bg-green-600 rounded-lg transition-colors hover:bg-green-700"
                        @click="exportTable('csv')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export CSV
                    </button>
                    <button type="button"
                        class="flex gap-2 items-center px-4 py-2 text-sm text-white bg-gray-800 rounded-lg transition-colors hover:bg-gray-700"
                        @click="exportTable('txt')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export TXT
                    </button>
                    <button type="button"
                        class="flex gap-2 items-center px-4 py-2 text-sm text-white bg-blue-600 rounded-lg transition-colors hover:bg-blue-700"
                        @click="exportTable('print')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Print
                    </button>
                </div>
                <button @click="fetchCategories"
                    class="flex gap-2 items-center px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg transition-colors hover:bg-gray-200"
                    :disabled="loading">
                    <svg class="w-4 h-4" :class="{ 'animate-spin': loading }" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    {{ loading ? 'Loading...' : 'Refresh' }}
                </button>
            </div>
        </div>

        <!-- Data Table -->
        <div class="overflow-hidden bg-white rounded-lg border border-gray-200 shadow-sm">
            <vue3-datatable
                ref="datatable"
                :rows="rows"
                :columns="cols"
                :loading="loading"
                :totalRows="paginationData.total"
                :sortable="true"
                :columnFilter="false"
                skin="bh-table-hover"
                :isServerMode="true"
                @change="handleTableChange"
                class="w-full">
                <!-- @ts-ignore -->
                <template #actions="slotProps">
                    <div class="flex gap-2 items-center">
                        <button @click="CategoryEdit(slotProps.value)"
                            class="p-1.5 text-blue-600 rounded-md transition-colors hover:bg-blue-50" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button @click="CategoryDelete(slotProps.value.id)"
                            class="p-1.5 text-red-600 rounded-md transition-colors hover:bg-red-50" title="Delete">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </template>
            </vue3-datatable>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import Vue3Datatable from '@bhplugin/vue3-datatable';
import '@bhplugin/vue3-datatable/dist/style.css';
import { deleteCategory, getCategories } from '@/services/categoryService';
import { useRouter } from 'vue-router';
import type { Category } from '@/types/Category';

const router = useRouter();
const loading = ref(true);
const rows = ref<any[]>([]);
const searchQuery = ref('');
let searchTimeout: ReturnType<typeof setTimeout> | null = null;

const paginationData = ref({
    total: 0,
    per_page: 10,
    current_page: 1,
    last_page: 1
});

const tableParams = ref({
    page: 1,
    perPage: 10,
    search: '',
    sortBy: '',
    sortOrder: 'asc' as 'asc' | 'desc'
});

const cols = ref([
    { field: 'id', title: 'ID', isUnique: true, type: 'number', width: '200px' },
    { field: 'name', title: 'Category Name', type: 'string' },
    {
        field: 'actions',
        title: 'Actions',
        sort: false,
        filter: false,
        width: '100px',
        cellClass: 'text-center'
    }
]);

const handleSearch = () => {
    // Debounce search to avoid too many API calls
    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }

    searchTimeout = setTimeout(() => {
        tableParams.value.search = searchQuery.value;
        tableParams.value.page = 1; // Reset to first page on search
        fetchCategories();
    }, 500); // Wait 500ms after user stops typing
};

const handleTableChange = (params: any) => {
    tableParams.value = {
        page: params.current_page || 1,
        perPage: params.pagesize || 10,
        search: searchQuery.value, // Use our own search input
        sortBy: params.sort_column || '',
        sortOrder: params.sort_direction || 'asc'
    };

    fetchCategories();
};

const fetchCategories = async () => {
    try {
        loading.value = true;
        const response = await getCategories(tableParams.value);
        rows.value = response.data;
        paginationData.value = {
            total: response.total,
            per_page: response.per_page,
            current_page: response.current_page,
            last_page: response.last_page
        };
    } catch (error) {
        console.error('Error fetching categories:', error);
        rows.value = [];
    } finally {
        loading.value = false;
    }
};

const CategoryEdit = (category: Category) => {
    router.push(`/categories/edit/${category.id}`);
};

const CategoryDelete = async (id: any) => {
    if (confirm('Are you sure you want to delete this category?')) {
        try {
            await deleteCategory(id);
            fetchCategories();
        } catch (error) {
            console.error('Error deleting category:', error);
        }
    }
};

const exportTable = async (type: 'csv' | 'txt' | 'print') => {
    // For export, fetch all data without pagination
    let records = rows.value;

    // Optionally, fetch all records for export
    try {
        const exportParams = {
            ...tableParams.value,
            perPage: paginationData.value.total // Get all records
        };
        const response = await getCategories(exportParams);
        records = response.data;
    } catch (error) {
        console.error('Error fetching all records for export:', error);
        // Fall back to current page data
        records = rows.value;
    }

    const filename = `categories_${new Date().toISOString().split('T')[0]}`;

    if (type === 'csv' || type === 'txt') {
        const coldelimiter = ',';
        const linedelimiter = '\n';
        let result = cols.value
            .filter((d: any) => d.field !== 'actions')
            .map((d: any) => d.title)
            .join(coldelimiter);
        result += linedelimiter;

        records.forEach((item: any) => {
            cols.value
                .filter((d: any) => d.field !== 'actions')
                .forEach((d: any, index: number) => {
                    if (index > 0) result += coldelimiter;
                    const val = d.field.split('.').reduce((acc: any, part: any) => acc?.[part], item);
                    result += val || '';
                });
            result += linedelimiter;
        });

        if (type === 'csv') {
            const data = 'data:application/csv;charset=utf-8,' + encodeURIComponent(result);
            downloadFile(data, filename + '.csv');
        } else if (type === 'txt') {
            const data = 'data:application/txt;charset=utf-8,' + encodeURIComponent(result);
            downloadFile(data, filename + '.txt');
        }
    } else if (type === 'print') {
        let rowhtml = `<h2 style="text-align: center; margin-bottom: 20px;">${filename}</h2>`;
        rowhtml += '<table style="width: 100%; border-collapse: collapse;">';
        rowhtml += '<thead><tr style="background: #f8f9fa; color: #495057;">';
        cols.value
            .filter((d: any) => d.field !== 'actions')
            .forEach((d: any) => {
                rowhtml += `<th style="padding: 12px; border: 1px solid #dee2e6; text-align: left;">${d.title}</th>`;
            });
        rowhtml += '</tr></thead><tbody>';

        records.forEach((item: any) => {
            rowhtml += '<tr>';
            cols.value
                .filter((d: any) => d.field !== 'actions')
                .forEach((d: any) => {
                    const val = d.field.split('.').reduce((acc: any, part: any) => acc?.[part], item);
                    rowhtml += `<td style="padding: 10px; border: 1px solid #dee2e6;">${val || ''}</td>`;
                });
            rowhtml += '</tr>';
        });
        rowhtml += '</tbody></table>';

        const printWindow = window.open('', '_blank', 'width=800,height=600');
        if (printWindow) {
            printWindow.document.write(`
                <html>
                    <head>
                        <title>${filename}</title>
                        <style>
                            body { font-family: Arial, sans-serif; margin: 20px; color: #333; }
                            table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                            th { background: #f8f9fa; }
                            tr:nth-child(even) { background: #f9f9f9; }
                        </style>
                    </head>
                    <body>${rowhtml}</body>
                </html>
            `);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
        }
    }
};

const downloadFile = (data: string, filename: string) => {
    const link = document.createElement('a');
    link.setAttribute('href', data);
    link.setAttribute('download', filename);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
};

onMounted(() => {
    fetchCategories();
});
</script>
