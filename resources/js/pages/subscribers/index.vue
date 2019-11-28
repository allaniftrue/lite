<template>
  <card :title="$t('Subscribers')">
    <el-table
      :data="subscribers"
      border
      stripe
      style="width: 100%"
    >
      <el-table-column
        prop="name"
        label="Name"
      />
      <el-table-column
        prop="email"
        label="Email"
      />
      <el-table-column
        prop="status"
        label="Status"
      />
      <el-table-column
        label="Operations"
      >
        <template slot-scope="scope">
          <el-button
            size="mini"
            @click="handleEdit(scope.$index, scope.row)"
          >
            Edit
          </el-button>
          <el-popconfirm
            confirm-button-text="OK"
            cancel-button-text="No"
            title="Are you sure to delete this?"
            @onConfirm="handleDelete(scope.$index, scope.row)"
          >
            <el-button
              slot="reference"
              size="mini"
              type="danger"
            >
              Delete
            </el-button>
          </el-popconfirm>
        </template>
      </el-table-column>
    </el-table>
  </card>
</template>

<script>
import axios from 'axios'

export default {
  metaInfo () {
    return { title: this.$t('Subscribers') }
  },

  data: () => ({
    subscribers: []
  }),

  created () {
    this.fetchSubscribers()
  },

  methods: {
    async fetchSubscribers () {
      try {
        const { data } = await axios.get('/api/subscribers')
        this.subscribers = data.data
      } catch (error) {
        log.error({ error })
      }
    },

    async handleDelete (index, row) {
      try {
        const { data } = await axios.delete('/api/subscribers', {
          params: {
            id: row.id
          }
        })
        this.$notify.success({
          title: 'Success',
          message: data.data,
          offset: 100
        })
        this.fetchSubscribers()
      } catch (error) {
        log.error({ error })
      }
    }
  }
}
</script>
