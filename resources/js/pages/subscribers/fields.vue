<template>
  <card :title="subscriber.name">
    <div class="row">
      <div class="col-md-3">
        <div class="mb-2">
          <strong>Fields</strong>
        </div>
        <draggable
          class="fields"
          :list="fields"
          :group="{ name: 'fields', pull: 'clone', put: false }"
          :clone="cloneField"
        >
          <div
            v-for="field in fields"
            :key="field.uuid"
            class="p-2 mb-1 draggable fields__field"
          >
            {{ field.title }}
          </div>
        </draggable>
      </div>
      <div class="col-md-6">
        <draggable
          class="dropzone fields p-2"
          :list="subscriber.fields"
          group="fields"
          @change="handleDrop"
        >
          <div v-if="subscriber.fields && subscriber.fields.length > 0">
            <div
              v-for="field in subscriber.fields"
              :key="field.uuid"
              class="p-2 my-1 fields__field"
            >
              {{ field.title }}
            </div>
          </div>
          <div
            v-if="subscriber.fields.length <= 0"
            class="text-center p-4"
          >
            Drop Fields Here
          </div>
        </draggable>
      </div>
    </div>
  </card>
</template>

<script>
import axios from 'axios'
import draggable from 'vuedraggable'

export default {
  name: 'SubscriberField',
  components: {
    draggable
  },

  data: () => ({
    fields: [],
    subscriber: [],
    loading: false
  }),

  created () {
    this.fetchFields()
    this.fetchSubscriber()
  },

  methods: {
    async fetchFields () {
      try {
        this.loading = true
        const { data: fields } = await axios.get('/api/fields', {
          params: { raw: true }
        })
        this.fields = fields.data
      } catch (error) {
        log.error(error)
        this.$message.error('Oh snap! Failed to process request')
      } finally {
        this.loading = false
      }
    },

    async fetchSubscriber () {
      try {
        this.loading = true
        const { data: subscriber } = await axios.get(
          `/api/subscriber/${this.$route.params.id}`
        )

        this.subscriber = subscriber.data
      } catch (error) {
        log.error(error)
        this.$message.error('Oh snap! Failed to process request')
      } finally {
        this.loading = false
      }
    },

    cloneField (item) {
      log.info({ item })
      return item
    },

    async handleDrop (evt) {
      try {
        const { data } = await axios.post('/api/subscriber/fields/store', {
          subscriber: this.subscriber.id,
          field: evt.added.element.id
        })
        this.$message({
          message: 'Field successfully added',
          type: 'success'
        })
        this.fetchSubscriber()
      } catch (error) {
        log.error(error)
        this.$message.error('Oh snap! Failed to process request')
      }
    }
  }
}
</script>

<style lang="scss" scoped>
  .dropzone {
    border-radius: 2px;
    border: 1px solid #f2f6fc;
  }

  .fields {
    min-height: 60px;
    &__field {
      border-radius: 2px;
      background-color: #f4f4f5;
      cursor: -webkit-grab;
      cursor: grab;
    }
  }
</style>
