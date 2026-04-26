<template>
    <div class="dark-app">
        <!-- Hero секция -->
        <div class="hero">
            <div class="hero-content">
                <div class="logo">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                </div>
                <h1 class="title">Laravel + Inertia + Vue + Sanctum</h1>
                <p class="subtitle">Современный стек для профессиональной разработки</p>
            </div>
        </div>

        <!-- Фичи -->
        <div class="features">
            <div class="features-grid">
                <div v-for="feature in features" :key="feature.title" class="feature-card">
                    <div class="feature-icon" v-html="feature.icon"></div>
                    <h3 class="feature-title">{{ feature.title }}</h3>
                    <p class="feature-desc">{{ feature.desc }}</p>
                </div>
            </div>
        </div>

        <!-- Демо счетчик -->
        <div class="demo">
            <div class="demo-card">
                <h3>Проверка реактивности</h3>
                <div class="counter">{{ count }}</div>
                <div class="counter-buttons">
                    <button @click="count--" class="counter-btn">-</button>
                    <button @click="count = 0" class="counter-btn reset">0</button>
                    <button @click="count++" class="counter-btn">+</button>
                </div>
                <p class="demo-note">Vue 3 Composition API работает!</p>
            </div>
        </div>

        <!-- Футер -->
        <footer class="footer">
            <p>Laravel Inertia Skeleton © {{ year }}</p>
        </footer>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

const count = ref(0)
const year = new Date().getFullYear()

const features = [
    {
        title: 'Без API',
        desc: 'Работай напрямую с Laravel, без создания отдельного API слоя',
        icon: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
    },
    {
        title: 'SPA навигация',
        desc: 'Мгновенные переходы без перезагрузки страницы',
        icon: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>'
    },
    {
        title: 'Vue 3 + SSR',
        desc: 'Composition API и серверный рендеринг из коробки',
        icon: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6z"/></svg>'
    }
]
</script>

<style scoped>
/* Reset */
.dark-app {
    width: 100vw;
    position:absolute;
    left:0;
    top:0;
    min-height: 100vh;
    background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 100%);
    color: #e0e0e0;
    font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
}

/* Hero */
.hero {
    padding: 80px 20px;
    text-align: center;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.hero-content {
    max-width: 800px;
    margin: 0 auto;
}

.logo {
    width: 80px;
    height: 80px;
    margin: 0 auto 24px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.logo svg {
    width: 48px;
    height: 48px;
    color: white;
}

.title {
    font-size: 48px;
    font-weight: 800;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    margin: 0 0 16px;
    letter-spacing: -0.5px;
}

.subtitle {
    font-size: 20px;
    color: #a0a0a0;
    margin: 0 0 32px;
}

.buttons {
    display: flex;
    gap: 16px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn {
    padding: 12px 32px;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    display: inline-block;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.4);
}

.btn-secondary {
    background: rgba(255,255,255,0.05);
    color: #e0e0e0;
    border: 1px solid rgba(255,255,255,0.1);
}

.btn-secondary:hover {
    background: rgba(255,255,255,0.1);
}

/* Features */
.features {
    padding: 60px 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
}

.feature-card {
    background: rgba(255,255,255,0.03);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 30px;
    text-align: center;
    border: 1px solid rgba(255,255,255,0.05);
    transition: all 0.3s;
}

.feature-card:hover {
    transform: translateY(-5px);
    background: rgba(255,255,255,0.05);
    border-color: rgba(102, 126, 234, 0.3);
}

.feature-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.feature-icon svg {
    width: 32px;
    height: 32px;
    color: white;
}

.feature-title {
    font-size: 22px;
    font-weight: 700;
    margin: 0 0 12px;
    color: white;
}

.feature-desc {
    color: #a0a0a0;
    line-height: 1.5;
    margin: 0;
}

/* Demo */
.demo {
    padding: 60px 20px;
    background: rgba(0,0,0,0.3);
}

.demo-card {
    max-width: 400px;
    margin: 0 auto;
    background: rgba(255,255,255,0.03);
    border-radius: 20px;
    padding: 40px;
    text-align: center;
    border: 1px solid rgba(255,255,255,0.05);
}

.demo-card h3 {
    font-size: 24px;
    margin: 0 0 24px;
    color: white;
}

.counter {
    font-size: 72px;
    font-weight: 800;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    margin: 0 0 24px;
}

.counter-buttons {
    display: flex;
    gap: 12px;
    justify-content: center;
    margin-bottom: 20px;
}

.counter-btn {
    width: 50px;
    height: 50px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 12px;
    color: white;
    font-size: 24px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.counter-btn:hover {
    background: rgba(102, 126, 234, 0.3);
    transform: scale(1.05);
}

.counter-btn.reset {
    width: auto;
    padding: 0 20px;
    font-size: 16px;
}

.demo-note {
    font-size: 14px;
    color: #667eea;
    margin: 0;
}

/* Footer */
.footer {
    text-align: center;
    padding: 30px 20px;
    border-top: 1px solid rgba(255,255,255,0.05);
    color: #666;
    font-size: 14px;
}

/* Responsive */
@media (max-width: 768px) {
    .title {
        font-size: 32px;
    }

    .subtitle {
        font-size: 16px;
    }

    .features-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .feature-card {
        padding: 20px;
    }

    .counter {
        font-size: 56px;
    }
}

@media (max-width: 480px) {
    .hero {
        padding: 50px 16px;
    }

    .buttons {
        flex-direction: column;
    }

    .btn {
        width: 100%;
        text-align: center;
    }

    .demo-card {
        padding: 24px;
    }
}
</style>
