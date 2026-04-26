<template>
    <div class="login-page">
        <div class="login-card">
            <h1>Вход в админ-панель</h1>

            <form @submit.prevent="submit">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        required
                        class="form-input"
                        placeholder="admin@example.com"
                    />
                    <span v-if="errors.email" class="error">{{ errors.email }}</span>
                </div>

                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        required
                        class="form-input"
                        placeholder="Введите пароль"
                    />
                    <span v-if="errors.password" class="error">{{ errors.password }}</span>
                </div>

                <button type="submit" class="login-btn" :disabled="processing">
                    {{ processing ? 'Вход...' : 'Войти' }}
                </button>
            </form>

            <Link href="/" class="back-link">На главную</Link>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { Link, useForm, router } from '@inertiajs/vue3'

const processing = ref(false)
const errors = ref({})

const form = useForm({
    email: '',
    password: '',
})

const submit = () => {
    processing.value = true
    errors.value = {}

    fetch('/api/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify(form),
    })
    .then(res => res.json())
    .then(data => {
        if (data.data && data.data.token) {
            localStorage.setItem('auth_token', data.data.token)

            router.visit('/admin/products')

        } else {
            errors.value = { email: data.message || 'Ошибка входа' }
        }
    })
    .catch(err => {
        errors.value = { email: 'Ошибка соединения' }
    })
    .finally(() => {
        processing.value = false
    })
}
</script>

<style scoped>
.login-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f9fafb;
    padding: 20px;
}

.login-card {
    background: white;
    padding: 40px;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 400px;
}

.login-card h1 {
    font-size: 24px;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0 0 30px;
    text-align: center;
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

.form-input {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 16px;
    box-sizing: border-box;
}

.form-input:focus {
    outline: none;
    border-color: #667eea;
}

.error {
    display: block;
    margin-top: 6px;
    color: #ef4444;
    font-size: 14px;
}

.login-btn {
    width: 100%;
    padding: 14px;
    background: #667eea;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 10px;
}

.login-btn:hover:not(:disabled) {
    background: #5a67d8;
}

.login-btn:disabled {
    opacity: 0.7;
}

.back-link {
    display: block;
    text-align: center;
    margin-top: 20px;
    color: #667eea;
    text-decoration: none;
}
</style>
