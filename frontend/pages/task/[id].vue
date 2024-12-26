<script setup lang="ts">
import type {UserData, UsersResponse} from '~/types/user'
import {TaskStatusEnum, type Task, type TasksResponse, type TaskResponse} from "~/types/tasks";
import type ErrorResponse from "~/types/errorResponse";

definePageMeta({
  middleware: ['sanctum:auth'],
});

const user = useSanctumUser<UserData>()

const route = useRoute()

const { data: taskData, status: tasksRequestStatus, error: tasksRespError } = await useApiRequest<TaskResponse, ErrorResponse>('GET', `/api/tasks/${route.params.id}`)
const { data: usersData, status: usersRequestStatus } = await useApiRequest<UsersResponse>('GET', `/api/users`)

// FIXME date converting workaround
if (taskData.value?.data.deadline_at) {
  taskData.value.data.deadline_at = new Date(taskData.value?.data.deadline_at)
}

if (tasksRespError.value?.statusCode === 404) {
  throw createError({ statusCode: 404, statusMessage: 'Задача не найдена' })
}
</script>

<template>
  <v-container>
    <v-row justify="center">
      <v-col md="6">
        <task-card-detail
          :is-loading="tasksRequestStatus === 'pending' || usersRequestStatus === 'pending'"
          :task="taskData.data"
          :users="usersData.data"
        ></task-card-detail>
      </v-col>
    </v-row>
  </v-container>
</template>
