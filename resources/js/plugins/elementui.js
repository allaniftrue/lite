import Vue from 'vue'
import {
  Table,
  TableColumn,
  Button,
  Message,
  Pagination,
  Popconfirm,
  Dialog,
  Tag,
  Form,
  FormItem,
  Loading,
  Input,
  Select,
  Option
} from 'element-ui';

[
  Table,
  TableColumn,
  Button,
  Pagination,
  Popconfirm,
  Dialog,
  Tag,
  Form,
  FormItem,
  Input,
  Select,
  Option
].forEach(Component => {
  Vue.component(Component.name, Component)
})

Vue.use(Loading.directive)
Vue.prototype.$message = Message
