document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.querySelector(".dropdown-toggle");
    const parent = document.querySelector(".dropdown-parent");

    toggle.addEventListener("click", function (e) {
        e.preventDefault();
        parent.classList.toggle("active");
    });
    document.addEventListener("click", function (e) {
        if (!parent.contains(e.target)) {
            parent.classList.remove("active");
        }
    });
});

function confirmLogout() {
    return confirm("Are you sure you want to logout?");
}

function confirmDelete(alertId) {
    if (confirm('Delete this alert?')) {
        // Create a form and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/alerts/${alertId}`;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}
