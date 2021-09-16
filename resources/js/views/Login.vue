<template>
  <v-app>
    <main>
      <v-container fluid fill-height class="loginOverlay mt-10">
        <v-layout flex align-center justify-center>
          <v-flex xs12 sm4 elevation-6>
            <v-toolbar class="pt-5 blue darken-4">
              <v-toolbar-title class="white--text mb-6"
                ><h4>Logon</h4></v-toolbar-title
              >
            </v-toolbar>

            <v-card>
              <v-card-text class="pt-4">
                <div>
                  <v-form v-model="valid" ref="form">
                    <v-text-field
                      v-model="logon.email"
                      :rules="emailRules"
                      label="E-mail"
                      required
                    ></v-text-field>

                    <v-text-field
                      v-model="logon.password"
                      :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                      :rules="[rules.required]"
                      :type="show1 ? 'text' : 'password'"
                      name="input-10-1"
                      label="Password"
                      @click:append="show1 = !show1"
                    ></v-text-field>

                    <v-layout
                      v-if="error"
                      justify-center
                      class="text-center red--text"
                    >
                      {{ error }}
                    </v-layout>

                    <v-layout justify-space-between>
                      <v-btn
                        @click="submit"
                        :class="{
                          'blue darken-4 white--text': valid,
                          disabled: !valid,
                        }"
                        >Login</v-btn
                      >
                    </v-layout>
                  </v-form>
                </div>
              </v-card-text>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </main>
  </v-app>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  computed: {
    ...mapGetters(["user"]),
  },
  data: () => ({
    valid: false,
    show1: false,
    error: false,
    logon: {
      email: "",
      password: "",
    },
    passwordRules: [(v) => !!v || "Password is required"],
    rules: {
      required: (value) => !!value || "Required.",
      emailMatch: () => `The email and password you entered don't match`,
    },
    emailRules: [
      (v) => !!v || "E-mail is required",
      (v) =>
        /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
        "E-mail must be valid",
    ],
  }),

  methods: {
    ...mapActions(["login"]),

    async submit() {
      if (this.$refs.form.validate()) {
        const response = await this.login(this.logon);

        if (response) {
          return this.$router.push("/app");
        } else {
          this.error = "Usuário e/ou Senha inválido(s).";
        }
      }
    },
  },
};
</script>
