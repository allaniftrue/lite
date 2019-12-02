<template>
  <el-dialog
    :title="`Subscriber: ${subscriber.name}`"
    :visible="visible"
    :before-close="handleClose"
    v-loading.fullscreen.lock="loading"
    fullscreen
  >
    <div class="row">
      <div class="col-md-3">
        <h5>Available Fields</h5>
        <draggable
          class="fields"
          :list="fields"
          :group="{ name: 'fields', pull: 'clone', put: false }"
          :clone="cloneField"
        >
          <div
            v-for="field in fields"
            :key="field.uuid"
            class="p-2 mb-1 fields__field"
          >
            {{ field.title }}
          </div>
        </draggable>
      </div>
      <div class="col-md-9">
        <h5>Subscriber Fields</h5>
        <draggable
          class="dropzone"
          :list="subscriberFields"
          group="fields"
          @change="handleDrop"
        >
          <div
            class="p-2"
            v-for="subscriberField in subscriberFields"
            :key="subscriberField.uuid"
          >
            {{ subscriberField.title }}
          </div>
        </draggable>
      </div>
    </div>

    <span slot="footer" class="dialog-footer">
      <el-button @click="handleClose">Cancel</el-button>
    </span>
  </el-dialog>
</template>

<script>
import axios from "axios";
import draggable from "vuedraggable";

export default {
  name: "SubscriberForm",
  components: {
    draggable
  },
  props: {
    visible: {
      type: Boolean,
      required: true,
      default: false
    },
    subscriber: {
      type: Object,
      required: true,
      default: () => ({})
    },
    propFields: {
      type: Array,
      required: false,
      default: () => []
    }
  },

  data: () => ({
    fields: [],
    subscriberFields: [],
    loading: false
  }),

  created() {
    if (this.propFields.length <= 0) {
      this.fetchFields();
    } else {
      this.fields = this.propFields;
    }

    this.subscriberFields = this.subscriber.fields.map(field => field);
  },

  methods: {
    handleClose() {
      this.$emit("close");
    },

    async fetchFields() {
      try {
        this.loading = true;
        const { data: fields } = await axios.get("/api/fields", {
          params: { raw: true }
        });
        this.fields = fields.data;
      } catch (error) {
        log.error(error);
        this.$message.error("Oh snap! Failed to process request");
      } finally {
        this.loading = false;
      }
    },

    async fetchSubscriber() {
      try {
        this.loading = true;
        const { data: subscriber } = await axios.get(
          `api/subscriber/${this.subscriber.id}`
        );

        this.subscriberFields = subscriber.data.fields;
        log.info({ subscriberFields: this.subscriberFields });
      } catch (error) {
        log.error(error);
        this.$message.error("Oh snap! Failed to process request");
      } finally {
        this.loading = false;
      }
    },

    cloneField(item) {
      log.info({ item });
      return item;
    },

    async handleDrop(evt) {
      try {
        const { data } = await axios.post("api/subscriber/fields/store", {
          subscriber: this.subscriber.id,
          field: evt.added.element.id
        });
        this.$message({
          message: "Field successfully added",
          type: "success"
        });
        this.fetchSubscriber();
      } catch (error) {
        log.error(error);
        this.$message.error("Oh snap! Failed to process request");
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.fields {
  min-height: 60vh;
  &__field {
    border-radius: 2px;
    border: 1px solid #e4e7ed;
  }
}

.dropzone {
  min-height: 60px;
  background-color: #fcfcfc;
}
</style>
