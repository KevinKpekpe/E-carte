let socialLinkCount = 1;

document.getElementById('add-social-link').addEventListener('click', function () {
    const socialLinksDiv = document.getElementById('social-links');
    const newSocialLink = `
                <div class="social-link-item mb-2">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text"
                                   class="form-control"
                                   name="social_links[${socialLinkCount}][platform]"
                                   placeholder="Plateforme">
                        </div>
                        <div class="col-md-8">
                            <input type="url"
                                   class="form-control"
                                   name="social_links[${socialLinkCount}][url]"
                                   placeholder="URL">
                        </div>
                    </div>
                </div>
            `;
    socialLinksDiv.insertAdjacentHTML('beforeend', newSocialLink);
    socialLinkCount++;
});


document.addEventListener('DOMContentLoaded', function () {
    let searchTimeout;
    const searchInput = document.getElementById('search');
    const form = searchInput.closest('form');

    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            form.submit();
        }, 500); // Délai de 500ms avant de soumettre le formulaire
    });

    // Pour éviter la soumission du formulaire en appuyant sur Enter
    searchInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            form.submit();
        }
    });
});
