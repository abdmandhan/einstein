<template>
  <v-container>
    <v-row justify="space-around">
      <v-col v-for="(item, index) in discuss" :key="index" cols="4">
        <v-card width="400">
          <div height="200px">
            <v-card-title>
              <v-avatar size="56">
                <img alt="user" :src="photo(item.user.photo)" />
              </v-avatar>
              <p class="ml-3">
                {{ item.user.name }}

                <br />
                <v-chip color="green" small v-if="item.is_done"> DONE </v-chip>
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
          <v-textarea
            outlined
            name="input-7-4"
            label="Reply"
            v-model="reply[item.id]"
          ></v-textarea>
          <v-btn @click="sendReply(item.id, reply[item.id])">Reply</v-btn>
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
          this.$parent.init();
          console.log("RESULT", result);
        });
    },
    removeReply(id) {
      axios
        .delete(`${this.$baseUrl}/api/discuss/replies/${id}`)
        .then((result) => {
          this.$parent.init();
        })
        .catch((err) => {});
    },
  },
};
</script>
