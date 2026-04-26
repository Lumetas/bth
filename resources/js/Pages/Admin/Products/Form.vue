<template>
    <div class="product-form-page">
        <header class="header">
            <h1>{{ isEdit ? 'Редактирование товара' : 'Добавление товара' }}</h1>
            <Link v-if="isEdit" :href="'/admin/products'" class="back-link">Назад</Link>
            <Link v-else href="/admin/products" class="back-link">Назад</Link>
        </header>

        <form @submit.prevent="submitForm" class="form">
            <div class="form-group">
                <label for="name">Название *</label>
                <input 
                    id="name" 
                    v-model="form.name" 
                    type="text" 
                    required
                    class="form-input"
                    placeholder="Введите название товара"
                />
                <span v-if="errors.name" class="error">{{ errors.name }}</span>
            </div>

            <div class="form-group">
                <label for="category_id">Категория *</label>
                <select 
                    id="category_id" 
                    v-model="form.category_id" 
                    required
                    class="form-select"
                >
                    <option value="">Выберите категорию</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
                <span v-if="errors.category_id" class="error">{{ errors.category_id }}</span>
            </div>

            <div class="form-group">
                <label for="price">Цена *</label>
                <input 
                    id="price" 
                    v-model="form.price" 
                    type="number" 
                    step="0.01" 
                    min="0.01"
                    required
                    class="form-input"
                    placeholder="0.00"
                />
                <span v-if="errors.price" class="error">{{ errors.price }}</span>
            </div>

            <div class="form-group">
                <label for="description">Описание</label>
                <textarea 
                    id="description" 
                    v-model="form.description" 
                    class="form-textarea"
                    rows="5"
                    placeholder="Введите описание товара"
                ></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-btn" :disabled="saving">
                    {{ saving ? 'Сохранение...' : 'Сохранить' }}
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
    product: Object,
    categories: Array,
    isEdit: Boolean,
})

const form = reactive({
    name: props.product?.name || '',
    category_id: props.product?.category_id || '',
    price: props.product?.price || '',
    description: props.product?.description || '',
})

const errors = ref({})
const saving = ref(false)
const token = localStorage.getItem('auth_token')

const submitForm = async () => {
    errors.value = {}
    saving.value = true
    
    try {
        const url = props.isEdit 
            ? `/api/products/${props.product.id}`
            : '/api/products'
        
        const method = props.isEdit ? 'PUT' : 'POST'
        
        const response = await fetch(url, {
            method,
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(form),
        })
        
        if (!response.ok) {
            const data = await response.json()
            if (data.errors) {
                errors.value = data.errors
            }
            return
        }
        
        router.visit('/admin/products')
    } catch (error) {
        console.error('Error saving product:', error)
    } finally {
        saving.value = false
    }
}
</script>

<style scoped>
.product-form-page {
    max-width: 600px;
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

.back-link {
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
}

.form {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #374151;
}

.form-input,
.form-select,
.form-textarea {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.2s;
    box-sizing: border-box;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: #667eea;
}

.error {
    display: block;
    margin-top: 6px;
    color: #ef4444;
    font-size: 14px;
}

.form-actions {
    margin-top: 24px;
}

.submit-btn {
    width: 100%;
    padding: 14px;
    background: #10b981;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
}

.submit-btn:hover:not(:disabled) {
    background: #059669;
}

.submit-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}
</style>