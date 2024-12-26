<script setup lang="ts">
import {useDate} from 'vuetify'
import {type Task, type TaskResponse, TaskStatusEnum} from "~/types/tasks";
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import type {VueQuillEditor} from '~/plugins/vue-quill-plugin'
import type {User} from "~/types/user";
import type ErrorResponse from "~/types/errorResponse";
import type {AsyncDataRequestStatus} from "#app/composables/asyncData";
import { VDateInput } from 'vuetify/labs/VDateInput'

const {task, users, isLoading} = defineProps<{
  task: Task,
  users: User[],
  isLoading: boolean
}>()

defineEmits(['click'])

const date = useDate()

const taskStatusEnumValues = [
  {
    value: TaskStatusEnum.NEW,
    title: 'Новая',
  },
  {
    value: TaskStatusEnum.IN_PROGRESS,
    title: 'В работе',
  },
  {
    value: TaskStatusEnum.DONE,
    title: 'Завершена',
  },
]

const responseError = ref<ErrorResponse | null | undefined>(null)

async function saveTask() {
  responseError.value = null

  if (task.id > 0) {
    // Update existing task
    const { data: taskData, status: taskReqStatus, error: taskRespError } = await useApiRequest<TaskResponse, ErrorResponse>('PATCH', `/api/tasks/${task.id}`, task)

    if (taskReqStatus.value === 'success') {
      taskSavedSuccessfullySnackbar.value = true
      navigateTo(`/task/${taskData.value?.data.id}`)
    } else if (taskReqStatus.value === 'error') {
      responseError.value = taskRespError.value?.data
    }
  } else {
    // Create new task
    const { data: taskData, status: taskReqStatus, error: taskRespError } = await useApiRequest<TaskResponse, ErrorResponse>('POST', '/api/tasks', task)

    if (taskReqStatus.value === 'success') {
      taskSavedSuccessfullySnackbar.value = true
      navigateTo(`/task/${taskData.value?.data.id}`)
    } else if (taskReqStatus.value === 'error') {
      responseError.value = taskRespError.value?.data
    }
  }
}

async function deleteTask() {
  responseError.value = null

  if (task.id < 0) {
    return
  }

  const { data: taskData, status: taskReqStatus, error: taskRespError } = await useApiRequest<TaskResponse, ErrorResponse>('DELETE', `/api/tasks/${task.id}`, task)

  if (taskReqStatus.value === 'success') {
    navigateTo('/my-tasks')
  } else if (taskReqStatus.value === 'error') {
    responseError.value = taskRespError.value?.data
  }
}

const taskSavedSuccessfullySnackbar = ref(false)
</script>

<template>
  <v-card :loading="isLoading" @click="$emit('click', task)" :link="false" :min-height="400">
    <v-card-item>
      <v-card-title>
        <v-text-field
          v-model="task.title"
          label="Название задачи"
          hide-details
          single-line
          variant="plain"
          :prefix="task.id ? '#' + task.id : undefined"
          placeholder="Название задачи"
          persistent-placeholder
          class="pb-2"
        ></v-text-field>
      </v-card-title>

      <v-card-subtitle>
        <span>Автор: {{ task.author?.name || '?' }} | Создана {{
            date.format(task.created_at, 'fullDate')
          }}</span>
        <span>
          <v-select
            v-model="task.assignee_id"
            :items="users || []"
            item-value="id"
            item-title="name"
            label="Исполнитель"
            hide-details
            clearable
            variant="plain"
            placeholder="Исполнитель"
            class="pb-2"
          ></v-select>
        </span>
        <strong
          v-if="task.deadline_at && !date.isAfterDay(task.deadline_at, new Date())"
          class="text-error"
        >
          Достигнут крайний срок исполнения задачи!
        </strong>
      </v-card-subtitle>
    </v-card-item>

    <v-card-text>
      <ClientOnly fallback-tag="div">
        <vue-quill-editor
          v-model:content="task.description_content"
          theme="snow"
          placeholder="Описание задачи"
          content-type="html"
        ></vue-quill-editor>

        <template #fallback>
          <div class="description-content" v-html="task.description_content"></div>
        </template>
      </ClientOnly>
    </v-card-text>

    <v-alert v-if="responseError" type="error" class="ma-3">
      <template #title>
        <v-alert-title>Ошибки:</v-alert-title>
      </template>

      <ul>
        <li v-for="(err, errIndex) in [].concat(...Object.values(responseError?.errors))" :key="errIndex">{{ err }}</li>
      </ul>
    </v-alert>

    <v-spacer></v-spacer>

    <v-card-actions class="flex-wrap">
      <div class="d-flex flex-1-1-100">
        <div class="flex-fill mr-2">
          <v-select
            v-model="task.status"
            :items="taskStatusEnumValues"
            hide-details
          ></v-select>
        </div>
        <div class="flex-fill ml-2">
          <v-date-input
            v-model="task.deadline_at"
            label="Крайник срок"
            hide-details
            placeholder="Крайник срок"
            clearable
            @click:clear="task.deadline_at = null"
          ></v-date-input>
        </div>
      </div>
      <v-spacer></v-spacer>
      <v-btn-group>
        <v-btn icon="mdi-check" color="primary" title="Сохранить" @click.stop="saveTask"></v-btn>
        <v-btn v-if="task.id > 0" icon="mdi-delete-outline" color="error" title="Удалить" @click.stop="deleteTask"></v-btn>
      </v-btn-group>
    </v-card-actions>

    <v-snackbar
      v-model="taskSavedSuccessfullySnackbar"
      color="success"
      :timeout="3000"
      timer
    >
      Задача сохранена успешно
    </v-snackbar>
  </v-card>
</template>

<style scoped>
.description-content > *:not(:first-child) {
  margin-top: 1em;
}
</style>
