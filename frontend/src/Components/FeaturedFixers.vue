<template>
  <div class="qf-fxr">
    <header class="qf-fxr__head">
      <div>
        <div class="qf-fxr__eyebrow qf-mono">/fixers — top rated this week</div>
        <h2 class="qf-fxr__title">
          The hands behind <em>every</em> repair.
        </h2>
      </div>
      <router-link to="/fixer" class="qf-fxr__viewall">
        <span>View all fixers</span>
        <i class="bi bi-arrow-up-right"></i>
      </router-link>
    </header>

    <div class="qf-fxr__rail">
      <div v-if="loading" class="qf-fxr__empty qf-mono">/loading fixers…</div>
      <div v-else-if="fixers.length === 0" class="qf-fxr__empty qf-mono">/no fixers available</div>

      <article
        v-for="(fixer, i) in featured"
        :key="fixer.id || i"
        class="qf-fxr__card"
        :style="{ animationDelay: (i * 0.06) + 's' }"
      >
        <div class="qf-fxr__num qf-mono">#{{ String(i + 1).padStart(2, '0') }}</div>
        <div class="qf-fxr__media">
          <img
            :src="fixer.image || `https://i.pravatar.cc/300?u=${fixer.id || i}`"
            :alt="fixer.name"
            loading="lazy"
          />
          <div class="qf-fxr__status">
            <span class="qf-fxr__status-dot"></span>
            <span class="qf-mono">ON DUTY</span>
          </div>
        </div>
        <div class="qf-fxr__body">
          <div class="qf-fxr__meta">
            <span class="qf-mono">{{ (fixer.career || 'GENERAL').toUpperCase() }}</span>
            <span class="qf-fxr__rating">
              <i class="bi bi-star-fill"></i>
              {{ (fixer.rating || (4.4 + (i * 0.13) % 0.6)).toFixed(1) }}
            </span>
          </div>
          <h3 class="qf-fxr__name">{{ fixer.name || 'Unnamed Fixer' }}</h3>
          <div class="qf-fxr__loc">
            <i class="bi bi-geo-alt"></i>
            <span>{{ fixer.location || fixer.place || 'Phnom Penh' }}</span>
          </div>
          <div class="qf-fxr__foot">
            <div class="qf-fxr__jobs">
              <span class="qf-fxr__jobs-num">{{ fixer.jobs_completed || ((i + 1) * 27) }}</span>
              <span class="qf-mono">JOBS</span>
            </div>
            <router-link to="/fixer" class="qf-fxr__cta">
              <span>Book</span>
              <i class="bi bi-arrow-up-right"></i>
            </router-link>
          </div>
        </div>
      </article>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

const fixers = ref([])
const loading = ref(true)

const featured = computed(() => fixers.value.slice(0, 6))

onMounted(async () => {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/fixer/list')
    fixers.value = response.data.fixers || response.data.data || response.data || []
  } catch (e) {
    console.warn('Could not load fixers:', e.message)
    fixers.value = []
  } finally {
    loading.value = false
  }
})
</script>

<style scoped>
.qf-fxr {
  font-family: var(--qf-font-body);
  color: var(--qf-ink);
}
.qf-mono {
  font-family: var(--qf-font-mono);
  font-size: 11px;
  letter-spacing: 0.08em;
  text-transform: uppercase;
}

/* Head */
.qf-fxr__head {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  gap: 24px;
  margin-bottom: 36px;
}
.qf-fxr__eyebrow {
  color: var(--qf-orange);
  margin-bottom: 12px;
  display: block;
}
.qf-fxr__title {
  font-family: var(--qf-font-display);
  font-weight: 700;
  font-size: clamp(32px, 4.2vw, 56px);
  line-height: 1.02;
  letter-spacing: -0.03em;
  margin: 0;
  max-width: 700px;
}
.qf-fxr__title em {
  font-style: italic;
  color: var(--qf-orange);
  font-weight: 600;
}
.qf-fxr__viewall {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 11px 18px;
  background: transparent;
  border: 1px solid var(--qf-ink);
  color: var(--qf-ink);
  text-decoration: none;
  border-radius: 999px;
  font-weight: 600;
  font-size: 13.5px;
  white-space: nowrap;
  transition: background 0.25s ease, color 0.25s ease, transform 0.15s ease;
}
.qf-fxr__viewall i { transition: transform 0.3s ease; }
.qf-fxr__viewall:hover {
  background: var(--qf-ink);
  color: var(--qf-bone);
  transform: translateY(-1px);
}
.qf-fxr__viewall:hover i { transform: translate(2px, -2px); }

/* Rail */
.qf-fxr__rail {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 18px;
}

.qf-fxr__empty {
  grid-column: 1 / -1;
  padding: 60px;
  text-align: center;
  color: var(--qf-fog);
  border: 1px dashed var(--qf-rule);
  border-radius: 14px;
}

/* Card */
.qf-fxr__card {
  position: relative;
  display: flex;
  flex-direction: column;
  background: var(--qf-bone-deep);
  border: 1px solid var(--qf-rule);
  border-radius: 16px;
  overflow: hidden;
  opacity: 0;
  transform: translateY(20px);
  animation: qf-fxr-rise 0.6s cubic-bezier(.2,.9,.3,1.05) forwards;
  transition: border-color 0.25s ease, transform 0.3s ease, box-shadow 0.3s ease;
}
.qf-fxr__card:hover {
  border-color: var(--qf-ink);
  transform: translateY(-4px) !important;
  box-shadow: 0 24px 60px -22px rgba(15,16,17,0.2);
}
@keyframes qf-fxr-rise {
  to { opacity: 1; transform: translateY(0); }
}

.qf-fxr__num {
  position: absolute;
  top: 14px;
  left: 14px;
  z-index: 3;
  color: var(--qf-bone);
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 0.04em;
  mix-blend-mode: difference;
}

.qf-fxr__media {
  position: relative;
  aspect-ratio: 5 / 4;
  overflow: hidden;
  background: var(--qf-steel);
}
.qf-fxr__media img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.7s cubic-bezier(.2,.9,.3,1);
  filter: saturate(0.92) contrast(1.04);
}
.qf-fxr__card:hover .qf-fxr__media img {
  transform: scale(1.08);
  filter: saturate(1) contrast(1);
}
.qf-fxr__status {
  position: absolute;
  bottom: 12px;
  right: 12px;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 5px 9px;
  background: rgba(15,16,17,0.78);
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  color: var(--qf-bone);
  border-radius: 999px;
  font-size: 9.5px;
}
.qf-fxr__status-dot {
  width: 5px;
  height: 5px;
  background: #34d367;
  border-radius: 50%;
  box-shadow: 0 0 0 3px rgba(52, 211, 103, 0.25);
  animation: qf-pulse 1.6s infinite ease-in-out;
}
@keyframes qf-pulse {
  0%, 100% { box-shadow: 0 0 0 0 rgba(52, 211, 103, 0.4); }
  50% { box-shadow: 0 0 0 6px rgba(52, 211, 103, 0); }
}

.qf-fxr__body { padding: 16px 18px 18px; display: flex; flex-direction: column; gap: 8px; flex: 1; }
.qf-fxr__meta {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.qf-fxr__meta .qf-mono { color: var(--qf-fog); font-size: 10px; }
.qf-fxr__rating {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-family: var(--qf-font-mono);
  font-size: 12px;
  font-weight: 600;
  color: var(--qf-ink);
}
.qf-fxr__rating i { color: var(--qf-orange); font-size: 10px; }

.qf-fxr__name {
  font-family: var(--qf-font-display);
  font-weight: 700;
  font-size: 20px;
  letter-spacing: -0.02em;
  margin: 0;
  color: var(--qf-ink);
  line-height: 1.15;
}
.qf-fxr__loc {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
  color: var(--qf-steel);
}
.qf-fxr__loc i { color: var(--qf-orange); font-size: 13px; }

.qf-fxr__foot {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  margin-top: 10px;
  padding-top: 14px;
  border-top: 1px dashed var(--qf-rule);
}
.qf-fxr__jobs { display: flex; flex-direction: column; gap: 1px; }
.qf-fxr__jobs-num {
  font-family: var(--qf-font-display);
  font-weight: 700;
  font-size: 22px;
  letter-spacing: -0.02em;
  color: var(--qf-ink);
  line-height: 1;
}
.qf-fxr__jobs .qf-mono { color: var(--qf-fog); font-size: 9.5px; }

.qf-fxr__cta {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 14px;
  background: var(--qf-ink);
  color: var(--qf-bone);
  text-decoration: none;
  border-radius: 999px;
  font-weight: 600;
  font-size: 12.5px;
  transition: background 0.25s ease, transform 0.18s ease;
}
.qf-fxr__cta i { transition: transform 0.3s ease; }
.qf-fxr__cta:hover { background: var(--qf-orange); transform: translateX(2px); }
.qf-fxr__cta:hover i { transform: translate(2px, -2px); }

/* Responsive */
@media (max-width: 720px) {
  .qf-fxr__head { flex-direction: column; align-items: flex-start; gap: 14px; }
  .qf-fxr__rail { grid-template-columns: 1fr 1fr; gap: 14px; }
  .qf-fxr__name { font-size: 17px; }
  .qf-fxr__jobs-num { font-size: 18px; }
}
@media (max-width: 480px) {
  .qf-fxr__rail { grid-template-columns: 1fr; }
}
</style>
