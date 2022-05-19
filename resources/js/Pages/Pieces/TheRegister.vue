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

export default {
    name: "TheRegister",
    components: {
        FormStep,
        FormWizard,
        Validation,
        YourInformation,
        InforObject,
        HeaderPage,
        "v-loading": Loading,
    },
    computed: {
        isLoading() {
            return this.isLoadingRegisterPiece;
        },
        stepperProgress() {
            return ( 100 / 3 ) * ( this.currentStepIdx - 1 ) + '%'
        },
    },
    props: ['pieces'],
    data() {
        return {
            isLoadingRegisterPiece: false,
            currentStepIdx: 1,
            piece: { type: "" },
            informationsPiece: [],
            fullPage: true,
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
            options: {
                maxWidth: '100%',
                nodeWidth: 40,
                nodeHeight: 40,
                barHeight: 3,
                showTooltip: true,
                showContent: true,

                // barType can be dashed or solid
                barType: 'dashed',

                // expects a function
                onNext: this.onNext,

                // expects a function
                onFinish: this.onFinish,

                nodes: [
                    {
                        content:'step 1',
                        tooltip:'sth about step 1'
                    },
                    {
                        content:'step 2',
                        tooltip:'sth about step 2'
                    },
                    {
                        content:'step 3',
                        tooltip:'sth about step 3'
                    },
                    {
                        content:'step 4',
                        tooltip:'sth about step 4'
                    }
                ]
            },
            errors: [],
        };
    },
    methods: {
        sendAmount(amount) {
            this.amount = amount;
        }
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
        <nav>
            <h2 class="sr-only">Steps</h2>

            <div class="w-full">
                <ol class="flex items-center justify-between space-x-12 text-xs font-medium text-gray-500 sm:space-x-4 w-full relative">
                    <li :class="{ 'current': currentStepIdx == item, 'success': currentStepIdx > item }"
                        class="flex items-center flex-col space-y-2"
                        v-for="item in steps" :key="item">
                        <span class="leading-6 w-10 h-10 rounded-full text-[14px] font-bold flex items-center justify-center bg-blue-50">{{ item.number }}</span>
                        <span
                            class="leading-6 w-10 h-10 rounded-full text-[14px] font-bold flex items-center justify-center text-green-600 rounded bg-green-50">
                           <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 20 20"
                                fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                  clip-rule="evenodd"/>
                           </svg>
                        </span>
                        <span class="ml-2">{{ item.name }}</span>
                    </li>
                    <li class="stepper-progress">
                        <span :style="'width:' + stepperProgress " class="stepper-progress-bar"></span>
                    </li>
                </ol>
            </div>
        </nav>

        <div class="is-clearfix mb-3">

           <FormWizard :validation-schema="validationSchema" @submit="onSubmit">
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
.stepper-progress {
    position: absolute;
    background-color: #C5C5C5;
    height: 2px;
    width: 90%;
    z-index: -1;
    top: 20px;
    left: 55px;
    right: 0;
    /*margin: 0 auto;*/
}

.stepper-progress-bar {
    position: absolute;
    left: 0;
    height: 100%;
    width: 0%;
    background-color: #75CC65;
    transition: all 500ms ease;
}

.icon-success{
    opacity: 1;
    transform: scale(1);
}

.progressbar li:first-child:after{
    content: none;
}

</style>
