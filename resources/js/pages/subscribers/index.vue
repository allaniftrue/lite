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
      >
        <template slot-scope="scope">
          <el-tag
            :type="setTagType(scope.row.status)"
            size="small"
            effect="dark"
            disable-transitions
          >{{scope.row.status}}</el-tag>
        </template>
      </el-table-column>
      <el-table-column label="Operations">
        <template slot-scope="scope">
          <el-button
            type="primary"
            size="mini"
            @click="handleFields(scope.$index, scope.row)"
          >Fields</el-button>
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
        @current-change="fetchSubscribers"
      >
      </el-pagination>
    </div>
  </card>
</template>

<script>
import axios from "axios";

export default {
  metaInfo() {
    return { title: this.$t("Subscribers") };
  },

  data: () => ({
    subscribers: [],
    total: 0,
    mode: null
  }),

  created() {
    this.fetchSubscribers();
  },

  methods: {
    async fetchSubscribers(page) {
      try {
        const payload = {
          page
        };
        const { data } = await axios.get("/api/subscribers", {
          params: payload
        });
        this.subscribers = data.data;
        this.total = data.total;
      } catch (error) {
        log.error({ error });
      }
    },

    async handleDelete(index, row) {
      try {
        const { data } = await axios.delete("/api/subscribers", {
          params: {
            id: row.id
          }
        });
        this.$notify.success({
          title: "Success",
          message: data.data,
          offset: 100
        });
        this.fetchSubscribers();
      } catch (error) {
        log.error({ error });
      }
    },

    isEdit() {
      this.mode = "EDIT";
    },

    setTagType(status) {
      switch (status) {
        case "ACTIVE":
          return "success";
          break;
        case "UNSUBSCRIBED":
          return "danger";
          break;
        case "JUNK":
          return "warning";
          break;
        case "BOUNCED":
          return "info";
          break;
        case "UNCONFIRMED":
          return "";
          break;
        default:
          return "";
          break;
      }
    },

    handleEdit(index, row) {},

    handleFields(index, row) {}
  }
};
</script>
