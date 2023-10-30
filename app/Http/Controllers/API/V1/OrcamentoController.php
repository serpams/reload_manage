<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Imports\OrcamentoImport;
use App\Models\Orcamento;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrcamentoController extends Controller
{
    public function show($obra_id)
    {

        $orcamentos = Orcamento::where('obra_id', $obra_id)->get();

        return response()->json($orcamentos);
    }


    public function importar(Request $request, $id): \Illuminate\Http\RedirectResponse
    {

        Excel::import(new OrcamentoImport($id), $request->file('file'));
        self::processarOrcamento($id);
        return redirect('/')->with('success', 'All good!');
    }
    public static function processarOrcamento($obra_id)
    {

        $orcamentos = Orcamento::where('obra_id', $obra_id)->get();
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
                $all_parents['childrens'] =  $orcamento->medivel == 1 ? [] : Orcamento::where('obra_id', $obra_id)->where('item', 'like', $new_item . '.%')->pluck('item')->toArray();
                $orcamento->group = $items[0];
                $orcamento->data = $all_parents;
                $parent_id = Orcamento::where('obra_id', $obra_id)->where('item', $new_item)->first();
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
                    where LEFT(tds2.item,LENGTH(tds.item)) = tds.item  and medivel = 1 and obra_id = " . $obra_id . ") as total_g FROM orcamentos tds where id = " . $orcamento->id
                )[0]->total_g;

                $orcamento->total_indexado = DB::SELECT(
                    "SELECT * ,( SELECT  SUM(total_indexado) FROM orcamentos  tds2
                    where LEFT(tds2.item,LENGTH(tds.item)) = tds.item  and medivel = 1 and obra_id = " . $obra_id . ") as total_indexado FROM orcamentos tds where id = " . $orcamento->id
                )[0]->total_indexado;
            }
            $orcamento->save();
        }
    }
}