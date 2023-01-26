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
                                                
                                                    <div class="row" id="app">
                                                        <div class="col-md-12" id="app">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">DIVISION</label>
                                                                <select class="form-control" v-model="selectedDivisionIds" @change="getForms">
                                                                    <option disabled value="">-- Select Division --</option>
                                                                    <option v-for="division in divisions" :key="division.id"> {{ division.name }}</option>
                                                                </select>
                                                            </div>
                                                            <div v-if="fiteredForm.length" class="mb-3">
                                                                <label class="form-label fw-bold">FORMS</label>
                                                                <select class="form-control" v-model="selectedFormIds">
                                                                    <option disabled value="">-- Select Forms --</option>
                                                                    <option v-for="form in forms" :key="form.id">{{ form.name }}</option>
                                                                </select>   
                                                            </div>
                                                        </div>
                                                    </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

    data() {
        return {
            divisions: [
                { id: 1, name: 'Support' },
                { id: 2, name: 'Marketing' },
                { id: 3, name: 'Application Support' },
            ],
            forms : [
                {id: 1, name: 'Form Absensi', division_id: 1, url: 'tes'},
                {id: 2, name: 'Form Sakit', division_id: 2, url: 'tes'},
                {id: 1, name: 'Form Kerja', division_id: 3, url: 'tes'},
                {id: 1, name: 'Form Cuti', division_id: 1, url: 'tes'},
                {id: 1, name: 'Form Melahirkan', division_id: 2, url: 'tes'},
                {id: 1, name: 'Form Lembur', division_id: 1, url: 'tes'},
            ],
            selectedDivisionIds: -1,
            selectedFormIds: -1
        },
        methods = {
            getForms() {
                this.selectedFormIds = -1;
                if(!this.selectedDivisionIds) {
                    this.selectedDivisionIds = -1;
                }
            }
        },
        computed = {
            forms() {
                let filteredsubForms = [];
                for(let i = 0; i < this.subForms.length ; i++) {
                    let subForms = this.subForms[i];
                    if(subForms.division_id == this.selectedDivisionIds) {
                        filteredsubForms.push(subForms);
                    }
                }

                return filteredsubForms;
            }
        }
    }


}

</script>