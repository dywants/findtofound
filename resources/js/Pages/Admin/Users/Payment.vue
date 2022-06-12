<template>
    <Head title="Admin - Payments"/>

    <HeaderAdmin>
        <template #HeaderAdmin>
            <ul>
                <li>
                    <Link :href="route('admin.index')">Admin</Link>
                </li>
                <li>
                    <Link :href="route('admin.payment')">Payment</Link>
                </li>
                <li>
                    <Link :href="route('admin.payment.finder')">Payment finder</Link>
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
                           <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                       </svg>
                   </span>
                Paiement
            </p>
        </header>
        <div class="card-content">
            <table>
                <thead>
                <tr>
                    <th>OrderId</th>
                    <th>Type de pièce</th>
                    <th>User finder</th>
                    <th>Telephone</th>
                    <th>Montant</th>
                    <th>Status pièce</th>
                    <th>PaymentStatus</th>
                    <th>CreatedAt</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="payment in payments" :key="payment.id">
                    <td>
                        {{ payment.order_id }}
                    </td>
                    <td data-label="Type">{{ payment.type_piece }}</td>
                    <td data-label="Name">{{ payment.thefind.user.name }}</td>
                    <td data-label="Name">{{ payment.thefind.user.profile.phone_number }}</td>
                    <td data-label="amount">{{ payment.thefind.amount_check }}</td>
                    <td data-label="status">{{
                            payment.thefind.approval_status == '0' ? 'Non récuperée' : 'Récuperée'
                        }}
                    </td>
                    <td data-label="City">{{ payment.payment_status }}</td>

                    <td data-label="Created">
                        <small class="text-gray-500" title="Oct 25, 2021">{{ formatDateFR(payment.created_at) }}</small>
                    </td>
                    <td class="actions-cell">
                        <div class="buttons right nowrap">
                            <button class="button small green --jb-modal" data-target="sample-modal-2" type="button">
                                <span class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </span>
                            </button>
                            <button class="button small red --jb-modal" data-target="sample-modal" type="button">
                                <span class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="table-pagination">
                <div class="flex items-center justify-between">
                    <div class="buttons">
                        <button type="button" class="button active">1</button>
                        <button type="button" class="button">2</button>
                        <button type="button" class="button">3</button>
                    </div>
                    <small>Page 1 of 3</small>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout";
import HeaderAdmin from "@/Layouts/Admin/HeaderAdmin";
import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: "Payment",
    components: { HeaderAdmin , Link},
    props: ['payments'],
    layout: AdminLayout,

    setup(){
        function formatDateFR(date) {
            const options = { year: 'numeric', month: 'numeric', day: 'numeric' }
            return new Date(date).toLocaleDateString('fr-FR', options)
        }

        return {
            formatDateFR
        }
    }
}
</script>

<style scoped>

</style>
