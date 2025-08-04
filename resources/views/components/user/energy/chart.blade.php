<div x-data="energyChart()"
     x-init="init()">
    <!-- Legend -->
    @include('components.user.energy.legend')

    <!-- Chart -->
    <div class="w-full md:w-2/3 mx-auto p-4 md:p-16 pb-0 shadow-sm">
        <canvas id="energyChart" class="w-full h-96"></canvas>
    </div>

    <!-- Company Averages Bar -->
    @include('components.user.energy.company')

    <script>
        function energyChart() {
            return {
                async init() {
                    if (!window.Chart) {
                        await new Promise((resolve, reject) => {
                            const script = document.createElement('script');
                            script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
                            script.onload = () => resolve();
                            script.onerror = () => reject(new Error('Failed to load Chart.js'));
                            document.head.appendChild(script);
                        });
                    }

                    const data = @json($history);
                    const sections = @json($sections);
                    const labels = data.map(r => new Date(r.date).toLocaleDateString('fa-IR'));

                    new Chart(document.getElementById('energyChart'), {
                        type: 'line',
                        data: {
                            labels,
                            datasets: [
                                {
                                    label: sections.physique,
                                    data: data.map(r => r.physique),
                                    tension: 0.4,
                                    borderWidth: 2,
                                    fill: false,
                                    borderColor: '#3B82F6',
                                    backgroundColor: '#3B82F6'
                                },
                                {
                                    label: sections.emotion,
                                    data: data.map(r => r.emotion),
                                    tension: 0.4,
                                    borderWidth: 2,
                                    fill: false,
                                    borderColor: '#EF4444',
                                    backgroundColor: '#EF4444'
                                },
                                {
                                    label: sections.mind,
                                    data: data.map(r => r.mind),
                                    tension: 0.4,
                                    borderWidth: 2,
                                    fill: false,
                                    borderColor: '#10B981',
                                    backgroundColor: '#10B981'
                                },
                                {
                                    label: sections.soul,
                                    data: data.map(r => r.soul),
                                    tension: 0.4,
                                    borderWidth: 2,
                                    fill: false,
                                    borderColor: '#F59E0B',
                                    backgroundColor: '#F59E0B'
                                },
                                {
                                    label: 'نمره کل',
                                    data: data.map(r => r.overall),
                                    tension: 0.4,
                                    borderWidth: 3,
                                    borderDash: [5, 5],
                                    fill: false,
                                    borderColor: '#8B5CF6',
                                    backgroundColor: '#8B5CF6'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            animation: {duration: 1000, easing: 'easeInOutQuad'},
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        boxWidth: 12,
                                        padding: 16,
                                        font: {family: 'persol-font, Tahoma, Arial'}
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 16,
                                    title: {
                                        display: true,
                                        text: 'نمره 0 =عالی  ||  16  =بحرانی',
                                        font: {family: 'persol-font, Tahoma, Arial'}
                                    },
                                    ticks: {
                                        font: {family: 'persol-font, Tahoma, Arial'},
                                        callback: function (value) {
                                            const labels = {
                                                0: 'عالی',
                                                4: 'متوسط',
                                                8: 'ضعیف',
                                                12: 'خطرناک',
                                                16: 'بحرانی'
                                            };
                                            return labels[value] || value;
                                        }
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'تاریخ',
                                        font: {family: 'persol-font, Tahoma, Arial'}
                                    },
                                    ticks: {font: {family: 'persol-font, Tahoma, Arial'}}
                                }
                            }
                        },
                        plugins: [
                            {
                                id: 'rowBackground',
                                beforeDraw(chart) {
                                    const {ctx, chartArea: {top, bottom, left, right}, scales: {y}} = chart;
                                    const ticks = y.ticks.map(t => t.value);
                                    for (let i = 0; i < ticks.length - 1; i++) {
                                        const v = ticks[i];
                                        let bg;
                                        if (v <= 2) bg = 'rgba(187, 247, 208, 0.2)';
                                        else if (v <= 5) bg = 'rgba(147, 197, 253, 0.2)';
                                        else if (v <= 9) bg = 'rgba(253, 224, 71, 0.2)';
                                        else if (v <= 13) bg = 'rgba(253, 186, 116, 0.2)';
                                        else bg = 'rgba(252, 165, 165, 0.2)';

                                        const yTop = y.getPixelForValue(v);
                                        const yBottom = y.getPixelForValue(ticks[i + 1]);
                                        ctx.fillStyle = bg;
                                        ctx.fillRect(left, yBottom, right - left, yTop - yBottom);
                                    }
                                }
                            }
                        ]
                    });
                }
            }
        }
    </script>
</div>
