<script setup>

import { ref } from 'vue'

const questions = [
    {
        answer: 'Lingkaran',
        emoji: '🔴',
        options: [
            'Persegi',
            'Lingkaran',
            'Bintang',
            'Segitiga',
        ],
    },
    {
        answer: 'Segitiga',
        emoji: '🔺',
        options: [
            'Hati',
            'Persegi',
            'Segitiga',
            'Lingkaran',
        ],
    },
    {
        answer: 'Bintang',
        emoji: '⭐',
        options: [
            'Bintang',
            'Persegi Panjang',
            'Hati',
            'Lingkaran',
        ],
    },
    {
        answer: 'Hati',
        emoji: '❤️',
        options: [
            'Segitiga',
            'Lingkaran',
            'Hati',
            'Persegi',
        ],
    },
    {
        answer: 'Persegi',
        emoji: '🟦',
        options: [
            'Persegi Panjang',
            'Bintang',
            'Persegi',
            'Hati',
        ],
    },
]

const currentQuestionIndex = ref(0)
const selectedAnswer = ref('')
const answerStatus = ref('')
const quizFinished = ref(false)
const score = ref(0)

const currentQuestion = () => {
    return questions[currentQuestionIndex.value]
}

function selectAnswer(answer) {

    if (selectedAnswer.value) {
        return
    }

    selectedAnswer.value = answer

    if (answer === currentQuestion().answer) {

        answerStatus.value = 'correct'
        score.value += 20

    } else {

        answerStatus.value = 'wrong'

    }
}

function nextQuestion() {

    if (currentQuestionIndex.value < questions.length - 1) {

        currentQuestionIndex.value++
        selectedAnswer.value = ''
        answerStatus.value = ''

    } else {

        quizFinished.value = true

    }
}

function restartQuiz() {

    currentQuestionIndex.value = 0
    selectedAnswer.value = ''
    answerStatus.value = ''
    quizFinished.value = false
    score.value = 0

}

function goBack() {
    window.location.href = '/bentuk'
}

</script>

<template>

    <main class="shape-quiz">

        <template v-if="!quizFinished">

            <div class="shape-quiz__top">

                <button
                    type="button"
                    class="shape-quiz__home"
                    aria-label="Kembali ke belajar bentuk"
                    @click="goBack"
                >
                    🏠
                </button>

                <div class="shape-quiz__question-number">
                    Soal {{ currentQuestionIndex + 1 }} / {{ questions.length }}
                </div>

            </div>

            <section class="shape-quiz__content">

                <h1>
                    Bentuk Apakah Ini? 🔷
                </h1>

                <div class="shape-quiz__display">
                    {{ currentQuestion().emoji }}
                </div>

                <div class="shape-quiz__options">

                    <button
                        v-for="(option, index) in currentQuestion().options"
                        :key="option"
                        type="button"
                        class="shape-quiz__option"
                        :class="{
                            'shape-quiz__option--correct':
                                selectedAnswer && option === currentQuestion().answer,

                            'shape-quiz__option--wrong':
                                selectedAnswer === option &&
                                option !== currentQuestion().answer,
                        }"
                        @click="selectAnswer(option)"
                    >

                        <span class="shape-quiz__option-letter">
                            {{ String.fromCharCode(65 + index) }}
                        </span>

                        <span>
                            {{ option }}
                        </span>

                    </button>

                </div>

                <div
                    v-if="answerStatus"
                    class="shape-quiz__feedback"
                    :class="{
                        'shape-quiz__feedback--correct':
                            answerStatus === 'correct',

                        'shape-quiz__feedback--wrong':
                            answerStatus === 'wrong',
                    }"
                >

                    <span v-if="answerStatus === 'correct'">
                        🎉 Benar!
                    </span>

                    <span v-else>
                        😊 Belum tepat!
                    </span>

                </div>

                <button
                    v-if="selectedAnswer"
                    type="button"
                    class="shape-quiz__next"
                    @click="nextQuestion"
                >
                    <span>
                        {{ currentQuestionIndex === questions.length - 1
                            ? 'Lihat Hasil'
                            : 'Soal Berikutnya'
                        }}
                    </span>

                    <span>
                        →
                    </span>
                </button>

            </section>

        </template>

        <section
            v-else
            class="shape-quiz__finished"
        >

            <div class="shape-quiz__finished-icon">
                🎉
            </div>

            <h1>
                Quiz Selesai!
            </h1>

            <div class="shape-quiz__score">
                ⭐ {{ score }} / 100
            </div>

            <p>
                Kamu berhasil menjawab
                {{ score / 20 }} soal dengan benar!
            </p>

            <button
                type="button"
                class="shape-quiz__restart-button"
                @click="restartQuiz"
            >
                Coba Lagi
            </button>

        </section>

    </main>

</template>