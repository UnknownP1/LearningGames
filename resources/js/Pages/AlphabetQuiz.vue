<script setup>

import { ref, computed, onMounted, onBeforeUnmount } from 'vue'

/*
|--------------------------------------------------------------------------
| KONSTANTA
|--------------------------------------------------------------------------
*/

const TOTAL_QUESTIONS = 5

const LETTERS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('')

const LETTER_SPEECH = {
    A: 'a',                C: 'ce',   D: 'de',
    E: 'e',    F: 'ef',   G: 'ge',   H: 'ha',
    I: 'iii',  J: 'je',   K: 'ka',   L: 'el',
    M: 'em',   N: 'en',   O: 'o',
    Q: 'kiu',  R: 'er',   S: 'es',   T: 'te',
    U: 'u',    V: 've',              X: 'eks',
    Y: 'ye',   Z: 'zet',
}

/*
|--------------------------------------------------------------------------
| UTIL
|--------------------------------------------------------------------------
*/

function shuffle(array) {
    const a = [...array]

    for (let i = a.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1))
        ;[a[i], a[j]] = [a[j], a[i]]
    }

    return a
}

function buildQuestions() {
    const picked = shuffle(LETTERS).slice(0, TOTAL_QUESTIONS)

    return picked.map((correct) => {
        const others = LETTERS.filter((l) => l !== correct)
        const distractors = shuffle(others).slice(0, 3)

        return {
            answer: correct,
            options: shuffle([correct, ...distractors]),
        }
    })
}


/*
|--------------------------------------------------------------------------
| STATE
|--------------------------------------------------------------------------
*/

const questions = ref([])
const currentQuestionIndex = ref(0)
const selectedAnswer = ref('')
const answerStatus = ref('')
const quizFinished = ref(false)
const correctCount = ref(0)

const score = computed(() => {
    if (!questions.value.length) return 0
    return Math.round((correctCount.value / questions.value.length) * 100)
})


/*
|--------------------------------------------------------------------------
| VOICE
|--------------------------------------------------------------------------
*/

let indonesianVoice = null

function loadVoices() {
    if (typeof window === 'undefined') return
    if (!('speechSynthesis' in window)) return

    const voices = window.speechSynthesis.getVoices()
    if (!voices.length) return

    indonesianVoice =
        voices.find((v) => v.lang === 'id-ID') ||
        voices.find((v) => v.lang.toLowerCase().startsWith('id')) ||
        null
}

function speak(text) {
    if (typeof window === 'undefined') return
    if (!('speechSynthesis' in window)) return

    if (!indonesianVoice) loadVoices()

    window.speechSynthesis.cancel()

    const spoken = LETTER_SPEECH[text] || text

    const utterance = new SpeechSynthesisUtterance(spoken)

    utterance.lang = 'id-ID'
    utterance.rate = 0.85
    utterance.pitch = 1.1
    utterance.volume = 1.0

    if (indonesianVoice) utterance.voice = indonesianVoice

    window.speechSynthesis.speak(utterance)
}


/*
|--------------------------------------------------------------------------
| CURRENT
|--------------------------------------------------------------------------
*/

function currentQuestion() {
    return questions.value[currentQuestionIndex.value]
}

function playCurrentLetter() {
    if (!currentQuestion()) return
    speak(currentQuestion().answer)
}


/*
|--------------------------------------------------------------------------
| NAVIGASI
|--------------------------------------------------------------------------
*/

function goHome() {
    window.location.href = '/'
}

function goToLearning() {
    window.location.href = '/alphabet'
}


/*
|--------------------------------------------------------------------------
| JAWAB
|--------------------------------------------------------------------------
*/

function selectAnswer(answer) {
    if (selectedAnswer.value) return

    selectedAnswer.value = answer

    if (answer === currentQuestion().answer) {
        answerStatus.value = 'correct'
        correctCount.value++
    } else {
        answerStatus.value = 'wrong'
    }
}


/*
|--------------------------------------------------------------------------
| NEXT
|--------------------------------------------------------------------------
*/

function nextQuestion() {
    if (currentQuestionIndex.value < questions.value.length - 1) {
        currentQuestionIndex.value++
        selectedAnswer.value = ''
        answerStatus.value = ''

        setTimeout(() => playCurrentLetter(), 300)
    } else {
        quizFinished.value = true
    }
}


/*
|--------------------------------------------------------------------------
| RESTART
|--------------------------------------------------------------------------
*/

function restartQuiz() {
    questions.value = buildQuestions()
    currentQuestionIndex.value = 0
    selectedAnswer.value = ''
    answerStatus.value = ''
    quizFinished.value = false
    correctCount.value = 0

    setTimeout(() => playCurrentLetter(), 300)
}


/*
|--------------------------------------------------------------------------
| LIFECYCLE
|--------------------------------------------------------------------------
*/

onMounted(() => {
    if (typeof window !== 'undefined' && 'speechSynthesis' in window) {
        window.speechSynthesis.onvoiceschanged = loadVoices
        loadVoices()
    }

    questions.value = buildQuestions()

    setTimeout(() => playCurrentLetter(), 400)
})

onBeforeUnmount(() => {
    if (typeof window !== 'undefined' && 'speechSynthesis' in window) {
        window.speechSynthesis.onvoiceschanged = null
        window.speechSynthesis.cancel()
    }
})

</script>


<template>

    <main class="alphabet-quiz">

        <!-- =====================================================
             QUIZ
        ====================================================== -->

        <template v-if="!quizFinished && currentQuestion()">

            <div class="alphabet-quiz__top">

                <button
                    type="button"
                    class="alphabet-quiz__icon-button"
                    aria-label="Kembali ke menu utama"
                    @click="goHome"
                >
                    🏠
                </button>

                <div class="alphabet-quiz__number">
                    Soal {{ currentQuestionIndex + 1 }} / {{ questions.length }}
                </div>

            </div>

            <section class="alphabet-quiz__card">

                <h1 class="alphabet-quiz__title">
                    Huruf Apakah Ini? 🔤
                </h1>

                <div class="alphabet-quiz__display">

                    <button
                        type="button"
                        class="alphabet-quiz__speaker"
                        aria-label="Putar suara huruf"
                        @click="playCurrentLetter"
                    >
                        🔊
                    </button>

                </div>

                <div class="alphabet-quiz__answers">

                    <button
                        v-for="(option, index) in currentQuestion().options"
                        :key="option"
                        type="button"
                        class="alphabet-quiz__answer"
                        :class="{
                            'alphabet-quiz__answer--correct':
                                selectedAnswer &&
                                option === currentQuestion().answer,
                            'alphabet-quiz__answer--wrong':
                                selectedAnswer === option &&
                                option !== currentQuestion().answer,
                        }"
                        :disabled="!!selectedAnswer"
                        @click="selectAnswer(option)"
                    >

                        <span class="alphabet-quiz__answer-letter">
                            {{ String.fromCharCode(65 + index) }}
                        </span>

                        <span class="alphabet-quiz__answer-name">
                            <span class="alphabet-quiz__answer-upper">
                                {{ option }}
                            </span>
                            <span class="alphabet-quiz__answer-lower">
                                {{ option.toLowerCase() }}
                            </span>
                        </span>

                    </button>

                </div>

                <div
                    v-if="selectedAnswer"
                    class="alphabet-quiz__feedback"
                    :class="{
                        'alphabet-quiz__feedback--correct':
                            answerStatus === 'correct',
                        'alphabet-quiz__feedback--wrong':
                            answerStatus === 'wrong',
                    }"
                >
                    <span v-if="answerStatus === 'correct'">🎉 Benar!</span>
                    <span v-else>😊 Belum tepat!</span>
                </div>

                <button
                    v-if="selectedAnswer"
                    type="button"
                    class="alphabet-quiz__next-button"
                    @click="nextQuestion"
                >
                    <span>
                        {{ currentQuestionIndex === questions.length - 1
                            ? 'Lihat Hasil'
                            : 'Soal Berikutnya' }}
                    </span>
                    <span>→</span>
                </button>

            </section>

        </template>

        <!-- =====================================================
             FINISHED
        ====================================================== -->

            <section
                v-else
                class="number-quiz__finished"
            >

                <div class="number-quiz__finished-icon">🎉</div>

                <h1>Quiz Selesai!</h1>

                <div class="number-quiz__score">
                    ⭐ {{ score }} / 100
                </div>

                <p>
                    Kamu berhasil menjawab
                    {{ correctCount }}
                    dari
                    {{ questions.length }}
                    soal dengan benar!
                </p>

                <div class="number-quiz__finished-actions">

                    <button
                        type="button"
                        class="number-quiz__finished-button"
                        @click="goHome"
                    >
                        <span>🏠</span>
                        <span>Home</span>
                    </button>

                    <button
                        type="button"
                        class="number-quiz__finished-button"
                        @click="goToLearning"
                    >
                        <span>Kembali ke Pembelajaran</span>
                    </button>

                </div>

</section>

    </main>

</template>