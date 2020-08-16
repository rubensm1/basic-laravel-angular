import { Component, OnInit } from '@angular/core';
import { AbstractComponentChild } from '../abstract-component-child';
import { Arquivo } from './arquivo';
import { ArquivosService } from './arquivos.service';

@Component({
  selector: 'app-arquivos',
  templateUrl: './arquivos.component.html',
  styleUrls: ['./arquivos.component.less']
})
export class ArquivosComponent extends AbstractComponentChild implements OnInit {

    val2: string = 'Option 2';
    //arquivoSelecionado:string = "";

    constructor(private arquivosService: ArquivosService) {
        super();
    }

    get editavelChild () {
        return this.editavel;
    }


    get files() {
        return this.arquivosService.files;
    }
    set files(files) {
        this.arquivosService.files = files;
    }

    get arquivoSelecionadoRadio () {
        return this.arquivosService.arquivo ? this.arquivosService.arquivo.name : null;
    }
    /*set arquivoSelecionadoRadio (arquivo) {
        this.arquivosService.macroSelecionada.arquivo.name = arquivo
    }*/


    onFileUpload(event) {
        this.arquivosService.onFileUpload(event)
            .then(arquivo => {
                //if (this.ancestral instanceof MacroComponent) {
                    return (this.ancestral).carregarLista()
                        .then(r => {
                            var novoArquivo = this.arquivosService.files[this.arquivosService.filesIndex[arquivo.name]];
                            return arquivo.name;

                        })
                        .catch(r => {
                            this.erroHttp(r);
                        })
                //}
            })
            .catch(r => {
                console.log(r)
                this.erroHttp(r);
            })
    }

    ngOnInit() {
        //this.arquivoSelecionado = this.arquivosService.macroSelecionada.arquivo ? this.arquivosService.macroSelecionada.arquivo.name : null;
        this.arquivosService.getPrefixoDownload()
            .then(prefixo => {
                this.arquivosService.getListFiles()
                    .then(response => {
                        this.status = this.COMPLETE
                    })
                    .catch(r => {
                        this.erroHttp(r);
                    })
            });
        
    }

}
