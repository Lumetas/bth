<template>
    <div class="product-page">
        <Link href="/" class="back-link">&larr; Назад к списку</Link>
        
        <div class="product-detail">
            <h1>{{ product.name }}</h1>
            <p class="category">{{ product.category?.name }}</p>
            <p class="price">${{ product.price }}</p>
            <p class="description">{{ product.description }}</p>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    product: Object,
})
</script>

<style scoped>
.product-page {
    max-width: 800px;
    margin: 0 auto;
    padding: 40px 20px;
}

.back-link {
    display: inline-block;
    margin-bottom: 20px;
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
}

.product-detail h1 {
    font-size: 36px;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0 0 12px;
}

.category {
    font-size: 18px;
    color: #667eea;
    margin: 0 0 16px;
}

.price {
    font-size: 32px;
    font-weight: 700;
    color: #10b981;
    margin: 0 0 24px;
}

.description {
    font-size: 16px;
    line-height: 1.6;
    color: #666;
}
</style>