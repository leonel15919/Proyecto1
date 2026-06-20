document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('[data-filter-group="estado"]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var value  = this.getAttribute('data-filter-value') || 'all';
            var group  = this.closest('[data-filter-group]');
            if (!group) return;
            var card   = group.closest('.card');
            if (!card) return;

            var rows     = card.querySelectorAll('tbody > tr[data-estado]');
            var emptyRow = card.querySelector('tbody > tr[data-filter-empty]');

            group.querySelectorAll('[data-filter-group="estado"]').forEach(function (b) {
                b.classList.remove('active');
            });
            this.classList.add('active');

            var visible = 0;
            rows.forEach(function (row) {
                var match = value === 'all' || row.getAttribute('data-estado') === value;
                row.style.display = match ? '' : 'none';
                if (match) visible++;
            });

            if (emptyRow) {
                emptyRow.style.display = visible === 0 ? '' : 'none';
            }
        });
    });

    var ct = document.querySelector('.content-area > .container-fluid');
    if (ct) {
        ct.classList.add('page-enter');
        ct.addEventListener('animationend', function () {
            ct.classList.remove('page-enter');
        }, { once: true });
    }
});
