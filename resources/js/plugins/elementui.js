import Vue from 'vue';
import {
  Table,
  TableColumn,
  Button,
  Notification,
  Pagination,
  Popconfirm,
  Icon,
  Tag
} from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

[Table, TableColumn, Button, Pagination, Popconfirm, Icon, Tag].forEach(
  Component => {
    Vue.component(Component.name, Component)
  }
)

Vue.prototype.$notify = Notification
