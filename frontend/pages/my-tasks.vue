<script setup lang="ts">
import TasksBoard from "~/components/TasksBoard.vue";
import type {TasksResponse} from "~/types/tasks";

definePageMeta({
  middleware: ['sanctum:auth'],
});

const { data, status } = await useApiRequest<TasksResponse>('GET', '/api/tasks/my', undefined, undefined, undefined, true)

</script>

<template>
  <v-container>
    <tasks-board :is-loading="status === 'pending'" :tasks="data?.data || []"></tasks-board>
  </v-container>
</template>
