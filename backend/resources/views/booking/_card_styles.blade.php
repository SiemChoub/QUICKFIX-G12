{{-- Shared styles for the booking list rows, used by the
     Requests, In Progress and Done pages. --}}
<style>
    /* Type filter buttons (scoped so it doesn't recolor Detail / Delete) */
    #immediately:hover, #dead:hover {
        background-color: #ffca2c;
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }
    .show-all { padding: 8px 14px; border-radius: 10px; transition: all .25s ease; }
    .show-all:hover { color: #b45309; background: #fff7e6; }

    /* List header */
    .qf-list-title { font-size: 1rem; font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: .4rem; margin: 0; }
    .qf-list-title i { color: #f59e0b; }
    .qf-count-pill { background: rgba(245,158,11,.13); color: #b45309; font-weight: 700; font-size: .75rem; padding: .25rem .7rem; border-radius: 999px; }

    /* Booking rows */
    .qf-booking-card {
        display: flex; align-items: center; gap: 1rem;
        background: #fff; border: 1px solid #eef0f3; border-left: 4px solid #e5e7eb;
        border-radius: 12px; padding: .8rem 1.1rem;
        transition: box-shadow .2s ease, transform .15s ease, border-color .2s ease;
    }
    .qf-booking-card:hover { box-shadow: 0 8px 22px rgba(0,0,0,.08); transform: translateY(-1px); }
    #immediate .qf-booking-card { border-left-color: #f59e0b; }
    #deadline  .qf-booking-card { border-left-color: #3b82f6; }

    .qf-bk-customer { display: flex; align-items: center; gap: .75rem; flex: 1 1 auto; min-width: 0; }
    .qf-bk-avatar { width: 46px; height: 46px; border-radius: 50%; object-fit: cover; border: 2px solid #f1f1f1; flex: 0 0 auto; }
    .qf-bk-customer-meta { display: flex; flex-direction: column; min-width: 0; }
    .qf-bk-name { font-weight: 700; font-size: .9rem; color: #1f2937; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .qf-bk-service { font-size: .76rem; color: #6b7280; display: flex; align-items: center; gap: .3rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .qf-bk-service i { color: #f59e0b; }

    .qf-bk-type { flex: 0 0 150px; }
    .qf-tag { display: inline-flex; align-items: center; gap: .35rem; font-size: .72rem; font-weight: 700; padding: .32rem .7rem; border-radius: 999px; }
    .qf-tag-now { background: rgba(245,158,11,.13); color: #b45309; }
    .qf-tag-deadline { background: rgba(59,130,246,.12); color: #1d4ed8; }

    /* Fixer column (In Progress / Done) */
    .qf-bk-fixer { flex: 0 0 175px; display: flex; align-items: center; gap: .5rem; min-width: 0; }
    .qf-bk-fixer .qf-bk-avatar-sm { width: 34px; height: 34px; border-radius: 50%; object-fit: cover; border: 2px solid #f1f1f1; flex: 0 0 auto; }
    .qf-bk-fixer-icon { width: 34px; height: 34px; border-radius: 50%; display: grid; place-items: center; background: rgba(245,158,11,.12); color: #f59e0b; font-size: 1.1rem; flex: 0 0 auto; }
    .qf-bk-fixer-meta { display: flex; flex-direction: column; min-width: 0; line-height: 1.15; }
    .qf-bk-fixer-label { font-size: .65rem; color: #9aa1ab; text-transform: uppercase; letter-spacing: .4px; }
    .qf-bk-fixer-name { font-weight: 600; font-size: .82rem; color: #1f2937; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    .qf-bk-date { flex: 0 0 150px; display: flex; align-items: center; gap: .55rem; color: #374151; }
    .qf-bk-date > i { font-size: 1.4rem; color: #9aa1ab; }
    .qf-bk-date-text { display: flex; flex-direction: column; line-height: 1.2; }
    .qf-bk-date-label { font-size: .65rem; color: #9aa1ab; text-transform: uppercase; letter-spacing: .4px; }
    .qf-bk-date-value { font-weight: 600; font-size: .82rem; }

    /* Status badge (In Progress / Done) */
    .qf-status { display: inline-flex; align-items: center; gap: .35rem; font-size: .72rem; font-weight: 700; padding: .32rem .7rem; border-radius: 999px; }
    .qf-status-progress { background: rgba(245,158,11,.13); color: #b45309; }
    .qf-status-done { background: rgba(16,185,129,.13); color: #047857; }

    .qf-bk-actions { flex: 0 0 auto; display: flex; gap: .5rem; }
    .qf-bk-btn { display: inline-flex; align-items: center; gap: .3rem; border-radius: 8px; font-size: .78rem; font-weight: 600; padding: .35rem .75rem; }

    .qf-bk-empty { text-align: center; padding: 3rem 1rem; color: #9aa1ab; font-size: .9rem; }
    .qf-bk-empty i { font-size: 2.6rem; display: block; margin-bottom: .5rem; color: #d1d5db; }

    @media (max-width: 992px) {
        .qf-booking-card { flex-wrap: wrap; }
        .qf-bk-type, .qf-bk-date, .qf-bk-fixer { flex-basis: auto; }
    }
</style>
