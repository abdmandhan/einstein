<template>
  <v-data-table
    :headers="headers"
    :items="items"
    class="elevation-1"
    :loading="loading"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>{{ nameTable }}</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" persistent>
          <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
              New Item
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="6" v-for="(header, i) in headers" :key="i">
                    <component
                      :is="header.component"
                      v-if="header.value != 'actions'"
                      v-model="form.data[header.value]"
                      :label="header.text"
                      v-bind:disabled="header.disabled"
                      :error-messages="errors[header.value]"
                    ></component>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close"> Cancel </v-btn>
              <v-btn color="blue darken-1" text @click="save"> Save </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="headline"
              >Are you sure you want to delete this item?</v-card-title
            >
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete"
                >Cancel</v-btn
              >
              <v-btn color="blue darken-1" text @click="deleteItemConfirm"
                >OK</v-btn
              >
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item, header }">
      <v-icon v-if="!header.href" small class="mr-2" @click="editItem(item)">
        mdi-pencil
      </v-icon>
      <v-btn v-else icon :to="{ name: header.href, params: { id: item.id } }">
        <v-icon small class="mr-2"> mdi-pencil </v-icon>
      </v-btn>
      <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
    </template>
    <template v-slot:no-data>
      <v-btn color="primary" @click="initialize"> Reset </v-btn>
    </template>

    <template v-for="header in headers" v-slot:[header.slot]="{ item }">
      <v-btn icon :href="photo(item.file.name)" v-if="header.type == 'file'">
        <v-icon color="blue">mdi-file</v-icon>
      </v-btn>

      <v-dialog
        v-model="dialogPreview[item.id]"
        v-if="header.type == 'youtube'"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-tooltip bottom>
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                icon
                v-bind="attrs"
                v-on="on"
                @click.stop="$set(dialogPreview, item.id, true)"
              >
                <v-icon color="red">mdi-youtube</v-icon>
              </v-btn>
            </template>
            <span>Open</span>
          </v-tooltip>
        </template>

        <v-card>
          <v-card-title class="headline grey lighten-2"> Youtube </v-card-title>

          <v-card-text class="text-center mt-5">
            <iframe
              width="600"
              height="400"
              :src="item.url_youtube"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen
            ></iframe>
          </v-card-text>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="primary"
              text
              @click.stop="$set(dialogPreview, item.id, false)"
            >
              Close
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </template>
  </v-data-table>
</template>

<script>
export default {
  props: {
    nameTable: {
      default: "",
    },
    dataParent: {
      default: {},
    },
    relationKey: {
      type: String,
    },
    api: {
      type: String,
    },
    apiHeader: {
      headers: {
        Accept: "application/json",
        "Content-Type": "multipart/form-data",
      },
    },
  },
  data: () => ({
    loading: true,
    form: {
      data: {},
    },
    errors: [],
    headers: [],
    dialog: false,
    dialogDelete: false,
    items: [],
    editedIndex: -1,
    dialogPreview: {},
  }),

  computed: {
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
    "form.data.file"(v) {
      console.log("form", v);
    },
  },

  created() {
    this.initialize();
  },

  methods: {
    photo(name) {
      return `${this.$baseUrl}/${name}`;
    },

    initialize() {
      axios.get(`${this.api}/${this.dataParent.id}`).then((response) => {
        this.items = response.data.data.data;
        this.headers = response.data.data.header;
        this.loading = false;

        this.items.forEach((element) => {
          if (element.file) {
            element.file = { name: element.file };
          }
        });
      });
    },

    editItem(item) {
      this.editedIndex = this.items.indexOf(item);
      this.form.data = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.items.indexOf(item);
      this.form.data = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      axios.delete(`${this.api}/${this.form.data.id}`).then((result) => {
        this.initialize();
      });

      this.closeDelete();
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.form.data = {};
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.form.data = {};
        this.editedIndex = -1;
      });
    },

    save() {
      this.errors = [];

      let dataPost = {
        ...this.form.data,
        [this.relationKey]: this.dataParent.id,
      };

      let formData = new FormData();

      for (const key in dataPost) {
        formData.append(key, dataPost[key]);
      }

      axios
        .post(`${this.api}`, formData, this.apiHeader)
        .then((response) => {
          this.initialize();
          this.close();
          console.log("Response", response);
        })
        .catch((error) => {
          this.message = error.response.data.message;
          this.errors = error.response.data.errors;
          console.log("ERROR", error.response, this.message, this.errors);
        });
    },
  },
};
</script>