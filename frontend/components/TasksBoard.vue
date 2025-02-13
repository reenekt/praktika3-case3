<script setup lang="ts">
import {TaskStatusEnum, type Task} from "~/types/tasks";
import TaskCard from "~/components/TaskCard.vue";

const {tasks} = defineProps<{
  tasks: Task[],
  isLoading: boolean,
}>()

const newTasks = computed(() => {
  return tasks.filter((task) => task.status === TaskStatusEnum.NEW)
})
const inProgressTasks = computed(() => {
  return tasks.filter((task) => task.status === TaskStatusEnum.IN_PROGRESS)
})
const doneTasks = computed(() => {
  return tasks.filter((task) => task.status === TaskStatusEnum.DONE)
})
</script>

<template>
  <v-row justify="center">
    <v-col cols="12" md="4">
      <h3>Новые задачи</h3>

      <v-skeleton-loader v-if="isLoading" v-for="i in 3" :key="i" type="heading, paragraph, actions"></v-skeleton-loader>

      <template v-else>
        <task-card
          v-if="newTasks.length > 0"
          v-for="task in newTasks"
          :key="`new-task-${task.id}`"
          :task="task"
          :to="`/task/${task.id}`"
        ></task-card>
        <div v-else class="text-overline">Пусто</div>
      </template>
    </v-col>
    <v-col cols="12" md="4">
      <h3>Задачи в работе</h3>

      <v-skeleton-loader v-if="isLoading" type="heading, paragraph, actions"></v-skeleton-loader>

      <template v-else>
        <task-card
          v-if="inProgressTasks.length > 0"
          v-for="task in inProgressTasks"
          :key="`in-progress-task-${task.id}`"
          :task="task"
          :to="`/task/${task.id}`"
        ></task-card>
        <div v-else class="text-overline">Пусто</div>
      </template>
    </v-col>
    <v-col cols="12" md="4">
      <h3>Завершённые задачи</h3>

      <v-skeleton-loader v-if="isLoading" v-for="i in 2" :key="i" type="heading, paragraph, actions"></v-skeleton-loader>

      <template v-else>
        <task-card
          v-if="doneTasks.length > 0"
          v-for="task in doneTasks"
          :key="`done-task-${task.id}`"
          :task="task"
          :to="`/task/${task.id}`"
        ></task-card>
        <div v-else class="text-overline">Пусто</div>
      </template>
    </v-col>
  </v-row>
</template>
