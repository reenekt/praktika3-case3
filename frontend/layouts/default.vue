<script setup lang="ts">
import { ref } from 'vue'
import type { UserData } from '~/types/user'

const drawer = ref(false)

const { isAuthenticated, user, logout } = useSanctumAuth<UserData>()
</script>

<template>
  <v-app>
    <v-layout class="rounded rounded-md">
      <v-app-bar color="blue-darken-2" :elevation="2">
        <template v-slot:prepend>
          <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
        </template>

        <v-app-bar-title #text>
          <nuxt-link to="/" class="text-decoration-none" style="color: inherit;">Менеджер задач</nuxt-link>
        </v-app-bar-title>
      </v-app-bar>

      <v-navigation-drawer v-model="drawer">
        <v-list>
          <v-list-item v-if="!isAuthenticated" tag="NuxtLink" to="/login">Вход</v-list-item>
          <v-list-item v-if="isAuthenticated">{{ user?.data.name }} ({{ user?.data.email }})</v-list-item>
          <v-divider></v-divider>
          <v-list-item v-if="isAuthenticated" tag="NuxtLink" to="/my-tasks">Мои задачи</v-list-item>
          <v-list-item v-if="isAuthenticated && user?.data.is_superuser" tag="NuxtLink" to="/all-tasks">Все задачи</v-list-item>
        </v-list>
        <div class="pa-2">
          <v-btn v-if="isAuthenticated" tag="NuxtLink" to="/new-task" block color="success" prepend-icon="mdi-plus">
            Создать задачу
          </v-btn>
        </div>

        <template v-if="isAuthenticated" v-slot:append>
          <div class="pa-2">
            <v-btn block color="secondary" @click.stop="logout">
              Выйти
            </v-btn>
          </div>
        </template>
      </v-navigation-drawer>

      <v-main class="d-flex justify-center" style="min-height: 300px;">
        <slot />
      </v-main>
    </v-layout>
  </v-app>
</template>
