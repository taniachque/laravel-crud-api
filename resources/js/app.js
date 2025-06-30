import { createApp } from 'vue';
import axios from 'axios';
import { BootstrapVue3 } from 'bootstrap-vue-3';

const app = createApp({
    data() {
        return {
            records: [],
            record: { name: '', description: '', code: '', status: '' },
            isEditing: false,
        };
    },
    mounted() {
        this.fetchRecords();
    },
    methods: {
        fetchRecords() {
            axios.get('/api/records')
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
                axios.put(`/api/records/${this.record.id}`, this.record)
                    .then(() => {
                        this.fetchRecords();
                        this.$bvModal.hide('recordModal');
                    });
            } else {
                axios.post('/api/records', this.record)
                    .then(() => {
                        this.fetchRecords();
                        this.$bvModal.hide('recordModal');
                    });
            }
        },
        deleteRecord(id) {
            axios.delete(`/api/records/${id}`)
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

app.use(BootstrapVue3);
app.mount('#app');