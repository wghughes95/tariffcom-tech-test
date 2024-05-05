<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    prefixname: '',
    firstname: '',
    middlename: '',
    lastname: '',
    suffixname: '',
    email: '',
    password: '',
    password_confirmation: '',
    photo: ''
});

const prefix = [{ value: 'Mr', name: 'Mr' }, { value: 'Mrs', name: 'Mrs' }, { value: 'Ms', name: 'Ms' }];

const photoInput = ref(null);

const updatePhoto = () => {
    const photo = photoInput.value.files[0];

    if (!photo) return;
};

const submit = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files[0];
    }

    form.post(route('users.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Create New User" />

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="prefixname" value="Prefix" />

                        <SelectInput v-model="form.prefixname" keyIndex="code" valueIndex="id" labelIndex="name"
                            :data="prefix" class="mt-1 block w-full" />

                        <InputError class="mt-2" :message="form.errors.prefixname" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="firstname" value="First Name" />

                        <TextInput id="firstname" type="text" class="mt-1 block w-full" v-model="form.firstname" required
                            autofocus autocomplete="firstname" />

                        <InputError class="mt-2" :message="form.errors.firstname" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="middlename" value="Middle Name" />

                        <TextInput id="middlename" type="text" class="mt-1 block w-full" v-model="form.middlename" required
                            autofocus autocomplete="middlename" />

                        <InputError class="mt-2" :message="form.errors.middlename" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="lastname" value="Last Name" />

                        <TextInput id="lastname" type="text" class="mt-1 block w-full" v-model="form.lastname" required
                            autofocus autocomplete="lastname" />

                        <InputError class="mt-2" :message="form.errors.lastname" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="suffixname" value="Suffix" />

                        <TextInput id="suffixname" type="text" class="mt-1 block w-full" v-model="form.suffixname" required
                            autofocus autocomplete="suffixname" />

                        <InputError class="mt-2" :message="form.errors.suffixname" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="email" value="Email" />

                        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                            autocomplete="username" />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="password" value="Password" />

                        <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                            autocomplete="new-password" />

                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="password_confirmation" value="Confirm Password" />

                        <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
                            v-model="form.password_confirmation" required autocomplete="new-password" />

                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="photo" value="Avatar Photo" />

                        <input id="photo" type="file" class="mt-1 block w-full" ref="photoInput" required accept="image/*"
                            @change="updatePhoto" />

                        <InputError class="mt-2" :message="form.errors.photo" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Create
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>


    </AuthenticatedLayout>
</template>
