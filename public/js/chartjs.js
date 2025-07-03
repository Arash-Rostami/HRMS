/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/chartConfig.js":
/*!*************************************!*\
  !*** ./resources/js/chartConfig.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ageDistributionChartData": () => (/* binding */ ageDistributionChartData),
/* harmony export */   "averageWorkingHoursChartData": () => (/* binding */ averageWorkingHoursChartData),
/* harmony export */   "departmentDistributionChartData": () => (/* binding */ departmentDistributionChartData),
/* harmony export */   "educationAndExperienceChartData": () => (/* binding */ educationAndExperienceChartData),
/* harmony export */   "employmentTypeChartData": () => (/* binding */ employmentTypeChartData),
/* harmony export */   "genderAndMaritalStatusChartData": () => (/* binding */ genderAndMaritalStatusChartData),
/* harmony export */   "genderAndPositionsChartData": () => (/* binding */ genderAndPositionsChartData)
/* harmony export */ });
function genderAndMaritalStatusChartData() {
  return window.chartConfig.getGenderAndMaritalStatusChartData;
}
function genderAndPositionsChartData() {
  return window.chartConfig.getGenderAndPositionsChartData;
}
function employmentTypeChartData() {
  return window.chartConfig.getEmploymentTypeChartData;
}
function departmentDistributionChartData() {
  return window.chartConfig.getDepartmentDistributionChartData;
}
function ageDistributionChartData() {
  return window.chartConfig.getAgeDistributionChartData;
}
function educationAndExperienceChartData() {
  return window.chartConfig.getEducationAndExperienceChartData;
}
function averageWorkingHoursChartData() {
  return window.chartConfig.getAverageWorkingHoursChartData;
}

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!*********************************!*\
  !*** ./resources/js/chartjs.js ***!
  \*********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _chartConfig_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./chartConfig.js */ "./resources/js/chartConfig.js");

var getGenderAndMaritalStatusChartData = (0,_chartConfig_js__WEBPACK_IMPORTED_MODULE_0__.genderAndMaritalStatusChartData)();
var getGenderAndPositionsChartData = (0,_chartConfig_js__WEBPACK_IMPORTED_MODULE_0__.genderAndPositionsChartData)();
var getEmploymentTypeChartData = (0,_chartConfig_js__WEBPACK_IMPORTED_MODULE_0__.employmentTypeChartData)();
var getDepartmentDistributionChartData = (0,_chartConfig_js__WEBPACK_IMPORTED_MODULE_0__.departmentDistributionChartData)();
var getAgeDistributionChartData = (0,_chartConfig_js__WEBPACK_IMPORTED_MODULE_0__.ageDistributionChartData)();
var getEducationAndExperienceChartData = (0,_chartConfig_js__WEBPACK_IMPORTED_MODULE_0__.educationAndExperienceChartData)();
var getAverageWorkingHoursChartData = (0,_chartConfig_js__WEBPACK_IMPORTED_MODULE_0__.averageWorkingHoursChartData)();
/* First row
Marital status chart */

var genderAndMaritalStatusChartDataCtx = document.getElementById('genderChart').getContext('2d');
var genderAndMaritalStatusChartDataData = {
  labels: getGenderAndMaritalStatusChartData.label,
  datasets: [{
    data: getGenderAndMaritalStatusChartData.chartData,
    backgroundColor: ['rgb(54,162,235, 0.85)', 'rgb(54,162,235)', 'rgb(255,99,132, 0.75)', 'rgb(255,99,132)'],
    borderColor: ['rgb(54,162,235, 0.85)', 'rgb(54,162,235)', 'rgb(255,99,132, 0.80)', 'rgb(255,99,132)']
  }]
};
setTimeout(function () {
  var genderChart = new Chart(genderAndMaritalStatusChartDataCtx, {
    type: 'pie',
    data: genderAndMaritalStatusChartDataData,
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top'
        },
        title: {
          display: true,
          position: 'bottom',
          text: 'Marital status by gender'
        }
      }
    }
  });
}, 1750); //Years of experience chart

var educationAndExperienceChartCtx = document.getElementById('educationExperienceChart').getContext('2d');
var colorPalette = ['rgb(103,151,162,0.50)', 'rgb(147,216,231)', 'rgb(255,99,132)'];
var datasets = getEducationAndExperienceChartData.degreeTypes.map(function (degree, index) {
  return {
    label: degree,
    data: getEducationAndExperienceChartData.experienceRanges.map(function (range) {
      return getEducationAndExperienceChartData.chartData[range][degree];
    }),
    backgroundColor: colorPalette[index]
  };
});
setTimeout(function () {
  var stackedBarChart = new Chart(educationAndExperienceChartCtx, {
    type: 'bar',
    data: {
      labels: getEducationAndExperienceChartData.experienceRanges,
      datasets: datasets
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top'
        },
        title: {
          display: true,
          position: 'bottom',
          text: 'Distribution of educational level by experience range'
        }
      },
      scales: {
        x: {
          stacked: true
        },
        y: {
          stacked: true,
          beginAtZero: true
        }
      }
    }
  });
}, 1750); // Employment type chart

var employmentTypeCtx = document.getElementById('employmentTypeChart').getContext('2d');
var employmentTypeData = {
  labels: getEmploymentTypeChartData.label,
  datasets: [{
    label: 'Employment Type',
    data: getEmploymentTypeChartData.chartData,
    backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 206, 86)', 'rgb(75, 192, 192)']
  }]
};
setTimeout(function () {
  var employmentTypeChart = new Chart(employmentTypeCtx, {
    type: 'doughnut',
    data: employmentTypeData,
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top'
        },
        title: {
          display: true,
          position: 'bottom',
          text: 'Population distribution by employment'
        }
      }
    }
  });
}, 1750);
/* Second row
Gender distribution chart */

var genderDistributionCtx = document.getElementById('genderDistribution').getContext('2d');
var positions = getGenderAndPositionsChartData.positions;
var colorOpacity = 0.2;
var genderColors = {
  male: '54, 162, 235',
  female: '255, 99, 132'
};
var genderDistributionData = {
  labels: getGenderAndPositionsChartData.label,
  datasets: positions.map(function (position, index) {
    var maleBackgroundColor = "rgba(".concat(genderColors.male, ", ").concat(1 - index * colorOpacity, ")");
    var femaleBackgroundColor = "rgba(".concat(genderColors.female, ", ").concat(1 - index * colorOpacity, ")");
    return {
      label: position,
      data: getGenderAndPositionsChartData.data[position],
      backgroundColor: [maleBackgroundColor, femaleBackgroundColor]
    };
  })
};
setTimeout(function () {
  var genderDistributionChart = new Chart(genderDistributionCtx, {
    type: 'bar',
    data: genderDistributionData,
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top'
        },
        title: {
          display: true,
          position: 'bottom',
          text: 'Gender distribution based on position'
        }
      },
      scales: {
        x: {
          stacked: true
        },
        y: {
          stacked: true
        }
      }
    }
  });
}, 2500); //Age distribution chart

var ageDistributionCtx = document.getElementById('ageDistributionChart').getContext('2d');
var ageDistributionData = {
  labels: getAgeDistributionChartData.labels,
  datasets: [{
    label: 'Both',
    data: getAgeDistributionChartData.data.both,
    borderColor: 'rgb(75, 192, 192)',
    backgroundColor: 'rgba(75, 192, 192, 0.2)',
    fill: true
  }, {
    label: 'Female',
    data: getAgeDistributionChartData.data.female,
    borderColor: 'rgb(255, 99, 132)',
    backgroundColor: 'rgba(255, 99, 132, 0.2)',
    fill: true
  }, {
    label: 'Male',
    data: getAgeDistributionChartData.data.male,
    borderColor: 'rgb(54, 162, 235)',
    backgroundColor: 'rgba(54, 162, 235, 0.2)',
    fill: true
  }]
};
setTimeout(function () {
  var ageDistributionChart = new Chart(ageDistributionCtx, {
    type: 'line',
    data: ageDistributionData,
    options: {
      plugins: {
        legend: {
          position: 'top'
        },
        title: {
          display: true,
          position: 'bottom',
          text: 'Age distribution based on gender'
        }
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
      }
    }
  });
}, 2500);
/* Third row
// Department distribution chart */

var departmentDistributionCtx = document.getElementById('departmentDistributionChart').getContext('2d');
var departmentDistributionData = {
  labels: getDepartmentDistributionChartData.label,
  datasets: [{
    label: 'Departmental Contribution',
    data: getDepartmentDistributionChartData.chartData,
    backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 206, 86)', 'rgb(75, 192, 192)', 'rgb(153, 102, 255)', 'rgb(255, 159, 64)', 'rgb(255, 192, 203)', 'rgb(0, 128, 0)', 'rgb(255, 255, 0)', 'rgb(128, 0, 0)', 'rgb(139, 0, 139)', 'rgb(0, 255, 255)', 'rgb(0, 0, 128)', 'rgb(128, 0, 0)', 'rgb(169, 169, 169)']
  }]
};
setTimeout(function () {
  var departmentContributionChart = new Chart(departmentDistributionCtx, {
    type: 'polarArea',
    data: departmentDistributionData,
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top'
        },
        title: {
          display: true,
          position: 'bottom',
          text: 'Population distribution based on department'
        }
      },
      animation: {
        animateRotate: true,
        animateScale: true
      }
    }
  });
}, 3000); // Average Working Hours Chart

var departmentAverageWorkingHoursCtx = document.getElementById('departmentAverageWorkingHours').getContext('2d');
var data = getAverageWorkingHoursChartData.chartData;

function getChartData(data, key) {
  return getAverageWorkingHoursChartData.labels.map(function (label) {
    return parseFloat(data[label][key]);
  });
}

var departmentAverageWorkingHoursData = {
  labels: getAverageWorkingHoursChartData.labels,
  datasets: [{
    label: 'Average Working Hours',
    data: getChartData(data, 'average'),
    backgroundColor: 'rgb(103,151,162, 0.4)',
    borderColor: 'rgb(103,151,162, 0.75)',
    borderWidth: 1
  }, {
    label: 'Total Working Hours',
    data: getChartData(data, 'total_hours'),
    backgroundColor: 'rgb(255,99,132, 0.2)',
    borderColor: 'rgb(255,99,132, 0.75)',
    borderWidth: 1
  }, {
    label: 'Number of personnel',
    data: getChartData(data, 'user_count'),
    backgroundColor: 'rgb(255,134,99)',
    borderColor: 'rgb(255,134,99, 0.75)',
    borderWidth: 1
  }]
};
setTimeout(function () {
  var departmentAverageWorkingHours = new Chart(departmentAverageWorkingHoursCtx, {
    type: 'radar',
    data: departmentAverageWorkingHoursData,
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top'
        },
        title: {
          display: true,
          position: 'bottom',
          text: 'Average Working Hours of Departments'
        }
      },
      animation: {
        duration: 2000,
        easing: 'easeInOutQuad'
      },
      scales: {
        r: {
          beginAtZero: true
        }
      }
    }
  });
}, 3000);
})();

/******/ })()
;