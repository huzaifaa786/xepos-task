<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Link } from '@inertiajs/vue3';

const employees = ref([]);
const pagination = ref({});

const fetchEmployees = (url) => {
    axios.get(url)
        .then(response => {
            employees.value = response.data.data;
            pagination.value = {
                prev: response.data.prev_page_url,
                next: response.data.next_page_url,
                total_pages: response.data.last_page,
                current_page: response.data.current_page,
            };
        })
        .catch(error => console.error('Error fetching employees:', error));
};

fetchEmployees('http://127.0.0.1:8000/api/employee');

const confirmDelete = (employeeId) => {
    if (window.confirm('Are you sure you want to delete this employee?')) {
        deleteEmployee(employeeId);
    }
};

const deleteEmployee = (employeeId) => {
    axios.get(`http://127.0.0.1:8000/api/employee/destroy/${employeeId}`)
        .then(() => {
            fetchEmployees('http://127.0.0.1:8000/api/employee');
        })
        .catch(error => console.error('Error deleting employee:', error));
};
</script>

<template>
    <Head title="Employees List" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Employees List</h2>
                <Link :href="route('employeeCreate')">
                <PrimaryButton>Create Employee</PrimaryButton>
                </Link>
            </div>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mt-5">
            <table v-if="employees.length > 0" class="w-full table-auto bg-white p-4 sm:p-8 shadow sm:rounded-lg">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Employee Name</th>
                        <th class="px-4 py-2 text-left">Employee Company</th>
                        <th class="px-4 py-2 text-left">Employee Email</th>
                        <th class="px-4 py-2 text-left">Employee Phone</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody v-for="(employee, index) in employees" :key="employee.id"
                    :class="index % 2 === 0 ? 'bg-gray-50' : 'bg-white'">
                    <tr>
                        <td class="border-b px-4 py-2">{{ employee.first_name }} {{ employee.last_name }}</td>
                        <td class="border-b px-4 py-2">{{ employee.company.name }}</td>
                        <td class="border-b px-4 py-2">{{ employee.email }}</td>
                        <td class="border-b px-4 py-2">{{ employee.phone }}</td>
                        <td class="border-b px-4 py-2">
                            <div class="flex justify-center space-x-2">
                                <Link :href="route('employeeEdit', employee.id)">
                                <PrimaryButton>Edit</PrimaryButton>
                                </Link>
                                <DangerButton @click="confirmDelete(employee.id)">Delete</DangerButton>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-else class="text-center text-gray-600">No records found</div>

            <!-- Pagination section -->
            <nav v-if="pagination.total_pages > 0 && employees.length > 0" class="flex justify-center mt-5"
                aria-label="Pagination">
                <ul class="flex">
                    <li v-for="pageNumber in pagination.total_pages" :key="pageNumber">
                        <button @click="fetchEmployees(`http://127.0.0.1:8000/api/employee?page=${pageNumber}`)"
                            :class="{ 'bg-blue-500 text-white px-4 py-2 rounded mx-2': pageNumber === pagination.current_page, 'border border-gray-300 bg-white text-gray-700 mx-2 px-4 py-2 rounded': pageNumber !== pagination.current_page }">
                            {{ pageNumber }}
                        </button>
                    </li>
                </ul>
            </nav>
        </div>
    </AuthenticatedLayout>
</template>
