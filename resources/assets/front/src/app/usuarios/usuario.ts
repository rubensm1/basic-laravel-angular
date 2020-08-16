import { Arquivo } from '../arquivos/arquivo';

export class Usuario {

    static readonly PERMISSAO_ADMINISTRADOR = 'ADMINISTRADOR';
    static readonly PERMISSAO_USUARIO = 'USUARIO';
    static readonly PERMISSAO_INATIVO = 'INATIVO';
    
	id:number;
    name:string;
    login:string;
    email:string;
    permissao:string;

    fileTemplogin = null;
    fileTempIdentidade = null;
    fileTempEndereco = null;

    constructor (id:number|object,
            name?:string,
            login?:string,
            email?:string,
            permissao?:string) 
    {
        if (typeof id == 'number') {
            this.id = id;
            this.name = name;
            this.login = login;
            this.email = email;
            this.permissao = permissao;
        }
        else {
            this.id = parseInt(id['id']);
            this.name = id['name'];
            this.login = id['login'];
            this.email = id['email'];
            this.permissao = id['permissao'];

        }
    }

    public gerarFormData(){
        const formData: FormData = new FormData();
        
        formData.append('id', this.id + "");
        formData.append('name',this.name?this.name:"");
        formData.append('login',this.login?this.login:"");
        formData.append('email',this.email?this.email:"");
        formData.append('permissao',this.permissao?this.permissao:"");

        return formData;
    }

    public static generateUsuario(usuarioAny) : Usuario {
        var usuario = new Usuario(usuarioAny);
        return usuario;
    }

    public static generateList (list:Array<any>):Array<Usuario> {
        var usuarioList: Array<Usuario> = [];
        list.forEach(usuarioAny => {
            var usuario = Usuario.generateUsuario(usuarioAny);
            usuarioList.push(usuario);
        });
        return usuarioList;
    };

    public isAdministrador() {
        return this.permissao == Usuario.PERMISSAO_ADMINISTRADOR;
    }

    public static defaultUsuario() : Usuario {
        return new Usuario(0,"","","","");
    }

    public clone ():Usuario {
        return new Usuario (this);
    }
}