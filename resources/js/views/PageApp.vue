<template>
  <v-app id="inspire">
    <!-- Navitator user -->
    <v-navigation-drawer v-model="drawer" app>
      <!-- List menu user -->
      <v-sheet color="grey lighten-4" class="pa-4" style="margin-bottom: -15px">
        <v-list>
          <v-list-item>
            <v-list-item-avatar color="grey darken-1">
              <v-icon lg dark> mdi-account-circle </v-icon>
            </v-list-item-avatar>
          </v-list-item>

          <v-list-item link>
            <v-list-item-content>
              <v-list-item-title class="text-h6">
                {{ getUser.name }}
              </v-list-item-title>
              <v-list-item-subtitle>{{ getUser.email }}</v-list-item-subtitle>
            </v-list-item-content>

            <v-list-item-action>
              <v-menu bottom left>
                <template v-slot:activator="{ on, attrs }">
                  <v-btn icon v-bind="attrs" v-on="on">
                    <v-icon>mdi-menu-down</v-icon>
                  </v-btn>
                </template>

                <v-list>
                  <v-list-item @click="onLogout">
                    <v-list-item-title> Logout </v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>
            </v-list-item-action>
          </v-list-item>
        </v-list>
      </v-sheet>
      <v-divider></v-divider>

      <v-card>
        <v-card class="mx-auto" max-width="400">
          <v-list-item two-line>
            <v-list-item-content>
              <v-list-item-title class="text-h5">
                {{ weather.results.city }}
              </v-list-item-title>
              <v-list-item-subtitle
                >{{ weather.results.date }} {{ weather.results.time }}</v-list-item-subtitle
              >
            </v-list-item-content>
          </v-list-item>

          <v-card-text>
            <v-row align="center">
              <v-col class="text-h2" cols="6"> {{ weather.results.temp }}&deg;C </v-col>
              <v-col cols="6">
                <v-img
                  src="https://cdn.vuetifyjs.com/images/cards/sun.png"
                  alt="Sunny image"
                  width="92"
                ></v-img>
              </v-col>
            </v-row>
          </v-card-text>

          <v-list-item>
            <v-list-item-icon>
              <v-icon>mdi-send</v-icon>
            </v-list-item-icon>
            <v-list-item-subtitle>{{ weather.results.wind_speedy }}</v-list-item-subtitle>
          </v-list-item>
        </v-card>
      </v-card>
    </v-navigation-drawer>

    <!-- Main area -->
    <v-main>
      <v-container class="py-8 px-6" fluid>
        <v-row>
          <v-col cols="12">
            <v-card>
              <v-data-table
                :headers="headers"
                :items="books"
                class="elevation-1"
              >
                <template v-slot:top>
                  <v-toolbar flat>
                    <v-toolbar-title>List Books</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>

                    <!-- Dialog Edit and Add -->
                    <v-dialog v-model="dialog" max-width="500px">
                      <template v-slot:activator="{ on, attrs }">
                        <v-btn
                          color="primary"
                          rounded
                          dark
                          class="mb-2"
                          v-bind="attrs"
                          v-on="on"
                        >
                          Add
                        </v-btn>
                      </template>

                      <v-form v-model="valid" ref="form">
                        <v-card>
                          <v-card-title>
                            <span class="text-h5">{{ formTitle }}</span>
                          </v-card-title>

                          <v-card-text>
                            <v-container>
                              <v-row>
                                <v-col cols="12" sm="6" md="12">
                                  <v-text-field
                                    v-model="editedItem.title"
                                    :rules="rules"
                                    label="Title"
                                    required
                                  ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="12">
                                  <v-text-field
                                    v-model="editedItem.description"
                                    :rules="rules"
                                    label="Description"
                                    required
                                  ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="12">
                                  <v-text-field
                                    v-model="editedItem.author"
                                    :rules="rules"
                                    label="Author"
                                    required
                                  ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="12">
                                  <v-text-field
                                    v-model="editedItem.number_page"
                                    :rules="rules"
                                    label="Number of page"
                                    required
                                  ></v-text-field>
                                </v-col>
                              </v-row>
                            </v-container>
                          </v-card-text>

                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                              color="blue darken-1 text-white"
                              @click="close"
                            >
                              Cancel
                            </v-btn>
                            <v-btn
                              color="blue darken-4 text-white"
                              @click="save"
                            >
                              Save
                            </v-btn>
                          </v-card-actions>
                        </v-card>
                      </v-form>
                    </v-dialog>
                  </v-toolbar>
                </template>
                <template v-slot:item.actions="{ item }">
                  <v-icon small class="mr-2" @click="editItem(item)">
                    mdi-pencil
                  </v-icon>
                  <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
                </template>
              </v-data-table>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import { mapGetters, mapMutations, mapActions } from "vuex";
import emitter from "tiny-emitter/instance";

export default {
  data: () => ({
    drawer: null,
    search: "",
    dialog: false,
    dialogDelete: false,
    valid: false,
    rules: [(v) => !!v || "Is required"],
    headers: [
      {
        text: "Title",
        align: "start",
        filterable: false,
        value: "title",
      },
      { text: "Description", value: "description" },
      { text: "Author", value: "author" },
      { text: "Number of page", value: "number_page" },
      { text: "Created", value: "created_at" },
      { text: "Actions", value: "actions", sortable: false },
    ],
    desserts: [],
    editedIndex: -1,
    editedItem: {
      id: "",
      title: "",
      description: "",
      author: "",
      number_page: 0,
      created_at: "",
    },
    defaultItem: {
      id: "",
      title: "",
      description: "",
      author: "",
      number_page: 0,
      created_at: "",
    },

    labels: ['SU', 'MO', 'TU', 'WED', 'TH', 'FR', 'SA'],
        time: 0,
        forecast: [
          { day: 'Tuesday', icon: 'mdi-white-balance-sunny', temp: '24\xB0/12\xB0' },
          { day: 'Wednesday', icon: 'mdi-white-balance-sunny', temp: '22\xB0/14\xB0' },
          { day: 'Thursday', icon: 'mdi-cloud', temp: '25\xB0/15\xB0' },
        ],
  }),

  computed: {
    ...mapGetters(["user", "books", "weather"]),

    getUser() {
      if (!this.user) {
        return this.me();
      }

      return this.user;
    },

    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },

  created() {
    this.fetch();
    this.fetchWeather();
  },

  methods: {
    ...mapActions([
      "me",
      "fetch",
      "create",
      "delete",
      "fetchWeather",
      "logout",
    ]),

    editItem(item) {
      this.editedIndex = this.desserts.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.desserts.indexOf(item);
      this.editedItem = Object.assign({}, item);
      //   this.dialogDelete = true;

      emitter.emit(
        "show-confirm",
        this.deleteItemConfirm,
        "Are you sure you want to delete this item?",
        "Confirm"
      );
    },

    async deleteItemConfirm() {
      const deleted = await this.delete(this.editedItem);

      emitter.emit("show-snack", "Item deleted in sucess.");

      return deleted;
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    async actionConfirm() {
      const confirm = await this.create(this.editedItem);

      emitter.emit("show-snack", "Item updated in sucess.");

      this.close();

      return confirm;
    },

    save() {
      if (!this.$refs.form.validate()) {
        return false;
      }

      emitter.emit(
        "show-confirm",
        this.actionConfirm,
        "Are you sure you want to save this item?",
        "Confirm"
      );
    },

    onLogout() {
      const response = this.logout();

      if (response) {
        return this.$router.push("/");
      }
    },
  },
};
</script>
