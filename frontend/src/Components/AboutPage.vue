<script setup lang="ts">
import { Icon } from '@iconify/vue'

const pillars = [
  {
    icon: 'tabler:certificate',
    label: '/01',
    title: 'Certified fixers',
    body: 'Every technician on the platform is vetted, background-checked, and re-certified annually.',
  },
  {
    icon: 'tabler:bolt',
    label: '/02',
    title: '12-min dispatch',
    body: 'Median time from booking to a fixer rolling toward you. Tracked live, published monthly.',
  },
  {
    icon: 'tabler:shield-check',
    label: '/03',
    title: 'Work guaranteed',
    body: 'Every job covered by a 30-day workmanship warranty. We come back free if it fails.',
  },
]

const stats = [
  { value: '7', unit: 'yrs', label: 'Operating' },
  { value: '42', unit: 'live', label: 'Fixers on duty' },
  { value: '18K', unit: '+', label: 'Jobs completed' },
  { value: '4.9', unit: '★', label: 'Customer rating' },
]
</script>

<template>
  <section class="qf-about" id="about">
    <div class="qf-about__grid" aria-hidden="true"></div>

    <div class="qf-about__inner">
      <!-- Header row -->
      <header class="qf-about__head">
        <span class="qf-mono">/04 — ABOUT QUICKFIX</span>
        <div class="qf-about__rule"></div>
        <span class="qf-mono qf-about__location">PHNOM PENH · 24/7</span>
      </header>

      <!-- Main grid -->
      <div class="qf-about__main">
        <!-- LEFT: copy -->
        <div class="qf-about__copy">
          <h2 class="qf-about__title">
            The garage that <em>comes to you.</em>
          </h2>

          <p class="qf-about__lede">
            QuickFix dispatches certified technicians across the city — roadside, residential,
            or shop floor. Twelve-minute average response, transparent pricing, and a 30-day
            workmanship warranty on every repair.
          </p>

          <div class="qf-about__ctas">
            <a href="#story" class="qf-about__btn qf-about__btn--solid">
              Read our story
              <Icon icon="tabler:arrow-up-right" />
            </a>
            <a href="#fixers" class="qf-about__btn qf-about__btn--ghost">
              Meet the fixers
            </a>
          </div>

          <!-- Stats -->
          <div class="qf-about__stats">
            <div v-for="s in stats" :key="s.label" class="qf-about__stat">
              <div class="qf-about__stat-num">
                <span>{{ s.value }}</span>
                <sup>{{ s.unit }}</sup>
              </div>
              <span class="qf-about__stat-label">{{ s.label }}</span>
            </div>
          </div>
        </div>

        <!-- RIGHT: image card -->
        <div class="qf-about__visual">
          <div class="qf-about__frame">
            <span class="qf-about__frame-tag qf-mono">/CREW · LIVE</span>
            <img src="../assets/images/team.png" alt="QuickFix technicians at work" />
            <span class="qf-about__frame-tick qf-mono">EST. 2019</span>
          </div>
          <div class="qf-about__chip">
            <Icon icon="tabler:tools" />
            <div>
              <strong>Fast service</strong>
              <span class="qf-mono">/ FOR EVERY VEHICLE</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Pillars row -->
      <div class="qf-about__pillars">
        <article v-for="p in pillars" :key="p.label" class="qf-pillar">
          <header class="qf-pillar__head">
            <Icon :icon="p.icon" class="qf-pillar__icon" />
            <span class="qf-mono">{{ p.label }}</span>
          </header>
          <h3 class="qf-pillar__title">{{ p.title }}</h3>
          <p class="qf-pillar__body">{{ p.body }}</p>
        </article>
      </div>
    </div>
  </section>
</template>

<style scoped>
.qf-about {
  --qf-bone: #F2EFE6;
  --qf-ink: #0F1011;
  --qf-steel: #1C1C1F;
  --qf-orange: #FF5B1F;
  --qf-fog: #9C998F;
  --qf-rule: rgba(15, 16, 17, 0.12);
  --qf-font-display: 'Bricolage Grotesque', system-ui, sans-serif;
  --qf-font-body: 'DM Sans', system-ui, sans-serif;
  --qf-font-mono: 'IBM Plex Mono', 'Menlo', monospace;

  position: relative;
  background: var(--qf-bone);
  color: var(--qf-ink);
  font-family: var(--qf-font-body);
  overflow: hidden;
  padding: 96px 0 120px;
}

.qf-about__grid {
  position: absolute;
  inset: 0;
  background-image:
    linear-gradient(to right, rgba(15, 16, 17, 0.05) 1px, transparent 1px),
    linear-gradient(to bottom, rgba(15, 16, 17, 0.05) 1px, transparent 1px);
  background-size: 64px 64px;
  mask-image: radial-gradient(ellipse 70% 60% at 50% 50%, black 40%, transparent 90%);
  -webkit-mask-image: radial-gradient(ellipse 70% 60% at 50% 50%, black 40%, transparent 90%);
  pointer-events: none;
}

.qf-about__inner {
  position: relative;
  max-width: 1440px;
  margin: 0 auto;
  padding: 0 32px;
  z-index: 2;
}

.qf-mono {
  font-family: var(--qf-font-mono);
  font-size: 11px;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: var(--qf-steel);
}

/* ---------- HEAD ---------- */
.qf-about__head {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-bottom: 56px;
}
.qf-about__rule {
  flex: 1;
  height: 1px;
  background: var(--qf-rule);
}
.qf-about__location { color: var(--qf-fog); }

/* ---------- MAIN GRID ---------- */
.qf-about__main {
  display: grid;
  grid-template-columns: minmax(0, 1.05fr) minmax(0, 1fr);
  gap: 80px;
  align-items: center;
}

/* LEFT */
.qf-about__title {
  font-family: var(--qf-font-display);
  font-size: clamp(40px, 5vw, 72px);
  line-height: 1.02;
  letter-spacing: -0.03em;
  font-weight: 600;
  margin: 0 0 24px;
  color: var(--qf-ink);
}
.qf-about__title em {
  font-style: italic;
  color: var(--qf-orange);
  font-weight: 500;
}

.qf-about__lede {
  font-size: 17px;
  line-height: 1.55;
  color: var(--qf-steel);
  max-width: 520px;
  margin: 0 0 32px;
}

.qf-about__ctas {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
  margin-bottom: 56px;
}
.qf-about__btn {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 14px 22px;
  border-radius: 999px;
  font-weight: 500;
  font-size: 15px;
  text-decoration: none;
  border: 1px solid transparent;
  transition: transform 0.2s ease, background 0.2s ease, color 0.2s ease;
}
.qf-about__btn--solid {
  background: var(--qf-ink);
  color: var(--qf-bone);
}
.qf-about__btn--solid:hover {
  background: var(--qf-orange);
  transform: translateY(-1px);
}
.qf-about__btn--ghost {
  color: var(--qf-ink);
  border-color: var(--qf-rule);
}
.qf-about__btn--ghost:hover {
  border-color: var(--qf-ink);
  background: rgba(15, 16, 17, 0.04);
}

/* Stats */
.qf-about__stats {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 24px;
  padding-top: 28px;
  border-top: 1px solid var(--qf-rule);
}
.qf-about__stat-num {
  font-family: var(--qf-font-display);
  font-size: 36px;
  font-weight: 600;
  letter-spacing: -0.02em;
  line-height: 1;
  display: inline-flex;
  align-items: baseline;
  gap: 2px;
  color: var(--qf-ink);
}
.qf-about__stat-num sup {
  font-family: var(--qf-font-mono);
  font-size: 11px;
  color: var(--qf-orange);
  letter-spacing: 0.05em;
  top: -0.7em;
  position: relative;
}
.qf-about__stat-label {
  display: block;
  font-family: var(--qf-font-mono);
  font-size: 10.5px;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: var(--qf-fog);
  margin-top: 8px;
}

/* RIGHT */
.qf-about__visual {
  position: relative;
}
.qf-about__frame {
  position: relative;
  border-radius: 20px;
  overflow: hidden;
  background: var(--qf-steel);
  border: 1px solid var(--qf-rule);
  box-shadow:
    0 1px 0 rgba(255, 255, 255, 0.6) inset,
    0 30px 60px -30px rgba(15, 16, 17, 0.35);
  aspect-ratio: 4 / 5;
}
.qf-about__frame img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}
.qf-about__frame-tag,
.qf-about__frame-tick {
  position: absolute;
  z-index: 2;
  background: var(--qf-bone);
  color: var(--qf-ink);
  padding: 6px 12px;
  border-radius: 999px;
  font-size: 10.5px;
}
.qf-about__frame-tag { top: 16px; left: 16px; }
.qf-about__frame-tick {
  bottom: 16px;
  right: 16px;
  background: var(--qf-ink);
  color: var(--qf-bone);
}
.qf-about__chip {
  position: absolute;
  left: -18px;
  bottom: 32px;
  background: var(--qf-bone);
  border: 1px solid var(--qf-rule);
  border-radius: 16px;
  padding: 14px 18px;
  display: flex;
  align-items: center;
  gap: 12px;
  box-shadow: 0 12px 28px -12px rgba(15, 16, 17, 0.25);
  z-index: 3;
}
.qf-about__chip > :first-child {
  font-size: 22px;
  color: var(--qf-orange);
}
.qf-about__chip strong {
  font-family: var(--qf-font-display);
  font-weight: 600;
  display: block;
  font-size: 15px;
  letter-spacing: -0.01em;
}
.qf-about__chip span { color: var(--qf-fog); font-size: 10.5px; }

/* ---------- PILLARS ---------- */
.qf-about__pillars {
  margin-top: 96px;
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1px;
  background: var(--qf-rule);
  border: 1px solid var(--qf-rule);
  border-radius: 20px;
  overflow: hidden;
}
.qf-pillar {
  background: var(--qf-bone);
  padding: 32px;
  display: flex;
  flex-direction: column;
  gap: 14px;
  transition: background 0.2s ease;
}
.qf-pillar:hover { background: #ECE9DF; }
.qf-pillar__head {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.qf-pillar__icon {
  font-size: 28px;
  color: var(--qf-ink);
  background: rgba(255, 91, 31, 0.12);
  padding: 10px;
  border-radius: 12px;
  width: 48px;
  height: 48px;
  box-sizing: content-box;
  color: var(--qf-orange);
}
.qf-pillar__title {
  font-family: var(--qf-font-display);
  font-size: 22px;
  font-weight: 600;
  letter-spacing: -0.02em;
  margin: 4px 0 0;
  color: var(--qf-ink);
}
.qf-pillar__body {
  font-size: 14.5px;
  line-height: 1.55;
  color: var(--qf-steel);
  margin: 0;
  opacity: 0.78;
}

/* ---------- RESPONSIVE ---------- */
@media (max-width: 1100px) {
  .qf-about__main { grid-template-columns: 1fr; gap: 64px; }
  .qf-about__visual { max-width: 540px; margin: 0 auto; width: 100%; }
}

@media (max-width: 720px) {
  .qf-about { padding: 64px 0 80px; }
  .qf-about__inner { padding: 0 20px; }
  .qf-about__head { margin-bottom: 32px; }
  .qf-about__stats { grid-template-columns: repeat(2, 1fr); gap: 18px; }
  .qf-about__pillars { grid-template-columns: 1fr; margin-top: 56px; }
  .qf-pillar { padding: 24px; }
  .qf-about__chip { left: 12px; bottom: 12px; }
}
</style>
