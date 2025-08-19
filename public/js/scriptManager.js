window.loadAndCacheScripts = async (scripts, baseUrl) => {
    const injectScript = (text) => {
        const script = document.createElement('script');
        script.defer = true;
        script.textContent = text;
        document.head.appendChild(script);
    };

    for (const [path, hash] of Object.entries(scripts)) {
        const versionedPath = `${path}?v=${hash}`;
        const storageKey = `script-cache:${versionedPath}`;
        const cachedScript = localStorage.getItem(storageKey);

        if (cachedScript) {
            injectScript(cachedScript);
        } else {
            try {
                const response = await fetch(`${baseUrl}${versionedPath}`);
                if (response.ok) {
                    const scriptText = await response.text();
                    try {
                        localStorage.setItem(storageKey, scriptText);
                    } catch (e) {
                        console.warn('Could not cache script, storage may be full.', e);
                    }
                    injectScript(scriptText);
                }
            } catch (error) {
                console.error(`Failed loading ${path}:`, error);
            }
        }
    }
};

window.clearAppCacheAndReload = async () => {
    const csrfTokenEl = document.querySelector('meta[name="csrf-token"]');
    if (csrfTokenEl) {
        try {
            await fetch('/clear-setting', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfTokenEl.content
                }
            });
        } catch (error) {
            console.error('Failed to clear server-side settings:', error);
        }
    }

    Object.keys(localStorage)
        .filter(key => key.startsWith('script-cache:'))
        .forEach(key => localStorage.removeItem(key));

    localStorage.removeItem('localStorage-sortables');
    location.reload();
};
