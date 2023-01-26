<template>
    <Head>
        <title> Add New Form - Master Form</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-shield-alt"></i> ADD FORM</span>
                            </div>

                            <div class="card-body">

                                <form @submit.prevent="submit">

                                    <div class="mb-3">
                                        <label class="fw-bold">Name Table</label>
                                        <input class="form-control" type="text" v-model="form.table_name" placeholder="Name Table">
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Role</label>
                                        <br>
                                        <div class="form-check form-check-inline" v-for="(role, index) in roles" :key="index">
                                            <input class="form-check-input" type="checkbox" v-model="form.roles" :value="role.name" :id="`check-${role.id}`">
                                            <label class="form-check-label" :for="`check-${role.id}`">{{ role.name }}</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                            <div class="col-12">
                                                <button class="btn btn-primary shadow-sm rounded-sm" type="submit">SAVE</button>
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import LayoutApp from '../../../Layouts/App.vue';

import { Head, Link } from '@inertiajs/inertia-vue3';

import { reactive } from 'vue';

import { Inertia } from '@inertiajs/inertia';

import Swal from 'sweetalert2';

export default {
    layout: LayoutApp,

    Components: {
        Head,
        Link
    },

    props: {
        roles: Array
    },

    setup() {
        const form = reactive({
            table_name: '',
            roles: []
        });

        const submit = () => {
            Inertia.post('/apps/master/forms/new_form', {
                name: form.table_name,
                roles: form.roles
            }, {
                onSuccess: () => {
                    Swal.fire({
                        title: 'Success!',
                        text: 'New Table Created!',
                        icon: 'success',
                        showConfirmButton: true,
                        timer:2000
                    });
                }
            })
        }

        return {
            form,
            submit,
        }
    }
}

</script>