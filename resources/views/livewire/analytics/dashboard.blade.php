<div>
    <div class="flex justify-between items-center mb-8">
        <div>
            <flux:heading size="xl">Executive Dashboard</flux:heading>
            <flux:subheading>Overview of institutional effectiveness and alumni metrics.</flux:subheading>
        </div>
        
        <flux:button icon="arrow-down-tray" variant="primary" color="lime" class="print:hidden" x-on:click="window.print()">
            Export PDF Report
        </flux:button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <flux:card>
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-100 text-blue-600 rounded-lg dark:bg-blue-900/30 dark:text-blue-400">
                    <flux:icon.users class="w-6 h-6" />
                </div>
                <div>
                    <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Surveyed</div>
                    <div class="text-2xl font-bold">{{ number_format($totalGraduates) }}</div>
                </div>
            </div>
        </flux:card>

        <flux:card>
            <div class="flex items-center gap-4">
                <div class="p-3 bg-emerald-100 text-emerald-600 rounded-lg dark:bg-emerald-900/30 dark:text-emerald-400">
                    <flux:icon.briefcase class="w-6 h-6" />
                </div>
                <div>
                    <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Employment Rate</div>
                    <div class="text-2xl font-bold">{{ $employmentRate }}%</div>
                </div>
            </div>
        </flux:card>

        <flux:card>
            <div class="flex items-center gap-4">
                <div class="p-3 bg-amber-100 text-amber-600 rounded-lg dark:bg-amber-900/30 dark:text-amber-400">
                    <flux:icon.academic-cap class="w-6 h-6" />
                </div>
                <div>
                    <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">First-Gen Graduates</div>
                    <div class="text-2xl font-bold">{{ $firstGenRate }}%</div>
                </div>
            </div>
        </flux:card>

        <flux:card>
            <div class="flex items-center gap-4">
                <div class="p-3 bg-purple-100 text-purple-600 rounded-lg dark:bg-purple-900/30 dark:text-purple-400">
                    <flux:icon.user-plus class="w-6 h-6" />
                </div>
                <div>
                    <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Pending Alumni CRM</div>
                    <div class="text-2xl font-bold">{{ number_format($pendingAlumni) }}</div>
                </div>
            </div>
        </flux:card>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <flux:card class="lg:col-span-2 min-h-[400px] flex flex-col">
            <flux:heading size="lg" class="mb-4">Employment Trends Over Time</flux:heading>
            
            <div 
                class="w-full flex-1"
                x-data="employmentChart(@js($employmentTrendData))"
                x-cloak
            >
                <div x-ref="chart" class="w-full h-full min-h-[350px]"></div>
            </div>
        </flux:card>

        <flux:card class="min-h-[400px] flex flex-col">
            <flux:heading size="lg" class="mb-4">Graduate Satisfaction</flux:heading>
            
            <div 
                class="w-full flex-1 flex items-center justify-center"
                x-data="satisfactionChart(@js($satisfactionData))"
                x-cloak
            >
                <div x-ref="radarChart" class="w-full h-full min-h-[350px]"></div>
            </div>
        </flux:card>

    </div>
</div>

@script
<script>
    // 1. Employment Chart Logic (Keep your existing one here)
    Alpine.data('employmentChart', (chartData) => ({
        chart: null,
        
        // Alpine automatically fires init() on load
        init() {
            const options = {
                series: [{
                    name: 'Employment Rate (%)',
                    data: chartData.data
                }],
                chart: {
                    type: 'area',
                    height: '100%',
                    fontFamily: 'inherit',
                    toolbar: { show: false },
                    animations: { enabled: true }
                },
                colors: ['#10b981'], 
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.05,
                        stops: [50, 100]
                    }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3 },
                xaxis: {
                    categories: chartData.categories,
                    tooltip: { enabled: false }
                },
                yaxis: {
                    min: 0,
                    max: 100,
                    labels: {
                        formatter: (value) => { return value + "%" }
                    }
                },
                theme: {
                    mode: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
                }
            };

            this.chart = new ApexCharts(this.$refs.chart, options);
            this.chart.render();
        }
    }));

    // 2. New Satisfaction Radar Chart Logic
    Alpine.data('satisfactionChart', (chartData) => ({
        chart: null,
        
        init() {
            const options = {
                series: [{
                    name: 'Average Rating (out of 5)',
                    data: chartData.data
                }],
                chart: {
                    type: 'radar',
                    height: '100%',
                    fontFamily: 'inherit',
                    toolbar: { show: false },
                },
                colors: ['#8b5cf6'], // Purple-500 to match your UI
                stroke: { width: 2 },
                fill: { opacity: 0.2 },
                markers: { size: 4, hover: { size: 6 } },
                xaxis: {
                    categories: chartData.categories,
                    labels: {
                        style: {
                            colors: document.documentElement.classList.contains('dark') ? ['#a1a1aa', '#a1a1aa', '#a1a1aa', '#a1a1aa', '#a1a1aa'] : ['#52525b', '#52525b', '#52525b', '#52525b', '#52525b'],
                            fontSize: '11px',
                            fontFamily: 'inherit'
                        }
                    }
                },
                yaxis: {
                    min: 0,
                    max: 5,
                    tickAmount: 5,
                    show: false // Hide the inner numbers for a cleaner look
                },
                theme: {
                    mode: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
                }
            };

            this.chart = new ApexCharts(this.$refs.radarChart, options);
            this.chart.render();
        }
    }));

</script>
@endscript