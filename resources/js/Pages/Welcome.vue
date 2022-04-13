<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import TheNavbar from "@/Components/TheNavbar";


defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
})

</script>

<template>
    <TheNavbar/>
    <div class="my-4">The home pages</div>
</template>

<style scoped>
.time {
    font-size: 13px;
    color: #999;
}

.bottom {
    margin-top: 13px;
    line-height: 12px;
}

.button {
    padding: 0;
    float: right;
}

.image {
    width: 100%;
    display: block;
}

.clearfix:before,
.clearfix:after {
    display: table;
    content: "";
}

.clearfix:after {
    clear: both
}
</style>

<script>
export default {
    data() {
        return {
            currentDate: new Date()
        };
    }
}
</script>
