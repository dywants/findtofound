<template>
    <Head title="Admin - All Find" />

    <HeaderAdmin>
        <template #HeaderAdmin>
            <ul>
                <li>
                    <Link :href="route('admin.index')">Admin</Link>
                </li>
                <li>
                    <Link :href="route('admin.allFind')">All Find</Link>
                </li>
            </ul>
        </template>
    </HeaderAdmin>
    <div class="card has-table">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon">
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                   </svg>
                </span>
                All Find
            </p>
        </header>
        <div class="card-content">
            <table>
                <thead>
                <tr>
                    <th>FullName</th>
                    <th>FindCity</th>
                    <th>Ward</th>
                    <th>Photos</th>
                    <th>Approval_status</th>
                    <th>Type de piece</th>
                    <th>User Finder</th>
                    <th>Amount</th>
                    <th>CreatedAt</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="find in finds" :key="find.id">
                    <td>
                        {{ find.fullName }}
                    </td>
                    <td>{{ find.findCity }}</td>
                    <td >{{ find.ward }}</td>
                    <td >
                        <img :src="showImage(find.photos)" alt="" class="w-48 h-48">
                    </td>
                    <td >
                       {{ find.approval_status == 1 ? 'Retrouvée' : 'Pas encore retrouvée'}}
                    </td>
                    <td>
                        {{ find.piece.name }}
                    </td>
                    <td>
                        {{find.user.name }}
                    </td>
                    <td>
                        {{ find.amount_check }}
                    </td>
                    <td data-label="Created">
                        <small class="text-gray-500" title="Oct 25, 2021">{{ formatDateFR(find.created_at)}}</small>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="table-pagination">
<!--                <div class="flex items-center justify-between">-->
<!--                    <ul class="buttons">-->
<!--                        <li :class="finds.links[0].url == null ? ' active' : 'disabled'" :disabled="finds.links[0].url == null "-->
<!--                            class="button" >-->
<!--                            <Link :href="finds.links[0].url == null ? '#' : finds.links[0].url" v-html="finds.links[0].label" />-->
<!--                        </li>-->
<!--                        <li v-for="item in numberLinks" :class="item.active ? ' active' : ' disabled'" class="button">-->
<!--                            <Link :href="!item.active ? '#' : item.url"  v-html="item.label" />-->
<!--                        </li>-->
<!--                        <li :class="finds.links[finds.links.length - 1].url == null ? ' active' : ' disabled'" class="button">-->
<!--                            <Link :href="finds.links[finds.links.length - 1].url == null ? '#' : finds.links[finds.links.length - 1].url" v-html="finds.links[finds.links.length - 1].label" />-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                    <small>Page {{ finds.current_page }} of {{ numberLinks.length }}</small>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</template>

<script>
import HeaderAdmin from "@/Layouts/Admin/HeaderAdmin";
import {Link, usePage} from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout";
import {computed} from "vue";

export default {
    name: "Find",
    components: {HeaderAdmin, Link},
    props: ['finds'],
    layout: AdminLayout,

    setup(){
        function formatDateFR(date) {
            const options = { year: 'numeric', month: 'numeric', day: 'numeric' }
            return new Date(date).toLocaleDateString('fr-FR', options)
        }

        function showImage(file) {
            const ArrayFile =  JSON.parse("[" + file + "]");

            return "/storage/findImages/" + (ArrayFile[0])[0]
        }

        // const finds = computed(() => usePage().props.value.finds);
        //
        // const numberLinks = finds.value.links.filter((v, i) => i > 0 && i < finds.value.links.length - 1);

        return {
            formatDateFR,
            showImage,
            // numberLinks
        }
    }
}
</script>

<style scoped>

</style>
