<script setup lang="ts">
import type {UserData, UsersResponse} from '~/types/user'
import {TaskStatusEnum, type Task, type TasksResponse, type TaskResponse} from "~/types/tasks";
import {reactive} from 'vue'

definePageMeta({
  middleware: ['sanctum:auth'],
});

const user = useSanctumUser<UserData>()

const route = useRoute()

const { data: usersData, status: usersRequestStatus } = await useApiRequest<UsersResponse>('GET', `/api/users`)

const newTask = reactive<Task>({
  id: 0,
  title: '',
  description_content: '',
  status: TaskStatusEnum.NEW,
  author_id: user.value?.data.id,
  assignee_id: null,
  deadline_at: null,
  created_at: null,
  updated_at: null,
  author: user.value?.data,
})
</script>

<template>
  <v-container>
    <v-row justify="center">
      <v-col md="6">
        <task-card-detail
          :is-loading="usersRequestStatus === 'pending'"
          :task="newTask"
          :users="usersData.data"
        ></task-card-detail>
      </v-col>
    </v-row>
  </v-container>
</template>
