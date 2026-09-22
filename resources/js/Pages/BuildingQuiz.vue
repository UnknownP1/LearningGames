<script setup>
import { ref, computed } from 'vue'

const questions = [
    {
        answer: 'Rumah Sakit',
        emoji: '🏥',
        image: '',
        options: [
            'Sekolah',
            'Rumah Sakit',
            'Bank',
            'Kantor Polisi',
        ],
    },
    {
        answer: 'Kantor Polisi',
        emoji: '🚓',
        image: '/images/PoliceStation.png',
        options: [
            'Kantor Polisi',
            'Perpustakaan',
            'Sekolah',
            'Kantor Pemadam Kebakaran',
        ],
    },
    {
        answer: 'Kantor Pemadam Kebakaran',
        emoji: '🚒',
        image: '/images/FireStation.png',
        options: [
            'Bank',
            'Rumah Sakit',
            'Kantor Pemadam Kebakaran',
            'Kantor Polisi',
        ],
    },
    {
        answer: 'Sekolah',
        emoji: '🏫',
        image: '',
        options: [
            'Perpustakaan',
            'Sekolah',
            'Bank',
            'Rumah Sakit',
        ],
    },
    {
        answer: 'Perpustakaan',
        emoji: '📚',
        image: '/images/Library.png',
        options: [
            'Kantor Polisi',
            'Bank',
            'Perpustakaan',
            'Sekolah',
        ],
    },
]

const currentQuestion = ref(0)
const selectedAnswer = ref(null)
const score = ref(0)
const showResult = ref(false)

const question = computed(() => questions[currentQuestion.value])

const isAnswered = computed(() => selectedAnswer.value !== null)

const isCorrect = computed(() => {
    return selectedAnswer.value === question.value.answer
})

function selectAnswer(answer) {
    if (selectedAnswer.value !== null) return

    selectedAnswer.value = answer

    if (answer === question.value.answer) {
        score.value += 20
    }
}

function nextQuestion() {
    if (!isAnswered.value) return

    if (currentQuestion.value < questions.length - 1) {
        currentQuestion.value++
        selectedAnswer.value = null
    } else {
        showResult.value = true
    }
}

function goHome() {
    window.location.href = '/'
}

function goToLearning() {
    window.location.href = '/bangunan'
}
</script>

<template>
    <main class="building-quiz">
        <!-- TOP -->
        <header class="building-quiz__top">
            <button
                type="button"
                class="building-quiz__home-button"
                @click="goHome"
            >
                🏠
            </button>

            <div class="building-quiz__progress">
                Soal {{ currentQuestion + 1 }} / {{ questions.length }}
            </div>
        </header>

        <!-- QUIZ -->
        <section
            v-if="!showResult"
            class="building-quiz__card"
        >
            <h1 class="building-quiz__title">
                Bangunan Apakah Ini? 🏠
            </h1>

            <!-- DISPLAY -->
            <div class="building-quiz__display">
                <img
                    v-if="question.image"
                    :src="question.image"
                    :alt="question.answer"
                    class="building-quiz__display-image"
                />

                <div
                    v-else
                    class="building-quiz__display-emoji"
                >
                    {{ question.emoji }}
                </div>
            </div>

            <!-- ANSWERS -->
            <div class="building-quiz__answers">
                <button
                    v-for="(option, index) in question.options"
                    :key="option"
                    type="button"
                    class="building-quiz__answer"
                    :class="{
                        'building-quiz__answer--selected':
                            selectedAnswer === option,
                        'building-quiz__answer--correct':
                            selectedAnswer !== null &&
                            option === question.answer,
                        'building-quiz__answer--wrong':
                            selectedAnswer === option &&
                            option !== question.answer,
                    }"
                    @click="selectAnswer(option)"
                >
                    <span class="building-quiz__answer-letter">
                        {{ String.fromCharCode(65 + index) }}
                    </span>

                    <span class="building-quiz__answer-name">
                        {{ option }}
                    </span>
                </button>
            </div>

            <!-- FEEDBACK -->
            <div
                v-if="isAnswered"
                class="building-quiz__feedback"
                :class="{
                    'building-quiz__feedback--correct': isCorrect,
                    'building-quiz__feedback--wrong': !isCorrect,
                }"
            >
                <template v-if="isCorrect">
                    🎉 Benar!
                </template>

                <template v-else>
                    😊 Belum tepat!
                </template>
            </div>

            <!-- NEXT -->
            <button
                type="button"
                class="building-quiz__next-button"
                :disabled="!isAnswered"
                @click="nextQuestion"
            >
                <span>
                    {{
                        currentQuestion === questions.length - 1
                            ? 'Lihat Hasil'
                            : 'Soal Berikutnya'
                    }}
                </span>

                <span>→</span>
            </button>
        </section>

        <!-- RESULT -->
        <section
            v-else
            class="building-quiz__result"
        >
            <div class="building-quiz__result-card">
                <h1 class="building-quiz__result-title">
                    🎉 Quiz Selesai!
                </h1>

                <p class="building-quiz__result-score">
                    {{ score }} / 100
                </p>

                <p class="building-quiz__result-correct">
                    Benar {{ score / 20 }} dari {{ questions.length }} soal
                </p>

                <div class="building-quiz__result-actions">
                    <button
                        type="button"
                        class="building-quiz__result-button"
                        @click="goHome"
                    >
                        🏠 Home
                    </button>

                    <button
                        type="button"
                        class="building-quiz__result-button"
                        @click="goToLearning"
                    >
                        Kembali ke Pembelajaran
                    </button>
                </div>
            </div>
        </section>
    </main>
</template>