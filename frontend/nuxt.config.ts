// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2024-11-01',
  devtools: { enabled: true },
  modules: ['vuetify-nuxt-module', 'nuxt-auth-sanctum'],

  vuetify: {
    moduleOptions: {
      /* module specific options */
    },
    vuetifyOptions: {
      /* vuetify options */
      date: {
        locale: {

        },
      }
    }
  },

  // nuxt-auth-sanctum options (also configurable via environment variables)
  sanctum: {
    baseUrl: 'http://localhost:80', // Laravel API
    mode: 'cookie',
    endpoints: {
      login: '/api/login',
      logout: '/api/logout',
    },
  },

  plugins: [
    { src: '~/plugins/vue-quill-plugin.ts', mode: 'client' }, // only on client side
  ],
})
