
document.addEventListener('DOMContentLoaded', () => {
    // get current url
    const currentUrl = new URL(window.location.href);

    // get all <a> tags have class "page-link"
    const pageLinks = document.querySelectorAll('.page-link');

    // update href for each <a> tag
    pageLinks.forEach(link => {
        const page = link.getAttribute('data-page');
        const newUrl = new URL(currentUrl);

        // delete `page` param
        newUrl.searchParams.delete('page');

        // add new `page` param
        newUrl.searchParams.set('page', page);

        // update href attribute of <a> tag
        link.href = newUrl.toString();

        // Save the typeName in localStorage to scroll to it after reload
        localStorage.setItem('scrollTo', 'view-sport-field');
    });
})

const handleFilterBySportType = (evt, sportType) => {
    evt.preventDefault;

    // Create a new URLSearchParams object
    const urlParams = new URLSearchParams();
    // Add the new parameter
    urlParams.set('sportType', sportType);

    const newUrl = `${window.location.pathname}?${urlParams.toString()}`;
    window.location.href = newUrl;

    // Save the typeName in localStorage to scroll to it after reload
    localStorage.setItem('scrollTo', 'view-sport-field');
}

// Scroll to the element after the page reloads
window.addEventListener('load', () => {
    const scrollTo = localStorage.getItem('scrollTo');
    if (scrollTo) {
        const element = document.getElementById(scrollTo);
        if (element) {
            element.scrollIntoView({
                behavior: 'smooth'
            });
        }
        // Remove the item from localStorage
        localStorage.removeItem('scrollTo');
    }
});
