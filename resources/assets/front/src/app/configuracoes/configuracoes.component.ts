import { Component, OnInit } from '@angular/core';
import { AbstractComponent } from '../abstract-component';
import { ConfiguracoesService } from './configuracoes.service';

@Component({
    selector: 'app-configuracoes',
    templateUrl: './configuracoes.component.html',
    styleUrls: ['./configuracoes.component.less']
})
export class ConfiguracoesComponent extends AbstractComponent implements OnInit {

    msgs = [];
    constructor(private configuracoesService:ConfiguracoesService) {
        super();
    }

    get configuracoes () {
        return this.configuracoesService.configuracoes;
    }

    set configuracoes (configuracoes) {
        this.configuracoesService.configuracoes = configuracoes;
    }

    salvar() {
        this.configuracoesService.setConfig()
            .then(r=>{
                this.msgs = [];
                this.msgs.push({ severity: 'success', summary: "Configurações Salvas!", detail: '' });
            })
            .catch(r=>{
                this.msgs = [];
                this.msgs.push({ severity: 'error', summary: this.erroHttp(r), detail: '' });
            })
    }
    
    /*'email_suporte'=> $emailSuporte->valor, 
    'prefix_download' => $prefixDownloads->valor, 
    'separador_email' => $separadorEmail->valor, 
    'tam_max_upload' => $tammaxUpload->valor,
    'timezone' => $timezone->valor*/

    ngOnInit() {
        this.configuracoesService.getConfig()
            .then(r=>{

            })
            .catch(r=>{
                this.msgs = [];
                this.msgs.push({ severity: 'error', summary: this.erroHttp(r), detail: '' });
            })
    }

}
