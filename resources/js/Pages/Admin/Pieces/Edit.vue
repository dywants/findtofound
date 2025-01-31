<template>

    <Head title="Admin - Modification pièce" />

    <HeaderAdmin>
        <template #HeaderAdmin>
            <ul>
                <li>
                    <Link :href="route('admin.index')">Admin</Link>
                </li>
                <li>
                    <Link :href="route('piece.index')">Pièces</Link>
                </li>
                <li>
                    <Link>Modification de : {{ piece.name }}</Link>
                </li>
            </ul>
        </template>
    </HeaderAdmin>
    <form @submit.prevent="submit">
        <ErrorsAndMessages :errors="errors" />
        <div class="mb-4">
            <Label for="">Nom</Label>
            <Input type="text" name="name" v-model="form.name" />
            <InputError />
        </div>

        <div class="mb-4">
            <Label for="">Montant</Label>
            <Input type="number" name="amount" v-model="form.amount" />
            <InputError />
        </div>

        <Button>Enregistrer</Button>
    </form>
</template>

<script>
import ErrorsAndMessages from "@/Components/Elements/ErrorsAndMessages";
import HeaderAdmin from "@/Layouts/Admin/HeaderAdmin";
import { Link, usePage } from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout";
import { reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";
import Input from "@/Components/Input";
import Button from "@/Components/Button";
import InputError from "@/Components/InputError";

export default {
    name: "Edit",
    components: { ErrorsAndMessages, HeaderAdmin, Link, Input, Button, InputError },
    layout: AdminLayout,
    props: ['piece', 'errors'],

    setup() {
        const form = reactive({
            name: null,
            amount: null,
            _token: usePage().props.value.csrf_token,
            _method: "PUT"
        });
        // retrieve post prop
        const { name, amount, id } = usePage().props.value.piece;
        form.name = name;
        form.amount = amount;

        function submit() {
            Inertia.post(route('piece.update', { 'piece': id }), form, {
                forceFormData: true
            });
        }
        return {
            form, submit
        }
    }
}
</script>

<style scoped></style>
