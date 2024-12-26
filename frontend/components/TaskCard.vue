<script setup lang="ts">
import type { Task } from "~/types/tasks";

const { task } = defineProps<{
  task: Task,
}>()

const PREVIEW_DESCRIPTION_MAX_LENGTH = 246

const taskDescriptionPreview = computed(() => {
  return task.description_content.length > PREVIEW_DESCRIPTION_MAX_LENGTH
    ? task.description_content.substring(0, PREVIEW_DESCRIPTION_MAX_LENGTH) + '...'
    : task.description_content
})

defineEmits(['click'])
</script>

<template>
  <v-card class="mt-3" @click="$emit('click', task)">
    <v-card-item>
      <v-card-title>#{{ task.id }} {{ task.title }}</v-card-title>
    </v-card-item>

    <v-card-text><div class="description-content" v-html="taskDescriptionPreview"></div></v-card-text>
  </v-card>
</template>

<style scoped>
.description-content > *:not(:first-child) {
  margin-top: 1em;
}
</style>
