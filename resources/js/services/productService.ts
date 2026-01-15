// services/productService.ts
import api from './api'
import type { Product } from '@/types/Product'
import type { Category } from '@/types/Category'
import type { PaginationParams, PaginatedResponse } from '@/types/ApiResponse'

export const getProducts = async (params?: PaginationParams): Promise<PaginatedResponse> => {
    const queryParams: any = {};

    if (params?.page) queryParams.page = params.page;
    if (params?.perPage) queryParams.perPage = params.perPage;
    if (params?.search) queryParams.search = params.search;
    if (params?.sortBy) queryParams.sortBy = params.sortBy;
    if (params?.sortOrder) queryParams.sortOrder = params.sortOrder;

    const response = await api.get('/products', { params: queryParams });
    return response.data;
}

export const getProductById = async (id: number): Promise<Product> => {
    const response = await api.get(`/products/${id}`)
    return response.data.data
}

export const createProduct = async (product: Product): Promise<Product> => {
    const response = await api.post('/products', product)
    return response.data
}

export const updateProduct = async (id: number, product: Partial<Product>): Promise<Product> => {
    const response = await api.put(`/products/${id}`, product)
    return response.data
}

export const deleteProduct = async (id: number): Promise<void> => {
    await api.delete(`/products/${id}`)
}

export const getCategoriesForSelect = async (): Promise<Array<{ value: number; label: string }>> => {
    const response = await api.get('/categories')
    return response.data.data.map((category: Category) => ({
        value: category.id,
        label: category.name
    }))
}

export const getShopProducts = async (params: Record<string, any> = {}) => {
    const response = await api.get('/products/shop', { params });
    return response.data;
};
