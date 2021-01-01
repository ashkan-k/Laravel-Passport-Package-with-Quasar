<template>
  <div class="row">
  <div class="q-pa-lg items-start q-gutter-md col-lg-12">
    <q-card class="my-card" flat bordered>
      <q-img style=" max-height: 500px;"
        :src="GetUserImage()"
      />

      <q-card-section>
        <h1> {{ user_profile.name }} </h1>

        <h3> {{ user_profile.email }} </h3>
      </q-card-section>

    </q-card>
  </div>
  </div>
</template>

<script>
export default {
  name: 'Profile',
  data () {
    return {
      user_profile: {
        name: null,
        email: null,
        password: null,
        img: null
      }
    }
  },

  methods: {
    SetUserData (data) {
      this.user_profile.name = data.name
      this.user_profile.email = data.email
      this.user_profile.password = data.password
      this.user_profile.img = data.img
    },

    GetUserData () {
      const app = this

      this.$axios.get(process.env.api + 'api/auth/user').then(function (response) {
        app.SetUserData(response.data)
      })
    },

    GetUserImage () {
      return process.env.api + this.user_profile.img
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

    this.GetUserData()
  }
}
</script>

<style scoped>

</style>
