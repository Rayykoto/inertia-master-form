<template>
    <Head>
        <title>Tes Table Dinamis</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 rounded-3 shadow border-top-purple">
                        <div class="card-header">
                            <span class="font-weight-bold"><i class="fa fa-shield-alt"></i> TABLE DINAMIS</span>
                        </div>
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <Link href="#" class="btn btn-primary input-group-text" data-bs-toggle="modal" data-bs-target="#addModal"> <i class="fa fa-plus-circle me-2"></i> NEW</Link>
                            </div>                     
                       </div>
                    </div>
                </div>
            </div>

            <!-- The Modal -->
                <div class="modal" id="addModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Modal Heading</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label class="fw-bold">Name Table</label>
                                <input class="form-control" type="text" placeholder="Name Column">
                            </div>
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button class="btn btn-primary shadow-sm rounded-sm" type="submit">SAVE</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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

import { Inertia } from '@inertiajs/inertia';

import Swal from 'sweetalert2';

export default {
    layout: LayoutApp,

    components: {
            Head,
            Link
        },
}

</script>

<style>

</style>