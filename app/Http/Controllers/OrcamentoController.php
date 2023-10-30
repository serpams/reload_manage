<?php

namespace App\Http\Controllers;

use App\Imports\OrcamentoImport;
use App\Models\Orcamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class OrcamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Listing orçamento
        $obras_id = $request->obras_id;
        $orcamentos = Orcamento::where('obras_id', $obras_id)->get();
        return view('orcamento.index', compact('orcamentos', 'obras_id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($obra_id)
    {
        $results = DB::table('orcamentos as oo')
            ->leftJoin('contratos_itens_vinculos as civ', 'civ.orcamento_id', '=', 'oo.id')
            ->leftJoin('contratos_medicoes_itens as cmi', 'cmi.contratos_itens_id', '=', 'civ.contratos_itens_id')
            ->where('oo.obras_id', '=', $obra_id)
            ->groupBy('oo.id', 'oo.item', 'oo.servico')
            ->select('oo.id', 'oo.item', 'oo.servico', DB::raw('SUM(cmi.total) as percentual'),)
            ->get();

        return response()->json($results);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orcamento $orcamento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Orcamento $orcamento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orcamento $orcamento)
    {
        //
    }
    public function importar(Request $request, $id): \Illuminate\Http\RedirectResponse
    {

        Excel::import(new OrcamentoImport($id), $request->file('file'));
        self::processarOrcamento($id);
        return redirect('/')->with('success', 'All good!');
    }
    public static function processarOrcamento($obras_id)
    {

        $orcamentos = Orcamento::where('obras_id', $obras_id)->get();
        $objeto = [];
        foreach ($orcamentos as $orcamento) {
            $new_item = [];
            $all_parents = [];
            $items = Str::of($orcamento->item)->explode('.');
            $count_itens = count($items);
            if ($count_itens == 1) {
                $orcamento->parent_id = null;
            } else {
                for ($i = 0; $i < ($count_itens - 1); $i++) {
                    $new_item[$i] = $items[$i];
                    $all_parents['parents'][$i] = implode('.', $new_item);
                }
                $new_item = implode('.', $new_item);
                $all_parents['childrens'] =  $orcamento->medivel == 1 ? [] : Orcamento::where('obras_id', $obras_id)->where('item', 'like', $new_item . '.%')->pluck('item')->toArray();
                $orcamento->group = $items[0];
                $orcamento->data = $all_parents;
                $parent_id = Orcamento::where('obras_id', $obras_id)->where('item', $new_item)->first();
                if ($parent_id) {
                    $orcamento->parent_id = $parent_id->id;
                }
            }
            /**
             * Verifica se é um grupo ou subgrupo e soma os itens internos dele
             */
            if ($orcamento->medivel != 1) {
                $orcamento->total = DB::SELECT(
                    "SELECT * ,( SELECT  SUM(total) FROM orcamentos  tds2
                    where LEFT(tds2.item,LENGTH(tds.item)) = tds.item  and medivel = 1 and obras_id = " . $obras_id . ") as total_g FROM orcamentos tds where id = " . $orcamento->id
                )[0]->total_g;

                $orcamento->total_indexado = DB::SELECT(
                    "SELECT * ,( SELECT  SUM(total_indexado) FROM orcamentos  tds2
                    where LEFT(tds2.item,LENGTH(tds.item)) = tds.item  and medivel = 1 and obras_id = " . $obras_id . ") as total_indexado FROM orcamentos tds where id = " . $orcamento->id
                )[0]->total_indexado;
            }
            $orcamento->save();
        }
    }
}
