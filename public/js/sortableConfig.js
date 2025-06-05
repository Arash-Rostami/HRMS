document.addEventListener('DOMContentLoaded', function () {
    let el = document.getElementById('sortMe');

    Sortable.create(el, {
        animation: 150,
        group: "localStorage-sortables",
        filter: ".ignore-elements",  // Selectors that do not lead to dragging (String or Function)
        store: {
            /**
             * Get the order of elements. Called once during initialization.
             * @param   {Sortable}  sortable
             * @returns {Array}
             */
            get: function (sortable) {
                let order = localStorage.getItem(sortable.options.group.name);
                return order ? order.split('|') : [];
            },

            /**
             * Save the order of elements. Called onEnd (when the item is dropped).
             * @param {Sortable}  sortable
             */
            set: function (sortable) {
                let order = sortable.toArray();
                localStorage.setItem(sortable.options.group.name, order.join('|'));
            }
        },
    });
});
