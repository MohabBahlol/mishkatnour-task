import api from './api'
import type { Product } from '@/types/Product'
import type { Category } from '@/types/Category'

export const getProducts = async (): Promise<Product[]> => {
    const response = await api.get('/products')
    return response.data.data
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
