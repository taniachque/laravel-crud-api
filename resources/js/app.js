import { createApp } from 'vue';
import axios from 'axios';
import BootstrapVue3 from 'bootstrap-vue-3';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue-3/dist/bootstrap-vue-3.css';

const app = createApp({
    data() {
        return {
            records: [],
            record: {
                id: null,
                name: '',
                description: '',
                code: '',
                status: 'active'
            },
            isEditing: false,
        };
    },
    mounted() {
        this.fetchRecords();
    },
    methods: {
        async fetchRecords() {
            try {
                const response = await axios.get('/api/records');
                this.records = response.data;
            } catch (error) {
                console.error('Error al obtener los registros:', error);
            }
        },

        showModal() {
            this.isEditing = false;
            this.resetForm();
            this.$bvModal.show('recordModal');
        },

        editRecord(record) {
            this.isEditing = true;
            this.record = { ...record };
            this.$bvModal.show('recordModal');
        },

        async saveRecord() {
            try {
                if (this.isEditing) {
                    await axios.put(`/api/records/${this.record.id}`, this.record);
                } else {
                    await axios.post('/api/records', this.record);
                }
                this.fetchRecords();
                this.$bvModal.hide('recordModal');
            } catch (error) {
                console.error('Error al guardar el registro:', error);
            }
        },

        async deleteRecord(id) {
            if (confirm('¿Estás seguro de que quieres eliminar este registro?')) {
                try {
                    await axios.delete(`/api/records/${id}`);
                    this.fetchRecords();
                } catch (error) {
                    console.error('Error al eliminar el registro:', error);
                }
            }
        },

        resetForm() {
            this.record = {
                id: null,
                name: '',
                description: '',
                code: '',
                status: 'active'
            };
            this.isEditing = false;
        },
    },
});

app.use(BootstrapVue3);
app.mount('#app');
