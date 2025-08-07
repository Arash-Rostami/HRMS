<?php
namespace App\Filament\Resources\DashboardResource\Widgets;
use App\Models\EnergyTest;
use Filament\Widgets\BarChartWidget;
class DepartmentEnergyChart extends BarChartWidget
{
    protected static ?string $heading = 'Average Energy by Department';
    public ?string $filter = 'all';
    protected static ?string $pollingInterval = '30s';

    protected function getFilters(): ?array
    {
        return [
            'all' => 'All Time',
            'last' => 'Last Time',
        ];
    }
    protected function getType(): string
    {
        return 'bar';
    }
    protected function getData(): array
    {
        $data = EnergyTest::getAverageScoresByDepartment($this->filter === 'last');
        $labels = $data->keys()->all();
        $scores = $data->values()->all();
        [$bg, $border] = $this->generateChartColors(count($labels));
        return [
            'labels' => $labels,
            'datasets' => [[
                'label' => $this->filter === 'last' ? 'Avg. Overall Score (Last 30 Days)' : 'Avg. Overall Score (All Time)',
                'data' => $scores,
                'backgroundColor' => $bg,
                'borderColor' => $border,
                'borderWidth' => 1,
            ]],
        ];
    }
    protected function generateChartColors(int $count): array
    {
        $backgroundColors = [];
        $borderColors = [];
        for ($i = 0; $i < $count; $i++) {
            $r = rand(0, 255);
            $g = rand(0, 255);
            $b = rand(0, 255);
            $backgroundColors[] = "rgba({$r},{$g},{$b},0.4)";
            $borderColors[] = "rgba({$r},{$g},{$b},0.7)";
        }
        return [$backgroundColors, $borderColors];
    }
    protected function getOptions(): array
    {
        return array_merge((array)parent::getOptions(), [
            'indexAxis' => 'y',
            'scales' => [
                'x' => ['beginAtZero' => true, 'max' => 16],
            ],
        ]);
    }
}
