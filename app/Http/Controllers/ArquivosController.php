<?php

namespace App\Http\Controllers;

use App\Arquivo;
use App\Configuracoes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArquivosController extends Controller
{

    const RAIZ_STORAGE = 'public';

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("layouts.app-angular");
    }

    public function all () {
        return Arquivo::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    private function validarArquivos($request) {
        $validator = Validator::make($request->all(), [
            'file' => 'max:5120', //5MB 
            'image_file_input_name' => 'required|mimes:jpeg,bmp,png|size:5000',
        ]);
    }

    public function listFiles() {
        $arrayRemessa = [];
        $files = File::files('storage/');
        foreach($files as $path)
        {
            $arrayRemessa[] = (object) array ("path" => $path->getPathName(), "name" => $path->getFileName(), "created" =>  date ("Y-m-d", $path->getCTime()) );
        }
        return $arrayRemessa;
    }

    public function download() {
        $arrayRemessa = [];
        $files = File::files('storage/processados/');
        foreach($files as $path)
        {
            $arrayRemessa[] = $path->getPathName();
        }
        return view('download',['arquivos' =>  $files]);
    }

    public function baixar($arquivo) {
        return Response::download("storage/processados/".$arquivo->nome);
        //return $this->download();
    }

    public function validaArquivo() {
        ['image' => 'required|mimes:jpeg,bmp,png,pdf|size:10000'];
    }

    public function salvarArquivo(Request $request, $fileParam = NULL, $login = NULL, $processoId = NULL) {
        // Define o valor default para a variável que contém o nome do arquivo 
        $nameFile = null;
    
        // Verifica se informou o arquivo e se é válido
        if ( !($request->file('arquivo') != null && $request->file('arquivo')->isValid()) && !$fileParam ) {
            abort(400, "Nenhum Arquivo Informado!");
            return;
        }
        if ($fileParam && !$fileParam->isValid())
            return null;
        if (!$fileParam)
            $fileParam = $request->arquivo;

         
        // Define um aleatório para o arquivo baseado no timestamps atual
        $name = pathinfo($fileParam->getClientOriginalName(), PATHINFO_FILENAME);
        $postname = substr_replace (substr(uniqid('', true),7), floor(rand()*10), 7);

        // Recupera a extensão do arquivo
        $extension = $fileParam->getClientOriginalExtension();
        
        if ($extension == "php")
            abort(400, "Vá tentar hackear a mãe!");
        /*return redirect()
            ->back()
            ->with('error', 'Vá tentar hackear a mãe!')
            ->withInput();*/

        // Define finalmente o nome
        $nameFile = $name."-".$postname.".".$extension;

        $pasta = '';
        //$processoId = App::make('ProcessosService')->getProcessoId($request);
        if ($login && !$processoId) {
            $pasta = '/'.$login;
        }
        else if ($login && $processoId) {
            $pasta = '/'.$login.'/'.$processoId;
        }
        elseif ($processoId) {
            $pasta = '/'.$processoId;
        }
        else {
            abort(400, "Local Não Identificado!");
        }
        // Faz o upload:
        $upload = $fileParam->storeAs(ArquivosController::RAIZ_STORAGE.$pasta, $nameFile);

        // Verifica se NÃO deu certo o upload (Redireciona de volta)
        if ( !$upload )
            return false;
            //abort(400, "Falha no Upload!");
            /*return redirect()
                        ->back()
                        ->with('error', 'Falha ao fazer upload')
                        ->withInput();*/


        $arquivo = new Arquivo();
        $arquivo->name = $name;
        $arquivo->hash = $postname;
        $arquivo->extension = $extension;
        $arquivo->path = $pasta;
        $arquivo->ativo = false;
        $arquivo->save();




        return $arquivo;
        //$this->index();
    
    }


    public function copiarArquivo($arquivo,$login,$processoId) {

        $pasta = '/'.$login.'/'.$processoId;
        $nameFile = $arquivo->name."-".$arquivo->hash.".".$arquivo->extension;

        $arquivoPath = $arquivo->path.'/'.$nameFile;
        
        
        if (Storage::disk('local')->exists(ArquivosController::RAIZ_STORAGE.$pasta.'/'.$nameFile))
            return $arquivo;
        if (!Storage::copy(ArquivosController::RAIZ_STORAGE.$arquivoPath, ArquivosController::RAIZ_STORAGE.$pasta.'/'.$nameFile)) {
            abort(400, "falha ao copiar $arquivo->name...");
        }

        $cp = new Arquivo();
        $cp->name = $arquivo->name;
        $cp->hash = $arquivo->hash;
        $cp->extension = $arquivo->extension;
        $cp->path = $pasta;
        $cp->ativo = true;
        $cp->save();

        if (!$cp)
            abort(400,"Erro ao realizar a cópia do arquivo");
        return $cp;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->salvarArquivo($request);
    }

    public function getPrefixoDownload() {
        return Configuracoes::where('nome', Configuracoes::CONFIGURACAO_PREFIXO_DOWNLOADS)->first()['valor'];
    }

    public function getFilesEspecificos(Request $request) {
        $idArquivosArray = $request->input("idArquivos");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove o arquivo do físico e do banco de dados
     */
    private function removeArquivo($id) {
        $a = Arquivo::find($id);
        if (!$a)
            abort(400, "Arquivo não Encontrado! $id");
        Storage::delete(ArquivosController::RAIZ_STORAGE.'/'.$a->path."/".$a->name."-".$a->hash.".".$a->extension);
        return $a->delete(); 
    }

    /**
     * Apenas remove o vínculo do arquivo mas não o exclui de fato, mantendo o arquivo físico e o registro
     *  no Bando de dados inativado
     */
    private function desativaArquivo($id) {
        $a = Arquivo::find($id);
        if (!$a)
            abort(400, "Arquivo não Encontrado! $id");
        $a->ativo = false;
        $a->save();
        return $a->delete(); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->removeArquivo($id);
    }

    public function destroyList($ids) {
        $success = true;
        foreach ($ids as $id){
            if (!$id)
                continue;
            if (!$this->destroy($id))
                $success = false;
        }
        return $success;
    }
}
