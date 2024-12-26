import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

export type VueQuillEditor = typeof QuillEditor

export default defineNuxtPlugin((nuxtApp) => {
  nuxtApp.vueApp.component('vue-quill-editor', QuillEditor)
})
