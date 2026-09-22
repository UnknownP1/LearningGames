<script setup>

import { ref } from 'vue'


/*
|--------------------------------------------------------------------------
| DATA SOAL
|--------------------------------------------------------------------------
*/

const questions = [
    {
        answer: 'Merah',

        color: '#ef3b3b',

        options: [
            'Biru',
            'Merah',
            'Kuning',
            'Hijau',
        ],
    },

    {
        answer: 'Biru',

        color: '#3199e8',

        options: [
            'Hijau',
            'Kuning',
            'Biru',
            'Ungu',
        ],
    },

    {
        answer: 'Kuning',

        color: '#ffd22e',

        options: [
            'Pink',
            'Merah',
            'Kuning',
            'Biru',
        ],
    },

    {
        answer: 'Hijau',

        color: '#45b94b',

        options: [
            'Ungu',
            'Hijau',
            'Biru',
            'Merah',
        ],
    },

    {
        answer: 'Ungu',

        color: '#9a55d5',

        options: [
            'Kuning',
            'Pink',
            'Ungu',
            'Hijau',
        ],
    },
]


/*
|--------------------------------------------------------------------------
| STATE
|--------------------------------------------------------------------------
*/

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
    return questions[
        currentQuestionIndex.value
    ]
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

    window.location.href = '/warna'

}


/*
|--------------------------------------------------------------------------
| PILIH JAWABAN
|--------------------------------------------------------------------------
*/

function selectAnswer(answer) {

    // Tidak bisa memilih lagi
    // setelah jawaban dipilih
    if (selectedAnswer.value) {
        return
    }


    // Simpan jawaban
    selectedAnswer.value = answer


    // Cek jawaban
    if (
        answer ===
        currentQuestion().answer
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

    if (
        currentQuestionIndex.value
        <
        questions.length - 1
    ) {

        currentQuestionIndex.value++

        selectedAnswer.value = ''

        answerStatus.value = ''

    } else {

        quizFinished.value = true

    }

}


/*
|--------------------------------------------------------------------------
| RESTART QUIZ
|--------------------------------------------------------------------------
*/

function restartQuiz() {

    currentQuestionIndex.value = 0

    selectedAnswer.value = ''

    answerStatus.value = ''

    quizFinished.value = false

    score.value = 0

}

</script>


<template>

    <main class="color-quiz">


        <!-- =====================================================
             QUIZ
        ====================================================== -->

        <template v-if="!quizFinished">


            <!-- =================================================
                 TOP
            ================================================== -->

            <div class="color-quiz__top">


                <!-- HOME -->

                <button
                    type="button"

                    class="color-quiz__icon-button"

                    aria-label="Kembali ke menu utama"

                    @click="goHome"
                >

                    🏠

                </button>


                <!-- QUESTION NUMBER -->

                <div class="color-quiz__number">

                    Soal
                    {{ currentQuestionIndex + 1 }}
                    /
                    {{ questions.length }}

                </div>


            </div>


            <!-- =================================================
                 MAIN CARD
            ================================================== -->

            <section class="color-quiz__card">


                <!-- TITLE -->

                <h1 class="color-quiz__title">

                    Warna Apakah Ini? 🌈

                </h1>


                <!-- =================================================
                     COLOR DISPLAY
                ================================================== -->

                <div class="color-quiz__display">

                    <div
                        class="color-quiz__color"

                        :style="{
                            backgroundColor:
                                currentQuestion().color
                        }"
                    >
                    </div>

                </div>


                <!-- =================================================
                     ANSWERS
                ================================================== -->

                <div class="color-quiz__answers">


                    <button
                        v-for="(
                            option,
                            index
                        ) in currentQuestion().options"

                        :key="option"

                        type="button"

                        class="color-quiz__answer"

                        :class="{

                            'color-quiz__answer--correct':
                                selectedAnswer &&
                                option ===
                                currentQuestion().answer,

                            'color-quiz__answer--wrong':
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


                        <!-- LETTER A / B / C / D -->

                        <span
                            class="
                                color-quiz__answer-letter
                            "
                        >

                            {{
                                String.fromCharCode(
                                    65 + index
                                )
                            }}

                        </span>


                        <!-- COLOR DOT -->

                        <span
                            class="
                                color-quiz__answer-color
                            "

                            :style="{
                                backgroundColor:
                                    option === 'Merah'
                                        ? '#ef3b3b'
                                        : option === 'Biru'
                                            ? '#3199e8'
                                            : option === 'Kuning'
                                                ? '#ffd22e'
                                                : option === 'Hijau'
                                                    ? '#45b94b'
                                                    : option === 'Ungu'
                                                        ? '#9a55d5'
                                                        : '#f36fa5'
                            }"
                        >
                        </span>


                        <!-- ANSWER NAME -->

                        <span
                            class="
                                color-quiz__answer-name
                            "
                        >

                            {{ option }}

                        </span>


                    </button>


                </div>


                <!-- =================================================
                     FEEDBACK
                ================================================== -->

                <div
                    v-if="selectedAnswer"

                    class="color-quiz__feedback"

                    :class="{

                        'color-quiz__feedback--correct':
                            answerStatus === 'correct',

                        'color-quiz__feedback--wrong':
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
                     NEXT BUTTON
                ================================================== -->

                <button
                    v-if="selectedAnswer"

                    type="button"

                    class="color-quiz__next-button"

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

            class="color-quiz__finished"
        >


            <!-- ICON -->

            <div class="color-quiz__finished-icon">

                🎉

            </div>


            <!-- TITLE -->

            <h1>

                Quiz Selesai!

            </h1>


            <!-- SCORE -->

            <div class="color-quiz__score">

                ⭐ {{ score }} / 100

            </div>


            <!-- DESCRIPTION -->

            <p>

                Kamu berhasil menjawab
                {{ score / 20 }}
                soal dengan benar!

            </p>


            <!-- =================================================
                 FINISHED BUTTONS
            ================================================== -->

            <div class="color-quiz__finished-actions">


                <!-- HOME -->

                <button
                    type="button"

                    class="
                        color-quiz__finished-button
                    "

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

                    class="
                        color-quiz__finished-button
                    "

                    @click="goToLearning"
                >

                    <span>

                        

                    </span>


                    <span>

                        Kembali ke Pembelajaran

                    </span>

                </button>


            </div>


        </section>


    </main>

</template>