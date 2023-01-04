<template>
    <Head>
        <title>Verification - Aplikasi Master Form</title>
    </Head>
    <div class="col-md-4">
        <div class="fade-in">
            <div class="text-center mb-4">
                <a href="" class="text-dark text-decoration-none">
                    <img src="/images/koto-01.svg" width="70">
                </a>
            </div>
            <div class="card-group">
                <div class="card border-top-purple border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <div class="text-start">
                            <h5>Akun Kamu Belum Terverfikasi</h5>
                        </div>
                        <hr>
                        <p>Silahkan Cek Email Kamu Untuk Verifikasi!</p>
                        <div v-if="session.status" class="alert alert-success mt-2">
                            {{ session.status }}
                        </div>
                        <form @submit.prevent="submit">
                            <button class="btn btn-primary shadow-sm rounded-sm px-4 w-100" type="submit">KIRIM ULANG</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    //import layout
    import LayoutAuth from '../../Layouts/Auth.vue';

    //import reactive
    import { reactive } from 'vue';

    //inertia adapter
    import { Inertia } from '@inertiajs/inertia';

    //import Heade and useForm from Inertia
    import {
        Head,
        Link,
    } from '@inertiajs/inertia-vue3';

    export default {

        //layout
        layout: LayoutAuth,

        //register component
        components: {
            Head,
            Link
        },

        props: {
            errors: Object,
            session: Object
        },

        //define composition API
        setup() {

            //submit method
            const submit = () => {
                Inertia.post('verification-notification', {
                  
                });
            }

            //return form state and submit method
            return {
                submit,
            };

        }

    }
</script>

<style>

</style>