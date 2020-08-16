import { Component } from '@angular/core';
import { UsuarioService } from './usuarios/usuario.service';
import { Usuario } from './usuarios/usuario';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.less']
})
export class AppComponent {
    title = 'front';
    constructor(private usuarioService: UsuarioService){ }
    hackAdmin:any = false;

    get usuario(): Usuario {
        return this.usuarioService.usuarioTemp
    }
    set usuario(usuario: Usuario) {
        this.usuarioService.usuarioTemp = usuario;
    }

    get usuarioLogado():Usuario {
        return this.usuarioService.usuarioLogado;
    }

    resetUserId() {
        this.usuarioService.resetAdmCandidato();
    }
    
    ngOnInit() {

        
        var iHidden = (<HTMLInputElement>document.getElementById('uid'))
        var hackHidden = (<HTMLInputElement>document.getElementById('usuario-hack-admin'))
        this.hackAdmin = hackHidden ? hackHidden.value : false;
        if (iHidden) {
            this.usuarioService.getUsuarioLogado()
                .then(response => {
                    this.usuarioService.getUsuario(iHidden ? iHidden.value : null)
                        .then(response => {
                        })
                        .catch(response => {
                            console.log(response);
                        });
                })
                .catch(response => {
                    console.log(response);
                });
        }
        else {
            this.usuarioService.getUsuarioLogado()
                .then(response => {
                    this.usuario = response;
                })
                .catch(response => {
                    console.log(response);
                });
        }
            
    }

}

