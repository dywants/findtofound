<template>
    <Head title="Recherche pièce"/>
    <HeaderPage>
        <template #headerPage>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Enregistrer Vos infomations
            </h2>
        </template>
    </HeaderPage>

<!--    <div class="max-w-screen-xl p-4 mx-auto mt-8">-->
<!--        <h2 class="text-[38px] text-gray-800 font-bold leading-4">{{ thefind.fullName }}</h2>-->
<!--        <p class="mt-4 leading-loose text-[18px]">Complétez ce formulaire, validez et effectuer le paiement via nos moyens de paiement après quoi nous nous mettrons en contact avec le <em class="font-semibold">finder</em> qui à retrouvée votre pièce</p>-->
<!--    </div>-->

    <section class="text-blueGray-700 bg-white">
        <div class="container flex flex-col items-center px-5 py-16 mx-auto  md:flex-row lg:px-28">
            <div class="flex flex-col items-start w-full pt-0 mb-16 text-left  lg:flex-grow md:w-1/2 xl:mr-20 md:pr-24 md:mb-0">
                <h1 class="mb-8 text-2xl font-black tracking-tighter text-black  md:text-5xl title-font"> {{ fullName }} </h1>
                <p class="mb-8 text-base leading-relaxed text-left text-blueGray-600">Complétez ce formulaire, validez et effectuer le paiement via nos moyens de paiement après quoi nous vous mettrons en contact avec le <em class="font-semibold">finder</em> qui à retrouvée votre pièce </p>
            </div>
            <div class="w-full lg:w-5/6 lg:max-w-lg md:w-1/2">
                <form @submit="onSubmit" :validation-schema="validationSchema">
                    <Field type="text" name="name" :value=fullName class="w-full" hidden />
                    <Field type="number" name="thefind_id" :value=id class="w-full" hidden />

                    <div class="mb-6">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Votre email</label>
                        <Field type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                        focus:border-blue-500 block w-full p-2.5 " placeholder="name@flowbite.com" />
                        <ErrorMessage class="mt-2 text-sm text-red-600" name="email" />
                    </div>
                    <div class="mb-6">
                        <label for="phone_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Votre numero de téléphone</label>
                        <Field type="number" id="phone_number" name="phone_number"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "  />
                        <ErrorMessage class="mt-2 text-sm text-red-600" name="phone_number" />
                    </div>
                    <div class="mb-6">
                        <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Votre ville</label>
                        <Field type="text" id="city" name="city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "  />
                        <ErrorMessage class="mt-2 text-sm text-red-600" name="city" />
                    </div>
                    <div class="mb-6">
                        <label for="amount_check" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Montant à payer</label>
                        <Field type="text"  id="amount_check" name="amount_check" :value="amount_check.amount == 0 ? amount_piece.formatted : amount_check.formatted"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "  disabled />
                    </div>

                    <button type="submit" :disabled="isSubmitting"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">Valider</button>
                </form>
            </div>
        </div>
    </section>

</template>

<script>
import { Field, ErrorMessage, useForm } from "vee-validate";
import HeaderPage from "@/Layouts/HeaderPage";
import { Link } from '@inertiajs/inertia-vue3';
import * as yup from 'yup';
import {Inertia} from "@inertiajs/inertia";

export default {
    name: "TheRegisterInfoFounder",
    components: {HeaderPage, Link, Field, ErrorMessage},
    props: ['fullName', 'amount_check', 'id' ,'validationSchema','amount_piece'],
    data() {
        return {
            errors: [],
        }
    },

    setup() {
        const { handleSubmit, isSubmitting } = useForm({
            validationSchema: validationSchema,
        });

        const onSubmit = handleSubmit(values => {
            Inertia.post('/piece/enregistrer', values);
        });

        const validationSchema = [
            yup.object({
                email: yup.string().required('Votre email est requis'),
                phone_number: yup.number().required('Votre numero de téléphone nous permettra de vous contacter'),
                city: yup.string().required("Votre ville est une information importante"),
            })
        ];

        return {
            validationSchema,
            onSubmit,
            isSubmitting
        };
    },
}
</script>

<style scoped>

</style>
