const TAG = window.__GRAV_PAGE_TAG;

class Skyneta11yPdfRemediationPage extends HTMLElement {

    async connectedCallback() {
        try {
            const baseUrl = window.location.origin;

            // ============================================================
            // 1. Load page HTML
            // ============================================================

            const templateUrl =
                `${baseUrl}/user/plugins/skyneta11ypdfremediation/admin-next/templates/skyneta11ypdfremediation-manager.html`;

            const response = await fetch(templateUrl);

            if (!response.ok) {
                throw new Error(
                    `HTTP ${response.status}: ${response.statusText}`
                );
            }

            this.innerHTML = await response.text();


            // ============================================================
            // 2. Load required JavaScript files
            // ============================================================

            await this.loadScript(
                `${baseUrl}/user/plugins/skyneta11ypdfremediation/assets/js/config.js`
            );

            await this.loadScript(
                `${baseUrl}/user/plugins/skyneta11ypdfremediation/assets/js/account.js`
            );

            await this.loadScript(
                `${baseUrl}/user/plugins/skyneta11ypdfremediation/assets/js/api.js`
            );

            await this.loadScript(
                `${baseUrl}/user/plugins/skyneta11ypdfremediation/assets/js/icons.js`
            );

            await this.loadScript(
                `${baseUrl}/user/plugins/skyneta11ypdfremediation/assets/js/app.js`
            );

            console.log(
                '[PDF] All required JavaScript files are available.'
            );

            // 3. Initialize application
            // ============================================================
            
            if (
                window.PdfRemediation &&
                typeof window.PdfRemediation.init === 'function'
            ) {
            
                console.log(
                    '[PDF] Initializing application for current page...'
                );
            
                await window.PdfRemediation.init(this);
            
            } else {
            
                console.error(
                    '[PDF] PdfRemediation.init() was not found.'
                );
            
            }

        } catch (error) {

            console.error(
                '[PDF] Failed to load page:',
                error
            );

            this.innerHTML = `
                <div style="padding:30px;">
                    <h2>Unable to load SkynetA11y PDF Remediation</h2>
                    <p>${this.escapeHtml(error.message)}</p>
                </div>
            `;
        }
    }


    // ================================================================
    // Load JavaScript
    // ================================================================

    loadScript(src, attributes = {}) {

        return new Promise((resolve, reject) => {

            const existingScript =
                document.querySelector(`script[src="${src}"]`);
            if (existingScript) {
                resolve();
                return;
            }


            const script = document.createElement('script');

            script.src = src;
            script.async = false;

            Object.keys(attributes).forEach((key) => {
                script.setAttribute(key, attributes[key]);
            });


            script.onload = () => {

                console.log(
                    '[PDF] Loaded:',
                    src
                );

                resolve();
            };


            script.onerror = () => {

                console.error(
                    '[PDF] Script failed:',
                    src
                );

                reject(
                    new Error(
                        `Failed to load script: ${src}`
                    )
                );
            };


            document.head.appendChild(script);
        });
    }


    // ================================================================
    // Escape HTML
    // ================================================================

    escapeHtml(str) {

        if (str === null || str === undefined) {
            return '';
        }

        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }
}


if (!customElements.get(TAG)) {
    customElements.define(
        TAG,
        Skyneta11yPdfRemediationPage
    );
}