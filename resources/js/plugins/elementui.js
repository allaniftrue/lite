import Vue from 'vue'
import { Table, TableColumn, Button, Notification, Pagination, Popconfirm } from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css';

[
  Table,
  TableColumn,
  Button,
  Pagination,
  Popconfirm
].forEach(Component => {
  Vue.component(Component.name, Component)
})

Vue.prototype.$notify = Notification
