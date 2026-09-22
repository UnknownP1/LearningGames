<script setup>

import { ref } from 'vue'


/*
|--------------------------------------------------------------------------
| DATA SOAL
|--------------------------------------------------------------------------
*/

const questions = [
    {
        answer: 'Kucing',

        emoji: '🐱',

        options: [
            'Anjing',
            'Kucing',
            'Sapi',
            'Kelinci',
        ],
    },

    {
        answer: 'Gajah',

        emoji: '🐘',

        options: [
            'Ayam',
            'Gajah',
            'Kucing',
            'Sapi',
        ],
    },

    {
        answer: 'Kelinci',

        emoji: '🐰',

        options: [
            'Sapi',
            'Anjing',
            'Kelinci',
            'Ayam',
        ],
    },

    {
        answer: 'Ayam',

        emoji: '🐔',

        options: [
            'Kucing',
            'Ayam',
            'Gajah',
            'Anjing',
        ],
    },

    {
        answer: 'Anjing',

        emoji: '🐶',

        options: [
            'Kelinci',
            'Sapi',
            'Anjing',
            'Gajah',
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

    window.location.href = '/hewan'

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
| RESTART
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

    <main class="animal-quiz">


        <!-- =====================================================
             QUIZ
        ====================================================== -->

        <template v-if="!quizFinished">


            <!-- =================================================
                 TOP
            ================================================== -->

            <div class="animal-quiz__top">


                <!-- HOME -->

                <button
                    type="button"

                    class="animal-quiz__icon-button"

                    aria-label="Kembali ke menu utama"

                    @click="goHome"
                >

                    🏠

                </button>


                <!-- QUESTION NUMBER -->

                <div class="animal-quiz__number">

                    Soal
                    {{ currentQuestionIndex + 1 }}
                    /
                    {{ questions.length }}

                </div>


            </div>


            <!-- =================================================
                 MAIN CARD
            ================================================== -->

            <section class="animal-quiz__card">


                <!-- TITLE -->

                <h1 class="animal-quiz__title">

                    Hewan Apakah Ini? 🐾

                </h1>


                <!-- =================================================
                     DISPLAY
                ================================================== -->

                <div class="animal-quiz__display">

                    <div class="animal-quiz__emoji">

                        {{ currentQuestion().emoji }}

                    </div>

                </div>


                <!-- =================================================
                     ANSWERS
                ================================================== -->

                <div class="animal-quiz__answers">


                    <button
                        v-for="(
                            option,
                            index
                        ) in currentQuestion().options"

                        :key="option"

                        type="button"

                        class="animal-quiz__answer"

                        :class="{

                            'animal-quiz__answer--correct':
                                selectedAnswer &&
                                option ===
                                currentQuestion().answer,

                            'animal-quiz__answer--wrong':
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


                        <!-- LETTER -->

                        <span
                            class="
                                animal-quiz__answer-letter
                            "
                        >

                            {{
                                String.fromCharCode(
                                    65 + index
                                )
                            }}

                        </span>


                        <!-- PURE TEXT -->

                        <span
                            class="
                                animal-quiz__answer-name
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

                    class="animal-quiz__feedback"

                    :class="{

                        'animal-quiz__feedback--correct':
                            answerStatus === 'correct',

                        'animal-quiz__feedback--wrong':
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

                    class="animal-quiz__next-button"

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

            class="animal-quiz__finished"
        >


            <!-- ICON -->

            <div class="animal-quiz__finished-icon">

                🎉

            </div>


            <!-- TITLE -->

            <h1>

                Quiz Selesai!

            </h1>


            <!-- SCORE -->

            <div class="animal-quiz__score">

                ⭐ {{ score }} / 100

            </div>


            <!-- DESCRIPTION -->

            <p>

                Kamu berhasil menjawab
                {{ score / 20 }}
                soal dengan benar!

            </p>


            <!-- =================================================
                 FINISHED ACTIONS
            ================================================== -->

            <div class="animal-quiz__finished-actions">


                <!-- HOME -->

                <button
                    type="button"

                    class="animal-quiz__finished-button"

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

                    class="animal-quiz__finished-button"

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