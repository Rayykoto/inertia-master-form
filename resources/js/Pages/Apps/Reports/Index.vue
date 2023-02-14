<template>
    <Head>
        <title>FORMS - Master Reports</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <!-- <div class="input-group mb-3">
                <Link href="/apps/master/forms/create" class="btn btn-primary input-group-text"> <i class="fa fa-plus-circle me-2"></i> NEW</Link>
            </div> -->
            <div class="row">
                <div v-for="form in form_access" :key="form" class="col-md-3 mx-auto card w-32 p-2">
                    <div class="card-body">
                        <h5 class="card-title">{{ form.description }}</h5>
                        <Link :href="`/apps/master/reports/${form.name}/show`" class="btn btn-primary btn-sm mt-4">Go Form</Link>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import LayoutApp from '../../../Layouts/App.vue'

import { Head, Link } from '@inertiajs/inertia-vue3';

import { Inertia } from '@inertiajs/inertia';

export default {
    layout: LayoutApp,

    components: {
        Link, Head
    },

    props: {
        form_access: Array
    }
}
</script>