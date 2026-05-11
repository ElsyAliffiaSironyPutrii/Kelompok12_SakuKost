function checkRole() {
    const role = document.getElementById('role').value;
    const regLink = document.getElementById('reg-link');
    if(regLink) {
        regLink.style.display = (role === 'user') ? 'block' : 'none';
    }
}

function login() {
    const role = document.getElementById('role').value;
    if(role === 'admin') {
        window.location.href = 'admin.html';
    } else {
        window.location.href = 'user.html';
    }
}

function logout() {
    window.location.href = 'index.html';
}

function showPage(pageId) {
    document.querySelectorAll('.page').forEach(p => p.style.display = 'none');
    const target = document.getElementById(pageId);
    if(target) target.style.display = 'block';
}