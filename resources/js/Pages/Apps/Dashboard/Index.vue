<template>

    <Head>
        <title>Dashboard - Aplikasi Form Master</title>
    </Head>

    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">

                <div class="row">
                    <p class="text-black-center"> hello </p>
                </div>

            </div>
        </div>
    </main>
</template>

<script>
    //import layout
    import LayoutApp from '../../../Layouts/App.vue';

    //import Heade and useForm from Inertia
    import { Head } from '@inertiajs/inertia-vue3';

    export default {

        //layout
        layout: LayoutApp,

        //register component
        components: {
            Head,
        },
    }
</script>

<style>

</style>