@push('scripts')
    @once
        <script>
            function energyChart() {
                const colors = ['#3e2f24', '#52585b', '#1f2933', '#7a5a48', '#000000'];
                const bgColors = colors.map(c => c + 'B3');
                const font = {family: 'persol-font, Tahoma, Arial'};
                const statusLabels = {0: 'عالی', 4: 'متوسط', 8: 'ضعیف', 12: 'خطرناک', 16: 'بحرانی'};
                const bgFill = {
                    id: 'rowBackground',
                    beforeDraw(chart) {
                        const {ctx, chartArea: {top, bottom, left, right}, scales: {y}} = chart;
                        const ticks = y.ticks.map(t => t.value);
                        const backgrounds = ['rgba(187, 247, 208, 0.2)', 'rgba(147, 197, 253, 0.2)', 'rgba(253, 224, 71, 0.2)', 'rgba(253, 186, 116, 0.2)', 'rgba(252, 165, 165, 0.2)'];

                        for (let i = 0; i < ticks.length - 1; i++) {
                            const v = ticks[i];
                            const bg = v <= 2 ? backgrounds[0] : v <= 5 ? backgrounds[1] : v <= 9 ? backgrounds[2] : v <= 13 ? backgrounds[3] : backgrounds[4];
                            const yTop = y.getPixelForValue(v);
                            const yBottom = y.getPixelForValue(ticks[i + 1]);
                            ctx.fillStyle = bg;
                            ctx.fillRect(left, yBottom, right - left, yTop - yBottom);
                        }
                    }
                };

                let chartInstance = null;


                return {
                    async init() {
                        if (!window.Chart) {
                            await new Promise((resolve, reject) => {
                                const script = document.createElement('script');
                                script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
                                script.onload = resolve;
                                script.onerror = () => reject(new Error('Failed to load Chart.js'));
                                document.head.appendChild(script);
                            });
                        }

                        this.createChart();

                        window.addEventListener('resize', () => {
                            if (chartInstance) {
                                chartInstance.destroy();
                            }
                            setTimeout(() => this.createChart(), 100);
                        });
                    },

                    createChart() {
                        const data = @json($history);
                        const sections = @json($sections);
                        const ctx = document.getElementById('energyChart');

                        if (data.length === 1) {
                            const r = data[0];
                            chartInstance = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: [sections.physique, sections.emotion, sections.mind, sections.soul, 'شاخص کل'],
                                    datasets: [{
                                        label: 'آخرین شاخص شما در تاریخ ' + new Date(r.date).toLocaleDateString('fa-IR'),
                                        data: [r.physique, r.emotion, r.mind, r.soul, r.overall],
                                        backgroundColor: bgColors,
                                        borderColor: colors,
                                        borderWidth: 2
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {legend: {display: false}},
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            max: 16,
                                            title: {
                                                display: true,
                                                text: '📉 شاخص: 16 = بحرانی ❌  ───  0 = عالی ✅',
                                                font
                                            },
                                            ticks: {font, callback: v => statusLabels[v] || v}
                                        },
                                        x: {ticks: {font}}
                                    }
                                },
                                plugins: [bgFill]
                            });
                        } else {
                            const labels = data.map(r => new Date(r.date).toLocaleDateString('fa-IR'));
                            const datasets = [
                                {
                                    label: sections.physique,
                                    data: data.map(r => r.physique),
                                    borderColor: colors[0],
                                    backgroundColor: colors[0]
                                },
                                {
                                    label: sections.emotion,
                                    data: data.map(r => r.emotion),
                                    borderColor: colors[1],
                                    backgroundColor: colors[1]
                                },
                                {
                                    label: sections.mind,
                                    data: data.map(r => r.mind),
                                    borderColor: colors[2],
                                    backgroundColor: colors[2]
                                },
                                {
                                    label: sections.soul,
                                    data: data.map(r => r.soul),
                                    borderColor: colors[3],
                                    backgroundColor: colors[3]
                                },
                                {
                                    label: 'شاخص کل',
                                    data: data.map(r => r.overall),
                                    borderColor: colors[4],
                                    backgroundColor: colors[4],
                                    borderWidth: 3,
                                    borderDash: [5, 5]
                                }
                            ].map(d => ({...d, tension: 0.4, borderWidth: d.borderWidth || 2, fill: false}));

                            chartInstance = new Chart(ctx, {
                                type: 'line',
                                data: {labels, datasets},
                                options: {
                                    responsive: true,
                                    animation: {duration: 1000, easing: 'easeInOutQuad'},
                                    plugins: {
                                        legend: {position: 'bottom', labels: {boxWidth: 12, padding: 16, font}}
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            max: 16,
                                            title: {
                                                display: true,
                                                text: '📉 شاخص: 16  = بحرانی ❌  ───  0 = عالی ✅',
                                                font
                                            },
                                            ticks: {font, callback: v => statusLabels[v] || v}
                                        },
                                        x: {title: {display: true, text: '📆 تاریخ', font}, ticks: {font}}
                                    }
                                },
                                plugins: [bgFill]
                            });
                        }
                    }
                }
            }
        </script>
    @endonce
@endpush
