<template>
  <q-layout view="hHh lpR fFf" class="bg-grey-1">
    <q-header elevated class="bg-white text-grey-8 q-py-xs" height-hint="58">
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          @click="leftDrawerOpen = !leftDrawerOpen"
          aria-label="Menu"
          icon="menu"
        />

        <q-btn flat no-caps no-wrap class="q-ml-xs" v-if="$q.screen.gt.xs">
          <q-icon :name="fabYoutube" color="red" size="28px" />
          <q-toolbar-title shrink class="text-weight-bold">
            YouTube
          </q-toolbar-title>
        </q-btn>

        <q-space />

        <div class="YL__toolbar-input-container row no-wrap">
          <q-input dense outlined square v-model="search" placeholder="Search" class="bg-white col" />
          <q-btn class="YL__toolbar-input-btn" color="grey-3" text-color="grey-8" icon="search" unelevated />
        </div>

        <q-space />

        <div class="q-gutter-sm row items-center no-wrap">
          <q-btn round dense flat color="grey-8" icon="video_call" v-if="$q.screen.gt.sm">
            <q-tooltip>Create a video or post</q-tooltip>
          </q-btn>
          <q-btn round dense flat color="grey-8" icon="apps" v-if="$q.screen.gt.sm">
            <q-tooltip>Apps</q-tooltip>
          </q-btn>
          <q-btn round dense flat color="grey-8" icon="message" v-if="$q.screen.gt.sm">
            <q-tooltip>Messages</q-tooltip>
          </q-btn>
          <q-btn round dense flat color="grey-8" icon="notifications">
            <q-badge color="red" text-color="white" floating>
              2
            </q-badge>
            <q-tooltip>Notifications</q-tooltip>
          </q-btn>
          <q-btn round flat>
            <q-avatar size="26px">
              <img src="https://cdn.quasar.dev/img/boy-avatar.png">
            </q-avatar>
            <q-tooltip>Account</q-tooltip>
          </q-btn>
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
      content-class="bg-grey-2"
      :width="240"
    >
      <q-scroll-area class="fit">
        <q-list padding>
          <q-item v-for="link in links1" :key="link.text" v-ripple clickable>
            <q-item-section avatar>
              <q-icon color="grey" :name="link.icon" />
            </q-item-section>
            <q-item-section>
              <router-link to="/"><q-item-label>{{ link.text }}</q-item-label></router-link>
            </q-item-section>
          </q-item>

          <q-separator class="q-mt-md q-mb-lg" />

          <q-item v-for="link in links4" :key="link.text" v-ripple clickable>
            <q-item-section avatar>
              <q-icon color="grey" :name="link.icon" />
            </q-item-section>
            <q-item-section>
              <router-link to="/profile"> <q-item-label>{{ link.text }}</q-item-label> </router-link>
            </q-item-section>
          </q-item>

          <q-separator class="q-my-md" />

          <q-item v-for="link in links7" :key="link.text" v-ripple clickable>
            <q-item-section avatar>
              <q-icon color="grey" :name="link.icon" />
            </q-item-section>
            <q-item-section>
              <router-link to="/refresh_token"> <q-item-label>{{ link.text }}</q-item-label> </router-link>
            </q-item-section>
          </q-item>

          <q-separator class="q-mt-md q-mb-lg" />

          <q-item v-for="link in links3" :key="link.text" v-ripple clickable>
            <q-item-section avatar>
              <q-icon color="grey" :name="link.icon" />
            </q-item-section>
            <q-item-section>
              <router-link to="/all"> <q-item-label>{{ link.text }}</q-item-label> </router-link>
            </q-item-section>
          </q-item>

          <q-separator class="q-mt-md q-mb-xs" />

          <q-item v-for="link in links2" :key="link.text" v-ripple clickable>
            <q-item-section avatar>
              <q-icon color="grey" :name="link.icon" />
            </q-item-section>
            <q-item-section>
              <router-link to="/register"> <q-item-label>{{ link.text }}</q-item-label> </router-link>
            </q-item-section>
          </q-item>

          <q-separator class="q-my-md" />

         <div  v-if="!Show_Login_Logout_Button()">
           <q-item v-for="link in links5" :key="link.text" v-ripple clickable>
             <q-item-section avatar>
               <q-icon color="grey" :name="link.icon" />
             </q-item-section>
             <q-item-section>
               <router-link to="/login"> <q-item-label>{{ link.text }}</q-item-label> </router-link>
             </q-item-section>
           </q-item>

           <q-separator class="q-mt-md q-mb-lg" />

         </div>

        <div v-else>
          <q-item v-for="link in links6" :key="link.text" v-ripple clickable>
            <q-item-section avatar>
              <q-icon color="grey" :name="link.icon" />
            </q-item-section>
            <q-item-section>
              <router-link to="/logout"> <q-item-label>{{ link.text }}</q-item-label> </router-link>
            </q-item-section>
          </q-item>

          <q-separator class="q-mt-md q-mb-lg" />
        </div>

          <div class="q-px-md text-grey-9">
            <div class="row items-center q-gutter-x-sm q-gutter-y-xs">
              <a
                v-for="button in buttons1"
                :key="button.text"
                class="YL__drawer-footer-link"
                href="javascript:void(0)"
              >
                {{ button.text }}
              </a>
            </div>
          </div>
          <div class="q-py-md q-px-md text-grey-9">
            <div class="row items-center q-gutter-x-sm q-gutter-y-xs">
              <a
                v-for="button in buttons2"
                :key="button.text"
                class="YL__drawer-footer-link"
                href="javascript:void(0)"
              >
                {{ button.text }}
              </a>
            </div>
          </div>
        </q-list>
      </q-scroll-area>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import { fabYoutube } from '@quasar/extras/fontawesome-v5'
export default {
  name: 'MyLayout',
  data () {
    return {
      leftDrawerOpen: false,
      search: '',
      links1: [
        { icon: 'home', text: 'Home' }
      ],
      links2: [
        { icon: 'folder', text: 'Create New User' }
      ],
      links3: [
        { icon: 'settings', text: 'Users List' }

      ],
      links4: [
        { icon: fabYoutube, text: 'Profile' }
      ],
      links5: [
        { icon: fabYoutube, text: 'Login' }
      ],

      links6: [
        { icon: fabYoutube, text: 'Logout' }
      ],

      links7: [
        { icon: fabYoutube, text: 'Refresh_Token' }
      ],

      buttons1: [
        { text: 'About' },
        { text: 'Press' },
        { text: 'Copyright' },
        { text: 'Contact us' },
        { text: 'Creators' },
        { text: 'Advertise' },
        { text: 'Developers' }
      ],
      buttons2: [
        { text: 'Terms' },
        { text: 'Privacy' },
        { text: 'Policy & Safety' },
        { text: 'Test new features' }
      ]
    }
  },

  methods: {
    Show_Login_Logout_Button () {
      return !!localStorage.token
    }
  },

  created () {
    this.fabYoutube = fabYoutube
  }
}
</script>

<style lang="sass">
  .YL
    &__toolbar-input-container
      min-width: 100px
      width: 55%
    &__toolbar-input-btn
      border-radius: 0
      border-style: solid
      border-width: 1px 1px 1px 0
      border-color: rgba(0,0,0,.24)
      max-width: 60px
      width: 100%
    &__drawer-footer-link
      color: inherit
      text-decoration: none
      font-weight: 500
      font-size: .75rem
      &:hover
        color: #000
</style>
