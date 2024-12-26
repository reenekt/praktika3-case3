<script setup lang="ts">
import type {UserData} from '~/types/user'

definePageMeta({
  middleware: ['sanctum:auth'],
});

const user = useSanctumUser<UserData>()
</script>

<template>
  <v-container>
    <v-row justify="center">
      <v-col md="6">
        <h1>Добро пожаловать, {{ user?.data.name }}</h1>
        <v-divider class="my-6"/>
        <v-btn color="primary" tag="NuxtLink" to="/my-tasks">Перейти к моим задачам</v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>
