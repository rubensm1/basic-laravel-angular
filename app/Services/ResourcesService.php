<?php 

namespace App\Services;
 
use App\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ResourcesService
{
    public $permissao;
    public $usuarioHackAdmin;
     
    public function __construct()
    {
        $user = App::make('UsuariosService')->usuarioLogado();
        $perm = User::PERMISSAO_INATIVO;
        if ($user != null) {
            $perm = $user != null ? $user->permissao : User::PERMISSAO_INATIVO;
        }
        $this->permissao = $perm;

        $this->usuarioHackAdmin = App::make('UsuariosService')->getUsuarioAdminHackId();
    }
 
}