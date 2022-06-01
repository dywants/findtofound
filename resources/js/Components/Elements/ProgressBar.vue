<template>
    <div class="progress-bar">
        <div class="info">
            <label class="percentage">{{percentage}}% </label>
        </div>
        <div class="background-bar"></div>
        <transition appear @before-appear="beforeEnter" @after-appear="enter">
            <div class="tracker-bar" v-bind:aria-valuenow="percentage" aria-valuemin="0" aria-valuemax="100"></div>
        </transition>
    </div>
</template>

<script>
import {percentage} from "tailwindcss/lib/util/dataTypes";

export default {
    name: "ProgressBar",
    props: {
        percentage: Number,
    },
    methods: {
        beforeEnter (el) {
            el.style.width = 0
        },
        enter (el) {
            console.log(this.percentage)
            el.style.width = `${this.percentage}%`
            el.style.transition = `width 1s linear`
        }
    }

}
</script>

<style scoped>

.active .tracker-bar {
    background: #ff298a !important;
}
.progress-bar {
    width: 100%;
}

.info{
    font-size: 17px;
    justify-content: space-between;
    display: flex;
    color: grey;
    text-transform: uppercase;
}

.percentage {
    font-weight: bolder;
}

.background-bar {
    background: #ccc;
    width: 100%;
    height: 5px;
}

.tracker-bar {
    background: grey;
    height: 5px;
    width: 0;
    transition: width 0.5s linear;
    margin-top: -5px;
}
</style>
