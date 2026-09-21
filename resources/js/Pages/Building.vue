<script setup>

import { ref, computed } from 'vue'


/*
|--------------------------------------------------------------------------
| DATA BANGUNAN
|--------------------------------------------------------------------------
*/

const buildings = {

    hospital: {
        name: 'Rumah Sakit',
        emoji: '🏥',
    },

    police: {
        name: 'Kantor Polisi',
        emoji: '🚓',
    },

    fireStation: {
        name: 'Kantor Pemadam Kebakaran',
        emoji: '🚒',
    },

    school: {
        name: 'Sekolah',
        emoji: '🏫',
    },

    library: {
        name: 'Perpustakaan',
        emoji: '📚',
    },

    bank: {
        name: 'Bank',
        emoji: '🏦',
    },

}


/*
|--------------------------------------------------------------------------
| DATA QUIZ
|--------------------------------------------------------------------------
*/

const questions = [

    {
        answer: buildings.hospital,

        options: [
            buildings.school,
            buildings.hospital,
            buildings.bank,
            buildings.police,
        ],
    },


    {
        answer: buildings.fireStation,

        options: [
            buildings.police,
            buildings.library,
            buildings.fireStation,
            buildings.school,
        ],
    },


    {
        answer: buildings.police,

        options: [
            buildings.bank,
            buildings.police,
            buildings.hospital,
            buildings.fireStation,
        ],
    },


    {
        answer: buildings.school,

        options: [
            buildings.library,
            buildings.school,
            buildings.bank,
            buildings.hospital,
        ],
    },


    {
        answer: buildings.bank,

        options: [
            buildings.fireStation,
            buildings.hospital,
            buildings.bank,
            buildings.library,
        ],
    },

]


/*
|--------------------------------------------------------------------------
| STATE
|--------------------------------------------------------------------------
*/

const currentQuestionIndex = ref(0)

const selectedAnswer = ref(null)

const answerStatus = ref(null)

const quizFinished = ref(false)

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

function selectAnswer(building) {

    // Jangan bisa memilih lagi setelah menjawab
    if (answerStatus.value !== null) {
        return
    }


    // Simpan jawaban
    selectedAnswer.value = building


    // Cek jawaban
    if (
        building.name ===
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

    window.location.href = '/bangunan'

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

    <main class="building-quiz">


        <!-- TOP -->

        <div class="building-quiz__top">


            <!-- BACK -->

            <button
                type="button"
                class="building-quiz__icon-button"
                aria-label="Kembali ke pengenalan bangunan"
                @click="goBack"
            >

                🏠

            </button>


            <!-- NOMOR SOAL -->

            <div class="building-quiz__number">

                Soal {{ questionNumber }}
                / {{ questions.length }}

            </div>


        </div>


        <!-- QUIZ -->

        <template v-if="!quizFinished">


            <!-- TITLE -->

            <h1 class="building-quiz__title">

                Bangunan Apakah Ini? 🏢

            </h1>


            <!-- MAIN CONTENT -->

            <div class="building-quiz__content">


                <!-- BANGUNAN -->

                <section class="building-quiz__display">

                    <div class="building-quiz__emoji">

                        {{ currentQuestion.answer.emoji }}

                    </div>

                </section>


                <!-- PILIHAN -->

                <div class="building-quiz__answers">


                    <button
                        v-for="
                            (building, index) in
                            currentQuestion.options
                        "
                        :key="building.name"

                        type="button"

                        class="building-quiz__answer"

                        :class="{

                            'building-quiz__answer--selected':
                                selectedAnswer?.name ===
                                building.name,

                            'building-quiz__answer--correct':
                                answerStatus &&
                                building.name ===
                                currentQuestion.answer.name,

                            'building-quiz__answer--wrong':
                                selectedAnswer?.name ===
                                building.name &&
                                answerStatus === 'wrong'

                        }"

                        @click="
                            selectAnswer(building)
                        "
                    >

                        <!-- HURUF -->

                        <span class="building-quiz__answer-letter">

                            {{ String.fromCharCode(65 + index) }}.

                        </span>


                        <!-- EMOJI -->

                        <span class="building-quiz__answer-emoji">

                            {{ building.emoji }}

                        </span>


                        <!-- NAMA -->

                        <span class="building-quiz__answer-name">

                            {{ building.name }}

                        </span>

                    </button>


                </div>

            </div>


            <!-- FEEDBACK -->

            <div
                v-if="answerStatus"

                class="building-quiz__feedback"

                :class="{

                    'building-quiz__feedback--correct':
                        answerStatus === 'correct',

                    'building-quiz__feedback--wrong':
                        answerStatus === 'wrong'

                }"
            >

                {{ feedbackMessage }}

            </div>


            <!-- NEXT -->

            <button
                v-if="answerStatus"

                type="button"

                class="building-quiz__next-button"

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
            class="building-quiz__finished"
        >

            <div class="building-quiz__finished-icon">

                🎉

            </div>


            <h1>

                Quiz Selesai!

            </h1>


            <!-- SCORE -->

            <div class="building-quiz__score">

                ⭐ {{ score }} / 100

            </div>


            <p>

                Kamu berhasil menjawab
                {{ score / 20 }}
                soal dengan benar!

            </p>


            <!-- RESTART -->

            <button
                type="button"
                class="building-quiz__restart-button"
                @click="restartQuiz"
            >

                🔄 Coba Lagi

            </button>


        </section>


    </main>

</template>