<script setup>

import { ref, onMounted, onBeforeUnmount } from 'vue'

/*
|--------------------------------------------------------------------------
| KONSTANTA
|--------------------------------------------------------------------------
*/

const TOTAL_QUESTIONS = 10
const LETTERS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('')


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


/*
|--------------------------------------------------------------------------
| BUILD QUESTIONS
|--------------------------------------------------------------------------
*/

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

const score = ref(0)


/*
|--------------------------------------------------------------------------
| CURRENT QUESTION
|--------------------------------------------------------------------------
*/

function currentQuestion() {
    return questions.value[currentQuestionIndex.value]
}


/* ========================================================================
   SPEECH
   ======================================================================== */

let indonesianVoice = null

function loadVoices() {
    if (
        typeof window === 'undefined' ||
        !('speechSynthesis' in window)
    ) return

    const voices = window.speechSynthesis.getVoices()

    if (!voices.length) return

    // Prioritas: id-ID → id-* (case-insensitive) → null
    indonesianVoice =
        voices.find((v) => v.lang === 'id-ID') ||
        voices.find((v) => v.lang.toLowerCase().startsWith('id')) ||
        null
}

function speak(text) {
    if (
        typeof window === 'undefined' ||
        !('speechSynthesis' in window)
    ) return

    // Kalau voice belum ke-load, coba load dulu
    if (!indonesianVoice) loadVoices()

    window.speechSynthesis.cancel()

    const utterance = new SpeechSynthesisUtterance(text)

    utterance.lang = 'id-ID'
    utterance.rate = 0.85
    utterance.pitch = 1.1

    // Kalau ada voice Indonesia, kunci pakai voice itu
    if (indonesianVoice) {
        utterance.voice = indonesianVoice
    }

    window.speechSynthesis.speak(utterance)
}

function playCurrentLetter() {
    if (!currentQuestion()) return

    speak(currentQuestion().answer)
}


/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

function goHome() {
    window.location.href = '/'
}


/*
|--------------------------------------------------------------------------
| KEMBALI KE PEMBELAJARAN
|--------------------------------------------------------------------------
*/

function goToLearning() {
    window.location.href = '/alphabet'
}


/*
|--------------------------------------------------------------------------
| PILIH JAWABAN
|--------------------------------------------------------------------------
*/

function selectAnswer(answer) {
    // Tidak bisa memilih lagi
    if (selectedAnswer.value) {
        return
    }

    // Simpan jawaban
    selectedAnswer.value = answer

    // Cek jawaban
    if (answer === currentQuestion().answer) {
        answerStatus.value = 'correct'

        score.value += 10
    } else {
        answerStatus.value = 'wrong'
    }

    // Requirement: TIDAK replay suara setelah memilih
}


/*
|--------------------------------------------------------------------------
| SOAL BERIKUTNYA
|--------------------------------------------------------------------------
*/

function nextQuestion() {
    if (currentQuestionIndex.value < questions.value.length - 1) {
        currentQuestionIndex.value++

        selectedAnswer.value = ''

        answerStatus.value = ''

        // Auto-play huruf baru
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

    score.value = 0

    setTimeout(() => playCurrentLetter(), 300)
}


/*
|--------------------------------------------------------------------------
| LIFECYCLE
|--------------------------------------------------------------------------
*/

onMounted(() => {
    // Register voice listener (dipanggil saat browser selesai load voices)
    if (typeof window !== 'undefined' && 'speechSynthesis' in window) {
        window.speechSynthesis.onvoiceschanged = loadVoices
        loadVoices() // panggil sekali untuk keamanan
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

        <template v-if="!quizFinished">


            <!-- =================================================
                 TOP
            ================================================== -->

            <div class="alphabet-quiz__top">


                <!-- HOME -->

                <button
                    type="button"

                    class="alphabet-quiz__icon-button"

                    aria-label="Kembali ke menu utama"

                    @click="goHome"
                >

                    🏠

                </button>


                <!-- QUESTION NUMBER -->

                <div class="alphabet-quiz__number">

                    Soal
                    {{ currentQuestionIndex + 1 }}
                    /
                    {{ questions.length }}

                </div>


            </div>


            <!-- =================================================
                 MAIN CARD
            ================================================== -->

            <section
                v-if="currentQuestion()"
                class="alphabet-quiz__card"
            >


                <!-- TITLE -->

                <h1 class="alphabet-quiz__title">

                    Huruf Apakah Ini? 🔤

                </h1>


                <!-- =================================================
                     DISPLAY (SPEAKER)
                ================================================== -->

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


                <!-- =================================================
                     ANSWERS
                ================================================== -->

                <div class="alphabet-quiz__answers">


                    <button
                        v-for="(
                            option,
                            index
                        ) in currentQuestion().options"

                        :key="option"

                        type="button"

                        class="alphabet-quiz__answer"

                        :class="{

                            'alphabet-quiz__answer--correct':
                                selectedAnswer &&
                                option ===
                                currentQuestion().answer,

                            'alphabet-quiz__answer--wrong':
                                selectedAnswer === option &&
                                option !==
                                currentQuestion().answer

                        }"

                        :disabled="
                            !!selectedAnswer
                        "

                        @click="
                            selectAnswer(option)
                        "
                    >


                        <!-- LETTER (INDEX) -->

                        <span
                            class="
                                alphabet-quiz__answer-letter
                            "
                        >

                            {{
                                String.fromCharCode(
                                    65 + index
                                )
                            }}

                        </span>


                        <!-- LETTER PAIR -->

                        <span
                            class="
                                alphabet-quiz__answer-name
                            "
                        >

                            <span class="alphabet-quiz__answer-upper">

                                {{ option }}

                            </span>

                            <span class="alphabet-quiz__answer-lower">

                                {{ option.toLowerCase() }}

                            </span>

                        </span>


                    </button>


                </div>


                <!-- =================================================
                     FEEDBACK
                ================================================== -->

                <div
                    v-if="selectedAnswer"

                    class="alphabet-quiz__feedback"

                    :class="{

                        'alphabet-quiz__feedback--correct':
                            answerStatus === 'correct',

                        'alphabet-quiz__feedback--wrong':
                            answerStatus === 'wrong'

                    }"
                >

                    <span
                        v-if="
                            answerStatus === 'correct'
                        "
                    >

                        🎉 Benar!

                    </span>


                    <span v-else>

                        😊 Belum tepat!

                    </span>

                </div>


                <!-- =================================================
                     NEXT
                ================================================== -->

                <button
                    v-if="selectedAnswer"

                    type="button"

                    class="alphabet-quiz__next-button"

                    @click="nextQuestion"
                >

                    <span>

                        {{
                            currentQuestionIndex ===
                            questions.length - 1

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


        <!-- =====================================================
             FINISHED
        ====================================================== -->

        <section
            v-else

            class="alphabet-quiz__finished"
        >


            <!-- ICON -->

            <div class="alphabet-quiz__finished-icon">

                🎉

            </div>


            <!-- TITLE -->

            <h1>

                Quiz Selesai!

            </h1>


            <!-- SCORE -->

            <div class="alphabet-quiz__score">

                ⭐ {{ score }} / 100

            </div>


            <!-- DESCRIPTION -->

            <p>

                Kamu berhasil menjawab
                {{ score / 10 }}
                soal dengan benar!

            </p>


            <!-- =================================================
                 FINISHED ACTIONS
            ================================================== -->

            <div class="alphabet-quiz__finished-actions">


                <!-- HOME -->

                <button
                    type="button"

                    class="alphabet-quiz__finished-button"

                    @click="goHome"
                >

                    <span>

                        🏠

                    </span>


                    <span>

                        Home

                    </span>

                </button>


                <!-- KEMBALI KE PEMBELAJARAN -->

                <button
                    type="button"

                    class="alphabet-quiz__finished-button"

                    @click="goToLearning"
                >

                    <span>

                        Kembali ke Pembelajaran

                    </span>

                </button>


            </div>


        </section>


    </main>

</template>