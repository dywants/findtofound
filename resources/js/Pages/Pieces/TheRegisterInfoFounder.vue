<template>
    <Head title="Recherche pièce"/>
    <HeaderPage>
        <template #headerPage>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Enregistrer Vos infomations
            </h2>
        </template>
    </HeaderPage>


    <section class="text-blueGray-700 bg-white">
        <div class="container flex flex-col items-center px-5 py-16 mx-auto  md:flex-row lg:px-28">
            <ErrorsAndMessages :errors="errors" />
            <div class="flex flex-col items-start w-full pt-0 mb-16 text-left lg:flex-grow md:w-1/2 xl:mr-20 md:pr-24 md:mb-0">
                <div v-if="!$page.props.auth.user">
                    <h1 class="mb-8 text-2xl font-black tracking-tighter text-black  md:text-5xl title-font"> {{ fullName }} </h1>
                    <p class="mb-8 text-base leading-relaxed text-left text-blueGray-600">Complétez ce formulaire, validez et effectuer le paiement via nos moyens de paiement après quoi nous vous mettrons en contact avec le <em class="font-semibold">finder</em> qui à retrouvée votre pièce </p>
                    <form @submit="onSubmit" :validation-schema="validationSchema" class="w-full">
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
                            <label for="amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Montant à payer (FCFA)</label>
                            <Field type="text" id="amount" name="amount" :value="amount_check.amount == 0 ? amount_piece.amount : amount_check.amount"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "  disabled />
                        </div>

                        <button type="submit" :disabled="isSubmitting"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none
                            focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">Valider</button>
                    </form>
                </div>
                <div v-else class="relative flex flex-col">
                    <h1 class="mb-8 text-2xl font-black tracking-tighter text-black  md:text-5xl title-font"> {{ fullName }} </h1>
                    <p class="z-40 leading-tight">Félicitation, encore d'une étape, choissez votre mode de paiement et effectuer le paiement pour
                        enfin avoir les informations sur votre pièce perdue</p>
                    <img src="/images/icons/icon-p.svg" alt="" class="self-end object-contain w-64 h-64 lg:w-72 lg:h-72 ">
                </div>

            </div>
            <div class="w-full lg:w-5/6 lg:max-w-lg md:w-1/2">
                <div class="px-3">
                    <div class="w-full mx-auto rounded-lg bg-white border border-gray-200 p-3 text-gray-800 font-light mb-6">
                       <h2 class="text-gray-800 font-semibold text-[22px] pv-2">Moyens de paiement</h2>
                        <p class="leading-relaxed">Choissiez votre moyen de paiement securisé</p>
                    </div>
                    <div class="w-full mx-auto rounded-lg bg-white border border-gray-200 text-gray-800 font-light mb-6">
                        <div class="w-full p-3 border-b border-gray-200">
                            <div class="mb-5">
                                <label for="type1" class="flex items-center cursor-pointer">
                                    <input type="radio" @click="toggleAccordion()" class="form-radio h-5 w-5 text-indigo-500" name="type" id="type1" checked>
                                    <img src="https://leadershipmemphis.org/wp-content/uploads/2020/08/780370.png" class="h-6 ml-3">
                                </label>
                            </div>
                            <div v-show="isOpen">
                                Lien
                            </div>
                        </div>
                        <div class="w-full p-3">
                           <div class="mb-5">
                               <label for="type2" class="flex items-center cursor-pointer">
                                   <input type="radio" @click="togglePaypal()"  class="form-radio h-5 w-5 text-indigo-500" name="type" id="type2">
                                   <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" width="80" class="ml-3"/>
                               </label>
                           </div>
                            <div v-show="isOpenCheck">
                                <div v-if="$page.props.auth.user" id="paypal-button-container"></div>
                                <p v-else>Bien vouloir en premier lieu enregistrer vos informations de base</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</template>

<script>
import { Field, ErrorMessage, useForm } from "vee-validate";
import HeaderPage from "@/Layouts/HeaderPage";
import {Link, usePage} from '@inertiajs/inertia-vue3';
import * as yup from 'yup';
import {Inertia} from "@inertiajs/inertia";
import ErrorsAndMessages from "@/Components/Elements/ErrorsAndMessages";
import {reactive} from "vue";

export default {
    name: "TheRegisterInfoFounder",
    components: {HeaderPage, Link, Field, ErrorMessage,ErrorsAndMessages},
    props: ['fullName', 'amount_check', 'id' ,'validationSchema','amount_piece', 'amount_paypal','type_piece'],
    data() {
        return {
            errors: [],
            isOpen: false,
            isOpenCheck: false,
        }
    },

    methods: {
        toggleAccordion() {
            this.isOpen = !this.isOpen;
        },
        togglePaypal() {
            this.isOpenCheck = !this.isOpenCheck;
            this.mountPaypalButton()
        },
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

        const mountPaypalButton = () => {
            // retrieve post prop
            const amount = usePage().props.value.amount_paypal;
            const name = usePage().props.value.fullName;
            const type = usePage().props.value.type_piece;

            paypal.Buttons({
                // Sets up the transaction when a payment button is clicked
                createOrder: (data, actions) => {
                    return actions.order.create({
                        "purchase_units": [{
                            "amount": {
                                "currency_code": "EUR",
                                "value": amount,
                                "breakdown": {
                                    "item_total": {  /* Required when including the `items` array */
                                        "currency_code": "EUR",
                                        "value": amount
                                    }
                                }
                            },
                            "items": [
                                {
                                    "name": name, /* Shows within upper-right dropdown during payment approval */
                                    "description": type, /* Item details will also be in the completed paypal.com transaction view */
                                    "unit_amount": {
                                        "currency_code": "EUR",
                                        "value": amount
                                    },
                                    "quantity": "1"
                                },
                            ]
                        }]
                    });
                },
                // Finalize the transaction after payer approval

                onApprove: async (data, actions) => {
                    const authorization = await actions.order.authorize()
                    const authorizationId = authorization.purchase_units[0].payments.authorizations[0].id
                    console.log(authorization, data)

                    const form = reactive({
                        authorizationId: authorizationId,
                        sourcePayment: data.paymentSource
                    });

                    Inertia.post(route('paypal.store', {id: authorizationId}), form, {
                        forceFormData: true
                    })

                    // alert('Votre paiement a bien été enregistré')
                }
            }).render('#paypal-button-container');
        }

        return {
            validationSchema,
            onSubmit,
            isSubmitting,
            mountPaypalButton
        };
    },
}
</script>

<style scoped>

</style>
