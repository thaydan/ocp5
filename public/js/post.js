function deletePost(e, slug) {
    e.preventDefault();
    if (confirm("Confirmer la suppression ?")) {
        window.location.href = "/blog/delete-post/" + slug;
    }
}

function deleteComment(e, id) {
    e.preventDefault();
    if (confirm("Confirmer la suppression ?")) {
        window.location.href = "/comment/"+ id +"/delete";
    }
}