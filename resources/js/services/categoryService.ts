import api from './api'
import type { Category } from '@/types/Category'

export const getCategories = async (): Promise<Category[]> => {
    const response = await api.get('/categories')
    return response.data.data
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
