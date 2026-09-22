<script setup>

import { ref } from 'vue'


/*
|--------------------------------------------------------------------------
| DATA SOAL
|--------------------------------------------------------------------------
*/

const questions = [
    {
        answer: 'Rumah Sakit',

        emoji: '🏥',

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

        options: [
            'Kantor Polisi',
            'Bank',
            'Perpustakaan',
            'Sekolah',
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

    window.location.href = '/bangunan'

}


/*
|--------------------------------------------------------------------------
| PILIH JAWABAN
|--------------------------------------------------------------------------
*/

function selectAnswer(answer) {

    // Tidak bisa memilih lagi
    // setelah satu jawaban dipilih
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

    <main class="building-quiz">


        <!-- =====================================================
             QUIZ
        ====================================================== -->

        <template v-if="!quizFinished">


            <!-- =================================================
                 TOP
            ================================================== -->

            <div class="building-quiz__top">


                <!-- HOME -->

                <button
                    type="button"

                    class="building-quiz__icon-button"

                    aria-label="Kembali ke menu utama"

                    @click="goHome"
                >

                    🏠

                </button>


                <!-- QUESTION NUMBER -->

                <div class="building-quiz__number">

                    Soal
                    {{ currentQuestionIndex + 1 }}
                    /
                    {{ questions.length }}

                </div>


            </div>


            <!-- =================================================
                 MAIN QUIZ CARD
            ================================================== -->

            <section class="building-quiz__card">


                <!-- TITLE -->

                <h1 class="building-quiz__title">

                    Bangunan Apakah Ini? 🏢

                </h1>


                <!-- =================================================
                     DISPLAY
                ================================================== -->

                <div class="building-quiz__display">

                    <div class="building-quiz__emoji">

                        {{ currentQuestion().emoji }}

                    </div>

                </div>


                <!-- =================================================
                     ANSWERS
                ================================================== -->

                <div class="building-quiz__answers">


                    <button
                        v-for="(
                            option,
                            index
                        ) in currentQuestion().options"

                        :key="option"

                        type="button"

                        class="building-quiz__answer"

                        :class="{

                            'building-quiz__answer--correct':
                                selectedAnswer &&
                                option ===
                                currentQuestion().answer,

                            'building-quiz__answer--wrong':
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
                                building-quiz__answer-letter
                            "
                        >

                            {{
                                String.fromCharCode(
                                    65 + index
                                )
                            }}

                        </span>


                        <!-- NAME ONLY -->

                        <span
                            class="
                                building-quiz__answer-name
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

                    class="building-quiz__feedback"

                    :class="{

                        'building-quiz__feedback--correct':
                            answerStatus === 'correct',

                        'building-quiz__feedback--wrong':
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

                    class="building-quiz__next-button"

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

            class="building-quiz__finished"
        >


            <!-- ICON -->

            <div class="building-quiz__finished-icon">

                🎉

            </div>


            <!-- TITLE -->

            <h1>

                Quiz Selesai!

            </h1>


            <!-- SCORE -->

            <div class="building-quiz__score">

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

            <div class="building-quiz__finished-actions">


                <!-- HOME -->

                <button
                    type="button"

                    class="building-quiz__finished-button"

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

                    class="building-quiz__finished-button"

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