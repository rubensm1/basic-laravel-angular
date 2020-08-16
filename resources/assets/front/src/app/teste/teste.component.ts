import { Component, OnInit } from '@angular/core';
import { AbstractComponent } from '../abstract-component';
import { ArquivosService } from '../arquivos/arquivos.service';

@Component({
    selector: 'app-teste',
    templateUrl: './teste.component.html',
    styleUrls: ['./teste.component.less']
})
export class TesteComponent extends AbstractComponent implements OnInit {

    constructor(private arquivosService: ArquivosService) {
        super()
    }

    get eu() {
        return this;
    }

    carregarLista(): Promise<any> {
        return this.arquivosService.getListFiles();
    }

    resolver() {
        console.log("Resolvida");
    }
    rejeitar() {
        console.log("Rejeitada");
    }

    promessa() {
        var promise = new Promise((resolve, reject) => {
            setTimeout(() => {
                reject();
            }, 1000);
        });
        return promise;
    }

    testePromessa() {
        this.promessa()
            .then(response => {
                this.resolver();
            })
            .catch(response => {
                this.rejeitar();
            })
    }

    ngOnInit() {
        this.editavel = true;

    }

}
