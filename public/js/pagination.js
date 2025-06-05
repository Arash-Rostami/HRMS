$(document).on('click', '.pagination a', async function (event) {
    event.preventDefault();
    const url = $(this).attr('href');
    let page = null;
    let table = null;

    if (url.includes('page=')) {
        page = url.split('page=')[1];

        const $paginationParent = $(this).closest('.pagination-posts, .pagination-reports');
        if ($paginationParent.hasClass('pagination-reports')) {
            table = 'report-table';
        }
        if ($paginationParent.hasClass('pagination-posts')) {
            table = 'post-table';
        }
        try {
            const response = await $.ajax({
                url: "/main",
                type: "GET",
                data: {page, table},
            });

            if (table === 'post-table') {
                $('#post-list').html(response);
                // $('#pagination-posts').html($(response).find('#pagination-posts').html());
            } else if (table === 'report-table') {
                $('#report-list').html(response);
                // $('#pagination-reports').html($(response).find('#pagination-reports').html());
            }
        } catch (error) {
            console.error(error);
        }
    }
});
