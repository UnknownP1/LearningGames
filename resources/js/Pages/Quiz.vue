<script setup>
import { ref, computed } from 'vue'


/*
|--------------------------------------------------------------------------
| DATA WARNA
|--------------------------------------------------------------------------
*/

const colors = {
    merah: {
        name: 'Merah',
        hex: '#ef3b3b',
    },

    biru: {
        name: 'Biru',
        hex: '#3199e8',
    },

    kuning: {
        name: 'Kuning',
        hex: '#ffd22e',
    },

    hijau: {
        name: 'Hijau',
        hex: '#45b94b',
    },

    ungu: {
        name: 'Ungu',
        hex: '#9a55d5',
    },

    pink: {
        name: 'Pink',
        hex: '#f36fa5',
    },
}


/*
|--------------------------------------------------------------------------
| DATA QUIZ
|--------------------------------------------------------------------------
|
| Setiap soal mempunyai:
|
| - warna yang harus ditebak
| - 4 pilihan jawaban
|
| Urutan pilihan sengaja dibuat berbeda-beda.
|--------------------------------------------------------------------------
*/

const questions = [

    {
        answer: colors.merah,

        options: [
            colors.hijau,
            colors.merah,
            colors.biru,
            colors.kuning,
        ],
    },

    {
        answer: colors.pink,

        options: [
            colors.biru,
            colors.pink,
            colors.ungu,
            colors.hijau,
        ],
    },

    {
        answer: colors.biru,

        options: [
            colors.kuning,
            colors.hijau,
            colors.merah,
            colors.biru,
        ],
    },

    {
        answer: colors.kuning,

        options: [
            colors.ungu,
            colors.kuning,
            colors.pink,
            colors.merah,
        ],
    },

    {
        answer: colors.ungu,

        options: [
            colors.hijau,
            colors.kuning,
            colors.ungu,
            colors.biru,
        ],
    },

]


/*
|--------------------------------------------------------------------------
| STATE
|--------------------------------------------------------------------------
*/

// Nomor soal saat ini
const currentQuestionIndex = ref(0)

// Jawaban yang dipilih
const selectedAnswer = ref(null)

// Status jawaban
const answerStatus = ref(null)

// Apakah quiz sudah selesai
const quizFinished = ref(false)

// Status Score

const score = ref(0)


/*
|--------------------------------------------------------------------------
| SOAL SAAT INI
|--------------------------------------------------------------------------
*/

const currentQuestion = computed(() => {
    return questions[currentQuestionIndex.value]
})


/*
|--------------------------------------------------------------------------
| NOMOR SOAL
|--------------------------------------------------------------------------
*/

const questionNumber = computed(() => {
    return currentQuestionIndex.value + 1
})


/*
|--------------------------------------------------------------------------
| PILIH JAWABAN
|--------------------------------------------------------------------------
*/

function selectAnswer(color) {

    // Jangan bisa memilih setelah menjawab
    if (answerStatus.value !== null) {
        return
    }

    // Simpan pilihan
    selectedAnswer.value = color


    // Cek jawaban
    if (
        color.name ===
        currentQuestion.value.answer.name
    ) {

        answerStatus.value = 'correct'
        score.value += 20

    } else {

        answerStatus.value = 'wrong'
    }
}


/*
|--------------------------------------------------------------------------
| SOAL BERIKUTNYA
|--------------------------------------------------------------------------
*/

function nextQuestion() {

    // Kalau masih ada soal
    if (
        currentQuestionIndex.value <
        questions.length - 1
    ) {

        currentQuestionIndex.value++

        selectedAnswer.value = null

        answerStatus.value = null

        return
    }


    // Kalau sudah soal terakhir
    quizFinished.value = true
}


/*
|--------------------------------------------------------------------------
| ULANGI QUIZ
|--------------------------------------------------------------------------
*/

function restartQuiz() {

    currentQuestionIndex.value = 0

    selectedAnswer.value = null

    answerStatus.value = null

    quizFinished.value = false

    score.value = 0
}


/*
|--------------------------------------------------------------------------
| KEMBALI KE BELAJAR
|--------------------------------------------------------------------------
*/

function goBack() {
    window.location.href = '/warna'
}


/*
|--------------------------------------------------------------------------
| FEEDBACK
|--------------------------------------------------------------------------
*/

const feedbackMessage = computed(() => {

    if (answerStatus.value === 'correct') {
        return 'Benar! 🎉'
    }

    if (answerStatus.value === 'wrong') {
        return 'Belum tepat 😊'
    }

    return ''
})


/*
|--------------------------------------------------------------------------
| TEKS TOMBOL
|--------------------------------------------------------------------------
*/

const nextButtonText = computed(() => {

    if (
        currentQuestionIndex.value ===
        questions.length - 1
    ) {
        return 'Selesai'
    }

    return 'Next'
})

</script>


<template>

    <main class="color-quiz">


        <!-- ========================================
             TOP
        ========================================= -->

        <div class="color-quiz__top">

            <button
                type="button"
                class="color-quiz__icon-button"
                aria-label="Kembali ke belajar warna"
                @click="goBack"
            >
                🏠
            </button>


            <div class="color-quiz__number">
                Soal {{ questionNumber }} / {{ questions.length }}
            </div>

        </div>


        <!-- ========================================
             QUIZ
        ========================================= -->

        <template v-if="!quizFinished">


            <!-- TITLE -->

            <h1 class="color-quiz__title">
                Warna Apakah Ini? 🎨
            </h1>


            <!-- MAIN AREA -->

            <div class="color-quiz__content">


                <!-- ==================================
                     WARNA YANG HARUS DITEBAK
                =================================== -->

                <section class="color-quiz__display">

                    <div
                        class="color-quiz__swatch"
                        :style="{
                            backgroundColor:
                                currentQuestion.answer.hex
                        }"
                    ></div>

                </section>


                <!-- ==================================
                     PILIHAN JAWABAN
                =================================== -->

                <div class="color-quiz__answers">

                    <button
                        v-for="color in currentQuestion.options"
                        :key="color.name"
                        type="button"
                        class="color-quiz__answer"

                        :class="{

                            'color-quiz__answer--selected':
                                selectedAnswer?.name ===
                                color.name,

                            'color-quiz__answer--correct':
                                answerStatus &&
                                color.name ===
                                currentQuestion.answer.name,

                            'color-quiz__answer--wrong':
                                selectedAnswer?.name ===
                                color.name &&
                                answerStatus === 'wrong'

                        }"

                        @click="selectAnswer(color)"
                    >

                        <span
                            class="color-quiz__answer-dot"
                            :style="{
                                backgroundColor:
                                    color.hex
                            }"
                        ></span>

                        <span class="color-quiz__answer-name">
                            {{ color.name }}
                        </span>

                    </button>

                </div>

            </div>


            <!-- ========================================
                 FEEDBACK
            ========================================= -->

            <div
                v-if="answerStatus"
                class="color-quiz__feedback"

                :class="{
                    'color-quiz__feedback--correct':
                        answerStatus === 'correct',

                    'color-quiz__feedback--wrong':
                        answerStatus === 'wrong'
                }"
            >
                {{ feedbackMessage }}
            </div>


            <!-- ========================================
                 NEXT BUTTON
            ========================================= -->

            <button
                v-if="answerStatus"
                type="button"
                class="color-quiz__next-button"
                @click="nextQuestion"
            >
                <span>
                    {{ nextButtonText }}
                </span>

                <span>
                    →
                </span>
            </button>


        </template>


        <!-- ========================================
             QUIZ SELESAI
        ========================================= -->

        <section
            v-else
            class="quiz__finished"
        >
            <div class="quiz__finished-icon">
                🎉
            </div>

            <h1>
                Quiz Selesai!
            </h1>

            <div class="quiz__score">
                ⭐ {{ score }} / 100
            </div>

            <p>
                Kamu berhasil menjawab
                {{ score / 20 }} soal dengan benar!
            </p>

            <button
                type="button"
                class="quiz__restart-button"
                @click="restartQuiz"
            >
                Coba Lagi
            </button>
        </section>


    </main>

</template>