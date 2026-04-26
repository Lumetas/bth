<template>
    <div class="admin-products-page">
        <header class="header">
            <h1>Управление товарами</h1>
            <div class="header-actions">
                <Link href="/admin/products/create" class="add-btn">Добавить товар</Link>
                <button @click="logout" class="logout-btn">Выйти</button>
            </div>
        </header>

        <div class="filters">
            <select v-model="selectedCategory" @change="filterProducts" class="category-select">
                <option :value="null">Все категории</option>
                <option v-for="category in categories" :key="category.id" :value="category.id">
                    {{ category.name }}
                </option>
            </select>
        </div>

        <table class="products-table">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Категория</th>
                    <th>Цена</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products" :key="product.id">
                    <td>{{ product.name }}</td>
                    <td>{{ product.category?.name }}</td>
                    <td>${{ product.price }}</td>
                    <td class="actions">
                        <Link :href="`/admin/products/${product.id}/edit`" class="edit-btn">Редактировать</Link>
                        <button @click="deleteProduct(product.id)" class="delete-btn">Удалить</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="pagination" v-if="pagination.last_page > 1">
            <button @click="changePage(pagination.current_page - 1)" :disabled="pagination.current_page === 1" class="pagination-btn">Назад</button>
            <span class="page-info">{{ pagination.current_page }} / {{ pagination.last_page }}</span>
            <button @click="changePage(pagination.current_page + 1)" :disabled="pagination.current_page === pagination.last_page" class="pagination-btn">Вперёд</button>
        </div>

        <div v-if="showDeleteModal" class="modal-overlay" @click="showDeleteModal = false">
            <div class="modal" @click.stop>
                <h3>Подтверждение удаления</h3>
                <p>Вы уверены, что хотите удалить этот товар?</p>
                <div class="modal-actions">
                    <button @click="confirmDelete" class="delete-confirm-btn">Удалить</button>
                    <button @click="showDeleteModal = false" class="cancel-btn">Отмена</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link, router, useForm } from '@inertiajs/vue3'

const props = defineProps({
    products: Array,
    categories: Array,
    pagination: Object,
    filters: Object,
})

const selectedCategory = ref(props.filters?.category_id || null)
const showDeleteModal = ref(false)
const productToDelete = ref(null)
const token = localStorage.getItem('auth_token')

const filterProducts = () => {
    router.get('/admin/products', { category_id: selectedCategory.value }, { preserveState: true })
}

const changePage = (page) => {
    router.get('/admin/products', { page, category_id: selectedCategory.value }, { preserveState: true })
}

const deleteProduct = (id) => {
    productToDelete.value = id
    showDeleteModal.value = true
}

const confirmDelete = async () => {
    try {
        const response = await fetch(`/api/products/${productToDelete.value}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
            },
        })
        
        if (response.ok) {
            router.reload()
        }
    } catch (error) {
        console.error('Error deleting product:', error)
    }
    
    showDeleteModal.value = false
    productToDelete.value = null
}

const logout = async () => {
    try {
        await fetch('/admin/logout', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
            },
        })
    } catch (e) {}
    
    localStorage.removeItem('auth_token')
    window.location.href = '/'
}
</script>

<style scoped>
.admin-products-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.header h1 {
    font-size: 28px;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0;
}

.header-actions {
    display: flex;
    gap: 12px;
}

.add-btn {
    padding: 12px 24px;
    background: #10b981;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 500;
}

.logout-btn {
    padding: 12px 24px;
    background: #ef4444;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}

.filters {
    margin-bottom: 24px;
}

.category-select {
    padding: 10px 16px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    min-width: 200px;
}

.products-table {
    width: 100%;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.products-table th,
.products-table td {
    padding: 16px;
    text-align: left;
}

.products-table th {
    background: #f9fafb;
    font-weight: 600;
    color: #374151;
}

.products-table td {
    border-top: 1px solid #e5e7eb;
}

.actions {
    display: flex;
    gap: 8px;
}

.edit-btn {
    padding: 6px 12px;
    background: #3b82f6;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-size: 14px;
}

.delete-btn {
    padding: 6px 12px;
    background: #ef4444;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 16px;
    margin-top: 24px;
}

.pagination-btn {
    padding: 8px 16px;
    background: #f5f5f5;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.pagination-btn:disabled {
    opacity: 0.5;
}

.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 100;
}

.modal {
    background: white;
    padding: 24px;
    border-radius: 12px;
    max-width: 400px;
}

.modal h3 {
    margin: 0 0 12px;
    font-size: 20px;
}

.modal p {
    margin: 0 0 20px;
    color: #666;
}

.modal-actions {
    display: flex;
    gap: 12px;
}

.delete-confirm-btn {
    padding: 10px 20px;
    background: #ef4444;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.cancel-btn {
    padding: 10px 20px;
    background: #e5e7eb;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}
</style>