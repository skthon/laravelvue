<script>

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
import { FilterMatchMode } from 'primevue/api';
import InputText from "primevue/inputtext";
import CreateTask from "./CreateTask.vue";
import DeleteTask from "./DeleteTask.vue";

export default {
    name: "ListTasks",
    components : {
        DeleteTask,
        DataTable,
        Column,
        Button,
        InputText,
        Dropdown,
        CreateTask
    },
    data() {
        return {
            tasks: [],
            loaded: false,
            filters: {
                subject: { value: null, matchMode: FilterMatchMode.CONTAINS },
                status: { value: null, matchMode: FilterMatchMode.EQUALS },
                type: { value: null, matchMode: FilterMatchMode.EQUALS },
                due_date: { value: null, matchMode: FilterMatchMode.EQUALS },
            },
            statuses: [
                'new', 'in_progress', 'resolved', 'feedback', 'closed', 'rejected'
            ],
            trackers: [
                'bug', 'feature', 'support'
            ]
        };
    },
    mounted() {
        this.fetchTasks();
    },
    methods: {
        fetchTasks() {
            fetch('/tasks')
                .then(response => response.json())
                .then(response => {
                    this.tasks = response.data;
                    this.loaded = true;
                })
                .catch(error => {
                    console.error('Error fetching tasks:', error);
                });
        },
        formatDate(date) {
            date = new Date(date);
            return date.toISOString().split('T')[0];
        }
    }
}
</script>

<template>
    <div class="">
        <DataTable v-model:filters="filters"
           :value="tasks" paginator :rows="5" :rowsPerPageOptions="[5, 10]"
           dataKey="id" filterDisplay="row"
           :globalFilterFields="['subject', 'description', 'type', 'status', 'due_date']"
        >
            <template #header>
                <div class="justify-content-center">
                    <CreateTask @refresh-tasks="fetchTasks"></CreateTask>
                </div>
            </template>
            <template #empty> No tasks found.</template>
            <Column field="id" sortable header="Id"></Column>
            <Column field="subject" sortable filterField="subject" :showFilterMenu="false" header="Subject">
                <template #body="{ data }">
                    {{ data.subject }}
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="text" @input="filterCallback" class="p-column-filter" placeholder="Search by title" />
                </template>
            </Column>
            <Column field="type" filterField="type" :showFilterMenu="false" sortable header="Tracker">
                <template #body="{ data }">
                    {{ data.type }}
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <Dropdown v-model="filterModel.value" @change="filterCallback()" :options="trackers" placeholder="Select One" class="p-column-filter" style="min-width: 12rem" :showClear="true">
                        <template #option="slotProps">
                            {{ slotProps.option }}
                        </template>
                    </Dropdown>
                </template>
            </Column>
            <Column field="status" filterField="status" :showFilterMenu="false" sortable header="Status">
                <template #body="{ data }">
                    {{ data.status }}
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <Dropdown v-model="filterModel.value" @change="filterCallback()" :options="statuses" placeholder="Select One" class="p-column-filter" style="min-width: 12rem" :showClear="true">
                        <template #option="slotProps">
                            {{ slotProps.option }}
                        </template>
                    </Dropdown>
                </template>
            </Column>
            <Column field="due_date" filterField="due_date" sortable header="Due on">
                <template #body="{ data }">
                    {{ data.due_date }}
                </template>
            </Column>
            <Column field="updated_at" filterField="updated_at" sortable header="Updated">
                <template #body="{ data }">
                    {{ formatDate(data.updated_at) }}
                </template>
            </Column>
            <Column>
                <template #body="{ data }">
                    <DeleteTask :id="data.id" @refresh-tasks="fetchTasks"></DeleteTask>
                </template>
            </Column>
        </DataTable>
    </div>
</template>
<style>
.p-datatable .p-column-header-content{
    padding: 8px;
}
.p-datatable .p-datatable-thead > tr > th {
    padding: 4px;
}
.p-datatable .p-datatable-tbody > tr > td {
    padding: 4px;
}
</style>
