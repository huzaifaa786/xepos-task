<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const form = ref({
    name: '',
    email: '',
    logo: '',
    logoPreview: null,
    website: '',
    errors: {}
});

const createCompany = async () => {
    try {
        const formData = new FormData();

        formData.append('name', form.value.name);
        formData.append('email', form.value.email);
        formData.append('logo', form.value.logo);
        formData.append('website', form.value.website);

        await axios.post('http://127.0.0.1:8000/api/company/store', formData).then(response => {
            console.log(response);

            alert('Company created successfully');
            form.value.errors = {};
        }).catch(error => {

            if (error.response && error.response.data) {
                console.log(error.response.data);
                form.value.errors = error.response.data;
                if (form.value.errors.name) {
                    form.value.errors.name = form.value.errors.name[0];
                }
            }
        });

        // Clear form fields
        form.value.name = '';
        form.value.email = '';
        form.value.logo = '';
        form.value.logoPreview = null;
        form.value.website = '';

    } catch (error) {
        console.error('Error creating company:', error);
        alert('An error occurred while creating the company. Please try again.');
    }
};

const handleLogoChange = (event) => {
    const file = event.target.files[0];
    form.value.logo = file;
    if (file) {
        const reader = new FileReader();
        reader.onload = () => {
            form.value.logoPreview = reader.result;
        };
        reader.readAsDataURL(file);
    }
};

const handleImageDrop = (event) => {
    event.preventDefault();
    const file = event.dataTransfer.files[0];
    if (file) {
        form.value.logo = file;
        const reader = new FileReader();
        reader.onload = () => {
            form.value.logoPreview = reader.result;
        };
        reader.readAsDataURL(file);
    }
};
</script>

<template>
    <Head title="Company Create" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Company Create</h2>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mt-5">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <form @submit.prevent="createCompany" class="space-y-6">
                    <div>
                        <InputLabel for="name" value="Name" />
                        <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus
                            autocomplete="off" />

                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div>
                        <InputLabel for="email" value="Email" />
                        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email"
                            autocomplete="off" />
                    </div>

                    <div id="logo-drop-area" class="drop-area" @drop.prevent="handleImageDrop" @dragover.prevent>
                        <InputLabel for="logo" value="Select Logo or Drag Here" />
                        <input type="file" id="logo" @change="handleLogoChange" ref="" accept="image/*">
                        <img v-if="form.logoPreview" :src="form.logoPreview" alt="Logo Preview" style="max-width: 200px;">
                    </div>

                    <div>
                        <InputLabel for="website" value="Website" />
                        <TextInput id="website" type="text" class="mt-1 block w-full" v-model="form.website"
                            autocomplete="off" />
                    </div>

                    <div class="flex justify-end">
                        <PrimaryButton :disabled="form.processing">Create</PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.drop-area {
    border: 2px dashed #ccc;
    padding: 20px;
    position: relative;
    cursor: pointer;
}

.drop-area:hover {
    background-color: #f8f8f8;
}

.drop-area input[type="file"] {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}
</style>
