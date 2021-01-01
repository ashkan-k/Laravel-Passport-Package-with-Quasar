<template>
  <div class="q-pa-md" style="max-width: 400px; margin: 0 auto">

    <q-dialog v-model="alert">
      <q-card>
        <q-card-section>
          <div class="text-h6">Validation Error</div>
        </q-card-section>

        <q-card-section class="q-pt-none">
            <p v-for="e in errors" :key="e[0]">
                  {{ e[0] }}
            </p>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn flat label="OK" color="primary" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>

    <q-form
      @submit="onSubmit"
      @reset="onReset"
      class="q-gutter-md"
    >
      <q-input
        filled
        v-model="form.name"
        label="Your name"
        hint="Your Public Name"
        lazy-rules
        :rules="[ val => val && val.length > 0 || 'Please type something']"
      />

      <q-input
        filled
        type="email"
        v-model="form.email"
        label="Your Email"
        hint="Your Public UserName"
        lazy-rules
        :rules="[ val => val && val.length > 0 || 'Please type something']"
      />

      <q-input
        filled
        v-model="form.password"
        type="password"
        label="Your Password"
        hint="Your Public Password"
        lazy-rules
        :rules="type === 'create' ?  [ val => val && val.length > 0 || 'Please type something'] : []"
      />

      <q-input
        filled
        v-model="form.password_confirmation"
        type="password"
        label="Your Password Confirmation"
        hint="Your Public Password Confirmation"
        lazy-rules
        :rules="type === 'create' ? [ val => val && val.length > 0 || 'Please type something'] : []"
      />

      <q-file color="teal" filled v-model="form.img" label="Your Public Image" >
        <template v-slot:prepend>
          <q-icon name="cloud_upload" />
        </template>
      </q-file>

  <div>
    <q-btn label="Save" type="submit" color="primary"/>
        <q-btn label="Reset Form" type="reset" color="primary" flat class="q-ml-sm"/>
      </div>
    </q-form>

  </div>
</template>
<script>
export default {
  data () {
    return {
      type: 'create',
      alert: false,
      form: {
        name: null,
        email: null,
        password: null,
        password_confirmation: null,
        img: null,
        lastImage: null
      },
      errors: []
    }
  },

  methods: {
    onSubmit () {
      const formData = new FormData()
      for (var item in this.form) {
        if (this.form[item] != null) {
          formData.append(item, this.form[item])
        }
      }

      const app = this

      /// //////  Create and Update User
      if (this.type === 'create') {
        this.$axios.post(process.env.api + 'api/users/', formData,
          {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }).then(function (response) {
          if (response.data.errors) {
            app.errors = response.data.errors
            app.alert = true
          } else {
            if (response.data.errors) {
              app.errors = response.data.errors
              app.alert = true
            } else {
              localStorage.setItem('message', 'created')
              window.location.href = '/all'
            }
          }
        })
      } else {
        this.$axios.post(process.env.api + 'api/user/update/' + app.$route.params.id, formData,
          {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }).then(function (response) {
          if (response.data.errors) {
            app.errors = response.data.errors
            app.alert = true
          } else {
            console.log(response.data)
            localStorage.setItem('message', 'updated')
            window.location.href = '/all'
          }
        })
      }
    },

    onReset () {
      this.form.name = this.form.email = this.form.password = this.form.password_confirmation = this.form.img = this.form.lastImage = null
    },

    GetUserForEdit () {
      const app = this

      this.$axios.put(process.env.api + 'api/user/' + app.$route.params.id).then(function (response) {
        app.form.id = response.data.id
        app.form.name = response.data.name
        app.form.email = response.data.email
        app.form.lastImage = response.data.img
      })
    }
  },

  mounted () {
    if (window.location.href.includes('http://localhost:8080/edit/')) {
      this.type = 'edit'
      this.GetUserForEdit()
    } else {
      this.type = 'create'
    }
  }
}
</script>
