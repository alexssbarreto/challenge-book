<template>
  <v-snackbar v-model="value" :multi-line="true" bottom left>
    {{ text }}

    <template #action="{ attrs }">
      <v-icon v-bind="attrs" @click="value = false">mdi-close</v-icon>
    </template>
  </v-snackbar>
</template>

<script>
import emitter from "tiny-emitter/instance";

export default {
  data: () => ({
    value: false,
    text: "",
  }),

  created() {
    emitter.on("show-snack", (text) => {
      this.value = true;
      this.text = text;
    });
  },
};
</script>
