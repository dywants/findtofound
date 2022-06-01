<script>
import HeaderPage from "@/Layouts/HeaderPage";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import InforObject from "@/Components/Steps/InforObject";
import YourInformation from "@/Components/Steps/YourInformation";
import Validation from "@/Components/Steps/Validation";
import FormWizard from "@/Components/Elements/FormWizard";
import FormStep from "@/Components/Elements/FormStep";
import * as yup from "yup";
import {Inertia} from '@inertiajs/inertia';
import ProgressBar from '@/Components/Elements/ProgressBar'


export default {
    name: "TheRegister",
    components: {
        FormStep,
        FormWizard,
        Validation,
        YourInformation,
        InforObject,
        HeaderPage,
        ProgressBar,
        "v-loading": Loading,
    },
    computed: {
        isLoading() {
            return this.isLoadingRegisterPiece;
        },
        getSectionName(){
            switch (this.currentStepIdx) {
                case 0:
                    return "Informations pièce retouvée"
                case 1:
                    return "Vos informations"
                default:
                    return "Validations"
            }
        }
    },
    props: ['pieces'],
    data() {
        return {
            isLoadingRegisterPiece: false,
            currentStepIdx: '',
            stepName: '',
            piece: { type: "" },
            informationsPiece: [],
            fullPage: true,
            percentage: 0,
            amount: '',
            steps: [
                {
                    number:'1',
                    name:'Informations pièce retrouvée'
                },
                {
                    number:'2',
                    name:'Vos informations'
                },
                {
                    number:'3',
                    name:'Validations'
                },
            ],
            errors: [],
        };
    },
    methods: {
        sendAmount(amount) {
            this.amount = amount;
        },
        currentStep(CURRENT_STEP) {
            this.currentStepIdx = CURRENT_STEP;
        },
    },

    setup(){
        function onSubmit(formData) {
            console.log(JSON.stringify(formData, null, 2));
            Inertia.post('/piece-enregistrer', formData);
        }
        const validationSchema = [
            yup.object({
                fullName: yup.string().required('Le nom inscrit sur la pièce est une information importante'),
                findCity: yup.string().required("La ville où la pièces a été retrouvée est une information importante"),
                piece_id: yup.number().required("Le choix du type de pièce est important"),
                photos: yup.mixed().required("L'image est requise"),
            }),
            yup.object({
                isAnnomined: yup.bool(),
                name: yup.string().nullable().when('isAnnomined', {
                    is: false,
                    then: yup.string().required('Votre nom est requis')  }),
                email: yup.string().nullable().when('isAnnomined', {
                    is: false,
                    then: yup.string().required('Votre email est requis')  }),
                phone_number: yup.number().nullable().when('isAnnomined', {
                    is: false,
                    then: yup.number().required('Votre numero de téléphone nous permettra de vous contacter').positive()}),
                localisation: yup.string().nullable().when('isAnnomined', {
                    is: true,
                    then: yup.string().required('Votre email est requis')  })
            }),
            yup.object({
                amount_check: yup.string().required('La validation de la remuneration est importante'),
            }),
        ];
        return {
            validationSchema,
            onSubmit,
        };

    }
}

</script>
<template>
    <Head title="Enregister pièce"/>
    <HeaderPage>
        <template #headerPage>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Enregistrer une pièce retrouvée
            </h2>
        </template>
    </HeaderPage>

    <div class="max-w-screen-xl p-4 mx-auto mt-8">
        <nav class="max-w-5xl mx-auto">
            <div>
                <p class="text-lg font-semibold text-gray-500">{{ currentStepIdx }}/3 - {{ getSectionName }} </p>

                <div class="mt-4 overflow-hidden bg-gray-200 rounded-full">
                    <div :style="percentage"
                         :class="{'w-0%': currentStepIdx === 0, 'w-35%': currentStepIdx === 1, 'w-75%': currentStepIdx === 2}"
                         class="h-4 bg-blue-600 text-white rounded-full"></div>
                </div>
            </div>
        </nav>

        <div class="is-clearfix mb-3">
           <FormWizard :validation-schema="validationSchema" @submit="onSubmit" @CURRENT_STEP="currentStep">
               <FormStep>
                   <template #header>Entrez les informations de la pièce </template>
                   <InforObject :pieces="pieces" @amount="sendAmount" />
               </FormStep>

               <FormStep>
                   <template #header>VOS INFORMATIONS PERSONNELLES</template>
                   <YourInformation />
               </FormStep>

               <FormStep>
                   <template #header>Validation</template>
                   <Validation :amount="amount"/>
               </FormStep>

           </FormWizard>
        </div>
        <v-loading :active.sync="isLoading" :is-full-page="fullPage" />
    </div>
</template>

<style scoped>
.progressbar li:first-child:after{
    content: none;
}

</style>
