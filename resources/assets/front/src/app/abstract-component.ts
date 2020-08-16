import { environment } from './../environments/environment'; 
declare var jQuery:any
export abstract class AbstractComponent {

    editavel: boolean = false;

    readonly LOADING = 0;
    readonly COMPLETE = 1;
    readonly ERROR = 2;
    status: number = this.LOADING;

    readonly MODO_CREATE = "CREATE";
    readonly MODO_UPDATE = "UPDATE";
    readonly MODO_DELETE = "DELETE";

    aviso:string = "";
    erroAviso:boolean;

    protected paginaCarregada = false;

    public pt = {
        firstDayOfWeek: 0,
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
        dayNamesMin: ['Do', 'Sg', 'Te', 'Qu', 'Qi', 'Sx', 'Sa'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho',
            'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        today: 'Hoje',
        clear: 'Limpar'
    };

    constructor() { }

    protected erroHttp (response):string {
        var mensagem:string;
        if (response.status == 0) {
            mensagem = "Falha na Conexão!";
        }
        else {
            try {
                mensagem = response.json().message;
            }
            catch (e) {
                if (response.message)
                    mensagem = response.message;
                else 
                    mensagem = response;
            }
            
        }
        return mensagem;
    }

    protected callJanelaDebug(classe, id, modo) {
        var link = "/logs/debug/"+classe+"/"+id+"/"+modo;
        jQuery('#dialog-debug-iframe').attr('src',link);
        jQuery('#dialogDebug').modal('show');
    }

    public carregarLista () :Promise<any> {
        return new Promise(null);
    }
}