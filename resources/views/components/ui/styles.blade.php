<style>
    .border-left-primary  { border-left: 0.25rem solid #4e73df !important; }
    .border-left-success  { border-left: 0.25rem solid #1cc88a !important; }
    .border-left-info     { border-left: 0.25rem solid #36b9cc !important; }
    .border-left-warning  { border-left: 0.25rem solid #f6c23e !important; }
    .border-left-danger   { border-left: 0.25rem solid #e74a3b !important; }
    .border-left-secondary{ border-left: 0.25rem solid #858796 !important; }
    [x-cloak] { display: none !important; }
    .order-summary-sticky {
        position: sticky;
        top: 5.5rem;
        z-index: 5;
    }

    /* ── Responsive tables (EN + UR) ── */

    .ui-table-wrap {
        width: 100%;
        max-width: 100%;
    }

    /* Default: fill the card, no forced horizontal scroll */
    .ui-table-wrap:not(.ui-table-wrap--wide) {
        overflow-x: visible;
    }

    .ui-table-wrap > .ui-table,
    .ui-table-wrap > table {
        width: 100% !important;
        max-width: 100%;
        table-layout: fixed;
    }

    .ui-table-wrap > .ui-table th,
    .ui-table-wrap > .ui-table td,
    .ui-table-wrap > table th,
    .ui-table-wrap > table td {
        word-wrap: break-word;
        overflow-wrap: break-word;
        vertical-align: middle;
    }

    .ui-table-wrap .ui-table-empty {
        text-align: center !important;
    }

    /* ── Empty tables: always fill the card and center the message ──
       When a table holds only the empty-state row, never let it shrink to
       header width or scroll horizontally (applies to wide tables too). */
    .ui-table-wrap:has(.ui-table-empty),
    .ui-table-wrap--wide:has(.ui-table-empty),
    .table-responsive:has(.ui-table-empty) {
        overflow-x: visible;
    }

    .ui-table-wrap:has(.ui-table-empty) > table,
    .table-responsive:has(.ui-table-empty) > table {
        width: 100% !important;
        min-width: 0 !important;
        table-layout: auto;
    }

    .ui-table-empty {
        text-align: center !important;
        white-space: normal !important;
    }

    /* Wide tables: full width on desktop, scroll on small screens */
    .ui-table-wrap--wide {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .ui-table-wrap--wide > .ui-table,
    .ui-table-wrap--wide > table {
        width: 100% !important;
        table-layout: fixed;
    }

    /* Legacy raw .table-responsive blocks used in older views */
    .table-responsive:not(.ui-table-wrap--wide) {
        width: 100%;
        max-width: 100%;
        overflow-x: visible;
    }

    .table-responsive:not(.ui-table-wrap--wide) > table {
        width: 100% !important;
        table-layout: fixed;
    }

    .table-responsive:not(.ui-table-wrap--wide) > table th,
    .table-responsive:not(.ui-table-wrap--wide) > table td {
        word-wrap: break-word;
        overflow-wrap: break-word;
        vertical-align: middle;
    }

    @media (max-width: 991.98px) {
        .ui-table-wrap > .ui-table,
        .ui-table-wrap > table,
        .card .table-responsive:not(.ui-table-wrap--wide) > table {
            font-size: 0.875rem;
        }

        .ui-table-wrap > .ui-table th,
        .ui-table-wrap > .ui-table td,
        .ui-table-wrap > table th,
        .ui-table-wrap > table td {
            padding: 0.55rem 0.5rem;
        }
    }

    @media (max-width: 767.98px) {
        .ui-table-wrap--wide > .ui-table,
        .ui-table-wrap--wide > table {
            table-layout: auto;
            width: max-content !important;
            min-width: 100%;
        }

        .ui-table-wrap--wide > .ui-table th,
        .ui-table-wrap--wide > table th,
        .ui-table-wrap--wide > .ui-table td,
        .ui-table-wrap--wide > table td {
            white-space: nowrap;
        }
    }
</style>
