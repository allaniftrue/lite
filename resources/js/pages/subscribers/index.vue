<template>
  <card :title="$t('Subscribers')">
    <el-button
      class="mb-4"
      type="info"
      size="mini"
      @click="addUser"
    >
      ADD SUBSCRIBER
    </el-button>
    <el-table
      v-loading="loading"
      :data="subscribers"
      border
      stripe
      style="width: 100%"
    >
      <el-table-column
        prop="id"
        label="ID"
        width="50"
      />
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
      >
        <template slot-scope="scope">
          <el-tag
            :type="setTagType(scope.row.status)"
            size="small"
            effect="dark"
            disable-transitions
          >
            {{ scope.row.status }}
          </el-tag>
        </template>
      </el-table-column>
      <el-table-column label="Operations">
        <template slot-scope="scope">
          <el-button
            type="primary"
            size="mini"
            @click="handleForms(scope.$index, scope.row)"
          >
            Forms
          </el-button>
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

    <div class="mt-4 mb-4 ml-0">
      <el-pagination
        background
        layout="prev, pager, next"
        :total="total"
        :current-page.sync="currentPage"
        @current-change="fetchSubscribers"
      />
    </div>

    <el-dialog
      title="Subscriber Details"
      :visible.sync="formDialog"
    >
      <el-form
        :model="form"
        label-position="right"
        label-width="80px"
      >
        <el-form-item
          label="Name"
          :rules="[
            { required: true, message: 'Name is required'}
          ]"
          :error="errors.name"
        >
          <el-input
            v-model="form.name"
            autocomplete="off"
          />
        </el-form-item>
        <el-form-item
          label="Email"
          :rules="[
            { required: true, message: 'Email is required'},
            { type: 'email', message: 'Please enter a valid email'}
          ]"
          :error="errors.email"
        >
          <el-input
            v-model="form.email"
            type="email"
            autocomplete="off"
          />
        </el-form-item>
        <el-form-item label="Status">
          <el-select
            v-model="form.status"
            placeholder="Select"
          >
            <el-option
              v-for="status in statuses"
              :key="status.value"
              :label="status.label"
              :value="status.value"
            />
          </el-select>
        </el-form-item>
      </el-form>
      <span
        slot="footer"
        class="dialog-footer"
      >
        <el-button @click="formDialog = false">Cancel</el-button>
        <el-button
          type="primary"
          @click="handleSubmit"
        >Update</el-button>
      </span>
    </el-dialog>
  </card>
</template>

<script>
import axios from 'axios'
import { SUBSCRIBER_STATUSES } from '~/constants'

export default {
  middleware: 'auth',
  metaInfo () {
    return { title: this.$t('Subscribers') }
  },

  data: () => ({
    subscribers: [],
    activeSubscriber: null,
    total: 0,
    page: 1,
    loading: false,
    formDialog: false,
    form: {
      id: null,
      name: null,
      email: null,
      status: 'UNCONFIRMED'
    },
    mode: 'ADD',
    errors: {
      name: null,
      email: null
    }
  }),

  computed: {
    currentPage: {
      get () {
        return parseInt(this.page)
      },
      set (value) {
        this.page = parseInt(value)
      }
    },
    statuses () {
      return SUBSCRIBER_STATUSES.map(status => {
        return {
          value: status,
          label: status.toLowerCase().replace(/^./, status[0].toUpperCase())
        }
      })
    }
  },

  created () {
    this.fetchSubscribers()
  },

  methods: {
    async fetchSubscribers (page) {
      try {
        this.loading = true
        this.page = page || this.$route.query.page

        const payload = {
          page: this.page
        }

        const { data: subscribers } = await axios.get('/api/subscribers', {
          params: payload
        })

        this.subscribers = subscribers.data
        this.total = subscribers.total
        this.$router.push({
          query: {
            page: this.page
          }
        })
      } catch (error) {
        log.error(error)
      } finally {
        this.loading = false
      }
    },

    async handleDelete (index, row) {
      try {
        const { data } = await axios.delete('/api/subscribers', {
          params: {
            id: row.id
          }
        })
        this.$message({
          message: 'Subscriber successfully removed',
          type: 'success'
        })
        this.fetchSubscribers()
      } catch (error) {
        log.error(error)
        this.$message.error('Oh snap! Failed to process request')
      }
    },

    setTagType (status) {
      switch (status) {
        case 'ACTIVE':
          return 'success'
        case 'UNSUBSCRIBED':
          return 'danger'
        case 'JUNK':
          return 'warning'
        case 'BOUNCED':
          return 'info'
        case 'UNCONFIRMED':
          return ''
        default:
          return ''
      }
    },

    handleEdit (index, row) {
      this.mode = 'EDIT'
      this.activeSubscriber = row
      this.formDialog = true

      Object.keys(this.form).forEach(key => {
        this.form[key] = this.activeSubscriber[key]
      })
    },

    handleForms (index, row) {
      this.$router.push({
        name: 'subscriber.fields',
        params: {
          id: row.id
        },
        query: {
          page: this.page
        }
      })
    },

    handleClose () {
      this.activeSubscriber = null
    },

    addUser () {
      this.mode = 'ADD'
      this.formDialog = true
      this.form = {
        id: null,
        name: null,
        email: null,
        status: 'UNCONFIRMED'
      }
    },

    handleSubmit () {
      if (this.mode === 'ADD') {
        this.handleCreate()
      } else {
        this.handleUpdate()
      }
    },

    async handleCreate () {
      try {
        await axios.post('api/subscriber', this.form)
        this.$message({
          message: 'Subscriber successfully added',
          type: 'success'
        })
        this.formDialog = false
        this.fetchSubscribers()
      } catch (error) {
        log.info(error)
        this.$message.error('Oh snap! Failed to process request')
        const { response } = error
        if (response.status === 422) {
          const { key, message } = this.getFirstErrorFromLaravel(response.data.errors)
          console.log({
            key,
            error
          })
          this.errors[key] = message
        }
      }
    },

    async handleUpdate () {
      try {
        await axios.patch('api/subscriber', this.form)
        this.$message({
          message: 'Subscriber successfully updated',
          type: 'success'
        })
        this.formDialog = false
        this.fetchSubscribers()
      } catch (error) {
        log.error(error)
        this.$message.error('Oh snap! Failed to process request')
      }
    },

    getFirstErrorFromLaravel (errors) {
      const key = Object.keys(errors)[0]
      return {
        key,
        message: errors[key][0]
      }
    }
  }
}
</script>
