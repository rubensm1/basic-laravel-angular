import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import { Arquivo } from './arquivo';

@Injectable()
export class ArquivosService {

    ENTRADAS:Array<string> = []

    files:Array<Arquivo> = [];
    filesIndex = {};
    macrosIndex = {};

    arquivo:Arquivo;

    prefixoDownload:string = "";

    constructor(private http:Http) { 
        
    }


    getListFiles() {
        return this.http.get("/files").toPromise()
            .then(response => {
                var files = response.json();
                this.files = [];
                this.filesIndex = {};
                for (var i in files) {
                    var a = new Arquivo(files[i]);
                    this.files.push (a)
                    this.filesIndex[a.name] = i;
                }
                return this.files;
            });
    }

    getListFilesEspecificos(idArquivos:Array<number>) {
        return this.http.put("/files/especificos",{'idArquivos':idArquivos}).toPromise()
            .then(response => {
                var files = response.json();
                this.files = [];
                this.filesIndex = {};
                for (var i in files) {
                    var a = new Arquivo(files[i]);
                    this.files.push (a)
                    this.filesIndex[a.name] = i;
                }
                return this.files;
            });
    }

    preparaUploadFile(data: { files: File }, nome?:string) {
        const formData: FormData = new FormData();
        const file = data.files[0];
        if (file) {
            formData.append('arquivo', file, nome ? nome :file.name);
            return formData;
        }
    }

    preparaUploadFileList() {
        const formData: FormData = new FormData();
    }

    onFileUpload(data: { files: File }, nome?:string): Promise<Arquivo> {
        var formData = this.preparaUploadFile(data, nome);
        //const formData: FormData = new FormData();
        //const file = data.files[0];
        if (formData) {
            //formData.append('arquivo', file, nome ? nome :file.name);
            return this.http.post("/arquivos", formData).toPromise()
                .then(r => {
                    var arquivo = new Arquivo(r.json());
                    return arquivo;
                });
        }
        
    }

    getPrefixoDownload():Promise<string> {
        return this.http.get("/base-downloads").toPromise()
            .then(response=>{
                this.prefixoDownload = response.text();
                return this.prefixoDownload;
            }) 
    }
}
