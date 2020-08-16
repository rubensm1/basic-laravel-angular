import { Component, OnInit } from '@angular/core';
import { UsuarioService } from './usuario.service';
import { Usuario } from './usuario';
import { AbstractComponent } from '../abstract-component';

@Component({
    selector: 'app-usuarios',
    templateUrl: './usuarios.component.html',
    styleUrls: ['./usuarios.component.less']
})
export class UsuariosComponent extends AbstractComponent implements OnInit {
    
    criteria:string="";

    usuarioTemp:Usuario;

    constructor(private usuarioService: UsuarioService) {
        super();
    }

    get usuarios(): Array<Usuario> {
        return this.usuarioService.usuarios;
    }

    set usuarios(usuarios: Array<Usuario>) {
        this.usuarioService.usuarios = usuarios;
    }

    altararPermissao() {
        this.usuarioService.alteraPermissao(this.usuarioTemp)
            .then(response => {
                if (response) 
                    alert(this.erroHttp(response));
                else {
                    this.resetEdit();
                }
            })
            .catch(response => {
                alert(this.erroHttp(response));
            });
    }

    habilitarEdicao(usuario:Usuario) {
        this.usuarioTemp = usuario;
        setTimeout ( function () {
            document.getElementById('selectPermissao').focus();
        },300);
    }

    resetEdit() {
        this.usuarioTemp = new Usuario(0,"","","");
    }
    
    submeterEditar(uid) {
        document.forms["form-editar-" + uid].submit();
        //$('meta[name="csrf-token"]').attr('content')
    }

    submeterLogarComo(uid) {
        document.forms["form-logar-como-" + uid].submit();
        //$('meta[name="csrf-token"]').attr('content')
    }

    admCandidato(uid) {
        this.usuarioService.admCandidato(uid);
    }

    ngOnInit() {
        this.resetEdit();

        this.usuarioService.listaUsuarios()
            .then(response => {
                this.status = this.COMPLETE;
            })
            .catch(response => {
                this.status = this.ERROR;
                console.log(response)
            })
    }

}
