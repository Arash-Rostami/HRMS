document.addEventListener('click', async function (event) {
    // Check if clicked element is a pagination link
    if (event.target.matches('.pagination a') || event.target.closest('.pagination a')) {
        event.preventDefault();

        const link = event.target.matches('.pagination a') ? event.target : event.target.closest('.pagination a');
        const url = link.getAttribute('href');
        let page = null;
        let table = null;

        if (url.includes('page=')) {
            page = url.split('page=')[1];

            const paginationParent = link.closest('.pagination-posts, .pagination-reports');
            if (paginationParent?.classList.contains('pagination-reports')) {
                table = 'report-table';
            }
            if (paginationParent?.classList.contains('pagination-posts')) {
                table = 'post-table';
            }

            try {
                const response = await fetch('/main?' + new URLSearchParams({page, table}),
                    {
                        method: 'GET',
                        headers: {'X-Requested-With': 'XMLHttpRequest'}
                    });

                if (!response.ok) throw new Error('Network response was not ok');

                const html = await response.text();

                if (table === 'post-table') {
                    document.getElementById('post-list').innerHTML = html;
                } else if (table === 'report-table') {
                    document.getElementById('report-list').innerHTML = html;
                }
            } catch (error) {
                console.error(error);
            }
        }
    }
});
