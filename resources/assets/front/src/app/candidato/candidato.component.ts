import { Component, OnInit, ViewChild, Input } from '@angular/core';
import { UsuarioService } from '../usuarios/usuario.service';
import { Usuario } from '../usuarios/usuario';
import { AbstractComponent } from '../abstract-component';
import { NgxViacepService } from '@brunoc/ngx-viacep';
import { ArquivosService } from '../arquivos/arquivos.service';
import { ActivatedRoute, Router } from '@angular/router';
declare var jQuery:any;


@Component({
    selector: 'app-candidato',
    templateUrl: './candidato.component.html',
    styleUrls: ['./candidato.component.less'],
})
export class CandidatoComponent extends AbstractComponent implements OnInit {

    msgs = [];

    tabPanelSelecionado = 0;

    /*get check() {
        return this.processosService.processo.check;
    }*/

    

    constructor(private usuarioService: UsuarioService, private arquivosService:ArquivosService,
         private route: ActivatedRoute, private router:Router) {
        super();
        
    }
    
    get usuario(): Usuario {
        return this.usuarioService.usuarioTemp
    }
    set usuario(usuario: Usuario) {
        this.usuarioService.usuarioTemp = usuario;
    }

    get usuarioLogado():Usuario {
        return this.usuarioService.usuarioLogado;
    }

    get prefixoDownload():string {
        return this.arquivosService.prefixoDownload;
    }

    salvar() {
        if (this.validarCandidato()) {
            this.usuarioService.update(this.usuario)
                .then(response => {
                    //this.messageService.add({key: 'myKey1', severity:'success', summary:'Informações Salvas com Sucesso!', detail:''});
                    this.msgs = [];
                    this.msgs.push({ severity: 'success', summary: 'Informações Salvas com Sucesso!', detail: '' });
                    this.usuario = response;             
                })
                .catch(response => {
                    this.msgs = [];
                    this.msgs.push({ severity: 'error', summary: this.erroHttp(response), detail: '' });
                    //alert(this.erroHttp(response));
                });
        }
    }

    redirectParaInscricao() {
        var _this = this;
        setTimeout(function () {
            //_this.inscricaoService.dadosPessoaisVerificados = true;
            //_this.router.navigate(['/inscricao/'+_this.processoId])
        }, 1000);
    }
    validarCandidato() {
        var erros = "";
        if (!this.usuario.name)
            erros += "<br />Nome";
        if (!this.usuario.login)
            erros += "<br />Login";
        if (!this.usuario.email)
            erros += "<br />Email";
        
        if (erros.length > 0) {
            //mensagem aq
            this.msgs = [];
            this.msgs.push({ severity: 'error', summary: "Alguns campos devem ser Preenchidos:", detail: erros });
            return false;
        }
        return true;
    }


    ngOnInit() {

        this.editavel = false;
        this.usuario = Usuario.defaultUsuario();
        var iHidden = (<HTMLInputElement>document.getElementById('uid'));

        if (iHidden || this.usuarioService.userIdEdit) {
            this.usuarioService.getUsuarioLogado()
                .then(response => {
                    var uid:any = null;
                    if (iHidden) 
                        uid = iHidden.value;
                    else if (this.usuarioService.userIdEdit)
                        uid = this.usuarioService.userIdEdit;
                    this.usuarioService.getUsuario(uid)
                        .then(response => {
                            this.editavel = true;
                        })
                        .catch(response => {
                            this.msgs = [];
                            this.msgs.push({ severity: 'error', summary: response, detail: '' });
                        });
                })
                .catch(response => {
                    this.msgs = [];
                    this.msgs.push({ severity: 'error', summary: response, detail: '' });
                });
        }
        else {
            this.usuarioService.getUsuarioLogado()
                .then(response => {
                    this.usuario = response;
                    this.editavel = true;
                })
                .catch(response => {
                    this.msgs = [];
                    this.msgs.push({ severity: 'error', summary: response, detail: '' });
                });
        }
            
    }

}
