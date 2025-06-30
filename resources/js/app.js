import Vue from 'vue';
import axios from 'axios';
import { BootstrapVue } from 'bootstrap-vue';

Vue.use(BootstrapVue);
Vue.prototype.$http = axios;

const app = new Vue({
    el: '#app',
    data: {
        records: [],
        record: { name: '', description: '', code: '', status: '' },
        isEditing: false,
    },
    mounted() {
        this.fetchRecords();
    },
    methods: {
        fetchRecords() {
            this.$http.get('/api/records')
                .then(response => {
                    this.records = response.data;
                });
        },
        showModal() {
            this.isEditing = false;
            this.record = { name: '', description: '', code: '', status: '' };
            this.$bvModal.show('recordModal');
        },
        editRecord(record) {
            this.isEditing = true;
            this.record = { ...record };
            this.$bvModal.show('recordModal');
        },
        saveRecord() {
            if (this.isEditing) {
                this.$http.put(`/api/records/${this.record.id}`, this.record)
                    .then(() => {
                        this.fetchRecords();
                        this.$bvModal.hide('recordModal');
                    });
            } else {
                this.$http.post('/api/records', this.record)
                    .then(() => {
                        this.fetchRecords();
                        this.$bvModal.hide('recordModal');
                    });
            }
        },
        deleteRecord(id) {
            this.$http.delete(`/api/records/${id}`)
                .then(() => {
                    this.fetchRecords();
                });
        },
        resetForm() {
            this.record = { name: '', description: '', code: '', status: '' };
            this.isEditing = false;
        },
    },
});