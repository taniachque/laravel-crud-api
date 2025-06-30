import { createApp } from 'vue';
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.css';

const app = createApp({
    data() {
        return {
            records: [],
            record: {
                uuid: null,
                name: '',
                description: '',
                code: '',
                status: 'active'
            },
            isEditing: false,
            modalInstance: null,
            searchTerm: '',
        };
    },
    mounted() {
        this.fetchRecords();
        const modalElement = document.getElementById('recordModal');
        if (modalElement) {
            this.modalInstance = new bootstrap.Modal(modalElement);
            modalElement.addEventListener('hidden.bs.modal', this.resetForm);
        } else {
            console.error('Modal element with ID "recordModal" not found in the DOM.');
        }
    },
    beforeUnmount() {
        const modalElement = document.getElementById('recordModal');
        if (modalElement && this.resetForm) {
            modalElement.removeEventListener('hidden.bs.modal', this.resetForm);
        }
    },
    methods: {
        async fetchRecords() {
            try {
                const params = {};
                if (this.searchTerm) {
                    params.search = this.searchTerm;
                }
                const response = await axios.get('/api/records', { params });
                this.records = response.data;
                console.log('Records fetched successfully:', this.records);
            } catch (error) {
                console.error('Error fetching records:', error);
            }
        },

        showModal() {
            this.isEditing = false;
            this.resetForm();
            if (this.modalInstance) {
                this.modalInstance.show();
            } else {
                console.error('Modal instance not available.');
            }
        },

        hideModal() {
            if (this.modalInstance) {
                this.modalInstance.hide();
            } else {
                console.error('Modal instance not available for hiding.');
            }
        },

        editRecord(record) {
            this.isEditing = true;
            this.record = { ...record };
            if (this.modalInstance) {
                this.modalInstance.show();
            } else {
                console.error('Modal instance not available.');
            }
        },

        async saveRecord() {
            console.log('Data to send (saveRecord):', this.record);
            try {
                if (this.isEditing) {
                    console.log('Sending PUT for UUID:', this.record.uuid);
                    await axios.put(`/api/records/${this.record.uuid}`, this.record);
                } else {
                    console.log('Sending POST (new record)');
                    await axios.post('/api/records', this.record);
                }
                this.fetchRecords();
                if (this.modalInstance) {
                    this.modalInstance.hide();
                }
            } catch (error) {
                console.error('Error saving record:', error);
                if (error.response) {
                    console.error('Server error response:', error.response.data);
                    console.error('Error status code:', error.response.status);
                }
            }
        },

        async deleteRecord(uuid) {
            if (confirm('Are you sure you want to delete this record?')) {
                try {
                    await axios.delete(`/api/records/${uuid}`);
                    this.fetchRecords();
                } catch (error) {
                    console.error('Error deleting record:', error);
                    if (error.response) {
                        console.error('Server error response:', error.response.data);
                        console.error('Error status code:', error.response.status);
                    }
                }
            }
        },

        resetForm() {
            this.record = {
                uuid: null,
                name: '',
                description: '',
                code: '',
                status: 'active'
            };
            this.isEditing = false;
        },

        clearSearch() {
            this.searchTerm = '';
            this.fetchRecords();
        }
    },
});

app.mount('#app');
