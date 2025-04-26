import { createApp } from 'vue'

// Import page components
import FeaturedPosts from './components/Home/FeaturedPosts.vue'
import Testimonials from './components/Home/Testimonials.vue'
import TeamMembers from './components/About/TeamMembers.vue'
import NotificationDropdown from './components/Shared/NotificationDropdown.vue'


// Mount if target exists
function mountComponent(selector, component) {
    const el = document.querySelector(selector)
    if (el) {
        createApp(component).mount(el)
    }
}

//Shared components
mountComponent('#notifications', NotificationDropdown)

// Home page
mountComponent('#featured-posts', FeaturedPosts)
mountComponent('#testimonials', Testimonials)

// About page (if any)
mountComponent('#team-members', TeamMembers)
