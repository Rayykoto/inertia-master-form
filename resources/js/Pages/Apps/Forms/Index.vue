<template>
    <Head>
        <title>FORMS - Master Form</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 rounded-3 shadow border-top-purple">
                        <div class="card-header">
                            <span class="font-weight-bold"><i class="fa fa-form"></i> Master Forms</span>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="input-group mb-3">
                                    <Link href="/apps/forms/create" class="btn btn-primary input-group-text"> <i class="fa fa-plus-circle me-2"></i> NEW</Link>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card border-0 rounded-3 shadow border-top-purple">
                                            <div class="card-header">
                                                <span class="font-weight-bold"><i class="fa fa-chart-bar"></i> DIVISION</span>
                                            </div>
                                            <div class="card-body">
                                                <form @submit.prevent="filter">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">DIVISION</label>
                                                                <select class="form-control">
                                                                    <option value="">-- Select Division --</option>
                                                                    <option>Support</option>
                                                                    <option>Marketing</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold text-white">*</label>
                                                                <button class="btn btn-md btn-purple border-0 shadow w-100"><i class="fa fa-filter"></i> FILTER</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-md-12">
                                    <div class="form-group">
                                    <label class="font-weight-bold">DIVISION</label>
                                    <select class="form-control">
                                        <option value="">-- Select Division --</option>
                                        <option>Support</option>
                                        <option>Marketing</option>
                                    </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label class="font-weight-bold">FORMS</label>
                                    <select class="form-control">
                                        <option value="">-- Select Forms --</option>
                                        <option>Forms Cuti</option>
                                        <option>Forms Ribet</option>
                                    </select>
                                    </div>
                                </div> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
   
</template>

<script>

import LayoutApp from '../../../Layouts/App.vue';

export default {
    
    layout: LayoutApp,
}

</script>