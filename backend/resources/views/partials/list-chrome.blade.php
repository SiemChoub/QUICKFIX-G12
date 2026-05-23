{{-- Shared chrome for modern admin list pages: header/toolbar, search pill,
     create button, ghost action buttons, empty state, pagination footer and
     the details-modal base. Include once per list page:  @include('partials.list-chrome')
     Then add your entity-specific card styles on top. --}}
<style>
    .qlist-page { padding: 1.75rem 1.5rem 2.5rem; }

    .qlist-head { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; }
    .qlist-head__title { display: flex; align-items: center; gap: .9rem; }
    .qlist-head__icon {
        width: 50px; height: 50px; border-radius: 14px; flex-shrink: 0;
        display: grid; place-items: center; font-size: 1.7rem; color: #fff;
        background: linear-gradient(135deg, #f59e0b, #f97316);
        box-shadow: 0 6px 16px rgba(245, 158, 11, .35);
    }
    .qlist-head__title h1 { font-size: 1.4rem; font-weight: 800; color: #111827; margin: 0; line-height: 1.2; }
    .qlist-head__title p  { font-size: .82rem; color: #9ca3af; margin: 0; }
    .qlist-head__actions { display: flex; align-items: center; gap: .6rem; flex-wrap: wrap; }

    .qlist-search {
        display: flex; align-items: center; gap: .5rem; background: #fff;
        border: 1px solid #e5e7eb; border-radius: 12px; padding: .55rem .85rem; min-width: 240px;
        transition: border-color .15s ease, box-shadow .15s ease;
    }
    .qlist-search:focus-within { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,.15); }
    .qlist-search i { font-size: 1.15rem; color: #9ca3af; }
    .qlist-search input { border: 0; outline: 0; background: transparent; width: 100%; font-size: .9rem; color: #111827; }
    .qlist-search input::placeholder { color: #9ca3af; }

    .qlist-create {
        display: inline-flex; align-items: center; gap: .4rem;
        background: linear-gradient(135deg, #f59e0b, #f97316); color: #fff; font-weight: 600; font-size: .88rem;
        padding: .65rem 1.2rem; border-radius: 12px; text-decoration: none;
        box-shadow: 0 6px 16px rgba(245,158,11,.32);
        transition: transform .15s ease, box-shadow .15s ease, filter .15s ease; white-space: nowrap;
    }
    .qlist-create:hover { color: #fff; transform: translateY(-1px); filter: brightness(1.05); box-shadow: 0 8px 20px rgba(245,158,11,.4); }
    .qlist-create i { font-size: 1.2rem; }

    .qlist-act {
        display: inline-flex; align-items: center; justify-content: center; gap: .35rem;
        font-size: .8rem; font-weight: 600; padding: .5rem .85rem; border-radius: 10px;
        border: 1px solid transparent; cursor: pointer; text-decoration: none;
        transition: background .15s ease, color .15s ease;
    }
    .qlist-act i { font-size: 1rem; }
    .qlist-act--info { color: #0ea5e9; background: rgba(14,165,233,.1); }
    .qlist-act--info:hover { color: #fff; background: #0ea5e9; }
    .qlist-act--edit { color: #b45309; background: rgba(245,158,11,.12); }
    .qlist-act--edit:hover { color: #fff; background: #f59e0b; }
    .qlist-act--del  { color: #e11d48; background: rgba(244,63,94,.09); }
    .qlist-act--del:hover  { color: #fff; background: #f43f5e; }

    .qlist-empty { text-align: center; padding: 3rem 1rem; color: #9ca3af; }
    .qlist-empty i { font-size: 2.4rem; }
    .qlist-empty p { margin: .5rem 0 0; font-size: .9rem; }

    .qlist-footer { margin-top: 1.6rem; display: flex; justify-content: flex-end; }
    .qlist-footer .pagination { margin: 0; }

    .qlist-modal { border: 0; border-radius: 18px; overflow: hidden; }
    .qlist-modal .modal-header { background: linear-gradient(135deg, #f59e0b, #f97316); color: #fff; border: 0; }
    .qlist-modal .modal-title { font-weight: 700; display: flex; align-items: center; gap: .5rem; }

    @media (max-width: 560px) {
        .qlist-head__actions { width: 100%; }
        .qlist-search { flex: 1; min-width: 0; }
        .qlist-act span { display: none; }
    }
</style>
