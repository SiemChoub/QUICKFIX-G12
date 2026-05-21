<template>
  <router-view>
    <router-view v-slot="{ Component }">
      <component :is="Component" />
    </router-view>
  </router-view>

  <WebLayout>
    <div class="qf-home">
      <!-- ============ HERO ============ -->
      <section class="qf-hero">
        <!-- Blueprint grid background -->
        <div class="qf-hero__grid" aria-hidden="true"></div>
        <div class="qf-hero__glow" aria-hidden="true"></div>

        <div class="qf-hero__inner">
          <!-- Top ticker -->
          <div class="qf-ticker">
            <span class="qf-ticker__dot"></span>
            <span class="qf-mono">LIVE</span>
            <span class="qf-ticker__line"></span>
            <span class="qf-mono">{{ todayStamp }}</span>
            <span class="qf-ticker__line"></span>
            <span class="qf-mono">{{ activeFixers }} FIXERS ON DUTY</span>
          </div>

          <!-- Editorial split -->
          <div class="qf-hero__split">
            <!-- LEFT: Headline column -->
            <div class="qf-hero__left">
              <div class="qf-eyebrow">
                <span class="qf-mono">/0{{ currentSlide + 1 }} — {{ slides[currentSlide].label }}</span>
              </div>
              <h1 class="qf-display">
                <span class="qf-display__line">{{ slides[currentSlide].title[0] }}</span>
                <span class="qf-display__line qf-display__line--accent">{{ slides[currentSlide].title[1] }}</span>
                <span v-if="slides[currentSlide].title[2]" class="qf-display__line">{{ slides[currentSlide].title[2] }}</span>
              </h1>
              <p class="qf-lead">{{ slides[currentSlide].desc }}</p>

              <div class="qf-cta-row">
                <router-link to="/fixerForm" class="qf-btn qf-btn--primary">
                  <span>Become a Fixer</span>
                  <i class="bi bi-arrow-up-right"></i>
                </router-link>
                <a href="#services" class="qf-btn qf-btn--ghost">
                  <span>Browse services</span>
                </a>
              </div>

              <!-- Stat strip -->
              <div class="qf-stats">
                <div class="qf-stat">
                  <div class="qf-stat__num">24<span>/7</span></div>
                  <div class="qf-stat__lbl">Roadside service</div>
                </div>
                <div class="qf-stat">
                  <div class="qf-stat__num">12<span>min</span></div>
                  <div class="qf-stat__lbl">Avg. dispatch</div>
                </div>
                <div class="qf-stat">
                  <div class="qf-stat__num">4.9<span>★</span></div>
                  <div class="qf-stat__lbl">Customer rating</div>
                </div>
              </div>
            </div>

            <!-- RIGHT: Image stack -->
            <div class="qf-hero__right">
              <div class="qf-frame">
                <div class="qf-frame__tag qf-mono">
                  <span class="qf-frame__dot"></span> {{ slides[currentSlide].tag }}
                </div>
                <div class="qf-frame__media" ref="slide">
                  <div
                    v-for="(s, i) in slides"
                    :key="i"
                    class="qf-frame__slide"
                    :class="{ 'qf-frame__slide--active': i === currentSlide }"
                    :style="{ backgroundImage: `url(${s.img})` }"
                  ></div>
                </div>
                <div class="qf-frame__meta">
                  <div>
                    <div class="qf-mono qf-frame__lbl">SHOT</div>
                    <div class="qf-frame__val">{{ String(currentSlide + 1).padStart(2,'0') }} / {{ String(slides.length).padStart(2,'0') }}</div>
                  </div>
                  <div class="qf-frame__nav">
                    <button class="qf-pill" ref="prevButton" aria-label="Previous">
                      <i class="bi bi-arrow-left"></i>
                    </button>
                    <button class="qf-pill qf-pill--filled" ref="nextButton" aria-label="Next">
                      <i class="bi bi-arrow-right"></i>
                    </button>
                  </div>
                </div>
              </div>

              <!-- Floating spec card -->
              <div class="qf-spec">
                <div class="qf-mono qf-spec__lbl">/spec</div>
                <div class="qf-spec__title">Certified technicians</div>
                <div class="qf-spec__row">
                  <span>Diagnostics</span><span class="qf-mono">OBD-II</span>
                </div>
                <div class="qf-spec__row">
                  <span>Coverage</span><span class="qf-mono">25 Provinces</span>
                </div>
                <div class="qf-spec__row">
                  <span>Warranty</span><span class="qf-mono">90 Days</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ============ SERVICES SECTION ============ -->
      <section id="services" class="qf-section">
        <WebService />
      </section>

      <!-- ============ ABOUT ============ -->
      <section class="qf-section">
        <AboutPage />
      </section>

      <FooterPage />

      <!-- ============ FLOATING FEEDBACK BUTTON ============ -->
      <button id="feedbackBtn" data-bs-toggle="modal" data-bs-target="#exampleModal" aria-label="Send feedback">
        <i class="bi bi-chat-dots-fill"></i>
      </button>

      <!-- Feedback modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content qf-modal">
            <div class="qf-modal__head">
              <div>
                <div class="qf-mono">/feedback</div>
                <h3>Tell us how we did</h3>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="qf-modal__body">
              <textarea
                class="qf-textarea"
                rows="5"
                v-model="content"
                placeholder="Share your experience, ideas or report an issue..."
              ></textarea>
            </div>
            <div class="qf-modal__foot">
              <button type="button" class="qf-btn qf-btn--ghost" data-bs-dismiss="modal">Cancel</button>
              <button
                type="button"
                class="qf-btn qf-btn--primary"
                @click="feedback"
                data-bs-dismiss="modal"
              >Send feedback</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </WebLayout>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import WebLayout from '@/Components/Layouts/WebLayout.vue'
import AboutPage from '@/Components/AboutPage.vue'
import FooterPage from '@/Components/FooterPage.vue'
import WebService from '@/Components/WebServiceCustomer.vue'
import axios from 'axios'

interface Slide {
  label: string
  tag: string
  title: string[]
  desc: string
  img: string
}

const slides: Slide[] = [
  {
    label: 'PERSONALIZED SERVICE',
    tag: 'MODE / CUSTOM',
    title: ['Built for', 'your vehicle.', 'On your terms.'],
    desc: 'Each vehicle is treated with individual attention and care. We tailor our services to meet your specific needs and preferences — from compact city cars to heavy-duty rides.',
    img: 'https://i.pinimg.com/564x/20/06/58/200658ead1212c34b994d8842b8538ee.jpg'
  },
  {
    label: 'EFFICIENT SERVICE',
    tag: 'MODE / RAPID',
    title: ['Time on the road,', 'not in the garage.'],
    desc: 'Streamlined diagnostics and skilled technicians ensure prompt, efficient repairs — minimizing downtime so you can keep moving.',
    img: 'https://i.pinimg.com/564x/86/17/d3/8617d33d2e81105204f8a68b9b2866ec.jpg'
  },
  {
    label: 'SKILLED TECHNICIANS',
    tag: 'MODE / EXPERT',
    title: ['Certified hands.', 'Real experience.'],
    desc: 'Highly trained technicians with deep experience across cars, motorcycles, and commercial vehicles — backed by ongoing certification.',
    img: 'https://i.pinimg.com/564x/31/65/46/316546a7fb5d1ce47e3f6146fb90a162.jpg'
  },
  {
    label: 'QUALITY PARTS',
    tag: 'MODE / OEM',
    title: ['Genuine parts.', 'No shortcuts.'],
    desc: 'We use high-quality, genuine parts and materials in every repair to ensure long-term durability and dependable performance.',
    img: 'https://i.pinimg.com/564x/df/1d/1a/df1d1af1897cd846b3e5fa3e265913ab.jpg'
  },
  {
    label: 'SPECIALIZED KNOWLEDGE',
    tag: 'MODE / TECH',
    title: ['Modern systems.', 'Decoded.'],
    desc: 'We stay current with the latest automotive technology and repair techniques to diagnose and resolve issues effectively.',
    img: 'https://i.pinimg.com/564x/65/45/1f/65451f8ab361bb8f42f5db02b0fcd20c.jpg'
  },
  {
    label: 'CUSTOMER SERVICE',
    tag: 'MODE / CARE',
    title: ['Clear communication.', 'Honest pricing.'],
    desc: 'Our friendly staff prioritize transparency at every step. We explain what we found, what we fixed, and what to watch for next.',
    img: 'https://i.pinimg.com/736x/f3/ad/f5/f3adf501c6010aaab1aceb6377de20ea.jpg'
  }
]

const content = ref<string | null>(null)
const slide = ref<HTMLElement | null>(null)
const nextButton = ref<HTMLElement | null>(null)
const prevButton = ref<HTMLElement | null>(null)
const currentSlide = ref(0)
const activeFixers = ref(42)

const todayStamp = computed(() => {
  const d = new Date()
  const dd = String(d.getDate()).padStart(2, '0')
  const mm = String(d.getMonth() + 1).padStart(2, '0')
  const yyyy = d.getFullYear()
  return `${dd}.${mm}.${yyyy}`
})

const moveSlide = (direction: 'next' | 'prev') => {
  if (direction === 'next') {
    currentSlide.value = (currentSlide.value + 1) % slides.length
  } else {
    currentSlide.value = (currentSlide.value - 1 + slides.length) % slides.length
  }
}

const feedback = async () => {
  try {
    const stored = localStorage.getItem('user')
    if (!stored) return
    const user = JSON.parse(stored).id
    await axios.post('http://127.0.0.1:8000/api/feedback/create', {
      user_id: user,
      content: content.value
    })
    content.value = null
  } catch (e) {
    console.error('Error feedback:')
  }
}

let autoTimer: ReturnType<typeof setInterval> | null = null

onMounted(() => {
  if (nextButton.value && prevButton.value) {
    nextButton.value.addEventListener('click', () => moveSlide('next'))
    prevButton.value.addEventListener('click', () => moveSlide('prev'))
  }
  autoTimer = setInterval(() => moveSlide('next'), 7000)
})

onBeforeUnmount(() => {
  if (autoTimer) clearInterval(autoTimer)
})
</script>

<style scoped>
.qf-home {
  --qf-bone: #F2EFE6;
  --qf-bone-deep: #EAE6DB;
  --qf-ink: #0F1011;
  --qf-steel: #1C1C1F;
  --qf-orange: #FF5B1F;
  --qf-orange-deep: #D8460B;
  --qf-fog: #9C998F;
  --qf-rule: rgba(15, 16, 17, 0.12);
  --qf-rule-strong: rgba(15, 16, 17, 0.22);
  --qf-font-display: 'Bricolage Grotesque', system-ui, sans-serif;
  --qf-font-body: 'DM Sans', system-ui, sans-serif;
  --qf-font-mono: 'IBM Plex Mono', 'Menlo', monospace;
  background: var(--qf-bone);
  color: var(--qf-ink);
  font-family: var(--qf-font-body);
  font-feature-settings: 'ss01' on, 'cv11' on;
  padding-top: 78px;
  overflow-x: hidden;
}

/* expose tokens to children */
:global(:root) {
  --qf-bone: #F2EFE6;
  --qf-ink: #0F1011;
  --qf-steel: #1C1C1F;
  --qf-orange: #FF5B1F;
  --qf-fog: #9C998F;
  --qf-rule: rgba(15, 16, 17, 0.12);
  --qf-font-display: 'Bricolage Grotesque', system-ui, sans-serif;
  --qf-font-body: 'DM Sans', system-ui, sans-serif;
  --qf-font-mono: 'IBM Plex Mono', 'Menlo', monospace;
}

.qf-mono {
  font-family: var(--qf-font-mono);
  font-size: 11px;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: var(--qf-steel);
}

/* ============== HERO ============== */
.qf-hero {
  position: relative;
  padding: 36px 0 64px;
  overflow: hidden;
}
.qf-hero__grid {
  position: absolute;
  inset: 0;
  background-image:
    linear-gradient(to right, rgba(15,16,17,0.05) 1px, transparent 1px),
    linear-gradient(to bottom, rgba(15,16,17,0.05) 1px, transparent 1px);
  background-size: 64px 64px;
  mask-image: radial-gradient(ellipse 80% 60% at 50% 30%, black 30%, transparent 80%);
  -webkit-mask-image: radial-gradient(ellipse 80% 60% at 50% 30%, black 30%, transparent 80%);
  pointer-events: none;
}
.qf-hero__glow {
  position: absolute;
  top: -120px;
  right: -160px;
  width: 520px;
  height: 520px;
  background: radial-gradient(circle, rgba(255,91,31,0.18), transparent 70%);
  filter: blur(40px);
  pointer-events: none;
}
.qf-hero__inner {
  position: relative;
  max-width: 1440px;
  margin: 0 auto;
  padding: 0 32px;
  z-index: 2;
}

/* Ticker */
.qf-ticker {
  display: inline-flex;
  align-items: center;
  gap: 14px;
  padding: 8px 16px;
  background: var(--qf-ink);
  color: var(--qf-bone);
  border-radius: 999px;
  margin-bottom: 40px;
}
.qf-ticker .qf-mono { color: var(--qf-bone); font-size: 10.5px; }
.qf-ticker__dot {
  width: 6px;
  height: 6px;
  background: var(--qf-orange);
  border-radius: 50%;
  box-shadow: 0 0 0 4px rgba(255,91,31,0.25);
  animation: qf-pulse 1.6s infinite ease-in-out;
}
.qf-ticker__line { width: 1px; height: 12px; background: rgba(255,255,255,0.18); }
@keyframes qf-pulse {
  0%, 100% { box-shadow: 0 0 0 0 rgba(255,91,31,0.4); }
  50% { box-shadow: 0 0 0 7px rgba(255,91,31,0); }
}

/* Editorial split */
.qf-hero__split {
  display: grid;
  grid-template-columns: 1.15fr 0.95fr;
  gap: 64px;
  align-items: start;
}

/* LEFT */
.qf-hero__left { padding-top: 6px; }
.qf-eyebrow { margin-bottom: 22px; }
.qf-eyebrow .qf-mono { color: var(--qf-orange); }
.qf-display {
  font-family: var(--qf-font-display);
  font-weight: 800;
  font-size: clamp(48px, 7.2vw, 104px);
  line-height: 0.96;
  letter-spacing: -0.038em;
  margin: 0 0 28px;
  color: var(--qf-ink);
}
.qf-display__line {
  display: block;
  opacity: 0;
  transform: translateY(24px);
  animation: qf-rise 0.7s cubic-bezier(.2,.9,.3,1.05) forwards;
}
.qf-display__line:nth-child(2) { animation-delay: 0.1s; }
.qf-display__line:nth-child(3) { animation-delay: 0.2s; }
.qf-display__line--accent {
  color: var(--qf-orange);
  font-style: italic;
  font-weight: 600;
}
@keyframes qf-rise {
  to { opacity: 1; transform: translateY(0); }
}
.qf-lead {
  max-width: 540px;
  font-size: clamp(15px, 1.2vw, 18px);
  line-height: 1.55;
  color: var(--qf-steel);
  margin: 0 0 36px;
  opacity: 0;
  animation: qf-rise 0.7s ease 0.35s forwards;
}

/* Buttons */
.qf-cta-row {
  display: flex;
  gap: 12px;
  margin-bottom: 56px;
  flex-wrap: wrap;
  opacity: 0;
  animation: qf-rise 0.7s ease 0.45s forwards;
}
.qf-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 14px 22px;
  font-family: var(--qf-font-body);
  font-weight: 600;
  font-size: 15px;
  letter-spacing: -0.005em;
  border-radius: 12px;
  border: 1px solid transparent;
  cursor: pointer;
  text-decoration: none;
  transition: transform 0.18s ease, background 0.25s ease, color 0.25s ease;
}
.qf-btn:hover { transform: translateY(-2px); }
.qf-btn--primary { background: var(--qf-ink); color: var(--qf-bone); }
.qf-btn--primary:hover { background: var(--qf-orange); }
.qf-btn--primary i { transition: transform 0.3s ease; }
.qf-btn--primary:hover i { transform: translate(2px, -2px); }
.qf-btn--ghost { background: transparent; color: var(--qf-ink); border-color: var(--qf-rule-strong); }
.qf-btn--ghost:hover { background: var(--qf-ink); color: var(--qf-bone); border-color: var(--qf-ink); }

/* Stats */
.qf-stats {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
  padding-top: 28px;
  border-top: 1px solid var(--qf-rule);
  max-width: 540px;
  opacity: 0;
  animation: qf-rise 0.7s ease 0.55s forwards;
}
.qf-stat__num {
  font-family: var(--qf-font-display);
  font-size: 38px;
  font-weight: 700;
  letter-spacing: -0.03em;
  color: var(--qf-ink);
  line-height: 1;
}
.qf-stat__num span {
  font-size: 16px;
  color: var(--qf-orange);
  font-weight: 500;
  margin-left: 2px;
}
.qf-stat__lbl {
  margin-top: 8px;
  font-size: 12.5px;
  color: var(--qf-fog);
  letter-spacing: 0.01em;
}

/* RIGHT — Image frame */
.qf-hero__right { position: relative; }
.qf-frame {
  position: relative;
  background: var(--qf-ink);
  border-radius: 18px;
  padding: 14px;
  box-shadow: 0 40px 80px -30px rgba(15,16,17,0.35);
  overflow: hidden;
  opacity: 0;
  animation: qf-rise 0.8s ease 0.25s forwards;
}
.qf-frame__tag {
  position: absolute;
  top: 24px;
  left: 24px;
  z-index: 3;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 6px 10px;
  background: rgba(15,16,17,0.7);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(255,255,255,0.1);
  color: var(--qf-bone);
  border-radius: 999px;
  font-family: var(--qf-font-mono);
  font-size: 10px;
  letter-spacing: 0.06em;
}
.qf-frame__dot {
  width: 6px;
  height: 6px;
  background: var(--qf-orange);
  border-radius: 50%;
}
.qf-frame__media {
  position: relative;
  width: 100%;
  aspect-ratio: 4 / 5;
  border-radius: 12px;
  overflow: hidden;
  background: var(--qf-steel);
}
.qf-frame__slide {
  position: absolute;
  inset: 0;
  background-size: cover;
  background-position: 50% 50%;
  opacity: 0;
  transform: scale(1.06);
  transition: opacity 0.8s ease, transform 1.4s ease;
}
.qf-frame__slide--active {
  opacity: 1;
  transform: scale(1);
}
.qf-frame__media::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, transparent 50%, rgba(0,0,0,0.45) 100%);
  pointer-events: none;
}
.qf-frame__meta {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 14px 8px 4px;
  color: var(--qf-bone);
}
.qf-frame__lbl { font-size: 9px; color: var(--qf-fog); }
.qf-frame__val { font-family: var(--qf-font-mono); font-size: 18px; font-weight: 600; }
.qf-frame__nav { display: flex; gap: 8px; }
.qf-pill {
  display: inline-grid;
  place-items: center;
  width: 42px;
  height: 42px;
  border-radius: 999px;
  background: rgba(255,255,255,0.08);
  border: 1px solid rgba(255,255,255,0.14);
  color: var(--qf-bone);
  cursor: pointer;
  font-size: 16px;
  transition: background 0.25s ease, transform 0.18s ease;
}
.qf-pill:hover { background: rgba(255,255,255,0.16); transform: translateY(-1px); }
.qf-pill--filled { background: var(--qf-orange); border-color: var(--qf-orange); }
.qf-pill--filled:hover { background: var(--qf-orange-deep); border-color: var(--qf-orange-deep); }

/* Spec card overlap */
.qf-spec {
  position: absolute;
  bottom: -30px;
  left: -40px;
  background: var(--qf-bone);
  border: 1px solid var(--qf-rule);
  border-radius: 14px;
  padding: 18px 20px;
  width: 250px;
  box-shadow: 0 24px 60px -20px rgba(15,16,17,0.18);
  z-index: 3;
  opacity: 0;
  animation: qf-rise 0.8s ease 0.6s forwards;
}
.qf-spec__lbl { color: var(--qf-orange); font-size: 10px; }
.qf-spec__title {
  font-family: var(--qf-font-display);
  font-weight: 700;
  font-size: 17px;
  letter-spacing: -0.02em;
  margin: 6px 0 12px;
}
.qf-spec__row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 6px 0;
  font-size: 13px;
  color: var(--qf-steel);
  border-top: 1px dashed var(--qf-rule);
}
.qf-spec__row .qf-mono { font-size: 10.5px; color: var(--qf-ink); }

/* ============== SECTIONS ============== */
.qf-section {
  max-width: 1440px;
  margin: 0 auto;
  padding: 64px 32px;
}
.qf-section--ink {
  background: var(--qf-ink);
  color: var(--qf-bone);
  max-width: 100%;
  padding: 80px 32px;
}

/* ============== FEEDBACK FAB ============== */
#feedbackBtn {
  position: fixed;
  bottom: 28px;
  right: 28px;
  width: 56px;
  height: 56px;
  border-radius: 999px;
  background: var(--qf-orange);
  color: white;
  border: none;
  cursor: pointer;
  display: grid;
  place-items: center;
  font-size: 22px;
  box-shadow: 0 16px 40px -8px rgba(255,91,31,0.55), 0 2px 4px rgba(0,0,0,0.1);
  z-index: 1000;
  transition: transform 0.25s cubic-bezier(.2,.9,.3,1.05), background 0.25s ease;
}
#feedbackBtn::before {
  content: '';
  position: absolute;
  inset: -6px;
  border-radius: inherit;
  border: 1px solid rgba(255,91,31,0.5);
  animation: qf-ring 2s ease-out infinite;
}
@keyframes qf-ring {
  0% { transform: scale(0.9); opacity: 1; }
  100% { transform: scale(1.4); opacity: 0; }
}
#feedbackBtn:hover { transform: scale(1.08) rotate(-6deg); background: var(--qf-orange-deep); }

/* Feedback modal */
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
.qf-modal__head .qf-mono { font-size: 11px; color: var(--qf-fog); }
.qf-modal__head h3 {
  font-family: var(--qf-font-display);
  font-size: 24px;
  font-weight: 700;
  letter-spacing: -0.02em;
  margin: 4px 0 0;
}
.qf-modal__body { padding: 22px 26px; }
.qf-modal__foot {
  padding: 18px 26px;
  border-top: 1px solid var(--qf-rule);
  display: flex;
  justify-content: flex-end;
  gap: 10px;
}
.qf-textarea {
  width: 100%;
  background: var(--qf-bone-deep, #EAE6DB);
  border: 1px solid var(--qf-rule);
  color: var(--qf-ink);
  font-family: var(--qf-font-body);
  font-size: 15px;
  padding: 14px;
  border-radius: 10px;
  outline: none;
  resize: vertical;
  transition: border-color 0.2s ease;
}
.qf-textarea:focus { border-color: var(--qf-orange); }

/* ============== RESPONSIVE ============== */
@media (max-width: 1100px) {
  .qf-hero__split { grid-template-columns: 1fr; gap: 56px; }
  .qf-hero__right { max-width: 540px; }
  .qf-spec { left: auto; right: -20px; bottom: -20px; }
}

@media (max-width: 720px) {
  .qf-home { padding-top: 70px; }
  .qf-hero { padding: 24px 0 48px; }
  .qf-hero__inner { padding: 0 20px; }
  .qf-ticker { padding: 6px 12px; gap: 10px; margin-bottom: 24px; }
  .qf-ticker .qf-mono { font-size: 9.5px; }
  .qf-eyebrow { margin-bottom: 16px; }
  .qf-display { margin-bottom: 20px; }
  .qf-lead { margin-bottom: 28px; }
  .qf-cta-row { margin-bottom: 40px; }
  .qf-btn { padding: 12px 18px; font-size: 14px; }
  .qf-stats { grid-template-columns: repeat(3, 1fr); gap: 12px; padding-top: 22px; }
  .qf-stat__num { font-size: 26px; }
  .qf-stat__num span { font-size: 13px; }
  .qf-stat__lbl { font-size: 11px; }
  .qf-frame { padding: 10px; }
  .qf-frame__media { aspect-ratio: 4 / 4.5; }
  .qf-spec { width: 200px; padding: 14px 16px; right: -8px; bottom: -16px; }
  .qf-spec__title { font-size: 15px; }
  .qf-section { padding: 48px 20px; }
  .qf-section--ink { padding: 56px 20px; }
  #feedbackBtn { width: 50px; height: 50px; bottom: 18px; right: 18px; font-size: 19px; }
}

@media (max-width: 420px) {
  .qf-stats { grid-template-columns: 1fr 1fr; }
  .qf-stats > :last-child { grid-column: span 2; }
}
</style>
