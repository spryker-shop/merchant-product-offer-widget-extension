import Component from 'ShopUi/models/component';
import { debug } from 'ShopUi/app/logger';

export default class StyleLoader extends Component {
    protected readyCallback(): void {}

    protected init(): void {
        this.mapEvents();
    }

    protected mapEvents(): void {
        this.mapLoadEvent();
    }

    protected mapLoadEvent(): void {
        window.addEventListener('load', () => this.addCss());
    }

    protected addCss(): void {
        const linkTemplate = `<link rel="stylesheet" href="${this.pathToCSS}">`;
        document.getElementsByTagName('head')[0].insertAdjacentHTML('beforeend', linkTemplate);

        debug(`Style file ${this.pathToCSS} has been loaded`);
    }

    protected get pathToCSS(): string {
        return this.getAttribute('path-to-css');
    }
}
