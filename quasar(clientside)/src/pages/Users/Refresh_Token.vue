<template>
      <div style="margin-right: 150px">
          <h3> Refresh Your Login Token </h3>
        <q-form
          @submit="OnSubmit"
          class="q-gutter-md"
        >
          <hr>
          <h5> !If You choose this option your token will be expire after 5 days </h5>
          <q-toggle v-model="remember_me" />

          <hr>

          <div>
            <q-btn label="Refresh Token" type="submit" color="primary"/>
          </div>
        </q-form>

        <h4 :style="message === '!! There was an error while refreshing token' ? 'color:red' : 'color:green'" v-if="message"> {{ message }}  </h4>

      </div>
</template>

<script>
export default {
  name: 'Refresh_Token',

  methods: {
    OnSubmit () {
      if (this.remember_me) {
        this.remember_me = 1
      } else {
        this.remember_me = 0
      }

      var formData = new FormData()
      formData.append('remember_me', this.remember_me)

      const app = this

      this.$axios.post(process.env.api + 'api/auth/refresh_token', formData,
        {
          headers: {
            'Content-Type': 'application / json',
            'X-Requested-With': 'XMLHttpRequest'
          }
        }).then(function (response) {
        // Save Token in axios headers

        /// Clear User Token
        localStorage.removeItem('token')
        app.$axios.defaults.headers.common.Authorization = ''
        /// /////////////////////////////////////////

        localStorage.token = response.data.access_token
        app.$axios.defaults.headers.common.Authorization = 'Bearer' + ' ' + response.data.access_token

        app.$axios.defaults.headers.common.Authorization = localStorage.token
        /// /////////////////////////////////////
        console.log('Your New Token : ', localStorage.token)

        app.$axios.get(process.env.api + 'api/auth/check_login',
          {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }).then(function (response) {
          app.message = '.Your Token Refreshed Successfully'
        })
      }).catch(function (error) {
        console.log(error.message)
        app.message = '!! There was an error while refreshing token'
      })
    }
  },

  data () {
    return {
      remember_me: false,
      message: null
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
  }

}
</script>
