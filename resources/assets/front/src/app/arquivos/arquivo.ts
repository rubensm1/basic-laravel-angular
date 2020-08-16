export class Arquivo {
    id:number;
    name: string;
    hash: string;
    extension: string;
    path: string;
    created: Date;

    constructor (id:number|object, name?:string, hash?:string, extension?:string, path?:string, created?:Date) {
        if (typeof id == 'number') {
            this.id = id;
            this.name = name;
            this.hash = hash;
            this.extension = extension;
            this.path = path.replace(/\\/g, '/');
            this.created = new Date (created);
        }
        else {
            this.id = id['id']? parseInt(id['id']) : 0;
            this.name = id['name'];
            this.hash = id['hash'];
            this.extension = id['extension'];
            this.path = id['path'] ? id['path'].replace(/\\/g, '/') : null;
            this.created = id['created_at'] ? new Date (id['created_at'] + " GMT-4") : (id['created'] ? new Date (id['created'] + " GMT-4") : null );
        }
    }

    geraLink(prefixo:string = "") {
        return prefixo + this.path + "/" + this.geraNome();
    }
    geraNome() {
        return this.name + "-" + this.hash + "." +  this.extension;
    }
}