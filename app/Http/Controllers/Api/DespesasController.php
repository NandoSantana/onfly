<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Despesas;
use Illuminate\Http\Request;
use App\Jobs\processaEmail;

class DespesasController extends Controller
{

    public function validar(Request $request){
        
        $message = [];

        if(!is_numeric(auth('api')->user()->id)){
            $message[] = ['message' => 'Usuário não existe ou não está logado.'];   
        }
        if(!isset($request->descricao)){
            $message[] = ['message' => 'campo descricao requerido'];   
        }

        $totalDescricao = strlen(trim($request->descricao));
        if($totalDescricao >= 191 ){
            $message[] = ['message'=> 'total de caracteres da descricao foram excedidos'];
        }
        if(!isset($request->valor)){
            $message[] = ['message'=> 'campo valor requerido'];  
        }
        if(!isset($request->data)){
            $message[] = ['message'=> 'campo data requerido'];  
        }
        if($request->data >= NOW()->format('Y-m-d')){
           $message[] = ['message'=> 'campo data é maior que o previsto'];  
        }

        return $message;
    }

    public function buscaEmail(){
        $collection = Despesas::join('users', 'users.id', '=','despesas.user_id')
            ->where('user_id', auth('api')->user()->id)
            ->get(
                [
                    'despesas.id',
                    'despesas.valor',
                    'despesas.descricao',
                    'users.email'
                ]     
            )->first();

        return $collection['email'];

    }

    public function createDespesas(Request $request){
        
        if(count($this->validar($request)) > 0){
            return $this->validar($request);
        }
        processaEmail::dispatch($this, $this->buscaEmail());

        $create = Despesas::create([
            'descricao' => $request->descricao,
            'valor' => $request->valor,
            'user_id' => auth('api')->user()->id,
            'data' => $request->data
        ]);
        
        return response(['message' => 'Cadastro feito com sucesso.'], 200);
    }
    
    public function despesasDelete(Request $request)
    {
        $update = Despesas::where('id', '=', $request->id)->delete();
    
        return response(['message' => 'Despesa deletada com sucesso.'], 200);
    }

    public function despesasUpdate(Request $request)
    {

        if(count($this->validar($request)) > 0){
            return $this->validar($request);
        }

        $update = Despesas::where('id', '=', $request->id)
            ->update([
                'valor' => $request->valor, 
                'descricao' => $request->descricao,
                'data' => $request->data
            ]);
    
        return response(['message' => 'Despesas editadas com sucesso.'], 200);
    }

    public function index()
    {
        $collection = Despesas::join('users', 'users.id', '=','despesas.user_id')
            ->where('user_id' , '=', auth('api')->user()->id)
            ->get(
                [
                    'despesas.id',
                    'despesas.valor',
                    'despesas.descricao',
                    'despesas.data',
                    'users.email'
                ]     
            );

        return response($collection, 200);
    }
}
