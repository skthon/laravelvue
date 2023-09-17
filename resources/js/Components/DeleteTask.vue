<script>
import Button from 'primevue/button';
import Dialog from "primevue/dialog";
import axios from 'axios';

export default {
    name: "DeleteTask",
    components: {
        Button,
        Dialog
    },
    props: {
        id: Number
    },
    emits: ['refreshTasks'],
    data() {
        return {
            message: '',
            showForm: false,
            formTitle: "Delete Task"
        };
    },
    methods: {
        openForm() {
            this.showForm = true;
        },
        closeForm() {
            this.showForm = false;
        },
        deleteForm() {
            axios.delete('/tasks/' + this.id)
                .then((response) => {
                    console.log('Response:', response.data);
                    this.closeForm();
                    this.$emit('refresh-tasks');
                })
                .catch((error) => {
                    this.message = 'Could not delete the task, please try again';
                    // Handle any errors here
                    console.error('Error:', error);
                });
        },
        cancelForm() {
            this.closeForm();
        },
    },
};
</script>

<template>
    <a class="btn m-2" style="color:white" @click="showForm = true">&#10006;</a>

    <Dialog v-model:visible="showForm" modal header="Delete Task" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '100vw' }">
        <div class="modal-content">
                <div class="modal-content">
                    <span v-if="message != ''" class="alert alert-warning" role="alert">
                        {{ message }}
                    </span>
                    <div class="modal-body">
                        Are you sure you want to delete this this task #{{ this.id }}?
                    </div>
                    <div class="modal-footer m-4">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary m-2" @click="deleteForm">Delete</button>
                            <button type="button" class="btn btn-secondary" @click="cancelForm">Cancel</button>
                        </div>
                    </div>
                </div>
        </div>
    </Dialog>
</template>
