import { Input } from '@angular/core';
import { AbstractComponent } from './abstract-component';

export abstract class AbstractComponentChild {

    
    private _ancestral:AbstractComponent;

    aviso:string = "";
    erroAviso:boolean;

    get LOADING () {
        return this._ancestral.LOADING;
    }
    get COMPLETE () {
        return this._ancestral.COMPLETE;
    }
    get ERROR () {
        return this._ancestral.ERROR;
    }
    get editavel() {
        return this._ancestral.editavel;
    }
    set editavel (editavel:boolean) {
        this._ancestral.editavel = editavel;
    }
    get status() {
        return this._ancestral.status;
    }
    set status(status:number) {
        this._ancestral.status = status
    }

    @Input() 
    set ancestral(ancestral:AbstractComponent) {
        this._ancestral = ancestral;
    }
    get ancestral():AbstractComponent {
        return this._ancestral;
    }

    constructor() { }

    protected erroHttp (response):string {
        var mensagem:string;
        if (response.status == 0) {
            mensagem = "Falha na Conexão!";
        }
        else {
            if (response.json) 
                mensagem = response.json().message;
            else 
                mensagem = response
        }
            
        return mensagem;
    }
}