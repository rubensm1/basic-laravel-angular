import { Injectable } from '@angular/core';
import { Http } from '@angular/http';

@Injectable()
export class ConfiguracoesService {

    constructor(private http:Http) { }

    configuracoes = {};

    getConfig() {
        return this.http.get('config/all').toPromise()
            .then(r=>{
                this.configuracoes = r.json();
            })
    }
    setConfig() {
        return this.http.post('config', this.configuracoes).toPromise()
            .then(r=>{
                return r.json();
            })
    }
    
}
