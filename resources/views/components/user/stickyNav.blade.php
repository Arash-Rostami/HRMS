<nav id="mainNav"
     x-data="{
                visible: false,
                version: false,
                text: '',
                position: {x: 0, y: 0},
                showTooltip(message, event) {
                    this.text = message;
                    this.position = {
                        x: event.clientX,
                        y: event.clientY + 35
                    };
                    this.visible = true;
                },
                hideTooltip() {
                    this.visible = false;
                    this.text = '';
                },
                easeInOutCubic(t) {
                    return t < 0.5
                        ? 4 * t * t * t
                        : 1 - Math.pow(-2 * t + 2, 3) / 2;
                },
                animateScroll(start, end, duration, callback) {
                    const startTime = performance.now();
                    const animate = (currentTime) => {
                        const elapsed = currentTime - startTime;
                        const progress = Math.min(elapsed / duration, 1);
                        const ease = this.easeInOutCubic(progress);
                        const currentPosition = start + (end - start) * ease;
                        window.scrollTo(0, currentPosition);
                        if (progress < 1) {
                            requestAnimationFrame(animate);
                        } else {
                            if (callback) callback();
                        }
                    };
                    requestAnimationFrame(animate);
                },
                scrollToSection(target) {
                    const el = document.querySelector(target);
                    if (!el) {
                        return;
                    }
                    const start = window.pageYOffset;
                    const rect = el.getBoundingClientRect();
                    const end = start + rect.top - 80;
                    const duration = 800;

                    this.animateScroll(start, end, duration);
                }
            }"
     x-show="!version"
     class="{{ isDarkMode() ? 'bg-gray-800' : 'bg-gray-200'}} shadow-md py-2 px-4 sticky top-0 z-50 transition duration-300 scrollbar-hide animate-[fade-in-left_1s_ease-in-out]">
    <div id="navContainer"
         class="w-full md:container md:mx-auto flex items-center justify-start space-x-6 overflow-x-auto overflow-y-hidden scrollbar-hide px-4 relative">
        {{-- Admin Panel Icon --}}
        @if (isAdmin(auth()->user()))
            <div class="flex flex-col items-center text-center">
                <a href="/main/admin"
                   @mouseenter="window.innerWidth > 768 && showTooltip('Navigate to the Admin Panel', $event)"
                   @mouseleave="hideTooltip()"
                   class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                    <i class="fas fa-cogs"></i>
                </a>
                <span class="mt-1 text-sm  {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700'}}">Admin</span>
            </div>
        @endif
        {{-- Parking Icon --}}
        <div class="flex flex-col items-center text-center">
            <a href="{{ route('dashboard',['type'=>'parking']) }}"
               @mouseenter="window.innerWidth > 768 && showTooltip('Reserve a Parking Spot or Search for Available Spaces', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class="fas fa-parking"></i>
            </a>
            <span class="mt-1 text-sm {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700'}}">Parking</span>
        </div>
        {{-- Calendar Icon --}}
        <div class="flex flex-col items-center text-center">
            <a @click.prevent="scrollToSection('#calendar')"
               @mouseenter="window.innerWidth > 768 && showTooltip('View Events, Birthdays, and Anniversaries', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110 cursor-pointer">
                <i class="fas fa-calendar-alt"></i>
            </a>
            <span class="mt-1 text-sm {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700'}}">Calendar</span>
        </div>
        {{-- Bulletin Icon --}}
        <div class="flex flex-col items-center text-center">
            <a @click.prevent="scrollToSection('#bulletin')"
               @mouseenter="window.innerWidth > 768 && showTooltip('View HR Pinned and New Posts', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110 cursor-pointer">
                <i class="fa fa-newspaper-o"></i>
            </a>
            <span class="mt-1 text-sm {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700'}}">Bulletin</span>
        </div>
        {{-- Personnel Icon --}}
        <div class="flex flex-col items-center text-center">
            <a @click="scrollToSection('#personnel')"
               @mouseenter="window.innerWidth > 768 && showTooltip('View Personnel Status and Contact Information', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110 cursor-pointer">
                <i class="fas fa-users"></i>
            </a>
            <span class="mt-1 text-sm {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700'}}">Personnel</span>
        </div>
        {{-- Report Icon --}}
        <div class="flex flex-col items-center text-center">
            <a @click="scrollToSection('#report')"
               @mouseenter="window.innerWidth > 768 && showTooltip('View Departmental Reports', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110 cursor-pointer">
                <i class="fas fa-chart-line"></i>
            </a>
            <span class="mt-1 text-sm {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700'}}">Reports</span>
        </div>
        {{-- Tools Icon --}}
        <div class="flex flex-col items-center text-center">
            <a @click="scrollToSection('#tools')"
               @mouseenter="window.innerWidth > 768 && showTooltip('Access Applications and External Links', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110 cursor-pointer">
                <i class="fas fa-external-link-alt"></i>
            </a>
            <span class="mt-1 text-sm {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700'}}">Tools</span>
        </div>
        {{-- Links Icon --}}
        <div class="flex flex-col items-center text-center">
            <a @click="scrollToSection('#links')"
               @mouseenter="window.innerWidth > 768 && showTooltip('Access Internal Links', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110 cursor-pointer">
                <i class="fas fa-link"></i>
            </a>
            <span class="mt-1 text-sm {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700'}}">Links</span>
        </div>
        {{-- FAQ Icon --}}
        <div class="flex flex-col items-center text-center">
            <a @click="scrollToSection('#faq')"
               @mouseenter="window.innerWidth > 768 && showTooltip('View Frequently Asked Questions', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110 cursor-pointer">
                <i class="fas fa-question-circle"></i>
            </a>
            <span class="mt-1 text-sm {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700'}}">FAQ</span>
        </div>
        {{-- Suggestion Icon --}}
        <div class="flex flex-col items-center text-center relative">
            <a href="{{ route('user.panel.suggestion') }}"
               @mouseenter="window.innerWidth > 768 && showTooltip('Submit or View Your Suggestions', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class="fa fa-bullhorn"></i>
            </a>
            @if(showSuggestionBadge())
                <span
                    @mouseenter="window.innerWidth > 768 && showTooltip('View Your In-Progress Suggestions and Logs', $event)"
                    @mouseleave="hideTooltip()"
                    class="absolute top-0 right-0 w-6 h-6 bg-red-600 text-white text-xs font-bold text-center rounded-full flex items-center justify-center cursor-help">
                    {{ showSuggestionBadgeNumber() }}
                </span>
            @elseif(showSuggestionCEOBadge())
                <span
                    @mouseenter="window.innerWidth > 768 && showTooltip('View All Suggestions', $event)"
                    @mouseleave="hideTooltip()"
                    class="absolute top-0 right-0 w-6 h-6 bg-orange-500 text-white text-xs font-bold text-center rounded-full flex items-center justify-center cursor-help">
                    {{ showSuggestionCEOBadgeNumber() }}
                </span>
            @endif
            <span class="mt-1 text-sm {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700'}}">Suggestions</span>
        </div>
        {{-- DMS Icon --}}
        <div class="flex flex-col items-center text-center relative">
            <a href="{{ route('user.panel.dms') }}"
               @mouseenter="window.innerWidth > 768 && showTooltip('View & Sign Official Documents Published', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class="fa fa-archive"></i>
            </a>
            @if(getUnsignedDocCount() > 0)
                <span
                    @mouseenter="window.innerWidth > 768 && showTooltip('Sign Pending Documents', $event)"
                    @mouseleave="hideTooltip()"
                    class="absolute top-0 right-0 w-6 h-6 bg-red-600 text-white text-xs font-bold text-center rounded-full flex items-center justify-center cursor-help">
                    {{ getUnsignedDocCount() }}
                </span>
            @elseif(getUnreadDocCount() > 0)
                <span
                    @mouseenter="window.innerWidth > 768 && showTooltip('Record Your View on Documents', $event)"
                    @mouseleave="hideTooltip()"
                    class="absolute top-0 right-0 w-6 h-6 bg-orange-500 text-white text-xs font-bold text-center rounded-full flex items-center justify-center cursor-help">
                    {{ getUnreadDocCount() }}
                </span>
            @endif
            <span class="mt-1 text-sm {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700'}}">Documents</span>
        </div>
        {{-- THS Icon --}}
        <div class="flex flex-col items-center text-center relative">
            <a href="{{ route('user.panel.ths') }}"
               @mouseenter="window.innerWidth > 768 && showTooltip('Submit Support or Access Tickets', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class="fas fa-ticket-alt"></i>
            </a>
            @if(getOpenTicketCount() > 0)
                <span
                    @mouseenter="window.innerWidth > 768 && showTooltip('View Unattended Tickets', $event)"
                    @mouseleave="hideTooltip()"
                    class="absolute top-0 right-0 w-6 h-6 bg-red-600 text-white text-xs font-bold text-center rounded-full flex items-center justify-center cursor-help">
                    {{ getOpenTicketCount() }}
                </span>
            @elseif(getInProgressTicketCount() > 0)
                <span
                    @mouseenter="window.innerWidth > 768 && showTooltip('View In-Progress Tickets', $event)"
                    @mouseleave="hideTooltip()"
                    class="absolute top-0 right-0 w-6 h-6 bg-orange-500 text-white text-xs font-bold text-center rounded-full flex items-center justify-center cursor-help">
                    {{ getInProgressTicketCount() }}
                </span>
            @endif
            <span class="mt-1 text-sm {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700'}}">Tickets</span>
        </div>
        {{-- Profile Edit Icon --}}
        <div class="flex flex-col items-center text-center">
            <a href="{{ route('user.panel.edit') }}"
               @mouseenter="window.innerWidth > 768 && showTooltip('View and Edit Your Profile', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class="fas fa-portrait"></i>
            </a>
            <span class="mt-1 text-sm {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700'}}">Profile</span>
        </div>
        {{-- Delegation Panel Icon --}}
        <div class="flex flex-col items-center text-center">
            <a href="{{ route('user.panel.delegation') }}"
               @mouseenter="window.innerWidth > 768 && showTooltip('View Departmental Authorities Delegated', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class='fas fa-tasks'></i>
            </a>
            <span class="mt-1 text-sm {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700'}}">Authorities</span>
        </div>
        {{-- Onboarding Icon --}}
        <div class="flex flex-col items-center text-center">
            <a href="{{ route('user.panel.onboarding') }}"
               @mouseenter="window.innerWidth > 768 && showTooltip('View Onboarding Stages', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class="fa fa-road"></i>
            </a>
            <span class="mt-1 text-sm {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700'}}">Onboarding</span>
        </div>
        {{-- Analytics Icon --}}
        <div class="flex flex-col items-center text-center">
            <a href="{{ route('user.panel.analytics') }}"
               @mouseenter="window.innerWidth > 768 && showTooltip('View General Statistics of Your Workplace', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class="fas fa-chart-bar"></i>
            </a>
            <span class="mt-1 text-sm {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700'}}">Analytics</span>
        </div>
        {{-- Music Icon --}}
        <div class="flex flex-col items-center text-center">
            <a href="{{ route('user.panel.music') }}"
               @mouseenter="window.innerWidth > 768 && showTooltip('Browse Track Playlists and Enjoy Music', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class="fa fa-headphones"></i>
            </a>
            <span class="mt-1 text-sm {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700'}}">Music</span>
        </div>
        {{-- CRM Icon --}}
        <div class="flex flex-col items-center text-center">
            <a href="{{ route('crm') }}"
               @mouseenter="window.innerWidth > 768 && showTooltip('Generate Customized CRM Reports', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class="fas fa-database"></i>
            </a>
            <span class="mt-1 text-sm {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700'}}">CRM</span>
        </div>
        {{-- Office Icon --}}
        <div class="flex flex-col items-center text-center">
            <a href="{{ route('dashboard',['type'=>'office']) }}"
               @mouseenter="window.innerWidth > 768 && showTooltip('Reserve an Office Desk or Search for Colleagues', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class="fas fa-building"></i>
            </a>
            <span class="mt-1 text-sm {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700'}}">Office</span>
        </div>
        {{-- Calculator Icon --}}
        <div class="flex flex-col items-center text-center cursor-pointer">
            <a id="openCalculator"
               @mouseenter="window.innerWidth > 768 && showTooltip('Perform Calculations Without Leaving the Page', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class="fas fa-calculator"></i>
            </a>
            <span class="mt-1 text-sm {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700'}}">Calculator</span>
        </div>
        {{-- Audio Timer Icon --}}
        <div class="flex flex-col items-center text-center cursor-pointer">
            <a id="playAudioButton"
               @mouseenter="window.innerWidth > 768 && showTooltip('Set a Music Timer as a Smart Reminder', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i id="clockIcon" class="fas fa-clock"></i>
            </a>
            <span class="mt-1 text-sm {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700'}}">Timer</span>
        </div>
        {{-- Slogan Icon --}}
        <div class="flex flex-col items-center text-center cursor-pointer">
            <a id="sloganLink"
               @mouseenter="window.innerWidth > 768 && showTooltip('View Workplace Principles', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-5 py-2 bg-main-mode text-xl text-white rounded shadow-lg"
            >
                <i class="fas fa-lightbulb"></i>
            </a>
            <span class="mt-1 text-sm {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700'}}">Slogan</span>
        </div>
    </div>
    <x-user.navbar-tooltip/>
</nav>
<div id="sloganModal"
     class="fixed inset-0 hidden z-50 bg-gray-500 bg-opacity-75 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
        <p class="text-gray-500"></p>
    </div>
</div>
<x-user.calculator/>
{{--<style>--}}
{{--    [draggable="true"] {--}}
{{--        cursor: grab;--}}
{{--        user-select: none; /* Prevent text selection while dragging */--}}
{{--        transition: opacity 0.2s ease-in-out; /* Smooth opacity change */--}}
{{--    }--}}
{{--    .dragging-item {--}}
{{--        opacity: 0.4 !important; /* Style for the item being dragged */--}}
{{--        cursor: grabbing !important;--}}
{{--    }--}}
{{--    /* Visual cue for drop target position */--}}
{{--    .drop-target-before {--}}
{{--        box-shadow: -3px 0 0 0 #3b82f6; /* blue-500 shadow */--}}
{{--    }--}}
{{--    .drop-target-after {--}}
{{--        box-shadow: 3px 0 0 0 #3b82f6; /* blue-500 shadow */--}}
{{--    }--}}
{{--</style>--}}

{{--<script>--}}
{{--    document.addEventListener('DOMContentLoaded', () => {--}}
{{--        const navContainer = document.getElementById('navContainer');--}}
{{--        if (!navContainer) {--}}
{{--            console.error('Navbar container (#navContainer) not found.');--}}
{{--            return;--}}
{{--        }--}}

{{--        // Helper function to get a unique ID for an item based on its text--}}
{{--        function getItemDataId(itemElement) {--}}
{{--            const span = itemElement.querySelector('span');--}}
{{--            // Attempt to get text. If span or text is missing, try to find text in 'a' tag's tooltip or a default.--}}
{{--            let text = span ? span.textContent.trim() : '';--}}
{{--            if (!text) {--}}
{{--                const aTag = itemElement.querySelector('a');--}}
{{--                if (aTag) {--}}
{{--                    const tooltipText = aTag.getAttribute('x-tooltip') || aTag.getAttribute('title'); // Example, adjust if tooltips are different--}}
{{--                    if (tooltipText) text = tooltipText.trim().split(' ')[0]; // Take first word of tooltip--}}
{{--                }--}}
{{--            }--}}
{{--            return text ? text.toLowerCase().replace(/\s+/g, '-') : null;--}}
{{--        }--}}

{{--        // Initialize items for drag-and-drop--}}
{{--        let items = Array.from(navContainer.children);--}}

{{--        function initializeItems() {--}}
{{--            items = Array.from(navContainer.children); // Re-query to get current items--}}
{{--            items.forEach((item, index) => {--}}
{{--                const itemDataId = getItemDataId(item);--}}
{{--                // Use data-id for localStorage key, and a unique DOM id for dataTransfer--}}
{{--                if (itemDataId) {--}}
{{--                    item.dataset.id = itemDataId;--}}
{{--                } else {--}}
{{--                    // Fallback if a meaningful data-id cannot be generated--}}
{{--                    item.dataset.id = `navitem-${index}`;--}}
{{--                }--}}
{{--                item.id = `draggable-${item.dataset.id}`; // Unique DOM ID for dnd operations--}}
{{--                item.setAttribute('draggable', 'true');--}}
{{--            });--}}
{{--        }--}}

{{--        // Load and apply saved order from localStorage--}}
{{--        function loadOrder() {--}}
{{--            const savedOrderJson = localStorage.getItem('navbarOrder');--}}
{{--            if (savedOrderJson) {--}}
{{--                try {--}}
{{--                    const savedOrderIds = JSON.parse(savedOrderJson);--}}
{{--                    const currentItemsMap = new Map();--}}

{{--                    // Ensure items are initialized before creating the map--}}
{{--                    // (initializeItems() might have already run, but this ensures dataset.id is set)--}}
{{--                    items.forEach(item => {--}}
{{--                        if (!item.dataset.id) { // Ensure data-id if somehow missed--}}
{{--                            const itemDataId = getItemDataId(item) || `navitem-${Array.from(navContainer.children).indexOf(item)}`;--}}
{{--                            item.dataset.id = itemDataId;--}}
{{--                        }--}}
{{--                        currentItemsMap.set(item.dataset.id, item);--}}
{{--                    });--}}

{{--                    const fragment = document.createDocumentFragment();--}}
{{--                    let orderedItemsCount = 0;--}}

{{--                    // Append items in saved order--}}
{{--                    savedOrderIds.forEach(id => {--}}
{{--                        if (currentItemsMap.has(id)) {--}}
{{--                            fragment.appendChild(currentItemsMap.get(id));--}}
{{--                            currentItemsMap.delete(id); // Remove from map as it's placed--}}
{{--                            orderedItemsCount++;--}}
{{--                        }--}}
{{--                    });--}}

{{--                    // Append any new items (not in saved order) or items whose IDs changed/weren't mapped--}}
{{--                    currentItemsMap.forEach(item => {--}}
{{--                        fragment.appendChild(item);--}}
{{--                    });--}}

{{--                    if (orderedItemsCount > 0 || currentItemsMap.size > 0) {--}}
{{--                        // Clear container and append re-ordered items--}}
{{--                        while (navContainer.firstChild) {--}}
{{--                            navContainer.removeChild(navContainer.firstChild);--}}
{{--                        }--}}
{{--                        navContainer.appendChild(fragment);--}}
{{--                    }--}}
{{--                } catch (e) {--}}
{{--                    console.error('Error parsing or applying saved navbar order:', e);--}}
{{--                    localStorage.removeItem('navbarOrder'); // Clear corrupted data--}}
{{--                }--}}
{{--            }--}}
{{--            // After loading order (or if no order), ensure all items are properly set up--}}
{{--            initializeItems(); // This re-initializes `items` array and attributes--}}
{{--        }--}}

{{--        // Save current order to localStorage--}}
{{--        function saveOrder() {--}}
{{--            const currentOrderIds = Array.from(navContainer.children)--}}
{{--                .map(item => item.dataset.id)--}}
{{--                .filter(id => id); // Filter out any undefined/null ids--}}
{{--            if (currentOrderIds.length > 0) {--}}
{{--                localStorage.setItem('navbarOrder', JSON.stringify(currentOrderIds));--}}
{{--            }--}}
{{--        }--}}

{{--        let draggedItem = null; // The actual DOM element being dragged--}}

{{--        // Attach D&D event listeners--}}
{{--        function attachDragDropListeners() {--}}
{{--            items.forEach(item => {--}}
{{--                // Remove existing listeners before adding, to prevent duplicates if this function is called multiple times--}}
{{--                item.removeEventListener('dragstart', handleDragStart);--}}
{{--                item.addEventListener('dragstart', handleDragStart);--}}

{{--                item.removeEventListener('dragend', handleDragEnd);--}}
{{--                item.addEventListener('dragend', handleDragEnd);--}}

{{--                item.removeEventListener('dragover', handleDragOver);--}}
{{--                item.addEventListener('dragover', handleDragOver);--}}

{{--                item.removeEventListener('dragleave', handleDragLeave);--}}
{{--                item.addEventListener('dragleave', handleDragLeave);--}}

{{--                item.removeEventListener('drop', handleDrop);--}}
{{--                item.addEventListener('drop', handleDrop);--}}
{{--            });--}}
{{--        }--}}

{{--        function handleDragStart(event) {--}}
{{--            draggedItem = event.target.closest('[draggable="true"]');--}}
{{--            if (!draggedItem) return;--}}

{{--            event.dataTransfer.setData('text/plain', draggedItem.id);--}}
{{--            event.dataTransfer.effectAllowed = 'move';--}}

{{--            setTimeout(() => { // Ensures drag image is generated before style change--}}
{{--                if (draggedItem) draggedItem.classList.add('dragging-item');--}}
{{--            }, 0);--}}
{{--        }--}}

{{--        function handleDragEnd() {--}}
{{--            if (draggedItem) {--}}
{{--                draggedItem.classList.remove('dragging-item');--}}
{{--            }--}}
{{--            // Clean up all drop indicator classes from all items--}}
{{--            items.forEach(i => {--}}
{{--                i.classList.remove('drop-target-before', 'drop-target-after');--}}
{{--            });--}}
{{--            draggedItem = null;--}}
{{--            saveOrder(); // Save order after drag operation concludes--}}
{{--        }--}}

{{--        function handleDragOver(event) {--}}
{{--            event.preventDefault();--}}
{{--            event.dataTransfer.dropEffect = 'move';--}}

{{--            const currentOverItem = event.target.closest('[draggable="true"]');--}}
{{--            if (!currentOverItem || currentOverItem === draggedItem) {--}}
{{--                items.forEach(i => { // Clear indicators from others if not over a valid target or over itself--}}
{{--                    if (i !== currentOverItem) i.classList.remove('drop-target-before', 'drop-target-after');--}}
{{--                });--}}
{{--                return;--}}
{{--            }--}}

{{--            // Clear indicators from all other items before setting on current target--}}
{{--            items.forEach(i => {--}}
{{--                if (i !== currentOverItem) {--}}
{{--                    i.classList.remove('drop-target-before', 'drop-target-after');--}}
{{--                }--}}
{{--            });--}}

{{--            const rect = currentOverItem.getBoundingClientRect();--}}
{{--            const offsetX = event.clientX - rect.left;--}}

{{--            if (offsetX < rect.width / 2) {--}}
{{--                currentOverItem.classList.add('drop-target-before');--}}
{{--                currentOverItem.classList.remove('drop-target-after');--}}
{{--            } else {--}}
{{--                currentOverItem.classList.add('drop-target-after');--}}
{{--                currentOverItem.classList.remove('drop-target-before');--}}
{{--            }--}}
{{--        }--}}

{{--        function handleDragLeave(event) {--}}
{{--            const leftItem = event.target.closest('[draggable="true"]');--}}
{{--            if (leftItem && (!event.relatedTarget || !leftItem.contains(event.relatedTarget))) {--}}
{{--                leftItem.classList.remove('drop-target-before', 'drop-target-after');--}}
{{--            }--}}
{{--        }--}}

{{--        function handleDrop(event) {--}}
{{--            event.preventDefault();--}}
{{--            if (!draggedItem) return;--}}

{{--            const targetItem = event.target.closest('[draggable="true"]');--}}

{{--            // Clean up all visual indicators--}}
{{--            items.forEach(i => {--}}
{{--                i.classList.remove('drop-target-before', 'drop-target-after');--}}
{{--            });--}}
{{--            // Opacity reset is handled by dragend's removal of 'dragging-item'--}}

{{--            const draggedItemDOMId = event.dataTransfer.getData('text/plain');--}}
{{--            const actualDraggedDOMItem = document.getElementById(draggedItemDOMId);--}}

{{--            if (!actualDraggedDOMItem) {--}}
{{--                console.error('Dropped item not found with ID:', draggedItemDOMId);--}}
{{--                if (draggedItem) draggedItem.classList.remove('dragging-item');--}}
{{--                draggedItem = null;--}}
{{--                return;--}}
{{--            }--}}

{{--            if (targetItem && targetItem !== actualDraggedDOMItem) {--}}
{{--                const rect = targetItem.getBoundingClientRect();--}}
{{--                const offsetX = event.clientX - rect.left;--}}

{{--                if (offsetX < rect.width / 2) {--}}
{{--                    navContainer.insertBefore(actualDraggedDOMItem, targetItem);--}}
{{--                } else {--}}
{{--                    navContainer.insertBefore(actualDraggedDOMItem, targetItem.nextSibling);--}}
{{--                }--}}
{{--            } else if (!targetItem && navContainer.contains(event.target)) {--}}
{{--                // If dropped directly on the container (not on an item), append to end--}}
{{--                navContainer.appendChild(actualDraggedDOMItem);--}}
{{--            }--}}
{{--            // If dropped on itself, no reordering needed.--}}

{{--            // Update the `items` array to reflect the new DOM order for subsequent operations--}}
{{--            initializeItems(); // Re-initializes items array and ensures attributes are set--}}
{{--            attachDragDropListeners(); // Re-attach listeners as DOM structure might have changed references for items array--}}
{{--                                       // Or simply update the items array: items = Array.from(navContainer.children);--}}
{{--                                       // However, re-querying and re-initializing + attaching listeners is safer if elements are heavily manipulated.--}}
{{--                                       // Given our current DOM manipulation (insertBefore, appendChild), listeners on the moved element persist.--}}
{{--                                       // So, simply updating `items` should be enough AFTER initializeItems() correctly re-populates it.--}}
{{--            // `saveOrder()` is called in `dragend`.--}}
{{--        }--}}

{{--        // Initial setup--}}
{{--        loadOrder(); // This will also call initializeItems() at the end.--}}
{{--        attachDragDropListeners();--}}
{{--    });--}}
{{--</script>--}}
