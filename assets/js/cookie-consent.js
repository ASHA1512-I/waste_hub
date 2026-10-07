(() => {
    const storageKey = 'wastehub-cookie-choice';
    const scriptUrl = new URL(document.currentScript.src, window.location.href);
    const rootPath = scriptUrl.pathname.replace(/assets\/js\/cookie-consent\.js$/, '');

    try {
        if (localStorage.getItem(storageKey)) return;
    } catch (error) {
        // The notice remains available when browser storage is disabled.
    }

    const banner = document.createElement('section');
    banner.className = 'cookie-banner';
    banner.setAttribute('role', 'region');
    banner.setAttribute('aria-label', 'Cookie preferences');

    const content = document.createElement('div');
    content.className = 'cookie-banner__content';
    const message = document.createElement('p');
    message.append('Waste Hub uses essential session cookies to keep accounts signed in. No analytics or advertising cookies are used. ');
    const privacyLink = document.createElement('a');
    privacyLink.href = `${scriptUrl.origin}${rootPath}privacy.php`;
    privacyLink.textContent = 'Privacy policy';
    message.append(privacyLink);

    const actions = document.createElement('div');
    actions.className = 'cookie-banner__actions';
    const acceptButton = document.createElement('button');
    acceptButton.type = 'button';
    acceptButton.textContent = 'Accept';
    const essentialButton = document.createElement('button');
    essentialButton.type = 'button';
    essentialButton.textContent = 'Essential only';

    const saveChoice = (choice) => {
        try {
            localStorage.setItem(storageKey, choice);
        } catch (error) {
            // Dismiss for this page view if browser storage is disabled.
        }
        banner.remove();
    };

    acceptButton.addEventListener('click', () => saveChoice('all'));
    essentialButton.addEventListener('click', () => saveChoice('essential'));
    actions.append(acceptButton, essentialButton);
    content.append(message, actions);
    banner.append(content);
    document.body.append(banner);
})();