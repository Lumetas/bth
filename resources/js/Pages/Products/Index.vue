<template>
    <div class="products-page">
        <header class="header">
            <h1>Каталог товаров</h1>
            <nav class="nav">
                <Link v-if="isAuth" href="/admin/products" class="admin-link">Управление товарами</Link>
                <button v-if="isAuth" @click="logout" class="logout-btn">Выйти</button>
                <Link v-else href="/admin/login" class="admin-link">Админ</Link>
            </nav>
        </header>

        <div class="filters">
            <select v-model="selectedCategory" @change="filterProducts" class="category-select">
                <option :value="null">Все категории</option>
                <option v-for="category in categories" :key="category.id" :value="category.id">
                    {{ category.name }}
                </option>
            </select>
        </div>

        <div class="products-grid">
            <div v-for="product in products" :key="product.id" class="product-card">
                <Link :href="`/product/${product.id}`" class="product-link">
                    <h3 class="product-name">{{ product.name }}</h3>
                    <p class="product-category">{{ product.category?.name }}</p>
                    <p class="product-price">${{ product.price }}</p>
                    <p class="product-description">{{ product.description }}</p>
                </Link>
            </div>
        </div>

        <div class="pagination" v-if="pagination.last_page > 1">
            <button 
                @click="changePage(pagination.current_page - 1)" 
                :disabled="pagination.current_page === 1"
                class="pagination-btn"
            >
                Назад
            </button>
            <span class="page-info">{{ pagination.current_page }} / {{ pagination.last_page }}</span>
            <button 
                @click="changePage(pagination.current_page + 1)" 
                :disabled="pagination.current_page === pagination.last_page"
                class="pagination-btn"
            >
                Вперёд
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'

const props = defineProps({
    products: Array,
    categories: Array,
    pagination: Object,
    filters: Object,
})

const selectedCategory = ref(props.filters?.category_id || null)
const token = localStorage.getItem('auth_token')
const isAuth = computed(() => !!token)

const filterProducts = () => {
    router.get('/', { category_id: selectedCategory.value }, { preserveState: true })
}

const changePage = (page) => {
    router.get('/', { page, category_id: selectedCategory.value }, { preserveState: true })
}

const logout = async () => {
    if (token) {
        try {
            await fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                },
            })
        } catch (e) {}
    }
    localStorage.removeItem('auth_token')
    router.visit('/')
}
</script>

<style scoped>
.products-page {
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
    font-size: 32px;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0;
}

.admin-link {
    padding: 10px 20px;
    background: #667eea;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 500;
}

.logout-btn {
    padding: 10px 20px;
    background: #ef4444;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
}

.nav {
    display: flex;
    gap: 12px;
}

.filters {
    margin-bottom: 30px;
}

.category-select {
    padding: 12px 16px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    min-width: 200px;
    background: white;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
    margin-bottom: 30px;
}

.product-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.2s;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
}

.product-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.product-name {
    font-size: 20px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0 0 8px;
}

.product-category {
    font-size: 14px;
    color: #667eea;
    margin: 0 0 8px;
}

.product-price {
    font-size: 24px;
    font-weight: 700;
    color: #10b981;
    margin: 0 0 12px;
}

.product-description {
    font-size: 14px;
    color: #666;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 16px;
}

.pagination-btn {
    padding: 10px 20px;
    background: #f5f5f5;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
}

.pagination-btn:hover:not(:disabled) {
    background: #667eea;
    color: white;
}

.pagination-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.page-info {
    font-size: 14px;
    color: #666;
}
</style>