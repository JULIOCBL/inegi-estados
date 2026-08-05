document.addEventListener('DOMContentLoaded', () => {
    const per_page_select = document.querySelector('#per_page');

    if (!per_page_select) {
        return;
    }

    per_page_select.addEventListener('change', () => {
        per_page_select.form?.submit();
    });
});
