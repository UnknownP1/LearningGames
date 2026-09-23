<script setup>

function goToColors() {
    window.location.href = '/warna'
}

function goToAnimals() {
    window.location.href = '/hewan'
}

function goToBuildings() {
    window.location.href = '/bangunan'
}

function goToShapes() {
    window.location.href = '/bentuk'
}

function goToAlphabet() {
    window.location.href = '/alphabet'
}

function goToNumbers() {
    window.location.href = '/angka'
}

</script>


<template>

    <main class="home">

        <section class="home__content">

            <div class="home__icon">
                🎮
            </div>

            <h1 class="home__title">
                Belajar & Bermain
            </h1>

            <p class="home__subtitle">
                Yuk belajar sambil bermain! 🌈
            </p>


            <div class="home__menus">

                <!-- WARNA -->

                <button
                    type="button"
                    class="home__menu home__menu--colors"
                    @click="goToColors"
                >

                    <div class="home__menu-icon">
                        🌈
                    </div>

                    <div class="home__menu-title">
                        Mengenal Warna
                    </div>

                    <div class="home__menu-description">
                        Yuk belajar berbagai warna!
                    </div>

                </button>


                <!-- HEWAN -->

                <button
                    type="button"
                    class="home__menu home__menu--animals"
                    @click="goToAnimals"
                >

                    <div class="home__menu-icon">
                        🐶
                    </div>

                    <div class="home__menu-title">
                        Mengenal Hewan
                    </div>

                    <div class="home__menu-description">
                        Yuk kenali berbagai hewan!
                    </div>

                </button>


                <!-- BANGUNAN -->

                <button
                    type="button"
                    class="home__menu home__menu--buildings"
                    @click="goToBuildings"
                >

                    <div class="home__menu-icon">
                        🏢
                    </div>

                    <div class="home__menu-title">
                        Mengenal Bangunan
                    </div>

                    <div class="home__menu-description">
                        Yuk kenali berbagai bangunan!
                    </div>

                </button>


                <!-- BENTUK -->

                <button
                    type="button"
                    class="home__menu home__menu--shapes"
                    @click="goToShapes"
                >

                    <div class="home__menu-icon">
                        🔷
                    </div>

                    <div class="home__menu-title">
                        Mengenal Bentuk
                    </div>

                    <div class="home__menu-description">
                        Yuk kenali berbagai bentuk!
                    </div>

                </button>

                <!-- ALFABET -->

                <button
                    type="button"
                    class="home__menu home__menu--alphabet"
                    @click="goToAlphabet"
                >

                    <div class="home__menu-icon">
                        🔤
                    </div>

                    <div class="home__menu-title">
                        Mengenal Alfabet
                    </div>

                    <div class="home__menu-description">
                        Yuk kenali huruf A sampai Z!
                    </div>

                </button>
                
                <!-- ANGKA -->

                <button
                    type="button"
                    class="home__menu home__menu--numbers"
                    @click="goToNumbers"
                >

                    <div class="home__menu-icon">
                        🔢
                    </div>

                    <div class="home__menu-title">
                        Mengenal Angka
                    </div>

                    <div class="home__menu-description">
                        Yuk kenali angka 0 sampai 10!
                    </div>

                </button>
                
            </div>

        </section>

    </main>

</template>