/**
 * Dashboard Index JavaScript
 * Volunteer Management System
 */

(function () {
      'use strict';

      // Bengali numerals mapping
      const bengaliNumerals = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];

      // Bengali month names
      const bengaliMonths = [
            'জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন',
            'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'
      ];

      const bengaliMonthsShort = [
            'জানু', 'ফেব্রু', 'মার্চ', 'এপ্রিল', 'মে', 'জুন',
            'জুলাই', 'আগস্ট', 'সেপ্টে', 'অক্টো', 'নভে', 'ডিসে'
      ];

      // Chart instances
      let trendChart = null;
      let residentChart = null;
      let ageChart = null;
      let hoursChart = null;
      let timeChart = null;

      // Current state
      let currentView = 'daily';
      let currentMonth = window.dashboardConfig.currentMonth;
      let currentYear = window.dashboardConfig.currentYear;

      // Default chart font size
      Chart.defaults.font.size = 14;

      /**
       * Convert number to Bengali numerals
       * @param {number|string} num 
       * @returns {string}
       */
      function toBengaliNumber(num) {
            return num.toString().replace(/[0-9]/g, function (w) {
                  return bengaliNumerals[parseInt(w)];
            });
      }

      /**
       * Format number with Bengali locale
       * @param {number} num 
       * @returns {string}
       */
      function formatBengaliNumber(num) {
            return toBengaliNumber(num.toLocaleString('en-IN'));
      }

      /**
       * Calculate percentage
       * @param {number} value 
       * @param {number} total 
       * @returns {number}
       */
      function calcPercent(value, total) {
            if (total === 0) return 0;
            return Math.round((value / total) * 100);
      }

      /**
       * Animate counter elements
       */
      function animateCounters() {
            document.querySelectorAll('[data-counter]').forEach(function (element) {
                  const target = parseInt(element.dataset.counter);
                  let start = 0;
                  const duration = 1000;
                  const increment = target / (duration / 16);

                  const timer = setInterval(function () {
                        start += increment;
                        if (start >= target) {
                              element.textContent = formatBengaliNumber(target);
                              clearInterval(timer);
                        } else {
                              element.textContent = formatBengaliNumber(Math.floor(start));
                        }
                  }, 16);
            });
      }

      /**
       * Get days in month
       * @param {number} year 
       * @param {number} month 
       * @returns {number}
       */
      function getDaysInMonth(year, month) {
            return new Date(year, month, 0).getDate();
      }

      /**
       * Update period label
       */
      function updatePeriodLabel() {
            const periodElement = document.getElementById('currentPeriod');
            if (!periodElement) return;

            const year = toBengaliNumber(currentYear);
            const month = bengaliMonths[currentMonth - 1];

            if (currentView === 'daily') {
                  periodElement.textContent = month + ' ' + year;
            } else {
                  periodElement.textContent = year;
            }
      }

      /**
       * Initialize Trend Chart
       */
      function initTrendChart() {
            const ctx = document.getElementById('trendChart');
            if (!ctx) return;

            let labels, data;

            if (currentView === 'daily') {
                  const daysInMonth = getDaysInMonth(currentYear, currentMonth);
                  labels = [];
                  data = [];

                  for (let i = 1; i <= daysInMonth; i++) {
                        labels.push(toBengaliNumber(i));
                        data.push(window.dashboardConfig.dailyTrend[i] || 0);
                  }
            } else {
                  labels = bengaliMonthsShort;
                  data = [];

                  for (let i = 1; i <= 12; i++) {
                        data.push(window.dashboardConfig.monthlyTrend[i] || 0);
                  }
            }

            if (trendChart) {
                  trendChart.destroy();
            }

            trendChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                        labels: labels,
                        datasets: [{
                              label: 'আবেদন সংখ্যা',
                              data: data,
                              backgroundColor: 'rgba(30, 136, 229, 0.8)',
                              borderColor: '#1e88e5',
                              borderWidth: 1,
                              borderRadius: 6,
                              hoverBackgroundColor: 'rgba(30, 136, 229, 1)'
                        }]
                  },
                  options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                              legend: { display: false },
                              tooltip: {
                                    backgroundColor: '#1e293b',
                                    titleFont: { family: 'inherit', size: 14 },
                                    bodyFont: { family: 'inherit', size: 14 },
                                    padding: 12,
                                    callbacks: {
                                          label: function (context) {
                                                return 'আবেদন: ' + toBengaliNumber(context.raw);
                                          }
                                    }
                              }
                        },
                        scales: {
                              y: {
                                    beginAtZero: true,
                                    ticks: {
                                          font: { size: 13 },
                                          callback: function (value) {
                                                return toBengaliNumber(value);
                                          }
                                    },
                                    grid: { color: 'rgba(0,0,0,0.05)' }
                              },
                              x: {
                                    ticks: {
                                          font: { size: 12 }
                                    },
                                    grid: { display: false }
                              }
                        }
                  }
            });

            updatePeriodLabel();
      }

      /**
       * Fetch trend data via AJAX
       */
      function fetchTrendData() {
            const url = new URL(window.dashboardConfig.trendDataUrl, window.location.origin);
            url.searchParams.set('month', currentMonth);
            url.searchParams.set('year', currentYear);
            url.searchParams.set('view', currentView);

            fetch(url)
                  .then(function (response) {
                        return response.json();
                  })
                  .then(function (result) {
                        // Update the config with new data
                        if (currentView === 'daily') {
                              window.dashboardConfig.dailyTrend = {};
                              result.labels.forEach(function (label, index) {
                                    window.dashboardConfig.dailyTrend[label] = result.data[index];
                              });
                        } else {
                              window.dashboardConfig.monthlyTrend = {};
                              result.labels.forEach(function (label, index) {
                                    window.dashboardConfig.monthlyTrend[label] = result.data[index];
                              });
                        }

                        // Re-initialize chart
                        initTrendChart();
                  })
                  .catch(function (error) {
                        console.error('Error fetching trend data:', error);
                        updatePeriodLabel();
                  });
      }

      /**
       * Initialize Sylhet-3 Resident Chart
       */
      function initResidentChart() {
            const ctx = document.getElementById('residentChart');
            if (!ctx) return;

            const stats = window.dashboardConfig.sylhet3Stats;
            const yes = stats.yes || 0;
            const no = stats.no || 0;
            const total = yes + no;

            if (residentChart) {
                  residentChart.destroy();
            }

            residentChart = new Chart(ctx, {
                  type: 'doughnut',
                  data: {
                        labels: ['সিলেট-৩ বাসিন্দা', 'অন্য এলাকার'],
                        datasets: [{
                              data: [yes, no],
                              backgroundColor: ['#43a047', '#fb8c00'],
                              borderWidth: 0,
                              hoverOffset: 10
                        }]
                  },
                  options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        cutout: '60%',
                        plugins: {
                              legend: { display: false },
                              tooltip: {
                                    backgroundColor: '#1e293b',
                                    titleFont: { size: 14 },
                                    bodyFont: { size: 14 },
                                    padding: 12,
                                    callbacks: {
                                          label: function (context) {
                                                const percent = calcPercent(context.raw, total);
                                                return context.label + ': ' + toBengaliNumber(context.raw) + ' (' + toBengaliNumber(percent) + '%)';
                                          }
                                    }
                              }
                        }
                  }
            });
      }

      /**
       * Initialize Age Range Chart
       */
      function initAgeChart() {
            const ctx = document.getElementById('ageChart');
            if (!ctx) return;

            const ageData = window.dashboardConfig.ageRanges;
            const labels = Object.keys(ageData);
            const data = Object.values(ageData);
            const total = data.reduce(function (a, b) { return a + b; }, 0);

            if (ageChart) {
                  ageChart.destroy();
            }

            ageChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                        labels: labels,
                        datasets: [{
                              label: 'আবেদনকারী',
                              data: data,
                              backgroundColor: [
                                    'rgba(33, 150, 243, 0.85)',   // Blue
                                    'rgba(76, 175, 80, 0.85)',    // Green
                                    'rgba(255, 193, 7, 0.85)',    // Yellow
                                    'rgba(244, 67, 54, 0.85)',    // Red
                                    'rgba(156, 39, 176, 0.85)',   // Purple
                                    'rgba(255, 152, 0, 0.85)',    // Orange
                                    'rgba(0, 188, 212, 0.85)',    // Cyan
                              ],

                              borderRadius: 6,
                              barThickness: 28
                        }]
                  },
                  options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: 'y',
                        plugins: {
                              legend: { display: false },
                              tooltip: {
                                    backgroundColor: '#1e293b',
                                    titleFont: { size: 14 },
                                    bodyFont: { size: 14 },
                                    padding: 12,
                                    callbacks: {
                                          label: function (context) {
                                                const percent = calcPercent(context.raw, total);
                                                return toBengaliNumber(context.raw) + ' জন (' + toBengaliNumber(percent) + '%)';
                                          }
                                    }
                              }
                        },
                        scales: {
                              x: {
                                    beginAtZero: true,
                                    ticks: {
                                          font: { size: 13 },
                                          callback: function (value) {
                                                return toBengaliNumber(value);
                                          }
                                    },
                                    grid: { color: 'rgba(0,0,0,0.05)' }
                              },
                              y: {
                                    ticks: {
                                          font: { size: 14 }
                                    },
                                    grid: { display: false }
                              }
                        }
                  }
            });
      }

      /**
       * Initialize Weekly Hours Chart
       */
      function initHoursChart() {
            const ctx = document.getElementById('hoursChart');
            if (!ctx) return;

            const hoursData = window.dashboardConfig.weeklyHoursStats;
            const labels = Object.keys(hoursData);
            const data = Object.values(hoursData);
            const total = data.reduce(function (a, b) { return a + b; }, 0);

            if (hoursChart) {
                  hoursChart.destroy();
            }

            hoursChart = new Chart(ctx, {
                  type: 'doughnut',
                  data: {
                        labels: labels,
                        datasets: [{
                              data: data,
                              backgroundColor: [
                                    '#4A148C', // Deep Purple
                                    '#1B5E20', // Dark Green
                                    '#0D47A1', // Dark Blue
                                    '#E65100', // Deep Orange
                              ],

                              borderWidth: 2,
                              borderColor: '#fff',
                              hoverOffset: 8
                        }]
                  },
                  options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '55%',
                        plugins: {
                              legend: {
                                    position: 'bottom',
                                    labels: {
                                          padding: 20,
                                          usePointStyle: true,
                                          pointStyle: 'circle',
                                          font: { size: 13 }
                                    }
                              },
                              tooltip: {
                                    backgroundColor: '#1e293b',
                                    titleFont: { size: 14 },
                                    bodyFont: { size: 14 },
                                    padding: 12,
                                    callbacks: {
                                          label: function (context) {
                                                const percent = calcPercent(context.raw, total);
                                                return context.label + ': ' + toBengaliNumber(context.raw) + ' জন (' + toBengaliNumber(percent) + '%)';
                                          }
                                    }
                              }
                        }
                  }
            });
      }

      /**
       * Initialize Preferred Time Chart
       */
      function initTimeChart() {
            const ctx = document.getElementById('timeChart');
            if (!ctx) return;

            const timeData = window.dashboardConfig.preferredTimeStats;
            const labels = Object.keys(timeData);
            const data = Object.values(timeData);
            const total = data.reduce(function (a, b) { return a + b; }, 0);

            if (timeChart) {
                  timeChart.destroy();
            }

            timeChart = new Chart(ctx, {
                  type: 'polarArea',
                  data: {
                        labels: labels,
                        datasets: [{
                              data: data,
                              backgroundColor: [
                                    'rgba(255, 193, 7, 0.75)',
                                    'rgba(255, 152, 0, 0.75)',
                                    'rgba(255, 87, 34, 0.75)',
                                    'rgba(103, 58, 183, 0.75)',
                                    'rgba(76, 175, 80, 0.75)'
                              ],
                              borderWidth: 2,
                              borderColor: '#fff'
                        }]
                  },
                  options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                              legend: {
                                    position: 'bottom',
                                    labels: {
                                          padding: 15,
                                          usePointStyle: true,
                                          pointStyle: 'circle',
                                          font: { size: 12 }
                                    }
                              },
                              tooltip: {
                                    backgroundColor: '#1e293b',
                                    titleFont: { size: 14 },
                                    bodyFont: { size: 14 },
                                    padding: 12,
                                    callbacks: {
                                          label: function (context) {
                                                const percent = calcPercent(context.raw, total);
                                                return toBengaliNumber(context.raw) + ' জন (' + toBengaliNumber(percent) + '%)';
                                          }
                                    }
                              }
                        },
                        scales: {
                              r: {
                                    ticks: {
                                          display: false,
                                          font: { size: 12 }
                                    }
                              }
                        }
                  }
            });
      }

      /**
       * Bind event listeners
       */
      function bindEvents() {
            // View toggle buttons
            document.querySelectorAll('.view-toggle .btn').forEach(function (btn) {
                  btn.addEventListener('click', function () {
                        document.querySelectorAll('.view-toggle .btn').forEach(function (b) {
                              b.classList.remove('active');
                        });
                        this.classList.add('active');
                        currentView = this.dataset.view;
                        fetchTrendData();
                  });
            });

            // Previous period button
            var prevBtn = document.getElementById('prevPeriod');
            if (prevBtn) {
                  prevBtn.addEventListener('click', function () {
                        if (currentView === 'daily') {
                              currentMonth--;
                              if (currentMonth < 1) {
                                    currentMonth = 12;
                                    currentYear--;
                              }
                        } else {
                              currentYear--;
                        }
                        fetchTrendData();
                  });
            }

            // Next period button
            var nextBtn = document.getElementById('nextPeriod');
            if (nextBtn) {
                  nextBtn.addEventListener('click', function () {
                        if (currentView === 'daily') {
                              currentMonth++;
                              if (currentMonth > 12) {
                                    currentMonth = 1;
                                    currentYear++;
                              }
                        } else {
                              currentYear++;
                        }
                        fetchTrendData();
                  });
            }

            // Re-initialize charts when tabs are shown (to fix canvas sizing issues)
            document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(function (tab) {
                  tab.addEventListener('shown.bs.tab', function (e) {
                        if (e.target.getAttribute('href') === '#age_chart_tab') {
                              initAgeChart();
                        } else if (e.target.getAttribute('href') === '#hours_chart_tab') {
                              initHoursChart();
                        } else if (e.target.getAttribute('href') === '#time_chart_tab') {
                              initTimeChart();
                        }
                  });
            });
      }

      /**
       * Initialize dashboard
       */
      function init() {
            // Mark dashboard link as active
            var dashboardLink = document.getElementById('dashboard_link');
            if (dashboardLink) {
                  dashboardLink.classList.add('active');
            }

            // Initialize components
            animateCounters();
            initTrendChart();
            initResidentChart();
            initAgeChart();
            initHoursChart();
            initTimeChart();
            bindEvents();
      }

      // Initialize on DOM ready
      if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
      } else {
            init();
      }

})();