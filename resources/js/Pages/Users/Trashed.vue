<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { IdentificationIcon, TrashIcon, ArrowUturnLeftIcon } from '@heroicons/vue/24/outline';
import moment from "moment";

defineProps(['users']);

const form = useForm({});

const restoreUser = (id) => {
    form.patch(route('users.restore', [id]));
};

const deleteUser = (id) => {
    form.delete(route('users.delete', [id]));
};
</script>

<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
            <h1 class="font-medium leading-tight text-4xl mt-0 mb-2">Users</h1>
            <table class="table-auto border border-slate-500 bg-white">
                <thead>
                    <tr class="bg-black text-white">
                        <th class="w-60 border border-slate-600">Name</th>
                        <th class="w-60 border border-slate-600">Email</th>
                        <th class="w-60 border border-slate-600">Avatar Photo</th>
                        <th class="w-60 border border-slate-600">Date Created</th>
                        <th class="w-30 border border-slate-600">Restore</th>
                        <th class="w-30 border border-slate-600">Show</th>
                        <th class="w-30 border border-slate-600">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" class="text-center">
                        <td class="border border-slate-600">{{ user.prefixname + ' ' + user.firstname + ' ' +
                            user.middlename + ' ' + user.lastname + ' ' + user.suffixname }}</td>
                        <td class="border border-slate-600">{{ user.email }}</td>
                        <td class="border border-slate-600"><img :src="`/storage/` + user.photo"></td>
                        <td class="border border-slate-600">{{ moment(user.created_at).format("DD-MM-YYYY") }}</td>
                        <td class="border border-slate-600">
                            <button @click="restoreUser(user.id)"
                                class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 p-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <ArrowUturnLeftIcon class="h-5 w-5" />
                            </button>
                        </td>
                        <td class="border border-slate-600">
                            <a :href="route('users.show', [user.id])"
                                class="inline-flex justify-center rounded-md border border-transparent bg-green-600 p-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                <IdentificationIcon class="h-5 w-5" />
                            </a>
                        </td>
                        <td class="border border-slate-600">
                            <button @click="deleteUser(user.id)"
                                class="inline-flex justify-center rounded-md border border-transparent bg-red-600 p-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                <TrashIcon class="h-5 w-5" />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-10">
                <a :href="route('users.create')"
                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Add New User
                </a>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
