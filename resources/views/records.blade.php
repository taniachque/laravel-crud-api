<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Records</title>
    @vite(['resources/css/app.css'])
</head>

<body>
    <div id="app" class="container mt-4">
        <h1 class="mb-4">Records</h1>
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <button class="btn btn-primary me-3" @click="showModal()">Add Record</button>
            <div class="input-group w-75">
                <input type="text" class="form-control" placeholder="Search by name, description, or code..."
                    v-model="searchTerm" @keyup.enter="fetchRecords()">
                <button class="btn btn-outline-secondary" type="button" @click="fetchRecords()">Search</button>
                <button class="btn btn-outline-danger" type="button" @click="clearSearch()">Clear</button>
            </div>
        </div>

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
                <tr v-for="record in records" :key="record.uuid">
                    <td v-text="record.name"></td>
                    <td v-text="record.description"></td>
                    <td v-text="record.code"></td>
                    <td v-text="record.status"></td>
                    <td>
                        <button @click="editRecord(record)" class="btn btn-warning">Edit</button>
                        <button @click="deleteRecord(record.uuid)" class="btn btn-danger">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="modal fade" id="recordModal" tabindex="-1" aria-labelledby="recordModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="recordModalLabel">
                            <span v-if="isEditing">Edit Record</span>
                            <span v-else>Add Record</span>
                        </h5>
                        <button type="button" class="btn-close" @click="hideModal()" aria-label="Close"></button>
                    </div>
                    <form @submit.prevent="saveRecord">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="recordName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="recordName" v-model="record.name"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="recordDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="recordDescription" v-model="record.description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="recordCode" class="form-label">Code</label>
                                <input type="text" class="form-control" id="recordCode" v-model="record.code"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="recordStatus" class="form-label">Status</label>
                                <select class="form-select" id="recordStatus" v-model="record.status" required>
                                    <option value="active">active</option>
                                    <option value="inactive">inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="hideModal()">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <span v-if="isEditing">Update</span>
                                <span v-else>Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/js/app.js'])
</body>

</html>
