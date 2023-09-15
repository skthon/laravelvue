<script>
import Button from 'primevue/button';
import Dialog from "primevue/dialog";
import axios from 'axios'; // Import Axios

export default {
    name: "CreateTask",
    components: {
        Button,
        Dialog
    },
    emits: ['refreshTasks'],
    data() {
        return {
            message: '',
            showForm: false,
            formTitle: "Create Task",
            formData: {
                subject: "",
                description: "",
                status: "new",
                type: "bug",
            },
        };
    },
    methods: {
        openForm() {
            this.showForm = true;
        },
        closeForm() {
            this.showForm = false;
        },
        submitForm() {
            axios.post('/tasks', this.formData)
                .then((response) => {
                    console.log('Response:', response.data);
                    this.closeForm();
                    this.$emit('refresh-tasks');
                })
                .catch((error) => {
                    this.message = 'Could not save the task, please try again';
                    // Handle any errors here
                    console.error('Error:', error);
                });
        },
        cancelForm() {
            // Clear form data and close the form
            this.formData = {
                subject: "",
                description: "",
                status: "new",
                type: "bug"
            };
            this.closeForm();
        },
    },
};
</script>

<template>
    <Button label="Create Task" icon="pi" @click="showForm = true" />
    <Dialog v-model:visible="showForm" modal header="Create Task" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '100vw' }">
        <div class="modal-content">
            <form @submit.prevent="submitForm">
                <div class="modal-body">
                    <span v-if="message != ''" class="alert alert-warning" role="alert">
                        {{ message }}
                    </span>
                    <div class="form-group m-4">
                        <label for="subject" class="m-2">Subject</label>
                        <input type="text" class="form-control" id="subject" v-model="formData.subject" required="true" minlength="20" maxlength="100"/>
                    </div>
                    <div class="form-group  m-4">
                        <label for="description" class="m-2">Description</label>
                        <textarea id="description" class="form-control" v-model="formData.description" required="true" minlength="20" maxlength="300"></textarea>
                    </div>
                    <div class="form-group  m-4">
                        <label for="status" class="m-2">Status</label>
                        <select id="status" class="form-control" v-model="formData.status" required>
                            <option value="new">New</option>
                            <option value="in_progress">In Progress</option>
                            <option value="resolved">Resolved</option>
                            <option value="feedback">Feedback</option>
                            <option value="closed">Closed</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="form-group  m-4">
                        <label for="tracker" class="m-2">Tracker</label>
                        <select id="type" class="form-control" v-model="formData.type" required>
                            <option value="bug">Bug</option>
                            <option value="feature">Feature</option>
                            <option value="support">Support</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer m-4">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary m-2">Submit</button>
                        <button type="button" class="btn btn-secondary" @click="cancelForm">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </Dialog>
</template>
