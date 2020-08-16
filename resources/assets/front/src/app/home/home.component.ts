import { Component, OnInit } from '@angular/core';
import { Usuario } from '../usuarios/usuario';
import { UsuarioService } from '../usuarios/usuario.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.less']
})
export class HomeComponent implements OnInit {

    constructor(private usuarioService: UsuarioService){ }

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
            
    }
}
