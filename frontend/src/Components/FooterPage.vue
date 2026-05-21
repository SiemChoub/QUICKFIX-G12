<script setup lang="ts">
import { ref } from 'vue'
import { Icon } from '@iconify/vue'

const email = ref('')
const subscribed = ref(false)

function submitNewsletter() {
  if (!email.value) return
  subscribed.value = true
  setTimeout(() => {
    subscribed.value = false
    email.value = ''
  }, 2500)
}

const year = new Date().getFullYear()

const serviceLinks = [
  { label: 'Computer repair', href: '#' },
  { label: 'Vehicle repair', href: '#' },
  { label: 'Phone repair', href: '#' },
  { label: 'Television', href: '#' },
  { label: 'Home equipment', href: '#' },
]
const companyLinks = [
  { label: 'About QuickFix', href: '#about' },
  { label: 'Become a fixer', href: '#' },
  { label: 'Service areas', href: '#' },
  { label: 'Pricing', href: '#' },
  { label: 'Press kit', href: '#' },
]
const socials = [
  { icon: 'tabler:brand-facebook', label: 'Facebook', href: '#' },
  { icon: 'tabler:brand-instagram', label: 'Instagram', href: '#' },
  { icon: 'tabler:brand-linkedin', label: 'LinkedIn', href: '#' },
  { icon: 'tabler:brand-x', label: 'X', href: '#' },
]
</script>

<template>
  <footer class="qf-footer">
    <!-- CTA Band -->
    <section class="qf-cta">
      <div class="qf-cta__inner">
        <div class="qf-cta__left">
          <span class="qf-mono qf-cta__tag">/ READY WHEN YOU ARE</span>
          <h2 class="qf-cta__title">
            Need a fix today?
            <span class="qf-cta__title-em">We're 12 minutes away.</span>
          </h2>
        </div>
        <div class="qf-cta__right">
          <a href="#book" class="qf-cta__btn qf-cta__btn--solid">
            Book a fixer
            <Icon icon="tabler:arrow-up-right" />
          </a>
          <a href="tel:+855000000000" class="qf-cta__btn qf-cta__btn--ghost">
            <Icon icon="tabler:phone" />
            Call dispatch
          </a>
        </div>
      </div>
    </section>

    <!-- Main footer -->
    <section class="qf-foot">
      <div class="qf-foot__inner">
        <!-- Top grid -->
        <div class="qf-foot__grid">
          <!-- Brand -->
          <div class="qf-foot__brand">
            <div class="qf-foot__logo">
              <span class="qf-foot__logo-mark">Q</span>
              <div class="qf-foot__logo-text">
                <strong>QUICKFIX</strong>
                <span class="qf-mono">/ svc</span>
              </div>
            </div>
            <p class="qf-foot__pitch">
              Certified technicians, dispatched fast. A 30-day warranty on every job,
              transparent pricing, no surprises.
            </p>
            <div class="qf-foot__socials">
              <a v-for="s in socials" :key="s.label" :href="s.href" :aria-label="s.label" class="qf-foot__social">
                <Icon :icon="s.icon" />
              </a>
            </div>
          </div>

          <!-- Services -->
          <nav class="qf-foot__col">
            <span class="qf-mono qf-foot__col-tag">/ SERVICES</span>
            <ul>
              <li v-for="l in serviceLinks" :key="l.label">
                <a :href="l.href">{{ l.label }}</a>
              </li>
            </ul>
          </nav>

          <!-- Company -->
          <nav class="qf-foot__col">
            <span class="qf-mono qf-foot__col-tag">/ COMPANY</span>
            <ul>
              <li v-for="l in companyLinks" :key="l.label">
                <a :href="l.href">{{ l.label }}</a>
              </li>
            </ul>
          </nav>

          <!-- Newsletter -->
          <div class="qf-foot__news">
            <span class="qf-mono qf-foot__col-tag">/ STAY IN THE LOOP</span>
            <p class="qf-foot__news-pitch">
              Service alerts, new coverage zones, and the occasional shop story.
            </p>
            <form class="qf-foot__news-form" @submit.prevent="submitNewsletter">
              <input
                v-model="email"
                type="email"
                required
                placeholder="you@email.com"
                aria-label="Email address"
              />
              <button type="submit" :disabled="subscribed">
                <Icon v-if="!subscribed" icon="tabler:arrow-right" />
                <Icon v-else icon="tabler:check" />
              </button>
            </form>
            <span v-if="subscribed" class="qf-foot__news-ok qf-mono">
              ✓ Subscribed — see you soon.
            </span>
          </div>
        </div>

        <!-- Bottom strip -->
        <div class="qf-foot__bottom">
          <div class="qf-foot__legal">
            <span class="qf-mono">© {{ year }} QUICKFIX</span>
            <span class="qf-foot__dot">·</span>
            <a href="#">Privacy</a>
            <span class="qf-foot__dot">·</span>
            <a href="#">Terms</a>
            <span class="qf-foot__dot">·</span>
            <a href="#">Status</a>
          </div>
          <span class="qf-mono qf-foot__location">
            <span class="qf-foot__dot qf-foot__dot--live"></span>
            42 FIXERS ON DUTY · PHNOM PENH
          </span>
        </div>
      </div>
    </section>
  </footer>
</template>

<style scoped>
.qf-footer {
  --qf-bone: #F2EFE6;
  --qf-ink: #0F1011;
  --qf-steel: #1C1C1F;
  --qf-orange: #FF5B1F;
  --qf-fog: #9C998F;
  --qf-rule: rgba(15, 16, 17, 0.12);
  --qf-rule-dark: rgba(242, 239, 230, 0.12);
  --qf-font-display: 'Bricolage Grotesque', system-ui, sans-serif;
  --qf-font-body: 'DM Sans', system-ui, sans-serif;
  --qf-font-mono: 'IBM Plex Mono', 'Menlo', monospace;

  font-family: var(--qf-font-body);
  color: var(--qf-bone);
  background: var(--qf-ink);
}

.qf-mono {
  font-family: var(--qf-font-mono);
  font-size: 11px;
  letter-spacing: 0.08em;
  text-transform: uppercase;
}

/* ============== CTA BAND ============== */
.qf-cta {
  background: var(--qf-orange);
  color: var(--qf-ink);
  position: relative;
}
.qf-cta::after {
  content: '';
  position: absolute;
  inset: 0;
  background-image:
    linear-gradient(to right, rgba(15, 16, 17, 0.08) 1px, transparent 1px),
    linear-gradient(to bottom, rgba(15, 16, 17, 0.08) 1px, transparent 1px);
  background-size: 48px 48px;
  pointer-events: none;
  mask-image: radial-gradient(ellipse 80% 80% at 20% 50%, black 20%, transparent 70%);
  -webkit-mask-image: radial-gradient(ellipse 80% 80% at 20% 50%, black 20%, transparent 70%);
}
.qf-cta__inner {
  position: relative;
  z-index: 2;
  max-width: 1440px;
  margin: 0 auto;
  padding: 56px 32px;
  display: grid;
  grid-template-columns: minmax(0, 1.4fr) minmax(0, 1fr);
  align-items: center;
  gap: 40px;
}
.qf-cta__tag {
  display: inline-block;
  margin-bottom: 14px;
  color: var(--qf-ink);
  opacity: 0.72;
}
.qf-cta__title {
  font-family: var(--qf-font-display);
  font-size: clamp(34px, 4.2vw, 56px);
  line-height: 1.02;
  letter-spacing: -0.03em;
  font-weight: 600;
  margin: 0;
  color: var(--qf-ink);
}
.qf-cta__title-em {
  display: block;
  font-style: italic;
  font-weight: 500;
  opacity: 0.7;
}
.qf-cta__right {
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  flex-wrap: wrap;
}
.qf-cta__btn {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 16px 22px;
  border-radius: 999px;
  font-weight: 500;
  font-size: 15px;
  text-decoration: none;
  border: 1px solid transparent;
  transition: transform 0.2s ease, background 0.2s ease;
}
.qf-cta__btn--solid {
  background: var(--qf-ink);
  color: var(--qf-bone);
}
.qf-cta__btn--solid:hover { transform: translateY(-1px); }
.qf-cta__btn--ghost {
  color: var(--qf-ink);
  border-color: rgba(15, 16, 17, 0.4);
}
.qf-cta__btn--ghost:hover {
  background: rgba(15, 16, 17, 0.08);
}

/* ============== MAIN FOOT ============== */
.qf-foot {
  position: relative;
  background: var(--qf-ink);
  overflow: hidden;
}
.qf-foot::before {
  content: '';
  position: absolute;
  top: -160px;
  right: -160px;
  width: 520px;
  height: 520px;
  background: radial-gradient(circle, rgba(255, 91, 31, 0.18), transparent 70%);
  filter: blur(60px);
  pointer-events: none;
}
.qf-foot__inner {
  position: relative;
  z-index: 2;
  max-width: 1440px;
  margin: 0 auto;
  padding: 80px 32px 32px;
}

.qf-foot__grid {
  display: grid;
  grid-template-columns: 1.4fr 0.8fr 0.8fr 1.1fr;
  gap: 64px;
  padding-bottom: 64px;
  border-bottom: 1px solid var(--qf-rule-dark);
}

/* Brand */
.qf-foot__logo {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 20px;
}
.qf-foot__logo-mark {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  background: var(--qf-orange);
  color: var(--qf-ink);
  font-family: var(--qf-font-display);
  font-weight: 700;
  display: grid;
  place-items: center;
  font-size: 22px;
  letter-spacing: -0.02em;
}
.qf-foot__logo-text strong {
  display: block;
  font-family: var(--qf-font-display);
  font-size: 18px;
  letter-spacing: 0.04em;
  font-weight: 700;
  color: var(--qf-bone);
}
.qf-foot__logo-text span { color: var(--qf-fog); }

.qf-foot__pitch {
  font-size: 14.5px;
  line-height: 1.6;
  color: rgba(242, 239, 230, 0.7);
  max-width: 360px;
  margin: 0 0 24px;
}

.qf-foot__socials {
  display: flex;
  gap: 8px;
}
.qf-foot__social {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: 1px solid var(--qf-rule-dark);
  display: grid;
  place-items: center;
  color: var(--qf-bone);
  font-size: 17px;
  text-decoration: none;
  transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
}
.qf-foot__social:hover {
  background: var(--qf-orange);
  color: var(--qf-ink);
  border-color: var(--qf-orange);
}

/* Columns */
.qf-foot__col-tag {
  display: block;
  color: var(--qf-fog);
  margin-bottom: 22px;
}
.qf-foot__col ul {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: column;
  gap: 14px;
}
.qf-foot__col a {
  color: rgba(242, 239, 230, 0.82);
  text-decoration: none;
  font-size: 14.5px;
  transition: color 0.15s ease;
  position: relative;
}
.qf-foot__col a:hover { color: var(--qf-orange); }

/* Newsletter */
.qf-foot__news-pitch {
  font-size: 14px;
  line-height: 1.55;
  color: rgba(242, 239, 230, 0.7);
  margin: 0 0 16px;
}
.qf-foot__news-form {
  display: flex;
  align-items: center;
  background: rgba(242, 239, 230, 0.06);
  border: 1px solid var(--qf-rule-dark);
  border-radius: 999px;
  padding: 4px 4px 4px 18px;
  transition: border-color 0.2s ease, background 0.2s ease;
}
.qf-foot__news-form:focus-within {
  border-color: var(--qf-orange);
  background: rgba(255, 91, 31, 0.06);
}
.qf-foot__news-form input {
  flex: 1;
  background: transparent;
  border: 0;
  outline: 0;
  color: var(--qf-bone);
  font-family: var(--qf-font-body);
  font-size: 14px;
  padding: 10px 0;
}
.qf-foot__news-form input::placeholder { color: var(--qf-fog); }
.qf-foot__news-form button {
  width: 38px;
  height: 38px;
  border-radius: 50%;
  border: 0;
  background: var(--qf-orange);
  color: var(--qf-ink);
  display: grid;
  place-items: center;
  cursor: pointer;
  font-size: 17px;
  transition: background 0.2s ease, transform 0.2s ease;
}
.qf-foot__news-form button:hover:not(:disabled) {
  transform: rotate(-12deg);
}
.qf-foot__news-form button:disabled {
  background: var(--qf-bone);
  cursor: default;
}
.qf-foot__news-ok {
  display: inline-block;
  margin-top: 12px;
  color: var(--qf-orange);
}

/* Bottom strip */
.qf-foot__bottom {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-top: 28px;
  gap: 20px;
  flex-wrap: wrap;
}
.qf-foot__legal {
  display: flex;
  align-items: center;
  gap: 12px;
  color: var(--qf-fog);
  font-size: 13px;
}
.qf-foot__legal a {
  color: rgba(242, 239, 230, 0.7);
  text-decoration: none;
  font-size: 13px;
  transition: color 0.15s ease;
}
.qf-foot__legal a:hover { color: var(--qf-orange); }
.qf-foot__dot { color: var(--qf-fog); opacity: 0.5; }
.qf-foot__dot--live {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: var(--qf-orange);
  display: inline-block;
  margin-right: 8px;
  box-shadow: 0 0 0 4px rgba(255, 91, 31, 0.22);
  animation: qf-pulse 1.8s ease-in-out infinite;
}
.qf-foot__location {
  color: var(--qf-fog);
  display: inline-flex;
  align-items: center;
}

@keyframes qf-pulse {
  0%, 100% { box-shadow: 0 0 0 4px rgba(255, 91, 31, 0.22); }
  50% { box-shadow: 0 0 0 8px rgba(255, 91, 31, 0.08); }
}

/* ============== RESPONSIVE ============== */
@media (max-width: 1100px) {
  .qf-foot__grid {
    grid-template-columns: 1fr 1fr;
    gap: 48px;
  }
  .qf-foot__brand { grid-column: 1 / -1; }
  .qf-cta__inner {
    grid-template-columns: 1fr;
    gap: 24px;
  }
  .qf-cta__right { justify-content: flex-start; }
}

@media (max-width: 720px) {
  .qf-cta__inner { padding: 40px 20px; }
  .qf-foot__inner { padding: 56px 20px 24px; }
  .qf-foot__grid {
    grid-template-columns: 1fr;
    gap: 40px;
    padding-bottom: 40px;
  }
  .qf-foot__bottom {
    flex-direction: column;
    align-items: flex-start;
    gap: 16px;
  }
  .qf-foot__legal { flex-wrap: wrap; }
}
</style>
