<template>
  <v-dialog v-model="value" persistent width="400">
    <v-card>
      <v-card-title class="text-subtitle-2"> {{ title }} </v-card-title>
      <v-card-text>{{ text }}</v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn @click="cancelAction" color="blue darken-1 text-white">
          Cancel
        </v-btn>
        <v-btn @click="confirmAction" color="blue darken-4 text-white">
          {{ textConfirm }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import emitter from "tiny-emitter/instance";

export default {
  data: () => ({
    title: '',
    text: '',
    textConfirm: 'Confirm',
    value: false,
    callback: () => {}
  }),

  created() {
    emitter.on("show-confirm", (callback, title, textConfirm, text) => {
      this.value = true;
      this.callback = callback;
      this.title = title;
      this.textConfirm = textConfirm;
      this.text = text;
    });
  },

  methods: {
    cancelAction() {
      this.value = false;
    },

    async confirmAction() {
      await this.callback();
      this.value = false;
    },
  },
};
</script>
