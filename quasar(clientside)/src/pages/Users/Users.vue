<template>
  <div class="q-pa-md">
    <q-table
      :data="data"
      :columns="columns"
      row-key="id"
      :rows-per-page-options="[10]"
      binary-state-sort
      flat
      separator="horizontal"
      color="brand"
    >
      <template v-slot:body="props">
        <q-tr :props="props" style="text-align: center">
          <q-td key="id" style="text-align: center">{{ props.row.id }}</q-td>
          <q-td key="name" >{{ props.row.name }}</q-td>
          <q-td key="email">{{ props.row.email }}</q-td>
          <q-td key="created_at">{{ formatCreatedAt(props.row.created_at) }}</q-td>
          <q-td key="img">
            <div class="q-pa-md">
              <q-img
                :src="GetImage(props.row.img)"
                spinner-color="white"
                style="height: 80px; max-width: 100px"
                img-class="my-custom-image"
                class="rounded-borders"
              >
                <div class="absolute-bottom text-subtitle1 text-center">
                  {{ props.row.name }}
                </div>
              </q-img>
            </div>
          </q-td>
          <q-td>
            <q-btn style="margin-left: 10px;" @click="DeleteUser(props.row.id)" color="red">
                Delete
              <q-tooltip>Delete this User</q-tooltip>
            </q-btn>

            <q-btn @click="$router.push('/edit/' + props.row.id)" color="primary">
              Edit
              <q-tooltip>Edit this User</q-tooltip>
            </q-btn>

          </q-td>
  </q-tr>
  </template>
  </q-table>
  </div>
  </template>

<script>

import moment from 'moment'
import Swal from 'sweetalert2'

export default {
  methods: {
    GetUsers () {
      const app = this
      this.$axios.get(process.env.api + 'api/users').then(function (response) {
        app.data = response.data
      })
    },

    formatCreatedAt (date) {
      return moment(date, 'YYYYMMDD').fromNow()
    },
    GetImage (image) {
      return process.env.api + image
    },

    DeleteUser (id) {
      const app = this

      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
      })

      swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: 'Do you want to delete this one',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          // we're done, we reset loading state
          this.$axios.delete(process.env.api + 'api/users/' + id).then(function (response) {
            app.GetUsers()
          }).catch(function (error) {
            console.log(error)
          })

          setTimeout(function () {
            swalWithBootstrapButtons.fire(
              'Deleted!',
              '.This record deleted successfully',
              'success'
            )
          }, 2000)
        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {
          swalWithBootstrapButtons.fire(
            'Cancelled',
            '!You were canceled deleting',
            'error'
          )
        }
      })
    }
  },
  data () {
    return {
      loading1: false,
      columns: [
        { name: 'id', align: 'center', label: 'Id', field: 'id', sortable: true },
        { name: 'name', align: 'center', label: 'Name', field: 'name', sortable: true },
        { name: 'email', align: 'center', label: 'Email', field: 'email', sortable: true },
        { name: 'created_at', align: 'center', label: 'Created At', field: 'created_at', sortable: true },
        { name: 'img', align: 'center', label: 'Image', field: 'img', sortable: true },
        { name: 'actions', align: 'center', label: 'Actions', field: 'actions', sortable: true }
      ],
      data: []
    }
  },
  created () {
    this.$axios.get(process.env.api + 'api/auth/check_login',
      {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }).then(function (response) {
      if (!response.data.login_status) {
        window.location.href = '/login'
      }
    })

    if (localStorage.getItem('message')) {
      Swal.fire(
        'Job Successfully done',
        '!Your User ' + localStorage.getItem('message') + ' Successfully',
        'success'
      )
      localStorage.removeItem('message')
    }
    this.GetUsers()
  }
}
</script>
