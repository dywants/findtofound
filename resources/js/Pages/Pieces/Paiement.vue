<template>
    <Head title="Paiement pièce"/>
    <HeaderPage>
        <template #headerPage>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Paiement
            </h2>
        </template>
    </HeaderPage>

    <div class="max-w-screen-xl p-4 mx-auto mt-8">
        <nav class="flex py-3 px-5 text-gray-700 bg-gray-50 rounded-lg border border-gray-200 " aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <Link :href="route('home')" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                        <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        Accueil
                    </Link>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <Link :href="route('found.search')" class="ml-1 text-sm font-medium text-gray-700 hover:text-gray-900 md:ml-2 dark:text-gray-400 dark:hover:text-white">Rechercher une pièce</Link>
                    </div>
                </li>
<!--                <li>-->
<!--                    <div class="flex items-center">-->
<!--                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>-->
<!--                        <Link :href="route('found.info')" class="ml-1 text-sm font-medium text-gray-700 hover:text-gray-900 md:ml-2 dark:text-gray-400 dark:hover:text-white">Validation</Link>-->
<!--                    </div>-->
<!--                </li>-->
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-sm font-medium text-gray-400 md:ml-2 dark:text-gray-500">Paiement</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="w-full bg-white border-t border-b border-gray-200 px-5 py-10 text-gray-800">
            <div class="w-full">
                <div class="-mx-3 md:flex items-start">
                    <div class="px-3 md:w-7/12 lg:pr-10">
                        <div class="w-full mx-auto text-gray-800 font-light mb-6 border-b border-gray-200 pb-6">
                            <div class="w-full flex items-center">
                                <div class="overflow-hidden rounded-lg w-16 h-16 bg-gray-50 border border-gray-200">
                                    <img src="https://images.unsplash.com/photo-1572635196237-14b3f281503f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1160&q=80" alt="">
                                </div>
                                <div class="flex-grow pl-3">
                                    <h6 class="font-semibold uppercase text-gray-600">Ray Ban Sunglasses.</h6>
                                    <p class="text-gray-400">x 1</p>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-600 text-xl">$210</span><span class="font-semibold text-gray-600 text-sm">.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-6 pb-6 border-b border-gray-200 text-gray-800">
                            <div class="w-full flex mb-3 items-center">
                                <div class="flex-grow">
                                    <span class="text-gray-600">Subtotal</span>
                                </div>
                                <div class="pl-3">
                                    <span class="font-semibold">$190.91</span>
                                </div>
                            </div>
                            <div class="w-full flex items-center">
                                <div class="flex-grow">
                                    <span class="text-gray-600">Taxes (GST)</span>
                                </div>
                                <div class="pl-3">
                                    <span class="font-semibold">$19.09</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-6 pb-6 border-b border-gray-200 md:border-none text-gray-800 text-xl">
                            <div class="w-full flex items-center">
                                <div class="flex-grow">
                                    <span class="text-gray-600">Total</span>
                                </div>
                                <div class="pl-3">
                                    <span class="font-semibold text-gray-400 text-sm">AUD</span> <span class="font-semibold">$210.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-3 md:w-5/12">
                        <div class="w-full mx-auto rounded-lg bg-white border border-gray-200 p-3 text-gray-800 font-light mb-6">
                            <div class="w-full flex mb-3 items-center">
                                <div class="w-32">
                                    <span class="text-gray-600 font-semibold">Contact</span>
                                </div>
                                <div class="flex-grow pl-3">
                                    <span>Scott Windon</span>
                                </div>
                            </div>
                            <div class="w-full flex items-center">
                                <div class="w-32">
                                    <span class="text-gray-600 font-semibold">Billing Address</span>
                                </div>
                                <div class="flex-grow pl-3">
                                    <span>123 George Street, Sydney, NSW 2000 Australia</span>
                                </div>
                            </div>
                        </div>
                        <div class="w-full mx-auto rounded-lg bg-white border border-gray-200 text-gray-800 font-light mb-6">
                            <div class="w-full p-3 border-b border-gray-200">
                                <div class="mb-5">
                                    <label for="type1" class="flex items-center cursor-pointer">
                                        <input type="radio" class="form-radio h-5 w-5 text-indigo-500" name="type" id="type1" checked>
                                        <img src="https://leadershipmemphis.org/wp-content/uploads/2020/08/780370.png" class="h-6 ml-3">
                                    </label>
                                </div>
                                <div>
                                    <div class="mb-3">
                                        <label class="text-gray-600 font-semibold text-sm mb-2 ml-1">Name on card</label>
                                        <div>
                                            <input class="w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="John Smith" type="text"/>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="text-gray-600 font-semibold text-sm mb-2 ml-1">Card number</label>
                                        <div>
                                            <input class="w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="0000 0000 0000 0000" type="text"/>
                                        </div>
                                    </div>
                                    <div class="mb-3 -mx-2 flex items-end">
                                        <div class="px-2 w-1/4">
                                            <label class="text-gray-600 font-semibold text-sm mb-2 ml-1">Expiration date</label>
                                            <div>
                                                <select class="form-select w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors cursor-pointer">
                                                    <option value="01">01 - January</option>
                                                    <option value="02">02 - February</option>
                                                    <option value="03">03 - March</option>
                                                    <option value="04">04 - April</option>
                                                    <option value="05">05 - May</option>
                                                    <option value="06">06 - June</option>
                                                    <option value="07">07 - July</option>
                                                    <option value="08">08 - August</option>
                                                    <option value="09">09 - September</option>
                                                    <option value="10">10 - October</option>
                                                    <option value="11">11 - November</option>
                                                    <option value="12">12 - December</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="px-2 w-1/4">
                                            <select class="form-select w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors cursor-pointer">
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                                <option value="2026">2026</option>
                                                <option value="2027">2027</option>
                                                <option value="2028">2028</option>
                                                <option value="2029">2029</option>
                                            </select>
                                        </div>
                                        <div class="px-2 w-1/4">
                                            <label class="text-gray-600 font-semibold text-sm mb-2 ml-1">Security code</label>
                                            <div>
                                                <input class="w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="000" type="text"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full p-3">
                                <label for="type2" class="flex items-center cursor-pointer">
                                    <input type="radio" class="form-radio h-5 w-5 text-indigo-500" name="type" id="type2">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" width="80" class="ml-3"/>
                                </label>
                            </div>
                        </div>
                        <div>
                            <button class="block w-full max-w-xs mx-auto bg-indigo-500 hover:bg-indigo-700 focus:bg-indigo-700 text-white rounded-lg px-3 py-2 font-semibold"><i class="mdi mdi-lock-outline mr-1"></i> PAY NOW</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-5">
            <div class="text-center text-gray-400 text-sm">
                <a href="https://www.buymeacoffee.com/scottwindon" target="_blank" class="focus:outline-none underline text-gray-400"><i class="mdi mdi-beer-outline"></i>Buy me a beer</a> and help support open-resource
            </div>
        </div>
    </div>
</template>

<script>
import HeaderPage from "@/Layouts/HeaderPage";
import { Link } from '@inertiajs/inertia-vue3';

export default {
    name: "Paiement",
    components: {HeaderPage,Link},
    props: ['amount_check']
}
</script>

<style scoped>
.form-radio {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
    display: inline-block;
    vertical-align: middle;
    background-origin: border-box;
    user-select: none;
    flex-shrink: 0;
    border-radius: 100%;
    border-width: 2px;
}

.form-radio:checked {
    background-color: currentColor;
    border-color: transparent;
    background-size: 100% 100%;
    background-position: center;
    background-repeat: no-repeat;
}

.form-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
}
</style>
