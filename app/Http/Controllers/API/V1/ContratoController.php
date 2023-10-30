<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ContratoRequest;
use App\Http\Requests\API\ItemRequest;
use App\Models\Contratos;
use App\Models\ContratosItens;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    public function create(ContratoRequest $request)
    {
        if ($request->validate()) {
            $contrato = Contratos::create($request->all());
            return response()->json(['message' => 'Contrato criado com sucesso!'], 201);
        } else {
            return response()->json(['message' => 'Erro ao criar contrato!'], 400);
        }
    }
    public function update(Request $request)
    {
    }
    public function delete(Request $request)
    {
    }
    public function get(Request $request)
    {
    }
    public function show(Request $request, $id_contrato)
    {
        $contrato = Contratos::where('id', $id_contrato)->with('itens,itens.vinculos')->get();
        return response()->json($contrato);
    }
    public function list(Request $request, $id_obra)
    {
        $contratos = Contratos::where('obra_id', $id_obra)->get();
        return response()->json($contratos);
    }
    public function list_itens(Request $request, $id_contrato)
    {
        $itens = Contratos::find($id_contrato)->with('itens,itens.vinculos')->get();
        return response()->json($itens);
    }
    public function create_itens(ItemRequest $request)

    {
        $item = Contratos::find($request->contrato_id)->itens()->create($request->all());
        return response()->json($item);
    }
    public function item_vincula_orcamento(Request $request)
    {
        $item  = ContratosItens::find($request->contrato_itens_id)->vinculos()->create($request->all());
        return response()->json($item);
    }
}
