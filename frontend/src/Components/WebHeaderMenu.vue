<template>
  <nav class="qf-nav" :class="{ 'qf-nav--scrolled': scrolled }">
    <div class="qf-nav__inner">
      <!-- Brand -->
      <router-link to="/" class="qf-brand" aria-label="QUICKFIX home">
        <span class="qf-brand__mark">Q</span>
        <span class="qf-brand__word">QUICKFIX</span>
        <span class="qf-brand__tag">/svc</span>
      </router-link>

      <!-- Desktop nav -->
      <ul class="qf-nav__links">
        <li>
          <router-link to="/" class="qf-link" active-class="qf-link--active" exact-active-class="qf-link--active">
            <i class="bi bi-house-door"></i><span>Home</span>
          </router-link>
        </li>
        <li>
          <router-link to="/fixer" class="qf-link" active-class="qf-link--active">
            <i class="bi bi-wrench-adjustable"></i><span>Fixers</span>
          </router-link>
        </li>
        <li>
          <button class="qf-link qf-link--offer" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <i class="bi bi-tag"></i><span>Offers</span>
          </button>
        </li>
      </ul>

      <!-- Actions -->
      <div class="qf-nav__actions">
        <button
          v-if="isLoggedIn && listBookings"
          type="button"
          class="qf-icon-btn"
          data-bs-toggle="modal"
          data-bs-target=".bd-cart-modal"
          aria-label="Bookings"
        >
          <i class="bi bi-cart"></i>
          <span v-if="listBookings.length" class="qf-badge">{{ listBookings.length }}</span>
        </button>

        <div class="qf-icon-btn qf-icon-btn--rel" @click="toggleNotifications">
          <i class="bi bi-bell"></i>
          <span v-if="isLoggedIn && notifications && notifications.length" class="qf-badge">{{ notifications.length }}</span>
          <div v-if="showNotifications" class="qf-notif">
            <div class="qf-notif__head">Notifications</div>
            <ul>
              <li v-for="(n, i) in notifications" :key="i">{{ n.message }}</li>
              <li v-if="!notifications || !notifications.length" class="qf-notif__empty">No notifications</li>
            </ul>
          </div>
        </div>

        <template v-if="!isLoggedIn">
          <router-link to="/signup" class="qf-btn qf-btn--ghost">Register</router-link>
          <router-link to="/login" class="qf-btn qf-btn--primary">Login</router-link>
        </template>

        <div v-if="isLoggedIn" class="qf-profile dropdown">
          <a
            class="qf-profile__trigger"
            href="#"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          >
            <img
              :src="authStore.user?.profile || 'https://st3.depositphotos.com/1767687/17621/v/450/depositphotos_176214104-stock-illustration-default-avatar-profile-icon.jpg'"
              alt="Profile"
            />
          </a>
          <ul class="dropdown-menu qf-dropdown">
            <li>
              <router-link to="/profile" class="dropdown-item">
                <i class="bi bi-person-circle"></i><span>View profile</span>
              </router-link>
            </li>
            <li>
              <router-link to="#" class="dropdown-item">
                <i class="bi bi-clock-history"></i><span>History</span>
              </router-link>
            </li>
            <li>
              <a href="#" class="dropdown-item" @click.prevent="logout">
                <i class="bi bi-box-arrow-right"></i><span>Logout</span>
              </a>
            </li>
          </ul>
        </div>

        <!-- Mobile toggle -->
        <button
          class="qf-burger"
          :class="{ 'qf-burger--open': drawerOpen }"
          @click="drawerOpen = !drawerOpen"
          aria-label="Menu"
        >
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>

    <!-- Mobile drawer (teleported to body so nav's backdrop-filter doesn't trap it) -->
    <Teleport to="body">
    <div class="qf-drawer" :class="{ 'qf-drawer--open': drawerOpen }" @click.self="drawerOpen = false">
      <div class="qf-drawer__panel">
        <div class="qf-drawer__head">
          <span class="qf-mono">/menu</span>
          <button class="qf-icon-btn" @click="drawerOpen = false" aria-label="Close">
            <i class="bi bi-x-lg"></i>
          </button>
        </div>
        <ul class="qf-drawer__links">
          <li><router-link to="/" @click="drawerOpen = false"><span>01</span>Home</router-link></li>
          <li><router-link to="/fixer" @click="drawerOpen = false"><span>02</span>Fixers</router-link></li>
          <li>
            <button @click="openOffers">
              <span>03</span>Offers
            </button>
          </li>
          <li v-if="isLoggedIn">
            <router-link to="/profile" @click="drawerOpen = false"><span>04</span>Profile</router-link>
          </li>
        </ul>
        <div class="qf-drawer__foot">
          <template v-if="!isLoggedIn">
            <router-link to="/signup" class="qf-btn qf-btn--ghost qf-btn--full" @click="drawerOpen = false">Register</router-link>
            <router-link to="/login" class="qf-btn qf-btn--primary qf-btn--full" @click="drawerOpen = false">Login</router-link>
          </template>
          <button v-else class="qf-btn qf-btn--ghost qf-btn--full" @click="logout">Logout</button>
        </div>
      </div>
    </div>
    </Teleport>

    <!-- Offers modal (unchanged behavior) -->
    <div
      class="modal fade custom-slide-modal"
      id="staticBackdrop"
      tabindex="-1"
      aria-labelledby="staticBackdropLabel"
      aria-hidden="true"
      data-bs-backdrop="false"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content qf-modal">
          <div class="modal-header qf-modal__head">
            <div>
              <div class="qf-mono">/promotions</div>
              <h3>Current Offers</h3>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body qf-modal__body">
            <div v-if="promotions && promotions.length" class="qf-promo-list">
              <div class="qf-promo" v-for="p in promotions" :key="p.id">
                <div class="qf-promo__pct">
                  <span class="qf-promo__num">{{ p.discount }}</span><span class="qf-promo__sym">%</span>
                </div>
                <div class="qf-promo__body">
                  <div class="qf-promo__desc">{{ p.description }}</div>
                  <div class="qf-mono qf-promo__dates">
                    {{ p.start_date }} → {{ p.end_date }}
                  </div>
                </div>
              </div>
            </div>
            <div v-else class="qf-empty">No promotions available.</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Cart modal (unchanged behavior) -->
    <div
      class="modal fade bd-cart-modal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="cartModalLabel"
      aria-hidden="true"
      data-bs-backdrop="false"
    >
      <div class="modal-dialog modal-fullscreen">
        <div class="modal-content qf-modal">
          <div class="modal-header qf-modal__head">
            <div>
              <div class="qf-mono">/cart</div>
              <h3 id="cartModalLabel">Your Bookings</h3>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body qf-modal__body qf-cart">
            <div class="qf-cart__list">
              <table class="qf-table">
                <thead>
                  <tr>
                    <th>Item</th><th>Date</th><th>Fixer</th><th>Status</th><th></th>
                  </tr>
                </thead>
                <tbody v-if="listBookings && listBookings.length">
                  <tr v-for="(booking, i) in listBookings" :key="i">
                    <td>{{ booking[0].booking.service || 'N/A' }}</td>
                    <td class="qf-mono">{{ booking[0].booking.date }}</td>
                    <td>{{ booking[0].fixer ? booking[0].fixer.name : 'N/A' }}</td>
                    <td><span class="qf-chip">{{ booking[0].action }}</span></td>
                    <td>
                      <button class="qf-btn qf-btn--danger qf-btn--sm" @click="cancelBooking(booking[0].id)">Cancel</button>
                    </td>
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr><td colspan="5" class="qf-empty">No bookings found.</td></tr>
                </tbody>
              </table>
            </div>
            <div class="qf-cart__chat">
              <div class="qf-cart__chat-head">Live Chat</div>
              <div class="qf-cart__chat-body">
                <div class="qf-empty qf-mono">/awaiting messages</div>
              </div>
              <div class="qf-cart__chat-foot">
                <input type="text" placeholder="Type your message..." />
                <button class="qf-btn qf-btn--primary qf-btn--sm">Send</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { useAuthStore } from '@/stores/auth-store'
import axios from 'axios'

const promotions = ref(null)
const listBookings = ref(null)
const notifications = ref()
const authStore = useAuthStore()
const showNotifications = ref(false)
const drawerOpen = ref(false)
const scrolled = ref(false)

const isLoggedIn = computed(() => !!authStore.user)

const fetchNotifications = async () => {
  try {
    const stored = localStorage.getItem('user')
    if (!stored) return
    const userId = JSON.parse(stored).id
    const response = await axios.get(`http://127.0.0.1:8000/api/notification/customer/${userId}`)
    notifications.value = response.data.data
  } catch (error) {
    console.error('Error fetching notifications:', error)
  }
}

async function listPromotion() {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/promotion/list')
    promotions.value = response.data
  } catch (error) {
    console.log('error getting promotion')
  }
}

async function listbooking() {
  const stored = localStorage.getItem('user')
  if (!stored) return
  const user = JSON.parse(stored).id
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/booking/show/' + user)
    listBookings.value = response.data.bookings
  } catch (error) {
    console.log('error getting bookings')
  }
}

const cancelBooking = async (bookingId) => {
  const stored = localStorage.getItem('user')
  if (!stored) return
  const user = JSON.parse(stored).id
  try {
    await axios.delete(`http://127.0.0.1:8000/api/customer/cancel/${bookingId}`, { user_id: user })
  } catch (error) {
    console.error('Error cancelling booking:', error)
  }
}

const toggleNotifications = () => {
  showNotifications.value = !showNotifications.value
}

const logout = async () => {
  try {
    authStore.logout()
    location.reload()
  } catch (error) {
    console.error('Error logging out:', error)
  }
}

const openOffers = () => {
  drawerOpen.value = false
  // trigger bootstrap modal
  setTimeout(() => {
    const el = document.getElementById('staticBackdrop')
    if (el && window.bootstrap) {
      const m = window.bootstrap.Modal.getOrCreateInstance(el)
      m.show()
    }
  }, 200)
}

const onScroll = () => {
  scrolled.value = window.scrollY > 12
}

let bookingTimer = null

onMounted(async () => {
  await listPromotion()
  await listbooking()
  await fetchNotifications()
  bookingTimer = setInterval(listbooking, 2000)
  window.addEventListener('scroll', onScroll, { passive: true })
})

onBeforeUnmount(() => {
  if (bookingTimer) clearInterval(bookingTimer)
  window.removeEventListener('scroll', onScroll)
})
</script>

<style scoped>
.qf-nav {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1030;
  background: rgba(242, 239, 230, 0.85);
  backdrop-filter: blur(14px) saturate(140%);
  -webkit-backdrop-filter: blur(14px) saturate(140%);
  border-bottom: 1px solid var(--qf-rule);
  transition: padding 0.3s ease, background 0.3s ease;
}
.qf-nav--scrolled {
  background: rgba(242, 239, 230, 0.96);
  border-bottom-color: rgba(15, 16, 17, 0.16);
}
.qf-nav__inner {
  max-width: 1440px;
  margin: 0 auto;
  padding: 18px 28px;
  display: grid;
  grid-template-columns: auto 1fr auto;
  align-items: center;
  gap: 32px;
  transition: padding 0.3s ease;
}
.qf-nav--scrolled .qf-nav__inner { padding: 12px 28px; }

/* Brand */
.qf-brand {
  display: inline-flex;
  align-items: baseline;
  gap: 6px;
  text-decoration: none;
  color: var(--qf-ink);
  font-family: var(--qf-font-display);
  letter-spacing: -0.02em;
}
.qf-brand__mark {
  display: inline-grid;
  place-items: center;
  width: 36px;
  height: 36px;
  background: var(--qf-orange);
  color: var(--qf-bone);
  font-weight: 800;
  font-size: 22px;
  border-radius: 6px;
  margin-right: 6px;
  transform: rotate(-4deg);
  transition: transform 0.4s cubic-bezier(.2,.9,.3,1.1);
}
.qf-brand:hover .qf-brand__mark { transform: rotate(2deg) scale(1.04); }
.qf-brand__word {
  font-size: 22px;
  font-weight: 800;
  letter-spacing: -0.03em;
}
.qf-brand__tag {
  font-family: var(--qf-font-mono);
  font-size: 11px;
  color: var(--qf-orange);
  margin-left: 2px;
  letter-spacing: 0.04em;
}

/* Links */
.qf-nav__links {
  display: flex;
  gap: 4px;
  list-style: none;
  margin: 0;
  padding: 0;
  justify-content: center;
}
.qf-link {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 16px;
  text-decoration: none;
  background: transparent;
  border: none;
  color: var(--qf-steel);
  font-family: var(--qf-font-body);
  font-weight: 500;
  font-size: 14.5px;
  letter-spacing: -0.005em;
  border-radius: 999px;
  cursor: pointer;
  transition: background 0.2s ease, color 0.2s ease;
}
.qf-link i { font-size: 16px; opacity: 0.75; }
.qf-link:hover { background: rgba(15,16,17,0.06); color: var(--qf-ink); }
.qf-link--active { background: var(--qf-ink); color: var(--qf-bone); }
.qf-link--active i { opacity: 1; }
.qf-link--offer { color: var(--qf-orange); font-weight: 600; }
.qf-link--offer:hover { background: rgba(255, 91, 31, 0.1); color: var(--qf-orange); }

/* Actions */
.qf-nav__actions { display: flex; align-items: center; gap: 10px; }
.qf-icon-btn {
  position: relative;
  display: inline-grid;
  place-items: center;
  width: 40px;
  height: 40px;
  background: transparent;
  border: 1px solid transparent;
  border-radius: 10px;
  color: var(--qf-steel);
  font-size: 18px;
  cursor: pointer;
  transition: background 0.2s ease, border-color 0.2s ease;
}
.qf-icon-btn:hover { background: rgba(15,16,17,0.06); border-color: var(--qf-rule); color: var(--qf-ink); }
.qf-icon-btn--rel { position: relative; }
.qf-badge {
  position: absolute;
  top: 4px;
  right: 4px;
  min-width: 16px;
  height: 16px;
  padding: 0 4px;
  background: var(--qf-orange);
  color: white;
  font-family: var(--qf-font-mono);
  font-size: 10px;
  font-weight: 600;
  border-radius: 8px;
  display: grid;
  place-items: center;
}

/* Buttons */
.qf-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  padding: 9px 18px;
  font-family: var(--qf-font-body);
  font-weight: 600;
  font-size: 13.5px;
  letter-spacing: -0.005em;
  border-radius: 10px;
  border: 1px solid transparent;
  cursor: pointer;
  text-decoration: none;
  transition: transform 0.15s ease, background 0.2s ease, color 0.2s ease;
}
.qf-btn:hover { transform: translateY(-1px); }
.qf-btn:active { transform: translateY(0); }
.qf-btn--primary { background: var(--qf-ink); color: var(--qf-bone); }
.qf-btn--primary:hover { background: var(--qf-orange); }
.qf-btn--ghost { background: transparent; color: var(--qf-ink); border-color: var(--qf-ink); }
.qf-btn--ghost:hover { background: var(--qf-ink); color: var(--qf-bone); }
.qf-btn--danger { background: #d12c2c; color: white; }
.qf-btn--sm { padding: 6px 12px; font-size: 12.5px; }
.qf-btn--full { width: 100%; }

/* Profile */
.qf-profile__trigger {
  display: inline-block;
  width: 40px;
  height: 40px;
  border-radius: 999px;
  overflow: hidden;
  border: 2px solid var(--qf-ink);
  transition: transform 0.2s ease, border-color 0.2s ease;
}
.qf-profile__trigger:hover { transform: rotate(-4deg); border-color: var(--qf-orange); }
.qf-profile__trigger img { width: 100%; height: 100%; object-fit: cover; display: block; }
.qf-dropdown {
  background: var(--qf-bone);
  border: 1px solid var(--qf-rule);
  border-radius: 12px;
  padding: 6px;
  box-shadow: 0 20px 50px -16px rgba(15,16,17,0.18);
  min-width: 200px;
}
.qf-dropdown .dropdown-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 9px 12px;
  border-radius: 8px;
  font-size: 14px;
  color: var(--qf-steel);
}
.qf-dropdown .dropdown-item i { color: var(--qf-orange); font-size: 15px; }
.qf-dropdown .dropdown-item:hover { background: var(--qf-ink); color: var(--qf-bone); }
.qf-dropdown .dropdown-item:hover i { color: var(--qf-orange); }

/* Notifications */
.qf-notif {
  position: absolute;
  top: calc(100% + 8px);
  right: 0;
  width: 320px;
  background: var(--qf-bone);
  border: 1px solid var(--qf-rule);
  border-radius: 12px;
  box-shadow: 0 24px 60px -20px rgba(15,16,17,0.22);
  z-index: 10;
  overflow: hidden;
}
.qf-notif__head {
  padding: 12px 14px;
  font-family: var(--qf-font-mono);
  font-size: 11px;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  border-bottom: 1px solid var(--qf-rule);
  color: var(--qf-steel);
}
.qf-notif ul { list-style: none; margin: 0; padding: 4px; max-height: 340px; overflow-y: auto; }
.qf-notif ul li {
  padding: 10px 12px;
  border-radius: 8px;
  font-size: 14px;
  color: var(--qf-ink);
  line-height: 1.5;
}
.qf-notif ul li:hover { background: rgba(15,16,17,0.06); }
.qf-notif__empty { font-family: var(--qf-font-mono); font-size: 12px; color: var(--qf-fog); }

/* Burger */
.qf-burger {
  display: none;
  position: relative;
  width: 40px;
  height: 40px;
  background: transparent;
  border: 1px solid var(--qf-rule);
  border-radius: 10px;
  cursor: pointer;
}
.qf-burger span {
  position: absolute;
  left: 10px;
  right: 10px;
  height: 2px;
  background: var(--qf-ink);
  border-radius: 2px;
  transition: transform 0.3s ease, opacity 0.2s ease, top 0.3s ease;
}
.qf-burger span:nth-child(1) { top: 14px; }
.qf-burger span:nth-child(2) { top: 19px; }
.qf-burger span:nth-child(3) { top: 24px; }
.qf-burger--open span:nth-child(1) { top: 19px; transform: rotate(45deg); }
.qf-burger--open span:nth-child(2) { opacity: 0; }
.qf-burger--open span:nth-child(3) { top: 19px; transform: rotate(-45deg); }

/* Drawer */
.qf-drawer {
  position: fixed;
  inset: 0;
  background: rgba(15, 16, 17, 0.5);
  backdrop-filter: blur(4px);
  z-index: 1040;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.3s ease;
}
.qf-drawer--open { opacity: 1; pointer-events: auto; }
.qf-drawer__panel {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  width: min(440px, 86vw);
  background: var(--qf-bone);
  border-left: 1px solid var(--qf-rule);
  display: flex;
  flex-direction: column;
  transform: translateX(100%);
  transition: transform 0.4s cubic-bezier(.2,.9,.3,1.05);
}
.qf-drawer--open .qf-drawer__panel { transform: translateX(0); }
.qf-drawer__head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 22px 26px;
  border-bottom: 1px solid var(--qf-rule);
}
.qf-drawer__head .qf-mono {
  font-family: var(--qf-font-mono);
  font-size: 12px;
  letter-spacing: 0.08em;
  color: var(--qf-fog);
}
.qf-drawer__links {
  list-style: none;
  margin: 0;
  padding: 24px 0;
  flex: 1;
}
.qf-drawer__links li a,
.qf-drawer__links li button {
  display: flex;
  align-items: center;
  gap: 18px;
  padding: 18px 30px;
  font-family: var(--qf-font-display);
  font-size: 32px;
  font-weight: 700;
  letter-spacing: -0.025em;
  color: var(--qf-ink);
  background: transparent;
  border: none;
  width: 100%;
  text-decoration: none;
  text-align: left;
  cursor: pointer;
  transition: padding 0.3s ease, background 0.2s ease;
}
.qf-drawer__links li a span,
.qf-drawer__links li button span {
  font-family: var(--qf-font-mono);
  font-size: 12px;
  color: var(--qf-orange);
  font-weight: 500;
  letter-spacing: 0.04em;
}
.qf-drawer__links li a:hover,
.qf-drawer__links li button:hover {
  background: rgba(255, 91, 31, 0.08);
  padding-left: 36px;
}
.qf-drawer__foot {
  padding: 26px;
  border-top: 1px solid var(--qf-rule);
  display: flex;
  flex-direction: column;
  gap: 10px;
}

/* Modal styling */
.qf-modal {
  background: var(--qf-bone);
  border: 1px solid var(--qf-rule);
  border-radius: 16px;
  overflow: hidden;
}
.qf-modal__head {
  padding: 22px 26px;
  border-bottom: 1px solid var(--qf-rule);
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
}
.qf-modal__head .qf-mono {
  font-family: var(--qf-font-mono);
  font-size: 11px;
  letter-spacing: 0.08em;
  color: var(--qf-fog);
  text-transform: uppercase;
}
.qf-modal__head h3 {
  font-family: var(--qf-font-display);
  font-size: 28px;
  font-weight: 700;
  margin: 4px 0 0;
  letter-spacing: -0.02em;
  color: var(--qf-ink);
}
.qf-modal__body { padding: 26px; max-height: 70vh; overflow-y: auto; }

.qf-promo-list { display: flex; flex-direction: column; gap: 14px; }
.qf-promo {
  display: grid;
  grid-template-columns: 110px 1fr;
  gap: 20px;
  padding: 20px;
  background: var(--qf-ink);
  color: var(--qf-bone);
  border-radius: 12px;
  align-items: center;
}
.qf-promo__pct {
  display: flex;
  align-items: baseline;
  color: var(--qf-orange);
  font-family: var(--qf-font-display);
}
.qf-promo__num { font-size: 56px; font-weight: 800; line-height: 1; letter-spacing: -0.04em; }
.qf-promo__sym { font-size: 24px; font-weight: 600; margin-left: 2px; }
.qf-promo__desc { font-size: 15px; line-height: 1.5; margin-bottom: 6px; }
.qf-promo__dates {
  font-family: var(--qf-font-mono);
  font-size: 11px;
  color: var(--qf-fog);
  letter-spacing: 0.04em;
}
.qf-empty {
  padding: 32px;
  text-align: center;
  color: var(--qf-fog);
  font-family: var(--qf-font-mono);
  font-size: 13px;
}

/* Cart */
.qf-cart {
  display: grid;
  grid-template-columns: 1.6fr 1fr;
  gap: 26px;
}
.qf-cart__list { overflow-x: auto; }
.qf-table { width: 100%; border-collapse: collapse; font-family: var(--qf-font-body); font-size: 14px; }
.qf-table th {
  text-align: left;
  padding: 10px 12px;
  font-family: var(--qf-font-mono);
  font-size: 11px;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: var(--qf-fog);
  border-bottom: 1px solid var(--qf-rule);
}
.qf-table td {
  padding: 14px 12px;
  border-bottom: 1px solid var(--qf-rule);
  color: var(--qf-ink);
  vertical-align: middle;
}
.qf-chip {
  display: inline-block;
  padding: 4px 10px;
  background: rgba(255, 91, 31, 0.12);
  color: var(--qf-orange);
  font-family: var(--qf-font-mono);
  font-size: 11px;
  letter-spacing: 0.04em;
  border-radius: 999px;
  text-transform: uppercase;
}
.qf-cart__chat {
  background: var(--qf-ink);
  color: var(--qf-bone);
  border-radius: 12px;
  display: flex;
  flex-direction: column;
  min-height: 360px;
}
.qf-cart__chat-head {
  padding: 16px 20px;
  border-bottom: 1px solid rgba(255,255,255,0.08);
  font-family: var(--qf-font-display);
  font-size: 18px;
  font-weight: 600;
}
.qf-cart__chat-body { flex: 1; padding: 20px; }
.qf-cart__chat-foot {
  padding: 12px;
  border-top: 1px solid rgba(255,255,255,0.08);
  display: flex;
  gap: 8px;
}
.qf-cart__chat-foot input {
  flex: 1;
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.1);
  color: var(--qf-bone);
  border-radius: 8px;
  padding: 8px 12px;
  font-family: var(--qf-font-body);
  font-size: 14px;
  outline: none;
}
.qf-cart__chat-foot input::placeholder { color: rgba(255,255,255,0.4); }

/* Responsive */
@media (max-width: 1100px) {
  .qf-nav__links { display: none; }
  .qf-nav__inner { grid-template-columns: auto 1fr; gap: 16px; padding: 14px 20px; }
}
@media (max-width: 720px) {
  .qf-nav__actions .qf-btn,
  .qf-nav__actions .qf-profile,
  .qf-nav__actions .qf-icon-btn:not(.qf-burger) { display: none; }
  .qf-burger { display: block; }
  .qf-brand__tag { display: none; }
  .qf-brand__word { font-size: 19px; }
  .qf-brand__mark { width: 32px; height: 32px; font-size: 19px; }
  .qf-cart { grid-template-columns: 1fr; }
  .qf-modal__head h3 { font-size: 22px; }
}
@media (min-width: 721px) {
  .qf-burger { display: none; }
}
</style>
