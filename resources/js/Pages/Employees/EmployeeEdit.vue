<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const form = ref({
    first_name: '',
    last_name: '',
    companyId: '',
    email: '',
    phone: '',
    errors: {}
});

const publishData = async () => {
    const page = usePage();
    let employee = ref(page.props.employee);
    form.value.first_name = employee.value.first_name;
    form.value.last_name = employee.value.last_name;
    form.value.companyId = employee.value.company_id;
    form.value.email = employee.value.email;
    form.value.phone = employee.value.phone;



}

publishData();

const updateEmployee = async () => {
    try {
        const formData = new FormData();
        formData.append('first_name', form.value.first_name);
        formData.append('last_name', form.value.last_name);
        formData.append('company_id', form.value.companyId);
        formData.append('email', form.value.email);
        formData.append('phone', form.value.phone);
        const page = usePage();

        let employee = ref(page.props.employee);


        await axios.post('http://127.0.0.1:8000/api/employee/update/' + employee.value.id, formData).then(response => {



            alert('Employee updated successfully');
            form.value.errors = {};
        }).catch(error => {

            if (error.response && error.response.data) {

                form.value.errors = error.response.data;
                if (form.value.errors.first_name) {
                    form.value.errors.first_name = form.value.errors.first_name[0];
                }
                if (form.value.errors.last_name) {
                    form.value.errors.last_name = form.value.errors.last_name[0];
                }
                if (form.value.errors.company_id) {
                    form.value.errors.company_id = form.value.errors.company_id[0];
                }

            }
        });

        // Clear form fields


    } catch (error) {
        console.error('Error updating company:', error);
        alert('An error occurred while updating the company. Please try again.');
    }
};

const companies = ref([]);
const fetchCompanies = async () => {
    try {
        const response = await axios.get('http://127.0.0.1:8000/api/company/all');
        companies.value = response.data;
        console.log(companies);
    } catch (error) {
        console.error('Error fetching companies:', error);
    }
};


fetchCompanies();
</script>

<template>
    <Head title="Employee Edit" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Employee Edit</h2>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mt-5">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <form @submit.prevent="updateEmployee" class="space-y-6">
                    <div>
                        <InputLabel for="first_name" value="First name" />
                        <TextInput id="first_name" type="text" class="mt-1 block w-full" v-model="form.first_name" autofocus
                            autocomplete="off" />

                        <InputError class="mt-2" :message="form.errors.first_name" />
                    </div>
                    <div>
                        <InputLabel for="last_name" value="Last name" />
                        <TextInput id="last_name" type="text" class="mt-1 block w-full" v-model="form.last_name" autofocus
                            autocomplete="off" />

                        <InputError class="mt-2" :message="form.errors.last_name" />
                    </div>
                    <div>
                        <InputLabel for="company" value="Select a company" />
                        <select id="company"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                            v-model="form.companyId">
                            <option value="" disabled>Select a company</option>
                            <option v-for="company in companies" :key="company.id" :value="company.id">{{ company.name }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.company_id" />
                    </div>

                    <div>
                        <InputLabel for="email" value="Email" />
                        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email"
                            autocomplete="off" />
                    </div>

                    <div>
                        <InputLabel for="phone" value="Phone" />
                        <TextInput id="phone" type="text" class="mt-1 block w-full" v-model="form.phone"
                            autocomplete="off" />
                    </div>

                    <div class="flex justify-end">
                        <PrimaryButton :disabled="form.processing">Update</PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>



