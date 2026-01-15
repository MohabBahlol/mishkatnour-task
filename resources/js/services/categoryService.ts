import api from './api'
import type { Category } from '@/types/Category'
import type { PaginationParams, PaginatedResponse } from '@/types/ApiResponse'


export const getCategories = async (params?: PaginationParams): Promise<PaginatedResponse> => {
    const queryParams: any = {};

    if (params?.page) queryParams.page = params.page;
    if (params?.perPage) queryParams.perPage = params.perPage;
    if (params?.search) queryParams.search = params.search;
    if (params?.sortBy) queryParams.sortBy = params.sortBy;
    if (params?.sortOrder) queryParams.sortOrder = params.sortOrder;
    const response = await api.get('/categories', { params: queryParams });
    return response.data;
}
export const getCategoryById = async (id: number): Promise<Category> => {
    const response = await api.get(`/categories/${id}`)
    return response.data.data
}

export const createCategory = async (category: Category): Promise<Category> => {
    const response = await api.post('/categories', category)
    return response.data
}

export const updateCategory = async (id: number, category: Partial<Category>): Promise<Category> => {
    const response = await api.put(`/categories/${id}`, category)
    return response.data
}

export const deleteCategory = async (id: number): Promise<void> => {
    await api.delete(`/categories/${id}`)
}
