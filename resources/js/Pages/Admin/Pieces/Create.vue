<template>
    <Head title="Admin - Create pièce"/>

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
                    <Link :href="route('piece.create')">Create</Link>
                </li>
            </ul>
        </template>
    </HeaderAdmin>

    <div class="block p-6 rounded-lg shadow-lg bg-white w-full">
        <form @submit.prevent="submit">
            <div class="mb-4">
                <Label for="">Nom</Label>
                <Input type="text" name="name" v-model="form.name"/>
                <InputError/>
            </div>

            <div class="mb-4">
                <Label for="">Montant</Label>
                <Input type="number" name="amount" v-model="form.amount"/>
                <InputError/>
            </div>

            <Button>Enregistrer</Button>
        </form>
    </div>
</template>

<script>
import HeaderAdmin from "@/Layouts/Admin/HeaderAdmin";
import {Link, useForm} from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout";
import Input from "@/Components/Input";
import Button from "@/Components/Button";
import InputError from "@/Components/InputError";

export default {
    name: "create",
    components: {InputError, HeaderAdmin , Link, Input, Button},
    layout: AdminLayout,

    setup(){
        const form = useForm({
            name: '',
            amount: '',
        });

        const submit = () => {
            form.post(route('piece.store'), {
                onFinish: () => form.reset('name', 'amount'),
            });
        };

        return {
            form,
            submit
        }
    }
}
</script>

<style scoped>

</style>
