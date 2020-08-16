import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import { Usuario } from './usuario';

@Injectable({
    providedIn: 'root'
})
export class UsuarioService {

    usuarios: Array<Usuario>;
    usuarioLogado: Usuario = Usuario.defaultUsuario();
    usuarioTemp: Usuario = Usuario.defaultUsuario();
    userIdEdit = 0;

    constructor(private http: Http) {
    }

    async listaUsuarios(): Promise<Array<Usuario>> {
        const response = await this.http.get('usuarios/lista')
            .toPromise();
        this.usuarios = Usuario.generateList(response.json());
        return this.usuarios;
    }

    getUsuarioLogado() {
        return this.http.get ("usuario").toPromise()
            .then(response => {
                this.usuarioLogado = Usuario.generateUsuario (response.json())
                return this.usuarioLogado
            })
    }
    getUsuario(uid?):Promise<Usuario> {
        return this.http.get (uid ? "usuario/"+uid : "usuario").toPromise()
            .then(response => {
                this.usuarioTemp = Usuario.generateUsuario (response.json())
                return this.usuarioTemp;
            })
    }

    update(usuario:Usuario, processoId?:number): Promise<Usuario> {
        var formData = usuario.gerarFormData();
        if (processoId)
            formData.append('processo_id', processoId+"");
        return this.http.post("usuarios/" + usuario.id, formData).toPromise()
        //return this.http.put("usuarios/" + usuario.id, usuario.gerarFormData()).toPromise()
            .then(response => {
                var u = Usuario.generateUsuario(response.json());
                for (var i in this.usuarios) {
                    if (this.usuarios[i].id == u.id) {
                        this.usuarios[i] = u;
                    }
                }
                return u;
            })
    }

    /*buscaCEP() {
        return this.http.get ("https://viacep.com.br/ws/"+this.usuarioLogado.cep+"/json/").toPromise()
            .then(response => {
                console.log(response);
            })
    }*/

    alteraPermissao(usuario: Usuario): Promise<Usuario> {
        return this.http.put("usuarios/permissao/" + usuario.id, usuario).toPromise()
            .then(response => {
                var u = new Usuario(response.json());
                for (var i in this.usuarios) {
                    if (this.usuarios[i].id == u.id)
                        this.usuarios[i].permissao = u.permissao;
                }
                return null;
            })
    }

    admCandidato(uid) {
        this.userIdEdit = uid;
        return uid;
    }
    resetAdmCandidato() {
        this.userIdEdit = 0;
        return 0;
    }
}
