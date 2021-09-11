function deleteUser(e, id) {
    e.preventDefault();
    if (confirm("Confirmer la suppression ?")) {
        window.location.href = "/user/"+ id +"/delete";
    }
}