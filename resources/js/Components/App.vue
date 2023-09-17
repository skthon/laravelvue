<script>

import ListTasks from "./ListTasks.vue";

export default {
    components: {
        ListTasks
    }
}
</script>

<template>
    <nav class="navbar justify-content-center">
        <h3 class="align-center">Task Management Application</h3>
    </nav>
    <div class="container-fluid mx-auto" style="max-width: 1480px;">
        <ListTasks></ListTasks>
    </div>
</template>
