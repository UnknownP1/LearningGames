<script setup>

import { ref } from 'vue'

import ShapeCard from '@/Components/Shapes/ShapeCard.vue'
import ShapeDisplay from '@/Components/Shapes/ShapeDisplay.vue'

const shapes = [
    {
        name: 'Lingkaran',
        emoji: '🔴',
    },
    {
        name: 'Persegi',
        emoji: '🟦',
    },
    {
        name: 'Segitiga',
        emoji: '🔺',
    },
    {
        name: 'Persegi Panjang',
        emoji: '🟨',
    },
    {
        name: 'Bintang',
        emoji: '⭐',
    },
    {
        name: 'Hati',
        emoji: '❤️',
    },
]

const currentShape = ref(shapes[0])
const message = ref('')

let messageTimer = null

function selectShape(shape) {
    currentShape.value = shape

    message.value = `Ini adalah ${shape.name.toLowerCase()}.`

    clearTimeout(messageTimer)

    messageTimer = setTimeout(() => {
        message.value = ''
    }, 2500)

    speakShape(shape)
}

function speakShape(shape) {
    if (!('speechSynthesis' in window)) {
        return
    }

    window.speechSynthesis.cancel()

    const speech = new SpeechSynthesisUtterance(shape.name)

    speech.lang = 'id-ID'
    speech.rate = 0.8
    speech.pitch = 1.15

    window.speechSynthesis.speak(speech)
}

function repeatName() {
    speakShape(currentShape.value)
}

function goHome() {
    window.location.href = '/'
}

function goToQuiz() {
    window.location.href = '/bentuk/quiz'
}

</script>

<template>

    <main class="shape-learning">

        <div class="shape-learning__top">

            <button
                type="button"
                class="shape-learning__icon-button"
                aria-label="Kembali ke menu utama"
                @click="goHome"
            >
                🏠
            </button>

            <div class="shape-learning__title">

                <h1>
                    Yuk Mengenal Bentuk! 🔷
                </h1>

                <p>
                    Pilih bentuk dan dengarkan namanya.
                </p>

            </div>

        </div>

        <ShapeDisplay
            :shape="currentShape"
            :message="message"
        />

        <button
            type="button"
            class="shape-learning__speaker"
            aria-label="Dengarkan nama bentuk"
            @click="repeatName"
        >
            🔊
        </button>

        <div class="shape-learning__cards">

            <ShapeCard
                v-for="shape in shapes"
                :key="shape.name"
                :shape="shape"
                @select="selectShape"
            />

        </div>

        <button
            type="button"
            class="shape-learning__quiz-button"
            @click="goToQuiz"
        >
            <span>
                Mulai Quiz
            </span>

            <span>
                →
            </span>
        </button>

    </main>

</template> 