import { Controller } from '@hotwired/stimulus';
import { Toast } from "bootstrap";
export default class extends Controller {
    static targets = ['power', 'game', 'dvd']

    connect() {
        document.toast  = new Toast(this.element);
    }

}