import { Injectable } from '@angular/core';
import { Usuario } from '../usuarios/usuario';
import { Http } from '@angular/http';

@Injectable()
export class CandidatosService {

    candidatos:Array<Usuario> = [];

    constructor(private http:Http) { }

    listar() {
        return this.http.get("/usuarios/lista").toPromise()
            .then (response => {
                this.candidatos = Usuario.generateList(response.json());
            })
    }
}
