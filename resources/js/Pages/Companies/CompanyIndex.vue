<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Link } from '@inertiajs/vue3';

const companies = ref([]);
const pagination = ref({});

const fetchCompanies = (url) => {
    axios.get(url)
        .then(response => {
            companies.value = response.data.data;
            pagination.value = {
                prev: response.data.prev_page_url,
                next: response.data.next_page_url,
                total_pages: response.data.last_page,
                current_page: response.data.current_page,
            };
        })
        .catch(error => console.error('Error fetching companies:', error));
};

fetchCompanies('http://127.0.0.1:8000/api/company');

const confirmDelete = (companyId) => {
    if (window.confirm('Are you sure you want to delete this company?')) {
        deleteCompany(companyId);
    }
};

const deleteCompany = (companyId) => {
    // Add your delete request logic here
    axios.get(`http://127.0.0.1:8000/api/company/destroy/${companyId}`)
        .then(() => {
            // After successful deletion, you might want to refresh the company list
            fetchCompanies('http://127.0.0.1:8000/api/company');
        })
        .catch(error => console.error('Error deleting company:', error));
};

</script>

<template>
    <Head title="Companies List" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Companies List</h2>
                <Link :href="route('companyCreate')">
                <PrimaryButton>Create Company</PrimaryButton>
                </Link>
            </div>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mt-5">
            <table v-if="companies.length > 0" class="w-full table-auto bg-white p-4 sm:p-8 shadow sm:rounded-lg">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Company Logo</th>
                        <th class="px-4 py-2 text-left">Company Name</th>
                        <th class="px-4 py-2 text-left">Company Email</th>
                        <th class="px-4 py-2 text-left">Company Website</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody v-for="(company, index) in companies" :key="company.id"
                    :class="index % 2 === 0 ? 'bg-gray-50' : 'bg-white'">
                    <tr>
                        <td class="border-b px-4 py-2 text-center">
                            <img v-if="company.logo" :src="company.logo" alt="Company Logo" class="h-12 w-12">
                        </td>
                        <td class="border-b px-4 py-2">{{ company.name }}</td>
                        <td class="border-b px-4 py-2">{{ company.email }}</td>
                        <td class="border-b px-4 py-2">{{ company.website }}</td>
                        <td class="border-b px-4 py-2">
                            <div class="flex justify-center space-x-2">
                                <Link :href="route('companyEdit', company.id)">
                                <PrimaryButton>Edit</PrimaryButton>
                                </Link>
                                <DangerButton @click="confirmDelete(company.id)">Delete</DangerButton>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-else class="text-center text-gray-600">No records found</div>

            <!-- Pagination section -->
            <nav v-if="pagination.total_pages > 0 && companies.length > 0" class="flex justify-center mt-5"
                aria-label="Pagination">
                <ul class="flex">
                    <li v-for="pageNumber in pagination.total_pages" :key="pageNumber">
                        <button @click="fetchCompanies(`http://127.0.0.1:8000/api/company?page=${pageNumber}`)"
                            :class="{ 'bg-blue-500 text-white px-4 py-2 rounded mx-2': pageNumber === pagination.current_page, 'border border-gray-300 bg-white text-gray-700 mx-2 px-4 py-2 rounded': pageNumber !== pagination.current_page }">
                            {{ pageNumber }}
                        </button>
                    </li>
                </ul>
            </nav>
        </div>
    </AuthenticatedLayout>
</template>
