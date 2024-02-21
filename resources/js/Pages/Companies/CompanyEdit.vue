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
    name: '',
    email: '',
    logo: null,
    website: '',
    errors: {}
});

const publishData = async () => {
    const page = usePage();
    let company = ref(page.props.company);
    form.value.name = company.value.name;
    form.value.email = company.value.email;
    form.value.logo = company.value.logo;
    form.value.website = company.value.website;


}

publishData();

const updateCompany = async () => {
    try {
        const formData = new FormData();
        formData.append('name', form.value.name);
        formData.append('email', form.value.email);
        formData.append('logo', form.value.logo);
        formData.append('website', form.value.website);
        const page = usePage();




        let company = ref(page.props.company);


        await axios.post('http://127.0.0.1:8000/api/company/update/' + company.value.id, formData).then(response => {

            form.value.name = response.data.name;
            form.value.email = response.data.email;
            form.value.logo = response.data.logo;
            form.value.website = response.data.website;
            alert('Company updated successfully');
            form.value.errors = {};
        }).catch(error => {

            if (error.response && error.response.data) {

                form.value.errors = error.response.data;

            }
        });

    } catch (error) {
        console.error('Error updating company:', error);
        alert('An error occurred while updating the company. Please try again.');
    }
};


const handleLogoChange = (event) => {
    const file = event.target.files[0];
    form.value.logo = file;
};
</script>

<template>
    <Head title="Company Edit" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Company Edit</h2>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mt-5">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <form @submit.prevent="updateCompany" class="space-y-6">
                    <div>
                        <InputLabel for="name" value="Name" />
                        <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus required
                            autocomplete="off" />
                    </div>

                    <div>
                        <InputLabel for="email" value="Email" />
                        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email"
                            autocomplete="off" />
                    </div>

                    <div>
                        <InputLabel for="logo" value="Logo" />
                        <input type="file" id="logo" @change="handleLogoChange" accept="image/*">
                    </div>

                    <div>
                        <InputLabel for="website" value="Website" />
                        <TextInput id="website" type="text" class="mt-1 block w-full" v-model="form.website"
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
