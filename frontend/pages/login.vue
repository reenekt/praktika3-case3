<script setup lang="ts">
import { ref } from 'vue'

definePageMeta({
  middleware: ['sanctum:guest'],
});

const email = ref('')
const password = ref('')

const formRules = {
  email: [
    (value: string) => {
      if (!value) {
        return 'Введите значение'
      }

      return true
    }
  ],
  password: [
    (value: string) => {
      if (!value) {
        return 'Введите значение'
      }

      return true
    }
  ],
}

const isAuthFailed = ref(false)

const onFormSubmit = async () => {
  isAuthFailed.value = false
  const { login } = useSanctumAuth()

  const credentials = {
    email: email.value,
    password: password.value,
    remember: true,
  }

  try {
    await login(credentials)
  } catch (e) {
    isAuthFailed.value = true
  }
}
</script>

<template>
  <v-container>
    <v-row justify="center">
      <v-col md="6">
        <v-card >
          <v-card-title class="text-center">Вход</v-card-title>
          <v-card-item>
            <v-form @submit.prevent="onFormSubmit">
              <v-text-field
                v-model="email"
                :rules="formRules.email"
                label="Email"
                class="mb-4"
                :error-messages="isAuthFailed ? ['Некорректные данные, попробуйте снова'] : []"
                @update:model-value="(value) => { isAuthFailed = false }"
              ></v-text-field>

              <v-text-field
                v-model="password"
                :rules="formRules.password"
                label="Password"
                type="password"
                class="mb-4"
              ></v-text-field>

              <v-btn color="primary" class="mt-2" type="submit" block>Войти</v-btn>
            </v-form>
          </v-card-item>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
