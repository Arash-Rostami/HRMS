import {
    genderAndMaritalStatusChartData,
    genderAndPositionsChartData,
    employmentTypeChartData,
    departmentDistributionChartData,
    ageDistributionChartData,
    educationAndExperienceChartData,
    averageWorkingHoursChartData
} from './chartConfig.js';


const getGenderAndMaritalStatusChartData = genderAndMaritalStatusChartData();
const getGenderAndPositionsChartData = genderAndPositionsChartData();
const getEmploymentTypeChartData = employmentTypeChartData();
const getDepartmentDistributionChartData = departmentDistributionChartData();
const getAgeDistributionChartData = ageDistributionChartData();
const getEducationAndExperienceChartData = educationAndExperienceChartData();
const getAverageWorkingHoursChartData = averageWorkingHoursChartData();

/* First row
Marital status chart */
let genderAndMaritalStatusChartDataCtx = document.getElementById('genderChart').getContext('2d');
const genderAndMaritalStatusChartDataData = {
    labels: getGenderAndMaritalStatusChartData.label,
    datasets: [{
        data: getGenderAndMaritalStatusChartData.chartData,
        backgroundColor: [
            'rgb(54,162,235, 0.85)',
            'rgb(54,162,235)',
            'rgb(255,99,132, 0.75)',
            'rgb(255,99,132)',
        ],
        borderColor: [
            'rgb(54,162,235, 0.85)',
            'rgb(54,162,235)',
            'rgb(255,99,132, 0.80)',
            'rgb(255,99,132)',
        ],
    }],
};
setTimeout(() => {
    const genderChart = new Chart(genderAndMaritalStatusChartDataCtx, {
        type: 'pie',
        data: genderAndMaritalStatusChartDataData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    position: 'bottom',
                    text: 'Marital status by gender',
                },
            },
        }
    });
}, 1750);

//Years of experience chart
let educationAndExperienceChartCtx = document.getElementById('educationExperienceChart').getContext('2d');
const colorPalette = ['rgb(103,151,162,0.50)', 'rgb(147,216,231)', 'rgb(255,99,132)'];
const datasets = getEducationAndExperienceChartData.degreeTypes.map((degree, index) => {
    return {
        label: degree,
        data: getEducationAndExperienceChartData.experienceRanges.map(range => getEducationAndExperienceChartData.chartData[range][degree]),
        backgroundColor: colorPalette[index]

    }
});
setTimeout(() => {
    const stackedBarChart = new Chart(educationAndExperienceChartCtx, {
        type: 'bar',
        data: {
            labels: getEducationAndExperienceChartData.experienceRanges,
            datasets: datasets,
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    position: 'bottom',
                    text: 'Distribution of educational level by experience range',
                },
            },
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                },
            },
        },
    });
}, 1750);

// Employment type chart
let employmentTypeCtx = document.getElementById('employmentTypeChart').getContext('2d');
const employmentTypeData = {
    labels: getEmploymentTypeChartData.label,
    datasets: [{
        label: 'Employment Type',
        data: getEmploymentTypeChartData.chartData,
        backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 206, 86)', 'rgb(75, 192, 192)'],
    }],
};
setTimeout(() => {
    const employmentTypeChart = new Chart(employmentTypeCtx, {
        type: 'doughnut',
        data: employmentTypeData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    position: 'bottom',
                    text: 'Population distribution by employment',
                },
            },
        },
    });
}, 1750);


/* Second row
Gender distribution chart */
let genderDistributionCtx = document.getElementById('genderDistribution').getContext('2d');
const positions = getGenderAndPositionsChartData.positions;
const colorOpacity = 0.2;
const genderColors = {male: '54, 162, 235', female: '255, 99, 132'};
const genderDistributionData = {
    labels: getGenderAndPositionsChartData.label,
    datasets: positions.map((position, index) => {
        const maleBackgroundColor = `rgba(${genderColors.male}, ${1 - (index * colorOpacity)})`;
        const femaleBackgroundColor = `rgba(${genderColors.female}, ${1 - (index * colorOpacity)})`;

        return {
            label: position,
            data: getGenderAndPositionsChartData.data[position],
            backgroundColor: [maleBackgroundColor, femaleBackgroundColor]
        };
    })
};
setTimeout(() => {
    const genderDistributionChart = new Chart(genderDistributionCtx, {
        type: 'bar',
        data: genderDistributionData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    position: 'bottom',
                    text: 'Gender distribution based on position',
                },
            },
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true,
                }
            }
        }
    });
}, 2500);

//Age distribution chart
const ageDistributionCtx = document.getElementById('ageDistributionChart').getContext('2d');
const ageDistributionData = {
    labels: getAgeDistributionChartData.labels,
    datasets: [{
        label: 'Both',
        data: getAgeDistributionChartData.data.both,
        borderColor: 'rgb(75, 192, 192)',
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        fill: true,
    }, {
        label: 'Female',
        data: getAgeDistributionChartData.data.female,
        borderColor: 'rgb(255, 99, 132)',
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
        fill: true,
    }, {
        label: 'Male',
        data: getAgeDistributionChartData.data.male,
        borderColor: 'rgb(54, 162, 235)',
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        fill: true,
    }],
};
setTimeout(() => {
    const ageDistributionChart = new Chart(ageDistributionCtx, {
        type: 'line',
        data: ageDistributionData,
        options: {
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    position: 'bottom',
                    text: 'Age distribution based on gender',
                },
            },
            responsive: true,
            transitions: {
                show: {
                    animations: {
                        x: {
                            from: 0
                        },
                        y: {
                            from: 0
                        }
                    }
                },
                hide: {
                    animations: {
                        x: {
                            to: 0
                        },
                        y: {
                            to: 0
                        }
                    }
                }
            },
            hoverRadius: 12,
            hoverBackgroundColor: 'darkgrey',
            interaction: {
                mode: 'nearest',
                intersect: false,
                axis: 'x'
            },
        }
    });
}, 2500);


/* Third row
// Department distribution chart */
let departmentDistributionCtx = document.getElementById('departmentDistributionChart').getContext('2d');
const departmentDistributionData = {
    labels: getDepartmentDistributionChartData.label,
    datasets: [{
        label: 'Departmental Contribution',
        data: getDepartmentDistributionChartData.chartData,
        backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 206, 86)', 'rgb(75, 192, 192)', 'rgb(153, 102, 255)', 'rgb(255, 159, 64)', 'rgb(255, 192, 203)', 'rgb(0, 128, 0)', 'rgb(255, 255, 0)', 'rgb(128, 0, 0)', 'rgb(139, 0, 139)', 'rgb(0, 255, 255)', 'rgb(0, 0, 128)', 'rgb(128, 0, 0)', 'rgb(169, 169, 169)'],

    }]
};
setTimeout(() => {
    const departmentContributionChart = new Chart(departmentDistributionCtx, {
        type: 'polarArea',
        data: departmentDistributionData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    position: 'bottom',
                    text: 'Population distribution based on department',
                },
            },
            animation: {
                animateRotate: true,
                animateScale: true,
            },
        }
    });
}, 3000);


// Average Working Hours Chart
const departmentAverageWorkingHoursCtx = document.getElementById('departmentAverageWorkingHours').getContext('2d');
const data = getAverageWorkingHoursChartData.chartData;

function getChartData(data, key) {
    return getAverageWorkingHoursChartData.labels.map(label => parseFloat(data[label][key]));
}

const departmentAverageWorkingHoursData = {
    labels: getAverageWorkingHoursChartData.labels,
    datasets: [
        {
            label: 'Average Working Hours',
            data: getChartData(data, 'average'),
            backgroundColor: 'rgb(103,151,162, 0.4)',
            borderColor: 'rgb(103,151,162, 0.75)',
            borderWidth: 1
        },
        {
            label: 'Total Working Hours',
            data: getChartData(data, 'total_hours'),
            backgroundColor: 'rgb(255,99,132, 0.2)',
            borderColor: 'rgb(255,99,132, 0.75)',
            borderWidth: 1
        },
        {
            label: 'Number of personnel',
            data: getChartData(data, 'user_count'),
            backgroundColor: 'rgb(255,134,99)',
            borderColor: 'rgb(255,134,99, 0.75)',
            borderWidth: 1
        }
    ]
};


setTimeout(() => {
    const departmentAverageWorkingHours = new Chart(departmentAverageWorkingHoursCtx, {
        type: 'radar',
        data: departmentAverageWorkingHoursData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    position: 'bottom',
                    text: 'Average Working Hours of Departments',
                },
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutQuad',
            },
            scales: {
                r: {
                    beginAtZero: true
                }
            }
        }
    });
}, 3000);

