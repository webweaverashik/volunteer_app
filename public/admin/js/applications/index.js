"use strict";

var ApplicationsTable = (function () {
      let table;
      let datatable;

      /* -------------------------------------------
       * Init DataTable
       * ----------------------------------------- */
      const initDatatable = function () {
            table = document.getElementById('kt_all_applications_table');
            if (!table) return;

            datatable = $(table).DataTable({
                  processing: true,
                  serverSide: true,
                  searching: true,
                  pageLength: 10,

                  // Default sort by created_at (latest first)
                  order: [[17, 'desc']],

                  ajax: {
                        url: table.dataset.ajaxUrl,
                        data: function (d) {
                              const form = document.querySelector('[data-all-applications-table-filter="form"]');

                              d.sylhet3_resident = form.querySelector('[name="sylhet3_resident"]').value;
                              d.upazila_id = form.querySelector('[name="upazila_id"]').value;
                              d.occupation_id = form.querySelector('[name="occupation_id"]').value;
                              d.team_id = form.querySelector('[name="team_id"]').value;
                              d.weekly_hours = form.querySelector('[name="weekly_hours"]').value;
                              d.preferred_time = form.querySelector('[name="preferred_time"]').value;
                              d.status = form.querySelector('[name="status"]').value;
                        }
                  },

                  columns: [
                        { data: 'DT_RowIndex', searchable: false, orderable: false },
                        { data: 'full_name' },
                        { data: 'mobile' },
                        { data: 'nid' },
                        { data: 'sylhet3_resident', searchable: false },
                        { data: 'upazila', searchable: false },
                        { data: 'union_name' },
                        { data: 'current_address', searchable: false },
                        { data: 'voting_center' },
                        { data: 'age', searchable: false },
                        { data: 'occupation', searchable: false },
                        { data: 'teams', searchable: false, orderable: false },
                        { data: 'reference' },
                        { data: 'weekly_hours', searchable: false },
                        { data: 'preferred_time', searchable: false },
                        { data: 'comments', searchable: false, orderable: false },
                        { data: 'status', searchable: false, orderable: false },
                        { data: 'created_at', searchable: false },
                        { data: 'action', searchable: false, orderable: false }
                  ]
            });
      };

      /* -------------------------------------------
       * Global Search
       * ----------------------------------------- */
      const handleSearch = function () {
            let timer;
            const searchInput = document.querySelector('[data-all-applications-table-filter="search"]');

            if (!searchInput) return;

            searchInput.addEventListener('keyup', function () {
                  clearTimeout(timer);
                  timer = setTimeout(() => {
                        datatable.search(this.value).draw();
                  }, 300);
            });
      };

      /* -------------------------------------------
       * Filters + Reset
       * ----------------------------------------- */
      const handleFilters = function () {
            const form = document.querySelector('[data-all-applications-table-filter="form"]');
            if (!form) return;

            form.querySelector('[data-all-applications-table-filter="filter"]')
                  .addEventListener('click', function () {
                        datatable.ajax.reload();
                  });

            form.querySelector('[data-all-applications-table-filter="reset"]')
                  .addEventListener('click', function () {
                        form.querySelectorAll('select').forEach(el => {
                              $(el).val(null).trigger('change');
                        });

                        datatable.search('').draw();
                  });
      };

      /* -------------------------------------------
       * Select2 Init (Metronic Style)
       * ----------------------------------------- */
      const initSelect2 = function () {
            $('[data-kt-select2="true"]').each(function () {
                  $(this).select2({
                        placeholder: $(this).data('placeholder'),
                        allowClear: true,
                        minimumResultsForSearch: $(this).data('hide-search') ? Infinity : 0,
                        width: '100%'
                  });
            });
      };

      /* -------------------------------------------
       * Excel Export
       * ----------------------------------------- */
      const handleExport = function () {
            const btn = document.querySelector('[data-row-export="excel"]');
            if (!btn) return;

            btn.addEventListener('click', function () {
                  const form = document.querySelector('[data-all-applications-table-filter="form"]');

                  const params = new URLSearchParams({
                        sylhet3_resident: form.querySelector('[name="sylhet3_resident"]').value,
                        upazila_id: form.querySelector('[name="upazila_id"]').value,
                        occupation_id: form.querySelector('[name="occupation_id"]').value,
                        team_id: form.querySelector('[name="team_id"]').value,
                        weekly_hours: form.querySelector('[name="weekly_hours"]').value,
                        preferred_time: form.querySelector('[name="preferred_time"]').value,
                        status: form.querySelector('[name="status"]').value,
                        search: datatable.search()
                  });

                  window.location.href =
                        window.APPLICATION_EXPORT_URL + '?' + params.toString();
            });
      };

      /* -------------------------------------------
       * Approve / Reject (SweetAlert + AJAX)
       * ----------------------------------------- */
      const handleActions = function () {

            $(document).on('click', '.js-approve, .js-reject', function () {
                  const id = this.dataset.id;
                  const status = this.classList.contains('js-approve') ? 'approved' : 'rejected';

                  Swal.fire({
                        title: 'আপনি কি নিশ্চিত?',
                        text: status === 'approved'
                              ? 'এই আবেদনটি গৃহীত হবে'
                              : 'এই আবেদনটি বাতিল হবে',
                        icon: status === 'approved' ? 'question' : 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'হ্যাঁ',
                        cancelButtonText: 'না',
                        confirmButtonColor: status === 'approved' ? '#28a745' : '#dc3545'
                  }).then((result) => {
                        if (!result.isConfirmed) return;

                        $.ajax({
                              url: window.APPLICATION_STATUS_URL.replace(':id', id),
                              type: 'POST',
                              data: {
                                    _token: window.CSRF_TOKEN,
                                    status: status
                              },
                              success: function (res) {
                                    Swal.fire({
                                          icon: 'success',
                                          text: res.message,
                                          timer: 1500,
                                          showConfirmButton: false
                                    });

                                    datatable.ajax.reload(null, false);
                              },
                              error: function (xhr) {
                                    Swal.fire({
                                          icon: 'error',
                                          text: xhr.responseJSON?.message || 'কিছু একটা সমস্যা হয়েছে'
                                    });
                              }
                        });
                  });
            });
      };

      /* -------------------------------------------
       * Init
       * ----------------------------------------- */
      return {
            init: function () {
                  initDatatable();
                  initSelect2();
                  handleSearch();
                  handleFilters();
                  handleExport();
                  handleActions();
            }
      };
})();

/* -------------------------------------------
 * DOM Ready
 * ----------------------------------------- */
document.addEventListener('DOMContentLoaded', function () {
      ApplicationsTable.init();
});
