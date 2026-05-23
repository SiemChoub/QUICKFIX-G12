{{-- Shared styles for admin form pages (create / edit). --}}
<style>
    .qf-form-page { max-width: 920px; margin: 0 auto; padding: 1.75rem 1rem 3rem; }

    .qf-form-head { display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 1.25rem; }
    .qf-form-head__title {
        font-size: 1.4rem; font-weight: 800; color: #1f2937; letter-spacing: -.01em;
        margin: 0; display: flex; align-items: center; gap: .5rem;
    }
    .qf-form-head__title i { color: #f59e0b; }
    .qf-back-btn {
        display: inline-flex; align-items: center; gap: .4rem; text-decoration: none;
        background: #fff; color: #374151; border: 1px solid #e5e7eb;
        font-weight: 600; font-size: .88rem; padding: .5rem .9rem; border-radius: 10px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .06); transition: background .15s ease, color .15s ease, border-color .15s ease;
    }
    .qf-back-btn:hover { background: #fff7e6; color: #b45309; border-color: #fcd34d; }
    .qf-back-btn i { font-size: 1.1rem; }

    .qf-card { background: #fff; border: 1px solid #eef0f3; border-radius: 18px; padding: 1.8rem; box-shadow: 0 10px 30px -12px rgba(0, 0, 0, .12); }
    .qf-fields { display: flex; flex-direction: column; gap: 1.1rem; }
    .qf-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1.1rem; }
    @media (max-width: 640px) { .qf-grid { grid-template-columns: 1fr; } }

    .qf-field { display: flex; flex-direction: column; gap: .4rem; }
    .qf-label { font-size: .8rem; font-weight: 600; color: #374151; }
    .qf-input {
        width: 100%; font-size: .92rem; color: #1f2937; background: #fff;
        border: 1px solid #d1d5db; border-radius: 10px; padding: .6rem .8rem;
        transition: border-color .15s ease, box-shadow .15s ease; outline: none;
    }
    .qf-input::placeholder { color: #9ca3af; }
    .qf-input:focus { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245, 158, 11, .15); }
    textarea.qf-input { resize: vertical; min-height: 84px; }
    select.qf-input {
        appearance: none; -webkit-appearance: none; padding-right: 2.2rem;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right .7rem center; background-size: 1.1rem;
    }
    .qf-field__error { font-size: .74rem; color: #dc2626; }

    .qf-form-actions { display: flex; justify-content: flex-end; gap: .6rem; margin-top: 1.6rem; }
    .qf-submit-btn {
        display: inline-flex; align-items: center; gap: .45rem; border: 0; cursor: pointer;
        background: linear-gradient(135deg, #f59e0b, #f97316); color: #1b1207;
        font-weight: 700; font-size: .92rem; padding: .7rem 1.4rem; border-radius: 10px;
        box-shadow: 0 8px 20px -6px rgba(245, 158, 11, .5);
        transition: transform .15s ease, box-shadow .2s ease;
    }
    .qf-submit-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 26px -8px rgba(245, 158, 11, .6); }
    .qf-submit-btn i { font-size: 1.2rem; }
</style>
