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
      @submit="LoginUser"
      @reset="ResetForm"
      class="q-gutter-md"
    >
      <q-input
        filled
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
        :rules="[ val => val && val.length > 0 || 'Please type something']"
      />

      <q-toggle v-model="form.remember_me" />

      <div>
        <q-btn label="Login" type="submit" color="primary"/>
        <q-btn label="Reset Form" type="reset" color="primary" flat class="q-ml-sm"/>
      </div>
    </q-form>

  </div>
</template>

<script>
export default {
  name: 'Login',

  data () {
    return {
      alert: false,
      form: {
        email: null,
        password: null,
        remember_me: false
      },
      errors: []
    }
  },

  methods: {
    LoginUser () {
      if (this.form.remember_me) {
        this.form.remember_me = 1
      } else {
        this.form.remember_me = 0
      }

      const formData = new FormData()
      for (var item in this.form) {
        formData.append(item, this.form[item])
      }

      const app = this

      this.$axios.post(process.env.api + 'api/auth/login', formData,
        {
          headers: {
            'Content-Type': 'application / json',
            'X-Requested-With': 'XMLHttpRequest'
          }
        }).then(function (response) {
        if (response.data.errors) {
          app.errors = response.data.errors
          app.alert = true
        } else {
          // Save Token in axios headers
          localStorage.token = response.data.access_token
          app.$axios.defaults.headers.common.Authorization = 'Bearer' + ' ' + response.data.access_token

          app.$axios.defaults.headers.common.Authorization = localStorage.token
          /// /////////////////////////////////////
          console.log('Your Token : ', localStorage.token)

          window.location.href = '/profile'
        }
      })
    },

    ResetForm () {
      this.form.email = this.form.password_confirmation = this.form.password = null
    }
  },

  created () {
    this.$axios.get(process.env.api + 'api/auth/check_login',
      {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }).then(function (response) {
      if (response.data.login_status) {
        window.location.href = '/profile'
      }
    })
  }
}
</script>

<style scoped>

</style>
