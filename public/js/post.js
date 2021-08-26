function deletePost(slug) {
    if (confirm("Confirmer la suppression ?")) {
        window.location.href = "/blog/delete-post/" + slug;
    }
}