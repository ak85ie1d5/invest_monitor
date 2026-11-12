import { Controller } from '@hotwired/stimulus';

/*
 * Saves an article's visibility when its switch is toggled.
 *
 * Usage (on any element wrapping the checkbox; the "change" event bubbles up):
 *   data-controller="visibility"
 *   data-visibility-url-value="{{ path('app_article_visibility', {id: article.id}) }}"
 *   data-visibility-token-value="{{ csrf_token('article-visibility') }}"
 *   data-action="change->visibility#toggle"
 */
export default class extends Controller {
    static values = { url: String, token: String };

    async toggle(event) {
        const input = event.target;
        input.disabled = true; // prevents double clicks while saving

        try {
            const response = await fetch(this.urlValue, {
                method: 'POST',
                headers: { Accept: 'application/json' },
                body: new URLSearchParams({
                    isVisible: input.checked ? '1' : '0',
                    _token: this.tokenValue,
                }),
            });

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }
        } catch (error) {
            input.checked = !input.checked; // the save failed: put the switch back
            console.error('Could not update the article visibility:', error);
        } finally {
            input.disabled = false;
        }
    }
}
