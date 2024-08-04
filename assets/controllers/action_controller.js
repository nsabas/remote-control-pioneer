import { Controller } from '@hotwired/stimulus';
import axios from "axios";

export default class extends Controller {
    static targets = [ 'power', 'game', 'tv', 'volume' ]

    url = process.env.BASE_URL + '/api/command/';
    power = false;
    connect() {
        this.initializePowerBtn();
        setTimeout(() => {
            this.initializeChannelsBtn();
        }, 100);

        document.querySelectorAll('data-button').forEach((elem) => {
            elem.addEventListener('click', function (e) {
                e.target.disabled = true;
                setTimeout(() => {
                    e.target.disabled = false;
                }, 100);
            });
        });

    }

    sendAction(e)
    {
        const command = e.target.getAttribute('data-command');

        axios
            .get(this.url + command)
            .then((resp) => {
                console.log(resp);
                if (resp.data.infos){
                    switch (resp.data.infos.type) {
                        case 'VOL':
                            this.syncVolume(resp.data.infos);
                    }
                }
            })
            .catch((error) => {
                document.toast.show();
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
            if (elem.classList.contains('active')){
                elem.classList.remove('active');
            }
        });
    }

    initializePowerBtn(){
        axios
            .get(this.url + '%3FP')
            .then((resp) => {
                let powerState = resp.data.buffer;
                if (powerState === 'PWR0' && !this.powerTarget.classList.contains('active')) {
                    this.power = true;
                    this.enableBtnAction(this.powerTarget, 'active', 'PF');
                } else if (powerState === 'PWR2' && this.powerTarget.classList.contains('active')) {
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
                    case 'FN05':
                        this.disableAllChannelsBtm();
                        this.enableBtnAction(this.tvTarget, 'active-channel')
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

    syncVolume(info) {
        this.volumeTarget.innerHTML = info.volume;
    }
}
