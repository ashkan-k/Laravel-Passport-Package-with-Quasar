<template>
  <h3 v-if="status"> !!Your where logout successfully </h3>
  <h3 v-else> !!There was an error while trying logout </h3>
</template>

<script>
export default {
  name: 'Logout',
  data () {
    return {
      status: false
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

    const app = this

    this.$axios.get(process.env.api + 'api/auth/logout').then(function (response) {
      if (response.data.status === 'OK') {
        /// Clear User Token
        localStorage.removeItem('token')
        app.$axios.defaults.headers.common.Authorization = ''
        /// /////////////////////////////////////////

        app.status = true

        setTimeout(function () {
          window.location.href = '/login'
        }, 1000)
      }
    })
  }
}
</script>
