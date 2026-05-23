<template>
  <div class="qf-profile">
    <!-- Top bar -->
    <header class="qf-topbar">
      <router-link to="/" class="qf-back">
        <i class="bi bi-arrow-left"></i> Back
      </router-link>
      <span class="qf-brand"><i class="bi bi-wrench-adjustable-circle-fill"></i> QUICK<b>FIX</b></span>
    </header>

    <main class="qf-shell">
      <!-- Hero / identity -->
      <section class="qf-card qf-herocard">
        <div class="qf-hero"></div>

        <div class="qf-avatar-wrap">
          <img class="qf-avatar" :src="avatarSrc" @error="onAvatarError" alt="Profile photo" />
          <button class="qf-cam" @click="openUpload" title="Change photo" aria-label="Change photo">
            <i class="bi bi-camera-fill"></i>
          </button>
        </div>

        <div class="qf-identity">
          <h1 class="qf-name">{{ authStore.user?.name || 'Your profile' }}</h1>
          <div class="qf-meta">
            <span class="qf-role"><i class="bi bi-shield-check"></i> {{ authStore.user?.role || 'user' }}</span>
            <span v-if="authStore.user?.email" class="qf-dot">·</span>
            <span v-if="authStore.user?.email" class="qf-email">{{ authStore.user?.email }}</span>
          </div>
          <button class="qf-btn qf-btn--primary qf-edit" @click="openEdit">
            <i class="bi bi-pencil-square"></i> Edit profile
          </button>
        </div>
      </section>

      <!-- Details -->
      <section class="qf-card qf-details">
        <h2 class="qf-section">Account details</h2>
        <div class="qf-grid">
          <div class="qf-row">
            <span class="qf-row__icon"><i class="bi bi-person"></i></span>
            <span class="qf-row__text">
              <span class="qf-row__label">User name</span>
              <span class="qf-row__value">{{ authStore.user?.name || '—' }}</span>
            </span>
          </div>
          <div class="qf-row">
            <span class="qf-row__icon"><i class="bi bi-shield-lock"></i></span>
            <span class="qf-row__text">
              <span class="qf-row__label">Role</span>
              <span class="qf-row__value qf-cap">{{ authStore.user?.role || '—' }}</span>
            </span>
          </div>
          <div class="qf-row">
            <span class="qf-row__icon"><i class="bi bi-envelope"></i></span>
            <span class="qf-row__text">
              <span class="qf-row__label">Email</span>
              <span class="qf-row__value">{{ authStore.user?.email || '—' }}</span>
            </span>
          </div>
          <div class="qf-row">
            <span class="qf-row__icon"><i class="bi bi-telephone"></i></span>
            <span class="qf-row__text">
              <span class="qf-row__label">Phone</span>
              <span class="qf-row__value" :class="{ 'qf-muted': !authStore.user?.phone }">
                {{ authStore.user?.phone || 'Not set' }}
              </span>
            </span>
          </div>
          <div class="qf-row">
            <span class="qf-row__icon"><i class="bi bi-calendar3"></i></span>
            <span class="qf-row__text">
              <span class="qf-row__label">Joined</span>
              <span class="qf-row__value">{{ formatDate(authStore.user?.created_at) }}</span>
            </span>
          </div>
          <div class="qf-row">
            <span class="qf-row__icon"><i class="bi bi-clock"></i></span>
            <span class="qf-row__text">
              <span class="qf-row__label">Time</span>
              <span class="qf-row__value">{{ formatTime(authStore.user?.created_at) }}</span>
            </span>
          </div>
        </div>
      </section>
    </main>

    <!-- Edit info modal -->
    <transition name="qf-modal">
      <div v-if="showEdit" class="qf-backdrop" @click.self="showEdit = false">
        <div class="qf-modal" role="dialog" aria-modal="true">
          <header class="qf-modal__head">
            <h3>Edit information</h3>
            <button class="qf-x" @click="showEdit = false" aria-label="Close"><i class="bi bi-x-lg"></i></button>
          </header>
          <form class="qf-modal__body" @submit.prevent="update">
            <label class="qf-field">
              <span class="qf-field__label">User name</span>
              <input v-model="form.name" type="text" class="qf-input" placeholder="Your name" autofocus />
            </label>
            <label class="qf-field">
              <span class="qf-field__label">Phone number</span>
              <input v-model="form.phone" type="tel" class="qf-input" placeholder="Add a phone number" />
            </label>
            <div class="qf-modal__foot">
              <button type="button" class="qf-btn qf-btn--ghost" @click="showEdit = false">Cancel</button>
              <button type="submit" class="qf-btn qf-btn--primary" :disabled="saving">
                <i class="bi bi-check2"></i> {{ saving ? 'Saving…' : 'Update' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </transition>

    <!-- Upload photo modal -->
    <transition name="qf-modal">
      <div v-if="showUpload" class="qf-backdrop" @click.self="showUpload = false">
        <div class="qf-modal" role="dialog" aria-modal="true">
          <header class="qf-modal__head">
            <h3>Update photo</h3>
            <button class="qf-x" @click="showUpload = false" aria-label="Close"><i class="bi bi-x-lg"></i></button>
          </header>
          <div class="qf-modal__body">
            <div
              class="qf-drop"
              :class="{ 'is-drag': dragging }"
              @dragover.prevent="dragging = true"
              @dragleave.prevent="dragging = false"
              @drop.prevent="handleDrop"
              @click="triggerFileInput"
            >
              <img v-if="image" :src="image" class="qf-drop__preview" alt="Preview" />
              <template v-else>
                <i class="bi bi-cloud-arrow-up qf-drop__icon"></i>
                <p class="qf-drop__title">Drop an image here, or <span>browse</span></p>
                <small class="qf-drop__hint">PNG or JPG · up to 2&nbsp;MB</small>
              </template>
              <input ref="fileInput" type="file" accept="image/*" class="qf-hidden" @change="handleFiles" />
            </div>
            <div class="qf-modal__foot">
              <button type="button" class="qf-btn qf-btn--ghost" @click="resetForm">Reset</button>
              <button type="button" class="qf-btn qf-btn--primary" :disabled="!selectedFile || uploading" @click="updateProfile">
                <i class="bi bi-check2"></i> {{ uploading ? 'Uploading…' : 'Save photo' }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import { useAuthStore } from '@/stores/auth-store'
import axios from 'axios'

const authStore = useAuthStore()

const showEdit = ref(false)
const showUpload = ref(false)
const saving = ref(false)
const uploading = ref(false)
const dragging = ref(false)
const image = ref(null)
const selectedFile = ref(null)
const fileInput = ref(null)
const form = reactive({ name: '', phone: '' })

const defaultAvatar = computed(
  () => `https://ui-avatars.com/api/?name=${encodeURIComponent(authStore.user?.name || 'User')}&background=f59e0b&color=fff&bold=true&size=256`
)
const avatarSrc = computed(() => authStore.user?.profile || defaultAvatar.value)
function onAvatarError(e) { e.target.src = defaultAvatar.value }

function openEdit() {
  form.name = authStore.user?.name || ''
  form.phone = authStore.user?.phone || ''
  showEdit.value = true
}
function openUpload() {
  resetForm()
  showUpload.value = true
}

function triggerFileInput() { fileInput.value?.click() }
function handleFiles(event) {
  const file = (event.target.files || [])[0]
  if (file) previewImage(file)
}
function handleDrop(event) {
  dragging.value = false
  const file = (event.dataTransfer.files || [])[0]
  if (file) previewImage(file)
}
function previewImage(file) {
  selectedFile.value = file
  const reader = new FileReader()
  reader.onload = (e) => { image.value = e.target.result }
  reader.readAsDataURL(file)
}
function resetForm() {
  image.value = null
  selectedFile.value = null
  if (fileInput.value) fileInput.value.value = ''
}

async function update() {
  try {
    saving.value = true
    const accessToken = localStorage.getItem('access_token')
    const response = await axios.put(
      `http://127.0.0.1:8000/api/update/${authStore.user.id}`,
      { name: form.name, phone: form.phone },
      { headers: { 'Content-Type': 'application/json', Authorization: `Bearer ${accessToken}` } }
    )
    authStore.user.name = form.name
    authStore.user.phone = form.phone
    localStorage.setItem('user', JSON.stringify(response.data.user ?? authStore.user))
    showEdit.value = false
  } catch (error) {
    console.error('Backend error:', error?.response?.data ?? error)
  } finally {
    saving.value = false
  }
}

async function updateProfile() {
  if (!selectedFile.value) return
  try {
    uploading.value = true
    const formData = new FormData()
    formData.append('profile', selectedFile.value)
    const accessToken = localStorage.getItem('access_token')
    const response = await axios.post(
      `http://127.0.0.1:8000/api/update/profile/${authStore.user.id}`,
      formData,
      { headers: { 'Content-Type': 'multipart/form-data', Authorization: `Bearer ${accessToken}` } }
    )
    if (response.data?.user) localStorage.setItem('user', JSON.stringify(response.data.user))
    location.reload()
  } catch (error) {
    console.error('Backend error:', error?.response?.data ?? error)
    uploading.value = false
  }
}

function formatDate(date) {
  return date ? new Date(date).toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: 'numeric' }) : '—'
}
function formatTime(date) {
  return date ? new Date(date).toLocaleTimeString(undefined, { hour: '2-digit', minute: '2-digit' }) : '—'
}
</script>

<style scoped>
.qf-profile {
  --amber: #f59e0b;
  --orange: #f97316;
  --ink: #0f172a;
  --muted: #64748b;
  --line: #eef1f5;
  --card: #ffffff;
  min-height: 100vh;
  font-family: 'DM Sans', system-ui, sans-serif;
  color: var(--ink);
  background:
    radial-gradient(1100px 460px at 50% -220px, #ffe9c7 0%, rgba(255, 233, 199, 0) 70%),
    #f5f6f8;
  padding: 1.1rem clamp(1rem, 4vw, 2.5rem) 4rem;
}

/* Top bar */
.qf-topbar { display: flex; align-items: center; justify-content: space-between; max-width: 860px; margin: 0 auto 1.5rem; }
.qf-back {
  display: inline-flex; align-items: center; gap: .45rem; text-decoration: none;
  background: #fff; color: #334155; border: 1px solid #e8eaee; font-weight: 600; font-size: .9rem;
  padding: .5rem .95rem; border-radius: 999px; box-shadow: 0 1px 3px rgba(15, 23, 42, .06);
  transition: color .15s ease, border-color .15s ease, transform .15s ease;
}
.qf-back:hover { color: var(--orange); border-color: #fed7aa; transform: translateX(-2px); }
.qf-brand { font-family: 'Bricolage Grotesque', sans-serif; font-weight: 700; letter-spacing: .3px; color: #1e293b; display: inline-flex; align-items: center; gap: .4rem; }
.qf-brand b { color: var(--amber); }
.qf-brand i { color: var(--amber); font-size: 1.2rem; }

/* Shell */
.qf-shell { max-width: 860px; margin: 0 auto; display: flex; flex-direction: column; gap: 1.1rem; }

.qf-card {
  background: var(--card); border: 1px solid var(--line); border-radius: 22px;
  box-shadow: 0 18px 50px -28px rgba(15, 23, 42, .35);
  animation: qf-rise .6s cubic-bezier(.2, .8, .2, 1) both;
}

/* Hero card */
.qf-herocard { overflow: hidden; position: relative; }
.qf-hero {
  height: 132px;
  background:
    radial-gradient(120% 160% at 85% -40%, rgba(255, 255, 255, .35), transparent 55%),
    linear-gradient(120deg, var(--amber) 0%, var(--orange) 100%);
  position: relative;
}
.qf-hero::after {
  content: ''; position: absolute; inset: 0;
  background-image: radial-gradient(rgba(255, 255, 255, .35) 1px, transparent 1.4px);
  background-size: 18px 18px; opacity: .35;
  -webkit-mask-image: linear-gradient(180deg, #000, transparent);
          mask-image: linear-gradient(180deg, #000, transparent);
}

.qf-avatar-wrap { position: relative; width: 124px; margin: -64px auto 0; }
.qf-avatar {
  width: 124px; height: 124px; border-radius: 50%; object-fit: cover;
  border: 5px solid #fff; background: #f1f5f9;
  box-shadow: 0 12px 28px -10px rgba(15, 23, 42, .45);
  display: block;
}
.qf-cam {
  position: absolute; right: 2px; bottom: 6px;
  width: 36px; height: 36px; border-radius: 50%; border: 3px solid #fff; cursor: pointer;
  display: grid; place-items: center; color: #fff; font-size: .95rem;
  background: linear-gradient(135deg, var(--amber), var(--orange));
  box-shadow: 0 6px 16px -4px rgba(245, 158, 11, .65);
  transition: transform .15s ease;
}
.qf-cam:hover { transform: scale(1.08); }

.qf-identity { text-align: center; padding: .8rem 1.5rem 1.8rem; }
.qf-name { font-family: 'Bricolage Grotesque', sans-serif; font-weight: 800; font-size: 1.7rem; letter-spacing: -.02em; margin: 0; }
.qf-meta { display: inline-flex; align-items: center; gap: .5rem; flex-wrap: wrap; justify-content: center; margin-top: .45rem; }
.qf-role {
  display: inline-flex; align-items: center; gap: .35rem; text-transform: capitalize;
  background: rgba(245, 158, 11, .13); color: #b45309; font-weight: 700; font-size: .76rem;
  padding: .22rem .65rem; border-radius: 999px;
}
.qf-dot { color: #cbd5e1; }
.qf-email { color: var(--muted); font-size: .9rem; }
.qf-edit { margin-top: 1.1rem; }

/* Details */
.qf-details { padding: 1.5rem 1.6rem 1.7rem; }
.qf-section {
  font-family: 'IBM Plex Mono', monospace; font-size: .72rem; letter-spacing: .18em; text-transform: uppercase;
  color: #94a3b8; margin: 0 0 1.1rem; font-weight: 600;
}
.qf-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: .85rem 1.4rem; }
@media (max-width: 560px) { .qf-grid { grid-template-columns: 1fr; } }
.qf-row { display: flex; align-items: center; gap: .8rem; padding: .55rem 0; border-bottom: 1px solid #f3f4f6; }
.qf-row__icon {
  flex: 0 0 auto; width: 40px; height: 40px; border-radius: 12px; display: grid; place-items: center;
  background: rgba(245, 158, 11, .1); color: var(--orange); font-size: 1.15rem;
}
.qf-row__text { display: flex; flex-direction: column; min-width: 0; }
.qf-row__label { font-family: 'IBM Plex Mono', monospace; font-size: .64rem; letter-spacing: .12em; text-transform: uppercase; color: #94a3b8; }
.qf-row__value { font-size: .95rem; font-weight: 600; color: var(--ink); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.qf-row__value.qf-muted { color: #cbd5e1; font-weight: 500; font-style: italic; }
.qf-cap { text-transform: capitalize; }

/* Buttons */
.qf-btn {
  display: inline-flex; align-items: center; justify-content: center; gap: .45rem;
  border: 0; cursor: pointer; font-family: inherit; font-weight: 700; font-size: .9rem;
  padding: .6rem 1.3rem; border-radius: 11px; transition: transform .15s ease, box-shadow .2s ease, background .15s ease;
}
.qf-btn--primary {
  color: #fff; background: linear-gradient(135deg, var(--amber), var(--orange));
  box-shadow: 0 10px 24px -8px rgba(245, 158, 11, .6);
}
.qf-btn--primary:hover { transform: translateY(-2px); box-shadow: 0 14px 30px -10px rgba(245, 158, 11, .7); }
.qf-btn--primary:disabled { opacity: .6; cursor: not-allowed; transform: none; }
.qf-btn--ghost { background: #f1f5f9; color: #475569; }
.qf-btn--ghost:hover { background: #e2e8f0; }

/* Modal */
.qf-backdrop {
  position: fixed; inset: 0; z-index: 100; display: flex; align-items: center; justify-content: center;
  padding: 1rem; background: rgba(15, 23, 42, .55); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px);
}
.qf-modal {
  width: 100%; max-width: 420px; background: #fff; border-radius: 20px; overflow: hidden;
  box-shadow: 0 40px 80px -25px rgba(0, 0, 0, .55);
}
.qf-modal__head { display: flex; align-items: center; justify-content: space-between; padding: 1.1rem 1.3rem; border-bottom: 1px solid var(--line); }
.qf-modal__head h3 { font-family: 'Bricolage Grotesque', sans-serif; font-weight: 700; font-size: 1.15rem; margin: 0; }
.qf-x { border: 0; background: #f1f5f9; color: #64748b; width: 32px; height: 32px; border-radius: 9px; cursor: pointer; display: grid; place-items: center; transition: background .15s ease, color .15s ease; }
.qf-x:hover { background: #fee2e2; color: #dc2626; }
.qf-modal__body { padding: 1.3rem; display: flex; flex-direction: column; gap: 1rem; }
.qf-modal__foot { display: flex; justify-content: flex-end; gap: .6rem; margin-top: .3rem; }

.qf-field { display: flex; flex-direction: column; gap: .4rem; }
.qf-field__label { font-size: .78rem; font-weight: 600; color: #475569; }
.qf-input {
  width: 100%; font-family: inherit; font-size: .95rem; color: var(--ink); background: #fff;
  border: 1px solid #d8dde4; border-radius: 11px; padding: .65rem .85rem; outline: none;
  transition: border-color .15s ease, box-shadow .15s ease;
}
.qf-input::placeholder { color: #9aa4b2; }
.qf-input:focus { border-color: var(--amber); box-shadow: 0 0 0 3px rgba(245, 158, 11, .16); }

/* Drop zone */
.qf-hidden { display: none; }
.qf-drop {
  position: relative; border: 2px dashed #d8dde4; border-radius: 16px; cursor: pointer;
  min-height: 220px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: .5rem;
  text-align: center; color: var(--muted); background: #fafbfc; overflow: hidden;
  transition: border-color .15s ease, background .15s ease;
}
.qf-drop:hover, .qf-drop.is-drag { border-color: var(--amber); background: #fff7ec; }
.qf-drop__icon { font-size: 2.4rem; color: var(--amber); }
.qf-drop__title { margin: 0; font-size: .95rem; font-weight: 600; color: #475569; }
.qf-drop__title span { color: var(--orange); text-decoration: underline; }
.qf-drop__hint { font-size: .76rem; color: #9aa4b2; }
.qf-drop__preview { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: contain; background: #fff; }

/* Animations */
@keyframes qf-rise { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
.qf-modal-enter-active, .qf-modal-leave-active { transition: opacity .22s ease; }
.qf-modal-enter-from, .qf-modal-leave-to { opacity: 0; }
.qf-modal-enter-active .qf-modal { transition: transform .28s cubic-bezier(.2, .8, .2, 1), opacity .22s ease; }
.qf-modal-enter-from .qf-modal, .qf-modal-leave-to .qf-modal { transform: translateY(14px) scale(.97); opacity: 0; }

@media (prefers-reduced-motion: reduce) {
  .qf-card, .qf-cam, .qf-btn, .qf-back, .qf-modal { animation: none !important; transition: none !important; }
}
</style>
