function loadScript(src, callback) {
    const script = document.createElement("script");
    script.src = src;
    script.async = true;
    script.onload = callback;
    document.head.appendChild(script);
}

//  jQuery
loadScript("https://code.jquery.com/jquery-3.6.3.min.js", function () {
    console.log("jQuery v3.6.3 loaded");
    //  persian-date.js
    loadScript("https://unpkg.com/persian-date@1.1.0/dist/persian-date.js", function () {
        console.log("persian-date.js loaded");

        //  persian-datepicker.js
        loadScript("https://unpkg.com/persian-datepicker@1.2.0/dist/js/persian-datepicker.js", function () {
            console.log("persian-datepicker.js loaded");

            // Datepicker controller
            $(document).ready(function () {
                let to, from, min, remainingDays, toSuspend, fromSuspend, openingHour, now;
                // let remainingDays = (new Date()).getDay() == 6 ? 6 : (5 - (new Date()).getDay());
                openingHour = 21; // 9 PM
                now = new persianDate();
                remainingDays = (now.hour() < openingHour) ? 2 : 3;

                // reservation datepicker controller
                to = $("#to-time").persianDatepicker({
                    initialValue: false,
                    calendar: {
                        persian: {
                            leapYearMode: 'astronomical'
                        }
                    },
                    format: 'YYYY/MM/DD',
                    navigator: {
                        scroll: {
                            enabled: false
                        }
                    },
                    altField: '.to-time-alt',
                    maxDate: (new Date()).getTime() + 60 * 60 * 24 * remainingDays * 1000,
                    minDate: new persianDate().subtract('day', 0).valueOf(),
                    navigator: {
                        enabled: true
                    },
                    monthPicker: {
                        enabled: false,
                    },
                    yearPicker: {
                        enabled: false,
                    },
                    timePicker: {
                        enabled: false,
                        meridiem: {
                            enabled: false
                        },
                        minute: {
                            enabled: false,
                            step: 30
                        },
                        second: {
                            enabled: false
                        }
                    },
                    toolbox: {
                        calendarSwitch: {
                            enabled: false
                        }
                    },
                    // altFormat: 'LLLL',
                    onSelect: function (unix) {
                        to.touched = true;
                        if (from && from.options && from.options.maxDate != unix) {
                            var cachedValue = from.getState().selected.unixDate;
                            from.options = {maxDate: unix};
                            var select = {
                                'date': to.getState().selected['date'],
                                'hour': to.getState().selected['hour'],
                                'month': to.getState().selected['month'],
                                'minute': to.getState().selected['minute'],
                                'year': to.getState().selected['year'],
                                'unix': unix
                            }
                            document.getElementById('to').value = JSON.stringify(select);
                            if (from.touched) {
                                from.setDate(cachedValue);
                            }
                        }
                    }
                });
                from = $("#from-time").persianDatepicker({
                    initialValue: false,
                    calendar: {
                        persian: {
                            leapYearMode: 'astronomical'
                        }
                    },
                    format: 'YYYY/MM/DD',
                    navigator: {
                        scroll: {
                            enabled: false
                        }
                    },
                    altField: '.from-time-alt',
                    maxDate: (new Date()).getTime() + 60 * 60 * 24 * remainingDays * 1000,
                    minDate: new persianDate().subtract('day', 0).valueOf(),
                    navigator: {
                        enabled: true
                    },
                    monthPicker: {
                        enabled: false,
                    },
                    yearPicker: {
                        enabled: false,
                    },
                    timePicker: {
                        enabled: false,
                        meridiem: {
                            enabled: false
                        },
                        minute: {
                            enabled: false,
                            step: 30
                        },
                        second: {
                            enabled: false
                        }
                    },
                    toolbox: {
                        calendarSwitch: {
                            enabled: false
                        }
                    },
                    altFormat: 'LLLL',
                    onSelect: function (unix) {
                        from.touched = true;
                        if (to && to.options && to.options.minDate != unix) {
                            var cachedValue = to.getState().selected.unixDate;
                            min = unix;
                            to.options = {minDate: unix};
                            var select = {
                                'date': from.getState().selected['date'],
                                'hour': from.getState().selected['hour'],
                                'month': from.getState().selected['month'],
                                'minute': from.getState().selected['minute'],
                                'year': from.getState().selected['year'],
                                'unix': unix
                            }
                            document.getElementById('from').value = JSON.stringify(select);
                            if (to.touched) {
                                to.setDate(cachedValue);
                            }
                        }
                    }
                });

                // suspension datepicker controller
                toSuspend = $("#to-time-suspend").persianDatepicker({
                    initialValue: false,
                    calendar: {
                        persian: {
                            leapYearMode: 'astronomical'
                        }
                    },
                    format: 'YYYY/MM/DD',
                    navigator: {
                        scroll: {
                            enabled: false
                        }
                    },
                    altField: '.to-time-alt',
                    maxDate: (new Date()).getTime() + 60 * 60 * 24 * 6 * 1000,
                    minDate: new persianDate().subtract('day', 0).valueOf(),
                    navigator: {
                        enabled: true
                    },
                    monthPicker: {
                        enabled: false,
                    },
                    yearPicker: {
                        enabled: false,
                    },
                    timePicker: {
                        enabled: false,
                    },
                    toolbox: {
                        calendarSwitch: {
                            enabled: false
                        }
                    },
                    altFormat: 'LLLL',
                    onSelect: function (unix) {
                        toSuspend.touched = true;
                        if (fromSuspend && fromSuspend.options && fromSuspend.options.maxDate != unix) {
                            var cachedValue = fromSuspend.getState().selected.unixDate;
                            fromSuspend.options = {maxDate: unix};
                            var select = {
                                'date': toSuspend.getState().selected['date'],
                                'hour': toSuspend.getState().selected['hour'],
                                'month': toSuspend.getState().selected['month'],
                                'minute': toSuspend.getState().selected['minute'],
                                'year': toSuspend.getState().selected['year'],
                                'unix': unix
                            };
                            document.getElementById('to-suspend').value = JSON.stringify(select);
                            if (fromSuspend.touched) {
                                fromSuspend.setDate(cachedValue);
                            }
                        }
                    }
                });
                fromSuspend = $("#from-time-suspend").persianDatepicker({
                    initialValue: false,
                    calendar: {
                        persian: {
                            leapYearMode: 'astronomical'
                        }
                    },
                    format: 'YYYY/MM/DD',
                    navigator: {
                        scroll: {
                            enabled: false
                        }
                    },
                    altField: '.from-time-alt',
                    maxDate: (new Date()).getTime() + 60 * 60 * 24 * 6 * 1000,
                    minDate: new persianDate().subtract('day', 0).valueOf(),
                    navigator: {
                        enabled: true
                    },
                    monthPicker: {
                        enabled: false,
                    },
                    yearPicker: {
                        enabled: false,
                    },
                    timePicker: {
                        enabled: false,
                    },
                    toolbox: {
                        calendarSwitch: {
                            enabled: false
                        }
                    },
                    // altFormat: 'LLLL',
                    onSelect: function (unix) {
                        fromSuspend.touched = true;
                        if (toSuspend && toSuspend.options && toSuspend.options.minDate != unix) {
                            var cachedValue = toSuspend.getState().selected.unixDate;
                            min = unix;
                            toSuspend.options = {minDate: unix};
                            var select = {
                                'date': fromSuspend.getState().selected['date'],
                                'hour': fromSuspend.getState().selected['hour'],
                                'month': fromSuspend.getState().selected['month'],
                                'minute': fromSuspend.getState().selected['minute'],
                                'year': fromSuspend.getState().selected['year'],
                                'unix': unix
                            };
                            document.getElementById('from-suspend').value = JSON.stringify(select);
                            if (toSuspend.touched) {
                                toSuspend.setDate(cachedValue);
                            }
                        }
                    }
                });
            });
        });
    });
});
