<template>
  <v-container>
    <v-row justify="space-around">
      <v-col v-for="(item, index) in discuss" :key="index" cols="6">
        <v-card>
          <div height="200px">
            <v-card-title>
              <v-avatar size="56">
                <img alt="user" :src="photo(item.user.photo)" />
              </v-avatar>
              <p class="ml-3">
                {{ item.user.name }}

                <br />
                <v-chip small v-if="item.is_done">
                  <v-icon color="green">mdi-check-bold</v-icon>
                </v-chip>
              </p>
            </v-card-title>
          </div>

          <v-card-text>
            <h3>{{ item.type.name }}</h3>
            <p>
              {{ item.text }}
            </p>
            <div class="font-weight-bold ml-8 mb-2">{{ item.created_at }}</div>

            <v-timeline align-top dense>
              <v-timeline-item
                v-for="message in item.replies"
                :key="message.id"
                color="green"
                small
              >
                <div>
                  <div class="font-weight-normal">
                    <strong>{{ message.user.name }}</strong>
                    <br />
                    {{ message.created_at }}
                    <v-btn
                      icon
                      color="red"
                      v-if="message.user_id == $userId"
                      @click="removeReply(message.id)"
                    >
                      <v-icon>mdi-trash-can</v-icon>
                    </v-btn>
                  </div>
                  <div>{{ message.text }}</div>
                </div>
              </v-timeline-item>
            </v-timeline>
          </v-card-text>

          <v-card-actions>
            <v-container>
              <v-row>
                <v-textarea
                  outlined
                  name="input-7-4"
                  label="Reply"
                  v-model="reply[item.id]"
                ></v-textarea>
              </v-row>
              <v-row justify="space-between">
                <v-btn @click="sendReply(item.id, reply[item.id])">Reply</v-btn>
                <div>
                  <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn
                        v-bind="attrs"
                        v-on="on"
                        icon
                        v-if="!item.is_done"
                        color="green"
                        @click="markAsDone(item.id)"
                      >
                        <v-icon>mdi-check-bold</v-icon>
                      </v-btn>
                    </template>
                    <span>Mark as Done</span>
                  </v-tooltip>

                  <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn
                        v-bind="attrs"
                        v-on="on"
                        icon
                        v-if="!item.is_done"
                        color="red"
                        @click="removeDiscuss(item.id)"
                      >
                        <v-icon>mdi-trash-can</v-icon>
                      </v-btn>
                    </template>
                    <span>Delete this Discuss</span>
                  </v-tooltip>
                </div>
              </v-row>
            </v-container>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  props: {
    discuss: {
      type: Array,
    },
  },
  data() {
    return {
      reply: [],
    };
  },
  methods: {
    photo(name) {
      return `${this.$baseUrl}/${name}`;
    },
    sendReply(id, text) {
      axios
        .post(`${this.$baseUrl}/api/discuss/replies`, {
          id: id,
          text: text,
        })
        .then((result) => {
          this.reply[id] = "";
          this.$emit("refresh");
          console.log("RESULT", result, this.$parent);
        });
    },
    removeReply(id) {
      axios
        .delete(`${this.$baseUrl}/api/discuss/replies/${id}`)
        .then((result) => {
          this.$emit("refresh");
        })
        .catch((err) => {});
    },
    removeDiscuss(id) {
      axios
        .delete(`${this.$baseUrl}/api/discuss/${id}`)
        .then((result) => {
          this.$emit("refresh");
        })
        .catch((err) => {});
    },
    markAsDone(id) {
      axios
        .put(`${this.$baseUrl}/api/discuss/${id}`)
        .then((result) => {
          this.$emit("refresh");
        })
        .catch((err) => {});
    },
  },
};
</script>
