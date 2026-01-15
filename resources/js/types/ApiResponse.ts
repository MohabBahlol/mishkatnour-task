import type { Category } from "./Category"

export interface ApiResponse<T = any> {
    data: T
    status: number
    statusText: string
    headers: any
    config: any
}

export interface PaginationParams {
    page?: number
    perPage?: number
    search?: string
    sortBy?: string
    sortOrder?: 'asc' | 'desc'
    filters?: Record<string, string>
}

export interface PaginatedResponse {
    data: Category[]
    total: number
    per_page: number
    current_page: number
    last_page: number
}
