<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Records</title>
</head>

<body>
    <div id="app" class="container">
        <h1>Records</h1>
        <button class="btn btn-primary" @click="showModal()">Add Record</button>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Code</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="record in records" :key="record.id">
                    <td v-text="record.name"></td>
                    <td v-text="record.description"></td>
                    <td v-text="record.code"></td>
                    <td v-text="record.status"></td>
                    <td>
                        <button @click="editRecord(record)" class="btn btn-warning">Edit</button>
                        <button @click="deleteRecord(record.id)" class="btn btn-danger">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <b-modal id="recordModal" @hide="resetForm()">
            <template #modal-title>
                <span v-if="isEditing">Edit Record</span>
                <span v-else>Add Record</span>
            </template>
            <form @submit.prevent="saveRecord">
                <b-form-group label="Name">
                    <b-form-input v-model="record.name" required></b-form-input>
                </b-form-group>
                <b-form-group label="Description">
                    <b-form-textarea v-model="record.description"></b-form-textarea>
                </b-form-group>
                <b-form-group label="Code">
                    <b-form-input v-model="record.code" required></b-form-input>
                </b-form-group>
                <b-form-group label="Status">
                    <b-form-select v-model="record.status" :options="['active', 'inactive']" required></b-form-select>
                </b-form-group>
                <b-button type="submit" variant="primary">
                    <span v-if="isEditing">Update</span>
                    <span v-else>Save</span>
                </b-button>
            </form>
        </b-modal>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
