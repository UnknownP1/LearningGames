<script setup>

import { ref, computed } from 'vue'


/*
|--------------------------------------------------------------------------
| DATA HEWAN
|--------------------------------------------------------------------------
*/

const animals = {

    kucing: {
        name: 'Kucing',
        emoji: '🐱',
    },

    anjing: {
        name: 'Anjing',
        emoji: '🐶',
    },

    kelinci: {
        name: 'Kelinci',
        emoji: '🐰',
    },

    sapi: {
        name: 'Sapi',
        emoji: '🐮',
    },

    ayam: {
        name: 'Ayam',
        emoji: '🐔',
    },

    gajah: {
        name: 'Gajah',
        emoji: '🐘',
    },

}


/*
|--------------------------------------------------------------------------
| DATA QUIZ
|--------------------------------------------------------------------------
|
| Setiap soal mempunyai:
|
| - hewan yang harus ditebak
| - 4 pilihan jawaban
|
| Urutan pilihan dibuat berbeda-beda.
|--------------------------------------------------------------------------
*/

const questions = [

    {
        answer: animals.kucing,

        options: [
            animals.anjing,
            animals.kucing,
            animals.sapi,
            animals.kelinci,
        ],
    },


    {
        answer: animals.gajah,

        options: [
            animals.ayam,
            animals.gajah,
            animals.kucing,
            animals.sapi,
        ],
    },


    {
        answer: animals.kelinci,

        options: [
            animals.sapi,
            animals.anjing,
            animals.kelinci,
            animals.ayam,
        ],
    },


    {
        answer: animals.ayam,

        options: [
            animals.kucing,
            animals.ayam,
            animals.gajah,
            animals.anjing,
        ],
    },


    {
        answer: animals.anjing,

        options: [
            animals.kelinci,
            animals.sapi,
            animals.anjing,
            animals.gajah,
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

    return questions[
        currentQuestionIndex.value
    ]

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

function selectAnswer(animal) {

    // Jangan bisa memilih lagi setelah menjawab
    if (answerStatus.value !== null) {
        return
    }


    // Simpan jawaban
    selectedAnswer.value = animal


    // Cek jawaban
    if (
        animal.name ===
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
| KEMBALI KE PENGENALAN HEWAN
|--------------------------------------------------------------------------
*/

function goBack() {

    window.location.href = '/hewan'

}


/*
|--------------------------------------------------------------------------
| FEEDBACK
|--------------------------------------------------------------------------
*/

const feedbackMessage = computed(() => {

    if (
        answerStatus.value === 'correct'
    ) {

        return 'Benar! 🎉'

    }


    if (
        answerStatus.value === 'wrong'
    ) {

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


    return 'Selanjutnya'

})

</script>


<template>

    <main class="animal-quiz">


        <!-- TOP -->

        <div class="animal-quiz__top">


            <!-- HOME -->

            <button
                type="button"
                class="animal-quiz__icon-button"
                aria-label="Kembali ke pengenalan hewan"
                @click="goBack"
            >

                🏠

            </button>


            <!-- NOMOR SOAL -->

            <div class="animal-quiz__number">

                Soal {{ questionNumber }}
                / {{ questions.length }}

            </div>


        </div>


        <!-- QUIZ -->

        <template v-if="!quizFinished">


            <!-- TITLE -->

            <h1 class="animal-quiz__title">

                Hewan Apakah Ini? 🐾

            </h1>


            <!-- MAIN CONTENT -->

            <div class="animal-quiz__content">


                <!-- HEWAN -->

                <section class="animal-quiz__display">

                    <div class="animal-quiz__emoji">

                        {{ currentQuestion.answer.emoji }}

                    </div>

                </section>


                <!-- PILIHAN -->

                <div class="animal-quiz__answers">


                    <button
                        v-for="
                            animal in
                            currentQuestion.options
                        "
                        :key="animal.name"

                        type="button"

                        class="animal-quiz__answer"

                        :class="{

                            'animal-quiz__answer--selected':
                                selectedAnswer?.name ===
                                animal.name,

                            'animal-quiz__answer--correct':
                                answerStatus &&
                                animal.name ===
                                currentQuestion.answer.name,

                            'animal-quiz__answer--wrong':
                                selectedAnswer?.name ===
                                animal.name &&
                                answerStatus === 'wrong'

                        }"

                        @click="
                            selectAnswer(animal)
                        "
                    >

                        <span
                            class="animal-quiz__answer-emoji"
                        >

                            {{ animal.emoji }}

                        </span>


                        <span
                            class="animal-quiz__answer-name"
                        >

                            {{ animal.name }}

                        </span>

                    </button>


                </div>

            </div>


            <!-- FEEDBACK -->

            <div
                v-if="answerStatus"

                class="animal-quiz__feedback"

                :class="{

                    'animal-quiz__feedback--correct':
                        answerStatus === 'correct',

                    'animal-quiz__feedback--wrong':
                        answerStatus === 'wrong'

                }"
            >

                {{ feedbackMessage }}

            </div>


            <!-- NEXT -->

            <button
                v-if="answerStatus"

                type="button"

                class="animal-quiz__next-button"

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


        <!-- SELESAI -->
        
        <section
            v-else
            class="animal-quiz__finished"
        >
            <div class="animal-quiz__finished-icon">
                🎉
            </div>

            <h1>
                Quiz Selesai!
            </h1>

            <div class="animal-quiz__score">
                ⭐ {{ score }} / 100
            </div>

            <p>
                Kamu berhasil menjawab
                {{ score / 20 }} soal dengan benar!
            </p>

            <button
                type="button"
                class="animal-quiz__restart-button"
                @click="restartQuiz"
            >
                Coba Lagi

            </button>

        </section>


    </main>

</template>