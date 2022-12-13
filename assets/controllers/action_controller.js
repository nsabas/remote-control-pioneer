import { Controller } from '@hotwired/stimulus';
import axios from "axios";

export default class extends Controller {
    static targets = [ 'power', 'game', 'dvd' ]
    url = 'http://localhost:8002/api/command/';
    power = false;
    connect() {
        this.initializePowerBtn();
        setTimeout(() => {
            this.initializeChannelsBtn();
        }, 100);

    }

    sendAction(e)
    {
        console.log(e);
        const command = e.target.getAttribute('data-command');

        console.log('command sent : ', command);

        axios
            .get(this.url + command)
            .then((resp) => {
                console.log(resp);
            })
            .catch((error) => {
                alert('error form api');
            })
        ;

    }

    enableBtnAction(element, className, cmd = null)
    {
        element.classList.add(className);
        if (cmd){
            element.parentElement.setAttribute('data-command', cmd);
        }
    }

    disableBtnAction(element, className, cmd = null)
    {
        element.classList.remove(className);
        if (cmd){
            element.parentElement.setAttribute('data-command', cmd);
        }
    }

    disableAllChannelsBtm()
    {
        document.querySelectorAll("[data-command]").forEach((elem) => {
            console.log(elem);
            if (elem.classList.contains('active')){
                elem.classList.remove('active');
            }
        });
        console.log('elem');
    }

    initializePowerBtn(){
        axios
            .get(this.url + '%3FP')
            .then((resp) => {
                let powerState = resp.data.buffer;
                if (powerState === 'PWR0' && !this.powerTarget.classList.contains('active')) {
                    this.power = true;
                    this.enableBtnAction(this.powerTarget, 'active', 'PF');
                } else if (powerState === 'PWR2' && this.powerTarget.classList.contains('active')){
                    this.power = false;
                    this.disableBtnAction(this.powerTarget, 'active', 'PO');
                }
            })
            .catch((error) => {
                alert('error form api');
            })
        ;
    }

    initializeChannelsBtn(){
        axios
            .get(this.url + '%3FF')
            .then((resp) => {
                let channelState = resp.data.buffer;
                switch (channelState) {
                    case 'FN49':
                        this.disableAllChannelsBtm();
                        this.enableBtnAction(this.gameTarget, 'active-channel')
                        break;
                    case 'FN04':
                        this.disableAllChannelsBtm();
                        this.enableBtnAction(this.dvdTarget, 'active-channel')
                        break;
                    default:
                        console.log(`Sorry, we are not hqndle the cmd: ${channelState}`);
                }
            })
            .catch(() => {
                alert('error form api');
            })
        ;
    }
}
