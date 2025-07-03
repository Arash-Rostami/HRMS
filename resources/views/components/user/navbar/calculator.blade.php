<div id="calculatorModal"
     class="fixed top-auto z-10 inset-0 hidden overflow-y-auto bg-gray-500 bg-opacity-75 transition-opacity justify-center">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div
            class="relative @if(isDarkMode()) bg-gray-700 @else bg-white @endif rounded-lg shadow-xl transform transition-all sm:max-w-md w-full">
            <div class="p-6">
                <input type="text" id="display"
                       class="w-full mb-4 border border-gray-300 rounded px-3 py-2 text-2xl text-black text-right"
                       disabled>
                <div class="grid grid-cols-4 gap-2">
                    <button onclick="appendToDisplay('7')"
                            class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 rounded px-3 py-2 text-xl font-bold min-w-[3rem] min-h-[3rem]">
                        7
                    </button>
                    <button onclick="appendToDisplay('8')"
                            class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 rounded px-3 py-2 text-xl font-bold min-w-[3rem] min-h-[3rem]">
                        8
                    </button>
                    <button onclick="appendToDisplay('9')"
                            class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 rounded px-3 py-2 text-xl font-bold min-w-[3rem] min-h-[3rem]">
                        9
                    </button>
                    <button onclick="appendToDisplay('+')"
                            class="bg-orange-500 hover:bg-orange-700 text-white rounded px-3 py-2 text-xl font-bold min-w-[3rem] min-h-[3rem]">
                        +
                    </button>
                    <button onclick="appendToDisplay('4')"
                            class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 rounded px-3 py-2 text-xl font-bold min-w-[3rem] min-h-[3rem]">
                        4
                    </button>
                    <button onclick="appendToDisplay('5')"
                            class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 rounded px-3 py-2 text-xl font-bold min-w-[3rem] min-h-[3rem]">
                        5
                    </button>
                    <button onclick="appendToDisplay('6')"
                            class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 rounded px-3 py-2 text-xl font-bold min-w-[3rem] min-h-[3rem]">
                        6
                    </button>
                    <button onclick="appendToDisplay('-')"
                            class="bg-orange-500 hover:bg-orange-700 text-white rounded px-3 py-2 text-xl font-bold min-w-[3rem] min-h-[3rem]">
                        -
                    </button>
                    <button onclick="appendToDisplay('1')"
                            class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 rounded px-3 py-2 text-xl font-bold min-w-[3rem] min-h-[3rem]">
                        1
                    </button>
                    <button onclick="appendToDisplay('2')"
                            class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 rounded px-3 py-2 text-xl font-bold min-w-[3rem] min-h-[3rem]">
                        2
                    </button>
                    <button onclick="appendToDisplay('3')"
                            class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 rounded px-3 py-2 text-xl font-bold min-w-[3rem] min-h-[3rem]">
                        3
                    </button>
                    <button onclick="appendToDisplay('*')"
                            class="bg-orange-500 hover:bg-orange-700 text-white rounded px-3 py-2 text-xl font-bold min-w-[3rem] min-h-[3rem]">
                        *
                    </button>
                    <button onclick="appendToDisplay('0')"
                            class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 rounded px-3 py-2 text-xl font-bold min-w-[3rem] min-h-[3rem]">
                        0
                    </button>
                    <button onclick="appendToDisplay('.')"
                            class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 rounded px-3 py-2 text-xl font-bold min-w-[3rem] min-h-[3rem]">
                        .
                    </button>
                    <button onclick="calculate()"
                            class="bg-green-500 hover:bg-green-700 text-white rounded px-3 py-2 text-xl font-bold min-w-[3rem] min-h-[3rem]">
                        =
                    </button>
                    <button onclick="clearDisplay()"
                            class="bg-red-500 hover:bg-red-700 text-white rounded px-3 py-2 text-xl font-bold min-w-[3rem] min-h-[3rem]">
                        C
                    </button>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="button" onclick="closeModal()"
                            class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 py-2 px-4 rounded">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const calculatorModal = document.getElementById('calculatorModal');
    const openCalculatorButton = document.getElementById('openCalculator');
    const display = document.getElementById('display');

    if (openCalculatorButton && calculatorModal && display) {
        openCalculatorButton.addEventListener('click', () => {
            calculatorModal.classList.remove('hidden');
            calculatorModal.classList.add('flex');
        });
        document.addEventListener('keydown', function (event) {
            if (event.key === "Escape" && calculatorModal.classList.contains('flex')) {
                closeModal();
            }
        });

        function closeModal() {
            calculatorModal.classList.remove('flex');
            calculatorModal.classList.add('hidden');
            display.value = '';
        }

        function appendToDisplay(value) {
            display.value += value;
        }

        function calculate() {
            try {
                const calculation = new Function('return ' + display.value);
                display.value = calculation();
            } catch (error) {
                display.value = 'Error';
                console.error("Calculation Error:", error)
            }
        }

        function clearDisplay() {
            display.value = '';
        }

        window.closeModal = closeModal;
        window.appendToDisplay = appendToDisplay;
        window.calculate = calculate;
        window.clearDisplay = clearDisplay;
    } else {
        console.error("Calculator elements not found!");
    }
</script>
